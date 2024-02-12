<?php

function getContact($id)
{
    $dbh = db_connect();

    $sql = "SELECT * FROM contact WHERE id = :id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":id" => $id));
        $contact = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $contact;
}

function getContacts()
{
    $dbh = db_connect();

    $sql = "SELECT * FROM contact ORDER BY created_at DESC";

    $sql .= " WHERE is_deleted = 0";

    $sql .= " ORDER BY created_at DESC";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $contacts = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $contacts;
}

function getContactsCount() {
    $dbh = db_connect();
    $sql = "SELECT COUNT(*) FROM contact WHERE is_deleted = 0";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $count;
}

function insertContact($contact)
{
    $dbh = db_connect();

    if(!isset($contact['customer_id'])) $contact['customer_id'] = null;

    $sql = "INSERT INTO contact (customer_id, email, subject, message) VALUES (:customer_id, :email, :subject, :message)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":customer_id" => $contact['customer_id'], ":email" => $contact['email'], ":subject" => $contact['subject'], ":message" => $contact['message']));
        if ($sth->rowCount() > 0) {
            log_txt("Contact registered in back office: customer_id " . $contact['customer_id']);
        } else {
            return "Erreur lors de l'ajout de la demande de contact";
        }
    } catch (PDOException $e) {
        return "Erreur lors de la requête SQL : " . $e->getMessage();
    }
}
