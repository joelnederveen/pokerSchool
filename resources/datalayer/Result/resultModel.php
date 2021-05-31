<?php

function endsWith($haystack, $needle) {
	$length = strlen($needle);
	if (!$length) {
		return true;
	}
	return substr($haystack, -$length) === $needle;
}

class Card {
	public $number;
	public $suit;

	public static function fromName($name) {
		$card = new Card();

		$suits = ['Clubs', 'Hearts', 'Spades', 'Diamonds'];
		foreach ($suits as $suit) {
			if (endsWith($name, $suit)) {
				$card->suit = $suit;
			}
		}

		$number = substr($name, 0, strlen($name) - strlen($card->suit));
		$index = ['J' => 11, 'Q' => 12, 'K' => 13, 'A' => 14];
		if (isset($index[$number])) {
			$card->number = $index[$number];
		} else {
			$card->number = intval($number);
		}

		return $card;
	}

	public function getNumber() {
		if ($this->number > 10) {
			return [11 => 'J', 12 => 'Q', 13 => 'K', 14 => 'A'][$this->number];
		} else {
			return $this->number;
		}
	}

	public function getImage() {
		return "/Cards/{$this->getNumber()}{$this->suit}.jpg";
	}

	/**
	 * @param Card $a
	 * @param Card $b
	 * @return int
	 */
	public static function sort($a, $b) {
		return $b->number - $a->number;
	}
}

class Player {
	public $number;
	/** @var Card[] */
	public $cards = [];
	public $bet;

	public static function fromArray($array) {
		$player = new Player();

		$player->number = intval($array['player']);
		$player->cards[] = Card::fromName($array['card1']);
		$player->cards[] = Card::fromName($array['card2']);

		$player->bet=$array['bet'];

		return $player;
	}

	/**
	 * @param Table $table
	 * @return Hand
	 */
	public function getHand($table) {
		return new Hand($table, $this);
	}
}

class Hand {
	/** @var Card[] */
	public $cards = [];
	public $result;
	public $score;
	public $highCard = 0;

	public function __construct($table, $player) {
		$cards = array_merge($player->cards, $table->cards);
		usort($cards, function($a, $b) {
			return Card::sort($a, $b);
		});
		$this->cards = $cards;
		$this->determineMainResult();
		$this->highCard();
	}

	public static function getFlush($cards) {
		$suits = ['Clubs' => [], 'Hearts' => [], 'Spades' => [], 'Diamonds' => []];
		foreach ($cards as $card) {
			$suits[$card->suit][] = $card;
		}

		foreach ($suits as $suit => $suitCards) {
			if (count($suitCards) >= 5) {
				return $suitCards;
			}
		}

		return false;
	}

	/**
	 * @param Card[] $cards
	 * @return bool|Card[]
	 */
	public static function getStraight($cards) {
		$start = 0;
		$length = 1;
		if ($cards[0]->number === 14) {
			$card = new Card();
			$card->number = 1;
			$card->suit = $cards[0]->suit;
			$cards[] = $card;
		}
		for ($i = 1; $i < count($cards); $i++) {
			if ($cards[$i - 1]->number === $cards[$i]->number + 1) {
				$length++;
			} else {
				if ($length >= 5) {
					break;
				}
				$start = $i;
				$length = 1;
			}
		}

		if ($length >= 5) {
			return array_slice($cards, $start, $length);
		} else {
			return false;
		}
	}

	/**
	 * @param Card[] $cards
	 * @return array
	 */
	public static function getNumbers($cards) {
		$numbers = [];
		foreach ($cards as $card) {
			if (isset($numbers[$card->number])) {
				$numbers[$card->number]++;
			} else {
				$numbers[$card->number] = 1;
			}
		}

		return $numbers;
	}

	public static function getOfKind($n, $numbers) {
		foreach ($numbers as $card => $count) {
			if ($count >= $n) {
				return $card;
			}
		}

		return false;
	}

	public static function getTwoPair($numbers) {
		$pairs = [];
		foreach ($numbers as $card => $count) {
			if ($count >= 2) {
				$pairs[] = $card;
			}
		}

		if (count($pairs) >= 2) {
			return array_slice($pairs, 0, 2);
		}
		return false;
	}

	public static function getFullHouse($numbers) {
		$parts = [];
		foreach ($numbers as $card => $count) {
			if ($count >= 3 || (!empty($parts) && $count >= 2)) {
				$parts[] = $card;
			}
		}

		if (count($parts) >= 2) {
			return array_slice($parts, 0, 2);
		}
		return false;
	}

	public function determineMainResult() {
		$flush = self::getFlush($this->cards);

		if ($flush !== false) {
			$straightFlush = self::getStraight($flush);
			if ($straightFlush !== false) {
				if ($straightFlush[0]->number === 14) {
					// Royal flush
					$this->result = 'Royal flush';
					$this->score = 10;
					return;
				}

				// Straight flush
				$this->result = 'Straight flush';
				$this->score = 9 + $straightFlush[0]->number / 100;
				return;
			}
		}

		$numbers = self::getNumbers($this->cards);
		// Four of a kind
		$fourOfKind = self::getOfKind(4, $numbers);
		if ($fourOfKind !== false) {
			$this->result = 'Four of a kind';
			$this->score = 8 + $fourOfKind / 100;
			return;
		}

		// Full House
		$fullHouse = self::getFullHouse($numbers);
		if ($fullHouse !== false) {
			$this->result = 'Full house';
			$this->score = 7 + $fullHouse[0] / 100 + $fullHouse[1] / 10000;
			return;
		}

		// Flush
		if ($flush !== false) {
			$this->result = 'Flush';
			$this->score = 6;
			// High card
			return;
		}

		// Straight
		$straight = self::getStraight($this->cards);
		if ($straight !== false) {
			$this->result = 'Straight';
			$this->score = 5 + $straight[0]->number / 100;
			return;
		}

		// Three of a Kind
		$threeOfKind = self::getOfKind(3, $numbers);
		if ($threeOfKind !== false) {
			$this->result = 'Three of a kind';
			$this->score = 4;
			return;
		}

		// Two pair
		$twoPair = self::getTwoPair($numbers);
		if ($twoPair !== false) {
			$this->result = 'Two pair';
			$this->score = 3 + $twoPair[0] / 100 + $twoPair[1] / 10000;
			return;
		}

		// Pair
		$twoOfKind = self::getOfKind(2, $numbers);
		if ($twoOfKind !== false) {
			$this->result = 'Pair';
			$this->score = 2 + $twoOfKind / 100;
			return;
		}

		// High card
		$this->result = 'High card';
		$this->score = 1;
	}

	public function highCard() {
		$this->highCard += $this->cards[0]->number / 100;
		$this->highCard += $this->cards[1]->number / 10000;
		$this->highCard += $this->cards[2]->number / 1000000;
		$this->highCard += $this->cards[3]->number / 100000000;
		$this->highCard += $this->cards[4]->number / 10000000000;
	}
}

class Table {
	/** @var Card[] */
	public $cards = [];

	public static function fromArray($array) {
		$table = new Table();

		$table->cards[] = Card::fromName($array['card1']);
		$table->cards[] = Card::fromName($array['card2']);
		$table->cards[] = Card::fromName($array['card3']);
		$table->cards[] = Card::fromName($array['card4']);
		$table->cards[] = Card::fromName($array['card5']);

		return $table;
	}
}
