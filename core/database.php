<?php

class DB
{
    protected static $connections = array();
    /**
     * 
     * @param string $connection
     * @return DatabaseConnection
     */
    public static function getConnection($connection = '')
    {
        // Get default connection if not specified
        if (empty($connection) || $connection == null) {
            $connection = 'default';
        }
        
        // Create connection if it has not been created
        if (!isset(DB::$connections[$connection])) {
            DB::$connections[$connection] = new DatabaseConnection(Application::$Configuration->database[$connection]);
        }
        
        return DB::$connections[$connection];
    }
    
    public static function getRedisConnection()
    {
        Predis\Autoloader::register();
        $redisConnection = new Predis\Client();
        return $redisConnection;
    }
}

class DatabaseConnection
{
    protected static $count = 0;
    protected $connection = null;
    protected $transactionLevel = 0;
    protected $rowCount = 0;
    public function __construct($connectionString)
    {
        $driver_options = array(
           PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        );         
        $this->connection = new PDO($connectionString[0], $connectionString[1], $connectionString[2], $driver_options);
    }
    
    /**
     * Get result of the database query
     * 
     * @param string $query A database query string 
     * @param array $param An array of parameter for query's placeholder
     * @return mixed Query result or FALSE if there is no data
     */    
    public function select($query, $param = null)
    {
        $sh = $this->connection->prepare($query);
        
        if (is_array($param)) {
            foreach($param as $key => $value) {
                if (is_array($value)) {
                    $sh->bindValue(':' . $key, $value[0], $value[1]);
                } else {
                    $sh->bindValue(':' . $key, $value);
                }
            }
        }
        
        self::$count++;
        $sh->execute();
        return $sh->fetchAll();
    }
    
    public static function getTotalOfQuery()
    {
        return self::$count;
    }
    
    /**
     * Get a first row data of the query
     * 
     * @param string $query A database query string 
     * @param array $param An array of parameter for query's placeholder
     * @return mixed First row data of the query or FALSE if there is no data
     */
    public function first($query, $param = null)
    {
        $result = $this->select($query, $param);
        
        if ($result) {
            return $result[0];
        }
        
        return false;
    }
    
    /**
     * Execute database query without returning the result
     * 
     * @param type $query A database query string 
     * @param type $param An array of parameter for query's placeholder
     * @return mixed TRUE if there is no error, otherwise FALSE
     */
    public function query($query, $param = null)
    {
        $sh = $this->connection->prepare($query);
        self::$count++;
        
        if (is_array($param)) {
            foreach($param as $key => $value) {
                $sh->bindValue(':' . $key, $value);
            }
        }
        
        $r = $sh->execute();
        $this->rowCount = $sh->rowCount();
        return $r;
    }
	
	public function getLastInsertId()
	{
		return $this->connection->lastInsertId();
	}
    
    /**
     * Wrap group of query into one transaction.
     * 
     * @param type $callback a function that wrap all query in one transaction
     */
    public function transaction($callback)
    {
        $this->beginTransaction();
        
        try {
            $callback($this);
            
            $this->commit();
        } catch (Exception $ex) {
            $this->rollback();
        }
    }
    
    /**
     * Create transaction
     */
    public function beginTransaction()
    {
        if ($this->transactionLevel <= 0) {
            $this->transactionLevel = 0;
            $this->connection->beginTransaction();
        }
        
        $this->transactionLevel++;
    }
    
    /**
     * Rollback all the changes in current transaction
     * 
     * @return boolean
     */
    public function rollback()
    {
        if (--$this->transactionLevel == 0) { 
            return $this->connection->rollback();
        } else {
            throw new Exception("Invalid depth of transaction.");
        }
    }
    public function rowCount(){
        return $this->rowCount;
    }
    /**
     * Commit all the changes.
     * 
     * @return type
     */
    public function commit()
    {
        if (--$this->transactionLevel == 0) {
            $this->connection->commit();
        }
        
        return $this->transactionLevel > 0;
    }
}