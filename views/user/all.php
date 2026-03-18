<!-- views/user/all.php -->

<div class="container mt-4">
    <h1 class="mb-4">Crear usuario</h1>

    <?php
    if(!empty($data['error'])) 
        echo '<div class="alert alert-danger">'.$data['error'].'</div>';
    if(!empty($data['mssg'])) 
        echo '<div class="alert alert-success">'.$data['mssg'].'</div>';
    ?>

    <form method="post" action="index.php" class="mb-5">
        <input type="hidden" name="action" value="crearUsuario">
        <div class="mb-3">
            <label for="username" class="form-label">Usuario:</label>
            <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol:</label>
            <select id="role" name="role" class="form-select">
                <option value="viewer">viewer</option>
                <option value="editor">editor</option>
                <option value="admin">admin</option>
                <option value="disabled">disabled</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Crear</button>
    </form>

    <h2 class="mb-3">Solicitudes de recuperar contrasena</h2>

    <?php
    $solicitudesRecuperacion = $data['solicitudesRecuperacion'] ?? [];
    if(count($solicitudesRecuperacion) == 0) {
        echo '<div class="alert alert-info">No hay solicitudes pendientes.</div>';
    } else {
        echo '<table class="table table-striped table-hover">';
        echo '<thead class="table-dark">';
        echo '<tr><th>ID</th><th>Usuario solicitado</th><th>Fecha</th><th>Accion</th></tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach($solicitudesRecuperacion as $sol) {
            echo '<tr>';
            echo '<td>'.$sol['id'].'</td>';
            echo '<td>'.$sol['username'].'</td>';
            echo '<td>'.$sol['created_at'].'</td>';
            echo '<td>';
            echo '<form method="post" action="index.php" style="display:inline;">';
            echo '<input type="hidden" name="action" value="atenderSolicitudRecuperacion">';
            echo '<input type="hidden" name="id" value="'.$sol['id'].'">';
            echo '<button type="submit" class="btn btn-sm btn-primary">Marcar atendida</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }
    ?>

    <h2 class="mb-3">Usuarios</h2>

    <?php
    $listaUsuarios = $data["listaUsuarios"] ?? [];

    if(count($listaUsuarios) == 0) {
        echo '<div class="alert alert-info">No hay usuarios.</div>';
    } else {

        echo '<table class="table table-striped table-hover">';
        echo '<thead class="table-dark">';
        echo '<tr><th>ID</th><th>Usuario</th><th>Rol</th><th>Fecha</th><th>Actualizar</th><th>Eliminar</th></tr>';
        echo '</thead>';

        foreach($listaUsuarios as $fila) {
            echo '<tr>';
            echo '<td>'.$fila->id.'</td>';
            echo '<td>'.$fila->username.'</td>';
            echo '<td>'.$fila->role.'</td>';
            echo '<td>'.$fila->created_at.'</td>';
            echo '<td>';

            echo '<form method="post" action="index.php" style="display:inline;margin-right:8px;">';
            echo '<input type="hidden" name="action" value="actualizarUsuario">';
            echo '<input type="hidden" name="id" value="'.$fila->id.'">';
            echo '<input type="text" name="username" class="form-control form-control-sm" style="display:inline;width:140px;" value="'.$fila->username.'" required>';
            echo '<button type="submit" class="btn btn-sm btn-outline-primary">Guardar usuario</button>';
            echo '</form>';

            echo '<form method="post" action="index.php" style="display:inline;">';
            echo '<input type="hidden" name="action" value="cambiarRol">';
            echo '<input type="hidden" name="id" value="'.$fila->id.'">';
            echo '<select name="role" class="form-select form-select-sm" style="display:inline;width:auto;">';
            echo '<option value="viewer"'.($fila->role === 'viewer' ? ' selected' : '').'>viewer</option>';
            echo '<option value="editor"'.($fila->role === 'editor' ? ' selected' : '').'>editor</option>';
            echo '<option value="admin"'.($fila->role === 'admin' ? ' selected' : '').'>admin</option>';
            echo '<option value="disabled"'.($fila->role === 'disabled' ? ' selected' : '').'>disabled</option>';
            echo '</select>';
            echo '<button type="submit" class="btn btn-sm btn-primary">Guardar rol</button>';
            echo '</form>';

            if((int)$fila->id !== (int)($_SESSION['id'] ?? 0)) {
                echo '<form method="post" action="index.php" style="display:inline;margin-left:8px;">';
                echo '<input type="hidden" name="action" value="cambiarRol">';
                echo '<input type="hidden" name="id" value="'.$fila->id.'">';
                if($fila->role === 'disabled') {
                    echo '<input type="hidden" name="role" value="viewer">';
                    echo '<button type="submit" class="btn btn-sm btn-success">Habilitar</button>';
                } else {
                    echo '<input type="hidden" name="role" value="disabled">';
                    echo '<button type="submit" class="btn btn-sm btn-warning">Deshabilitar</button>';
                }
                echo '</form>';
            }

            echo '<form method="post" action="index.php" style="display:inline;margin-left:8px;">';
            echo '<input type="hidden" name="action" value="resetPasswordUsuario">';
            echo '<input type="hidden" name="id" value="'.$fila->id.'">';
            echo '<input type="password" name="password" class="form-control form-control-sm" style="display:inline;width:140px;" placeholder="Nuevo password" required>';
            echo '<button type="submit" class="btn btn-sm btn-secondary">Reset pass</button>';
            echo '</form>';
            echo '</td>';

            echo '<td>';
            if((int)$fila->id !== (int)($_SESSION['id'] ?? 0)) {
                echo '<form method="post" action="index.php" style="display:inline;" onsubmit="return confirm(\'¿Eliminar usuario?\')">';
                echo '<input type="hidden" name="action" value="eliminarUsuario">';
                echo '<input type="hidden" name="id" value="'.$fila->id.'">';
                echo '<button type="submit" class="btn btn-sm btn-danger">Eliminar</button>';
                echo '</form>';
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
    ?>
</div>
 