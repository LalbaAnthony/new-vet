<?php

function getAddress($address_id)
{
    $sql = "SELECT * FROM address WHERE address_id = :address_id;";

    $params = array(":address_id" => $address_id);

    $result = Database::queryOne($sql, $params);

    return $result['data'];
}

function getAddresses($customer_id = null, $search = null)
{
    // Select all addresses
    $sql = "SELECT * FROM address";

    $sql .= " WHERE is_deleted = 0";

    // Filter by customer_id
    if ($customer_id) $sql .= " AND customer_id = :customer_id";

    // Filter by search
    if ($search) $sql .= " AND (first_name LIKE :like_search OR last_name LIKE :like_search OR address1 LIKE :like_search OR address2 LIKE :like_search OR city LIKE :like_search OR region LIKE :like_search OR zip LIKE :like_search OR tel LIKE :like_search)";

    $sql .= " ORDER BY zip ASC";

    $params = array();
    if ($customer_id) $params[":customer_id"] = $customer_id;
    if ($search) $params[":search"] = "%" . $search . "%";

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function insertAddress($address)
{
    $sql = "INSERT INTO address (customer_id, first_name, last_name, address1, address2, city, region, zip, country_id, tel) VALUES (:customer_id, :first_name, :last_name, :address1, :address2, :city, :region, :zip, :country_id, :tel)";

    $result = Database::queryInsert($sql, array(":customer_id" => $address['customer_id'], ":first_name" => $address['first_name'], ":last_name" => $address['last_name'], ":address1" => $address['address1'], ":address2" => $address['address2'], ":city" => $address['city'], ":region" => $address['region'], ":zip" => $address['zip'], ":country_id" => $address['country_id'], ":tel" => $address['tel']));

    if ($result['success']) {
        log_txt("Address inserted in back office: address_id " . $result["lastInsertId"]);
        return true;
    } else {
        return false;
    }
}

function updateAddress($address)
{
    $sql = "UPDATE address SET";

    if (isset($address['customer_id'])) $sql .= " customer_id = :customer_id,";
    if (isset($address['first_name'])) $sql .= " first_name = :first_name,";
    if (isset($address['last_name'])) $sql .= " last_name = :last_name,";
    if (isset($address['address1'])) $sql .= " address1 = :address1,";
    if (isset($address['address2'])) $sql .= " address2 = :address2,";
    if (isset($address['city'])) $sql .= " city = :city,";
    if (isset($address['region'])) $sql .= " region = :region,";
    if (isset($address['zip'])) $sql .= " zip = :zip,";
    if (isset($address['country_id'])) $sql .= " country_id = :country_id,";
    if (isset($address['tel'])) $sql .= " tel = :tel,";
    if (isset($address['is_deleted'])) $sql .= " is_deleted = :is_deleted,";

    $sql = rtrim($sql, ","); // cut off the last comma

    $sql .= " WHERE address_id = :address_id";

    $params = array();
    if (isset($address['customer_id'])) $params[":customer_id"] = (string) $address['customer_id'];
    if (isset($address['first_name'])) $params[":first_name"] = (string) $address['first_name'];
    if (isset($address['last_name'])) $params[":last_name"] = (string) $address['last_name'];
    if (isset($address['address1'])) $params[":address1"] = (string) $address['address1'];
    if (isset($address['address2'])) $params[":address2"] = (string) $address['address2'];
    if (isset($address['city'])) $params[":city"] = (string) $address['city'];
    if (isset($address['region'])) $params[":region"] = (string) $address['region'];
    if (isset($address['zip'])) $params[":zip"] = (string) $address['zip'];
    if (isset($address['country_id'])) $params[":country_id"] = (int) $address['country_id'];
    if (isset($address['tel'])) $params[":tel"] = $address['tel'];
    if (isset($address['is_deleted'])) $params[":is_deleted"] = $address['is_deleted'];
    if (isset($address['address_id'])) $params[":address_id"] = $address['address_id'];
    

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Address updated in back office: address_id " . $address['address_id']);
        return true;
    } else {
        return false;
    }
}

function putToTrashAddress($address_id)
{
    $sql = "UPDATE address SET is_deleted = 1 WHERE address_id = :address_id";

    $result = Database::queryUpdate($sql, array(":address_id" => $address_id));

    if ($result['success']) {
        log_txt("Address deleted in back office: address_id " . $address_id);
        return true;
    } else {
        return false;
    }
}
