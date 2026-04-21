<?php
header('Content-Type: application/json');

require_once __DIR__.'/../models/Activacion.php';//para mapear los datos de la tabla activacion y modulo
require_once __DIR__.'/../models/Modulo.php';   //


require_once __DIR__.'/../models/Producto.php';         //
require_once __DIR__.'/../models/SoftwareBase.php';     //
require_once __DIR__.'/../models/SoftwareDecorador.php';//patron decorador
require_once __DIR__.'/../models/Soporte24_7.php';       //
require_once __DIR__.'/../models/BackupPremium.php';     //
require_once __DIR__.'/../models/LicenciaEducativa.php'; //

require_once __DIR__.'/../config/Database.php'; //CONEXION A LA BASE DE DATOS

require_once __DIR__.'/../repositorio/SoftwareRepositorio.php';
require_once __DIR__.'/../repositorio/ModuloRepositorio.php';       //API 
require_once __DIR__.'/../repositorio/ActivacionRepositorio.php';

$repoActivacion = new ActivacionRepositorio();

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $datos = json_decode(file_get_contents('php://input'), true);
    //$activacion = new Activacion(0, $datos['id_software'], $datos['id_modulo']); 
    $id = $repoActivacion->agregarActivacion($datos['id_software'], $datos['id_modulo']);
    echo json_encode(['id'=> $id]);
    exit;
}

if($_SERVER['REQUEST_METHOD']== 'DELETE'){
    $id = $_GET['id'];
    $repoActivacion->eliminar($id);
    echo json_encode(['mensaje'=>'eliminado'] );
    exit;
}

if($_SERVER['REQUEST_METHOD']=='GET' && isset($_GET['id_software'])){
    $repoSoftware = new SoftwareRepositorio();
    $repoModulo = new ModuloRepositorio();

    $software = $repoSoftware->obtenerPorId($_GET['id_software']);
    $activaciones = $repoActivacion->obtenerPorSoftware($_GET['id_software']);

    //mapeo de nombre de moudulo a clase decoradora
    $decoradores = [
        'Soporte 24/7' => Soporte24_7::class,
        'Backup Premium' => BackupPremium::class,
        'Licencia Educativa' => LicenciaEducativa::class

    ];
    $producto = $software;
    $modulosAplicados = [];

    foreach($activaciones as $activacion){
        $modulo = $repoModulo->obtenerPorId($activacion->getIdModulo());
        $nombreModulo = $modulo->getNombre();

        if(isset($decoradores[$nombreModulo])){//si existe el nombre del modulo y es distinto de null
            $clase = $decoradores[$nombreModulo];
            $producto = new $clase($producto);
        }

        $modulosAplicados[] = [
            'id' => $activacion->getId(),
            'id_modulo' => $activacion->getIdModulo(),
            'nombre_modulo' => $nombreModulo
        ];

        
    }

    echo json_encode([
        'activaciones' => $modulosAplicados,
        'total' => $producto->getCosto()
    ]);
    exit;
}