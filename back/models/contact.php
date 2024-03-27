<?php

function getContact($id)
{
    $dbh = db_connect();

    $sql = "SELECT * FROM contact WHERE contact_id = :id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":id" => $id));
        $contact = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $contact;
}

function getContacts($search = null, $sort =  array(array('order' => 'ASC', 'order_by' => 'created_at'), array('order' => 'DESC', 'order_by' => 'email')), $offset = null, $per_page = 10)
{
    $dbh = db_connect();

    $sql = "SELECT contact.* FROM contact 
    LEFT JOIN customer ON customer.customer_id = contact.contact_id";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND contact.is_deleted = 0";

    if ($search) {
        $sql .= " AND (
            customer.first_name LIKE :search OR 
            customer.last_name LIKE :search OR
            contact.email LIKE :search OR
            contact.subject LIKE :search OR
            contact.message LIKE :search OR
            SOUNDEX(customer.first_name) = SOUNDEX(:search) OR
            SOUNDEX(customer.last_name) = SOUNDEX(:search) OR
            SOUNDEX(contact.email) = SOUNDEX(:search) OR
            SOUNDEX(contact.subject) = SOUNDEX(:search) OR
            SOUNDEX(contact.message) = SOUNDEX(:search) 
        )";
    }

    if ($sort) {
        $sql .= " ORDER BY ";
        foreach ($sort as $key => $value) {
            $sql .= "COALESCE(contact." . $value['order_by'] . ", 9999999) " . strtoupper($value['order']); // COALESCE to avoid NULL values
            if ($key < count($sort) - 1) $sql .= ", ";
        }
    }

    // Limit and offset
    if ($per_page) $sql .= " LIMIT :per_page";
    if ($offset) $sql .= " OFFSET :offset";

    try {
        $sth = $dbh->prepare($sql);

        // Bind others values
        if ($search) $sth->bindValue(":search", "%$search%");
        if ($per_page) $sth->bindValue(":per_page", $per_page, PDO::PARAM_INT);
        if ($offset) $sth->bindValue(":offset", $offset, PDO::PARAM_INT);

        $sth->execute();
        $contacts = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $sql);
    }

    return $contacts;
}

function getContactsCount($search = null)
{
    $dbh = db_connect();

    $sql = "SELECT COUNT(contact_id) as count FROM contact 
    LEFT JOIN customer ON customer.customer_id = contact.contact_id";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND contact.is_deleted = 0";
    if ($search) {
        $sql .= " AND (
            customer.first_name LIKE :search OR 
            customer.last_name LIKE :search OR
            contact.email LIKE :search OR
            contact.subject LIKE :search OR
            contact.message LIKE :search OR
            SOUNDEX(customer.first_name) = SOUNDEX(:search) OR
            SOUNDEX(customer.last_name) = SOUNDEX(:search) OR
            SOUNDEX(contact.email) = SOUNDEX(:search) OR
            SOUNDEX(contact.subject) = SOUNDEX(:search) OR
            SOUNDEX(contact.message) = SOUNDEX(:search) 
        )";
    }

    try {
        $sth = $dbh->prepare($sql);

        // Bind others values
        if ($search) $sth->bindValue(":search", "%$search%");

        $sth->execute();
        $count = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $sql);
    }

    return $count['count'];
}

function insertContact($contact)
{
    $dbh = db_connect();

    if (!isset($contact['customer_id'])) $contact['customer_id'] = null;

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


function deleteContact($id)
{
    $dbh = db_connect();
    $sql = "UPDATE contact SET is_deleted = 1 WHERE contact_id = :id";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":id" => $id));
        if ($sth->rowCount() > 0) {
            log_txt("Product deleted in back office: slug " . $id);
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
