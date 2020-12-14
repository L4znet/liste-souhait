<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">


    <div class="row w-100 d-flex align-items-center justify-content-between">
        <div class="col-8">
            <h1>Les listes de <?= $membre->prenom ?> <?= $famille->nom ?></h1>
        </div>
        <div class="col-3">
            <a class="btn btn-primary" href="<?= BASE_URI ?>/membre/<?= $membre->id ?>/listes/create">Créer une liste</a>
        </div>
    </div>
    <?php foreach ($listes as $liste): ?>

    <div class="card">
        <div class="card-body">
            <h4> Liste de souhaits de l'année <?= $liste->annee ?></h4>
            <a class="btn btn-primary" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/souhait">Consulter la liste</a>
            <a class="btn btn-danger" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/destroy">Supprimer la liste</a>
            <a class="btn btn-warning" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/edit">Modifier la liste</a>
        </div>
    </div>

    <?php  endforeach; ?>

</main>

<?php require('views/layouts/footer.php') ?>
