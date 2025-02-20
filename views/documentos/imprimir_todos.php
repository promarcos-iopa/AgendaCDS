<!DOCTYPE html>
<html>

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Imprimir Documentos</title>

	<style>
		label {
			color: #adadad !important;
			font-weight: bold !important;
		}

		.form-control:disabled,
		.form-control[readonly] {
			background-color: #ffffff !important;
			opacity: 1 !important;
		}

		/* Estilos para la tabla */
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}

		th,
		td {
			padding: 12px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		th {
			background-color: #f2f2f2;
		}

		tr:hover {
			background-color: #f9f9f9;
		}


	</style>
</head>

<body>
	<?php require 'views/header.php' ?>
	<div class="container">
		<!-- <h2 class="center">Detalle Agenda</h2> -->
		<div class="card">
			<div class="card-body">
				<form class="row" id="form-imprimir" method="POST">
					<div class="position-relative mb-4">
						<h3>
							<div class="alert alert-primary text-center">Imprimir Documentos</div>
						</h3>
					</div>

					<div class="row">

						<!-- Fecha -->
						<div class="col-md-3 mb-4">
							<label for="fecha" class="form-label">Fecha:</label>
							<input type="date" class="form-control form-control-sm" name="fecha" id="fecha" placeholder="Fecha">
						</div>

                        <div class="col-md-3 mb-4">
                            <label for="documento" class="form-label">Documento:</label>
                            <select class="form-control form-control-sm" id="documento" name="documento">
                                <option value="">Seleccione</option>
                                <option value="consentimiento">Consentimiento</option>
                                <option value="ges">GES</option>
                            </select>
                        </div>


						<!-- Botón de búsqueda -->
						<div class="col-md-3 d-flex align-items-end mb-4">
							<button id="btnImprimir" type="button" class="btn btn-primary btn-sm" style="width: 150px;">Imprimir</button>
						</div>
					</div>
				</form>


			</div>

		</div>
	</div>

	<?php require 'views/footer.php' ?>

    <script>
        $(document).ready(function () {
            $('#btnImprimir').on('click', function (e) {
                // Obtener valores de los campos
                const fecha = $('#fecha').val();
                const documento = $('#documento').val();

                // Validar campos
                if (!fecha) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Falta la Fecha',
                        text: 'Por favor seleccione una fecha.',
                    });
                    return;
                }

                if (!documento) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Falta el Documento',
                        text: 'Por favor seleccione un documento.',
                    });
                    return;
                }
                
                // Construir URL con los datos del formulario
                const baseUrl = "<?php echo constant('URL'); ?>documentos/mostrar_todos_pdf";
                const finalUrl = `${baseUrl}?fecha=${encodeURIComponent(fecha)}&documento=${encodeURIComponent(documento)}`;

                // Abrir nueva ventana
                window.open(finalUrl, '_blank', 'width=800,height=600,resizable=yes');
            });
        });
    </script>
</body>

</html>