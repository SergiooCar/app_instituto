<?php
class InicioController extends BaseController {
    public function mostrarInicio() {
        header('Location: index.php?action=mostrarAulas');
        exit;
    }
}
