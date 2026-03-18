<!-- views/etiqueta/plantillas.php -->

<div class="container mt-4">
    <?php if($_SESSION['role'] !== 'viewer'): ?>
    <h1 class="mb-4">Nueva plantilla gráfica</h1>

    <form method="post" action="index.php" class="mb-5" id="formPlantillaGrafica">
        <input type="hidden" name="action" value="crearPlantilla">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del diseño:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="textoSuperior" class="form-label">Texto superior:</label>
                    <input type="text" id="textoSuperior" class="form-control" value="TEXTO01">
                </div>
                <div class="mb-3">
                    <label for="textoInferior" class="form-label">Texto inferior:</label>
                    <input type="text" id="textoInferior" class="form-control" value="20.30">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" id="mostrarLogo" class="form-check-input" value="1">
                    <label class="form-check-label" for="mostrarLogo">Mostrar logo en la franja superior</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="colorBarra" class="form-label">Color franja superior:</label>
                    <input type="color" id="colorBarra" class="form-control form-control-color" value="#000000">
                </div>
                <div class="mb-3">
                    <label for="colorTextoSuperior" class="form-label">Color texto superior:</label>
                    <input type="color" id="colorTextoSuperior" class="form-control form-control-color" value="#ffffff">
                </div>
                <div class="mb-3">
                    <label for="colorFondoInferior" class="form-label">Color fondo inferior:</label>
                    <input type="color" id="colorFondoInferior" class="form-control form-control-color" value="#f5f5f5">
                </div>
                <div class="mb-3">
                    <label for="colorTextoInferior" class="form-label">Color texto inferior:</label>
                    <input type="color" id="colorTextoInferior" class="form-control form-control-color" value="#1f1f1f">
                </div>
            </div>
        </div>

        <input type="hidden" id="contenido" name="contenido" value='{"tipo":"barra_superior","textoSuperior":"TEXTO01","textoInferior":"20.30","mostrarLogo":0,"colorBarra":"#000000","colorTextoSuperior":"#ffffff","colorFondoInferior":"#f5f5f5","colorTextoInferior":"#1f1f1f"}'>

        <div class="mb-3">
            <label class="form-label">Vista previa:</label>
            <div id="previewEtiqueta" class="border rounded overflow-hidden" style="max-width:420px;">
                <div id="previewBarra" style="background:#000; color:#fff; min-height:52px; display:flex; align-items:center; justify-content:center; gap:8px; padding:8px 12px;">
                    <img id="previewLogo" src="Logo.jpg" alt="Logo" style="height:22px; width:auto; display:none;">
                    <div id="previewTextoSuperior" style="font-weight:700; font-size:34px; line-height:1;">TEXTO01</div>
                </div>
                <div id="previewCuerpo" style="background:#f5f5f5; min-height:84px; display:flex; align-items:center; justify-content:center; padding:10px 12px;">
                    <div id="previewTextoInferior" style="font-size:42px; color:#1f1f1f; line-height:1;">20.30</div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
    <?php endif; ?>

    <h2 class="mb-3">Plantillas gráficas</h2>

    <?php
    $listaPlantillas = $data["listaPlantillas"] ?? [];

    if(count($listaPlantillas) == 0) {
        echo '<div class="alert alert-info">No hay plantillas.</div>';
    } else {

        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-hover align-middle">';
        echo '<thead class="table-dark">';
        echo '<tr><th>Nombre del diseño</th><th>Vista previa</th><th>Fecha</th><th>Accion</th></tr>';
        echo '</thead>';

        foreach($listaPlantillas as $fila) {
            $cfg = json_decode((string)$fila->contenido, true);
            $textoSuperior = 'TEXTO01';
            $textoInferior = '20.30';
            $mostrarLogo = 0;
            $colorBarra = '#000000';
            $colorTextoSuperior = '#ffffff';
            $colorFondoInferior = '#f5f5f5';
            $colorTextoInferior = '#1f1f1f';

            if(is_array($cfg)) {
                $textoSuperior = $cfg['textoSuperior'] ?? $textoSuperior;
                $textoInferior = $cfg['textoInferior'] ?? $textoInferior;
                $mostrarLogo = (int)($cfg['mostrarLogo'] ?? $mostrarLogo);
                $colorBarra = $cfg['colorBarra'] ?? $colorBarra;
                $colorTextoSuperior = $cfg['colorTextoSuperior'] ?? $colorTextoSuperior;
                $colorFondoInferior = $cfg['colorFondoInferior'] ?? $colorFondoInferior;
                $colorTextoInferior = $cfg['colorTextoInferior'] ?? $colorTextoInferior;
            }

            echo '<tr>';
            echo '<td>'.htmlspecialchars($fila->nombre, ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>';
            echo '<div class="border rounded overflow-hidden" style="max-width:320px;">';
            echo '<div style="background:' . htmlspecialchars($colorBarra, ENT_QUOTES, 'UTF-8') . ';color:' . htmlspecialchars($colorTextoSuperior, ENT_QUOTES, 'UTF-8') . ';padding:8px 10px;display:flex;align-items:center;justify-content:center;gap:8px;">';
            if($mostrarLogo === 1) {
                echo '<img src="Logo.jpg" alt="Logo" style="height:18px; width:auto;">';
            }
            echo '<span style="font-weight:700;font-size:14px;line-height:1;">' . htmlspecialchars($textoSuperior, ENT_QUOTES, 'UTF-8') . '</span>';
            echo '</div>';
            echo '<div style="background:' . htmlspecialchars($colorFondoInferior, ENT_QUOTES, 'UTF-8') . ';color:' . htmlspecialchars($colorTextoInferior, ENT_QUOTES, 'UTF-8') . ';padding:12px 10px;text-align:center;">';
            echo '<span style="font-weight:500;font-size:24px;line-height:1;">' . htmlspecialchars($textoInferior, ENT_QUOTES, 'UTF-8') . '</span>';
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '<td>'.htmlspecialchars($fila->created_at, ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>';
            if($_SESSION['role'] !== 'viewer') {
                echo '<form method="post" action="index.php" style="display:inline;">';
                echo '<input type="hidden" name="action" value="eliminarPlantilla">';
                echo '<input type="hidden" name="id" value="'.$fila->id.'">';
                echo '<button type="submit" class="btn btn-sm btn-danger">Eliminar</button>';
                echo '</form>';
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    }
    ?>
</div>

<?php if($_SESSION['role'] !== 'viewer'): ?>
<script>
(function() {
    const textoSuperior = document.getElementById('textoSuperior');
    const textoInferior = document.getElementById('textoInferior');
    const mostrarLogo = document.getElementById('mostrarLogo');
    const colorBarra = document.getElementById('colorBarra');
    const colorTextoSuperior = document.getElementById('colorTextoSuperior');
    const colorFondoInferior = document.getElementById('colorFondoInferior');
    const colorTextoInferior = document.getElementById('colorTextoInferior');
    const contenido = document.getElementById('contenido');

    const previewBarra = document.getElementById('previewBarra');
    const previewCuerpo = document.getElementById('previewCuerpo');
    const previewTextoSuperior = document.getElementById('previewTextoSuperior');
    const previewTextoInferior = document.getElementById('previewTextoInferior');
    const previewLogo = document.getElementById('previewLogo');

    if(!textoSuperior || !textoInferior || !mostrarLogo || !colorBarra || !colorTextoSuperior || !colorFondoInferior || !colorTextoInferior || !contenido || !previewBarra || !previewCuerpo || !previewTextoSuperior || !previewTextoInferior || !previewLogo) {
        return;
    }

    function render() {
        const cfg = {
            tipo: 'barra_superior',
            textoSuperior: textoSuperior.value || 'TEXTO01',
            textoInferior: textoInferior.value || '20.30',
            mostrarLogo: mostrarLogo.checked ? 1 : 0,
            colorBarra: colorBarra.value,
            colorTextoSuperior: colorTextoSuperior.value,
            colorFondoInferior: colorFondoInferior.value,
            colorTextoInferior: colorTextoInferior.value
        };

        contenido.value = JSON.stringify(cfg);

        previewBarra.style.background = cfg.colorBarra;
        previewBarra.style.color = cfg.colorTextoSuperior;
        previewCuerpo.style.background = cfg.colorFondoInferior;
        previewTextoInferior.style.color = cfg.colorTextoInferior;
        previewTextoSuperior.textContent = cfg.textoSuperior;
        previewTextoInferior.textContent = cfg.textoInferior;
        previewLogo.style.display = cfg.mostrarLogo === 1 ? 'inline-block' : 'none';
    }

    [textoSuperior, textoInferior, mostrarLogo, colorBarra, colorTextoSuperior, colorFondoInferior, colorTextoInferior].forEach(function(el) {
        el.addEventListener('change', render);
        el.addEventListener('input', render);
    });

    render();
})();
</script>
<?php endif; ?>
 