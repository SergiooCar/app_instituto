<?php
class ImportarController extends BaseController {
    public function formularioImportarCSV($data=[]) {
        $this->requireRole(['admin', 'editor']);
        if(!empty($data['mensaje'])) {
            $_SESSION['flash_mensaje'] = $data['mensaje'];
        }
        if(!empty($data['error'])) {
            $_SESSION['flash_error'] = $data['error'];
        }
        header('Location: index.php?action=mostrarAulas&openImport=1');
        exit;
    }

    public function importarCSV() {
        $this->requireRole(['admin', 'editor']);

        if(!isset($_FILES['archivo_csv']) || $_FILES['archivo_csv']['error'] !== UPLOAD_ERR_OK) {
            $_SESSION['flash_error'] = 'No se pudo subir el CSV.';
            header('Location: index.php?action=mostrarAulas');
            exit;
        }

        $handle = fopen($_FILES['archivo_csv']['tmp_name'], 'r');
        if($handle === false) {
            $_SESSION['flash_error'] = 'No se pudo abrir el archivo.';
            header('Location: index.php?action=mostrarAulas');
            exit;
        }

        $cabecera = fgetcsv($handle, 0, ';');
        $importadas = 0;
        $omitidas = 0;
        $horarios_creados = 0;
        $sePuedeCrearHorarios = $this->horarioDAO->existeTablaHorarios();

        $esFormatoBloqueAulaCurso = false;
        if(is_array($cabecera) && count($cabecera) >= 8) {
            $c0 = strtolower(preg_replace('/^\xEF\xBB\xBF/', '', trim((string)($cabecera[0] ?? ''))));
            $c1 = strtolower(preg_replace('/^\xEF\xBB\xBF/', '', trim((string)($cabecera[1] ?? ''))));
            $c2 = strtolower(preg_replace('/^\xEF\xBB\xBF/', '', trim((string)($cabecera[2] ?? ''))));
            $esFormatoBloqueAulaCurso = ($c0 === 'bloque' && $c1 === 'aula' && $c2 === 'curso');
        }

        while(($row = fgetcsv($handle, 0, ';')) !== false) {
            if(!$row || $row === [null]) continue;

            if($esFormatoBloqueAulaCurso) {
                $bloqueCsv = trim($row[0] ?? '');
                $aulaCsv = trim($row[1] ?? '');
                $cursoCsv = trim($row[2] ?? '');
                $profesorCsv = trim($row[3] ?? '');
                $diaCsv = trim($row[4] ?? '');
                $horaCsv = trim($row[5] ?? '');
                $etiquetaCsv = trim($row[6] ?? '');
                $antenaCsv = trim($row[7] ?? '');

                $nombre = $aulaCsv;
                $curso = $cursoCsv;
                $bloques = $bloqueCsv;
                $profesor = $profesorCsv;
                $dia = $diaCsv;
                $hora_rango = $horaCsv;
                $etiqueta = $etiquetaCsv;
                $antena = $antenaCsv;
            } else {
                $nombre = trim($row[0] ?? '');
                $curso = trim($row[1] ?? '');
                $bloques = trim($row[2] ?? '');
                $profesor = trim($row[3] ?? '');
                $dia = trim($row[4] ?? '');
                $hora_rango = trim($row[5] ?? '');
                $etiqueta = trim($row[6] ?? '');
                $antena = trim($row[7] ?? '');
            }

            $antena = $this->generarAntenaPorBloque($bloques);
            if($nombre === '') continue;

            $datos = [
                'aula' => $nombre,
                'nombre' => $nombre,
                'curso' => $curso,
                'dia' => $dia,
                'hora' => $hora_rango,
                'bloques' => $bloques,
                'profesor' => $profesor,
                'etiqueta_codigo' => $etiqueta,
                'antena_codigo' => $antena,
                'emparejada' => 0
            ];

            if($this->aulaDAO->existeAula($datos)) {
                $nombreAula = $datos['aula'] ?? ($datos['nombre'] ?? '');
                $aula_id = $this->aulaDAO->obtenerIdPorNombre($nombreAula);
                $omitidas++;
            } else {
                $aula_id = $this->aulaDAO->crear($datos);
                $importadas++;
            }

            if($sePuedeCrearHorarios && $aula_id && !empty($dia) && !empty($hora_rango)) {
                $horas = explode('-', $hora_rango);
                if(count($horas) === 2) {
                    $horario_datos = [
                        'aula_id' => $aula_id,
                        'dia' => $dia,
                        'hora_inicio' => trim($horas[0]),
                        'hora_fin' => trim($horas[1]),
                        'bloque' => $bloques,
                        'profesor' => $profesor,
                        'curso' => $curso
                    ];
                    $this->horarioDAO->crear($horario_datos);
                    $horarios_creados++;
                }
            }
        }

        fclose($handle);
        $mensaje = 'Importacion completada. Aulas importadas: '.$importadas.'. Filas omitidas: '.$omitidas;
        if($horarios_creados > 0) {
            $mensaje .= '. Horarios creados: '.$horarios_creados;
        } elseif(!$sePuedeCrearHorarios) {
            $mensaje .= '. Tabla horarios no existe: solo se importaron aulas.';
        }
        $_SESSION['flash_mensaje'] = $mensaje;
        header('Location: index.php?action=mostrarAulas');
        exit;
    }
}
