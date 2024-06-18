<?php


require_once "../../../config.inc.php";

include_once APP_PATH . "controllers/order.php";
include_once APP_PATH . "controllers/card.php";
include_once APP_PATH . "controllers/status.php";
include_once APP_PATH . "controllers/customer.php";
include_once APP_PATH . "controllers/address.php";
include_once APP_PATH . "controllers/product.php";
include_once APP_PATH . 'helpers/mask_number.php';

// Réception du produit à modifier
$urlId = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($urlId)) {
    header('Location: ' . APP_URL . 'bo/pages/orders/index.php');
}

// Get the order iteself
$order = getorder($urlId);

// Get the order lines
$order_lines = getOrderLines($urlId);

// Add the product to each order line
foreach ($order_lines as $key => $order_line) {
    $order_lines[$key]['product'] = getProduct($order_line['product_slug']);
}

// Load children tables
$statuses = getStatuses();
$customers = getCustomers();
$addresses = getAddresses($order['customer_id']);
$card = getCard($order['card_id']);

// Modification dans la base
if (isset($_POST['submit'])) {

    $order = array();

    // Lecture du formulaire
    $order['order_id'] = isset($_POST['order_id']) ? $_POST['order_id'] : null;
    $order['customer_id'] = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
    $order['shipping_address_id'] = isset($_POST['shipping_address_id']) ? $_POST['shipping_address_id'] : null;
    $order['billing_address_id'] = isset($_POST['billing_address_id']) ? $_POST['billing_address_id'] : null;
    $order['card_id'] = isset($_POST['card_id']) ? $_POST['card_id'] : null;
    $order['status_id'] = isset($_POST['status_id']) ? $_POST['status_id'] : null;
    $order['order_date'] = isset($_POST['order_date']) ? $_POST['order_date'] : null;
    $order['total_amount'] = isset($_POST['total_amount']) ? $_POST['total_amount'] : 0;

    // Formulaire validé : on modifie l'enregistrement
    $success = updateOrder($order);

    // Redirection vers la liste des produits
    header('Location: ' . APP_URL . 'bo/pages/orders/index.php?created=' . $success);
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= APP_URL ?>assets/favicon-gear.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="<?= APP_NAME ?>" />
    <title>Modification - <?= APP_NAME ?></title>
    <link href="<?= APP_URL ?>bo/style/bootstrap.css" rel="stylesheet">
    <link href="<?= APP_URL ?>bo/style/main.css" rel="stylesheet">
</head>

<body>
    <?php include_once APP_PATH . "bo/partials/header.php"; ?>

    <div class="container mt-5">

        <?php include_once APP_PATH . "bo/partials/alert_message.php"; ?>

        <h2 class="mb-4">Modification d'une commande :</h2>

        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="post" class="mb-5">
            <input type="hidden" name="order_id" id="id" value="<?= $order['order_id']; ?>">

            <div class="form-group my-4">
                <label class="required" for="total_amount">Total:</label>
                <input class="form-control" type="number" id="total_amount" name="total_amount" value="<?= $order['total_amount'] ?>" required disabled>
            </div>

            <div class="form-group my-4">
                <label class="required" for="order_date">Date de la commande:</label>
                <input class="form-control" type="datetime-local" id="order_date" name="order_date" value="<?= $order['order_date'] ?>" required>
            </div>

            <div class="form-group my-4">
                <label class="required" for="customer_id">Client de la commande:</label>
                <select name="customer_id" id="customer_id" class="form-control" required disabled>
                    <?php foreach ($customers as $customer) : ?>
                        <option value="<?= $customer['customer_id'] ?>" <?php if ($customer['customer_id'] == $order['customer_id']) : ?> selected <?php endif; ?>><?= $customer['first_name'] . " " . $customer['last_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group my-4">
                <label class="required" for="status_id">Status de la commande:</label>
                <select name="status_id" id="status_id" class="form-control" required>
                    <?php foreach ($statuses as $status) : ?>
                        <option value="<?= $status['status_id'] ?>" <?php if ($status['status_id'] == $order['status_id']) : ?> selected <?php endif; ?>><?= $status['libelle'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex-row">
                <div class="form-group my-4">
                    <label class="required" for="shipping_address_id">Adresse de livraison de la commande:</label>
                    <select name="shipping_address_id" id="shipping_address_id" class="form-control" required>
                        <?php foreach ($addresses as $address) : ?>
                            <option value="<?= $address['address_id'] ?>" <?php if ($address['address_id'] == $order['shipping_address_id']) : ?> selected <?php endif; ?>>
                                <?= $address['address1'] . " " . $address['address2'] . " " . $address['postal_code'] . " " . $address['city'] . " " . $address['region'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group my-4">
                    <label class="required" for="billing_address_id">Adresse de facturation de la commande:</label>
                    <select name="billing_address_id" id="billing_address_id" class="form-control" required>
                        <?php foreach ($addresses as $address) : ?>
                            <option value="<?= $address['address_id'] ?>" <?php if ($address['address_id'] == $order['billing_address_id']) : ?> selected <?php endif; ?>>
                                <?= $address['address1'] . " " . $address['address2'] . " " . $address['postal_code'] . " " . $address['city'] . " " . $address['region'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group my-4">
                <input type="hidden" name="card_id" id="id" value="<?= $order['card_id']; ?>">
                <label class="required" for="card_number">Carte:</label>
                <input class="form-control" type="text" id="card_number" name="card_number" value="<?= mask_number($card['number']) ?>" required disabled>
            </div>

            <!-- Lignes de commande -->
            <div class="form-group my-4">
                <label for="order_lines">Lignes de commande:</label>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_lines as $order_line) : ?>
                            <tr>
                                <td><?= $order_line['product']['name'] ?></td>
                                <td><?= $order_line['quantity'] ?></td>
                                <td><?= $order_line['product']['name'] ?></td>
                                <td><?= $order_line['line_price'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between my-4">
                <a href="<?= APP_URL ?>bo/pages/orders/index.php" class="btn btn-secondary">Retour</a>
                <button type="submit" name="submit" class="btn btn-primary">Modifier</button>
            </div>
        </form>
    </div>
</body>

</html>