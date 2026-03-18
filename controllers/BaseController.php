<?php
class BaseController {
    protected $aulaDAO;
    protected $userDAO;
    protected $plantillaDAO;
    protected $horarioDAO;
    protected $profesorDAO;

    public function __construct() {
        $this->aulaDAO = new AulaDAO();
        $this->userDAO = new UserDAO();
        $this->plantillaDAO = new PlantillaDAO();
        $this->horarioDAO = new HorarioDAO();
        $this->profesorDAO = new ProfesorDAO();
    }

    protected function requireLogin() {
        if(!isset($_SESSION['username'])) {
            View::render("user/login", ['error' => 'Debes iniciar sesion.']);
            exit;
        }
    }

    protected function requireRole($roles) {
        $this->requireLogin();
        if(!in_array($_SESSION['role'], $roles)) {
            header('Location: index.php?action=mostrarAulas');
            exit;
        }
    }

    protected function generarAntenaPorBloque($bloque) {
        $bloque = trim((string)$bloque);
        if($bloque === '') return '';
        preg_match('/([0-9]+)/', $bloque, $matches);
        if(!empty($matches[1])) return 'ANT-' . (int)$matches[1];
        return 'ANT-' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $bloque));
    }

    protected function generarCodigoAntena($etiqueta) {
        $codigo = strtoupper(trim((string)$etiqueta));
        $codigo = preg_replace('/[^A-Z0-9]/', '', $codigo);
        if($codigo === '') return '';
        return 'ANT-'.$codigo;
    }
}
