<?php

function getAdmin($login)
{
    $dbh = db_connect();
    $sql = "SELECT * FROM `admin` WHERE login = :login";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute(array(":login" => $login));
        $admin = $sth->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #4: " . $e->getMessage());
    }

    return $admin;
}

function getAdmins()
{
    $dbh = db_connect();

    // Select all admins
    $sql = "SELECT * FROM admin";
    $sql .= " WHERE is_deleted = 0";

    $sql .= " ORDER BY created_at DESC";

    try {
        $sth = $dbh->prepare($sql);

        $sth->execute();

        $admins = $sth->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #5: " . $e->getMessage());
    }

    return $admins;
}

function getAdminsCount()
{
    $dbh = db_connect();
    $sql = "SELECT COUNT(*) FROM admin WHERE is_deleted = 0";
    try {
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #6: " . $e->getMessage());
    }

    return $count;
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
        die("Erreur lors de la requête SQL #7: " . $e->getMessage());
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
            log_txt("Admin access changed in back office: login $login has_access $has_access");
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        die("Erreur lors de la requête SQL #8: " . $e->getMessage());
    }
}

function deleteAdmin($login)
{
    $dbh = db_connect();

    $sql = "UPDATE admin SET is_deleted = 1 WHERE login = :login";

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
        die("Erreur lors de la requête SQL #9: " . $e->getMessage());
    }
}
