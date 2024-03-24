<?php

include_once "../../../config.inc.php";
include_once APP_PATH . "/models/category.php";
include_once APP_PATH . "/helpers/fr_datetime.php";
include_once APP_PATH . "/models/image.php";


// Get the sorting parameters from the query string
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;


// Comput new order and sort
$new_order = $order == 'DESC' ? 'asc' : 'desc';
$sort = array(array('order' => $order, 'order_by' => $order_by));

$categories_count = getCategoriesCount($search);

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;
$maxPage = ceil($categories_count / $per_page);

// Fetch categories  with sorting
$categories = getCategories($search,false,false,array(),array(), $sort, $offset, $per_page);

// Bottom action: delete selected contacts, ...
if (isset($_GET['delete']) && isset($_GET['selected_categories'])) {
    $selected_categories = explode(",", $_GET['selected_categories']);
    foreach ($selected_categories as $slug) {
        deleteCategory($slug);
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Site de vente de vêtement pour femme." />
    <meta name="author" content="LALBA Anthony et SIREYJOL Victor" />
    <title>Lise des contacts - NEW VET</title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <main>

        <?php include_once APP_PATH . "/bo/partials/header.php"; ?>

        <?php include_once APP_PATH . "/bo/partials/alert_message.php"; ?>

        <div class="container p-4 p-lg-5">
            <h1 class="text-center">Liste des Catégories</h1>
            <p class="text-center"><?= $categories_count ?> <?php if ($categories_count == 1) : ?>catégorie<?php endif; ?> catégories</p>
         

            <!-- Barre de recherche -->
            <form class="d-flex justify-content-between my-4" method="GET">
                <input class="form-control mr-sm-2" id="search" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
                <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr class="table-primary">
                        <th scope='col' colspan='1'><input type="checkbox" onclick="toggleAll()"></th>
                        <th scope='col' colspan='1'>&nbsp;</th>
                        <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=created_at&order=<?= $new_order ?>">Matériel</a></th>
                        <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=libelle&order=<?= $new_order ?>">Date</a></th>
                        <th scope='col' colspan='2'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($categories as $category) {
                    ?>
                        <tr class="align-middle">
                            <!-- Checkbox pour la suppression multiple -->
                            <td><input id="slug" type="checkbox" name="selected_categories[]" value="<?= $category['slug'] ?>"></td>
                              <!-- Image -->
                        <td>
                            <?php
                            $dbImgPath = getFirstImagePathFromCategory($category['slug']);
                            $full_img_path = APP_PATH . $dbImgPath;
                  
                            ?>
                            <?php if ($dbImgPath && file_exists($full_img_path)) : ?>
                               <?php echo($full_img_path) ?>
                                <img src="<?= APP_URL . $dbImgPath ?>" class="img-thumbnail" width="100">
                            <?php else : ?>
                               
                                <img src="<?= APP_URL ?>assets/img/default-img.webp" class="img-thumbnail" width="100">
                            <?php endif; ?>
                        </td>
                                <!-- Client -->
                                <td><?= $category['libelle'] ?></td>
                            <!-- Date -->
                            <td><?= fr_datetime($category['created_at']) ?></td>
                    
                    
                            <!-- Bouton de suppression -->
                            <td> <a href="<?= APP_URL ?>/bo/pages/categories/delete_category.php?slug=<?= $category['slug'] ?>" class="btn btn-danger btn-sm">Supprimer</a> </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

              <!-- Pagination -->
              <div class="d-flex justify-content-between my-2">
                <!-- Page précédente -->
                <?php if ($page > 1) : ?>
                    <a href="?search=<?= $search ?>&page=<?= $page - 1 ?>&order_by=<?= $order_by ?>&order=<?= $order ?>">Page précédent (<?= $page - 1 ?>)</a>
                <?php else : ?>
                    <span>&nbsp;</span>
                <?php endif; ?>
                <!-- Page Actuelle -->
                <span>Page <?= $page ?></span>
                <!-- Page suivante -->
                <?php if ($page < $maxPage) : ?>
                    <a href="?search=<?= $search ?>&page=<?= $page + 1 ?>&order_by=<?= $order_by ?>&order=<?= $order ?>">Page suivant (<?= $page + 1 ?>)</a>
                <?php else : ?>
                    <span>&nbsp;</span>
                <?php endif; ?>
            </div>
            <!-- Actions en bas de page -->
            <div class="d-flex justify-content-start gap-2 my-5">
                <button id="delete-contacts" class="btn btn-danger" disabled onclick="deleteSelectedcontacts()">Supprimer</button>
            </div>
        </div>

    </main>
</body>

</html>


<script>
    // Auto submit search form on change (with a delay)
    var searchInput = document.getElementById('search');
    var searchForm = document.querySelector('form');
    const delay = 1000;
    var timeout = null;
    searchInput.addEventListener('input', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            searchForm.submit();
        }, delay);
    });

    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-contacts');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-contacts');
        btn.disabled = false;
    }

    // Fonction pour cocher/décocher toutes les cases
    function toggleAll() {
        var checkboxes = document.getElementsByName('selected_contacts[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = event.target.checked;
        }
        if (event.target.checked) {
            enableSupprButton();
        } else {
            disableSupprButton();
        }
    }

    // Fonction pour supprimer les contacts sélectionnés
    function deleteSelectedcontacts() {
        var checkboxes = document.getElementsByName('selected_contacts[]');
        var selected_contacts = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_contacts.push(checkbox.value);
            }
        }
        if (selected_contacts.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_contacts=" + selected_contacts.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_contacts[]');
    for (var checkbox of checkboxes) {
        checkbox.addEventListener('change', function() {
            if (this.checked || document.querySelector('input[name="selected_images[]"]:checked')) {
                enableSupprButton();
            } else {
                disableSupprButton();
            }
        });
    }
</script>

?>