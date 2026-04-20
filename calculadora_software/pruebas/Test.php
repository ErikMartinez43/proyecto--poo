<?php
require_once 'config/Database.php';
require_once 'models/Producto.php';
require_once 'models/SoftwareBase.php';
require_once 'models/SoftwareDecorador.php';
require_once 'models/BackupPremium.php';
require_once 'models/LicenciaEducativa.php';
require_once 'models/Soporte24_7.php';
require_once 'repositorio/ActivacionRepositorio.php';
require_once 'repositorio/ModuloRepositorio.php';
require_once 'repositorio/SoftwareRepositorio.php';

$db = Database::getInstancia()->getConexion();
echo "conexion exitosa\n";

$software_repo = new SoftwareRepositorio();
$software = new SoftwareBase(1, "SysControl","Sistema de control", 100.00);
//$id = $software_repo->crearSoftware($software);
echo $software->getDescripcion()." -$ ". $software->getCosto()."\n";
//echo "Sofware creado con ID: $id\n";
//obteniendo el software de la BD con el id
//$software = $software_repo->obtenerPorId($id);

//agregando funcionalidades
$software = new Soporte24_7($software);

$software = new BackupPremium($software);

$software = new LicenciaEducativa($software);
echo $software->getNombre()." -$ ". $software->getCosto()."\n";

//actualizar registro en el indice 2
$softwareActualizado = new SoftwareBase(2, "Syscontrol pro", "sistema de control de java avanzado", 150.0);
$software_repo->actualizar($softwareActualizado);
echo "software actualizado\n";

//verificar
$software = $software_repo->obtenerPorId(2);
echo $software->getNombre()." -$ ". $software->getCosto()."\n";




