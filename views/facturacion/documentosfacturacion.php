<!DOCTYPE html>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Detalle Facturacion</title>
	<link rel="stylesheet" href="">

	<style>
		label {
            color: #adadad !important;
            font-weight: bold !important;
        }

		
		.clickable-row {
			cursor: pointer;
		}

		.ver-documentos-btn {
			cursor: pointer;
		}
		.documentos-content {
			display: none; /* Ocultar los detalles por defecto */
			transition: height 0.3s ease; /* Efecto de transición suave */
		}


		.css-me949n {
			margin: 0px;
			line-height: 1.5;
			color: rgb(51, 51, 51);
			font-size: 18px;
			font-weight: 500;
		}

		.css-5n7ti0 {
			margin: 0px;
			line-height: 1.5;
			color: #09b5ff;
			font-size: 22px;
			font-weight: 600;
		}

		.logo-usuario2{
			width: 70px;
			/* margin-left: 5px; */
			/* padding-top: 10px; */
			height: auto;
		}

		.datos-container {
            /* background-color: #f0f0f0; */
            /* padding: 20px; */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            overflow: hidden; /* Para clearfix */
			border: 2px solid  #3292ff; /* Borde azul */
        }

		.custom-panel {
			color: #fff;
			background-color:  #76a8ff;
			/* background-color: #3a78ff; */
			display: flex;
			align-items: center;
			padding: 10px;
		}

		

		.panel-title {
			margin: 0;
		}

		

		.css-117ufk5 {
			margin: 0px;
			line-height: 1.5;
			color: #2c79f1;
			font-size: 1rem;
			font-weight: 600;
			/* padding-left: 20px; */

		}

		.form-control:disabled, .form-control[readonly] {
			background-color: #ffffff !important;
			opacity: 1 !important;
		}

		.img-icon {
			width: 28px; /* Tamaño deseado de la imagen */
			height: 28px; /* Tamaño deseado de la imagen */
			margin-right: 8px; /* Espacio entre la imagen y el texto */
		}

		.css-Guardar:hover {
			background-color: #d2e7ee !important; /* Cambia el color de fondo a amarillo al hacer hover */
			color: #0a58ca !important; /* Cambia el color del texto a negro al hacer hover */
		}

		.bg-white {
			background-color: white !important;
		}

		.btn-mas, .btn-menos {
        transition: opacity 0.9s, visibility 0.9s;
		}
		.btn-menos.hidden, .btn-mas.hidden {
			opacity: 0;
			visibility: hidden;
		}

		.detalle-contenedor {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-around;
		}
		

		/* .detalle_documentos {
			border: 1px solid #ccc;
			border-radius: 8px; 
			padding: 10px;
			margin: 5px;
			width: 120px; 
			height: 100px; 
			box-sizing: border-box;
		} */

		.btn-mas, .btn-menos {
			cursor: pointer;
			transition: transform 0.5s ease; /* Suaviza la rotación */
		}

		.rotate {
			transform: rotate(180deg); /* Rota la imagen 180 grados */
		}

		/* MODAL RECETAS */
		 /* Estilos de la modal */
		 .modal {
            display: none; /* Ocultar la modal por defecto */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }

        /* Contenido de la modal */
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Estilos del encabezado */
        .modal-header {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        /* Estilos del contenido */
        .modal-body {
            font-size: 16px;
            color: #555;
        }

        /* Estilos del botón cerrar */
		.close {
            color: #aaa;
            position: absolute; /* Posición absoluta */
            top: 15px; /* Distancia desde la parte superior */
            right: 15px; /* Distancia desde el borde derecho */
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #0d6efd;
            text-decoration: none;
            cursor: pointer;
        }

        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
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

		.rotate {
			transform: rotate(180deg);
			transition: transform 0.5s ease;
		}

		.imgArchivosPDF {
			width: 25px;
			height: 25px;
			/* margin-bottom: 1px; */
		}

		.imgArchivos {
			width: 32px;
			height: 32px;
			margin-bottom: 1px;
		}
		
	</style>
</head>
<body>
	<?php require 'views/header.php'?>
	<div class="container" >
		<!-- <h2 class="center">Detalle Agenda</h2> -->
		<div class="card" >
			<div class="card-body">
				<form class="row" id="form-buscar" action="<?php echo constant('URL'); ?>Facturacion/verPaginacion_Detalle_Optica/1" method="POST">
					<div class="position-relative mb-4">
						<h3>
							<div class="alert alert-primary text-center">Cargar documentos de facturación</div>
						</h3>
					</div>
				</form>
		
				<!-- EXPAN ROW -->
				<div class="table-responsive text-center mt-3">
					<table id="tblDocumentos" class="table mx-auto">
						<thead style="color: #0d70fd;">
							<tr>
								<th style="display:none;">ID</th>
								<th>Centro</th>
								<th>Subir Documento 
									<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivosPDF" style="margin-left: 10px; vertical-align: middle;">
								</th>
								<th style="display:none;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								
								date_default_timezone_set('America/Santiago');
								// Obtener la fecha y hora actual
								$fechaHora_actual = date('Y-m-d H:i:s');
								// Array para almacenar los nombres de los centros sin repetir
								// $centros_unicos = [];
								$centros_unicos = ["ALESSANDRI", "AGUILUCHO", "LENG"];
								// Imprimir la fecha y hora actual
								// echo "Fecha y hora actual en Santiago de Chile: $fechaHora_actual<br>";
								// Recorrer e imprimir los centros únicos
								foreach ($centros_unicos as $centro) {
									// $centro;

							?>
							<tr >
								<td style="display:none;"></td>
								<td style="font-weight: bold;color: #76818d;text-align: center;padding-top: 12px"><?php echo $centro; ?></td> 
								<td colspan="7">
								<!-- modal_cargar -->
								<!-- detalle_documentos -->
									<div class="modal_cargar" style="display: flex; gap: 20px;justify-content: center;">
										<a href="#" class="descarga ges" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/subiendo (1).png" alt="Icono PDF" class="imgArchivos">
										</a>
									</div>
								</td>
							</tr>
							<?php
								}
								
							?>
						</tbody>
					</table>
				</div>
			</div>
			
		</div>
	</div>
	
	<!-- MODAL CARGAR DOCUMENTOS DE FACTURACIÓN -->
<div id="modal_cargar_documentos" class="modal">
    <!-- Contenido de la modal -->
    <div class="modal-content">
        <span class="close" id="closeModalBtn2">&times;</span>
        <div class="modal-header">
            <h5>Cargar documentos de facturación</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" class="form-control" id="fecha" value="<?php echo $fecha_atencion; ?>">
            <input type="hidden" class="form-control" id="rut" value="<?php echo $paciente; ?>">

            <!-- Agrupar "Mes" y "Año" en una fila -->
            <div class="row mb-3">
                <!-- Select de Mes -->
                <div class="col-md-6">
                    <label for="mes" class="form-label">Selecione mes</label>
                    <select class="form-control form-control-sm mb-3" id="mes" name="mes"></select>
                </div>

                <!-- Input Año alineado a la derecha -->
                <div class="col-md-6">
                    <label for="anio" class="form-label">Año</label>
                    <input type="text" class="form-control form-control-sm" name="anio" id="anio" disabled>
                </div>

				<!-- select tipo documento  -->
				<div class="col-md-6">
                    <label for="tipo_documento" class="form-label">Selecione tipo documento</label>
                    <select class="form-control form-control-sm mb-3" id="tipo_documento" name="tipo_documento"></select>
                </div>

				<!-- select tipo programa  -->
				<div class="col-md-6">
                    <label for="tipo_programa" class="form-label">Selecione tipo documento</label>
                    <select class="form-control form-control-sm mb-3" id="tipo_programa" name="tipo_programa"></select>
                </div>

				<!-- Input folio -->
                <div class="col-md-6">
                    <label for="folio" class="form-label">N° Folio</label>
                    <input type="text" class="form-control form-control-sm" name="folio" id="folio" placeholder="Ingresa número de folio">
                </div>
            </div>

            <p>Centro: <b id="centro_cierre_factura"></b></p>

            <div class="input-group mb-3">
                <input type="file" class="form-control" id="archivo">
                <!-- <label class="input-group-text" for="archivo_ges">Cargar</label> -->
            </div>
            <button type="button" class="btn btn-primary" id="uploadButton">Subir Archivo</button>
        </div>
        
    </div>
</div>
	
	<div id="gesContainer" class="recetas" style="padding-bottom: 40px;margin-bottom: 70px;"></div>
	<?php require 'views/footer.php'?>
	<script src="<?php echo constant('URL'); ?>public/select2/js/select2.full.min.js"></script>
	<script>

		$(document).ready(function(){
			
			// identifica el elemeto al cual se realizo el evento click
			$('#tblDocumentos').on('click', '.descarga', function(e) {
				e.preventDefault(); 
				// debugger;
				var valor = $(this).closest('tr').find('td');
				var centro = valor.eq(1).text();

				$('#modal_cargar_documentos').fadeIn();
				 // Asigna los valores a los elementos <b>
				$("#centro_cierre_factura").text(centro);
				cargar_mes();
				cargar_tipo_documentos();
				cargar_tipo_programa();
				//Obtener el año actual 
				var anio = new Date().getFullYear();
				$('#anio').val(anio); // Asignar el valor de la fecha al input de fecha

				
				
			});


			
			$('.close').click(function() {
				var elementId = $(this).attr('id');  // Obtiene el id del elemento que ejecutó el clic
				// console.log("ID del elemento clickeado:", elementId); 

				if(elementId =='closeModalBtn2'){
					$('#modal_cargar_documentos').fadeOut();

				}

			});

			// $("#uploadButton").on("click", function(){
			// 	var formData = new FormData();
			// 	var file = $("#archivo")[0].files[0];
			// 	var anio=$('#anio').val();
			// 	var valor_mes = $('#mes').val();
			// 	var texto_mes = $('#mes option:selected').text();
			// 	var tipo_documento = $('#tipo_documento').val();
			// 	var folio = $('#folio').val();
			// 	var centro = $('#centro_cierre_factura').text();
				
			// 	if(file){
			// 		Swal.fire({
			// 			title: '¿Está seguro de guardar el archivo?',
			// 			icon: 'warning',
			// 			showCancelButton: true,
			// 			confirmButtonColor: '#3085d6',
			// 			cancelButtonColor: '#d33',
			// 			confirmButtonText: 'Aceptar',
			// 			cancelButtonText: 'Cancelar'
			// 		}).then((result) => {
			// 			if (result.isConfirmed)
			// 			{
			// 			Swal.fire({
			// 				title: 'Cargando...',
			// 				allowOutsideClick: false,
			// 				allowEscapeKey: false,
			// 				allowEnterKey: false,
			// 				showConfirmButton: false,
			// 				willOpen: () => {
			// 					Swal.showLoading();
			// 				}
			// 			});
			// 			formData.append("archivo", file);
			// 			formData.append("anio", anio);  
			// 			formData.append("valor_mes", valor_mes);  
			// 			formData.append("texto_mes", texto_mes);  
			// 			formData.append("tipo_documento", tipo_documento);  
			// 			formData.append("folio", folio);  
			// 			formData.append("centro", centro);  
			// 			$.ajax({
			// 				url: "<?php echo constant('URL'); ?>facturacion/CargarArchivos",
			// 				type: "POST",
			// 				data: formData,
			// 				contentType: false, // No definir contentType para evitar conflictos con FormData
			// 				processData: false, // No procesar los datos para evitar conflictos con FormData
			// 				dataType: 'json',
			// 				success: function(response)
			// 				{
			// 					// const response = JSON.parse(response);
			// 					console.log("Archivo subido exitosamente:", response);
			// 					if(response.success === true)
			// 					{
			// 						Swal.fire({
			// 						title: 'Archivo Cargado!',
			// 						icon: 'success',
			// 						showCancelButton: false,
			// 						confirmButtonColor: '#3085d6',
			// 						cancelButtonColor: '#d33',
			// 						confirmButtonText: 'OK'
			// 						}).then((result) => {
			// 						$('#cargar').modal('hide');
			// 						});
			// 					}
			// 					else
			// 					{
			// 						Swal.fire({
			// 						title: response.message+ "asdasasd",
			// 						icon: 'error',
			// 						showCancelButton: false,
			// 						confirmButtonColor: '#3085d6',
			// 						cancelButtonColor: '#d33',
			// 						confirmButtonText: 'OK'
			// 						});
			// 					}
			// 					// Aquí puedes agregar lógica adicional después de la subida exitosa
			// 				},
			// 				error: function(xhr, status, error)
			// 				{
			// 					console.error("Error al subir el archivo:", status, error);
			// 					Swal.fire({
			// 						title: 'Error al subir el archivo.!',
			// 						icon: 'error',
			// 						showCancelButton: false,
			// 						confirmButtonColor: '#3085d6',
			// 						cancelButtonColor: '#d33',
			// 						confirmButtonText: 'OK'
			// 					});
			// 				}
			// 			});
			// 			}
			// 		});

			// 	}else{
			// 		console.log("Por favor, seleccione un archivo antes de intentar subirlo.");
			// 		// error
			// 		Swal.fire({
			// 		title: 'Por favor, seleccione un archivo antes de intentar subirlo.!',
			// 		icon: 'error',
			// 		showCancelButton: false,
			// 		confirmButtonColor: '#3085d6',
			// 		cancelButtonColor: '#d33',
			// 		confirmButtonText: 'OK'
			// 		});
			// 	}
			// });




			$("#uploadButton").on("click", function(){
				var formData = new FormData();
				var file = $("#archivo")[0].files[0];
				var anio = $('#anio').val();
				var valor_mes = $('#mes').val();
				var texto_mes = $('#mes option:selected').text();
				var tipo_documento = $('#tipo_documento').val();
				var folio = $('#folio').val();
				var centro = $('#centro_cierre_factura').text();
				var valor_programa = $('#tipo_programa').val();
				var texto_programa = $('#tipo_programa option:selected').text();
			

				// Validaciones de los campos requeridos
				if (!file) {
					Swal.fire({ title: 'Debe seleccionar un archivo.', icon: 'error', confirmButtonText: 'OK' });
					return;
				}
				if (!valor_mes) {
					Swal.fire({ title: 'Debe seleccionar un mes para asociar el documento.', icon: 'error', confirmButtonText: 'OK' });
					return;
				}
				if (!tipo_documento) {
					Swal.fire({ title: 'Debe seleccionar un tipo de documento.', icon: 'error', confirmButtonText: 'OK' });
					return;
				}
				if (!folio) {
					Swal.fire({ title: 'Debe ingresar el folio.', icon: 'error', confirmButtonText: 'OK' });
					return;
				}
				if (!centro.trim()) { // trim() para eliminar espacios vacíos
					Swal.fire({ title: 'El centro de facturación no puede estar vacío.', icon: 'error', confirmButtonText: 'OK' });
					return;
				}

				if (!valor_programa) {
					Swal.fire({ title: 'Debe seleccionar un programa para asociar el documento.', icon: 'error', confirmButtonText: 'OK' });
					return;
				}

				Swal.fire({
					title: '¿Está seguro de guardar el archivo?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar',
					cancelButtonText: 'Cancelar'
				}).then((result) => {
					if (result.isConfirmed) {
						Swal.fire({
							title: 'Cargando...',
							allowOutsideClick: false,
							allowEscapeKey: false,
							allowEnterKey: false,
							showConfirmButton: false,
							willOpen: () => { Swal.showLoading(); }
						});

						formData.append("archivo", file);
						formData.append("anio", anio);
						formData.append("valor_mes", valor_mes);
						formData.append("texto_mes", texto_mes);
						formData.append("tipo_documento", tipo_documento);
						formData.append("folio", folio);
						formData.append("centro", centro);
						formData.append("valor_programa", valor_programa);
						formData.append("texto_programa", texto_programa);

						$.ajax({
							url: "<?php echo constant('URL'); ?>facturacion/CargarArchivos",
							type: "POST",
							data: formData,
							contentType: false, 
							processData: false, 
							dataType: 'json',
							success: function(response) {
								console.log("Archivo subido exitosamente:", response);
								if (response.success === true) {
									Swal.fire({
										title: 'Archivo Cargado!',
										icon: 'success',
										confirmButtonColor: '#3085d6',
										confirmButtonText: 'OK'
									}).then(() => { 
										$('#folio').val(''); 
										$('#archivo').val('');
										$('#modal_cargar_documentos').fadeOut();
										
									});
								} else {
									Swal.fire({
										title: response.message || 'Error desconocido al subir el archivo.',
										icon: 'error',
										confirmButtonColor: '#3085d6',
										confirmButtonText: 'OK'
									});
								}
							},
							error: function(xhr, status, error) {
								console.error("Error al subir el archivo:", status, error);
								Swal.fire({
									title: 'Error al subir el archivo.',
									icon: 'error',
									confirmButtonColor: '#3085d6',
									confirmButtonText: 'OK'
								});
							}
						});
					}
				});
			});

		
			
		});
		
	

		function cargar_tipo_documentos() {
			var documentos = [
				{value: 'FACTURA', text: 'Factura'},
				{value: 'NOTA_DEBITO', text: 'Nota de Débito'},
				{value: 'NOTA_CREDITO', text: 'Nota de Crédito'}
        	];

			// Limpiar el select antes de agregar nuevas opciones
			$('#tipo_documento').empty();

			// Agregar la opción por defecto
			$('#tipo_documento').append('<option value="" disabled selected>Seleccione tipo de documento</option>');

			// Iterar sobre el array de documentos y agregar cada opción
			documentos.forEach(function(doc) {
				$('#tipo_documento').append('<option value="' + doc.value + '">' + doc.text + '</option>');
			});

			
		}


		function cargar_tipo_programa() {
			var documentos = [
				{value: 'GES', text: 'GES'},
				{value: 'RES', text: 'RESOLUTIVIDAD'}
        	];

			// Limpiar el select antes de agregar nuevas opciones
			$('#tipo_programa').empty();

			// Agregar la opción por defecto
			$('#tipo_programa').append('<option value="" disabled selected>Seleccione tipo de programa</option>');

			// Iterar sobre el array de documentos y agregar cada opción
			documentos.forEach(function(doc) {
				$('#tipo_programa').append('<option value="' + doc.value + '">' + doc.text + '</option>');
			});

			
		}


		function cargar_mes() {
			let meses = [
				"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
				"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
			];

			// let mesSeleccionado = $("#mes_selecionado").val(); // Obtener el valor guardado

			// Limpiar el select y agregar la opción por defecto
			$("#mes").empty().append('<option value="0" selected disabled>Seleccione Mes</option>');

			// Llenar el select con los meses
			meses.forEach((mes, index) => {
				$('#mes').append('<option value="' + (index + 1) + '">' + mes + '</option>');
			});

			
		}


		

	</script>
</body>
</html>