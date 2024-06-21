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