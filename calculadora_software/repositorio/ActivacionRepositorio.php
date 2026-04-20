<?php
require_once __DIR__.'/../config/Database.php';
require_once __DIR__.'/../models/Activacion.php';

class ActivacionRepositorio {

    private PDO $conexion;

    public function __construct()
    {
        //throw new \Exception('Not implemented');
        $this->conexion = Database::getInstancia()->getConexion();

    }

    public function agregarActivacion(int $id_software, int $id_modulo ):int
    {
        $sql = "INSERT INTO activacion (id_software, id_modulo) VALUES (:id_software, :id_modulo)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
                        ':id_software' => $id_software,
                        ':id_modulo' => $id_modulo]);

        

        return (int) $this->conexion->lastInsertId('activacion_id_seq');

    }

   /* public function obtenerTodos(){
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

    }*/

    public function obtenerPorSoftware(int $id_software):array{
        $sql = "SELECT * FROM activacion WHERE id_software = :id_software";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([':id_software' => $id_software]);
        $activaciones = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $activaciones[] = new Activacion($row['id'],
                                    $row['id_software'],
                                    $row['id_modulo']);
        }


        return $activaciones;
        
    }

    public function eliminar($id){
        $sql = "DELETE FROM activacion WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute(['id'=> $id]);

    }



}