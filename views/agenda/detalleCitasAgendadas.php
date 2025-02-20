<!DOCTYPE html>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Listado medicos</title>
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
			width: 36px;
			height: 36px;
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
		<h2 class="center">Detalle Agenda</h2>
		<div class="card" >
			<div class="card-body">
				<form class="row" id="form-buscar" action="<?php echo constant('URL'); ?>Agenda/verPaginacionDetalle/1" method="POST">
					<!-- <div class="form-group col-md-3">
						<label for="txtbuscar">Buscar por rut</label>
						<input type="text" class="form-control" name="txtbuscar" id="txtbuscar">
					</div>
					<button id="btnbuscar" type="Submit" class="btn btn-primary">Buscar</button> -->
					<!-- <label for="txtbuscar">Buscar por rut</label>
					<div class="form-group col-md-3 d-flex align-items-end">
						<input type="text" class="form-control me-2" name="txtbuscar" id="txtbuscar">
						<button id="btnbuscar" type="submit" class="btn btn-primary">Buscar</button>
					</div> -->
					<label for="rut">Buscador de pacientes</label>
					<div class="form-group col-md-3 d-flex align-items-end mt-3">
						<!-- Campo para buscar por RUT -->
						<input type="text" class="form-control me-2" name="rut" id="rut" placeholder="Buscar por RUT">
					</div>

					<div class="form-group col-md-3 d-flex align-items-end">
						<!-- Campo de fecha desde -->
						<input type="date" class="form-control me-2" name="fecha_desde" id="fecha_desde" placeholder="Fecha desde">
					</div>

					<div class="form-group col-md-3 d-flex align-items-end">
						<!-- Campo de fecha hasta -->
						<input type="date" class="form-control me-2" name="fecha_hasta" id="fecha_hasta" placeholder="Fecha hasta">
					</div>

					<div class="form-group col-md-3 d-flex align-items-end">
						<!-- Botón de búsqueda -->
						<button id="btnbuscar" type="submit" class="btn btn-primary">Buscar</button>
					</div>

					
				</form>
		
				<!-- EXPAN ROW -->
				<div class="table-responsive text-center mt-5">
					<table id="tblDocumentos" class="table mx-auto">
						<thead style="color: #0d70fd;">
							<tr>
								<th style="display:none;">ID</th>
								<th>RUT</th>
								<th>Paciente</th>
								<th>Fecha Agenda</th>
								<th>Hora Agenda</th>
								<th>Centro</th>
								<th style="text-align: center;">Documentos</th>
								<th style="display:none;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
								include_once 'models/medicos.php';
								foreach($this->citas as $index => $row){
							?>
							<tr >
								<td style="display:none;"><?php echo $row["id"]; ?></td>
								<td style="text-align: center;"><?php echo $row["rut"]; ?></td>
								<td style="text-align: center;"><?php echo $row["nombre"] . ' ' . $row["apellido1"] . ' ' . $row["apellido2"]; ?></td>
								<td style="text-align: center;"><?php echo $row["fecha"]; ?></td>
								<td style="text-align: center;"><?php echo $row["hora_inicio"] . ' a ' . $row["hora_fin"]; ?></td>
								<td style="text-align: center;"><?php echo $row["centro"]; ?></td>
								<td style="text-align: center;">
									<img src="<?php echo constant('URL'); ?>public/img/mas.png" alt="Imagen" class="btn-mas" style="width: 26px;">
									<img src="<?php echo constant('URL'); ?>public/img/boton-menos.png" alt="Imagen" class="btn-menos" style="width: 26px; display: none;">
								</td>
								<td style="display:none;"><?php echo $row["id_horario"]; ?></td>
							</tr>
							<tr class="expand-row" style="display: none;">
								<td colspan="7">
									<div class="p-3 detalle_documentos" style="display: flex; gap: 20px;justify-content: center;">
										<a href="#" class="descarga receta" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Recetas</span>
										</a>
										<a href="#" class="descarga refaccion" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Refracción</span>
										</a>
										<a href="#" class="descarga examen" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/png (1).png" alt="Icono PNG" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">Exámenes</span>
										</a>
										<a href="http://localhost/iopaGo/public/PDF/GES/2024-11-08/FORMULARIO_GES_25928724-3.pdf" class="descarga ges" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/pdf (2).png" alt="Icono PDF" class="imgArchivos">
											<span style="font-size: 14px; color: #858585;">GES</span>
										</a>
										<a href="#" class="descarga presion_ocular" style="display: flex; flex-direction: column; align-items: center; text-decoration: none;">
											<img src="<?php echo constant('URL'); ?>public/img/presion (1).png" alt="Icono PDF" style="width: 42px; height: 42px; margin-bottom: -2px;">
											<span style="font-size: 14px; color: #858585;">Presión</span>
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
			<div class="card-footer">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<li class="page-item <?php echo $this->paginaactual <= 1 ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo constant('URL'); ?>Agenda/verPaginacionDetalle/<?php echo $this->paginaactual - 1; ?>">Anterior</a>
						</li>
						<?php for ($i = 0; $i < $this->paginas; $i++): ?>
							<?php if ($i <= 10): ?>
								<li class="page-item <?php echo $this->paginaactual == $i + 1 ? 'active' : ''; ?>">
									<a class="page-link" href="<?php echo constant('URL'); ?>Agenda/verPaginacionDetalle/<?php echo $i + 1; ?>">
										<?php echo $i + 1; ?>
									</a>
								</li>
							<?php endif; ?>
						<?php endfor; ?>
						<li class="page-item <?php echo $this->paginaactual >= $this->paginas ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo constant('URL'); ?>Agenda/verPaginacionDetalle/<?php echo $this->paginaactual + 1; ?>">Siguiente</a>
						</li>
					</ul>
				</nav>
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


			// $(".btn-mas").on("click", function() {
			// 	var mainRow = $(this).closest("tr");
			// 	var expandRow = mainRow.next("tr");

			// 	// Agrega la rotación a la imagen actual
			// 	$(this).addClass('rotate');

			// 	// Espera a que la rotación termine antes de realizar el cambio de visibilidad
			// 	setTimeout(function() {
			// 		expandRow.show();
			// 		$('.btn-mas').hide();
			// 		$('.btn-menos').show();
			// 		$('.btn-mas, .btn-menos').removeClass('rotate'); // Elimina la rotación para el próximo clic
			// 	}, 500); // La duración de la animación debe coincidir con el tiempo en CSS

			// });

			


			$(".btn-mas").on("click", function() {
				var mainRow = $(this).closest("tr"); // Obtiene la fila principal donde se hizo clic
				var rut = mainRow.find("td:nth-child(2)").text(); // Obtiene el RUT (segunda columna) de la fila

				// Mostrar el rut en una ventana emergente (alerta)
				// alert("Rut de la fila: " + rut);

				var expandRow = mainRow.next("tr"); // Obtiene la fila siguiente para mostrarla

				// Agrega la rotación a la imagen actual
				$(this).addClass('rotate');

				// Espera a que la rotación termine antes de realizar el cambio de visibilidad
				setTimeout(function() {
					expandRow.show();
					$('.btn-mas').hide();
					$('.btn-menos').show();
					$('.btn-mas, .btn-menos').removeClass('rotate'); // Elimina la rotación para el próximo clic
				}, 500); // La duración de la animación debe coincidir con el tiempo en CSS
				cargarRecetas(rut);
				cargarFormularioGes(rut);
			});

			$(".btn-menos").on("click", function() {
				var mainRow = $(this).closest("tr");
				var expandRow = mainRow.next("tr");

				// Agrega la rotación a la imagen actual
				$(this).addClass('rotate');

				// Espera a que la rotación termine antes de realizar el cambio de visibilidad
				setTimeout(function() {
					expandRow.hide();
					$('.btn-menos').hide();
					$('.btn-mas').show();
					$('.btn-mas, .btn-menos').removeClass('rotate'); // Elimina la rotación para el próximo clic
				}, 500); // La duración de la animación debe coincidir con el tiempo en CSS
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
						url = 'http://186.64.123.171/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'';

					}else if(codigo_detalle_atencion !='' &&  codigo_item_atencion =='7' && (codigo_detalle_atencion =='02' || codigo_detalle_atencion =='04')) {
						console.log(codigo_detalle_atencion);
						tipo_doc_receta = 4;
						// tipo 4 recetas otras indicaciones 
						// url = 'http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
						url = 'http://186.64.123.171/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
					

					}else if(codigo_detalle_atencion =='' && codigo_item_atencion =='7'){
						console.log(codigo_detalle_atencion);
						tipo_doc_receta = 4;
						// tipo 4 recetas otras indicaciones 
						// url = 'http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
						url = 'http://186.64.123.171/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
					
						
					}else if(codigo_item_atencion =='10'){
						tipo_doc_receta = 5;
						// tipo 5 otros examenes
						// url = 'http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';
						url = 'http://186.64.123.171/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta='+tipo_doc_receta+'&codigo_consulta_medica='+codigo_consulta_medica+'';

					}

					

				}else{
					//DESCARGAR PDF DOCUMENTO 
					// url ='http://192.168.1.251/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta=3&codigo_detalle_atencion_fc='+codigo_detalle_atencion+'';
					url ='http://186.64.123.171/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta=3&codigo_detalle_atencion_fc='+codigo_detalle_atencion+'';

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

				let url ='http://186.64.123.171/softland_api/receta?codigo_reserva='+codigo_reserva_atencion+'&lugar_atencion='+codigo_atencion_consulta+'&tipo_doc_receta=2&id_correlativo2='+id_correlativo+'';
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



		function cargarRecetas(rut){
			//rut de prueba 
			// rut_paciente = '18512609-9';
			// rut_paciente = '25928724-3';
			// rut_paciente = '5122324-1';
			$.ajax({
			type: 'GET',
			// url: 'http://localhost/rebsol_info/public/api/recetas?rut=' +rut_paciente,
			url: 'https://www.iopanet.cl/agenda_medica_cds/proxy/recetas.php?rut=' +rut,
			dataType: 'json',
				success: function(response) {
					console.log(response);
					// Combine ambos arrays, para cargar documentos e indicaciones en el acordion 
					let registros = [];

					// Agregar indicaciones al array de registros
					if (response.indicaciones.length > 0) {
						for (let i = 0; i < response.indicaciones.length; i++) {
							registros.push({
								tipo: "indicaciones",
								detalle: response.indicaciones[i]['detalle_atencion'],
								fecha_registro: response.indicaciones[i]['fecha_registro'],
								sucursal: response.indicaciones[i]['lugar_atencion'],
								codigo_consulta_medica: response.indicaciones[i]['codigo_consulta_medica'],
								codigo_detalle_atencion: response.indicaciones[i]['codigo_detalle_atencion'],
								codigo_reserva_atencion: response.indicaciones[i]['codigo_reserva_atencion'],
								codigo_item_atencion: response.indicaciones[i]['codigo_item_atencion']
								
							});
						}
					}

					// Agregar documentos al array de registros
					if (response.documento.length > 0) {
						for (let i = 0; i < response.documento.length; i++) {
							registros.push({
								tipo: "documento",
								detalle: response.documento[i]['nombre_abreviado'],
								fecha_registro: response.documento[i]['fecha_registro'],
								sucursal: response.documento[i]['lugar_atencion'],
								codigo_consulta_medica: response.documento[i]['codigo_consulta_medica'],
								codigo_detalle_atencion: response.documento[i]['codigo_detalle_atencion'],
								codigo_reserva: response.documento[i]['codigo_reserva'],
								codigo_item_atencion: response.documento[i]['codigo_item_atencion']
								
							});
						}
					}

					let htmlContent = ''; 
					if (registros.length > 0){
						$('.indicaciones').empty();
						// Ordenar los registros por fecha de mayor a menor
						registros.sort((a, b) => new Date(b.fecha_registro) - new Date(a.fecha_registro));
						let total_registros = registros.length;
						
					
						for (let i = 0; i < registros.length; i++) {
							let registro = registros[i];
							let sucursal = registro.sucursal;
							sucursal = sucursal === 'HUERFANOS' ? 2 :
									sucursal === 'LA FLORIDA' ? 3 :
									sucursal === 'MAIPU' ? 5 :
									1; // Asignar 1 para otros casos
							console.log(sucursal);

							let fecha = new Date(registro.fecha_registro);
							let dia = ('0' + fecha.getDate()).slice(-2);
							let mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
							let anio = fecha.getFullYear();
							let fechaFormateada = dia + '/' + mes + '/' + anio;

							htmlContent += '<tr>';
							htmlContent += '<td style="display: none;">' + sucursal + '</td>';
							htmlContent += '<td style="display: none;">' + registro.codigo_consulta_medica + '</td>';
							htmlContent += '<td style="display: none;">' + registro.codigo_detalle_atencion + '</td>';
							htmlContent += '<td style="font-size: 14px;display: none;">' + (registro.codigo_reserva || registro.codigo_reserva_atencion) + '</td>';
							htmlContent += '<td style="font-size: 14px;">' + registro.detalle + '</td>';
							htmlContent += '<td style="font-size: 14px;padding-left: 50px;">' + fechaFormateada + '</td>';
							htmlContent += '<td><a href="#"><img src="<?php echo constant('URL'); ?>public/img/pdf.png" alt="Descargar" class="descarga" style="width: 30px; height: 32px;"></a></td>';
							htmlContent += '<td style="display: none;">' + registro.codigo_item_atencion + '</td>';
							htmlContent += '<td style="display: none;">' + registro.tipo + '</td>';
							htmlContent += '</tr>';
						}

						htmlContent += '</tbody>';
						htmlContent += '</table>';
						htmlContent += '</div>';

						// Insertar la tabla generada en el elemento correspondiente
						$('#tabla_recetas tbody').html(htmlContent);

					}else{
						$('#tabla_recetas tbody').empty();
						$('.indicaciones').text('El paciente no cuenta con documentos disponibles.');
					}

					//CARGAR PRESION OCULAR
					if (response.tension.length > 0){
						$('.tension').empty();
						htmlContent = '';
					
						for (let i = 0; i < response.tension.length; i++){
							let fecha_atencion = response.tension[i]['fecha_hora_reg_medico'];
							fecha_atencion = fecha_atencion.split(" ")[0]; // Extrae solo la fecha antes del espacio
							let od_m = response.tension[i]['od_m'];
							let oi_m = response.tension[i]['oi_m'];
					
							let fecha = new Date(fecha_atencion);
							// Obtener partes de la fecha
							let dia = ('0' + fecha.getDate()).slice(-2); // Agrega un cero y toma los últimos dos caracteres
							let mes = ('0' + (fecha.getMonth() + 1)).slice(-2); // Agrega un cero y toma los últimos dos caracteres
							let anio = fecha.getFullYear();
							fecha_atencion = dia + '/' + mes + '/' + anio;
							
							
							htmlContent += '<tr>';
							htmlContent += '<td >' + fecha_atencion + '</td>';	
							htmlContent += '<td style="font-size: 14px;">' + 
											"OJO DERECHO: " + od_m + " / " + 
											"OJO IZQUIERDO: " + oi_m + 
											'</td>';
							
							htmlContent += '</tr>';
						}

						htmlContent += '</tbody>';
						htmlContent += '</table>';
						htmlContent += '</div>';

						$('#tabla_tension tbody').html(htmlContent);

					}else{
						$('#tabla_tension tbody').empty();
						$('.tension').text('El paciente no cuenta presiones intraoculares disponibles');
					}


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

							// Convertir la cadena a objeto Date
							let fecha = new Date(fechaRegistro);

							let dia = ('0' + fecha.getDate()).slice(-2); 
							let mes = ('0' + (fecha.getMonth() + 1)).slice(-2); 
							let anio = fecha.getFullYear();
							let fechaFormateada = dia + '/' + mes + '/' + anio;
							let nombre_tipo_forma_lente = 'Receta de lentes';

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
			let rutPrueba = '25928724-3';
			$.ajax({
				type: 'GET',
				url: 'http://localhost/ApiCitasCds/public/ges?rut=' + encodeURIComponent(rutPrueba),
				dataType: 'json',
				headers: {
					'Authorization': '<?php echo constant("TOKEN"); ?>' // Token de autenticación
				},
				success: function(response) {
					console.log("Respuesta del servidor:", response);
					// Verificar que sea un arreglo y tenga datos
					let htmlContent = '';
					if (Array.isArray(response) && response.length > 0) {
						$('.formulario_ges').empty();
						let formulario = response[0]; // Accedemos al primer objeto del arreglo

						// Accedemos a las propiedades del objeto
						let fechaRegistro = formulario.fecha_registro;
						var fecha_registro_db = fechaRegistro.split(" ")[0];
						let id = formulario.id;
						let nombreArchivo = formulario.nombre_archivo_ges;
						let nombreCarpeta = formulario.nombre_carpeta;
						let rut = formulario.rut;
						let tipoGes = formulario.tipo_ges;


						// Convertir la cadena a objeto Date
						let fecha = new Date(fechaRegistro);

						let dia = ('0' + fecha.getDate()).slice(-2); 
						let mes = ('0' + (fecha.getMonth() + 1)).slice(-2); 
						let anio = fecha.getFullYear();
						let fechaFormateada = dia + '/' + mes + '/' + anio;
						let url = "http://186.103.211.84/iopaGo/public/PDF/" + nombreCarpeta + "/" + fecha_registro_db + "/" + nombreArchivo;

						htmlContent += '<tr>';
						htmlContent += '<td style="display: none;">' + url + '</td>';
						htmlContent += '<td style="font-size: 14px;padding-left: 50px;">' + fechaFormateada + '</td>';
						htmlContent += '<td><a href="#"><img src="<?php echo constant('URL'); ?>public/img/pdf.png" alt="Descargar" class="descarga"  style="width: 30px; height: 32px;"></a></td>';
						htmlContent += '</tr>';
						

						htmlContent += '</tbody>';
						htmlContent += '</table>';
						htmlContent += '</div>';

						

						$('#tabla_ges tbody').html(htmlContent);

						// // Mostrar los datos en consola
						// console.log("Fecha de registro:", fechaRegistro);
						// console.log("Fecha formatiada:", fecha);
						// console.log("ID:", id);
						// console.log("Nombre del archivo GES:", nombreArchivo);
						// console.log("Nombre de la carpeta:", nombreCarpeta);
						// console.log("RUT:", rut);
						// console.log("Tipo GES:", tipoGes);

						// let url = "http://186.103.211.84/iopaGo/public/PDF/" + nombreCarpeta + "/" + fecha + "/" + nombreArchivo;
						// window.open(url, "_blank");
					} else {
						$('#tabla_ges tbody').empty();
						$('.formulario_ges').text('El paciente no cuente con formulario GES disponible.');
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