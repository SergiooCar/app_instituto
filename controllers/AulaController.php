<?php
class AulaController extends BaseController {
    public function mostrarAulas() {
        $this->requireLogin();
        $data["listaAulas"] = $this->aulaDAO->getAll();
        if($this->horarioDAO->existeTablaHorarios()) {
            $data["horarios"] = $this->horarioDAO->getAll();
        } else {
            $data["horarios"] = [];
        }
        $data['mensaje'] = $_SESSION['flash_mensaje'] ?? '';
        $data['error'] = $_SESSION['flash_error'] ?? '';
        unset($_SESSION['flash_mensaje'], $_SESSION['flash_error']);
        View::render("aula/all", $data);
    }

    public function formularioCrearAula() {
        $this->requireRole(['admin', 'editor']);
        View::render("aula/crear");
    }

    public function crearAula() {
        $this->requireRole(['admin', 'editor']);
        $aula = trim($_REQUEST['aula'] ?? ($_REQUEST['nombre'] ?? ''));
        if($aula !== '') {
            $datos = $_REQUEST;
            $datos['etiqueta_codigo'] = '';
            $datos['antena_codigo'] = $this->generarAntenaPorBloque($datos['bloques'] ?? '');
            $datos['emparejada'] = 0;
            $datos['solo_logo'] = isset($_REQUEST['solo_logo']) ? 1 : 0;
            $this->aulaDAO->crear($datos);
        }
        $this->mostrarAulas();
    }

    public function formularioEditarAula() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $data['aula'] = $this->aulaDAO->get($id);
        if(empty($data['aula'])) {
            $this->mostrarAulas();
            return;
        }
        View::render("aula/editar", $data);
    }

    public function editarAula() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $aula = trim($_REQUEST['aula'] ?? ($_REQUEST['nombre'] ?? ''));
        if($id > 0 && $aula !== '') {
            $aulaActual = $this->aulaDAO->get($id);
            if(!empty($aulaActual)) {
                $datos = $_REQUEST;
                $datos['etiqueta_codigo'] = $aulaActual->etiqueta_codigo;
                if((int)$aulaActual->emparejada === 0) {
                    $datos['antena_codigo'] = $this->generarAntenaPorBloque($datos['bloques'] ?? '');
                } else {
                    $datos['antena_codigo'] = $aulaActual->antena_codigo;
                }
                $datos['emparejada'] = $aulaActual->emparejada;
                $datos['solo_logo'] = isset($_REQUEST['solo_logo']) ? 1 : 0;
                $this->aulaDAO->actualizar($id, $datos);
            }
        }
        $this->mostrarAulas();
    }

    public function formularioEliminarAula() {
        $this->requireRole(['admin']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $data['aula'] = $this->aulaDAO->get($id);
        if(empty($data['aula'])) {
            $this->mostrarAulas();
            return;
        }
        View::render("aula/eliminar", $data);
    }

    public function eliminarAula() {
        $this->requireRole(['admin']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        if($id > 0) {
            $this->aulaDAO->eliminar($id);
        }
        $this->mostrarAulas();
    }
}
