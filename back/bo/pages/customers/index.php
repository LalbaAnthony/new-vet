<?php
require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/customer.php";
include_once APP_PATH . "helpers/fr_datetime.php";
include_once APP_PATH . "helpers/three_dots_string.php";
?>
<?php
// Get the sorting parameters from the query strings
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Comput new order and sort
$new_order = $order == 'DESC' ? 'asc' : 'desc';
$sort = array(array('order' => $order, 'order_by' => $order_by));

$customers_count = getCustomersCount();

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;
$maxPage = ceil($customers_count / $per_page);

// Fetch customers with sorting
$customers = getCustomers($search,$sort,$offset,$per_page);

// Bottom action: delete selected customers, ...
if (isset($_GET['delete']) && isset($_GET['selected_customers'])) {
    $selected_customers = explode(",", $_GET['selected_customers']);
    foreach ($selected_customers as $id) {
        putToTrashcustomer($id);
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
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Lise des produits - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
    <script src="<?= APP_URL ?>bo/script/autosubmit.js"></script>
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <?php include_once APP_PATH . "bo/partials/alert_message.php"; ?>

    <div class="container p-4 p-lg-5">
        <h1 class="text-center">Liste des clients</h1>
        <p class="text-center"><?= $customers_count ?> client<?php if ($customers_count > 1) : ?>s<?php endif; ?></p>

        <!-- Barre de recherche -->
        <form class="d-flex justify-content-between my-4" method="GET">
            <input class="form-control mr-sm-2" id="search" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
            <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr class="table-primary">
                    <th scope='col' colspan='1'><input type="checkbox" onclick="toggleAll()"></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=first_name&order=<?= $new_order ?>">Prenom</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=last_name&order=<?= $new_order ?>">Nom</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=email&order=<?= $new_order ?>">E-mail</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=has_validated_email&order=<?= $new_order ?>">Mail Valide ?</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=last_login&order=<?= $new_order ?>">Last Login</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=created_at&order=<?= $new_order ?>">Date Création</a></th>
                    <th scope='col' colspan='2'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($customers as $customer) {
                ?>
                    <tr class="align-middle">
                        <!-- Checkbox pour la suppression multiple -->
                        <td><input id="customer_<?= $customer['customer_id'] ?>" type="checkbox" name="selected_customers[]" value="<?= $customer['customer_id'] ?>"></td>
                        <!-- Prenom -->
                        <td><?= $customer['first_name'] ?></td>
                        <!-- Nom -->
                        <td><?= $customer['last_name'] ?></td>
                        <!-- Mail -->
                        <td><?= $customer['email'] ?></td>
                        <!-- Mail Valide ? -->
                        <td><?= $customer['has_validated_email'] == 1 ? 'Oui' : '-' ?></td>
                        <!-- Ordre d'affichage -->
                        <td><?= fr_datetime($customer['last_login']) ?></td>
                        <!-- Date de création -->
                        <td><?= fr_datetime($customer['created_at']) ?></td>
                        <!-- Bouton de modification -->
                        <td><a href="<?= APP_URL ?>bo/pages/customers/modify_customer.php?id=<?= $customer['customer_id'] ?>" class="btn btn-primary btn-sm">Modifier</a></td>
                        <!-- Bouton de suppression -->
                        <td><a href="<?= APP_URL ?>bo/pages/customers/delete_customer.php?id=<?= $customer['customer_id'] ?>" class="btn btn-danger btn-sm">Supprimer</a></td>
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
            <button id="delete-customers" class="btn btn-danger" disabled onclick="deleteSelectedcustomers()">Supprimer</button>
            <a href="<?= APP_URL ?>bo/pages/customers/create_customer.php" class="btn btn-primary">Ajouter</a>
        </div>
    </div>
</body>

</html>
<script>
    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-customers');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-customers');
        btn.disabled = false;
    }

    // Fonction pour cocher/décocher toutes les cases
    function toggleAll() {
        var checkboxes = document.getElementsByName('selected_customers[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = event.target.checked;
        }
        if (event.target.checked) {
            enableSupprButton();
        } else {
            disableSupprButton();
        }
    }

    // Fonction pour supprimer les produits sélectionnés
    function deleteSelectedcustomers() {
        var checkboxes = document.getElementsByName('selected_customers[]');
        var selected_customers = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_customers.push(checkbox.value);
            }
        }
        if (selected_customers.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_customers=" + selected_customers.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_customers[]');
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