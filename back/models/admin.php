<?php

function getAdmin($login)
{
    $sql = "SELECT * FROM `admin` WHERE login = :login";

    $reslut = Database::queryOne($sql, array(":login" => $login));

    return $reslut['data'];
}

function getAdmins()
{
    // Select all admins
    $sql = "SELECT * FROM admin";
    $sql .= " WHERE is_deleted = 0";

    $sql .= " ORDER BY created_at DESC";

    $reslut = Database::queryAll($sql);

    return $reslut['data'];
}

function getAdminsCount()
{
    $sql = "SELECT COUNT(*) as count FROM admin WHERE is_deleted = 0";

    $result = Database::queryOne($sql);

    return $result['data']['count'];
}

function insertAdmin($admin)
{
    $sql = "INSERT INTO admin (login, password) VALUES (:login, :password)";

    $reslut = Database::queryInsert($sql, array(":login" => $admin['login'], ":password" => $admin['password']));

    if ($reslut['lastInsertId']) {
        log_txt("Admin inserted in back office: login " . $admin['login']);
        return true;
    } else {
        return false;
    }
}

function autoUpdateLastLoginAdmin($admin_id, $datetime = null)
{
    if (!$datetime) $datetime = date("Y-m-d H:i:s");

    $sql = "UPDATE admin SET last_login = :datetime WHERE admin_id = :admin_id";

    $reslut = Database::queryUpdate($sql, array(":datetime" => $datetime, ":admin_id" => $admin_id));

    if ($reslut['success']) {
        log_txt("Admin last login updated in back office: admin_id $admin_id last_login $datetime");
        return true;
    } else {
        return false;
    }
}

function setHasAccess($login, $has_access = false)
{

    $sql = "UPDATE admin SET has_access = :has_access WHERE login = :login";

    $reslut = Database::queryUpdate($sql, array(":has_access" => $has_access, ":login" => $login));

    if ($reslut['success']) {
        log_txt("Admin has access updated in back office: login $login has_access $has_access");
        return true;
    } else {
        return false;
    }
}

function deleteAdmin($admin_id)
{

    $sql = "UPDATE admin SET is_deleted = 1 WHERE admin_id = :admin_id";

    $reslut = Database::queryUpdate($sql, array(":admin_id" => $admin_id));

    if ($reslut['success']) {
        log_txt("Admin deleted in back office: admin_id $admin_id");
        return true;
    } else {
        return false;
    }
}
