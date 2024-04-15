<?php

class Database
{
    private static $dbHost = DB_HOST;
    private static $dbName = DB_NAME;
    private static $dbUser = DB_USER;
    private static $dbPass = DB_PASSWORD;

    private static $connection = null;

    function __construct()
    {
        self::connect();
    }

    private static function connect()
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUser, self::$dbPass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur lors de la connexion à la base de données: " . $e->getMessage());
            }
        }
    }

    public static function query(string $query, array $params = array())
    {
        self::connect();

        $success = false;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);
            $success = $statement->execute($params);
        } catch (PDOException $e) {
            if (APP_DEBUG) die($error);
            $error = $e->getMessage();
        }

        return array(
            'success' => $success,
            'error' => $error
        );
    }

    public static function queryMultiple(string $query, array $params = array())
    {
        self::connect();

        $data = array();
        $success = false;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);
            $statement->execute($params);

            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            $success = true;
        } catch (PDOException $e) {
            if (APP_DEBUG) die($error);
            $error = $e->getMessage();
        }

        return array(
            'success' => $success,
            'data' => $data,
            'error' => $error
        );
    }

    public static function querySingle(string $query, array $params = array())
    {
        self::connect();

        $data = array();
        $success = false;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);
            $statement->execute($params);

            $data = $statement->fetch(PDO::FETCH_ASSOC);
            $success = true;
        } catch (PDOException $e) {
            if (APP_DEBUG) die($error);
            $error = $e->getMessage();
        }

        return array(
            'success' => $success,
            'data' => $data,
            'error' => $error
        );
    }

    public static function queryCount(string $query, array $params = array())
    {
        self::connect();

        $count = 0;
        $success = false;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);
            $statement->execute($params);

            $count = $statement->fetchColumn();
            $success = true;
        } catch (PDOException $e) {
            if (APP_DEBUG) die($error);
            $error = $e->getMessage();
        }

        return array(
            'success' => $success,
            'count' => $count,
            'error' => $error
        );
    }

    public static function queryInsert(string $query, array $params = array())
    {
        self::connect();

        $id = null;
        $success = false;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);
            $success = $statement->execute($params);

            $id = self::$connection->lastInsertId();
        } catch (PDOException $e) {
            if (APP_DEBUG) die($error);
            $error = $e->getMessage();
        }

        return array(
            'success' => $success,
            'id' => $id,
            'error' => $error
        );
    }

    public static function queryUpdate(string $query, array $params = array())
    {
        self::connect();

        $success = false;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);
            $success = $statement->execute($params);
        } catch (PDOException $e) {
            if (APP_DEBUG) die($error);
            $error = $e->getMessage();
        }

        return array(
            'success' => $success,
            'error' => $error
        );
    }

    public static function queryDelete(string $query, array $params = array())
    {
        self::connect();

        $success = false;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);
            $success = $statement->execute($params);
        } catch (PDOException $e) {
            if (APP_DEBUG) die($error);
            $error = $e->getMessage();
        }

        return array(
            'success' => $success,
            'error' => $error
        );
    }
}
