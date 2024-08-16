<?php

/**
 * Classe Database
 * 
 * Cette classe gère la connexion à la base de données et fournit des méthodes pour exécuter des requêtes SQL.
 */
class Database
{
    private static $dbHost = DB_HOST;
    private static $dbName = DB_NAME;
    private static $dbUser = DB_USER;
    private static $dbPass = DB_PASSWORD;

    // ? Might need to add elements to these arrays, if error on the type
    private static $forcedStringParams = array(':email', ':password', ':token', ':code', ':name', ':libelle');
    private static $forcedIntParams = array(':per_page', ':offset', ':customer_id', ':admin_id');
    private static $forcedBoolParams = array(':is_deleted');

    private static $connection = null;

    /**
     * Constructeur de la classe Database.
     * 
     * Initialise la connexion à la base de données.
     */
    function __construct()
    {
        self::connect();
    }

    /**
     * Établit la connexion à la base de données.
     * 
     * @return void
     */
    private static function connect()
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO("mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName, self::$dbUser, self::$dbPass);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                if (defined('APP_DEBUG') && APP_DEBUG) die("Erreur lors de la connexion à la base de données: " . $e->getMessage());
            }
        }
    }

    /**
     * Recompose une requête SQL avec les paramètres donnés.
     * 
     * @param string $query La requête SQL avec des placeholders.
     * @param array $params Les paramètres à remplacer dans la requête.
     * @return void
     */
    private static function getRecomposedRequest(string $query, array $params)
    {
        $recomposedQuery = $query;
        foreach ($params as $key => $value) {
            $recomposedQuery = str_replace($key, "\"" . $value . "\"", $recomposedQuery);
        }
        return $recomposedQuery;
    }

    /**
     * Affiche les informations sur la requête SQL et ses paramètres.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @param mixed $error L'erreur survenue (facultatif).
     * @return void
     */
    public static function displayRequestInfos(string $query, array $params, $error = null)
    {
        // ? Can be very useful to debug SQL queries. 
        // ? Request can so be easily copied and pasted in a Chat GPT to get help.

        if ($error) {
            echo '<h4 style="color: red;">Error: </h4>';
            echo $error;
        }

        echo '<h4 style="color: blue;">Query: </h4>';
        echo $query;

        echo '<h4 style="color: green;">Params: </h4>';
        dd($params);

        echo '<h4 style="color: purple;">Recomposed request with query and params: </h4>';
        echo self::getRecomposedRequest($query, $params);
    }

    /**
     * Gère les erreurs survenant lors de l'exécution d'une requête SQL.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @param mixed $error L'erreur survenue (facultatif).
     * @return void
     */
    private static function handleError(string $query, array $params, $error = null)
    {
        if (defined('APP_DEBUG') && APP_DEBUG) {
            echo "<h1>Erreur lors de la requête SQL</h1>";
            self::displayRequestInfos($query, $params, $error);
            die();
        }
    }

    /**
     * Exécute une requête SQL.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @return array Un tableau contenant le statut de succès et l'erreur éventuelle.
     */
    public static function query(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                if (is_int($value) || in_array($key, self::$forcedIntParams)) {
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

    /**
     * Exécute une requête SQL et retourne tous les résultats.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @return array Un tableau contenant le statut de succès, les données et l'erreur éventuelle.
     */
    public static function queryAll(string $query, array $params = array())
    {
        self::connect();

        $data = array();
        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                if (is_int($value) || in_array($key, self::$forcedIntParams)) {
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

    /**
     * Exécute une requête SQL et retourne un seul résultat.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @return array Un tableau contenant le statut de succès, les données et l'erreur éventuelle.
     */
    public static function queryOne(string $query, array $params = array())
    {
        self::connect();

        $data = array();
        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                if (is_int($value) || in_array($key, self::$forcedIntParams)) {
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

    /**
     * Exécute une requête SQL d'insertion.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @return array Un tableau contenant le statut de succès, l'ID du dernier enregistrement inséré et l'erreur éventuelle.
     */
    public static function queryInsert(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                if (is_int($value) || in_array($key, self::$forcedIntParams)) {
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

    /**
     * Exécute une requête SQL de mise à jour.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @return array Un tableau contenant le statut de succès et l'erreur éventuelle.
     */
    public static function queryUpdate(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                if (is_int($value) || in_array($key, self::$forcedIntParams)) {
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

    /**
     * Exécute une requête SQL de suppression.
     * 
     * @param string $query La requête SQL.
     * @param array $params Les paramètres de la requête.
     * @return array Un tableau contenant le statut de succès et l'erreur éventuelle.
     */
    public static function queryDelete(string $query, array $params = array())
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $statement = self::$connection->prepare($query);

            foreach ($params as $key => $value) {
                if (is_int($value) || in_array($key, self::$forcedIntParams)) {
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

    /**
     * Récupère le nom de la base de données.
     * 
     * @return array Un tableau contenant le statut de succès et l'erreur éventuelle.
     */
    public static function queryGetDbName()
    {
        self::connect();

        $success = true;
        $error = null;

        try {
            $query = "SELECT DATABASE() AS db_name";
            $statement = self::$connection->prepare($query);
            $statement->execute();
            $data = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $success = false;
            $error = $e->getMessage();
            self::handleError($query, array(), $error);
        }

        return array(
            'success' => $success,
            'data' => $data,
            'error' => $error
        );
    }
}
