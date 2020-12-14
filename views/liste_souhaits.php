<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <div class="row w-100 d-flex align-items-center justify-content-between">
        <div class="col-md-7">
            <h1>La liste de <?= $liste_souhaits->annee ?></h1>
        </div>
        <div class="col-md-3"> <a class="btn btn-primary" href="<?= BASE_URI ?>/liste/<?= $liste_souhaits->id ?>/souhait/create">Ajouter un produit</a></div>
    </div>
    <?php foreach ($souhaits as $souhait): ?>
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info"> <?= $souhait->donneur_id ? $souhait->donneur_nom . " offre ce cadeau." : "Personne ne s'est encore attribué à ce cadeau."; ?></div>

            <div class="row d-flex justify-content-between">
                <div class="col-md-7">
                    <h4> <?= $souhait->nom ?></h4>
                </div>
                <div class="col-md-3">
                    <h4>
                        <?= $prix = $souhait->prix ? $souhait->prix . " € " : "Aucun prix"; ?>
                    </h4>
                    <a class="link-primary" href="<?= $souhait->lien ?? '' ?>"><?= $lien = $souhait->lien ? " Lien vers le produit " : ""; ?></a>
                </div>
            </div>

            <a class="btn btn-danger" href="<?= BASE_URI ?>/souhait/<?= $souhait->id ?>/destroy">Supprimer le souhait</a>
            <a class="btn btn-warning" href="<?= BASE_URI ?>/souhait/<?= $souhait->id ?>/edit">Modifier le souhait</a>
        </div>
    </div>
    <?php  endforeach; ?>

</main>

<?php require('views/layouts/footer.php') ?>
