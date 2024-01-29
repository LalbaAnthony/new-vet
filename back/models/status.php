<?php

function getStatus($status_id)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM status WHERE status_id = :status_id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":status_id" => $status_id));
        $status = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read status: slug $status_id");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $status;
}

function getStatuses($order_by = 'sort_order', $order = 'ASC')
{
    $dbh = db_connect();

    // Select all statuses
    $sql = "SELECT * FROM status";

    $sql .= " WHERE is_deleted = 0";

    $sql .= " ORDER BY $order_by $order";

    try {
        $sth = $dbh->prepare($sql);

        $sth->execute();

        $statuses = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read statuses");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $statuses;
}

function insertStatus($status)
{
    $dbh = db_connect();

    $sql = "INSERT INTO status (libelle) VALUES (:libelle)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":libelle" => $status['libelle']));
        if ($sth->rowCount() > 0) {
            log_txt("Status registered in back office: status_libelle " . $status['libelle']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function updateStatus($status)
{
    $dbh = db_connect();

    $sql = "UPDATE status SET libelle = :libelle, WHERE status_id = :status_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":libelle" => $status['libelle'], ":status_id" => $status['status_id']));
        if ($sth->rowCount() > 0) {
            log_txt("Status updated in back office: status_id " . $status['status_id']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteStatus($status_id)
{
    $dbh = db_connect();

    $sql = "UPDATE status SET is_deleted = 1 WHERE status_id = :status_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":status_id" => $status_id));
        if ($sth->rowCount() > 0) {
            log_txt("Status deleted in back office: status_id " . $status_id);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}