<!-- views/horario/editar.php -->

<?php $horario = $data['horario']; ?>

<div class="container mt-4">
    <h1 class="mb-4">Editar Horario</h1>
    <form method="post" action="index.php" class="col-md-6">
        <input type="hidden" name="action" value="editarHorario">
        <input type="hidden" name="id" value="<?php echo $horario->id; ?>">
        <div class="mb-3">
            <label for="aula_id" class="form-label">Bloque:</label>
            <select id="aula_id" name="aula_id" class="form-control" required>
                <option value="">Selecciona un bloque</option>
                <?php foreach($data['listaAulas'] as $aula): ?>
                    <option value="<?php echo $aula->id; ?>" <?php echo ($aula->id == $horario->aula_id) ? 'selected' : ''; ?>><?php echo $aula->aula; ?> (<?php echo $aula->bloques; ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="dia" class="form-label">Día:</label>
            <select id="dia" name="dia" class="form-control" required>
                <option value="">Selecciona un día</option>
                <option value="Lunes" <?php echo ($horario->dia == 'Lunes') ? 'selected' : ''; ?>>Lunes</option>
                <option value="Martes" <?php echo ($horario->dia == 'Martes') ? 'selected' : ''; ?>>Martes</option>
                <option value="Miércoles" <?php echo ($horario->dia == 'Miércoles') ? 'selected' : ''; ?>>Miércoles</option>
                <option value="Jueves" <?php echo ($horario->dia == 'Jueves') ? 'selected' : ''; ?>>Jueves</option>
                <option value="Viernes" <?php echo ($horario->dia == 'Viernes') ? 'selected' : ''; ?>>Viernes</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora Inicio:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" value="<?php echo $horario->hora_inicio; ?>" required>
        </div>
        <div class="mb-3">
            <label for="hora_fin" class="form-label">Hora Fin:</label>
            <input type="time" id="hora_fin" name="hora_fin" class="form-control" value="<?php echo $horario->hora_fin; ?>" required>
        </div>
        <div class="mb-3">
            <label for="profesor" class="form-label">Profesor:</label>
            <input type="text" id="profesor" name="profesor" class="form-control" value="<?php echo $horario->profesor; ?>" required>
        </div>
        <div class="mb-3">
            <label for="curso" class="form-label">Aula:</label>
            <input type="text" id="curso" name="curso" class="form-control" value="<?php echo $horario->curso; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary me-2">Actualizar</button>
        <a href="index.php?action=mostrarHorarios" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
 