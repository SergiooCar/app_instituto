<!-- views/etiqueta/horarios.php -->

<div class="container-fluid mt-4 etiquetas-page">
    <h1 class="mb-4">Horarios por Aula</h1>

    <?php if($_SESSION['role'] !== 'viewer'): ?>
    <div class="mb-3">
        <a href="index.php?action=formularioImportarCSV" class="btn btn-info">Importar CSV</a>
    </div>
    <?php endif; ?>

    <?php
    $listaAulas = $data["listaAulas"] ?? [];
    $horarios = $data["horarios"];
    $aulasPorId = [];

    foreach($listaAulas as $aula) {
        $aulasPorId[$aula->id] = $aula;
    }

    if(count($horarios) == 0) {
        echo '<div class="alert alert-info">No hay horarios cargados.</div>';
    } else {
        // Agrupar por aula
        $gruposPorAula = [];

        foreach($horarios as $h) {
            $nombreAula = 'Sin aula';
            if(isset($aulasPorId[$h->aula_id])) {
                $nombreAula = trim((string)($aulasPorId[$h->aula_id]->aula ?? ''));
                if($nombreAula === '') {
                    $nombreAula = 'Sin aula';
                }
            }

            $claveAula = strtolower($nombreAula);

            if(!isset($gruposPorAula[$claveAula])) {
                $gruposPorAula[$claveAula] = [
                    'nombre' => $nombreAula,
                    'aula_id' => $h->aula_id,
                    'horarios' => []
                ];
            }

            $gruposPorAula[$claveAula]['horarios'][] = $h;
        }

        foreach($gruposPorAula as $grupo) {
            $aulaIdParaCrear = (int)($grupo['aula_id'] ?? 0);

            usort($grupo['horarios'], function($a, $b) {
                $inicioA = strtotime($a->hora_inicio);
                $inicioB = strtotime($b->hora_inicio);

                if($inicioA === $inicioB) {
                    return strtotime($a->hora_fin) <=> strtotime($b->hora_fin);
                }

                return $inicioA <=> $inicioB;
            });

            echo '<div class="card mb-4">';
            echo '<div class="card-header bg-dark text-white">';
            echo '<h5 class="mb-0">Aula = ' . $grupo['nombre'] . '</h5>';
            echo '</div>';
            echo '<div class="card-body">';

            if(count($grupo['horarios']) > 0) {
                echo '<table class="table table-sm table-striped">';
                echo '<thead class="table-light">';
                echo '<tr><th>Día</th><th>Hora</th><th>Profesor</th><th>Curso</th>';
                if($_SESSION['role'] !== 'viewer') {
                    echo '<th>Acciones</th>';
                }
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                foreach($grupo['horarios'] as $h) {
                    echo '<tr>';
                    echo '<td>' . $h->dia . '</td>';
                    echo '<td>' . $h->hora_inicio . ' - ' . $h->hora_fin . '</td>';
                    echo '<td>' . $h->profesor . '</td>';
                    echo '<td>' . $h->curso . '</td>';
                    if($_SESSION['role'] !== 'viewer') {
                        echo '<td>';
                        echo '<a href="index.php?action=formularioEditarHorario&id=' . $h->id . '" class="btn btn-sm btn-primary">Editar</a> ';
                        echo '<a href="index.php?action=eliminarHorario&id=' . $h->id . '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Estás seguro?\')">Eliminar</a>';
                        echo '</td>';
                    }
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p class="text-muted">Sin horarios registrados.</p>';
            }

            if($_SESSION['role'] !== 'viewer') {
                if($aulaIdParaCrear > 0) {
                    echo '<a href="index.php?action=formularioCrearHorario&aula_id=' . $aulaIdParaCrear . '" class="btn btn-sm btn-success">Agregar horario</a>';
                } else {
                    echo '<a href="index.php?action=formularioCrearHorario" class="btn btn-sm btn-success">Agregar horario</a>';
                }
            }
            echo '</div>';
            echo '</div>';
        }
    }
    ?>
</div>
 