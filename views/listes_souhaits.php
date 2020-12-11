<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">


    <div class="row w-100 d-flex align-items-center justify-content-between">
        <h1>Les listes de <?= $membre->prenom ?> <?= $famille->nom ?></h1>
        <a class="btn btn-primary" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/">Créer une liste</a>
    </div>
    <?php foreach ($listes as $liste): ?>

    <div class="card">
        <div class="card-body">
            <h4> Liste de souhaits de l'année <?= $liste->annee ?></h4>
            <a class="btn btn-primary" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/">Consulter la liste</a>
            <a class="btn btn-danger" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/">Supprimer la liste</a>
            <a class="btn btn-warning" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/">Modifier la liste</a>
        </div>
    </div>
    <?php  endforeach; ?>

</main>

<?php require('views/layouts/footer.php') ?>
