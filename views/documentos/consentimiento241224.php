<!DOCTYPE html>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
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

		.imgArchivos {
			width: 30px;
			height: 30px;
			margin-bottom: 5px;
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
		
	</style>
</head>
<body>
	<?php require 'views/header.php'?>
	<div class="container" >
		<!-- <h2 class="center">Detalle Agenda</h2> -->
		<div class="card" >
			<div class="card-body">
				<form class="row" id="form-buscar" action="<?php echo constant('URL'); ?>consentimiento/verPaginacion_consentimiento/1" method="POST">
					<div class="position-relative mb-4">
						<h3>
							<div class="alert alert-primary text-center">Consentimiento</div>
						</h3>
					</div>
					<input type="hidden" id="datos_informe" name="datos_informe" value="<?php echo htmlspecialchars(json_encode($this->datos_informe)); ?>">
					<input type="hidden" id="filtro_fecha" name="filtro_fecha" value="<?php echo $this->fecha; ?>">
					<input type="hidden" id="filtro_fecha_hasta" name="filtro_fecha_hasta" value="<?php echo $this->fecha_hasta; ?>">
					<input type="hidden" id="msg" name="msg" value="<?php echo $this->mensaje; ?>">
					
					
					<div class="row">
						<!-- rut paciente -->
						<div class="col-md-3">
							<label for="rut" class="form-label">Buscador de pacientes</label>
							<input type="text" class="form-control form-control-sm me-2" name="rut" id="rut" placeholder="Buscar por RUT">
						</div>
						<!-- Fecha Desde -->
						<div class="col-md-3">
							<label for="fecha_desde" class="form-label">Fecha desde</label>
							<input type="date" class="form-control form-control-sm" name="fecha_desde" id="fecha_desde" placeholder="Fecha desde">
						</div>

						<!-- Fecha Hasta -->
						<div class="col-md-3">
							<label for="fecha_hasta" class="form-label">Fecha hasta</label>
							<input type="date" class="form-control form-control-sm" name="fecha_hasta" id="fecha_hasta" placeholder="Fecha hasta">
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
								<th style="display:none;">ID</th>
								<th>RUT</th>
								<th>Paciente</th>
								<th>Email</th>
								<th>Telefono</th>
								<th>Fecha Agenda</th>
								<th>Hora</th>
								<th>Centro</th>
								<th>Estado</th>
								<!-- <th>Diagnóstico</th> -->
								<!-- <th style="text-align: center;">Documentos</th> -->
								<th style="display:none;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								include_once 'models/medicos.php';
								foreach($this->citas as $index => $row){
									$partes = $row["fecha_atencion"];
									// Dividir la cadena en fecha y hora
									list($fecha, $hora) = explode(' ', $partes);
							?>
							<tr >
								<td style="display:none;"><?php echo $row["id"]; ?></td>
								<!-- <td style="text-align: center;"><?php //echo $row["rut_pnatural"]; ?></td> -->
								<td style="text-align: center;"><?php echo $row["rut_completo"]; ?></td>
								<td style="text-align: center;"><?php echo $row["nombres"] . ' ' . $row["apellido_paterno"] . ' ' . $row["apellido_materno"]; ?></td>
								<td style="text-align: center;"><?php echo $row["correo_electronico"]; ?></td>
								<td style="text-align: center;">
									<?php
										// Verificar si telefono1 tiene datos
										if (!empty($row["telefono1"])) {
										echo $row["telefono1"];
										}
										// Si telefono1 está vacío, verificar si telefono2 tiene datos
										elseif (!empty($row["telefono2"])) {
										echo $row["telefono2"];
										}
										// Si ninguno de los anteriores tiene datos, verificar telefono3
										elseif (!empty($row["telefono3"])) {
										echo $row["telefono3"];
										}
										// Si ninguno tiene datos, dejar vacío
										else {
										echo '';
										}
									?>
								</td>
								<td style="text-align: center;"><?php echo $fecha; ?></td>
								<td style="text-align: center;"><?php echo $hora; ?></td>
								<td style="text-align: center;"><?php echo $row["centro"]; ?></td>
								<td style="text-align: center; font-weight: bold; background-color: <?php echo ($row['recepcionado'] == 1 && $row['codigo_pago_cuenta'] == 2) ? '#a6dfa6' : '#f1c97e'; ?>;
									color: <?php echo ($row['recepcionado'] == 1 && $row['codigo_pago_cuenta'] == 2) ? 'green' : '#FFA500'; ?>;">
									<?php 
										echo ($row["recepcionado"] == 1 && $row["codigo_pago_cuenta"] == 2) ? 'Asistió' : 'Agendado'; 
									?>
								</td>
								<!-- <td style="text-align: center;"><?php //echo isset($row["detalle_atencion"]) && $row["detalle_atencion"] !== null ? $row["detalle_atencion"] : ""; ?></td> -->
								<!-- <td style="text-align: center;"><?php //echo $row["hora_inicio"] . ' a ' . $row["hora_fin"]; ?></td> -->
								
								<td style="text-align: center;">
									<!-- <img src="<?php //echo constant('URL'); ?>public/img/google-mas(1).png" alt="Imagen" class="btn-mas" style="width: 22px;"> -->
									<img 
										src="<?php 
												echo constant('URL'); 
												echo ($row['recepcionado'] == 1 && $row['codigo_pago_cuenta'] == 2) 
													? 'public/img/google-mas.png' 
													: 'public/img/google-mas(1).png'; 
											?>" 
										alt="Imagen" 
										class="btn-mas" 
										style="width: 22px;">
									<img src="<?php echo constant('URL'); ?>public/img/boton-menos (1).png" alt="Imagen" class="btn-menos" style="width: 22px; display: none;">
								</td>
								<td style="display:none;"><?php echo $row["id_horario"]; ?></td>
							</tr>
							<tr class="expand-row" style="display: none;">
								<td colspan="7">
									<div class="p-3 detalle_documentos" style="display: flex; gap: 20px;justify-content: center;">
										<a href="#" class="descarga consentimiento" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Consentimiento</span>
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
			<div class="card-footer d-flex justify-content-between align-items-center" style="padding-bottom: 15px;padding-top: 15px;"> 
				<!-- Paginación y otros elementos del footer -->
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<!-- Enlace para la página anterior -->
						<li class="page-item <?php echo $this->paginaactual <= 1 ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo constant('URL'); ?>consentimiento/verPaginacion_consentimiento/<?php echo $this->paginaactual - 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">Anterior</a>
						</li>
						<!-- Bucle para las páginas -->
						<?php for ($i = 0; $i < $this->paginas; $i++): ?>
							<?php if ($i <= 10): ?>
								<li class="page-item <?php echo $this->paginaactual == $i + 1 ? 'active' : ''; ?>">
									<a class="page-link" href="<?php echo constant('URL'); ?>consentimiento/verPaginacion_consentimiento/<?php echo $i + 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">
										<?php echo $i + 1; ?>
									</a>
								</li>
							<?php endif; ?>
						<?php endfor; ?>
						<!-- Enlace para la página siguiente -->
						<li class="page-item <?php echo $this->paginaactual >= $this->paginas ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo constant('URL'); ?>consentimiento/verPaginacion_consentimiento/<?php echo $this->paginaactual + 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">Siguiente</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>
	
	<div id="gesContainer" class="recetas" style="padding-bottom: 40px;margin-bottom: 70px;"></div>
	<?php require 'views/footer.php'?>
	<script>

		$(document).ready(function(){

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
				
			}

			

			var respuestasGes = [];

			$('.ver-documentos-btn').on('click', function() {
				// Obtener el elemento objetivo (filas de documentos)
				var target = $(this).data('target');
				var content = $(target);

				// Verificar si el contenido está expandido o colapsado
				if (content.is(':visible')) {
					content.slideUp(300); // Colapsar el contenido con una animación suave
				} else {
					content.slideDown(300); // Expandir el contenido con una animación suave
				}
			});


	

			$("#exportar_Excel_optica").click(function() {
				var datos_informe = $("#datos_informe").val();
				$('#exportar_Excel_optica').prop("disabled", true);

				// Hacer la solicitud AJAX usando POST en lugar de GET
				$.ajax({
					type: 'POST',
					url: '<?php echo constant('URL') ?>Informe/descargarExcel',
					data: {
						valor: 3,
						datos: datos_informe
					}, // Parámetros enviados en la solicitud
					dataType: 'json',
					success: function(response) {
						console.log("Respuesta del servidor:", response);

						// Verifica si la respuesta contiene un archivo
						if (response == 'Excel Descargado Correctamente') {
							var nomArchivo = 'Informe_Optica.xlsx';
							var link = document.createElement("a");
							// Ruta del archivo que fue descargado en el servidor
							link.href = "<?php echo constant('URL') . 'views/informes/exportar_informe_optica/' ?>" + nomArchivo;
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


			


			// Expandir fila
			$("#tblDocumentos").on("click", ".btn-mas", function () {
				var filaPrincipal = $(this).closest("tr"); // Seleccionar la fila actual
				var filaExpandida = filaPrincipal.next(".expand-row"); // Seleccionar la fila expandida siguiente
				// Obtiene el los datos columna de la fila principal segun posicion
				var rut = filaPrincipal.find("td:nth-child(2)").text(); 
				console.log('RUT de la fila expandida:', rut);
				var fecha_atencion = filaPrincipal.find("td:nth-child(6)").text();
				console.log('FECHA ATENCION de la fila expandida:', fecha_atencion);
				var estado = filaPrincipal.find("td:nth-child(9)").text().trim();
				console.log('estado de la fila expandida:', estado);

				if(estado != 'Agendado'){
					// Ocultar el botón "+" y mostrar "-"
					$(this).hide();
					filaPrincipal.find(".btn-menos").show();
					// Mostrar la fila expandida
					filaExpandida.show();
					// Llamar a funciones específicas
					cargarRecetas(rut, fecha_atencion);
					

				}

				
			});

			// Colapsar fila
			$("#tblDocumentos").on("click", ".btn-menos", function () {
				var filaPrincipal = $(this).closest("tr"); // Seleccionar la fila actual
				var filaExpandida = filaPrincipal.next(".expand-row"); // Seleccionar la fila expandida siguiente

				// Ocultar el botón "-" y mostrar "+"
				$(this).hide();
				filaPrincipal.find(".btn-mas").show();

				// Ocultar la fila expandida
				filaExpandida.hide();
			});
			


			// identifica el elemeto al cual se realizo el evento click
			$('#tblDocumentos').on('click', '.descarga', function(e) {
				e.preventDefault(); 

				// Obtener el tipo de documento haciendo clic en el elemento específico
				let tipoDocumento = $(this).find('span').text();

				// Navegar a la fila principal para obtener el RUT y el nombre del paciente
				let filaPrincipal = $(this).closest('tr').prev();
				let rut = filaPrincipal.find('td:eq(1)').text();
				let nombrePaciente = filaPrincipal.find('td:eq(2)').text();

				// Imprimir el tipo de documento, RUT y nombre del paciente en la consola
				console.log("Tipo de documento:", tipoDocumento);
				console.log("RUT:", rut);
				console.log("Nombre del paciente:", nombrePaciente);
				
				$('#modal_consetimiento').fadeIn();

			});


			
			$('.close').click(function() {
				var elementId = $(this).attr('id');  // Obtiene el id del elemento que ejecutó el clic
				// console.log("ID del elemento clickeado:", elementId); 

				if(elementId =='closeModalBtn1'){
					$('#modal_recetas').fadeOut();

				}else if(elementId=='closeModalBtn2'){
					$('#modal_consetimiento').fadeOut();
					
				}

			});

		
			$('#tabla_refracciones').on('click', '.descarga', function() {
				// Aquí dentro puedes manejar lo que sucede cuando se hace click en cualquier <td> con clase 'descarga'
				// Accede a los valores de las celdas de la fila
				let valor = $(this).closest('tr').find('td');

				let codigo_atencion_consulta = valor.eq(0).text();
				let codigo_reserva_atencion = valor.eq(1).text();
				let id_correlativo = valor.eq(2).text();

				let url ='http://192.168.1.122/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta=2&id_correlativo2='+id_correlativo+'';
				let ventanaEmergente = window.open('', '_blank', 'width=800,height=600');

				if (ventanaEmergente) {
					ventanaEmergente.location.href = url;
				} else {
					// alert('No se pudo abrir la ventana emergente. Verifica la configuración de tu navegador.');
					Swal.fire({
                            title: "¡No se pudo abrir la ventana emergente. Verifica la configuración de tu navegador!",
                            icon:'warning'
                    }).then((result) => {
                       
                    });
				}
				

			});


			$('#tabla_ges').on('click', '.descarga', function() {
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



		function cargarRecetas(rut, fecha_atencion){
			//rut de prueba 
			// rut_paciente = '18512609-9';
			// rut_paciente = '25928724-3';
			// rut_paciente = '5122324-1';
			$.ajax({
			type: 'GET',
			// url: 'http://localhost/rebsol_info/public/api/recetas?rut=' +rut_paciente,
			url: 'http://localhost/rebsol_info/public/api/recetas?rut=' +rut,
			dataType: 'json',
				success: function(response) {
					console.log(response);
					// debugger;
					// Combine ambos arrays, para cargar documentos e indicaciones en el acordion 
					let registros = [];

					// // Agregar indicaciones al array de registros
					// if (response.indicaciones.length > 0) {
					// 	for (let i = 0; i < response.indicaciones.length; i++) {
					// 		registros.push({
					// 			tipo: "indicaciones",
					// 			detalle: response.indicaciones[i]['detalle_atencion'],
					// 			fecha_registro: response.indicaciones[i]['fecha_registro'],
					// 			sucursal: response.indicaciones[i]['lugar_atencion'],
					// 			codigo_consulta_medica: response.indicaciones[i]['codigo_consulta_medica'],
					// 			codigo_detalle_atencion: response.indicaciones[i]['codigo_detalle_atencion'],
					// 			codigo_reserva_atencion: response.indicaciones[i]['codigo_reserva_atencion'],
					// 			codigo_item_atencion: response.indicaciones[i]['codigo_item_atencion']
								
					// 		});
					// 	}
					// }

					// // Agregar documentos al array de registros
					// if (response.documento.length > 0) {
					// 	for (let i = 0; i < response.documento.length; i++) {
					// 		registros.push({
					// 			tipo: "documento",
					// 			detalle: response.documento[i]['nombre_abreviado'],
					// 			fecha_registro: response.documento[i]['fecha_registro'],
					// 			sucursal: response.documento[i]['lugar_atencion'],
					// 			codigo_consulta_medica: response.documento[i]['codigo_consulta_medica'],
					// 			codigo_detalle_atencion: response.documento[i]['codigo_detalle_atencion'],
					// 			codigo_reserva: response.documento[i]['codigo_reserva'],
					// 			codigo_item_atencion: response.documento[i]['codigo_item_atencion']
								
					// 		});
					// 	}
					// }

					// let htmlContent = ''; 
					// if (registros.length > 0){
					// 	$('.indicaciones').empty();
					// 	// Ordenar los registros por fecha de mayor a menor
					// 	registros.sort((a, b) => new Date(b.fecha_registro) - new Date(a.fecha_registro));
					// 	let total_registros = registros.length;
						
					
					// 	for (let i = 0; i < registros.length; i++) {
					// 		let registro = registros[i];
					// 		let sucursal = registro.sucursal;
					// 		sucursal = sucursal === 'HUERFANOS' ? 2 :
					// 				sucursal === 'LA FLORIDA' ? 3 :
					// 				sucursal === 'MAIPU' ? 5 :
					// 				1; // Asignar 1 para otros casos
					// 		console.log(sucursal);

					// 		let fecha = new Date(registro.fecha_registro);
					// 		let dia = ('0' + fecha.getDate()).slice(-2);
					// 		let mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
					// 		let anio = fecha.getFullYear();
					// 		let fechaFormateada = dia + '/' + mes + '/' + anio;

					// 		htmlContent += '<tr>';
					// 		htmlContent += '<td style="display: none;">' + sucursal + '</td>';
					// 		htmlContent += '<td style="display: none;">' + registro.codigo_consulta_medica + '</td>';
					// 		htmlContent += '<td style="display: none;">' + registro.codigo_detalle_atencion + '</td>';
					// 		htmlContent += '<td style="font-size: 14px;display: none;">' + (registro.codigo_reserva || registro.codigo_reserva_atencion) + '</td>';
					// 		htmlContent += '<td style="font-size: 14px;">' + registro.detalle + '</td>';
					// 		htmlContent += '<td style="font-size: 14px;padding-left: 50px;">' + fechaFormateada + '</td>';
					// 		htmlContent += '<td><a href="#"><img src="<?php echo constant('URL'); ?>public/img/pdf.png" alt="Descargar" class="descarga" style="width: 30px; height: 32px;"></a></td>';
					// 		htmlContent += '<td style="display: none;">' + registro.codigo_item_atencion + '</td>';
					// 		htmlContent += '<td style="display: none;">' + registro.tipo + '</td>';
					// 		htmlContent += '</tr>';
					// 	}

					// 	htmlContent += '</tbody>';
					// 	htmlContent += '</table>';
					// 	htmlContent += '</div>';

					// 	// Insertar la tabla generada en el elemento correspondiente
					// 	$('#tabla_recetas tbody').html(htmlContent);

					// }else{
					// 	$('#tabla_recetas tbody').empty();
					// 	$('.indicaciones').text('El paciente no cuenta con documentos disponibles.');
					// }

					//CARGAR PRESION OCULAR
					// if (response.tension.length > 0){
					// 	$('.tension').empty();
					// 	htmlContent = '';
					
					// 	for (let i = 0; i < response.tension.length; i++){
					// 		let fecha_atencion = response.tension[i]['fecha_hora_reg_medico'];
					// 		fecha_atencion = fecha_atencion.split(" ")[0]; // Extrae solo la fecha antes del espacio
					// 		let od_m = response.tension[i]['od_m'];
					// 		let oi_m = response.tension[i]['oi_m'];
					
					// 		let fecha = new Date(fecha_atencion);
					// 		// Obtener partes de la fecha
					// 		let dia = ('0' + fecha.getDate()).slice(-2); // Agrega un cero y toma los últimos dos caracteres
					// 		let mes = ('0' + (fecha.getMonth() + 1)).slice(-2); // Agrega un cero y toma los últimos dos caracteres
					// 		let anio = fecha.getFullYear();
					// 		fecha_atencion = dia + '/' + mes + '/' + anio;
							
							
					// 		htmlContent += '<tr>';
					// 		htmlContent += '<td >' + fecha_atencion + '</td>';	
					// 		htmlContent += '<td style="font-size: 14px;">' + 
					// 						"OJO DERECHO: " + od_m + " / " + 
					// 						"OJO IZQUIERDO: " + oi_m + 
					// 						'</td>';
							
					// 		htmlContent += '</tr>';
					// 	}

					// 	htmlContent += '</tbody>';
					// 	htmlContent += '</table>';
					// 	htmlContent += '</div>';

					// 	$('#tabla_tension tbody').html(htmlContent);

					// }else{
					// 	$('#tabla_tension tbody').empty();
					// 	$('.tension').text('El paciente no cuenta presiones intraoculares disponibles');
					// }


					//CARGAR REFRACCIONES
					if (response.refraccion.length > 0) {
						$('.refracciones').empty();
						htmlContent = '';

						for (let i = 0; i < response.refraccion.length; i++) {
							let sucursal = response.refraccion[i]['lugar_atencion'];
							if (sucursal == 'HUERFANOS'){
								sucursal = 2;
							}else if (sucursal == 'LA FLORIDA') {
								sucursal = 3;
							}else if (sucursal == 'MAIPU'){
								sucursal = 5;
							}else{
								sucursal = response.refraccion[i]['codigo_atencion_consulta'];
							}

							let fechaRegistro = response.refraccion[i]['fecha_hora_reg_medico'];
							// console.log('FECHA registro medico :', fechaRegistro);
							let fecha_hora_reg_medico = fechaRegistro.split(" ")[0]; 

							// Convertir la cadena a objeto Date
							let fecha = new Date(fechaRegistro);

							let dia = ('0' + fecha.getDate()).slice(-2); 
							let mes = ('0' + (fecha.getMonth() + 1)).slice(-2); 
							let anio = fecha.getFullYear();
							let fechaFormateada = dia + '/' + mes + '/' + anio;
							let nombre_tipo_forma_lente = 'Receta de lentes';

							if (fecha_atencion == fecha_hora_reg_medico){
								htmlContent += '<tr>';
								htmlContent += '<td style="display: none;">' + sucursal + '</td>';
								htmlContent += '<td style="font-size: 14px;display: none;">' + response.refraccion[i]['codigo_reserva_atencion'] + '</td>';
								htmlContent += '<td style="font-size: 14px;padding-left: 50px; display: none;">'+ response.refraccion[i]['id_correlativo'] + '</td>';
								htmlContent += '<td style="font-size: 14px;">'+ nombre_tipo_forma_lente +'</td>';
								htmlContent += '<td style="font-size: 14px;padding-left: 50px;">' + fechaFormateada + '</td>';
								// htmlContent += '<td><a href="#"><img src="http://localhost/iopaGo/public/img/descargar.png" alt="Descargar" class="descarga"  style="width: 25px; height: 25px;"></a></td>';
								htmlContent += '<td><a href="#"><img src="<?php echo constant('URL'); ?>public/img/pdf.png" alt="Descargar" class="descarga"  style="width: 30px; height: 32px;"></a></td>';
								htmlContent += '</tr>';

							}

							
						}

						htmlContent += '</tbody>';
						htmlContent += '</table>';
						htmlContent += '</div>';

						

						$('#tabla_refracciones tbody').html(htmlContent);

					}else{
						$('#tabla_refracciones tbody').empty();
						$('.refracciones').text('El paciente no cuenta recetas de Anteojo/Lentes de contacto disponibles');
					}


				},
				error: function(xhr, status, error) {
					console.log("Error:", error);
				}
			});

			
			
		}




		// function cargarFormularioGes(rut) {
		// 	let rutPrueba = '25928724-3';
		// 	$.ajax({
		// 		type: 'GET',
		// 		url: 'http://localhost/ApiCitasCds/public/ges?rut=' + encodeURIComponent(rutPrueba),
		// 		dataType: 'json',
		// 		headers: {
		// 			'Authorization': '<?php echo constant("TOKEN"); ?>' // Token de autenticación
		// 		},
		// 		success: function(response) {
		// 			console.log("Respuesta del servidor:", response);
		// 			// Verificar que sea un arreglo y tenga datos
		// 			let htmlContent = '';
		// 			if (Array.isArray(response) && response.length > 0) {
		// 				$('.formulario_ges').empty();
		// 				let formulario = response[0]; // Accedemos al primer objeto del arreglo

		// 				// Accedemos a las propiedades del objeto
		// 				let fechaRegistro = formulario.fecha_registro;
		// 				var fecha_registro_db = fechaRegistro.split(" ")[0];
		// 				let id = formulario.id;
		// 				let nombreArchivo = formulario.nombre_archivo_ges;
		// 				let nombreCarpeta = formulario.nombre_carpeta;
		// 				let rut = formulario.rut;
		// 				let tipoGes = formulario.tipo_ges;


		// 				// Convertir la cadena a objeto Date
		// 				let fecha = new Date(fechaRegistro);

		// 				let dia = ('0' + fecha.getDate()).slice(-2); 
		// 				let mes = ('0' + (fecha.getMonth() + 1)).slice(-2); 
		// 				let anio = fecha.getFullYear();
		// 				let fechaFormateada = dia + '/' + mes + '/' + anio;
		// 				let url = "http://186.103.211.84/iopaGo/public/PDF/" + nombreCarpeta + "/" + fecha_registro_db + "/" + nombreArchivo;

		// 				htmlContent += '<tr>';
		// 				htmlContent += '<td style="display: none;">' + url + '</td>';
		// 				htmlContent += '<td style="font-size: 14px;padding-left: 50px;">' + fechaFormateada + '</td>';
		// 				htmlContent += '<td><a href="#"><img src="<?php echo constant('URL'); ?>public/img/pdf.png" alt="Descargar" class="descarga"  style="width: 30px; height: 32px;"></a></td>';
		// 				htmlContent += '</tr>';
						

		// 				htmlContent += '</tbody>';
		// 				htmlContent += '</table>';
		// 				htmlContent += '</div>';

						

		// 				$('#tabla_ges tbody').html(htmlContent);

		// 				// // Mostrar los datos en consola
		// 				// console.log("Fecha de registro:", fechaRegistro);
		// 				// console.log("Fecha formatiada:", fecha);
		// 				// console.log("ID:", id);
		// 				// console.log("Nombre del archivo GES:", nombreArchivo);
		// 				// console.log("Nombre de la carpeta:", nombreCarpeta);
		// 				// console.log("RUT:", rut);
		// 				// console.log("Tipo GES:", tipoGes);

		// 				// let url = "http://186.103.211.84/iopaGo/public/PDF/" + nombreCarpeta + "/" + fecha + "/" + nombreArchivo;
		// 				// window.open(url, "_blank");
		// 			} else {
		// 				$('#tabla_ges tbody').empty();
		// 				$('.formulario_ges').text('El paciente no cuente con formulario GES disponible.');
		// 			}

		// 		},
		// 		error: function(xhr, status, error) {
		// 			console.error("Error en la solicitud:", error);
					
		// 		}
		// 	});
		// }


		function buscarGes(rut){
			$('#modal_recetas').fadeIn();
			
		}
		

	</script>
</body>
</html>