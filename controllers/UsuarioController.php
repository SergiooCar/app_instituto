<?php
class UsuarioController extends BaseController {
    public function mostrarUsuarios($data=[]) {
        $this->requireRole(['admin']);
        if(empty($data["listaUsuarios"])) {
            $data["listaUsuarios"] = $this->userDAO->getAll();
        }
        $data['solicitudesRecuperacion'] = $this->userDAO->getSolicitudesRecuperacionPendientes();
        View::render("user/all", $data);
    }

    public function crearUsuario() {
        $this->requireRole(['admin']);
        $username = trim($_REQUEST['username'] ?? '');
        $password = $_REQUEST['password'] ?? '';

        if($username !== '' && $password !== '') {
            $error = $this->userDAO->crear($_REQUEST);
            if($error !== '') {
                $data['error'] = $error;
            } else {
                $data['mssg'] = "Usuario creado correctamente.";
            }
            $data["listaUsuarios"] = $this->userDAO->getAll();
            $this->mostrarUsuarios($data);
            return;
        }

        $this->mostrarUsuarios();
    }

    public function cambiarRol() {
        $this->requireRole(['admin']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $role = $_REQUEST['role'] ?? 'viewer';
        if($id > 0 && in_array($role, ['admin', 'editor', 'viewer', 'disabled'])) {
            $this->userDAO->cambiarRol($id, $role);
        }
        $this->mostrarUsuarios();
    }

    public function actualizarUsuario() {
        $this->requireRole(['admin']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $username = trim($_REQUEST['username'] ?? '');
        if($id > 0 && $username !== '') {
            $error = $this->userDAO->actualizarUsername($id, $username);
            if($error !== '') {
                $this->mostrarUsuarios(['error' => $error, 'listaUsuarios' => $this->userDAO->getAll()]);
                return;
            }
            $this->mostrarUsuarios(['mssg' => 'Usuario actualizado.', 'listaUsuarios' => $this->userDAO->getAll()]);
            return;
        }

        $this->mostrarUsuarios(['error' => 'No se pudo actualizar el usuario.', 'listaUsuarios' => $this->userDAO->getAll()]);
    }

    public function resetPasswordUsuario() {
        $this->requireRole(['admin']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        $password = $_REQUEST['password'] ?? '';
        if($id > 0 && trim($password) !== '') {
            $this->userDAO->actualizarPassword($id, $password);
            $this->mostrarUsuarios(['mssg' => 'Password actualizado.', 'listaUsuarios' => $this->userDAO->getAll()]);
            return;
        }

        $this->mostrarUsuarios(['error' => 'No se pudo actualizar el password.', 'listaUsuarios' => $this->userDAO->getAll()]);
    }

    public function eliminarUsuario() {
        $this->requireRole(['admin']);
        $id = (int) ($_REQUEST['id'] ?? 0);
        if($id > 0 && $id !== (int)($_SESSION['id'] ?? 0)) {
            $this->userDAO->eliminar($id);
            $this->mostrarUsuarios(['mssg' => 'Usuario eliminado.', 'listaUsuarios' => $this->userDAO->getAll()]);
            return;
        }

        $this->mostrarUsuarios(['error' => 'No se puede eliminar ese usuario.', 'listaUsuarios' => $this->userDAO->getAll()]);
    }

    public function atenderSolicitudRecuperacion() {
        $this->requireRole(['admin']);
        $id = (int)($_REQUEST['id'] ?? 0);
        if($id > 0) {
            $this->userDAO->marcarSolicitudRecuperacionAtendida($id);
            $this->mostrarUsuarios(['mssg' => 'Solicitud marcada como atendida.', 'listaUsuarios' => $this->userDAO->getAll()]);
            return;
        }

        $this->mostrarUsuarios(['error' => 'No se pudo marcar la solicitud.', 'listaUsuarios' => $this->userDAO->getAll()]);
    }
}
