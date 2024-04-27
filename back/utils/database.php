<?php

class Database
{
    private static $dbHost = DB_HOST;
    private static $dbName = DB_NAME;
    private static $dbUser = DB_USER;
    private static $dbPass = DB_PASSWORD;

    // ? Might need to add elemnts to these arrays, if error on the type
    private static $forcedStringParams = array(':email', ':password', ':token', ':code', ':name', ':libelle');
    private static $forcedIntParams = array(':per_page', ':offset', ':customer_id', ':admin_id');
    private static $forcedBoolParams = array(':is_deleted');

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

    private static function displayRequest(string $query, array $params, $error = null)
    {
        if ($error) {
            echo '<h4 style="color: red;">Error: </h4>';
            echo $error;
        }

        echo '<h4 style="color: blue;">Query: </h4>';
        echo $query;

        echo '<h4 style="color: green;">Params: </h4>';
        dd($params);
    }

    private static function handleError(string $query, array $params, $error = null)
    {
        if (APP_DEBUG) {
            echo "<h1>Erreur lors de la requête SQL</h1>";
            self::displayRequest($query, $params, $error);
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
                if (is_int($value) || is_float($value) || in_array($key, self::$forcedIntParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_INT);
                } elseif (is_bool($value) || in_array($key, self::$forcedBoolParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                } elseif (is_string($value) || in_array($key, self::$forcedStringParams)) {
                    $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                } elseif (is_null($value)) {
                    $statement->bindValue($key, $value, PDO::PARAM_NULL);
                } else {
                    $statement->bindValue($key, $value);
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
                if (is_int($value) || is_float($value) || in_array($key, self::$forcedIntParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_INT);
                } elseif (is_bool($value) || in_array($key, self::$forcedBoolParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                } elseif (is_string($value) || in_array($key, self::$forcedStringParams)) {
                    $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                } elseif (is_null($value)) {
                    $statement->bindValue($key, $value, PDO::PARAM_NULL);
                } else {
                    $statement->bindValue($key, $value);
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
                if (is_int($value) || is_float($value) || in_array($key, self::$forcedIntParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_INT);
                } elseif (is_bool($value) || in_array($key, self::$forcedBoolParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                } elseif (is_string($value) || in_array($key, self::$forcedStringParams)) {
                    $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                } elseif (is_null($value)) {
                    $statement->bindValue($key, $value, PDO::PARAM_NULL);
                } else {
                    $statement->bindValue($key, $value);
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
                if (is_int($value) || is_float($value) || in_array($key, self::$forcedIntParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_INT);
                } elseif (is_bool($value) || in_array($key, self::$forcedBoolParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                } elseif (is_string($value) || in_array($key, self::$forcedStringParams)) {
                    $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                } elseif (is_null($value)) {
                    $statement->bindValue($key, $value, PDO::PARAM_NULL);
                } else {
                    $statement->bindValue($key, $value);
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
                if (is_int($value) || is_float($value) || in_array($key, self::$forcedIntParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_INT);
                } elseif (is_bool($value) || in_array($key, self::$forcedBoolParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                } elseif (is_string($value) || in_array($key, self::$forcedStringParams)) {
                    $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                } elseif (is_null($value)) {
                    $statement->bindValue($key, $value, PDO::PARAM_NULL);
                } else {
                    $statement->bindValue($key, $value);
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
                if (is_int($value) || is_float($value) || in_array($key, self::$forcedIntParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_INT);
                } elseif (is_bool($value) || in_array($key, self::$forcedBoolParams)) {
                    $statement->bindValue($key, $value, PDO::PARAM_BOOL);
                } elseif (is_string($value) || in_array($key, self::$forcedStringParams)) {
                    $statement->bindValue($key, htmlspecialchars($value), PDO::PARAM_STR);
                } elseif (is_null($value)) {
                    $statement->bindValue($key, $value, PDO::PARAM_NULL);
                } else {
                    $statement->bindValue($key, $value);
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
