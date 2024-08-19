<?php

function getCountry($country_id)
{
    $sql = "SELECT * FROM country WHERE country_id = :country_id;";

    $params = array(":country_id" => $country_id);

    $result = Database::queryOne($sql, $params);

    return  $result['data'];
}

function getCountries()
{

    // Select all countries
    $sql = "SELECT * FROM country";

    $sql .= " WHERE is_deleted = 0";

    $sql .= " ORDER BY name ASC";

    $result = Database::queryAll($sql)['data'];

    return $result;
}

function getCountryCount()
{
    $sql = "SELECT COUNT(DISTINCT country.country_id) as count FROM country WHERE is_deleted = 0";

    $result = Database::queryOne($sql);

    return $result['data']['count'];
}

function insertCountry($country)
{

    $sql = "INSERT INTO country (name) VALUES (:name)";

    $result = Database::queryInsert($sql, array(":name" => $country['name']));

    if ($result['success']) {
        log_txt("Country inserted in back office: country_id " . $result["lastInsertId"]);
        return $result;
    } else {
        return false;
    }
}

function updateCountry($country)
{

    $sql = "UPDATE country SET";

    if (isset($country['name'])) $sql .= " name = :name,";
    if (isset($country['is_deleted'])) $sql .= " is_deleted = :is_deleted,";

    $sql = rtrim($sql, ","); // Remove last comma

    $sql .= " WHERE country_id = :country";

    $params = array();

    if (isset($country['name'])) $params[":name"] = $country['name'];
    if (isset($country['is_deleted'])) $params[":is_deleted"] = $country['is_deleted'];

    $params[":country_id"] = $country['country_id'];

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Country updated in back office: country_id " . $country['country_id']);
        return true;
    } else {
        return false;
    }
}

function putToTrashCountry($country_id)
{

    $sql = "UPDATE country SET is_deleted = 1 WHERE country_id = :country_id";

    $params = array(":country_id" => $country_id);

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Country deleted in back office: country_id " . $country_id);
        return true;
    } else {
        return false;
    }
}
