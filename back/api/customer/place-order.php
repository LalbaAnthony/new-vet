<?php

require_once "../../config.inc.php";
include_once APP_PATH . 'controllers/customer.php';
include_once APP_PATH . 'controllers/order.php';
include_once APP_PATH . 'controllers/product.php';
include_once APP_PATH . 'controllers/card.php';
include_once APP_PATH . 'controllers/address.php';
include_once APP_PATH . 'helpers/email.php';

$POST_data = json_decode(file_get_contents("php://input"), true);

$error = null;
$json = array();

$order = null;
$customer_id = null;
$token = null;
$cart = null;

// check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') $error = "Request method not allowed";

// check if params are valid, 
if (!$error) {
    if (!isset($POST_data['order']) || !$POST_data['order']) $error = "Missing order";
    else $order = $POST_data['order'];

    if (!isset($POST_data['customer_id']) || !$POST_data['customer_id']) $error = "Missing customer_id";
    else $customer_id = $POST_data['customer_id'];

    if (!isset($POST_data['token']) || !$POST_data['token']) $error = "Missing token";
    else $token = $POST_data['token'];

    if (!isset($POST_data['cart']) || !$POST_data['cart']) $error = "Missing cart";
    else $cart = $POST_data['cart'];
}

// Check if user exists
if (!$error) {
    $customer = getCustomer($customer_id);
    if (!$customer) {
        $error = "Utilisateur introuvable";
    }
}

// Check token
if (!$error) {
    if ($customer && $customer['connection_token'] !== $token) {
        $error = "Token invalide";
    }
}

// Check if order is valid
if (!$error) {
    if (!isset($order['shipping_address_id']) || !$order['shipping_address_id']) $error = "Missing shipping_address_id";
    if (!isset($order['billing_address_id']) || !$order['billing_address_id']) $error = "Missing billing_address_id";
    if (!isset($order['card_id']) || !$order['card_id']) $error = "Missing card_id";
}

// Check if card exists
if (!$error) {
    $card = getCard($order['card_id']);
    if (!$card) {
        $error = "Carte non trouvée";
    }
}

// Check if addresses exist
if (!$error) {
    $shipping_address = getAddress($order['shipping_address_id']);
    $billing_address = getAddress($order['billing_address_id']);
    if (!$shipping_address || !$billing_address) {
        $error = "Adresse non trouvée";
    }
}

// Check if cart is valid
if (!$error) {
    foreach ($cart as $slug => $quantity) {
        $product = getProduct($slug);
        if (!$product) {
            $error = "Produit introuvable";
            break;
        }
        if (!(int)$quantity) {
            $error = "Quantité invalide pour le produit " . $product['name'];
            break;
        }
        if ($product['stock_quantity'] < $quantity) {
            $error = "Plus de stock pour le produit " . $product['name'];
            break;
        }
    }
}

// Create order and order lines
if (!$error) {

    $total_amount = 0;
    foreach ($cart as $slug => $quantity) {
        $product = getProduct($slug);
        $total_amount += $product['price'] * $quantity;
    }

    // shipping_address_id already here at this point
    // billing_address_id already here at this point
    // card_id already here at this point
    $order['customer_id'] = $customer_id;
    $order['status_id'] = 1;
    $order['order_date'] = date('Y-m-d H:i:s');
    $order['total_amount'] = $total_amount;

    $order_id = insertOrder($order);
    if (!$order_id) {
        $error = "Error getting order_id";
    } else {
        foreach ($cart as $slug => $quantity) {
            $product = getProduct($slug);
            $order_line = array(
                'order_id' => $order_id,
                'product_slug' => $product['slug'],
                'quantity' => $quantity,
                'unit_price' => $product['price'],
                'line_price' => $quantity * $product['price'],
            );
            $order_line_id = insertOrderLine($order_line);
            if (!$order_line_id) {
                $error = "Error getting order_line_id";
                break;
            }
        }
    }
}

// Update stock
if (!$error) {
    foreach ($cart as $slug => $quantity) {
        $product = getProduct($slug);
        $product['stock_quantity'] -= $quantity;
        updateProduct($product);
    }
}

// Send email
if (!$error) {
    $subject = "Nouvelle commande";
    $message = "Bonjour,<br><br>Vous avez reçu une nouvelle commande.<br><br>Cordialement,<br>L'équipe de " . COMPANY_NAME;
    email(EMAIL_TO_ADMIN, $subject, $message);

    $subject = "Merci pour votre commande";
    $message = "Bonjour,<br><br>Votre commande a été passée avec succès.<br><br>Vous pouvez consulter votre commande sur notre site: <a href='" . FRONT_URL . "/mon-compte/mes-commandes'>ici</a><br><br>Cordialement,<br>L'équipe de " . COMPANY_NAME;
    email($customer["email"], $subject, $message);
}

if (!$error) {
    $json['message'] = 'Votre commande a été passée avec succès';
    $json['status'] = 200;
    $json['error'] = null;
} else {
    $json['status'] = 400;
    $json['error'] = $error;
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-type: application/json; charset=utf-8");

$json = json_encode($json);
echo $json;
