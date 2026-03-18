<!-- views/aula/crear.php -->

<div class="container mt-4">
    <h1 class="mb-4">Nueva aula</h1>
    <form method="post" action="index.php" class="col-md-6">
        <input type="hidden" name="action" value="crearAula">
        <div class="mb-3">
            <label for="bloques" class="form-label">Bloques:</label>
            <input type="text" id="bloques" name="bloques" class="form-control">
        </div>
        <div class="mb-3">
            <label for="aula" class="form-label">Aula:</label>
            <input type="text" id="aula" name="aula" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="curso" class="form-label">Curso:</label>
            <input type="text" id="curso" name="curso" class="form-control">
        </div>
        <div class="mb-3">
            <label for="dia" class="form-label">Día:</label>
            <input type="text" id="dia" name="dia" class="form-control" placeholder="Lunes">
        </div>
        <div class="mb-3">
            <label for="hora" class="form-label">Hora:</label>
            <input type="text" id="hora" name="hora" class="form-control" placeholder="08:00-09:00">
        </div>
        <div class="mb-3">
            <label for="profesor" class="form-label">Profesor:</label>
            <input type="text" id="profesor" name="profesor" class="form-control">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="solo_logo" name="solo_logo" value="1">
            <label class="form-check-label" for="solo_logo">Mostrar solo el logo del instituto (sin datos de clase)</label>
        </div>
        <button type="submit" class="btn btn-success me-2">Guardar</button>
        <a href="index.php?action=mostrarAulas" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
 