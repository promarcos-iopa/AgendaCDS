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
		
	</style>
</head>
<body>
	<?php require 'views/header.php'?>
	<div class="container" >
		<!-- <h2 class="center">Detalle Agenda</h2> -->
		<div class="card" >
			<div class="card-body">
				<form class="row" id="form-buscar" action="<?php echo constant('URL'); ?>informe/verPaginacion_Detalle_Prestaciones/1" method="POST">
					<div class="position-relative mb-4">
						<h3>
							<div class="alert alert-primary text-center">Detalle Prestaciones Realizadas</div>
						</h3>
						<div id="divInfo" class="alert alert-warning alert-dismissible fade show position-absolute top-0 end-0" style="display: none;">
							<span id="msg"></span>
							<button type="button" id="cierre" class="btn-close" aria-label="Close"></button>
						</div>
					</div>
					<input type="hidden" id="datos_informe" name="datos_informe" value="<?php echo htmlspecialchars(json_encode($this->datos_informe)); ?>">
					<input type="hidden" id="filtro_fecha" name="filtro_fecha" value="<?php echo $this->fecha; ?>">
					<input type="hidden" id="filtro_fecha_hasta" name="filtro_fecha_hasta" value="<?php echo $this->fecha_hasta; ?>">
					<!-- <label for="rut">Buscador de pacientes</label>
					<div class="form-group col-md-3 d-flex align-items-end mt-3">
						<input type="text" class="form-control form-control-sm me-2" name="rut" id="rut" placeholder="Buscar por RUT">
					</div> -->

					
					<div class="row">
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
								<th>Fecha N</th>
								<th>Sexo</th>
								<th>Centro</th>
								<th>Fecha Agenda</th>
								<th>Hora</th>
								<th>Estado</th>
								<th>Diagnóstico</th>
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
								<td style="text-align: center;"><?php echo $row["fecha_nacimiento"]; ?></td>
								<td style="text-align: center;"><?php echo $row["sexo"]; ?></td>
								<!-- <td style="text-align: center;"><?php //echo $row["centro"]; ?></td> -->
								<td style="text-align: center;"><?php echo ''; ?></td>
								<td style="text-align: center;"><?php echo $fecha; ?></td>
								<td style="text-align: center;"><?php echo $hora; ?></td>
								<td style="text-align: center; font-weight: bold; background-color: <?php echo ($row['recepcionado'] == 1 && $row['codigo_pago_cuenta'] == 2) ? '#a6dfa6' : '#f1c97e'; ?>;
									color: <?php echo ($row['recepcionado'] == 1 && $row['codigo_pago_cuenta'] == 2) ? 'green' : '#FFA500'; ?>;">
									<?php 
										echo ($row["recepcionado"] == 1 && $row["codigo_pago_cuenta"] == 2) ? 'Asistió' : 'Agendado'; 
									?>
								</td>
								<td style="text-align: center;"><?php echo isset($row["detalle_atencion"]) && $row["detalle_atencion"] !== null ? $row["detalle_atencion"] : ""; ?></td>
								<!-- <td style="text-align: center;"><?php //echo $row["hora_inicio"] . ' a ' . $row["hora_fin"]; ?></td> -->
								
								<td style="text-align: center;">
									<img src="<?php echo constant('URL'); ?>public/img/google-mas.png" alt="Imagen" class="btn-mas" style="width: 22px;">
									<img src="<?php echo constant('URL'); ?>public/img/boton-menos (1).png" alt="Imagen" class="btn-menos" style="width: 22px; display: none;">
								</td>
								<td style="display:none;"><?php echo $row["id_horario"]; ?></td>
							</tr>
							<tr class="expand-row" style="display: none;">
								<td colspan="7">
									<div class="p-3 detalle_documentos" style="display: flex; gap: 20px;justify-content: center;">
										<!-- <a href="#" class="descarga receta" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php //echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Recetas</span>
										</a> -->
										<a href="#" class="descarga refaccion" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Refracción</span>
										</a>
										<!-- <a href="#" class="descarga examen" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php //echo constant('URL'); ?>public/img/png (1).png" alt="Icono PNG" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Exámenes</span>
										</a>
										<a href="https://www.iopanet.cl/iopaGo/public/PDF/GES/2024-11-08/FORMULARIO_GES_25928724-3.pdf" class="descarga ges" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php //echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">GES</span>
										</a>
										<a href="#" class="descarga presion_ocular" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php //echo constant('URL'); ?>public/img/presion (1).png" alt="Icono PDF" style="width: 42px; height: 42px; margin-bottom: -2px;">
											<span style="font-size: 14px; color: #858585;">Presión</span>
										</a> -->
										<a href="#" class="descarga ges" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">GES</span>
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
							<a class="page-link" href="<?php echo constant('URL'); ?>informe/verPaginacion_Detalle_Prestaciones/<?php echo $this->paginaactual - 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">Anterior</a>
						</li>
						<!-- Bucle para las páginas -->
						<?php for ($i = 0; $i < $this->paginas; $i++): ?>
							<?php if ($i <= 10): ?>
								<li class="page-item <?php echo $this->paginaactual == $i + 1 ? 'active' : ''; ?>">
									<a class="page-link" href="<?php echo constant('URL'); ?>informe/verPaginacion_Detalle_Prestaciones/<?php echo $i + 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">
										<?php echo $i + 1; ?>
									</a>
								</li>
							<?php endif; ?>
						<?php endfor; ?>
						<!-- Enlace para la página siguiente -->
						<li class="page-item <?php echo $this->paginaactual >= $this->paginas ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo constant('URL'); ?>informe/verPaginacion_Detalle_Prestaciones/<?php echo $this->paginaactual + 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">Siguiente</a>
						</li>
					</ul>
				</nav>

				<button type="button" id="exportar_Excel_Prestaciones" class="btn btn-success btn-sm" style="display: flex; align-items: center; gap: 8px;">
					<!-- Imagen de Excel -->
					<img src="<?php echo constant('URL'); ?>public/img/excel.png" alt="Excel Icon" style="width: 20px; height: 20px;" >
					Exportar Excel
				</button>

				

			</div>
		</div>
	</div>
	<!-- MODAL RECETAS-->
    <div id="modal_recetas" class="modal">
        <!-- Contenido de la modal -->
        <div class="modal-content">
            <span class="close" id="closeModalBtn1">&times;</span>
            <div class="modal-header">
                Recetas
            </div>
            <div class="modal-body">
                <p class="indicaciones"></p>
				<!-- Tabla dinámica -->
                <table id="tabla_recetas">
                    <thead>
                        <tr>
                            <th>Nombre de la receta</th>
                            <th>Fecha creacion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas se agregarán aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	<!-- MODAL REFRACCION-->
    <div id="modal_refraccion" class="modal">
        <!-- Contenido de la modal -->
        <div class="modal-content">
            <span class="close" id="closeModalBtn2">&times;</span>
            <div class="modal-header">
				Refracción
            </div>
            <div class="modal-body">
                <p class="refracciones"></p>
				<!-- Tabla dinámica -->
                <table id="tabla_refracciones">
                    <thead>
                        <tr>
                            <th>Nombre de la receta</th>
                            <th>Fecha creacion</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas se agregarán aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	<!-- MODAL TENSION OCULAR-->
    <div id="modal_presion_ocular" class="modal">
        <!-- Contenido de la modal -->
        <div class="modal-content">
            <span class="close" id="closeModalBtn5">&times;</span>
            <div class="modal-header">
				Presión Ocular
            </div>
            <div class="modal-body">
                <p class="tension"></p>
				<!-- Tabla dinámica -->
                <table id="tabla_tension">
                    <thead>
                        <tr>
                            <th>Fecha Registro</th>
                            <th>Presión intraocular</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas dinámicas se agregarán aquí -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
	<!-- MODAL FORMULARIO GES-->
    <div id="modal_formulario_ges" class="modal">
        <!-- Contenido de la modal -->
        <div class="modal-content">
            <span class="close" id="closeModalBtn4">&times;</span>
            <div class="modal-header">
				Formulario Ges
            </div>
            <div class="modal-body">
                <p class="formulario_ges"></p>
				<!-- Tabla dinámica -->
                <table id="tabla_ges">
                    <thead>
                        <tr>
                            <th>Fecha registro</th>
                            <th>GES</th>
                            <!-- <th>Presión intraocular</th> -->
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
	<script>

		$(document).ready(function(){

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




			//DESCARGAR INFORME
			$("#exportar_Excel_Prestaciones").click(function() {
				var datos_informe = $("#datos_informe").val();
				// console.log(datos_informe);
				// Deshabilitar el botón para evitar múltiples clics
				$('#exportar_Excel_Prestaciones').prop("disabled", true);

				// Hacer la solicitud AJAX usando POST en lugar de GET
				$.ajax({
					type: 'POST',
					url: '<?php echo constant('URL') ?>informe/descargarExcel',
					data: {
						valor: 2,
						datos: datos_informe
					}, // Parámetros enviados en la solicitud
					dataType: 'json',
					success: function(response) {
						console.log("Respuesta del servidor:", response);

						// Verifica si la respuesta contiene un archivo
						if (response == 'Excel Descargado Correctamente') {
							var nomArchivo = 'Informe_Prestaciones.xlsx';
							var link = document.createElement("a");
							// Ruta del archivo que fue descargado en el servidor
							link.href = "<?php echo constant('URL') . 'views/informes/exportar_informe_prestacion/' ?>" + nomArchivo;
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
						$('#exportar_Excel_Prestaciones').prop("disabled", false);
					},
					complete: function() {
						// Asegura que el botón se habilite al terminar la solicitud, en caso de éxito o error
						$('#exportar_Excel_Prestaciones').prop("disabled", false);
					}
				});
			});


			


			// Expandir fila
			$("#tblDocumentos").on("click", ".btn-mas", function () {
				var filaPrincipal = $(this).closest("tr"); // Seleccionar la fila actual
				var filaExpandida = filaPrincipal.next(".expand-row"); // Seleccionar la fila expandida siguiente

				var rut = filaPrincipal.find("td:nth-child(2)").text(); // Obtiene el RUT de la segunda columna de la fila principal
				console.log('RUT de la fila expandida:', rut);
				var fecha_atencion = filaPrincipal.find("td:nth-child(7)").text();

				// Ocultar el botón "+" y mostrar "-"
				$(this).hide();
				filaPrincipal.find(".btn-menos").show();

				// Mostrar la fila expandida
				filaExpandida.show();

				// Llamar a funciones específicas
				cargarRecetas(rut, fecha_atencion);
				cargarFormularioGes(rut);
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
				
				// Mostrar la modal con el tipo de documento seleccionado
				if(tipoDocumento =='Recetas'){
					$('#modal_recetas').fadeIn();

				}else if(tipoDocumento =='Refracción'){
					$('#modal_refraccion').fadeIn();

				}else if(tipoDocumento =='Exámenes'){

				}else if(tipoDocumento =='GES'){
					$('#modal_formulario_ges').fadeIn();
					
				
				}else if(tipoDocumento =='Presión'){
					$('#modal_presion_ocular').fadeIn();

				}

			});


			
			$('.close').click(function() {
				var elementId = $(this).attr('id');  // Obtiene el id del elemento que ejecutó el clic
				// console.log("ID del elemento clickeado:", elementId); 

				if(elementId =='closeModalBtn1'){
					$('#modal_recetas').fadeOut();

				}else if(elementId=='closeModalBtn2'){
					$('#modal_refraccion').fadeOut();
					

				}else if(elementId=='closeModalBtn4'){
					$('#modal_formulario_ges').fadeOut();

				}else if(elementId=='closeModalBtn5'){
					$('#modal_presion_ocular').fadeOut();

				}

			});

			$('#tabla_recetas').on('click', '.descarga', function() {
				let valor = $(this).closest('tr').find('td');
				let codigo_atencion_consulta = valor.eq(0).text();
				let codigo_consulta_medica = valor.eq(1).text();
				let codigo_detalle_atencion = valor.eq(2).text();
				let codigo_reserva_atencion = valor.eq(3).text();
				let codigo_item_atencion = valor.eq(7).text();
				let receta = valor.eq(8).text();

				// Imprime los valores en la consola
				// console.log("Código Atención Consulta:", codigo_atencion_consulta);
				// console.log("Código Consulta Médica:", codigo_consulta_medica);
				// console.log("Código Detalle Atención:", codigo_detalle_atencion);
				// console.log("Código Reserva Atención:", codigo_reserva_atencion);
				// console.log("Código Item Atención:", codigo_item_atencion);
				// console.log("Receta:", receta);
				let tipo_doc_receta = "";
				let url  = '';

				if (receta == 'indicaciones'){
					if (codigo_detalle_atencion !=''){
						// Obtener los primeros 2 dígitos
						codigo_detalle_atencion = codigo_detalle_atencion.slice(0, 2);
					}
				
				
					if (codigo_detalle_atencion !="" && codigo_item_atencion =='7' && codigo_detalle_atencion =='01'){ 
						console.log(codigo_detalle_atencion);
						//tipo 1 indicaciones medicas
						tipo_doc_receta = 1;
						// url = 'http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'';
						url = 'https://www.iopanet.cl/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'';

					}else if(codigo_detalle_atencion !='' &&  codigo_item_atencion =='7' && (codigo_detalle_atencion =='02' || codigo_detalle_atencion =='04')) {
						console.log(codigo_detalle_atencion);
						tipo_doc_receta = 4;
						// tipo 4 recetas otras indicaciones 
						// url = 'http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
						url = 'https://www.iopanet.cl/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
					

					}else if(codigo_detalle_atencion =='' && codigo_item_atencion =='7'){
						console.log(codigo_detalle_atencion);
						tipo_doc_receta = 4;
						// tipo 4 recetas otras indicaciones 
						// url = 'http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
						url = 'https://www.iopanet.cl/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
					
						
					}else if(codigo_item_atencion =='10'){
						tipo_doc_receta = 5;
						// tipo 5 otros examenes
						// url = 'http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
						url = 'https://www.iopanet.cl/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';

					}

					

				}else{
					//DESCARGAR PDF DOCUMENTO 
					// url ='http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta=3&codigo_detalle_atencion_fc='+codigo_detalle_atencion+'';
					url ='https://www.iopanet.cl/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta=3&codigo_detalle_atencion_fc='+codigo_detalle_atencion+'';

				}


				let ventanaEmergente = window.open('', '_blank', 'width=800,height=600');
				// Verificar si se pudo abrir la ventana emergente correctamente
				if (ventanaEmergente) {
					// Cargar la URL en la ventana emergente
					ventanaEmergente.location.href = url;
				} else {
					// Manejar el caso en el que no se pudo abrir la ventana emergente
					Swal.fire({
							title: "¡No se pudo abrir la ventana emergente. Verifica la configuración de tu navegador!",
							icon:'warning'
					}).then((result) => {
					
					});
					// alert('No se pudo abrir la ventana emergente. Verifica la configuración de tu navegador.');
				}

			});


			$('#tabla_refracciones').on('click', '.descarga', function() {
				// Aquí dentro puedes manejar lo que sucede cuando se hace click en cualquier <td> con clase 'descarga'
				// Accede a los valores de las celdas de la fila
				let valor = $(this).closest('tr').find('td');

				let codigo_atencion_consulta = valor.eq(0).text();
				let codigo_reserva_atencion = valor.eq(1).text();
				let id_correlativo = valor.eq(2).text();

				let url ='https://www.iopanet.cl/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta=2&id_correlativo2='+id_correlativo+'';
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
			url: 'https://www.iopanet.cl/rebsol_info/public/api/recetas?rut=' +rut,
			dataType: 'json',
				success: function(response) {
					console.log(response);
					// Combine ambos arrays, para cargar documentos e indicaciones en el acordion 

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
							console.log('FECHA registro medico :', fechaRegistro);
							let fecha_hora_reg_medico = fechaRegistro.split(" ")[0]; // Extrae solo la fecha antes del espacio

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




		function cargarFormularioGes(rut) {
			// let rutPrueba = '25928724-3';
			$.ajax({
				type: 'GET',
				// url: 'http://186.64.123.171/ApiCitasCds/public/ges?rut=' + encodeURIComponent(rut),
				url: 'https://www.iopanet.cl/ApiCitasCds/public/ges?rut=' + encodeURIComponent(rut),
				dataType: 'json',
				headers: {
					'Authorization': '<?php echo constant("TOKEN"); ?>' // Token de autenticación
				},
				success: function(response) {
					console.log("Respuesta del servidor:", response);
					// Verificar que sea un arreglo y tenga datos
					let htmlContent = '';
					if (Array.isArray(response) && response.length > 0) {
						$('.formulario_ges').empty(); // Limpiar contenido previo

						response.forEach((formulario) => {
							// Accedemos a las propiedades del objeto actual
							let fechaRegistro = formulario.fecha_registro;
							var fecha_registro_db = fechaRegistro.split(" ")[0];
							let id = formulario.id;
							let nombreArchivo = formulario.nombre_archivo_ges;
							let nombreCarpeta = formulario.nombre_carpeta;
							let rut = formulario.rut;
							let tipoGes = formulario.tipo_ges;

							// Convertir la cadena a objeto Date
							let fecha = new Date(fechaRegistro);

							// Formatear la fecha en formato DD/MM/YYYY
							let dia = ('0' + fecha.getDate()).slice(-2); 
							let mes = ('0' + (fecha.getMonth() + 1)).slice(-2); 
							let anio = fecha.getFullYear();
							let fechaFormateada = dia + '/' + mes + '/' + anio;

							// Generar la URL del archivo
							let url = "https://www.iopanet.cl/iopaGo/public/PDF/" + nombreCarpeta + "/" + fecha_registro_db + "/" + nombreArchivo;

							// Crear el HTML para cada fila
							htmlContent += '<tr>';
							htmlContent += '<td style="display: none;">' + url + '</td>';
							htmlContent += '<td style="font-size: 14px; padding-left: 50px;">' + fechaFormateada + '</td>';
							htmlContent += '<td><a href="' + url + '" target="_blank"><img src="<?php echo constant('URL'); ?>public/img/pdf.png" alt="Descargar" class="descarga" style="width: 30px; height: 32px;"></a></td>';
							htmlContent += '</tr>';
						});

						// Agregar las filas generadas al tbody de la tabla
						$('#tabla_ges tbody').html(htmlContent);
					} else {
						// Si no hay registros, limpiar la tabla y mostrar un mensaje
						$('#tabla_ges tbody').empty();
						$('.formulario_ges').text('El paciente no cuenta con formulario GES disponible.');
					}

				},
				error: function(xhr, status, error) {
					console.error("Error en la solicitud:", error);
					
				}
			});
		}


		function buscarGes(rut){
			$('#modal_recetas').fadeIn();
			
		}
		

	</script>
</body>
</html>