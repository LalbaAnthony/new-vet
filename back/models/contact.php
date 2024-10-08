<?php

function getContact($contact_id)
{

    $sql = "SELECT * FROM contact WHERE contact_id = :contact_id";

    $params = array(":contact_id" => $contact_id);

    $result = Database::queryOne($sql, $params);

    return $result['data'];
}

function getContacts($search = null, $sort =  array(array('order' => 'ASC', 'order_by' => 'created_at'), array('order' => 'DESC', 'order_by' => 'email')), $offset = null, $per_page = 10)
{

    $sql = "SELECT DISTINCT contact.* FROM contact 
    LEFT JOIN customer ON customer.customer_id = contact.contact_id";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND contact.is_deleted = 0";

    if ($search) {
        $sql .= " AND (
            customer.first_name LIKE :like_search OR 
            customer.last_name LIKE :like_search OR
            contact.email LIKE :like_search OR
            contact.subject LIKE :like_search OR
            contact.message LIKE :like_search OR
            SOUNDEX(customer.first_name) = SOUNDEX(:soundex_search) OR
            SOUNDEX(customer.last_name) = SOUNDEX(:soundex_search) OR
            SOUNDEX(contact.email) = SOUNDEX(:soundex_search) OR
            SOUNDEX(contact.subject) = SOUNDEX(:soundex_search) OR
            SOUNDEX(contact.message) = SOUNDEX(:soundex_search) 
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

    $params = array();
    if ($search) $params[":search"] = "%" . $search . "%";
    if ($per_page) $params[":per_page"] = $per_page;
    if ($offset) $params[":offset"] = $offset;

    $result = Database::queryAll($sql, $params);

    return $result['data'];
}

function getContactsCount($search = null)
{

    $sql = "SELECT COUNT(DISTINCT contact.contact_id) as count FROM contact 
    LEFT JOIN customer ON customer.customer_id = contact.contact_id";

    // Use WHERE 1 = 1 to be able to add conditions with AND
    $sql .= " WHERE 1 = 1";

    $sql .= " AND contact.is_deleted = 0";

    if ($search) {
        $sql .= " AND (
            customer.first_name LIKE :like_search OR 
            customer.last_name LIKE :like_search OR
            contact.email LIKE :like_search OR
            contact.subject LIKE :like_search OR
            contact.message LIKE :like_search OR
            SOUNDEX(customer.first_name) = SOUNDEX(:soundex_search) OR
            SOUNDEX(customer.last_name) = SOUNDEX(:soundex_search) OR
            SOUNDEX(contact.email) = SOUNDEX(:soundex_search) OR
            SOUNDEX(contact.subject) = SOUNDEX(:soundex_search) OR
            SOUNDEX(contact.message) = SOUNDEX(:soundex_search) 
        )";
    }

    $params = array();
    if ($search) $params[":search"] = "%" . $search . "%";

    $result = Database::queryOne($sql, $params);

    return $result['data']['count'];
}

function insertContact($contact)
{

    if (!isset($contact['customer_id'])) $contact['customer_id'] = null;

    $sql = "INSERT INTO contact (customer_id, email, subject, message) VALUES (:customer_id, :email, :subject, :message)";

    $result = Database::queryInsert($sql, array(":customer_id" => $contact['customer_id'], ":email" => $contact['email'], ":subject" => $contact['subject'], ":message" => $contact['message']));

    if ($result['success']) {
        log_txt("Contact inserted in back office: contact_id " . $result["lastInsertId"]);
        return $result;
    } else {
        return false;
    }
}


function putToTrashContact($contact_id)
{
    $sql = "UPDATE contact SET is_deleted = 1 WHERE contact_id = :contact_id";

    $params = array(":contact_id" => $contact_id);

    $result = Database::queryUpdate($sql, $params);

    if ($result['success']) {
        log_txt("Contact deleted in back office: contact_id " . $contact_id);
        return true;
    } else {
        return false;
    }
}
