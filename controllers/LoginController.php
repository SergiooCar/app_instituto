<?php
class LoginController extends BaseController {
    public function formularioLogin($data=[]) {
        View::render("user/login", $data);
    }

    public function validarUser() {
        $user = $_REQUEST['user'];
        $pass = $_REQUEST['pass'];
        $data["userInfo"] = $this->userDAO->validar($user, $pass);

        if(!empty($data['userInfo'])) {
            $_SESSION['id'] = $data['userInfo']->id;
            $_SESSION['username'] = $data['userInfo']->username;
            $_SESSION['role'] = $data['userInfo']->role;
            header('Location: index.php?action=mostrarAulas');
            exit;
        }

        $data['error'] = "Credenciales incorrectas.";
        View::render("user/login", $data);
    }

    public function formularioRecuperarPassword($data=[]) {
        View::render("user/recuperar", $data);
    }

    public function recuperarPassword() {
        $user = trim($_REQUEST['user'] ?? '');
        if($user === '') {
            $this->formularioRecuperarPassword(['error' => 'Indica tu usuario.']);
            return;
        }
        $this->userDAO->registrarSolicitudRecuperacion($user);
        $this->formularioRecuperarPassword(['mssg' => 'Solicitud enviada al administrador para '.$user.'.']);
    }

    public function salir() {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
}
