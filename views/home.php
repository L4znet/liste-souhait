<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <div class="col-3">
        <a href="<?= BASE_URI ?>/famille/create" class="btn btn-primary float-right">Créer une famille</a>
    </div>
    <?php foreach ($familles as $famille) : ?>
    <div class="row w-100 d-flex align-items-center justify-content-between">
        <h2><?= $famille->nom ?></h2>

    </div>
    <p><?= $famille->ville ?></p>
    <a class="btn btn-primary" href="<?= BASE_URI ?>/famille/<?= $famille->id ?>">Consulter</a> -
    <a class="btn btn-warning" href="<?= BASE_URI ?>/famille/<?= $famille->id ?>/edit">Modifier</a>
    - <a class="btn btn-danger" href="<?= BASE_URI ?>/famille/<?= $famille->id ?>/destroy">Supprimer</a>
    <hr>

    <?php endforeach; ?>
</main>

<?php require('views/layouts/footer.php') ?>
