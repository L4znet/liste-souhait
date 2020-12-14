<?php require('views/layouts/header.php') ?>

<main class="bg-white p-5 shadow-sm">
    <h1>Modification de <?= $membre->prenom ?> <?= $membre->nom ?></h1>
    <form action="<?= BASE_URI ?>/membre/<?= $membre->id ?>/update" method="post">
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" id="prenom" placeholder="Prénom" class="form-control" value="<?= $membre->prenom ?>">
            <span class="text text-danger"><?= $errors['prenom'] ?? '' ?></span>
        </div>
        <div class="form-group">
            <label for="date_naissance">Date de naissance</label>
            <input type="date" name="date_naissance" id="date_naissance" placeholder="Date de naissance" class="form-control" value="<?= $membre->date_naissance ?>">
            <span class="text text-danger"><?= $errors['date_naissance'] ?? '' ?></span>
        </div>
        <button role="submit" class="btn btn-primary">Modifier</button>
        <a href="<?= BASE_URI ?>/" role="submit" class="btn btn-outline-primary">Annuler</a>
    </form>
</main>

<?php require('views/layouts/footer.php') ?>
