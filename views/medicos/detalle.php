<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detalle del Médico</title>
	<!-- FontAwesome for icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<!-- Bootstrap CSS for grid and styling -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Custom CSS for additional styling -->
	<style>
		.container {
			margin-top: 40px;
		}
		.card {
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
			border-radius: 10px;
		}
		.btn-custom {
			background-color: #007bff;
			border: none;
			color: white;
			padding: 10px 20px;
			font-size: 16px;
			border-radius: 5px;
		}
		.btn-custom:hover {
			background-color: #0056b3;
			color: white;
		}
		.img-preview {
			max-width: 150px;
			margin-top: 10px;
			border-radius: 8px;
			box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
		}
		.btn-warning {
			color: #ffffff !important;
			background-color: #ffc107;
			border-color: #ffc107;
		}
        /* label {
            color: #074994 !important;
            font-weight: bold !important;
        } */
		label {
            color: #adadad !important;
            font-weight: bold !important;
        }
	</style>
</head>
<body>
	<?php require 'views/header.php'; ?>
	<div class="container">
        <!-- <h2 class="center">Datos Del Médico</h2> -->
		<form class="border rounded bg-light p-3">
			<div class="position-relative mb-4">
                <h3>
                    <div class="alert alert-primary text-center">Datos Del Médico</div>
                </h3>
                <div id="divInfo" class="alert alert-warning alert-dismissible fade show position-absolute top-0 end-0" style="display: none;">
                    <span id="msg"></span>
                    <button type="button" id="cierre" class="btn-close" aria-label="Close"></button>
                </div>
            </div>
			<div class="card-header">
				<a href="<?php echo constant('URL'); ?>medicos/verPaginacion/1" class="btn btn-warning btn-sm" style="width: 180px;"> &larr; Volver</a>
			</div>
			<div class="card-body">
				<?php if (!empty($this->mensaje)) { ?>
					<div class="alert alert-info text-center"><?php echo $this->mensaje; ?></div>
				<?php } ?>
				<div class="row">
                    <!-- Formulario para editar los datos del médico -->
                    <form class="row" action="<?php echo constant('URL'); ?>medicos/actualizarMedicos" method="POST" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" id="rut" name="rut" value="<?php echo $this->medicos->id; ?>">

                        <div class="form-group col-md-3">
                            <label for="rut">RUT Médico:</label>
                            <input type="text" class="form-control form-control-sm" id="rut" name="rut" value="<?php echo $this->medicos->rut; ?>" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" value="<?php echo $this->medicos->nombre; ?>" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="apellido1">Primer Apellido:</label>
                            <input type="text" class="form-control form-control-sm" id="apellido1" name="apellido1" value="<?php echo $this->medicos->apellido1; ?>" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="apellido2">Segundo Apellido:</label>
                            <input type="text" class="form-control form-control-sm" id="apellido2" name="apellido2" value="<?php echo $this->medicos->apellido2; ?>" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $this->medicos->fecha_nacimiento; ?>" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="direccion">Dirección:</label>
                            <input type="text" class="form-control form-control-sm" id="direccion" name="direccion" value="<?php echo $this->medicos->direccion; ?>" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="especialidad">Especialidad:</label>
                            <input type="text" class="form-control form-control-sm" id="especialidad" name="especialidad" value="<?php echo $this->medicos->especialidad; ?>" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" value="<?php echo $this->medicos->email; ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control form-control-sm" id="telefono" name="telefono" value="<?php echo $this->medicos->telefono; ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label for="estado">Estado:</label>
                            <select class="form-control form-control-sm" id="estado" name="estado">
                                <option value="activo" <?php echo $this->medicos->estado == 'activo' ? 'selected' : ''; ?>>Activo</option>
                                <option value="inactivo" <?php echo $this->medicos->estado == 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                            </select>
                        </div>

                        <!-- <div class="form-group col-md-3">
                            <label for="foto">Foto del Médico:</label>
                            <input type="file" class="form-control foto" id="foto" name="foto">
                            <img src="<?php echo $this->medicos->foto; ?>" alt="Foto Médico" class="img-fluid img-preview">
                        </div> -->

                        <!-- <div class="form-group col-md-4">
                            <button type="submit" class="btn btn-custom btn-block">Grabar Médico</button>
                        </div> -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button id="guardarContacto" type="button" class="btn btn-guardar btn-sm" style="width: 226px;">
                                <svg class="check-guardar" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="LockRoundedIcon">
                                <path d="M21 7l-12 12L3 12l1.41-1.41L9 15.17l10.59-10.59L21 7z"></path>
                                </svg>
                                Guardar datos
                            </button>
                        </div>
                    </form>
				</div>
			</div>
		</form>
	</div>

	<?php require 'views/footer.php'; ?>

	<script>
		// Previsualización de la imagen seleccionada
		$(".foto").change(function() {
			var imagen = this.files[0];
			if (imagen) {
				if (imagen.type != "image/jpeg" && imagen.type != "image/png") {
					$(".foto").val("");
					alert("La imagen debe estar en formato JPG o PNG.");
				} else if (imagen.size > 2000000) {
					$(".foto").val("");
					alert("La imagen no debe pesar más de 2MB.");
				} else {
					var datosImagen = new FileReader();
					datosImagen.readAsDataURL(imagen);
					$(datosImagen).on("load", function(event) {
						var rutaImagen = event.target.result;
						$(".img-preview").attr("src", rutaImagen);
					});
				}
			}
		});
	</script>
</body>
</html>
