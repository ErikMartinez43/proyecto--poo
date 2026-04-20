<?php

use Pdo\Pgsql;

class Database {
    private static ?Database $instancia = null;
    private PDO $conexion;

    private function __construct()
    {
        //throw new \Exception('Not implemented');
        $host = "localhost";
        $port = "5432";
        $dbname = "calculadora_software";
        $user  = "postgres";
        $password = "admin";
        try{
            $this->conexion = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die("Error de conexion". $e->getMessage());
        }    
    }

    public static function getInstancia(){
        if (self::$instancia == null){
            self::$instancia = new Database();
        }
        return self::$instancia;
    }

    public function getConexion(): PDO {
        return $this->conexion;
    }
}
?>