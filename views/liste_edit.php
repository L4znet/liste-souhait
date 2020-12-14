<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Modification de la liste de l'année <?= $liste->annee ?></h1>
    <form action="<?= BASE_URI ?>/liste/<?= $liste->id?>/update" method="post">
        <div class="form-group">
            <label for="annee">Année</label>
            <input type="number" name="annee" id="annee" placeholder="Année" value="<?= $liste->annee ?>" class="form-control">
            <span class="text text-danger"><?= $errors['annee'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-success">Modifier la liste</button>
        <a href="<?= BASE_URI ?>/membre/<?= $liste->id_membre ?>/listes" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
