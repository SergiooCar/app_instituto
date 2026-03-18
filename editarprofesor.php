<! viwes/profesores/editar.php>
<?php $profesor = $data['profesor']; ?> <!-- Obtener el profesor desde los datos pasados al view -->
<div class="container mt-4">
    <h1 class="mb-4"> Editar profesor</h1>
    <!--
     -post envia los datos de forma oculta
    -->
    <form method="post" action="index.php" class="col-md-6">
        <input type="hidden" name="action" value="editarProfesor">

        <!-- en hidden
        - campo oculto con el id del profesor
        - al final el hidden manejara los datos de manera que solamete se 
        - enviara el id del profesor para que el controlador sepa cual profesor editar, sin mostrarlo en la interfaz de usuario
        -->
        <input type="hidden" name="id" value="<= $profesor-> getId() ?>">

            <div class="mb-3"><!-- campo para el nombre profesor-->
                <Label for="nombre" class="from-label">Nombre: </Label><!-- esto es basicamente la etiqueta del campo-->
                <input type="text" id="nombre" name="nombre" class="form-control" value="<?= $profesor->getNombre() ?>" required> 
            </div>
            <div class="mb-3">
            <label for="departamento" class="form-label">Departamento:</label>        
            <!-- 
              Campo de texto para el departamento
              - No lleva required porque puede ser opcional
              - value="<?= $profesor->getDepartamento() ?>": valor actual
            -->
            <input type="text" id="departamento" name="departamento" class="form-control" 
                   value="<?= $profesor->getDepartamento() ?>">
        </div>
        
        <!-- Grupo de formulario para la dirección MAC -->
        <div class="mb-3">
            <label for="direccion_mac" class="form-label">Dirección MAC:</label>
            
            <!-- 
              Campo de texto para la MAC
              - placeholder: texto orientativo del formato esperado
              - pattern: expresión regular básica para formato MAC (opcional, mejora la validación)
              - title: mensaje que aparece si no cumple el pattern
            -->
            <input type="text" id="direccion_mac" name="direccion_mac" class="form-control" 
                   value="<?= $profesor->getDireccionMac() ?>"
                   placeholder="00:11:22:AA:BB:CC"
                   pattern="^([0-9A-Fa-f]{2}[:-]){5}([0-9A-Fa-f]{2})$"
                   title="Formato de MAC: 00:11:22:AA:BB:CC">
        </div>
        
        <!-- Contenedor para los botones con flexbox -->
        <div class="d-flex gap-2">
            
            <!-- 
              Botón de enviar el formulario
              - type="submit": envía el formulario
              - btn: clase base de Bootstrap
              - btn-primary: color azul (principal)
              - me-2: margen derecho
            -->
            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
            
            <!-- 
              Enlace para cancelar y volver al listado
              - href: acción que muestra el listado de profesores
              - btn btn-secondary: botón gris de estilo secundario
            -->
            <a href="index.php?action=mostrarProfesores" class="btn btn-secondary">Cancelar</a>
        </div>
        
        <!-- 
          Nota: No incluimos </form> dentro del div para mantener la estructura correcta
        -->
    </form>
    <!-- Fin del formulario -->
    
</div>
<!-- Fin del contenedor principal -->

                
