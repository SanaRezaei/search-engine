<?php

class Database {
    private  $dbName = 'testDB';
    private  $dbHost = 'localhost';
    private  $port = '8889';
    private  $dbUsername = 'root';
    private  $dbUserPassword = 'root';
    private  $cont = null;
    private  $db;

    function __construct() {
        $this->db = $this->connect();
    }

    public  function connect(){
        if ( null == $this->cont ){
            try {
                $arg = "mysql:host=" . $this->dbHost . ";dbname=" . $this->dbName . ";port=" . $this->port;
                $this->cont = new PDO (
                    $arg, $this->dbUsername, $this->dbUserPassword);

            }catch (PDOException $e) {
                die ($e -> getMessage());
            }
        }
        return $this->cont;
    }
    public function disconnect (){
        $this->cont = null ;
    }

    public function getCurrentUser() {
        
        $id = get_current_user_id();
        $sql = "SELECT * FROM wp_users where ID=?"; 
        return $this->query($sql, [$id]);
        // $result = $this->db->prepare($sql); 
        // $result->execute([get_current_user_id()]); 
        // return $result->fetch(); 
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM wp_users where ID=?"; 
        $res = $this->query($sql, [$id]);
        if (isset($res) && count($res)>0){
            return $res;
        }
        else {
            return null;
        }
    }
    /**
     * @param sql: sql string query
     * @param params: array of query parameters filling ? marks in sql query
     */
    public function query($sql, array $params){
        $q = $this->db->prepare($sql);
        $q->execute($params); 
        $data = $q->fetchAll();
        return $data;
    }
}

?>