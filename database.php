<?php

class Database {
    private static $dbName = 'ToDoApp';
    private static $dbHost = 'localhost';
    private static $port = '8889';
    private static $dbUsername = 'root';
    private static $dbUserPassword = 'root';
    private static $cont = null;

public static function connect(){
    if ( null == self::$cont ){
        try {
            $arg = "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";port=" . self::$port;
            self::$cont = new PDO (
                $arg, self::$dbUsername, self::$dbUserPassword);

        }catch (PDOException $e) {
            die ($e -> getMessage());
        }
    }
    return self::$cont;
}
public static function disconnect (){
    self::$cont = null ;
}

}

?>