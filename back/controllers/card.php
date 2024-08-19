<?php

function getCard($card_id)
{
    $sql = "SELECT * FROM card WHERE card_id = :card_id;";

    $params = array(":card_id" => $card_id);

    $result = Database::queryOne($sql, $params);

    return $result['data'];
}

function getCards($customer_id = null)
{
    $sql = "SELECT * FROM card";

    $sql .= " WHERE is_deleted = 0";

    // Filter by customer_id
    if ($customer_id) $sql .= " AND customer_id = :customer_id";

    $params = array();
    if ($customer_id) $params[":customer_id"] = $customer_id;

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function insertCard($card)
{
    $sql = "INSERT INTO card (customer_id, number, expiration_date, first_name, last_name, cvv) VALUES (:customer_id, :number, :expiration_date, :first_name, :last_name, :cvv)";

    $result = Database::queryInsert($sql, array(":customer_id" => $card['customer_id'], ":number" => $card['number'], ":expiration_date" => $card['expiration_date'], ":cvv" => $card['cvv'], ":first_name" => $card['first_name'], ":last_name" => $card['last_name']));

    if ($result['success']) {
        log_txt("Card inserted in back office: card_id " . $result["lastInsertId"]);
        return $result;
    } else {
        return false;
    }
}

function updateCard($card)
{
    $sql = "UPDATE card SET";

    if (isset($card['customer_id'])) $sql .= " customer_id = :customer_id,";
    if (isset($card['number'])) $sql .= " number = :number,";
    if (isset($card['expiration_date'])) $sql .= " expiration_date = :expiration_date,";
    if (isset($card['first_name'])) $sql .= " first_name = :first_name,";
    if (isset($card['last_name'])) $sql .= " last_name = :last_name,";
    if (isset($card['cvv'])) $sql .= " cvv = :cvv,";
    if (isset($card['is_deleted'])) $sql .= " is_deleted = :is_deleted,";

    $sql = rtrim($sql, ","); // Remove last comma

    $sql .= " WHERE card_id = :card_id";

    $params = array();
    if (isset($card['card_id'])) $params[":card_id"] = $card['card_id'];
    if (isset($card['customer_id'])) $params[":customer_id"] = $card['customer_id'];
    if (isset($card['number'])) $params[":number"] = $card['number'];
    if (isset($card['first_name'])) $params[":first_name"] = $card['first_name'];
    if (isset($card['last_name'])) $params[":last_name"] = $card['last_name'];
    if (isset($card['expiration_date'])) $params[":expiration_date"] = $card['expiration_date'];
    if (isset($card['cvv'])) $params[":cvv"] = $card['cvv'];
    if (isset($card['is_deleted'])) $params[":is_deleted"] = $card['is_deleted'];

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Card updated in back office: card_id " . $card['card_id']);
        return true;
    } else {
        return false;
    }
}

function putToTrashCard($card_id)
{

    $sql = "UPDATE card SET is_deleted = 1 WHERE card_id = :card_id";

    $result = Database::queryUpdate($sql, array(":card_id" => $card_id));

    if ($result['success']) {
        log_txt("Card deleted in back office: card_id " . $card_id);
        return true;
    } else {
        return false;
    }
}
