<?php


require_once "../../../config.inc.php";

include_once APP_PATH . "models/order.php";
include_once APP_PATH . "models/card.php";
include_once APP_PATH . "models/status.php";
include_once APP_PATH . "models/customer.php";
include_once APP_PATH . "models/address.php";
include_once APP_PATH . "models/product.php";
include_once APP_PATH . 'helpers/mask_number.php';

// Réception du contenu à modifier
$urlId = isset($_GET['id']) ? $_GET['id'] : '';

// Load children tables
$statuses = getStatuses();
$customers = getCustomers(null, array(array('order' => 'ASC', 'order_by' => 'first_name')), null, 999);
$products = getProducts(null, null, null, false, null, null, null, null, 999);

if (!empty($urlId)) {
    $order = getOrder($urlId);
    $order_lines = getOrderLines($urlId);

    // Add the product to each order line
    for($i = 0; $i < count($order_lines); $i++) {
        $order_lines[$i]['product'] = getProduct($order_lines[$i]['product_slug']);
    }

    // Load children tables
    $addresses = getAddresses($order['customer_id']);
    $card = getCard($order['card_id']);
}

// Modification dans la base
if (isset($_POST['submit'])) {

    $order = array();

    // Lecture de la commande
    $order['order_id'] = isset($_POST['order_id']) ? $_POST['order_id'] : null;
    $order['customer_id'] = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
    $order['shipping_address_id'] = isset($_POST['shipping_address_id']) ? $_POST['shipping_address_id'] : null;
    $order['billing_address_id'] = isset($_POST['billing_address_id']) ? $_POST['billing_address_id'] : null;
    $order['card_id'] = isset($_POST['card_id']) ? $_POST['card_id'] : null;
    $order['status_id'] = isset($_POST['status_id']) ? $_POST['status_id'] : null;
    $order['order_date'] = isset($_POST['order_date']) ? $_POST['order_date'] : null;

    // Load children tables
    if ($order) {
        $addresses = getAddresses($order['customer_id']);
        $card = getCard($order['card_id']);
    }

    // Lecture des lignes de commande
    $order_lines = isset($_POST['orders_line']) ? $_POST['orders_line'] : null;

    // Modification des lignes de commande
    $successOrderLine = true;
    $total_amount = 0;
    if ($order_lines) {
        foreach ($order_lines as $key => $order_line) {

            // Calcul du prix de la ligne
            $line_price = ($order_line['quantity'] && $order_line['product']['price']) ? ($order_line['quantity'] * $order_line['product']['price']) : $order_line['line_price'];
            $total_amount += $line_price;

            $new_order_line = array(
                'order_line_id' => isset($order_line['order_line_id']) ? $order['order_line_id'] : $key,
                'order_id' => $order['order_id'],
                'product_slug' => $order_line['product']['product_slug'],
                'quantity' => $order_line['quantity'],
                'line_price' =>  $line_price,
            );

            // Modification de la ligne de commande
            $successOrderLine = updateOrderLine($new_order_line);
        }
    }
    
    $order['total_amount'] = $total_amount > 0 ? $total_amount : (isset($_POST['total_amount']) ? $_POST['total_amount'] : 0);
    
    // Modification de la commande
    $successOrder = updateOrder($order);

    // Message de retour
    $success = $successOrder && $successOrderLine;

    // Redirection vers la liste des produits
    header('Location: ' . APP_URL . 'bo/pages/orders/index.php?created=' . $success);
}

// Suppression d'une ligne de commande
if (isset($_GET['line_to_delete'])) {
    $success = putToTrashOrderLine($_GET['line_to_delete']);
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $urlId . '&deleted=' . $success);
}

