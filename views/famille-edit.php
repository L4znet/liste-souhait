<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Modification de la famille </h1>
    <form action="<?= BASE_URI ?>/famille/<?= $famille->id ?>/update" method="post">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" placeholder="Nom" class="form-control" value="<?= $famille->nom?>">
            <span class="text text-danger"><?= $errors['nom'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" name="ville" id="ville" placeholder="Ville" class="form-control" value="<?= $famille->ville?>">
            <span class="text text-danger"><?= $errors['ville'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-success">Modifier la famille <?= $famille->nom?></button>
        <a href="<?= BASE_URI ?>/" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
