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
                if (APP_DEBUG) die("Erreur lors de la connexion à la base de données: " . $e->getMessage());
            }
        }
    }

    private static function handleError($query, $params, $error)
    {
        if (APP_DEBUG) {
            echo "<h1>Erreur lors de la requête SQL</h1>";
            echo '<h4 style="color: red;">Error: </h4>';
            echo $error;
            echo '<h4 style="color: blue;">Query: </h4>';
            echo $query;
            echo '<h4 style="color: green;">Params: </h4>';
            dd($params);
            die();
        }
    }

    public static function query(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                        $statement->bindValue($key, $value, PDO::PARAM_INT);
                        break;
                    case 'boolean':
                        $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                        break;
                    case 'NULL':
                        $statement->bindValue($key, $value, PDO::PARAM_NULL);
                        break;
                    case 'string':
                        $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                        break;
                    default:
                        $statement->bindValue($key, $value);
                        break;
                }
            }

            $success = $statement->execute($params);
        } catch (PDOException $e) {
            $success = false;
            $error = $e->getMessage();
            self::handleError($query, $params, $error);
        }

        return array(
            'success' => $success,
            'error' => $error
        );
    }

    public static function queryAll(string $query, array $params = array())
    {
        self::connect();

        $data = array();
        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                        $statement->bindValue($key, $value, PDO::PARAM_INT);
                        break;
                    case 'boolean':
                        $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                        break;
                    case 'NULL':
                        $statement->bindValue($key, $value, PDO::PARAM_NULL);
                        break;
                    case 'string':
                        $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                        break;
                    default:
                        $statement->bindValue($key, $value);
                        break;
                }
            }

            $statement->execute();

            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $success = false;
            $error = $e->getMessage();
            self::handleError($query, $params, $error);
        }

        return array(
            'success' => $success,
            'data' => $data,
            'error' => $error
        );
    }

    public static function queryOne(string $query, array $params = array())
    {
        self::connect();

        $data = array();
        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                        $statement->bindValue($key, $value, PDO::PARAM_INT);
                        break;
                    case 'boolean':
                        $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                        break;
                    case 'NULL':
                        $statement->bindValue($key, $value, PDO::PARAM_NULL);
                        break;
                    case 'string':
                        $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                        break;
                    default:
                        $statement->bindValue($key, $value);
                        break;
                }
            }

            $statement->execute();

            $data = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $success = false;
            $error = $e->getMessage();
            self::handleError($query, $params, $error);
        }

        return array(
            'success' => $success,
            'data' => $data,
            'error' => $error
        );
    }

    public static function queryInsert(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                        $statement->bindValue($key, $value, PDO::PARAM_INT);
                        break;
                    case 'boolean':
                        $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                        break;
                    case 'NULL':
                        $statement->bindValue($key, $value, PDO::PARAM_NULL);
                        break;
                    case 'string':
                        $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                        break;
                    default:
                        $statement->bindValue($key, $value);
                        break;
                }
            }

            $success = $statement->execute($params);
        } catch (PDOException $e) {
            $success = false;
            $error = $e->getMessage();
            self::handleError($query, $params, $error);
        }

        return array(
            'success' => $success,
            'lastInsertId' => self::$connection->lastInsertId(),
            'error' => $error
        );
    }

    public static function queryUpdate(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                        $statement->bindValue($key, $value, PDO::PARAM_INT);
                        break;
                    case 'boolean':
                        $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                        break;
                    case 'NULL':
                        $statement->bindValue($key, $value, PDO::PARAM_NULL);
                        break;
                    case 'string':
                        $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                        break;
                    default:
                        $statement->bindValue($key, $value);
                        break;
                }
            }

            $success = $statement->execute($params);
        } catch (PDOException $e) {
            $success = false;
            $error = $e->getMessage();
            self::handleError($query, $params, $error);
        }

        return array(
            'success' => $success,
            'error' => $error
        );
    }

    public static function queryDelete(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                switch (gettype($value)) {
                    case 'integer':
                        $statement->bindValue($key, $value, PDO::PARAM_INT);
                        break;
                    case 'boolean':
                        $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                        break;
                    case 'NULL':
                        $statement->bindValue($key, $value, PDO::PARAM_NULL);
                        break;
                    case 'string':
                        $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                        break;
                    default:
                        $statement->bindValue($key, $value);
                        break;
                }
            }

            $success = $statement->execute($params);
        } catch (PDOException $e) {
            $success = false;
            $error = $e->getMessage();
            self::handleError($query, $params, $error);
        }

        return array(
            'success' => $success,
            'error' => $error
        );
    }
}
