<?php

namespace Database;

class Database{
    private $connection, $queryParams, $params, $query;
    public function __construct(){
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
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
    }
    public function select($select){
        $this->queryParams['select'] = $select;
    }
    public function where($param, $value, $op = "="){
        $this->queryParams['whereQuery'][] = $param.$op.':'.$param;
        $this->params[$param] = $value;
    }
    public function order($order){
        $this->queryParams['order'] = $order;
    }
    public function limit($limit){
        $this->queryParams['limit'] = $limit;
    }
    public function applyWhere(){
    }
    public function get(){
        $this->query = "SELECT ".$this->queryParams['select'].
        " FROM ".$this->queryParams['table'];
        if(is_array(this->queryParams['whereQuery'])){
            $this->query .= " WHERE ";
            foreach(this->queryParams['whereQuery'] as $whereQuery){
                $this->query .= $whereQuery." and ";
            }
            $this->query = rtrim($this->query," and ");
        }
        $this->query .= "ORDER BY ".$this->queryParams['where'].
        " LIMIT ".$this->queryParams['limit'];
        return $this->run($this->query, $this->params)->fetchAll();
    }

    public function insert($params){
        $this->query = "INSERT INTO ".$this->queryParams['table'].' ('.implode(",",array_keys($params)).') VALUES ('.implode(",",preg_filter('/^/', ':',array_keys($params))).')';
    }

    public function update($params){
        $this->query = "UPDATE ".$this->queryParams['table'].' SET '.implode(",", array_keys($params)).' WHERE ('.preg_filter('/^/', ':',array_keys($params)).')';
    }
    
    public function run($sql, $args = NULL)
    {
        if (!$args)
        {
            return $this->connection->query($sql);
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
