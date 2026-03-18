<!-- views/dashboard.php -->

<div class="container mt-4">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total aulas</h5>
                    <p class="card-text" style="font-size:1.5rem;">
                        <strong><?php echo $data['totalAulas']; ?></strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Emparejadas</h5>
                    <p class="card-text" style="font-size:1.5rem;">
                        <strong class="text-success"><?php echo $data['emparejadas']; ?></strong>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pendientes</h5>
                    <p class="card-text" style="font-size:1.5rem;">
                        <strong class="text-warning"><?php echo $data['pendientes']; ?></strong>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="index.php?action=mostrarAulas" class="btn btn-primary me-2">Ir a aulas</a>
        <a href="index.php?action=formularioImportarCSV" class="btn btn-info me-2">Ir a importar CSV</a>
        <a href="index.php?action=mostrarEtiquetas" class="btn btn-secondary">Ir a etiquetas</a>
    </div>
</div>
