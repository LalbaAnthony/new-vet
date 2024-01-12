<?php

function getAdmin($login)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM `admin` WHERE login = :login";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":login" => $login));
        $admin = $sth->fetch(PDO::FETCH_ASSOC);
        log_txt("Read admin: login $login");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $admin;
}

function getAdmins($order_by = 'login', $order = 'ASC')
{
    $dbh = db_connect();

    // Select all admins
    $sql = "SELECT * FROM admin";

    $sql .= " ORDER BY :order_by :order";

    try {
        $sth = $dbh->prepare($sql);

        // Bind values
        $sth->bindValue(":order_by", $order_by);
        $sth->bindValue(":order", $order);

        $sth->execute();

        $admins = $sth->fetchAll(PDO::FETCH_ASSOC);
        log_txt("Read admins");
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }

    return $admins;
}

function insertAdmin($login, $password)
{
    $dbh = db_connect();

    $sql = "INSERT INTO admin (login, password) VALUES (:login, :password)";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":login" => $login, ":password" => password_hash($password, PASSWORD_BCRYPT)));
        if ($sth->rowCount() > 0) {
            log_txt("Admin registered in back office: login $login");
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function setHasAccess($login, $has_access = false)
{
    $dbh = db_connect();

    $sql = "UPDATE admin SET has_access = :has_access WHERE login = :login";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":login" => $login, ":has_access" => $has_access));
        if ($sth->rowCount() > 0) {
            log_txt("Admin access changed in back office: login $login has_access = $has_access");
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}

function deleteAdmin($login)
{
    $dbh = db_connect();

    $sql = "DELETE FROM admin WHERE login = :login";

    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":login" => $login));
        if ($sth->rowCount() > 0) {
            log_txt("Admin deleted in back office: login $login");
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL : " . $e->getMessage());
    }
}
