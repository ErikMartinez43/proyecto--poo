<?php
header('Content-Type: application/json');
require_once __DIR__.'/../models/Activacion.php';
require_once __DIR__.'/../config/Database.php';
require_once __DIR__.'/../repositorio/ActivacionRepositorio.php';

$repo = new ActivacionRepositorio();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $datos = json_decode(file_get_contents('php://input'), true);
    //$activacion = new Activacion(0, $datos['id_software'], $datos['id_modulo']);
    $id = $repo->agregarActivacion($datos['id_software'], $datos['id_modulo']);

    echo json_encode(['id'=> $id]);
    exit;
}

if($_SERVER['REQUEST_METHOD']== 'DELETE'){
    $id = $_GET['id'];
    $repo->eliminar($id);
    echo json_encode(['mensaje'=>'eliminado'] );
    exit;
}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['id_software'])){
    $activaciones = $repo->obtenerPorSoftware($_GET['id_software']);
    $resultado = [];
    foreach($activaciones as $activacion){
        $resultado[] = [
            /** @var Activacion $activacion */
                    'id' => $activacion->getId(),
                    'id_software' => $activacion->getIdSoftware(),
                    'id_modulo' => $activacion->getIdModulo()];
    }
    echo json_encode($resultado);
    exit;
}