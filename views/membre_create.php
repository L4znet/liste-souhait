<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Ajout d'un nouveau membre</h1>
    <form action="<?= BASE_URI ?>/famille/<?= $famille->id ?>/membre/store" method="post">
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" placeholder="Prénom" class="form-control">
            <span class="text text-danger"><?= $errors['prenom'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="date_naissance">Date de naissance</label>
            <input type="date" name="date_naissance" id="date_naissance" placeholder="Date de naissance" class="form-control">
            <span class="text text-danger"><?= $errors['date_naissance'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-success">Ajouter un membre</button>
        <a href="<?= BASE_URI ?>/famille/<?= $famille->id ?>" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
