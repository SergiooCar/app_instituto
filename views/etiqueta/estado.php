<!-- views/etiqueta/estado.php -->

<div class="container mt-4">
    <h1 class="mb-4">Estado general</h1>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total aulas</h5>
                    <p class="card-text"><strong class="text-primary"><?php echo $data['totalAulas']; ?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Emparejadas</h5>
                    <p class="card-text"><strong class="text-success"><?php echo $data['emparejadas']; ?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pendientes</h5>
                    <p class="card-text"><strong class="text-warning"><?php echo $data['pendientes']; ?></strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Conectividad</h5>
                    <p class="card-text"><strong class="text-info"><?php echo $data['conectividad']; ?>%</strong></p>
                </div>
            </div>
        </div>
    </div>

    <?php
    $listaAulas = $data["listaAulas"];

    if(count($listaAulas) == 0) {
        echo '<div class="alert alert-info">No hay datos.</div>';
    } else {

        echo '<table class="table table-striped table-hover table-sm">';
        echo '<thead class="table-dark">';
        echo '<tr><th>Aula</th><th>Curso</th><th>Profesor</th><th>Conectividad</th></tr>';
        echo '</thead>';

        foreach($listaAulas as $fila) {
            echo '<tr>';
            echo '<td>'.$fila->aula.'</td>';
            echo '<td>'.$fila->curso.'</td>';
            echo '<td>'.$fila->profesor.'</td>';
            echo '<td>'.((int)$fila->emparejada === 1 ? 'Conectada' : 'Pendiente').'</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
    ?>
</div>
 