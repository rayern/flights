<?php

namespace Database;

class Database{
    private $connection, $queryParams, $query, $enableLog = false;
    public function __construct()
    {
    }
    public function table($table){
        $this->queryParams['table'] = $table;
    }
    public function select($select){
        $this->queryParams['select'] = $select;
    }
    public function where($param, $value, $op = "="){
        $this->queryParams['where'] = $param.$op.$value;
    }
    public function order($order){
        $this->queryParams['order'] = $order;
    }
    public function limit($limit){
        $this->queryParams['limit'] = $limit;
    }
    public function get(){
        $this->query = "SELECT ".$this->queryParams['select'].
        " FROM ".$this->queryParams['table'].
        " WHERE ".$this->queryParams['where'].
        " ORDER BY ".$this->queryParams['where'].
        " LIMIT ".$this->queryParams['limit'];
        if($this->enableLog){
            $dbLog = fopen(__DIR__ . "/../storage/log/db.log", "a");
            $txt = date('Y-m-d H:i:s')." | ".$this->query."\n";
            fwrite($dbLog, $txt);
            fclose($myfile);
        }
    }
    public function enableQueryLog(){
        $this->enableLog = true;
    }

    public function insert($params){
        $this->query = "INSERT INTO ".$this->queryParams['table'].'('.array_keys($params).') VALUES ('.array_values($params).')';

    }

    public function update($params){

    }

    public function runSQL(){
        try{
            $dsn = sprintf('mysql:dbname=%s;host=%s', $_ENV['DB_NAME'], $_ENV['DB_HOST']);
            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);

            $statement = $pdo->prepare($this->query);

            $statement->execute(array(
                'name' => $name,
            ));
        }catch(\Exception $e){  
            Echo "Connection failed" . $e->getMessage();  
        }  
    }

}