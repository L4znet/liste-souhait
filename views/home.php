<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <a href="<?= BASE_URI ?>/famille/create" class="btn btn-primary float-right">Créer une famille</a>

    <?php foreach ($familles as $famille) : ?>
    <h2><?= $famille->nom ?></h2>
    <p><?= $famille->ville ?></p>
    <a class="btn btn-primary" href="<?= BASE_URI ?>/famille/<?= $famille->id ?>">Consulter</a> -
    <a class="btn btn-warning" href="<?= BASE_URI ?>/famille/<?= $famille->id ?>/edit">Modifier</a>
    - <a class="btn btn-danger" href="<?= BASE_URI ?>/famille/<?= $famille->id ?>/destroy">Supprimer</a>
    <hr>

    <?php endforeach; ?>
</main>

<?php require('views/layouts/footer.php') ?>
