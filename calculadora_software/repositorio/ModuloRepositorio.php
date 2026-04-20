<?php
require_once __DIR__.'/../config/Database.php';
require_once __DIR__.'/../models/Modulo.php';

class ModuloRepositorio {

    private PDO $conexion;

    public function __construct()
    {
        //throw new \Exception('Not implemented');
        $this->conexion = Database::getInstancia()->getConexion();

    }

    public function crearModulo(Modulo $modulo):int
    {
        $sql = "INSERT INTO modulo (nombre, costo_adicional) VALUES (:nombre, :costo)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
                        ':nombre' => $modulo->getNombre(),
                        ':costo' => $modulo->getCosto()]);

        

        return (int) $this->conexion->lastInsertId('modulo_id_seq');

    }

    public function obtenerTodos(){
        $sql = "SELECT*FROM modulo ORDER BY id ";
        $stmt = $this->conexion->query($sql);
        $modulos = [];
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $modulos[] = new Modulo(
                                        $row['id'],
                                        $row['nombre'],
                                        $row['costo_adicional']

            );
        }

        return $modulos;

    }

    public function actualizar(Modulo $modulo){
        $sql = "UPDATE modulo
                SET nombre = :nombre, costo_adicional = :costo
                WHERE id = :id ";
        
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
                            ':nombre' => $modulo->getNombre(),
                            ':costo' => $modulo->getCosto(),
                            ':id' => $modulo->getId()
        ]);

    }

    public function obtenerPorId(int $id):?Modulo{
        $sql = "SELECT * FROM modulo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            return new Modulo($row['id'],
                            $row['nombre'],
                            $row['costo_adicional']);
        }

        return null;
    }

    public function eliminar($id){
        $sql = "DELETE FROM modulo WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute(['id'=> $id]);

    }


}