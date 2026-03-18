<!-- views/user/recuperar.php -->

<?php
if(!empty($data['error']))
    echo '<div class="alert alert-danger">'.$data['error'].'</div>';

if(!empty($data['mssg']))
    echo '<div class="alert alert-success">'.$data['mssg'].'</div>';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="mb-4">Recuperar contrasena</h1>
            <p class="text-muted">Introduce tu usuario y se registrara la solicitud para que un administrador restablezca el acceso.</p>
            <form method="post" action="index.php">
                <input type="hidden" name="action" value="recuperarPassword">
                <div class="mb-3">
                    <label for="user" class="form-label">Usuario:</label>
                    <input type="text" id="user" name="user" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar solicitud</button>
                <a href="index.php" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
 