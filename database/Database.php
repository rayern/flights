<?php

namespace Database;

class Database{
    private $queryParams, $query, $enableLog = false;
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
}