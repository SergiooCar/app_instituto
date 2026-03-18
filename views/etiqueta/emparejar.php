<!-- views/etiqueta/emparejar.php -->

<div class="container-fluid mt-4 etiquetas-page">
    <h1 class="mb-4">Etiquetas</h1>

    <?php
    $listaAulas = $data["listaAulas"];

    if(count($listaAulas) == 0) {
        echo '<div class="alert alert-info">No hay aulas cargadas.</div>';
    } else {

        echo '<h2 class="h5 mb-3">Listado de aulas (informativo)</h2>';
        echo '<div class="table-responsive etiquetas-table-wrap mb-4">';
        echo '<table class="table table-striped table-hover">';
        echo '<thead class="table-dark">';
        echo '<tr><th>Ref Aula</th><th>Bloques</th><th>Aula</th><th>Curso</th><th>Profesor</th><th>Etiqueta</th><th>Antena</th><th>Estado</th></tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach($listaAulas as $fila) {
            echo '<tr>';
            echo '<td>#'.$fila->id.'</td>';
            echo '<td>'.$fila->bloques.'</td>';
            echo '<td>'.$fila->aula.'</td>';
            echo '<td>'.$fila->curso.'</td>';
            echo '<td>'.$fila->profesor.'</td>';
            echo '<td>'.$fila->etiqueta_codigo.'</td>';
            echo '<td>'.$fila->antena_codigo.'</td>';
            echo '<td>'.((int)$fila->emparejada === 1 ? 'Emparejada' : 'Sin emparejar').'</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</div>';

        if($_SESSION['role'] !== 'viewer') {
            echo '<h2 class="h5 mb-3">Emparejar aula (ref) con etiqueta</h2>';
            echo '<div class="table-responsive etiquetas-table-wrap">';
            echo '<table class="table table-striped table-hover">';
            echo '<thead class="table-dark">';
            echo '<tr><th>Ref Aula</th><th>Aula</th><th>Estado</th><th>Accion</th></tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach($listaAulas as $fila) {
                echo '<tr>';
                echo '<td>#'.$fila->id.'</td>';
                echo '<td>'.$fila->aula.'</td>';
                echo '<td>'.((int)$fila->emparejada === 1 ? 'Emparejada' : 'Sin emparejar').'</td>';
                echo '<td>';

                if((int)$fila->emparejada === 1) {
                    echo '<form method="post" action="index.php" class="acciones-rapidas-form">';
                    echo '<input type="hidden" name="action" value="desemparejarAula">';
                    echo '<input type="hidden" name="id" value="'.$fila->id.'">';
                    echo '<button type="submit" class="btn btn-sm btn-warning">Desemparejar</button>';
                    echo '</form>';
                } else {
                    echo '<form method="post" action="index.php" class="acciones-rapidas-form">';
                    echo '<input type="hidden" name="action" value="emparejarAula">';
                    echo '<input type="hidden" name="id" value="'.$fila->id.'">';
                    echo '<input type="text" name="etiqueta_codigo" class="form-control form-control-sm" placeholder="Etiqueta" required>';
                    echo '<button type="submit" class="btn btn-sm btn-success">Emparejar</button>';
                    echo '</form>';
                }

                echo '</td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
    }
    ?>
</div>
 