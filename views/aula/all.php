<!-- views/aula/all.php -->

<div class="container mt-4">
    <h1 class="mb-4">Aulas</h1>
    
    <?php if(!empty($data['mensaje'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($data['mensaje'], ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <?php if(!empty($data['error'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($data['error'], ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if($_SESSION['role'] !== 'viewer'): ?>
    <div class="mb-3">
        <a href="index.php?action=formularioCrearAula" class="btn btn-success">Nueva aula</a>
        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modalImportarCSV">Importar CSV</button>
    </div>
    <?php endif; ?>

    <?php
    $listaAulas = $data["listaAulas"];
    $horarios = $data["horarios"] ?? [];

    if(count($listaAulas) == 0) {
        echo '<div class="alert alert-info">No hay resultados.</div>';
    } else {
        $horariosPorAula = [];
        foreach($horarios as $h) {
            if(!isset($horariosPorAula[$h->aula_id])) {
                $horariosPorAula[$h->aula_id] = [];
            }
            $horariosPorAula[$h->aula_id][] = $h;
        }

        $ordenDias = [
            'lunes' => 1,
            'martes' => 2,
            'miercoles' => 3,
            'miércoles' => 3,
            'jueves' => 4,
            'viernes' => 5
        ];

        foreach($listaAulas as $fila) {
            $tituloAula = trim((string)$fila->aula);

            $listaHorarios = $horariosPorAula[$fila->id] ?? [];

            usort($listaHorarios, function($a, $b) use ($ordenDias) {
                $diaA = strtolower(trim((string)$a->dia));
                $diaB = strtolower(trim((string)$b->dia));
                $ordA = $ordenDias[$diaA] ?? 99;
                $ordB = $ordenDias[$diaB] ?? 99;

                if($ordA !== $ordB) {
                    return $ordA <=> $ordB;
                }

                $hIniA = strtotime((string)$a->hora_inicio);
                $hIniB = strtotime((string)$b->hora_inicio);
                if($hIniA !== $hIniB) {
                    return $hIniA <=> $hIniB;
                }

                return strtotime((string)$a->hora_fin) <=> strtotime((string)$b->hora_fin);
            });

            echo '<div class="card mb-4">';
            echo '<div class="card-header bg-dark text-white">';
            if((int)$fila->solo_logo === 1) {
                echo '<img src="Logo.jpg" alt="Logo del instituto" class="img-fluid" style="max-height:40px;">';
            } else {
                echo '<h5 class="mb-0">Aula ' . htmlspecialchars($tituloAula, ENT_QUOTES, 'UTF-8') . '</h5>';
            }
            echo '</div>';
            echo '<div class="card-body">';

            echo '<div class="table-responsive">';
            echo '<table class="table table-striped table-hover">';
            echo '<thead class="table-light">';
            echo '<tr><th>Día</th><th>Hora</th><th>Profesor</th><th>Curso</th><th>Etiqueta</th><th>Antena</th><th>Estado</th>';
        if($_SESSION['role'] !== 'viewer') {
            echo '<th>Acciones</th>';
        }
        echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            $filasPintadas = 0;
            foreach($listaHorarios as $h) {
                $diaActual = strtolower(trim((string)$h->dia));
                if(!isset($ordenDias[$diaActual])) {
                    continue;
                }

                $inicio = strtotime((string)$h->hora_inicio);
                $fin = strtotime((string)$h->hora_fin);
                if($inicio !== false && $fin !== false) {
                    $horaInicioMin = (int)date('H', $inicio) * 60 + (int)date('i', $inicio);
                    $horaFinMin = (int)date('H', $fin) * 60 + (int)date('i', $fin);
                    if($horaInicioMin < 480 || $horaFinMin > 1280) {
                        continue;
                    }
                }

                echo '<tr>';
                echo '<td>' . htmlspecialchars($h->dia, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($h->hora_inicio, ENT_QUOTES, 'UTF-8') . ' - ' . htmlspecialchars($h->hora_fin, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($h->profesor, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($h->curso, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($fila->etiqueta_codigo, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($fila->antena_codigo, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>';
                if((int)$fila->emparejada === 1) {
                    echo '<span class="badge bg-success">Emparejada</span>';
                } else {
                    echo '<span class="badge bg-warning">Sin emparejar</span>';
                }
                echo '</td>';
                if($_SESSION['role'] !== 'viewer') {
                    echo '<td>';
                    echo '<a href="index.php?action=formularioEditarAula&id=' . $fila->id . '" class="btn btn-sm btn-primary">Editar</a> ';
                    echo '<a href="index.php?action=formularioEliminarAula&id=' . $fila->id . '" class="btn btn-sm btn-danger">Eliminar</a>';
                    echo '</td>';
                }
                echo '</tr>';
                $filasPintadas++;
            }

            if($filasPintadas === 0) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fila->dia ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($fila->hora ?? '-', ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($fila->profesor, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($fila->curso, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($fila->etiqueta_codigo, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>' . htmlspecialchars($fila->antena_codigo, ENT_QUOTES, 'UTF-8') . '</td>';
                echo '<td>';
                if((int)$fila->emparejada === 1) {
                    echo '<span class="badge bg-success">Emparejada</span>';
                } else {
                    echo '<span class="badge bg-warning">Sin emparejar</span>';
                }
                echo '</td>';
                if($_SESSION['role'] !== 'viewer') {
                    echo '<td>';
                    echo '<a href="index.php?action=formularioEditarAula&id=' . $fila->id . '" class="btn btn-sm btn-primary">Editar</a> ';
                    echo '<a href="index.php?action=formularioEliminarAula&id=' . $fila->id . '" class="btn btn-sm btn-danger">Eliminar</a>';
                    echo '</td>';
                }
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</div>

<?php if($_SESSION['role'] !== 'viewer'): ?>
<div class="modal fade" id="modalImportarCSV" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Importar CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <p><strong>Formato:</strong> bloque;aula;curso;profesor;dia;hora;etiqueta;antena</p>
                    <p class="mb-0">Separador obligatorio: <strong>;</strong></p>
                </div>

                <form method="post" action="index.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="importarCSV">
                    <div class="mb-3">
                        <label for="archivo_csv" class="form-label">Archivo CSV</label>
                        <input type="file" id="archivo_csv" name="archivo_csv" class="form-control" accept=".csv,text/csv" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Importar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if(isset($_REQUEST['openImport']) && $_REQUEST['openImport'] == '1'): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modalEl = document.getElementById('modalImportarCSV');
    if(modalEl) {
        var modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
});
</script>
<?php endif; ?>
<?php endif; ?>
 