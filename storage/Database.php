<?php

namespace Storage;

class Database{
    private $connection, $queryParams, $queryArgs, $query;
    public function __construct(){
        $default_options = [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_CLASS,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ];
        $dsn = sprintf('mysql:dbname=%s;host=%s', $_ENV['DB_NAME'], $_ENV['DB_HOST']);
        try {
            $this->connection = new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function table($table){
        $this->queryParams['table'] = $table;
        return $this;
    }
    public function select($select){
        $this->queryParams['select'] = $select;
        return $this;
    }
    public function where($filter, $value, $op = '=', $param = ''){
        if(!$param) $param = $filter;
        $this->queryParams['whereQuery'][] = $filter.$op.':'.$param;
        $this->queryArgs[$param] = $value;
        return $this; 
    }
    public function order($order){
        $this->queryParams['order'] = $order;
        return $this;
    }
    public function limit($limit){
        $this->queryParams['limit'] = $limit;
        return $this;
    }
    public function get(){
        $this->query = "SELECT ".$this->queryParams['select'].
        " FROM ".$this->queryParams['table'];
        if(is_array($this->queryParams['whereQuery'])){
            $this->query .= " WHERE ";
            foreach($this->queryParams['whereQuery'] as $key => $whereQuery){
                $this->query .= $whereQuery;
                if ($key != array_key_last($this->queryParams['whereQuery'])) {
                    $this->query .= " and ";
                }
            }
        }
        if(isset($this->queryParams['order'])){
            $this->query .= "ORDER BY ".$this->queryParams['order'];
        }
        if(isset($this->queryParams['limit'])){
            $this->query .= "LIMIT ".$this->queryParams['limit'];
        }
        return $this->run()->fetchAll(\PDO::FETCH_CLASS);
    }

    public function reset(){
        $this->query = "";
        $this->queryArgs = [];
        $this->queryParams = [];
    }

    public function insert($params){
        $this->query = "INSERT INTO ".$this->queryParams['table'].' ('.implode(",",array_keys($params)).') VALUES ('.implode(",",preg_filter('/^/', ':',array_keys($params))).')';
        $this->queryArgs = $params;
        $this->run();
    }

    public function update($params){
        $this->query = "UPDATE ".$this->queryParams['table'].' SET '.implode(",", array_keys($params)).' WHERE ('.preg_filter('/^/', ':',array_keys($params)).')';
        $this->queryArgs = $params;
        $this->run();
    }
    
    public function run()
    {
        try {
            if (!$this->queryArgs)
            {
                return $this->connection->query($this->query);
            }
            $stmt = $this->connection->prepare($this->query);
            $stmt->execute($this->queryArgs);
            $this->reset();
            return $stmt;
        } catch (\PDOException $e) {
            echo json_encode([$this->query, $this->queryArgs]);
            $this->reset();
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
