<!-- views/horario/crear.php -->

<div class="container mt-4">
    <h1 class="mb-4">Crear Horario</h1>
    <form method="post" action="index.php" class="col-md-6">
        <input type="hidden" name="action" value="crearHorario">
        <div class="mb-3">
            <label for="aula_id" class="form-label">Bloque:</label>
            <select id="aula_id" name="aula_id" class="form-control" required>
                <option value="">Selecciona un bloque</option>
                <?php foreach($data['listaAulas'] as $aula): ?>
                    <option value="<?php echo $aula->id; ?>"><?php echo $aula->aula; ?> (<?php echo $aula->bloques; ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="dia" class="form-label">Día:</label>
            <select id="dia" name="dia" class="form-control" required>
                <option value="">Selecciona un día</option>
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="hora_inicio" class="form-label">Hora Inicio:</label>
            <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="hora_fin" class="form-label">Hora Fin:</label>
            <input type="time" id="hora_fin" name="hora_fin" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="profesor" class="form-label">Profesor:</label>
            <input type="text" id="profesor" name="profesor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="curso" class="form-label">Aula:</label>
            <input type="text" id="curso" name="curso" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success me-2">Guardar</button>
        <a href="index.php?action=mostrarHorarios" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
 