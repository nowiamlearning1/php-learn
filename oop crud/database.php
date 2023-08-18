<?php

use LDAP\Result;

class Database{

    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_pass = '';
    private $db_name = 'testing';

    private $conn= false;
    private $mysqli= '';
    private $result= array();

    public function __construct()
    {
        if(!$this->conn){
            $this->mysqli= new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            $this->conn= true;
            if($this->mysqli->connect_error){
                array_push($this->result, $this->mysqli->connect_error);

            }

        }else{
            return true;

        } 
        
    }

    public function insert($table, $params= array()) {
        if($this->tableExist($table)){
            // print_r($params);            
            $table_column= implode(', ', array_keys($params));
            $table_values= implode("', '", $params);
            $sql= "insert into $table($table_column) values('$table_values')";
            // echo $sql;
            if($this->mysqli->query($sql)){
                array_push($this->result, $this->mysqli->insert_id);
                return true;
            }
            else{
                array_push($this->result, $this->mysqli->error);
                return false;

            }

        }
        else{
            return false;
        }
        
    }

    private function tableExist($table) {
        $sql="show tables from $this->db_name like '$table'";
        $tableIndb= $this->mysqli->query($sql);
        if($tableIndb){
            if($tableIndb->num_rows == 1){
                return true;
            }
            else{
                array_push($this->result, $table . 'does not exist in database.');
                return false;
            }
        }
        
    }

    public function getResult(){

        $val= $this->result;
        $this->result= array();
        return $val;
        
    }


    public function __destruct()
    {
        if($this->conn){
            if($this->mysqli->close()){
                $this->conn = false;
            }

            return true;
        }
        else{
            return false;

        }
    }
}
?>