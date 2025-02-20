<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Crear Bloque Horario</title>
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
        <!-- <h2 class="center">Crear Bloque Horario</h2> -->
		<div class="card">
			<div class="card-body">
				<div class="position-relative mb-4">
					<h3>
						<div class="alert alert-primary text-center">Crear Bloque Horario</div>
					</h3>
					<div id="divInfo" class="alert alert-warning alert-dismissible fade show position-absolute top-0 end-0" style="display: none;">
						<span id="msg"></span>
						<button type="button" id="cierre" class="btn-close" aria-label="Close"></button>
					</div>
				</div>
				<?php //if (!empty($this->mensaje)) { ?>
					<!-- <div class="alert alert-info text-center"><?php //echo $this->mensaje; ?></div> -->
				<?php //} ?>
				<div class="row mt-3">
                    <!-- Formulario para editar los datos del médico -->
                    <!-- <form class="row" action="<?php echo constant('URL'); ?>medicos/crearMedicos" method="POST" enctype="multipart/form-data"> -->
                    <form id="form_bloque_medico" class="row" action="" method="POST" enctype="multipart/form-data">
						<div class="form-group col-md-3">
                            <label for="medico">Médicos:</label>
                            <select class="form-control" id="medico" name="medico">
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="fecha_desde">Fecha Desde:</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_desde" name="fecha_desde" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="fecha_hasta">Fecha Hasta:</label>
                            <input type="date" class="form-control form-control-sm" id="fecha_hasta" name="fecha_hasta" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="hora_inicio">Hora de Inicio:</label>
                            <input type="time" class="form-control form-control-sm" id="hora_inicio" name="hora_inicio" required>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="hora_fin">Hora de Fin:</label>
                            <input type="time" class="form-control form-control-sm" id="hora_fin" name="hora_fin" required>
                        </div>

                        <div class="form-group col-md-3">
							<label for="duracion_consulta">Duración de la Consulta (minutos):</label>
							<input type="number" class="form-control form-control-sm" id="duracion_consulta" name="duracion_consulta" required>
                        </div>
						<div class="form-group col-md-3">
                            <label for="dias">Días:</label>
                            <select class="form-control form-control-sm" id="dias" name="dias[]"  multiple>
								<option value="todos">Todos los días</option>
                            </select>
                        </div>

                       
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button id="bloque_medico" type="button" class="btn btn-guardar btn-sm" style="width: 226px;">
                                <svg class="check-guardar" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="LockRoundedIcon">
                                <path d="M21 7l-12 12L3 12l1.41-1.41L9 15.17l10.59-10.59L21 7z"></path>
                                </svg>
                                Crear Bloque Horario
                            </button>
                        </div>

						<!-- <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button id="horarios_medico" type="button" class="btn btn-guardar" style="width: 226px;">
                                <svg class="check-guardar" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="LockRoundedIcon">
                                <path d="M21 7l-12 12L3 12l1.41-1.41L9 15.17l10.59-10.59L21 7z"></path>
                                </svg>
                                Edpoin
                            </button>
                        </div> -->
                    </form>
				</div>
			</div>
		</div>
	</div>

	<?php require 'views/footer.php'; ?>
	<script src="<?php echo constant('URL'); ?>public/select2/js/select2.full.min.js"></script>
	<script>
        $(document).ready(function(){
			buscarMedicos();
			// buscarConexion18();


			$('#medico').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });

			// Array con los días de la semana
			const dias = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    
			// Agregar las opciones dinámicamente al select
			dias.forEach(function(dia) {
				$('#dias').append(`<option value="${dia.toLowerCase()}">${dia}</option>`);
			});
			
			// Inicializar select2 si es necesario
			$('#dias').select2({
				placeholder: "Selecciona uno o más días",
				allowClear: true
			});

			// Funcionalidad para seleccionar todos los días
			$('#dias').on('change', function() {
				let selectedValues = $(this).val();
				if (selectedValues.includes('todos')) {
					// Si se selecciona 'Todos los días', selecciona todas las demás opciones
					$('#dias').val(dias.map(dia => dia.toLowerCase())).trigger('change');
				}
			});



			// TEST PARA EJECUTAR ENDPOINT CONFIGURADO CON EL TOKEN QUE CONTIENE LA API-KEY DE ACCESO A LA API.
			// $('#horarios_medico').click(function() {
				
			// 	// $.ajax({
			// 	// 	url: 'http://localhost/ApiCitasCds/public/horarios', 
			// 	// 	type: 'GET', // Método de la solicitud
			// 	// 	data: {
			// 	// 		fecha_hora_inicio: '2024-10-09 08:00', 
			// 	// 		fecha_hora_termino: '2024-10-09 13:00', 
			// 	// 		sucursal: 1 // Parámetro sucursal
			// 	// 	},
			// 	// 	headers: {
			// 	// 		'Authorization': '<?php //echo constant('TOKEN'); ?>' // Token de autenticación
			// 	// 	},
			// 	// 	success: function(response) {
			// 	// 		// Manejar la respuesta
			// 	// 		console.log(response);
			// 	// 	},
			// 	// 	error: function(xhr, status, error) {
			// 	// 		// Manejar errores
			// 	// 		console.error('Error:', error);
			// 	// 	}
			// 	// });

			// 	// $.ajax({
			// 	// 	url: 'http://localhost/ApiCitasCds/public/bloque_medico', // Nueva URL del endpoint
			// 	// 	type: 'GET', // Método de la solicitud
			// 	// 	headers: {
			// 	// 		'Authorization': '<?php //echo constant('TOKEN'); ?>' // Token de autenticación
			// 	// 	},
			// 	// 	success: function(response) {
			// 	// 		console.log(response);
			// 	// 		// exit();
			// 	// 	},
			// 	// 	error: function(xhr, status, error) {
			// 	// 		// Manejar errores
			// 	// 		console.error('Error:', error);
			// 	// 	}
			// 	// });

			// 	$.ajax({
			// 		url: "<?php //echo constant('URL');?>bloque/apiCitasCds",
			// 		type: "POST",
			// 		dataType: "json",
			// 		success: function(response) {
			// 			console.log(response);
			// 		},
			// 		error: function(xhr, status, error) {
			// 			console.log(error);
			// 		}
			// 	});


            // });

			
			
			

			$('#bloque_medico').click(function() {
	
				let value = $('#medico').val(); // value contiene el id_medico y el rut del medico
				// Dividir el value por el punto
				let partes = value.split('.');
				// obtener el primer caracter del value (id_medico)
				let id_medico = partes[0]; 
				// obtener elimina el primer caracter del value para obtener el rut medico
				let rut_medico =  partes[1]; 
				let nombre_medico = $('#medico').select2('data')[0].text;
			
				let fecha_desde = $('#fecha_desde').val();
				let fecha_hasta = $('#fecha_hasta').val();
				let hora_inicio = $('#hora_inicio').val();
				let hora_fin = $('#hora_fin').val();
				let duracion_consulta = $('#duracion_consulta').val();
				let array_dias_select = $('#dias').val();

				let data = {id_medico: id_medico, fecha_desde: fecha_desde, fecha_hasta: fecha_hasta, hora_inicio: hora_inicio, hora_fin: hora_fin, 
					duracion_consulta: duracion_consulta, array_dias_select: array_dias_select, rut_medico: rut_medico};

				// Array para almacenar campos vacíos
				let camposVacios = [];

				// Verificar si alguno de los campos está vacío
				if (!id_medico) camposVacios.push("Médico");
				if (!fecha_desde) camposVacios.push("Fecha Desde");
				if (!fecha_hasta) camposVacios.push("Fecha Hasta");
				if (!hora_inicio) camposVacios.push("Hora Inicio");
				if (!hora_fin) camposVacios.push("Hora Fin");
				if (!duracion_consulta) camposVacios.push("Duración Consulta");
				if (!duracion_consulta) camposVacios.push("Días");

				// Si hay campos vacíos, mostrar SweetAlert
				if (camposVacios.length > 0) {
					// Crear un mensaje con los campos vacíos
					let mensaje = "Los siguientes campos están vacíos:\n" + camposVacios.join(", ");
					Swal.fire({
						title: 'Campos Vacíos obligatorios',
						text: mensaje,
						icon: 'warning',
						confirmButtonText: 'Aceptar'
					});
					return false; // Detener la ejecución si hay campos vacíos
				}else{

					$.ajax({
                    url: "<?php echo constant('URL');?>bloque/crearBloqueMedico",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(response){
                        if (response == 'Bloque creado con exito' ){
                            Swal.fire({
								title: "Bloque creado con exito",
								text: `Médico ${nombre_medico}.`,
								icon: 'success'
							}).then((result) => {
								$('#form_bloque_medico')[0].reset();
								$('#dias').val('0').trigger('change'); //reaniciar al valor de carga del select2 
								$('#medico').val('0').trigger('change');
							});

                        }
                    },
                    error: function(xhr, status, error) {
                    console.log(error);
                    }
                    });

				}
			

         

            });


        });


	

		function buscarMedicos() {
			$.ajax({
				type: 'GET',
				url: '<?php echo constant('URL')?>bloque/obtenerMedicos',
				dataType: 'json',
				success: function(response) {
					$("#medico").empty().append('<option value="0" selected disabled>Seleccione Médico</option>');
					
					let len = response.length;
					for (let i = 0; i < len; i++) {
						let id_medico = response[i].id;
						let rut = response[i].rut;
						let nombre = response[i].nombre;
						let apellido1 = response[i].apellido1;
						let apellido2 = response[i].apellido2;
						let full_nombre = nombre + " " + apellido1 + " " + apellido2;

						// Crear un arreglo con el id_medico y el rut
						let value = id_medico+'.'+rut;
						$('#medico').append('<option value="' + value + '">' + full_nombre + '</option>');
					}
				},
				error: function(xhr, status, error) {
					console.log(error);
				}
			});
		}


	</script>
</body>
</html>
