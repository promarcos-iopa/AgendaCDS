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

		.imgArchivos {
			width: 25px;
			height: 25px;
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
				<form class="row" id="form-buscar" action="<?php echo constant('URL'); ?>facturacion/verPaginacion_Detalle_Optica/1" method="POST">
					<div class="position-relative mb-4">
						<h3>
							<div class="alert alert-primary text-center">Detalle Facturación </div>
						</h3>
					</div>
					<input type="hidden" id="datos_informe" name="datos_informe" value="<?php echo htmlspecialchars(json_encode($this->datos_informe)); ?>">
					<input type="hidden" id="filtro_fecha" name="filtro_fecha" value="<?php echo $this->fecha; ?>">
					<input type="hidden" id="filtro_fecha_hasta" name="filtro_fecha_hasta" value="<?php echo $this->fecha_hasta; ?>">
					<input type="hidden" id="msg" name="msg" value="<?php echo $this->mensaje; ?>">
					
					
					<div class="row">

						<div class="col-md-3">
							<label for="mes" class="form-label">Bucador por mes</label>
							<select class="form-control mb-3" id="mes" name="mes">
                        </select>
						</div>
						
						<!-- Fecha Desde -->
						<div class="col-md-3">
							<label for="anio" class="form-label">Buscador por año</label>
							<input type="hidden" class="form-control form-control-sm" name="mes_selecionado" id="mes_selecionado" value="<?php echo $this->mes; ?>">
							<input type="text" class="form-control form-control-sm" name="anio" id="anio" disabled>
						</div>

						<!-- Botón de búsqueda -->
						<div class="col-md-3 d-flex align-items-end">
							<button id="btnbuscar" type="submit" class="btn btn-primary btn-sm" style="width: 150px;">Buscar</button>
						</div>
					</div>
				</form>
		
				<!-- EXPAN ROW -->
				<div class="table-responsive text-center mt-3">
					<table id="tblDocumentos" class="table mx-auto">
						<thead style="color: #0d70fd;">
							<tr>
								<th>Centro</th>
								<th>Documentos</th>
								<th style="display:none;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								include_once 'models/medicos.php';
								date_default_timezone_set('America/Santiago');
								// Obtener la fecha y hora actual
								$fechaHora_actual = date('Y-m-d H:i:s');
								// Array para almacenar los nombres de los centros sin repetir
								// $centros_unicos = [];
								$centros_unicos = ["ALESSANDRI", "AGUILUCHO", "LENG"];
								// Imprimir la fecha y hora actual
								// echo "Fecha y hora actual en Santiago de Chile: $fechaHora_actual<br>";
								foreach($this->citas as $index => $row){
									$fecha_atencion = $row["fecha_atencion"];
									// echo "Fecha y hora de atención: $fecha_atencion<br>";
									
									// Dividir la cadena en fecha y hora
									list($fecha, $hora) = explode(' ', $fecha_atencion);
									
									// $centro = $row["centro"];

									// // Verificar si el centro ya está en el array
									// if (!in_array($centro, $centros_unicos)) {
									// 	$centros_unicos[] = $centro; // Agregar centro si no existe en el array
									// }
								}
								// Recorrer e imprimir los centros únicos
								
								foreach ($centros_unicos as $centro) {
									// $centro;
								
								

							?>
							<tr >
								<!-- <td style="text-align: center;"><?php //echo $row["rut_pnatural"]; ?></td> -->
								<td style="font-weight: bold;color: #76818d;text-align: center;padding-top: 20px"><?php echo $centro; ?></td> 
								<td colspan="7">
									<div class="detalle_documentos" style="display: flex; gap: 20px;justify-content: center;">
										<a href="#" class="descargar_excel_ges" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/excel.png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">GES</span>
										</a>
										<a href="#" class="descargar_excel_resolutividad" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/excel.png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Resolutividad</span>
										</a>
										<a href="#" class="descarga ges" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Facturas</span>
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
	
	<!-- MODAL REFRACCION-->
    <div id="modal_facturacion" class="modal">
        <!-- Contenido de la modal -->
        <div class="modal-content">
            <span class="close" id="closeModalBtn2">&times;</span>
            <div class="modal-header">
				Documentos
            </div>
            <div class="modal-body">
                <p class="facturacion"></p>
				<!-- Tabla dinámica -->
                <table id="tabla_refracciones">
                    <thead>
                        <tr>
                            <th>Detalle documento</th>
                            <th>Documentos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas se agregarán aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	
	<div id="gesContainer" class="recetas" style="padding-bottom: 40px;margin-bottom: 70px;"></div>
	<?php require 'views/footer.php'?>
	<script src="<?php echo constant('URL'); ?>public/select2/js/select2.full.min.js"></script>
	<script>

		$(document).ready(function(){

			buscarMes();
			//Obtener el año actual 
			var anio = new Date().getFullYear();
			$('#anio').val(anio); // Asignar el valor de la fecha al input de fecha

			$('#mes').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });

			var mesg = $('#msg').val(); // Obtener el valor del input hidden
			console.log("trm",mesg);
			if (mesg.trim() !='') {
				console.log("enel trm",mesg);
				Swal.fire({
					title: "¡Atención!",
					text: mesg,
					icon: 'warning',
					confirmButtonText: 'Aceptar'
				}).then((result) => {
					$('#msg').val(''); // Limpiar el input para evitar duplicados
					
				});
				
			}else{
				Swal.fire({
					title: "¡Éxito!",
					text: "Los datos se han cargado correctamente.",
					icon: "success",
					confirmButtonText: "Aceptar"
				}).then((result) => {
					$("#msg").val(""); // Limpiar el input para evitar duplicados
				});

			}

			

			var respuestasGes = [];

			
			// identifica el elemeto al cual se realizo el evento click para abrir modal facturacion
			$('#tblDocumentos').on('click', '.descarga', function(e) {
				e.preventDefault(); 
				// debugger;
				// Obtener el tipo de documento haciendo clic en el elemento específico
				let tipoDocumento = $(this).find('span').text();
				var valor = $(this).closest('tr').find('td');
				var centro = valor.eq(0).text();
				var anio = $("#anio").val();
				var valor_mes = $("#mes").val();
				var text_mes = $("#mes").find("option:selected").text();

				if (!valor_mes) {
					var meses = [
						"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
						"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
					];

					var fecha = new Date();
					text_mes = meses[fecha.getMonth()]; // Obtiene el mes actual en español
					
					
				}

				if(tipoDocumento == "Facturas"){
					$('#modal_facturacion').fadeIn();
					cargar_documentos_facturacion(centro, anio, text_mes);
				}

			});


			
			$('.close').click(function() {
				var elementId = $(this).attr('id');  // Obtiene el id del elemento que ejecutó el clic
				// console.log("ID del elemento clickeado:", elementId); 
				if(elementId =='closeModalBtn1'){
					$('#modal_recetas').fadeOut();

				}else if(elementId=='closeModalBtn2'){
					$('#modal_facturacion').fadeOut();
					
				}

			});

		

			$('#modal_facturacion').on('click', '.descarga', function() {
				// Aquí dentro puedes manejar lo que sucede cuando se hace click en cualquier <td> con clase 'descarga'
				// Accede a los valores de las celdas de la fila
				let valor = $(this).closest('tr').find('td');

				let url_formulario_ges = valor.eq(0).text();
				let ventanaEmergente = window.open('', '_blank', 'width=800,height=600');

				if (ventanaEmergente) {
					ventanaEmergente.location.href = url_formulario_ges;
				} else {
					// alert('No se pudo abrir la ventana emergente. Verifica la configuración de tu navegador.');
					Swal.fire({
                            title: "¡No se pudo abrir la ventana emergente. Verifica la configuración de tu navegador!",
                            icon:'warning'
                    }).then((result) => {
                       
                    });
				}
				

			});
			
		});


		
		$('#tblDocumentos').on('click', '.descargar_excel_ges', function() {
			var valor = $(this).closest('tr').find('td');
			var centro = valor.eq(0).text();
			var datos_informe = $("#datos_informe").val();
			var nombre_carpeta = "";
			
			if(centro == "ALESSANDRI"){
				nombre_carpeta = "informe_centro_alessandri";

			}else if(centro == "AGUILUCHO"){
				nombre_carpeta = "informe_centro_aguilucho";

			}else if(centro == "LENG"){
				nombre_carpeta = "informe_centro_leng";

			}

			// Hacer la solicitud AJAX usando POST en lugar de GET
			$.ajax({
				type: 'POST',
				url: '<?php echo constant('URL') ?>facturacion/descargarExcel',
				data: {
					valor: 1,
					datos: datos_informe,
					centro: centro
				}, // Parámetros enviados en la solicitud
				dataType: 'json',
				success: function(response) {
					console.log("Respuesta del servidor:", response);

					// Verifica si la respuesta contiene un archivo
					if (response == 'Excel Descargado Correctamente') {

						// var nomArchivo = 'Informe_Optica.xlsx';
						var nomArchivo = 'Informe_programa_ges_' + centro.toLowerCase() + '.xlsx';
						var link = document.createElement("a");
						// Ruta del archivo que fue descargado en el servidor
						link.href = "<?php echo constant('URL') . 'views/facturacion/' ?>" + nombre_carpeta + "/" + nomArchivo;
						// Nombre del archivo que deseas que tenga al descargarse
						link.download = nomArchivo;
						// Crear y simular el clic en el enlace
						document.body.appendChild(link);
						link.click();
						document.body.removeChild(link);
					} else {
						// Manejo de error en el caso de que no se haya podido generar el archivo
						console.error("No se pudo generar el archivo.");
					}
				},
				error: function(xhr, status, error) {
					// Log del error para depuración
					console.error("Error en la solicitud:", error);
					console.error("Detalles:", xhr.responseText);

					// Mostrar el botón habilitado nuevamente
					$('#exportar_Excel_optica').prop("disabled", false);
				},
				complete: function() {
					// Asegura que el botón se habilite al terminar la solicitud, en caso de éxito o error
					$('#exportar_Excel_optica').prop("disabled", false);
				}
			});
		});


		
		$('#tblDocumentos').on('click', '.descargar_excel_resolutividad', function() {
			var valor = $(this).closest('tr').find('td');
			var centro = valor.eq(0).text();
			var datos_informe = $("#datos_informe").val();
			var nombre_carpeta = "";
			
			if(centro == "ALESSANDRI"){
				nombre_carpeta = "informe_centro_alessandri";

			}else if(centro == "AGUILUCHO"){
				nombre_carpeta = "informe_centro_aguilucho";

			}else if(centro == "LENG"){
				nombre_carpeta = "informe_centro_leng";

			}
			// Hacer la solicitud AJAX usando POST en lugar de GET
			$.ajax({
				type: 'POST',
				url: '<?php echo constant('URL') ?>facturacion/descargarExcel',
				data: {
					valor: 2,
					datos: datos_informe,
					centro: centro
				}, // Parámetros enviados en la solicitud
				dataType: 'json',
				success: function(response) {
					console.log("Respuesta del servidor:", response);

					// Verifica si la respuesta contiene un archivo
					if (response == 'Excel Descargado Correctamente') {

						// var nomArchivo = 'Informe_Optica.xlsx';
						var nomArchivo = 'Informe_programa_resolutividad_' + centro.toLowerCase() + '.xlsx';
						var link = document.createElement("a");
						// Ruta del archivo que fue descargado en el servidor
						link.href = "<?php echo constant('URL') . 'views/facturacion/' ?>" + nombre_carpeta + "/" + nomArchivo;
						// Nombre del archivo que deseas que tenga al descargarse
						link.download = nomArchivo;
						// Crear y simular el clic en el enlace
						document.body.appendChild(link);
						link.click();
						document.body.removeChild(link);
					} else {
						// Manejo de error en el caso de que no se haya podido generar el archivo
						console.error("No se pudo generar el archivo.");
					}
				},
				error: function(xhr, status, error) {
					// Log del error para depuración
					console.error("Error en la solicitud:", error);
					console.error("Detalles:", xhr.responseText);

					// Mostrar el botón habilitado nuevamente
					$('#exportar_Excel_optica').prop("disabled", false);
				},
				complete: function() {
					// Asegura que el botón se habilite al terminar la solicitud, en caso de éxito o error
					$('#exportar_Excel_optica').prop("disabled", false);
				}
			});
		});




		function cargar_documentos_facturacion(centro, anio, text_mes){
			// debugger;
			$.ajax({
				type: 'POST',
				url: '<?php echo constant('URL') ?>facturacion/cargar_documentos',
				data: {
					centro: centro,
					anio: anio,
					mes: text_mes
				}, // Parámetros enviados en la solicitud
				dataType: 'json',
				success: function(response) {
					console.log("Respuesta del servidor:", response);
					// debugger;
					// Verificar que sea un arreglo y tenga datos
					let htmlContent = '';

					if(response.success === true) {
						// Acceder al array de datos
						const datos = response.datos;

						$('.facturacion').empty(); // Limpiar contenido previo
						// Acceder al array de dato

						// Recorrer el array con forEach
						datos.forEach(dato => {
						// Accedemos a las propiedades del objeto actual
							let centro = dato.centro;
							let mes = dato.mes;
							let anio = dato.anio;
							let tipo_documento = dato.tipo_documento;
							let tipo_programa = dato.tipo_programa;
							let folio = dato.folio;
							let nombre_archivo = dato.nombre_archivo;
							let fecha_registro_subida = dato.fecha_registro_subida;

							// Generar la URL del archivo
							let url = "https://www.iopanet.cl/agenda_medica_cds/public/PDF/DOCUMENTOS_FACTURACION/" + centro + "/" + mes + "/" + nombre_archivo;

							// Crear el HTML para cada fila
							htmlContent += '<tr>';
							htmlContent += '<td style="display: none;">' + url + '</td>';
							htmlContent += '<td style="font-size: 14px; padding-left: 15px;">' + tipo_documento + ' ' +  tipo_programa +' ' +  mes + ' del ' +  anio +'</td>';
							htmlContent += '<td><a href="' + url + '" target="_blank"><img src="<?php echo constant('URL'); ?>public/img/pdf.png" alt="Descargar" class="descarga" style="width: 30px; height: 32px;margin-left: 30px;"></a></td>';
							htmlContent += '</tr>';
						});

						// Agregar las filas generadas al tbody de la tabla
						$('#modal_facturacion tbody').html(htmlContent);
						// debugger;
					} else {
						// Si no hay registros, limpiar la tabla y mostrar un mensaje
						$('#modal_facturacion tbody').empty();
						$('.facturacion').text('No se encuentran documentos disponible.');
					}

				},
				error: function(xhr, status, error) {
					console.error("Error en la solicitud:", error);
					
				}
			});
		}


		function buscarMes() {
			let meses = [
				"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
				"Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
			];

			let mesSeleccionado = $("#mes_selecionado").val(); // Obtener el valor guardado

			// Limpiar el select y agregar la opción por defecto
			$("#mes").empty().append('<option value="0" selected disabled>Seleccione Mes</option>');

			// Llenar el select con los meses
			meses.forEach((mes, index) => {
				$('#mes').append('<option value="' + (index + 1) + '">' + mes + '</option>');
			});

			// Aplicar Select2
			$("#mes").select2();

			// Seleccionar el mes guardado (si existe)
			if (mesSeleccionado) {
				$("#mes").val(mesSeleccionado).trigger('change');
			}
		}


	</script>
</body>
</html>