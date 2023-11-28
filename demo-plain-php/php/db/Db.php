<?php

/**
 * This singleton class holds the database connection
 * @author Jeroen Van Aken
 */
class Db {
    const DSN = "mysql:host=localhost;port=3306;dbname=coubooks";
    const USERNAME = 'root';
    const PASSWORD = '20lkbYzt';

    private PDO $connection;
    private static Db $instance;

    /**
     * A private constructor, the object can only be created by the getConnection method
     */
    private function __construct() {
        $this->connection = new PDO(self::DSN,self::USERNAME,self::PASSWORD);
    }

    /**
     * Initialises a new object if it does not exists yet and sets up the connection
     * @return PDO the connection to the mysql server
     */
    public static function getConnection(): PDO {
        if (!isset(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance->connection;
    }

}