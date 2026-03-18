<?php
class EtiquetaController extends BaseController {
    public function mostrarEtiquetas() {
        $this->requireLogin();
        $data["listaAulas"] = $this->aulaDAO->getAll();
        View::render("etiqueta/emparejar", $data);
    }

    public function emparejarAula() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $etiqueta = trim($_REQUEST['etiqueta_codigo'] ?? '');
        $antena = $this->generarCodigoAntena($etiqueta);
        if($id > 0 && $etiqueta !== '' && $antena !== '') {
            $this->aulaDAO->emparejar($id, $etiqueta, $antena);
        }
        $this->mostrarEtiquetas();
    }

    public function desemparejarAula() {
        $this->requireRole(['admin', 'editor']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        if($id > 0) {
            $this->aulaDAO->desemparejar($id);
        }
        $this->mostrarEtiquetas();
    }

    public function mostrarEstado() {
        $this->requireLogin();
        $data['totalAulas'] = $this->aulaDAO->contarTotal();
        $data['emparejadas'] = $this->aulaDAO->contarEmparejadas();
        $data['pendientes'] = $data['totalAulas'] - $data['emparejadas'];
        $data['conectividad'] = ($data['totalAulas'] > 0)
            ? round(($data['emparejadas'] * 100) / $data['totalAulas'], 1)
            : 0;
        $data["listaAulas"] = $this->aulaDAO->getAll();
        View::render("etiqueta/estado", $data);
    }
}
