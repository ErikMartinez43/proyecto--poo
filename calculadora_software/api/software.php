<?php
header('Content-Type: application/json');//indicar que la respuesta sera en formato Json
require_once __DIR__."/../models/Producto.php";
require_once __DIR__."/../models/SoftwareBase.php";
require_once __DIR__."/../config/Database.php";
require_once __DIR__."/../repositorio/SoftwareRepositorio.php";
//crear el repositorio
$repo = new SoftwareRepositorio();

//si la peticion es POST crear un nuevo software
if($_SERVER['REQUEST_METHOD']=='POST'){
    //obtener los datos enviados en json
    $datos = json_decode(file_get_contents('php://input'), true);
    //crear el objeto SofwareBase
    $software = new SoftwareBase(0, $datos['nombre'], $datos['descripcion'], $datos['costo']);
    //guardarlo en la base de datos
    $id = $repo->crearSoftware($software);
    //responder con el id generado
    echo json_encode(['id'=> $id]);
    exit;
}
//si es DELETE eliminar el registro
if($_SERVER['REQUEST_METHOD']== 'DELETE'){
    $id = $_GET['id'];
    $repo->eliminar($id);
    echo json_encode(['mensaje'=>'eliminado'] );
    exit;
}

//si es GET con ID, obtener el sofware con ese Id
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    $software = $repo->obtenerPorId($_GET['id']);
    echo json_encode([
        'id' => $software->getId(),
        'nombre' => $software->getNombre(),
        'descripcion' =>  $software->getDescripcion(),
        'costo' => $software->getCosto()
    ]);
    exit;
}

//si es PUT actualizar software
if($_SERVER['REQUEST_METHOD'] == 'PUT'){
    $id = $_GET['id'];
    $datos = json_decode(file_get_contents('php://input'), true);
 
    $software = new SoftwareBase($id, $datos['nombre'], $datos['descripcion'], $datos['costo']);
    $repo->actualizar($software);
    echo json_encode(['mensaje' => 'actualizado']);
    exit;
}

//recuperando todos los softwares
$softwares = $repo->obtenerTodos();
//convertirlos en un array
$resultado = [];
foreach($softwares as $software){

    /** @var SoftwareBase $software */
    $resultado[] = ['id'=> $software->getId(),
                    'nombre' => $software->getNombre(),
                    'descripcion' => $software->getDescripcion(),
                    'costo' => $software->getCosto()];
}
//responder con Json
echo json_encode($resultado);
