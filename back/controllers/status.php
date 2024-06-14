<?php

function getStatus($status_id)
{
    $sql = "SELECT * FROM status WHERE status_id = :status_id;";

    $params = array(":status_id" => $status_id);

    $result = Database::queryOne($sql, $params);

    return $result['data'];
}

function getStatuses()
{
    $sql = "SELECT * FROM status";

    $sql .= " WHERE is_deleted = 0";

    $sql .= " ORDER BY sort_order ASC";

    $result = Database::queryAll($sql)['data'];

    return $result;
}

function insertStatus($status)
{

    $sql = "INSERT INTO status (libelle) VALUES (:libelle)";

    $reslut = Database::queryInsert($sql, array(":libelle" => $status['libelle']));

    if ($reslut['success']) {
        log_txt("Status inserted in back office: status_id " . $reslut);
        return $reslut;
    } else {
        return false;
    }
}

function updateStatus($status)
{

    $sql = "UPDATE status SET";

    if (isset($status['libelle'])) $sql .= " libelle = :libelle,";
    if (isset($status['sort_order'])) $sql .= " sort_order = :sort_order,";
    if (isset($status['is_deleted'])) $sql .= " is_deleted = :is_deleted,";

    $sql = rtrim($sql, ","); // Remove last comma

    $sql .= " WHERE status_id = :status_id";

    $params = array();

    if (isset($status['libelle'])) $params[":libelle"] = $status['libelle'];
    if (isset($status['sort_order'])) $params[":sort_order"] = $status['sort_order'];
    if (isset($status['is_deleted'])) $params[":is_deleted"] = $status['is_deleted'];

    $params[":status_id"] = $status['status_id'];

    $reslut = Database::queryUpdate($sql, $params);

    if ($reslut['success']) {
        log_txt("Status updated in back office: status_id " . $status['status_id']);
        return true;
    } else {
        return false;
    }
}

function putToTrashStatus($status_id)
{

    $sql = "UPDATE status SET is_deleted = 1 WHERE status_id = :status_id";

    $params = array(":status_id" => $status_id);

    $reslut = Database::queryUpdate($sql, $params);

    if ($reslut['success']) {
        log_txt("Status deleted in back office: status_id " . $status_id);
        return true;
    } else {
        return false;
    }
}
