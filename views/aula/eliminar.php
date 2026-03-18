<!-- views/aula/eliminar.php -->

<?php $aula = $data['aula']; ?>

<div class="container mt-4">
    <h1 class="mb-4">Eliminar aula</h1>
    <div class="alert alert-danger">
        <p>Vas a eliminar el aula <strong><?php echo $aula->aula; ?></strong>.</p>
    </div>
    <form method="post" action="index.php">
        <input type="hidden" name="action" value="eliminarAula">
        <input type="hidden" name="id" value="<?php echo $aula->id; ?>">
        <button type="submit" class="btn btn-danger me-2">Si, eliminar</button>
        <a href="index.php?action=mostrarAulas" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
 