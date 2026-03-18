<!-- views/user/login.php -->

<?php
if(!empty($data['error'])) 
    echo '<div class="alert alert-danger">'.$data['error'].'</div>';

if(!empty($data['mssg'])) 
    echo '<div class="alert alert-success">'.$data['mssg'].'</div>';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Iniciar sesion</h1>
            <form method="post" action="index.php">
                <input type="hidden" name="action" value="validarUser">
                <div class="mb-3">
                    <label for="user" class="form-label">Usuario:</label>
                    <input type="text" id="user" name="user" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="pass" class="form-label">Contrasena:</label>
                    <input type="password" id="pass" name="pass" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
            <div class="mt-3 text-end">
                <a href="index.php?action=formularioRecuperarPassword">Recuperar contrasena</a>
            </div>
        </div>
    </div>
</div>
 