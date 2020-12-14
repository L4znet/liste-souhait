<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Ajout d'une nouvelle famille</h1>
    <form action="<?= BASE_URI ?>/famille/store" method="post">
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" placeholder="Nom" class="form-control">
            <span class="text text-danger"><?= $errors['nom'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="text" name="ville" id="ville" placeholder="Ville" class="form-control">
            <span class="text text-danger"><?= $errors['ville'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-success">Créer la famille </button>
        <a href="<?= BASE_URI ?>/" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
