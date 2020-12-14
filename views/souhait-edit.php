<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Modification du souhait <b><?= $souhait->nom ?></b></h1>
    <form action="<?= BASE_URI ?>/souhait/<?= $souhait->id?>/update" method="post">
        <div class="form-group">
            <label for="nom">Nom du produit</label>
            <input type="text" name="nom" id="nom" placeholder="Nom du produit" class="form-control" value="<?= $souhait->nom ?>">
            <span class="text text-danger"><?= $errors['nom'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="id_donneur">Choix de la personne</label>
            <select name="id_donneur" id="id_donneur" class="form-select" aria-label="Default select example">
                <option disabled selected value="<?= $souhait->donneur_id ?>"><?= $souhait->donneur_nom ?></option>
                <?php
                foreach ($membres as $membre): ?>
                <option value="<?= $membre->id ?>"><?= $membre->prenom ?> <?= $membre->nom ?></option>
                <?php endforeach;?>
            </select>
            <span class="text text-danger"><?= $errors['prix'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="prix">Prix (facultatif)</label>
            <input type="text" name="prix" id="prix" placeholder="Prix" value="<?= $souhait->prix ?? 'Aucun prix' ?>" class="form-control">
            <span class="text text-danger"><?= $errors['prix'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="lien">Lien (facultatif)</label>
            <input type="url" name="lien" id="lien" placeholder="Lien" class="form-control" value="<?= $souhait->lien ?>">
            <span class="text text-danger"><?= $errors['lien'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-primary">Modifier ce souhait</button>
        <a href="<?= BASE_URI ?>/liste/<?= $souhait->id_liste ?>/souhait" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
