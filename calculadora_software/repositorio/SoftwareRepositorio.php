<?php
require_once __DIR__.'/../config/Database.php';
require_once __DIR__.'/../models/SoftwareBase.php';

class SoftwareRepositorio {

    private PDO $conexion;

    public function __construct()
    {
        //throw new \Exception('Not implemented');
        $this->conexion = Database::getInstancia()->getConexion();

    }

    public function crearSoftware(SoftwareBase $software):int
    {
        $sql = "INSERT INTO software (nombre, descripcion, costo) VALUES (:nombre, :descripcion, :costo)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
                        ':nombre' => $software->getNombre(),
                        ':descripcion' => $software->getDescripcion(),
                        ':costo' => $software->getCosto()]);

        

        return (int) $this->conexion->lastInsertId('software_id_seq');

    }

    public function obtenerTodos(){
        $sql = "SELECT*FROM software ORDER BY id ";
        $stmt = $this->conexion->query($sql);
        $softwares = [];
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $softwares[] = new SoftwareBase(
                                        $row['id'],
                                        $row['nombre'],
                                        $row['descripcion'],
                                        $row['costo']

            );
        }

        return $softwares;

    }

    public function actualizar(SoftwareBase $software){
        $sql = "UPDATE software 
                SET nombre = :nombre, descripcion = :descripcion, costo = :costo
                WHERE id = :id ";
        
        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
                            ':nombre' => $software->getNombre(),
                            ':descripcion' => $software->getDescripcion(),
                            ':costo' => $software->getCosto(),
                            ':id' => $software->getId()
        ]);

    }

    public function obtenerPorId(int $id):?SoftwareBase{
        $sql = "SELECT * FROM software WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row){
            return new SoftwareBase($row['id'],
                                     $row['nombre'],
                                     $row['descripcion'],
                                     $row['costo']);
        }

        return null;
    }

    public function eliminar($id){
        $sql = "DELETE FROM software WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        
        return $stmt->execute(['id'=> $id]);

    }


}