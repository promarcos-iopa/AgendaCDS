<!DOCTYPE html>
<html>

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Documentos Por Pacientes</title>

	<style>
		label {
			color: #adadad !important;
			font-weight: bold !important;
		}

		.clickable-row {
			cursor: pointer;
		}

		/* .ver-documentos-btn {
			cursor: pointer;
			} */

		.documentos-content {
			display: none;
			/* Ocultar los detalles por defecto */
			transition: height 0.3s ease;
			/* Efecto de transición suave */
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

		.logo-usuario2 {
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
			overflow: hidden;
			/* Para clearfix */
			border: 2px solid #3292ff;
			/* Borde azul */
		}

		.custom-panel {
			color: #fff;
			background-color: #76a8ff;
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

		.form-control:disabled,
		.form-control[readonly] {
			background-color: #ffffff !important;
			opacity: 1 !important;
		}

		.img-icon {
			width: 28px;
			/* Tamaño deseado de la imagen */
			height: 28px;
			/* Tamaño deseado de la imagen */
			margin-right: 8px;
			/* Espacio entre la imagen y el texto */
		}

		.css-Guardar:hover {
			background-color: #d2e7ee !important;
			/* Cambia el color de fondo a amarillo al hacer hover */
			color: #0a58ca !important;
			/* Cambia el color del texto a negro al hacer hover */
		}

		.bg-white {
			background-color: white !important;
		}

		.btn-mas,
		.btn-menos {
			transition: opacity 0.9s, visibility 0.9s;
		}

		.btn-menos.hidden,
		.btn-mas.hidden {
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

		.btn-mas,
		.btn-menos {
			cursor: pointer;
			transition: transform 0.5s ease;
			/* Suaviza la rotación */
		}

		.rotate {
			transform: rotate(180deg);
			/* Rota la imagen 180 grados */
		}

		.imgArchivos {
			width: 30px;
			height: 30px;
			margin-bottom: 5px;
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

		.rotate {
			transform: rotate(180deg);
			transition: transform 0.5s ease;
		}
	</style>
</head>

<body>
	<?php require 'views/header.php' ?>
	<div class="">
		<!-- <h2 class="center">Detalle Agenda</h2> -->
		<div class="card" style="margin-top: 120px;margin-left: 250px;margin-right: 250px;">
			<div class="card-body">
				<form class="row" id="form-buscar" action="<?php echo constant('URL'); ?>documentos/verPaginacion_doc_pacientes/1" method="POST">
					<div class="position-relative mb-4">
						<h3>
							<div class="alert alert-primary text-center">Documentos Por Pacientes</div>
						</h3>
					</div>
					<input type="hidden" id="datos_informe" name="datos_informe" value="<?php echo htmlspecialchars(json_encode($this->datos_informe)); ?>">
					<input type="hidden" id="filtro_fecha" name="filtro_fecha" value="<?php echo $this->fecha; ?>">
					<input type="hidden" id="filtro_fecha_hasta" name="filtro_fecha_hasta" value="<?php echo $this->fecha_hasta; ?>">
					<!-- <input type="hidden" id="msg" name="msg" value="<?php echo $this->mensaje; ?>"> -->

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
								<!-- <th>Estado</th> -->
								<!-- <th>Diagnóstico</th> -->
								<!-- <th style="text-align: center;">Documentos</th> -->
								<th style="display:none;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							include_once 'models/medicos.php';
							foreach ($this->citas as $index => $row) {
								$partes = $row["fecha_atencion"];
								// Dividir la cadena en fecha y hora
								list($fecha, $hora) = explode(' ', $partes);
							?>
								<tr>
									<td style="display:none;"><?php echo $row["id"]; ?></td>
									<td class="rut_medico" style="display:none;"><?php echo $row["med_rut_completo"]; ?></td>
									<td class="direccion" style="display:none;"><?php echo $row["direccion"]; ?></td>
									<td class="comuna" style="display:none;"><?php echo $row["comuna"]; ?></td>
									<td class="region" style="display:none;"><?php echo $row["region"]; ?></td>
									<td class="nombre_social_paciente" style="display:none;"><?php echo $row["nombre_social_paciente"]; ?></td>
									<td class="nombre_medico" style="display:none;"><?php echo $row["med_nombre"] . ' ' . $row["med_apellido_paterno"] . ' ' . $row["med_apellido_materno"]; ?></td>

									<!-- <td style="text-align: center;"><?php //echo $row["rut_pnatural"]; 
																			?></td> -->
									<td class="rut_paciente" style="text-align: left;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $row["rut_completo"]; ?></td>
									<td class="nombres_paciente" style="text-align: left;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $row["nombres"] . ' ' . $row["apellido_paterno"] . ' ' . $row["apellido_materno"]; ?></td>
									<td class="email" style="text-align: center;"><?php echo $row["correo_electronico"]; ?></td>
									<td class="telefono" style="text-align: center;">
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
									<td class="fecha_atencion" style="text-align: center;"><?php echo $fecha; ?></td>
									<td class="hora_atencion" style="text-align: center;"><?php echo $hora; ?></td>
									<td class="centro" style="text-align: center;"><?php echo $row["centro"]; ?></td>
									<!-- <td style="text-align: center; font-weight: bold; background-color: <?php echo ($row['recepcionado'] == 1 && $row['codigo_pago_cuenta'] == 2) ? '#a6dfa6' : '#f1c97e'; ?>;
										color: <?php //echo ($row['recepcionado'] == 1 && $row['codigo_pago_cuenta'] == 2) ? 'green' : '#FFA500'; ?>;">
										<?php
										//echo ($row["recepcionado"] == 1 && $row["codigo_pago_cuenta"] == 2) ? 'Asistió' : 'Agendado';
										?>
									</td> -->
									<!-- <td style="text-align: center;"><?php //echo isset($row["detalle_atencion"]) && $row["detalle_atencion"] !== null ? $row["detalle_atencion"] : ""; 
																			?></td> -->
									<!-- <td style="text-align: center;"><?php //echo $row["hora_inicio"] . ' a ' . $row["hora_fin"]; 
																			?></td> -->

									<td style="text-align: center;">
										<img src="<?php echo constant('URL'); ?>public/img/google-mas.png" alt="Imagen" class="btn-mas" style="width: 22px;">
										
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

											<!-- //* Agregado el 26-12-2024 -->
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
							<a class="page-link" href="<?php echo constant('URL'); ?>documentos/verPaginacion_doc_pacientes/<?php echo $this->paginaactual - 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">Anterior</a>
						</li>
						<!-- Bucle para las páginas -->
						<?php for ($i = 0; $i < $this->paginas; $i++): ?>
							<?php if ($i <= 10): ?>
								<li class="page-item <?php echo $this->paginaactual == $i + 1 ? 'active' : ''; ?>">
									<a class="page-link" href="<?php echo constant('URL'); ?>documentos/verPaginacion_doc_pacientes/<?php echo $i + 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">
										<?php echo $i + 1; ?>
									</a>
								</li>
							<?php endif; ?>
						<?php endfor; ?>
						<!-- Enlace para la página siguiente -->
						<li class="page-item <?php echo $this->paginaactual >= $this->paginas ? 'disabled' : ''; ?>">
							<a class="page-link" href="<?php echo constant('URL'); ?>documentos/verPaginacion_doc_pacientes/<?php echo $this->paginaactual + 1; ?>?fecha=<?php echo $this->fecha; ?>&fecha_hasta=<?php echo $this->fecha_hasta; ?>">Siguiente</a>
						</li>
					</ul>
				</nav>
			</div>
		</div>
	</div>

	<?php require 'views/footer.php' ?>
	<script>

		//* Actualizado el 26-12-2024 toda la funcion incluyendo su nombre funcion
		function ver_documento(tipoDoc, rut, nombrePaciente, fecha_atencion, centro, email, telefono, hora_atencion, rut_medico, nombre_medico,direccion,comuna,region,nombre_social_paciente){

			let metodo = "";
			if(tipoDoc =='consentimiento'){
				metodo = "ver_pdf";
			}else if(tipoDoc =='ges'){
				metodo = "ver_ges_pdf";
			}

			const url = "<?php echo constant('URL') ?>documentos/"+metodo;
			const queryParams = new URLSearchParams({
				rut,
				nombrePaciente,
				fecha_atencion,
				centro, 
				email, 
				telefono,
				hora_atencion,
				rut_medico, 
				nombre_medico,
				direccion,
				comuna,
				region,
				nombre_social_paciente
			});
			console.log(queryParams);
			const finalUrl = `${url}?${queryParams.toString()}`;
			window.open(finalUrl, '_blank', 'width=800,height=600,resizable=yes');
			// window.open(url+'/'+rut+'/'+nombrePaciente+'/'+fecha_atencion+'/'+centro, '_blank', 'width=800,height=600,resizable=yes');
		}

		$(document).ready(function() {

			// Expandir fila
			$("#tblDocumentos").on("click", ".btn-mas", function() {
				var filaPrincipal = $(this).closest("tr"); // Seleccionar la fila actual
				var filaExpandida = filaPrincipal.next(".expand-row"); // Seleccionar la fila expandida siguiente
				// Obtiene el los datos columna de la fila principal segun posicion
				// var rut = filaPrincipal.find("td:nth-child(2)").text();
				// var fecha_atencion = filaPrincipal.find("td:nth-child(6)").text();
				// var estado = filaPrincipal.find("td:nth-child(9)").text().trim();

				// if (estado != 'Agendado') {
					// Ocultar el botón "+" y mostrar "-"
					$(this).hide();
					filaPrincipal.find(".btn-menos").show();
					// Mostrar la fila expandida
					filaExpandida.show();
					// Llamar a funciones específicas
					// cargarRecetas(rut, fecha_atencion);

				// }

			});

			// Colapsar fila
			$("#tblDocumentos").on("click", ".btn-menos", function() {
				var filaPrincipal = $(this).closest("tr"); // Seleccionar la fila actual
				var filaExpandida = filaPrincipal.next(".expand-row"); // Seleccionar la fila expandida siguiente

				// Ocultar el botón "-" y mostrar "+"
				$(this).hide();
				filaPrincipal.find(".btn-mas").show();

				// Ocultar la fila expandida
				filaExpandida.hide();
			});


			//* Actualizado el 26-12-2024 TODO
			// identifica el elemeto al cual se realizo el evento click
			$('#tblDocumentos').on('click', '.descarga', function(e) {
				e.preventDefault();

				// Navegar a la fila principal para obtener el RUT y el nombre del paciente
				let filaPrincipal = $(this).closest('tr').prev();
				let rut = filaPrincipal.find('.rut_paciente').text().trim();
				let nombrePaciente = filaPrincipal.find('.nombres_paciente').text().trim();

				let rut_medico = filaPrincipal.find('.rut_medico').text().trim();
				let nombre_medico = filaPrincipal.find('.nombre_medico').text().trim();

				//* Agregados el 23-12-2024
				let fecha_atencion = filaPrincipal.find('.fecha_atencion').text();
				let centro = filaPrincipal.find('.centro').text();
				let email = filaPrincipal.find('.email').text().trim();
				let telefono = filaPrincipal.find('.telefono').text().trim();
				let hora_atencion = filaPrincipal.find('.hora_atencion').text();

				let direccion =filaPrincipal.find('.direccion').text();
				let comuna =filaPrincipal.find('.comuna').text();
				let region =filaPrincipal.find('.region').text();
				let nombre_social_paciente =filaPrincipal.find('.nombre_social_paciente').text();

			
				//* Agregado el 26-12-2024
				let tipoDocumento = "";
				if ($(this).hasClass('consentimiento')) {
					tipoDocumento = "consentimiento";
				} else if ($(this).hasClass('ges')) {
					tipoDocumento = "ges";
				}

				// console.log("Tipo de documento:", tipoDocumento);

				//* Actualizado el 26-12-2024
				ver_documento(tipoDocumento, rut, nombrePaciente, fecha_atencion, centro, email, telefono, hora_atencion, rut_medico, nombre_medico,direccion,comuna,region,nombre_social_paciente);

			});


		});

	</script>
</body>

</html>