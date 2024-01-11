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

    $sql .= " ORDER BY :order_by :order";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        $sth->bindValue(":order_by", $order_by);
        $sth->bindValue(":order", $order);

        $sth->execute();

        $statuses = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read statuses");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $statuses;
}