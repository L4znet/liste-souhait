<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <div class="row w-100 d-flex align-items-center justify-content-between">
        <div class="col-7">
            <h1><?= $famille->nom ?? ''?></h1>
            <h2><?= $famille->ville ?? ''?></h2>
        </div>
        <div class="col-3">
            <a class="btn btn-primary" href="<?= BASE_URI ?>/famille/<?=  $famille->id ?>/membre/create">Ajouter un membre</a>
        </div>
    </div>

    <?php foreach ($membres as $membre): ?>

    <div class="card">
        <div class="card-body">
            <b> <?= $membre->prenom ?> <?= $famille->nom ?></b>
            <p><?= formatDate('d/m/Y', $membre->date_naissance)?></p>
            <a class="btn btn-primary" href="<?= BASE_URI ?>/membre/<?= $membre->id ?>/listes">Consulter ses listes de souhaits</a>
            <a class="btn btn-danger" href="<?= BASE_URI ?>/membre/<?= $membre->id ?>/destroy/">Supprimer ce membre</a>
            <a class="btn btn-warning" href="<?= BASE_URI ?>/membre/<?= $membre->id ?>/edit">Modifier ce membre</a>
        </div>
    </div>
    <?php  endforeach; ?>

</main>

<?php require('views/layouts/footer.php') ?>
