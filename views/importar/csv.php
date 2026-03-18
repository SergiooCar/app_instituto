<!-- views/importar/csv.php -->

<div class="container mt-4">
    <h1 class="mb-4">Importar CSV</h1>

    <?php
    if(!empty($data['mensaje'])) {
        echo '<div class="alert alert-success">'.htmlspecialchars($data['mensaje']).'</div>';
    }
    if(!empty($data['error'])) {
        echo '<div class="alert alert-danger">'.htmlspecialchars($data['error']).'</div>';
    }
    ?>

    <div class="alert alert-info">
        <p><strong>Instrucciones:</strong> Usa separador <code>;</code></p>
        <p>Formato: <code>bloque;aula;curso;profesor;dia;hora;etiqueta;antena</code></p>
    </div>

    <form method="post" action="index.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="importarCSV">
        <div class="mb-3">
            <label for="archivo_csv" class="form-label">Archivo CSV:</label>
            <input type="file" id="archivo_csv" name="archivo_csv" class="form-control" accept=".csv,text/csv" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>
</div>
 