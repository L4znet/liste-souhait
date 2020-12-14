<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Ajout d'un souhait</h1>
    <form action="<?= BASE_URI ?>/liste/<?= $liste->id?>/souhait/store" method="post">
        <div class="form-group">
            <label for="nom">Nom du produit</label>
            <input type="text" name="nom" id="nom" placeholder="Nom du produit" class="form-control">
            <span class="text text-danger"><?= $errors['nom'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="prix">Prix (facultatif)</label>
            <input type="number" name="prix" id="prix" placeholder="Prix" class="form-control">
            <span class="text text-danger"><?= $errors['prix'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="lien">Lien (facultatif)</label>
            <input type="text" name="lien" id="lien" placeholder="Lien" class="form-control">
            <span class="text text-danger"><?= $errors['lien'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-success">Ajouter ce souhait</button>
        <a href="<?= BASE_URI ?>/liste/<?= $liste->id ?>/souhait" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
