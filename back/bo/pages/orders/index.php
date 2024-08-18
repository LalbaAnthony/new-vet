<?php

require_once "../../../config.inc.php";
include_once APP_PATH . "controllers/order.php";
include_once APP_PATH . "controllers/status.php";
include_once APP_PATH . "controllers/customer.php";
include_once APP_PATH . "helpers/fr_datetime.php";
include_once APP_PATH . "controllers/image.php";

// Get the sorting parameters from the query string
$search = isset($_GET['search']) ? $_GET['search'] : null;
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'created_at';
$order = isset($_GET['order']) && $_GET['order'] == 'desc' ? 'DESC' : 'ASC';
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Comput new order and sort
$new_order = $order == 'DESC' ? 'asc' : 'desc';
$sort = array(array('order' => $order, 'order_by' => $order_by));

$orders_count = getOrdersCount(null, null, $search, null, null);

// Comput offset & per_page
$per_page = 10;
$offset = ($page - 1) * $per_page;
$maxPage = ceil($orders_count / $per_page);

// Fetch orders with sorting
$orders = getOrders(null, null, null, $search, $sort, $offset, $per_page);

// Bottom action: delete selected orders, ...
if (isset($_GET['delete']) && isset($_GET['selected_orders'])) {
    $selected_orders = explode(",", $_GET['selected_orders']);
    foreach ($selected_orders as $id) {
        putToTrashOrder($id);
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?deleted=1");
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
    <title>Lise des commandes - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
    <script src="<?= APP_URL ?>bo/script/autosubmit.js"></script>
</head>

<body>

    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <?php include_once APP_PATH . "bo/partials/alert_message.php"; ?>

    <div class="container p-4 p-lg-5">
        <h1 class="text-center">Liste des commandes</h1>
        <p class="text-center"><?= $orders_count ?> commande<?php if ($orders_count > 1) : ?>s<?php endif; ?></p>

        <!-- Barre de recherche -->
        <form class="d-flex justify-content-between my-4" method="GET">
            <input class="form-control mr-sm-2" id="search" type="search" placeholder="Rechercher" aria-label="Search" name="search" value="<?= $search ?>">
            <button class="btn btn-primary mx-2 my-sm-0" type="submit">Rechercher</button>
        </form>

        <table class="table table-striped">
            <thead>
                <tr class="table-primary">
                    <th scope='col' colspan='1'><input type="checkbox" onclick="toggleAll()"></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=order_id&order=<?= $new_order ?>">ID</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=status_id&order=<?= $new_order ?>">Status</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=customer_id&order=<?= $new_order ?>">Client</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=order_date&order=<?= $new_order ?>">Date</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=created_at&order=<?= $new_order ?>">Création</a></th>
                    <th scope='col'><a class="text-decoration-none" href="?search=<?= $search ?>&page=<?= $page ?>&order_by=total_amount&order=<?= $new_order ?>">Total</a></th>
                    <th scope='col' colspan='2'>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($orders as $ord) {
                ?>
                    <tr class="align-middle">
                        <!-- Checkbox pour la suppression multiple -->
                        <td><input id="order_<?= $ord['order_id'] ?>" type="checkbox" name="selected_orders[]" value="<?= $ord['order_id'] ?>"></td>
                        <!-- ID de la commande -->
                        <td><?= $ord['order_id'] ?></td>
                        <!-- Status de la commande -->
                        <td>
                            <?php $status = getStatus($ord['status_id']); ?>
                            <span class="badge" style="background-color: <?= $status['color'] ?>; color: white; padding: 5px; border-radius: 5px;">
                                <?= $status['libelle'] ?>
                            </span>
                        </td>
                        <!-- Nom du client -->
                        <td>
                            <?php
                            $customer = getCustomer($ord['customer_id']);
                            $nicename = $customer['first_name'] . " " . $customer['last_name'];
                            echo "<a href='" . APP_URL . "bo/pages/customers/index.php?search=" . $customer['email'] . "'>" . $nicename . "</a>";
                            ?>
                        </td>
                        <!-- Date de la commande -->
                        <td><?= fr_datetime($ord['order_date']) ?></td>
                        <!-- Date de création -->
                        <td><?= fr_datetime($ord['created_at']) ?></td>
                        <!-- Total -->
                        <td><?= $ord['total_amount'] ?> €</td>
                        <!-- Bouton de modification -->
                        <td><a href="<?= APP_URL ?>bo/pages/orders/modify_order.php?id=<?= $ord['order_id'] ?>" class="btn btn-primary btn-sm">Modifier</a></td>
                        <!-- Bouton de suppression -->
                        <td><a href="<?= APP_URL ?>bo/pages/orders/delete_order.php?id=<?= $ord['order_id'] ?>" class="btn btn-danger btn-sm">Supprimer</a></td>
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
            <button id="delete-orders" class="btn btn-danger" disabled onclick="deleteSelectedOrders()">Supprimer</button>
            <a href="<?= APP_URL ?>bo/pages/orders/create_order.php" class="btn btn-primary">Ajouter</a>
        </div>
    </div>
</body>

</html>

<script>
    // Fonction disbale suppr button
    function disableSupprButton() {
        var btn = document.getElementById('delete-orders');
        btn.disabled = true;
    }

    // Fonction enable suppr button
    function enableSupprButton() {
        var btn = document.getElementById('delete-orders');
        btn.disabled = false;
    }

    // Fonction pour cocher/décocher toutes les cases
    function toggleAll() {
        var checkboxes = document.getElementsByName('selected_orders[]');
        for (var checkbox of checkboxes) {
            checkbox.checked = event.target.checked;
        }
        if (event.target.checked) {
            enableSupprButton();
        } else {
            disableSupprButton();
        }
    }

    // Fonction pour supprimer les commandes sélectionnés
    function deleteSelectedOrders() {
        var checkboxes = document.getElementsByName('selected_orders[]');
        var selected_orders = [];
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                selected_orders.push(checkbox.value);
            }
        }
        if (selected_orders.length > 0) {
            if (confirm("Voulez-vous vraiment supprimer les éléments sélectionnés ?")) {
                window.location.href = "<?= $_SERVER['PHP_SELF'] ?>?delete&selected_orders=" + selected_orders.join(",");
            }
        } else {
            alert("Vous devez sélectionner au moins un élément à supprimer");
        }
    }

    // Désactiver le bouton de suppression si aucune case n'est cochée
    var checkboxes = document.getElementsByName('selected_orders[]');
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