if (empty($urlId)) {
    // header('Location: ' . APP_URL . 'bo/pages/orders/index.php');
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
                <input class="form-control" type="number" id="total_amount" name="total_amount" value="<?= $order['total_amount'] ?>" required readonly>
            </div>

            <div class="form-group my-4">
                <label class="required" for="order_date">Date de la commande:</label>
                <input class="form-control" type="datetime-local" id="order_date" name="order_date" value="<?= $order['order_date'] ?>" required>
            </div>

            <div class="form-group my-4">
                <label class="required" for="customer_id">Client de la commande:</label>
                <select name="customer_id" id="customer_id" class="form-control" required readonly>
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
                                <?= $address['address1'] . " " . $address['address2'] . " " . $address['zip'] . " " . $address['city'] . " " . $address['region'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group my-4">
                    <label class="required" for="billing_address_id">Adresse de facturation de la commande:</label>
                    <select name="billing_address_id" id="billing_address_id" class="form-control" required>
                        <?php foreach ($addresses as $address) : ?>
                            <option value="<?= $address['address_id'] ?>" <?php if ($address['address_id'] == $order['billing_address_id']) : ?> selected <?php endif; ?>>
                                <?= $address['address1'] . " " . $address['address2'] . " " . $address['zip'] . " " . $address['city'] . " " . $address['region'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group my-4">
                <input type="hidden" name="card_id" id="id" value="<?= $order['card_id']; ?>">
                <label class="required" for="number">Carte:</label>
                <input class="form-control" type="text" id="number" name="number" value="<?= mask_number($card['number']) ?>" required readonly>
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
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order_lines as $order_line) : ?>
                            <tr>
                                <td>
                                    <select id="product.product_slug.<?= $order_line['order_line_id'] ?>" name="orders_line[<?= $order_line['order_line_id'] ?>][product][product_slug]" class="form-control" required>
                                        <?php foreach ($products as $product) : ?>
                                            <option value="<?= $product['slug'] ?>" <?php if ($product['slug'] == $order_line['product_slug']) : ?> selected <?php endif; ?>>
                                                <?= $product['name']  ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input class="form-control" type="number" id="quantity.<?= $order_line['order_line_id'] ?>" name="orders_line[<?= $order_line['order_line_id'] ?>][quantity]" value="<?= $order_line['quantity'] ?>" required min="1">
                                </td>
                                <td>
                                    <input class="form-control" type="number" id="product.price.<?= $order_line['order_line_id'] ?>" name="orders_line[<?= $order_line['order_line_id'] ?>][product][price]" value="<?= $order_line['product']['price'] ?>" required readonly>
                                </td>
                                <td>
                                    <input class="form-control" type="number" id="line_price.<?= $order_line['order_line_id'] ?>" name="orders_line[<?= $order_line['order_line_id'] ?>][line_price]" value="<?= $order_line['line_price'] ?>" required readonly>
                                </td>
                                <td>
                                    <a href="<?= $_SERVER['PHP_SELF']; ?>?id=<?= $urlId ?>&line_to_delete=<?= $order_line['order_line_id'] ?>" class="btn btn-danger">Supprimer</a>
                                </td>
                            </tr>
                            <script>
                                // Compute total amount

                                function computeTotalAmount() {
                                    const linePrices = document.querySelectorAll('input[name^="orders_line["][name$="][line_price]"]');
                                    let totalAmount = 0;
                                    linePrices.forEach((linePrice) => {
                                        totalAmount += parseFloat(linePrice.value);
                                    });
                                    document.getElementById('total_amount').value = totalAmount;
                                }

                                // Calcul du du prix de la ligne
                                document.getElementById('quantity.<?= $order_line['order_line_id'] ?>').addEventListener('change', function() {
                                    const val = document.getElementById('quantity.<?= $order_line['order_line_id'] ?>').value * <?= $order_line['product']['price'] ?>;
                                    document.getElementById('line_price.<?= $order_line['order_line_id'] ?>').value = Math.round(val * 100) / 100;
                                    computeTotalAmount();
                                });

                                // Récuperation automatique du prix unitaire du produit sélectionné
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Function asynchrone pour récupérer les données du produit
                                    async function getProduct(slug) {
                                        try {
                                            const response = await fetch('<?= APP_URL ?>api/product.php?slug=' + slug);
                                            const data = await response.json();
                                            return data.data[0];
                                        } catch (error) {
                                            console.error('error: ', error);
                                            return {};
                                        }
                                    }

                                    // Timer pour attendre que la page soit chargée
                                    setTimeout(() => {
                                        // Fonction asynchrone pour gérer le changement de sélection du produit
                                        async function handleProductChange(el) {
                                            const slug = el.target.value;

                                            // Récupérer les données du produit
                                            const product = await getProduct(slug); // Attendez la résolution de la promesse

                                            if (product) {
                                                // Remplir le champ de prix avec les données du produit
                                                document.getElementById('product.price.<?= $order_line['order_line_id'] ?>').value = product.price;

                                                // Calculer le prix de la ligne
                                                const quantity = document.getElementById('quantity.<?= $order_line['order_line_id'] ?>').value;
                                                const val = quantity * product.price;
                                                document.getElementById('line_price.<?= $order_line['order_line_id'] ?>').value = Math.round(val * 100) / 100;
                                            } else {
                                                console.error("Le produit est introuvable");
                                            }
                                        }

                                        // Sélectionnez l'élément et ajoutez l'écouteur d'événements
                                        const toWatchEl = document.getElementById('product.product_slug.<?= $order_line['order_line_id'] ?>');
                                        toWatchEl.addEventListener('change', function(el) {
                                            handleProductChange(el); // Appel de la fonction asynchrone
                                            computeTotalAmount();
                                        });
                                    }, 1000);
                                });
                            </script>
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