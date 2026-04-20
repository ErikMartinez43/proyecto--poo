<?php
header('Content-Type: application/json');//indicar que la respuesta sera en formato Json
//require_once __DIR__."/../models/Producto.php";
require_once __DIR__."/../models/Modulo.php";
require_once __DIR__."/../config/Database.php";
require_once __DIR__."/../repositorio/ModuloRepositorio.php";

$repo = new ModuloRepositorio();
//arreglo de modulos
$modulos = $repo->obtenerTodos();

$resultado =[];
foreach($modulos as $modulo){
    /** @var Modulo $modulo */
    $resultado[] = ['id'=> $modulo->getId(),
                'nombre' => $modulo->getNombre(),
                'costo_adicional' => $modulo->getCosto()];
}
//responder con json
echo json_encode($resultado);