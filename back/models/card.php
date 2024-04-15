<?php

function getCard($card_id)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM card WHERE card_id = :card_id;";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":card_id" => $card_id));
        $card = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #621: " . $e->getMessage());
    }

    return $card;
}

function getCards()
{
    $dbh = db_connect();

    // Select all cards
    $sql = "SELECT * FROM card";

    $sql .= " WHERE is_deleted = 0";

    $sql .= " ORDER BY sort_order ASC";

    try {
        $sth = $dbh->prepare($sql);

        $sth->execute();

        $cards = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #631: " . $e->getMessage());
    }

    return $cards;
}


function insertCard($card)
{
    $dbh = db_connect();

    $sql = "INSERT INTO card (customer_id, number, expiration_date, cvv) VALUES (:customer_id, :number, :expiration_date, :cvv)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $card['customer_id'], ":number" => $card['number'], ":expiration_date" => $card['expiration_date'], ":cvv" => $card['cvv']));
        if ($sth->rowCount() > 0) {
            log_txt("Card registered in back office: card_libelle " . $card['libelle']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #641: " . $e->getMessage());
    }
}

function updateCard($card)
{
    $dbh = db_connect();

    $sql = "UPDATE card SET customer_id = :customer_id, number = :number, expiration_date = :expiration_date, cvv = :cvv WHERE card_id = :card_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $card['customer_id'], ":number" => $card['number'], ":expiration_date" => $card['expiration_date'], ":cvv" => $card['cvv'], ":card_id" => $card['card_id']));
        if ($sth->rowCount() > 0) {
            log_txt("Card updated in back office: card_id " . $card['card_id']);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #651: " . $e->getMessage());
    }
}

function deleteCard($card_id)
{
    $dbh = db_connect();

    $sql = "UPDATE card SET is_deleted = 1 WHERE card_id = :card_id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":card_id" => $card_id));
        if ($sth->rowCount() > 0) {
            log_txt("Card deleted in back office: card_id " . $card_id);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #661: " . $e->getMessage());
    }
}
