<a class="item" href="character.php?id=<?= $data["id"] ?>">
        <div class="left">
            <img class="avatar" src="resources/images/<?= $data["avatar"] ?>">
        </div>
        <div class="right">
            <h2><?= $data["name"] ?></h2>
            <div class="stats">
                <ul class="fa-ul">
                    <li><span class="fa-li"><i class="fas fa-heart"></i></span> <?= $data["health"] ?></li>
                    <li><span class="fa-li"><i class="fas fa-fist-raised"></i></span> <?= $data["attack"] ?></li>
                    <li><span class="fa-li"><i class="fas fa-shield-alt"></i></span> <?= $data["defense"] ?></li>
                </ul>
            </div>
        </div>
        <div class="detailButton"><i class="fas fa-search"></i> bekijk</div>
    </a>