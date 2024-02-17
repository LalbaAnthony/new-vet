<?php

include APP_PATH . "auth.php";

?>

<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js'></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-4">

        <a style="text-decoration: none" class="d-flex justify-content-start" href="<?= APP_URL ?>bo/pages/index.php">
            <img src="<?= APP_URL ?>assets/logo.jpg" alt="Logo" width="40" height="40">
            <span class="mx-2 navbar-brand">NEW VET</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/dashboard.php">Tableau de bord</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/images/index.php">Images</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/products/index.php">Produits</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/categories/index.php">Catégories</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/materials/index.php">Matériaux</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/orders/index.php">Commandes</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/customers/index.php">Clients</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/contacts/index.php">Contacts</a></li>
                <li class="nav-item"><a class="nav-link" aria-current="page" href="<?= APP_URL ?>bo/pages/logout.php">Se déconnecter</a></li>
            </ul>
        </div>
    </div>
</nav>