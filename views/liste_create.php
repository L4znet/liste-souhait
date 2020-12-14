<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Création d'une liste</h1>
    <form action="<?= BASE_URI ?>/membre/<?= $membre->id?>/listes/store" method="post">
        <div class="form-group">
            <label for="annee">Année</label>
            <input type="text" name="annee" id="annee" placeholder="Année" class="form-control">
            <span class="text text-danger"><?= $errors['annee'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-success">Créer la liste</button>
        <a href="<?= BASE_URI ?>/membre/<?= $membre->id ?>/listes" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
