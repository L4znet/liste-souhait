<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">


    <div class="row w-100 d-flex align-items-center justify-content-between">
        <h1>La listes de <?= $liste_souhaits->annee ?></h1>

    </div>
    <?php foreach ($souhaits as $souhait): ?>

    <div class="card">
        <div class="card-body">
            <div class="row d-flex justify-content-between">
                <h4> <?= $souhait->nom ?></h4>
                <h4> <?= $souhait->prix ?> €</h4>
            </div>
            <a class="btn btn-success" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/">Je veux l'offrir</a>
            <a class="btn btn-danger" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/">Supprimer le souhait</a>
            <a class="btn btn-warning" href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/">Modifier le souhait</a>
        </div>
    </div>
    <?php  endforeach; ?>

</main>

<?php require('views/layouts/footer.php') ?>
