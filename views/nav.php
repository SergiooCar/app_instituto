<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><strong>App IES Barajas</strong></a>
        <?php if(isset($_SESSION['username'])): ?>
        <div class="dropdown ms-auto">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Menú">
                &#9776;
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="index.php?action=mostrarAulas">Aulas</a></li>
                <?php if($_SESSION['role'] !== 'viewer'): ?>
                <li><a class="dropdown-item" href="index.php?action=formularioCrearAula">Nueva aula</a></li>
                <li><a class="dropdown-item" href="index.php?action=mostrarAulas&openImport=1">Importar CSV</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="index.php?action=mostrarEtiquetas">Etiquetas / Emparejar</a></li>
                <li><a class="dropdown-item" href="index.php?action=mostrarEstado">Estado</a></li>
                <?php if($_SESSION['role'] !== 'viewer'): ?>
                <li><a class="dropdown-item" href="index.php?action=mostrarPlantillas">Plantillas gráficas</a></li>
                <?php endif; ?>
                <?php if($_SESSION['role'] === 'admin'): ?>
                <li><a class="dropdown-item" href="index.php?action=mostrarUsuarios">Usuarios</a></li>
                <?php endif; ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="index.php?action=salir">Salir (<?php echo $_SESSION['username']; ?>)</a></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</nav>
 