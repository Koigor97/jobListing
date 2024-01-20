<?php

class Database {
    public $connection;

    /**
     * Constructor for database class
     * 
     * @param array $config
     */
    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset=utf8";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->connection = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed " . $e->getMessage());
        }
    }

    /**
     * This method execute a query
     * 
     * @param string $query
     * 
     * @return PDOStatement
     * @thros PDOException
     */
    
}