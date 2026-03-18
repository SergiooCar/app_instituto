<?php
class HorarioController extends BaseController {
    public function mostrarHorarios() {
        $this->requireLogin();
        $data["listaAulas"] = $this->aulaDAO->getAll();
        if($this->horarioDAO->existeTablaHorarios()) {
            $data["horarios"] = $this->horarioDAO->getAll();
        } else {
            $data["horarios"] = [];
        }
        View::render("etiqueta/horarios", $data);
    }

    public function formularioCrearHorario() {
        $this->requireRole(['admin', 'editor']);
        $data["listaAulas"] = $this->aulaDAO->getAll();
        View::render("horario/crear", $data);
    }

    public function crearHorario() {
        $this->requireRole(['admin', 'editor']);
        $aula_id = (int) ($_REQUEST['aula_id'] ?? 0);
        if($aula_id > 0) {
            $this->horarioDAO->crear($_REQUEST);
        }
        $this->mostrarHorarios();
    }

    public function formularioEditarHorario() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $data['horario'] = $this->horarioDAO->get($id);
        $data["listaAulas"] = $this->aulaDAO->getAll();
        if(empty($data['horario'])) {
            $this->mostrarHorarios();
            return;
        }
        View::render("horario/editar", $data);
    }

    public function editarHorario() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        if($id > 0) {
            $this->horarioDAO->actualizar($id, $_REQUEST);
        }
        $this->mostrarHorarios();
    }

    public function eliminarHorario() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        if($id > 0) {
            $this->horarioDAO->eliminar($id);
        }
        $this->mostrarHorarios();
    }
}
