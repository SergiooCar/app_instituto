<?php
class PlantillaController extends BaseController {
    public function mostrarPlantillas() {
        $this->requireRole(['admin', 'editor']);
        $data["listaPlantillas"] = $this->plantillaDAO->getAll();
        View::render("etiqueta/plantillas", $data);
    }

    public function crearPlantilla() {
        $this->requireRole(['admin', 'editor']);
        $nombre = trim($_REQUEST['nombre'] ?? '');
        $contenido = trim($_REQUEST['contenido'] ?? '');
        if($nombre !== '' && $contenido !== '') {
            $this->plantillaDAO->crear($nombre, $contenido);
        }
        $this->mostrarPlantillas();
    }

    public function eliminarPlantilla() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        if($id > 0) {
            $this->plantillaDAO->eliminar($id);
        }
        $this->mostrarPlantillas();
    }
}
