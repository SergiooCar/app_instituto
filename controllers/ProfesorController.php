<?php
Class ProfesorController extends BaseController {

    function mostrarProfesores($data = []) {
        $this->requireRole(['admin']);
        if(empty($data["listaProfesores"])) {
            $data["listaProfesores"] = $this->profesorDAO->getAll();
        }
        View::render("profesor/all", $data);
    }

    public function formularioCrearProfesor($data=[]) {
        $this->requireRole(['admin']);
        View::render("profesor/crear", $data);
    }

    public function crearProfesor() {
        $this->requireRole(['admin', 'editor']);
        
        $nombre = trim($_POST['nombre']);
        $departamento = trim($_POST['departamento']);
        $direccion_mac = trim($_POST['direccion_mac']);

        $this->profesorDAO->crear([
            'nombre' => $nombre,
            'departamento' => $departamento,
            'direccion_mac' => $direccion_mac
        ]);

        header("Location: index.php?profesores");
        exit;
    }

    public function formularioEditarProfesor() {
        $this->requireRole(['admin', 'editor']);

        $id = (int) ($_GET['id'] ?? 0);
        $data['profesor'] = $this->profesorDAO->get($id);

        if(empty($data['profesor'])) {
            $this->mostrarProfesores();
            return;
        }
        View::render("profesor/editar", $data);
    }

    public function editarProfesor() {
        $this->requireRole(['admin', 'editor']);

        $id = (int) ($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre']);
        $departamento = trim($_POST['departamento']);
        $direccion_mac = trim($_POST['direccion_mac']);
        
        $this->profesorDAO->actualizar($id, [
            'nombre' => $nombre,
            'departamento' => $departamento,
            'direccion_mac' => $direccion_mac
        ]);

        header("Location: index.php?profesores");
        exit;
    }

    public function formularioEliminarProfesor() {
        $this->requireRole(['admin']);

        $id = (int) ($_GET['id'] ?? 0);
        $data['profesor'] = $this->profesorDAO->get($id);

        if(empty($data['profesor'])) {
            $this->mostrarProfesores();
            return;
        }

        View::render("profesor/eliminar", $data);
    }

    public function eliminarProfesor() {
        $this->requireRole(['admin']);

        $id = (int) ($_POST['id'] ?? 0);
        $this->profesorDAO->eliminar($id);

        header("Location: index.php?profesores");
        exit;
    }
}
?>