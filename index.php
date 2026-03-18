<?php
include_once("models/aulaDAO.php");
include_once("models/userDAO.php");
include_once("models/plantillaDAO.php");
include_once("models/horarioDAO.php");
include_once("models/profesorDAO.php");
include_once("view.php");
require_once __DIR__ . "/controllers/BaseController.php";
require_once __DIR__ . "/controllers/LoginController.php";
require_once __DIR__ . "/controllers/InicioController.php";
require_once __DIR__ . "/controllers/AulaController.php";
require_once __DIR__ . "/controllers/EtiquetaController.php";
require_once __DIR__ . "/controllers/HorarioController.php";
require_once __DIR__ . "/controllers/PlantillaController.php";
require_once __DIR__ . "/controllers/ImportarController.php";
require_once __DIR__ . "/controllers/UsuarioController.php";
require_once __DIR__ . "/controllers/ProfesorController.php";

session_start();

$action = 'mostrarProfesores';
if (isset($_REQUEST["action"])) {
    $action = $_REQUEST["action"];
} else {
    if(isset($_SESSION['username'])) {
        $action = "mostrarAulas";
    } else {
        $action = "formularioLogin";
    }
}

$routes = [
    'formularioLogin' => 'LoginController',
    'validarUser' => 'LoginController',
    'formularioRecuperarPassword' => 'LoginController',
    'recuperarPassword' => 'LoginController',
    'salir' => 'LoginController',

    'mostrarInicio' => 'InicioController',

    'mostrarAulas' => 'AulaController',
    'formularioCrearAula' => 'AulaController',
    'crearAula' => 'AulaController',
    'formularioEditarAula' => 'AulaController',
    'editarAula' => 'AulaController',
    'formularioEliminarAula' => 'AulaController',
    'eliminarAula' => 'AulaController',

    'mostrarEtiquetas' => 'EtiquetaController',
    'emparejarAula' => 'EtiquetaController',
    'desemparejarAula' => 'EtiquetaController',
    'mostrarEstado' => 'EtiquetaController',

    'mostrarHorarios' => 'HorarioController',
    'formularioCrearHorario' => 'HorarioController',
    'crearHorario' => 'HorarioController',
    'formularioEditarHorario' => 'HorarioController',
    'editarHorario' => 'HorarioController',
    'eliminarHorario' => 'HorarioController',

    'mostrarPlantillas' => 'PlantillaController',
    'crearPlantilla' => 'PlantillaController',
    'eliminarPlantilla' => 'PlantillaController',

    'formularioImportarCSV' => 'ImportarController',
    'importarCSV' => 'ImportarController',

    'mostrarUsuarios' => 'UsuarioController',
    'crearUsuario' => 'UsuarioController',
    'cambiarRol' => 'UsuarioController',
    'actualizarUsuario' => 'UsuarioController',
    'resetPasswordUsuario' => 'UsuarioController',
    'eliminarUsuario' => 'UsuarioController',
    'atenderSolicitudRecuperacion' => 'UsuarioController',

    'mostrarProfesores' => 'ProfesorController'
];

if(!isset($routes[$action])) {
    $action = isset($_SESSION['username']) ? 'mostrarAulas' : 'formularioLogin';
}
$action = 'mostrarProfesores';


$controllerClass = $routes[$action];
$controller = new $controllerClass();
$controller->$action();

