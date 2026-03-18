<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Profesores</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #000;
            background-color: #ddd;
            margin: 2px;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Lista de Profesores</h2>

<?php if (!empty($data["listaProfesores"])): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Departamento</th>
            <th>Dirección Mac</th>
        </tr>

        <?php 
        foreach ($data["listaProfesores"] as $profesor): ?>
            <tr>
                <td><?php echo $profesor['id']; ?></td>
                <td><?php echo $profesor['nombre']; ?></td>
                <td><?php echo $profesor['departamento']; ?></td>
                <td><?php echo $profesor['direccion_mac']; ?></td>
                <td>
                    <a class="btn" href="index.php?controller=profesor&action=editar&id=<?php echo $profesor['id']; ?>">Editar</a>
                    <a class="btn" href="index.php?controller=profesor&action=eliminar&id=<?php echo $profesor['id']; ?>" onclick="return confirm('¿Seguro que quieres eliminar este profesor?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p style="text-align:center;">No hay profesores registrados.</p>
<?php endif; ?>

<div style="text-align:center;">
    <a class="btn" href="index.php?controller=profesor&action=formularioCrearProfesor">Añadir Profesor</a>
</div>

</body>
</html>