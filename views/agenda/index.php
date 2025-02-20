<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Médica</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
    <style>
        /* Personaliza el estilo del calendario */
        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }
        .fc-toolbar-title {
            font-size: 1.5rem;
        }
        .fc-event {
            font-size: 0.85rem;
            border-radius: 5px;
        }

		.fc-toolbar-title {
			color: #76818d;
		}

		.text_grey{
			color: #1a252f;
		}
		.fc-timegrid-slot-label-cushion{
			color: #1a252f;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {
			color: #1a252f !important; /* Cambiar el color del texto */
		}

		/* estilo tab */
		.card {
			box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
			margin-bottom: 1rem;
		}

		.card {
			position: relative;
			display: -ms-flexbox;
			display: flex;
			-ms-flex-direction: column;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;
			border: 0 solid rgba(0, 0, 0, .125);
			border-radius: .25rem;
		}



		.card.card-tabs:not(.card-outline)>.card-header {
			border-bottom: 0;
		}

		.card-secondary:not(.card-outline)>.card-header, .card-secondary:not(.card-outline)>.card-header a {
			color: #fff;
		}
		.card-secondary:not(.card-outline)>.card-header {
			background-color: #59b1ff;
		}
		.card-header:first-child {
			border-radius: calc(.25rem - 0) calc(.25rem - 0) 0 0;
		}
		.card-header {
			background-color: transparent;
			border-bottom: 1px solid rgba(0, 0, 0, .125);
			padding: .75rem 1.25rem;
			position: relative;
			border-top-left-radius: .25rem;
			border-top-right-radius: .25rem;
		}


		fieldset.scheduler-border {
			border: 1px groove #ddd !important;
			/* padding: 0 1.4em 1.4em 1.4em !important; */
			padding: 1.4em 1.4em 1.4em 1.4em !important; 
			margin: 0 0 1.5em 0 !important;
			-webkit-box-shadow: 0px 0px 0px 0px #000;
			box-shadow: 0px 0px 0px 0px #000;
		}
		fieldset {
			min-width: 0;
			padding: 0;
			margin: 0;
			border: 0;
		}


		legend.scheduler-border {
			position: absolute;
			top: 50px;
			font-size: 1.2em !important;
			font-weight: bold !important;
			text-align: left !important;
			width: auto;
			padding: 0 10px;
			border-bottom: none;
			background: white; /* Fondo blanco para que el texto cubra el borde */
			font-size: 16px !important; /* Tamaño de la fuente */
			color: #074994;
		}

	

		legend {
			display: block;
			width: 100%;
			max-width: 100%;
			padding: 0;
			margin-bottom: .5rem;
			font-size: 1.5rem;
			line-height: inherit;
			color: inherit;
			white-space: normal;
		}

		.prom_label {
			color: #074994;
		}

		.nav-link.active {
			color: #074994 !important; /* Cambia el color del texto a azul */
		}

		/* .fc-timegrid-slot {
			background-color: #f8f9fa;
		} */


		/* Estilo para cambiar el color de los iconos de los eventos a gris claro */
		.evento-personalizado i.fa-clock {
			color: #0d6efd; /* Gris claro */
		}


		.custom-icon {
			color: #fff !important;
		}

		.btn-sincronizar {
			background-color: #4cbd3e !important;
			border-color: #09bd07 !important;
			color: white !important;
			border-radius: 12px !important;
		}

		.btn-sincronizar:hover {
            background-color: #349228 !important; 
            color: white !important;
            border-color: #09bd07 !important;
        }

		
    </style>
</head>
<body>
<?php require 'views/header.php'; ?>
<div class="">
	<div class="card"style="margin-top: 120px;margin-left: 220px;margin-right: 220px;">
		<div class="card-body">
			<div class="row">
				<div class="col-md-2 bg-light">
					<div class="mt-3">
						<h5 class="text_grey" style="color: #76818d;">Filtrar por fecha</h5>
						<input id="fecha_bloque" name="fecha_bloque" type="date" class="form-control form-control-sm mb-3" />
						
						<h5 class=" text_grey mt-4" style="color: #76818d;">Médicos</h5>
						<select class="form-control mb-3" id="medico" name="medico">
                        </select>
						
						<!-- <ul class="list-group">
							<li class="list-group-item">Andrés Gaona</li>
							<li class="list-group-item">Penélope Villacres</li>
							<li class="list-group-item">Sebastián Casaus</li>
						</ul> -->
						
					</div>
					<div class="mt-3">
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button id="buscar_bloque_medico" type="button" class="btn btn-guardar btn-sm" style="width: 226px;">
								<svg class="filter-icon check-guardar" xmlns="http://www.w3.org/2000/svg" focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="FilterIcon">
									<path d="M10 18h4v-2h-4v2zm-7-8v2h18v-2H3zm3-6v2h12V4H6z"/>
								</svg>
                                Filtrar datos
                            </button>
                        </div>
					</div>
					<div class="mt-3">
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button id="limpiar_filtros" type="button" class="btn btn-limpiar btn-sm" style="width: 226px;">
							<i class="fas fa-eraser" style="padding-right: 10px;"></i>Limpiar
                            </button>
                        </div>
					</div>
					<div class="mt-3">
						<div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button id="sincronizar_agenda_rs" type="button" class="btn btn-sincronizar btn-sm" style="width: 226px;">
							Sincronizar Agenda
                            </button>
                        </div>
					</div>
					
				</div>

				<div class="col-md-10">
					<!-- Aquí va el calendario -->
					<div id="calendar"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Modal reserva de hora  -->
<div class="modal fade" id="reservaModal" tabindex="-1" role="dialog" aria-labelledby="reservaModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" id="id_horario" name="id_horario" value="">
				<!-- <input type="text" id="id_horario" name="id_horario" value=""> -->
				<!-- <p id="modalEventoTitulo"></p>
				<p id="modalEventoHora"></p>
				<p id="modalEventoID"></p> -->
				<!-- Pestañas tab -->
				<div class="container-fluid">
					<div class="row">
						<div class="col-12 col-sm-12">
							<div class="card card-secondary card-tabs">
								<div class="card-header p-0 pt-1">
									<ul class="nav nav-tabs" id="custom-tabs-one-tab" id="myTab" role="tablist">
										<li class="nav-item" role="presentation">
											<a class="nav-link active" id="agendar-tab" data-bs-toggle="tab" data-bs-target="#agendar" role="tab" aria-controls="agendar" aria-selected="true"><i class="fas fa-calendar-check"></i>&nbsp;&nbsp;Agendar</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="nav-link" id="sobreCupo-tab" data-bs-toggle="tab" data-bs-target="#sobre_cupo" role="tab" aria-controls="sobre_cupo" aria-selected="true"><i class="fas fa-calendar-check"></i>&nbsp;&nbsp;Sobre Cupo</a>
										</li>
										<li class="nav-item" role="presentation">
											<a class="nav-link" id="eliminar-tab"  data-bs-toggle="tab" data-bs-target="#eliminar" role="tab" aria-controls="eliminar" aria-selected="true"><i class="fas fa-calendar-times"></i>&nbsp;&nbsp;Anular</a>
										</li>
									</ul>
								</div><!-- /.card-header -->
								<div class="card-body">
									<div class="tab-content" id="custom-tabs-one-tabContent">
										<!-- Pestaña Agendar -->
										<div class="tab-pane fade show active" id="agendar" role="tabpanel" aria-labelledby="agendar-tab">
											<fieldset class="scheduler-border">
												<legend class="scheduler-border">Ingreso de Reserva </legend>
												<form name="formAgendar" id="formAgendar" method="POST" action="">
													<!-- REGISTROS DEL ENCABEZADO  -->
													<div class="row mt-3">
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="medico">MÉDICO</label> 
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<span class="prom_span medico_agenda" id="medico_agenda" name="medico_agenda"></span>
																<span class="prom_span rut_m" id="rut_m" name="rut_m" style="display: none;"></span>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="agendado_por">AGENDADO POR</label> 
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<span class="prom_span agendado_por" id="agendado_por" name="agendado_por"><?php echo $_SESSION["nombre"] ?></span>
															</div>
														</div>
													</div><!-- /.row MÉDICO-->

													<div class="row mt-2">
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="lugar_consulta">LUGAR CONSULTA :</label> 
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<span class="prom_span lugar_consulta" id="lugar_consulta" name="lugar_consulta">LOS LEONES</span>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="fecha_consulta">FECHA CONSULTA :</label> 
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<span class="prom_span fecha_consulta" id="fecha_consulta" name="fecha_consulta"></span>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="hora_consulta">HORA CONSULTA :</label> 
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<span class="prom_span hora_consulta" id="hora_consulta" name="hora_consulta"></span>
															</div>
														</div>
													</div>
													<!-- FIN DEL ENCABEZADO  -->


													<div class="row mt-3">
														<!-- RUT -->
														<div class="form-group col-md-3">
															<label for="rut_p"  class="prom_label">Rut paciente:</label>
															<input type="text" class="form-control" id="rut_p" name="rut_p" maxlength="10" oninput="formatRut()" required>
															<input type="text" class="form-control" id="id_reserva" name="id_reserva" hidden>
														</div>
														<!-- NOMBRE -->
														<div class="form-group col-md-3">
															<label for="nombre_p"  class="prom_label">Nombre:</label>
															<input type="text" class="form-control" id="nombre_p" name="nombre_p" required>
														</div>
														<!-- APELLIDO 1 -->
														<div class="form-group col-md-3">
															<label for="apellido_1p"  class="prom_label">Apellido 1:</label>
															<input type="text" class="form-control" id="apellido_1p" name="apellido_1p" required>
														</div>
														<!-- APELLIDO 2  -->
														<div class="form-group col-md-3">
															<label for="apellido_2p"  class="prom_label">Apellido 2 :</label>
															<input type="text" class="form-control" id="apellido_2p" name="apellido_2p" required>
														</div>
														<!-- FECHA NACIMIENTO  -->
														<div class="form-group col-md-3 mt-2">
															<label for="fecha_nac_p"  class="prom_label">Fecha nacimiento :</label>
															<input type="date" class="form-control" id="fecha_nac_p" name="fecha_nac_p" required>
														</div>
														<!-- DIRECCION  -->
														<div class="form-group col-md-4 mt-2">
															<label for="direccion_p"  class="prom_label">Dirección :</label>
															<input type="text" class="form-control" id="direccion_p" name="direccion_p"  required>
														</div>
														<!-- EMAIL -->
														<div class="form-group col-md-5 mt-2">
															<label for="email_p"  class="prom_label">Email :</label>
															<input type="email" class="form-control" id="email_p" name="email_p" required>
														</div>
														<!-- TELEFONOS -->
														<div class="form-group col-md-3 mt-2">
															<label for="fono_1p" class="prom_label">Teléfono 1 :</label>
															<input type="tel" class="form-control" id="fono_1p" name="fono_1p" required pattern="[0-9]{9,15}" >
														</div>
														<div class="form-group col-md-3 mt-2">
															<label for="fono_2p"  class="prom_label">Telefono 2 :</label>
															<input type="tel" class="form-control" id="fono_2p" name="fono_2p" required pattern="[0-9]{9,15}" >
														</div>

														<!-- RADIO BUTON GENERO -->
														<div class="col-md-6 mt-4">
															<div class="form-group row">
																<label for="genero" class="col-form-label col-md-3 prom_label">Género:</label>
																<div class="col-md-4 mt-2">
																	<div class="form-check form-check-inline">
																		<input class="form-check-input" type="radio" name="genero" id="genero_h" value="h" required>
																		<label class="form-check-label prom_label" for="genero_h">H</label>
																	</div>
																	<div class="form-check form-check-inline">
																		<input class="form-check-input" type="radio" name="genero" id="genero_m" value="m">
																		<label class="form-check-label prom_label" for="genero_m">M</label>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="row mt-2">
														<!-- CENTRO -->
														<div class="form-group col-md-3">
															<label for="centro_derivado_p"  class="prom_label">Centro :</label>
															<input type="text" class="form-control" id="centro_derivado_p" name="centro_derivado_p" required>
														</div>
														<div class="form-group col-md-3">
															<label for="prevision_p"  class="prom_label">Previsión :</label>
															<input type="text" class="form-control prevision_p" id="prevision_p" name="prevision_p" value="" disabled>
														</div>
														<!-- OBSERVACION -->
														<div class="form-group col-md-6">
															<label for="observacion"  class="prom_label">Observación :</label>
															<textarea id="observacion" name="observacion" class="form-control" rows="1" required></textarea>
														</div>
													</div>
													
													<!-- <div class="row text-center">
														<div class="col-sm-12">
															<div class="form-group">
															<div class="icheck-primary d-inline">
																<input type="checkbox" id="confirma" name="confirma">
																<label for="confirma">
																	<span class="prom_label">CONFIRMADA</span>
																</label>
															</div>
															</div>
														</div>
														
													</div> -->
													<!-- /.row CONFIRMADA-->

													<div class="row text-center mt-5">
														<div class="col-sm-12">
															<div class="form-group">
																<button id="btnAgendar" type="button" class="btn btn-guardar" style="width: 200px;">
																	<i class="fas fa-calendar-check" style="padding-right: 10px;"></i>Agendar
																</button>
																<button id="btnLimpiar" type="button" class="btn btn-limpiar" style="width: 200px;">
																	<i class="fas fa-eraser" style="padding-right: 10px;"></i>Limpiar
																</button>
																<button type="button" id="btn_eliminar_hora" class="btn btn-eliminar" style="width: 200px;"><i class="fas fa-calendar-times"></i>&nbsp;&nbsp;Anular Hora</button>&nbsp;
																<button type="button" class="btn btn-cerrar" data-dismiss="modal" style="width: 200px; border-radius: 12px;"><i class="fas fa-times-circle"></i>&nbsp;Cerrar</button>
															</div>
														</div>              
													</div><!-- /.row -->
												</form>
											</fieldset> 
										</div><!-- /.Pestaña Agendar -->    
										
										
										<!-- Pestaña Agendar sobre cupo -->
										<div class="tab-pane fade show " id="sobre_cupo" role="tabpanel" aria-labelledby="sobreCupo-tab">
											<fieldset class="scheduler-border">
												<legend class="scheduler-border">Ingreso de Reserva </legend>
												<form name="form_agendar_sobre_cupo" id="form_agendar_sobre_cupo" method="POST" action="">
													<!-- REGISTROS DEL ENCABEZADO  -->
													<div class="row mt-3">
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="medico">MÉDICO</label> 
															</div>
														</div>
														<div class="col-sm-3">
															<div class="form-group">
																<span class="prom_span medico_agenda" id="cupo_medico_agenda" name="cupo_medico_agenda"></span>
																<span class="prom_span rut_m" id="cupo_rut_m" name="cupo_rut_m" style="display: none;"></span>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="agendado_por">AGENDADO POR</label> 
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<span class="prom_span agendado_por" id="cupo_agendado_por" name="cupo_agendado_por"><?php echo $_SESSION["nombre"] ?></span>
															</div>
														</div>
													</div><!-- /.row MÉDICO-->

													<div class="row mt-2">
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="lugar_consulta">LUGAR CONSULTA :</label> 
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<span class="prom_span lugar_consulta" id="cupo_lugar_consulta" name="cupo_lugar_consulta">LOS LEONES</span>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="fecha_consulta">FECHA CONSULTA :</label> 
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<span class="prom_span fecha_consulta" id="cupo_fecha_consulta" name="cupo_fecha_consulta"></span>
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<label class="prom_label" for="hora_consulta">HORA CONSULTA :</label> 
															</div>
														</div>
														<div class="col-sm-2">
															<div class="form-group">
																<span class="prom_span hora_consulta" id="cupo_hora_consulta" name="cupo_hora_consulta"></span>
															</div>
														</div>
													</div>
													<!-- FIN DEL ENCABEZADO  -->


													<div class="row mt-3">
														<!-- RUT -->
														<div class="form-group col-md-3">
															<label for="cupo_rut_p" class="prom_label">Rut paciente:</label>
															<input type="text" class="form-control" id="cupo_rut_p" name="rut_p" maxlength="10" oninput="formatRut()" required>
															<input type="text" class="form-control" id="cupo_id_reserva" name="cupo_id_reserva" hidden>
														</div>
														<!-- NOMBRE -->
														<div class="form-group col-md-3">
															<label for="cupo_nombre_p" class="prom_label">Nombre:</label>
															<input type="text" class="form-control" id="cupo_nombre_p" name="nombre_p" required>
														</div>
														<!-- APELLIDO 1 -->
														<div class="form-group col-md-3">
															<label for="cupo_apellido_1p" class="prom_label">Apellido 1:</label>
															<input type="text" class="form-control" id="cupo_apellido_1p" name="apellido_1p" required>
														</div>
														<!-- APELLIDO 2 -->
														<div class="form-group col-md-3">
															<label for="cupo_apellido_2p" class="prom_label">Apellido 2:</label>
															<input type="text" class="form-control" id="cupo_apellido_2p" name="apellido_2p" required>
														</div>
														<!-- FECHA NACIMIENTO -->
														<div class="form-group col-md-3 mt-2">
															<label for="cupo_fecha_nac_p" class="prom_label">Fecha nacimiento:</label>
															<input type="date" class="form-control" id="cupo_fecha_nac_p" name="fecha_nac_p" required>
														</div>
														<!-- DIRECCION -->
														<div class="form-group col-md-4 mt-2">
															<label for="cupo_direccion_p" class="prom_label">Dirección:</label>
															<input type="text" class="form-control" id="cupo_direccion_p" name="direccion_p" required>
														</div>
														<!-- EMAIL -->
														<div class="form-group col-md-5 mt-2">
															<label for="cupo_email_p" class="prom_label">Email:</label>
															<input type="email" class="form-control" id="cupo_email_p" name="email_p" required>
														</div>
														<!-- TELEFONOS -->
														<div class="form-group col-md-3 mt-2">
															<label for="cupo_fono_1p" class="prom_label">Teléfono 1:</label>
															<input type="tel" class="form-control" id="cupo_fono_1p" name="fono_1p" required pattern="[0-9]{9,15}">
														</div>
														<div class="form-group col-md-3 mt-2">
															<label for="cupo_fono_2p" class="prom_label">Teléfono 2:</label>
															<input type="tel" class="form-control" id="cupo_fono_2p" name="fono_2p" required pattern="[0-9]{9,15}">
														</div>

														<!-- RADIO BUTTON GENERO -->
														<div class="col-md-6 mt-4">
															<div class="form-group row">
															<label for="cupo_genero" class="col-form-label col-md-3 prom_label">Género:</label>
															<div class="col-md-4 mt-2">
																<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio" name="cupo_genero" id="cupo_genero_h" value="h" required>
																<label class="form-check-label prom_label" for="cupo_genero_h">H</label>
																</div>
																<div class="form-check form-check-inline">
																<input class="form-check-input" type="radio" name="cupo_genero" id="cupo_genero_m" value="m">
																<label class="form-check-label prom_label" for="cupo_genero_m">M</label>
																</div>
															</div>
															</div>
														</div>
													</div>
													<div class="row mt-2">
														<!-- CENTRO -->
														<div class="form-group col-md-3">
															<label for="cupo_centro_derivado_p"  class="prom_label">Centro :</label>
															<input type="text" class="form-control" id="cupo_centro_derivado_p" name="cupo_centro_derivado_p" required>
														</div>
														<div class="form-group col-md-3">
															<label for="prevision_p"  class="prom_label">Previsión :</label>
															<input type="text" class="form-control prevision_p" id="cupo_prevision_p" name="cupo_prevision_p" value="" disabled>
														</div>
														<!-- OBSERVACION -->
														<div class="form-group col-md-6">
															<label for="cupo_observacion"  class="prom_label">Observación :</label>
															<textarea id="cupo_observacion" name="cupo_observacion" class="form-control" rows="1" required></textarea>
														</div>
													</div>
													
													<!-- <div class="row text-center">
														<div class="col-sm-12">
															<div class="form-group">
															<div class="icheck-primary d-inline">
																<input type="checkbox" id="confirma" name="confirma">
																<label for="confirma">
																	<span class="prom_label">CONFIRMADA</span>
																</label>
															</div>
															</div>
														</div>
													</div> -->
													<!-- /.row CONFIRMADA-->

													<div class="row text-center mt-5">
														<div class="col-sm-12">
															<div class="form-group">
																<button id="btn_agendar_sobre_cupo" type="button" class="btn btn-guardar" style="width: 200px;">
																	<i class="fas fa-calendar-check" style="padding-right: 10px;"></i>Agendar
																</button>
																<button id="btn_limpiar_cupo" type="button" class="btn btn-limpiar" style="width: 200px;">
																	<i class="fas fa-eraser" style="padding-right: 10px;"></i>Limpiar
																</button>
																<button type="button" id="btn_eliminar_hora_cupo" class="btn btn-eliminar" style="width: 200px;"><i class="fas fa-calendar-times"></i>&nbsp;&nbsp;Anular Hora</button>&nbsp;
																<button type="button" class="btn btn-cerrar" data-dismiss="modal" style="width: 200px; border-radius: 12px;"><i class="fas fa-times-circle"></i>&nbsp;Cerrar</button>
																
															</div>
														</div>              
													</div><!-- /.row -->
												</form>
											</fieldset> 
										</div><!-- /.Pestaña Agendar -->   
										
										<!-- Pestaña Eliminar -->
										<div class="tab-pane fade" id="eliminar" role="tabpanel" aria-labelledby="eliminar-tab">
											<fieldset class="scheduler-border">
												<legend class="scheduler-border" >Anulación de Bloques</legend>
													<form name="formEliminarHora" id="formEliminarHora" method="POST" action="">

														<div class="row mt-3">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="dia_mostrar_e">DÍA</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="dia_mostrar_e"></span>
																</div>
															</div>
														</div><!-- /.row DIA-->
														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="medico_mostrar_e">MÉDICO</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="medico_mostrar_e"></span>
																</div>
															</div>
														</div><!-- /.row MEDICO-->
														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="lugar_consulta_mostrar_e">LUGAR ATENCIÓN</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="lugar_consulta_mostrar_e">LOS LEONES</span>
																</div>
															</div>
														</div><!-- /.row SUCURSAL-->
														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="paciente_mostrar_e">PACIENTE</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="paciente_mostrar_e"></span>
																</div>
															</div>
														</div><!-- /.row PACIENTE -->
														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="fecha_consulta_e">FECHA</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="fecha_consulta_e"></span>
																</div>
															</div>
														</div><!-- /.row FECHA -->
														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="hora_i_e">HORA INICIO</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="hora_i_e"></span>
																</div>
															</div>
														</div><!-- /.row HORA INICIO-->
														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="hora_t_e">HORA TÉRMINO</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="hora_t_e"></span>
																</div>
															</div>
														</div><!-- /.row HORA TERMINO-->
														<div class="row">
															<div class="col-sm-3">
																<div class="form-group">
																	<label class="prom_label" for="duracion_consulta_e">DURACIÓN CONSULTA</label> 
																</div>
															</div>
															<div class="col-sm-3">
																<div class="form-group">
																<b>:</b>&nbsp;&nbsp;<span id="duracion_consulta_e"></span>
																</div>
															</div>
														</div><!-- /.row DURACION-->
														<div class="row">
															<div class="form-group col-md-6">
																<label for="motivo_anula"  class="prom_label">MOTIVO ANULACIÓN</label>
																<textarea id="motivo_anula" name="motivo_anula" class="form-control" rows="1" required></textarea>
															</div>
														</div><!-- /.row DURACION-->
														<br>
														<div class="row text-center mt-5">
															<div class="col-sm-12">
																<div class="form-group">
																	<button type="button" id="btnEliminarHora" class="btn btn-eliminar" style="width: 200px;"><i class="fas fa-calendar-times"></i>&nbsp;&nbsp;Anular Hora</button>&nbsp;
																	<button type="button"  class="btn btn-cerrar " data-dismiss="modal" style="width: 200px; border-radius: 12px;"><i class="fas fa-times-circle"></i>&nbsp;Cerrar</button>
																</div>
															</div>              
														</div><!-- /.row -->
													</form>
											</fieldset>   
										</div><!-- /.Pestaña Eliminar -->   

									</div><!-- /.tab-content -->
					
								</div><!-- /.card-body -->

							</div><!-- /.card -->

						</div><!-- /.col -->

					</div><!-- /.row -->

				</div>

			</div>
		</div>
	</div>
</div>






	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/locales/es.js"></script> <!-- Idioma español -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="<?php echo constant('URL'); ?>public/select2/js/select2.full.min.js"></script>
	<script>
        document.addEventListener('DOMContentLoaded', function() {

			buscarMedicos();
			instanciaFullcalendar();
			$('#sobreCupo-tab').prop('disabled', true);

			$('.prevision_p').val('CDS');

			$('#medico').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });


			$('.btn-cerrar').click(function() {
				$('#reservaModal').modal('hide'); // Cerrar la modal
				$('#formAgendar')[0].reset();
				$('#form_agendar_sobre_cupo')[0].reset();
							
			});



			// $("#buscar_bloque_medico").click(function () {
			// 	//dayGridMonth ->condiguracion calendario para mostrar el mes
			// 	//editable: false,
			// 	//selectable: true,
			// 	//nowIndicator: true
			// 	let medico_select = $('#medico').val();
			// 	let medico_nombre = $('#medico').select2('data')[0].text;
			// 	let fecha_bloque = $('#fecha_bloque').val();
			// 	console.log(medico_select);
			// 	console.log(medico_nombre);
			// 	console.log(fecha_bloque);
			// 	if (medico_nombre !='Seleccione Médico'){

			// 		obtener_bloque_medico().then(data => {
					
			// 		let bloque_medico = data; // Almacenar los datos en bloque_medico
			// 		if (bloque_medico!=''){
			// 			// console.log("Datos almacenados en bloque_medico:", bloque_medico);
			// 			let calendarEl = document.getElementById('calendar');

			// 			let config = {
			// 				locale: 'es',  // Configura el calendario a español
			// 				initialView: 'timeGridWeek', // Vista predeterminada por semana
			// 				slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
			// 				slotDuration: '00:10:00',
			// 				slotLabelInterval: "00:10:00",
			// 				slotMinTime: '08:00:00',
			// 				slotMaxTime: '19:20:00',
			// 				eventTextColor: '#000',
			// 				eventBorderColor: 'gray',
			// 				allDaySlot: false, // Remueve la fila "Todo el día"
			// 				headerToolbar: {
			// 					left: 'prev,next today',
			// 					center: 'title',
			// 					right: 'timeGridWeek,timeGridDay'
			// 				},
			// 				events: bloque_medico,
			// 				// Aquí es donde configuramos el evento `eventClick`
			// 				eventClick: function(info) {
			// 					// info.event es el evento que se ha clicado
			// 					let event = info.event;
			// 					// Obtener el ID del evento
			// 					let eventId = event.id;
								
			// 					// Mostrar en consola el título, detalles y ID del evento
			// 					console.log('Evento clicado:', event.title);
			// 					console.log('Detalles del evento:', event);
			// 					console.log('ID del evento:', eventId);
								
			// 					let tituloEvento = `Evento: ${event.title}`;
			// 					// Mostrar la información del evento en el modal
			// 					// $('#modalEventoTitulo').text(`Evento: ${event.title}`);
			// 					// $('#modalEventoHora').text(`Hora: ${event.start.toLocaleString()} - ${event.end.toLocaleString()}`);
			// 					// $('#modalEventoID').text(`ID: ${eventId}`);  // Mostrar el ID en el modal

			// 					let cadena = `Hora: ${event.start.toLocaleString()} - ${event.end.toLocaleString()}`;
			// 					// Elimina el prefijo "Hora: " y divide por " - " para separar la hora de inicio y fin
			// 					let partes = cadena.replace('Hora: ', '').split(' - ');

			// 					// La primera parte contiene la fecha y hora de inicio
			// 					let inicio = partes[0].split(', ');  // Divide fecha y hora en la parte de inicio
			// 					let fechaInicio = inicio[0];          // Fecha de inicio
			// 					fechaInicio = rellenarConCerosFecha(fechaInicio);
			// 					let horaInicio = inicio[1];           // Hora de inicio
			// 					horaInicio = rellenarConCerosHora(horaInicio);
								

			// 					// La segunda parte contiene la fecha y hora de fin
			// 					let fin = partes[1].split(', ');      // Divide fecha y hora en la parte de fin
			// 					let fechaFin = fin[0];                // Fecha de fin
			// 					fechaFin = rellenarConCerosFecha(fechaFin);
			// 					let horaFin = fin[1];                 // Hora de fin
			// 					horaFin = rellenarConCerosHora(horaFin);

			// 					let hora_consulta = horaInicio +" a "+horaFin;
			// 					$('#id_horario').val(eventId); 

			// 					// TAB AGENDAR 
			// 					$('.id_horario').val(eventId);  // ID del evento
			// 					$('.rut_m').text(medico_select);  
			// 					$('.medico_agenda').text(medico_nombre);  
			// 					$('.fecha_consulta').text(fechaInicio); 
			// 					$('.hora_consulta').text(hora_consulta); 
			// 					$('.prevision_p').val('CDS');

			// 					// TAB ELIMINAR
			// 					let dia_e = obtenerDiaEnPalabras(fechaInicio);
			// 					$('#dia_mostrar_e').text(dia_e);
			// 					$('#medico_mostrar_e').text(medico_nombre);
								
			// 					$('#fecha_consulta_e').text(fechaInicio);
			// 					$('#hora_i_e').text(horaInicio);
			// 					$('#hora_t_e').text(horaFin);
			// 					let intervalo = calcularIntervalo(horaInicio, horaFin);
			// 					$('#duracion_consulta_e').text(intervalo);
								
															
								
			// 					if (tituloEvento =='Evento: ocupado'){
			// 						// cargar datos de la reserva 
			// 						cargar_reserva_agenda(eventId).then(data => {
			// 							let reservas = JSON.parse(data); 
			// 							console.log(reservas);
			// 							// exit();
			// 							$('#paciente_mostrar_e').text(reservas[0].nombre+" "+reservas[0].apellido1+" "+reservas[0].apellido2);
			// 							// console.log('Tipo de data:', Array.isArray(data) ? 'Arreglo' : typeof data);
    		// 							// console.log('Contenido de data:', data);
			// 							// Verifica si la respuesta es un arreglo y no está vacío
			// 							if (Array.isArray(reservas) && reservas.length > 0) {
			// 								// Llenar campos sobre cupo con el segundo elemento del arreglo (el segundo paciente)
			// 								reservas.forEach((reserva, index) => {
			// 									// Si el índice es 1 (segundo elemento, ya que el conteo empieza en 0)
			// 									if (index === 1) {
			// 										$('#cupo_id_reserva').val(reservas[1].id);
			// 										$('#cupo_rut_p').val(reservas[1].rut);
			// 										$('#cupo_nombre_p').val(reservas[1].nombre);
			// 										$('#cupo_apellido_1p').val(reservas[1].apellido1);
			// 										$('#cupo_apellido_2p').val(reservas[1].apellido2);
			// 										$('#cupo_fecha_nac_p').val(reservas[1].fecha_nacimiento);
			// 										$('#cupo_direccion_p').val(reservas[1].direccion);
			// 										$('#cupo_email_p').val(reservas[1].email);
			// 										$('#cupo_fono_1p').val(reservas[1].telefono);
			// 										$('#cupo_fono_2p').val(reservas[1].telefono2);
			// 										$('input[name="cupo_genero"][value="' + reservas[1].sexo + '"]').prop('checked', true);
			// 										$('#cupo_centro_derivado_p').val(reservas[1].centro);
			// 										$('#cupo_observacion').val(reservas[1].observacion);
			// 									}
			// 								});


			// 								// Accede directamente a las propiedades del primer objeto del arreglo
			// 								$('#id_reserva').val(reservas[0].id);
			// 								$('#rut_p').val(reservas[0].rut);
			// 								$('#nombre_p').val(reservas[0].nombre);
			// 								$('#apellido_1p').val(reservas[0].apellido1);
			// 								$('#apellido_2p').val(reservas[0].apellido2);
			// 								$('#fecha_nac_p').val(reservas[0].fecha_nacimiento);
			// 								$('#direccion_p').val(reservas[0].direccion);
			// 								$('#email_p').val(reservas[0].email);
			// 								$('#fono_1p').val(reservas[0].telefono);
			// 								$('#fono_2p').val(reservas[0].telefono2);
			// 								$('input[name="genero"][value="' + reservas[0].sexo + '"]').prop('checked', true);
			// 								$('#centro_derivado_p').val(reservas[0].centro);
			// 								$('#observacion').val(reservas[0].observacion);

			// 								// Mostrar el modal
			// 								$('#reservaModal').modal('show');
			// 							} else {
			// 								console.warn('No se encontraron reservas o la respuesta no es un arreglo válido:', data);
			// 							}
			// 						}).catch(error => {
			// 							console.error("Error al obtener bloque médico:", error);
			// 						});

			// 					}else{

			// 						// Validar que la fecha del evento agendado no sea anterior a la fecha actual si es el mismo día
			// 						// let fechaHoy = new Date();
			// 						// let fechaEvento = new Date(event.start);

			// 						// /// Validar que la hora del evento no sea anterior a la hora actual si es el mismo día
			// 						// if (fechaEvento.toDateString() === fechaHoy.toDateString()) {
			// 						// 	let horaActual = fechaHoy.getHours() + ':' + fechaHoy.getMinutes();
			// 						// 	let horaEvento = event.start.getHours() + ':' + event.start.getMinutes();
			// 						// 	debugger;
			// 						// 	if (horaEvento <= horaActual) {
			// 						// 		Swal.fire({
			// 						// 			icon: 'warning',
			// 						// 			title: 'Hora Inválida',
			// 						// 			text: 'No puedes agendar una cita en una hora anterior a la actual.',
			// 						// 			confirmButtonText: 'Aceptar',
			// 						// 			backdrop: true,
			// 						// 			allowOutsideClick: false
			// 						// 		});
			// 						// 		return;
			// 						// 	}
			// 						// }else{
			// 						// 	if (fechaEvento < fechaHoy) {
			// 						// 		Swal.fire({
			// 						// 			icon: 'warning',
			// 						// 			title: 'Fecha Inválida',
			// 						// 			text: 'No puedes agendar una cita en una fecha anterior a hoy.',
			// 						// 			confirmButtonText: 'Aceptar',
			// 						// 			backdrop: true,
			// 						// 			allowOutsideClick: false
			// 						// 		});
			// 						// 	return;
			// 						// 	}
			// 						// }
			// 						// Mostrar el modal
			// 						$('#paciente_mostrar_e').text('');
			// 						$('#reservaModal').modal('show');
			// 					}
			// 				}
			// 			};

			// 			// Verifica si `fecha_bloque` no está vacía
			// 			if (fecha_bloque !== '') {
			// 				config.initialDate = fecha_bloque;  // Establece la fecha inicial
			// 				config.initialView = 'timeGridDay'; // Cambia la vista a timeGridDay si hay fecha_bloque
			// 			}

			// 			// Crear el calendario con la configuración final
			// 			let calendar = new FullCalendar.Calendar(calendarEl, config);

			// 			// Renderizar el calendario
			// 			calendar.render();

			// 		}else{
			// 			// console.log("No exiten agenda para este médico");
			// 			Swal.fire({
			// 				icon: 'warning',
			// 				title: '¡Advertencia!',
			// 				text: 'No existe agenda para este médico.',
			// 				confirmButtonText: 'Aceptar',
			// 				backdrop: true,
			// 				allowOutsideClick: false
			// 			});

			// 		}
					
			// 	}).catch(error => {
			// 		console.error("Error al obtener bloque médico:", error);
			// 	});

			// 	}else{
			// 		Swal.fire({
			// 			icon: 'warning',
			// 			title: '¡Advertencia!',
			// 			text: 'El campo médicos no debe estar vacio.',
			// 			confirmButtonText: 'Aceptar',
			// 			backdrop: true,
			// 			allowOutsideClick: false
			// 		});

			// 	}
				
				

			// });




			//******************************************************************************************************************* */
			//Agregado 10-12-2024 sincronizar reservas agendadas de rebsol
			$("#sincronizar_agenda_rs").click(function () {
				Swal.fire({
					title: 'Sincronizando agenda con rebsol...',
					allowEscapeKey: false,
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading(); // Muestra un ícono de carga mientras se realiza una operación
					}
				});
				
				$.ajax({
					url: '<?php echo constant("URL") ?>agenda/sincronizar_agenda_rs', // Ruta a tu controlador
					type: 'GET', // Método HTTP
					success: function (response) {
						// debugger;
						// Manejo de respuesta exitosa
						if (response.trim() === '"sincronizado exitoso"') {
							Swal.close();
							Swal.fire({
								title: "¡Sincronización exitosa!",
								text: "La agenda se ha sincronizado correctamente.",
								icon: "success"
							}).then(() => {
								// $('#buscar_bloque_medico').trigger('click'); // Refresca la agenda
								$('#reservaModal').modal('hide');           // Cierra la ventana modal
								$('#formAgendar')[0].reset();  
								             // Resetea el formulario
							});
						} else {
							Swal.close();
							Swal.fire({
								title: "Sincronización fallida",
								text: "No se pudo sincronizar la agenda. Por favor, intenta nuevamente.",
								icon: "error"
							});
							
						}
					},
					error: function (xhr, status, error) {
						// Manejo de errores del servidor
						Swal.close();
						console.error("Error al sincronizar la agenda:", error);
						Swal.fire({
							title: "Error en el servidor",
							text: "Ocurrió un problema al intentar sincronizar la agenda. Por favor, inténtalo más tarde.",
							icon: "error"
						});
						
					}
				});
			});
			//************************************************************************************************************************** */





			$("#buscar_bloque_medico").click(function () {
				// Obtener los valores seleccionados
				let medico_select = $('#medico').val();
				let medico_nombre = $('#medico').select2('data')[0].text;
				let fecha_bloque = $('#fecha_bloque').val();

				console.log(medico_select);
				console.log(medico_nombre);
				console.log(fecha_bloque);

				if (medico_nombre !== 'Seleccione Médico') {
					obtener_bloque_medico().then(data => {
						let bloque_medico = data; // Almacenar los datos en bloque_medico

						if (bloque_medico !== '') {
							// Configuración del calendario
							let calendarEl = document.getElementById('calendar');
							let config = {
								locale: 'es', // Configura el calendario a español
								initialView: 'timeGridWeek', // Vista predeterminada por semana
								slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
								slotDuration: '00:10:00',
								slotLabelInterval: "00:10:00",
								slotMinTime: '08:00:00',
								slotMaxTime: '19:20:00',
								eventTextColor: '#000',
								eventBorderColor: 'gray',
								allDaySlot: false, // Remueve la fila "Todo el día"
								headerToolbar: {
									left: 'prev,next today',
									center: 'title',
									right: 'timeGridWeek,timeGridDay'
								},
								height: 730.815, // Configura la altura del calendario (en píxeles)
								events: bloque_medico,
								eventClick: function(info) {
									let event = info.event;
									let eventId = event.id;

									//limpuar los formularios
									$('#formAgendar')[0].reset();
									$('#form_agendar_sobre_cupo')[0].reset();

									// const eventObj = info.event;
									// const detalles = eventObj.extendedProps.detalle;
									// const icono = eventObj.extendedProps.icono;

									// alert('Detalles: ' + detalles + '\n' + 'Icono: ' + icono); // Muestra detalles del evento

									// Mostrar detalles en consola
									console.log('Evento clicado:', event.title);
									console.log('Detalles del evento:', event);
									console.log('ID del evento:', eventId);
									// Dividir la cadena en un array usando un espacio como separador
									let partes_eventId = eventId.split(" ");

									// Acceder a cada parte
									let event_id_horario = partes_eventId[0]; // "247"
									let event_estado = partes_eventId[1]; // "ocupado"

									let tituloEvento = `Evento: ${event.title}`;
									let cadena = `Hora: ${event.start.toLocaleString()} - ${event.end.toLocaleString()}`;
									let partes = cadena.replace('Hora: ', '').split(' - ');
									let inicio = partes[0].split(', ');  // Divide fecha y hora en la parte de inicio
									let fechaInicio = rellenarConCerosFecha(inicio[0]);
									let horaInicio = rellenarConCerosHora(inicio[1]);
									let fin = partes[1].split(', ');      // Divide fecha y hora de fin
									let fechaFin = rellenarConCerosFecha(fin[0]);
									let horaFin = rellenarConCerosHora(fin[1]);

									let hora_consulta = horaInicio + " a " + horaFin;
									// $('#id_horario').val(eventId);
									$('#id_horario').val(event_id_horario);

									// TAB AGENDAR
									// $('#id_horario').val(eventId);
									$('#id_horario').val(event_id_horario);
									$('#rut_m').text(medico_select);
									$('#medico_agenda').text(medico_nombre);
									$('#fecha_consulta').text(fechaInicio);
									$('#hora_consulta').text(hora_consulta);
									$('#prevision_p').val('CDS');

								
									$('#cupo_rut_m').text(medico_select);
									$('#cupo_medico_agenda').text(medico_nombre);
									$('#cupo_fecha_consulta').text(fechaInicio);
									$('#cupo_hora_consulta').text(hora_consulta);
									$('#cupo_prevision_p').val('CDS');

									// TAB ELIMINAR
									let dia_e = obtenerDiaEnPalabras(fechaInicio);
									$('#dia_mostrar_e').text(dia_e);
									$('#medico_mostrar_e').text(medico_nombre);
									$('#fecha_consulta_e').text(fechaInicio);
									$('#hora_i_e').text(horaInicio);
									$('#hora_t_e').text(horaFin);
									let intervalo = calcularIntervalo(horaInicio, horaFin);
									$('#duracion_consulta_e').text(intervalo);
									
									
									
									// debugger;
									// if (tituloEvento === 'Evento: ocupado') {
									// if (tituloEvento === 'Evento: ocupado' || tituloEvento === 'Evento: sobrecupo') {
									if (event_estado === 'ocupado' || event_estado === 'sobrecupo') {
										$('#sobreCupo-tab').prop('disabled', false);
										// Cargar datos de la reserva
										cargar_reserva_agenda(eventId).then(data => {
											let reservas = JSON.parse(data);
											console.log(reservas);
											// $('#formAgendar')[0].reset();
											// $('#form_agendar_sobre_cupo')[0].reset();
											// $('#prevision_p').val('CDS');
											// $('#cupo_prevision_p').val('CDS');

											// Si se encuentran reservas, llenar los campos correspondientes
											if (Array.isArray(reservas) && reservas.length > 0) {
												// Primer paciente
												$('#id_reserva').val(reservas[0].id);
												$('#rut_p').val(reservas[0].rut);
												$('#nombre_p').val(reservas[0].nombre);
												$('#apellido_1p').val(reservas[0].apellido1);
												$('#apellido_2p').val(reservas[0].apellido2);
												$('#fecha_nac_p').val(reservas[0].fecha_nacimiento);
												$('#direccion_p').val(reservas[0].direccion);
												$('#email_p').val(reservas[0].email);
												$('#fono_1p').val(reservas[0].telefono);
												$('#fono_2p').val(reservas[0].telefono2);
												$('input[name="genero"][value="' + reservas[0].sexo + '"]').prop('checked', true);
												$('#centro_derivado_p').val(reservas[0].centro);
												$('#observacion').val(reservas[0].observacion);

												// Segundo paciente (si existe)
												if (reservas.length > 1) {
													$('#cupo_id_reserva').val(reservas[1].id);
													$('#cupo_rut_p').val(reservas[1].rut);
													$('#cupo_nombre_p').val(reservas[1].nombre);
													$('#cupo_apellido_1p').val(reservas[1].apellido1);
													$('#cupo_apellido_2p').val(reservas[1].apellido2);
													$('#cupo_fecha_nac_p').val(reservas[1].fecha_nacimiento);
													$('#cupo_direccion_p').val(reservas[1].direccion);
													$('#cupo_email_p').val(reservas[1].email);
													$('#cupo_fono_1p').val(reservas[1].telefono);
													$('#cupo_fono_2p').val(reservas[1].telefono2);
													$('input[name="cupo_genero"][value="' + reservas[1].sexo + '"]').prop('checked', true);
													$('#cupo_centro_derivado_p').val(reservas[1].centro);
													$('#cupo_observacion').val(reservas[1].observacion);
												}

												// Mostrar el modal
												$('#reservaModal').modal('show');
											} else {
												console.warn('No se encontraron reservas o la respuesta no es un arreglo válido:', data);
											}
										}).catch(error => {
											console.error("Error al obtener bloque médico:", error);
										});
									} else {
										// Si no está ocupado, mostrar el modal de agendar
										$('#sobreCupo-tab').prop('disabled', true);
										$('#paciente_mostrar_e').text('');
										$('#reservaModal').modal('show');
									}
								},
								//agregado para cargar icono en los bloques
								eventContent: function(info) {
									let icono = info.event.extendedProps.icono;
									let title = info.event.title;
									let content = document.createElement('div');
									// ${icono}
									content.innerHTML = `
										<div class="evento-contenido">
											${title}
										</div>
									`;
									return { html: content.outerHTML };
								}
							};

							// Verifica si fecha_bloque no está vacío
							if (fecha_bloque !== '') {
								config.initialDate = fecha_bloque;
								config.initialView = 'timeGridDay'; // Cambia la vista a timeGridDay si hay fecha_bloque
							}

							// Crear el calendario
							let calendar = new FullCalendar.Calendar(calendarEl, config);
							calendar.render();
						} else {
							// Si no hay bloque médico, mostrar advertencia
							Swal.fire({
								icon: 'warning',
								title: '¡Advertencia!',
								text: 'No existe agenda para este médico.',
								confirmButtonText: 'Aceptar',
								backdrop: true,
								allowOutsideClick: false
							});
						}
					}).catch(error => {
						console.error("Error al obtener bloque médico:", error);
					});
				} else {
					// Si no se seleccionó médico, mostrar advertencia
					Swal.fire({
						icon: 'warning',
						title: '¡Advertencia!',
						text: 'El campo médico no debe estar vacío.',
						confirmButtonText: 'Aceptar',
						backdrop: true,
						allowOutsideClick: false
					});
				}
			});





	
			$("#limpiar_filtros").click(function () {
				// Reinicia los filtros y la lista de médicos
				$('#medico').val('0').trigger('change'); //reaniciar al valor de carga del select2 medicos 
				$('#fecha_bloque').val('');
				instanciaFullcalendar();
				
			});



			$("#btnLimpiar").click(function () {
				$('#formAgendar')[0].reset();
				
			});
			
			$("#btn_limpiar_cupo").click(function () {
				$('#form_agendar_sobre_cupo')[0].reset();
				
			});


			$('#rut_p').on('blur', function() {
                let rut = $("#rut_p").val();
                if (typeof rut !== 'undefined' && rut !== "" && rut !== null){
                    rutValido = validarRut(rut);
                    if (!rutValido){
                        Swal.fire({
                                title: "El rut ingresado no es valido",
                                icon: 'warning'
                        }).then((result) => {
                            $("#rut_p").val("").focus(); // Resetea y enfoca el campo
                            ;

                        });
                    }
                }
            });



			$('#email_p').on('blur', function() {
                let email = $("#email_p").val();
                if (typeof email !== 'undefined' && email !== "" && email !== null){
                    emailValido = validarEmail(email);
                    if (!emailValido){
                        Swal.fire({
                                title: "El correo ingresado no es valido",
                                icon: 'warning'
                        }).then((result) => {
                            $("#email_p").val("").focus(); // Resetea y enfoca el campo
                            ;

                        });
                    }
                }
            });




			$("#btnAgendar").click(function () {
				//valor del input oculto, que es necesario para generar la reserva
				let id_reserva = $("#id_reserva").val();
				let value = $('#medico').val(); // value contiene el id_medico y el rut del medico
				// Dividir el value por el punto
				let partes = value.split('.');
				// obtener el primer caracter del value (id_medico)
				let id_medico = partes[0]; 
				// obtener elimina el primer caracter del value para obtener el rut medico
				let rut_medico =  partes[1]; 
				// console.log(value);
				// console.log(id_medico);
				// console.log(rut_medico);
				// exit();

				let id_horario = $('#id_horario').val();
				// console.log(id_horario);
				// exit();
				// Obtener valores de los campos de texto
				let rut_m = $('#rut_m').text(); 
				let medico_agenda = $('#medico_agenda').text(); 
				let agendado_por = $('#agendado_por').text(); 
				let lugar_consulta = $('#lugar_consulta').text(); 

				// Obtener valores de los campos de input
				let rut_p = $('#rut_p').val(); 
				let nombre_p = $('#nombre_p').val(); 
				let apellido_1p = $('#apellido_1p').val(); 
				let apellido_2p = $('#apellido_2p').val(); 
				let fecha_nac_p = $('#fecha_nac_p').val(); 
				let direccion_p = $('#direccion_p').val(); 
				let email_p = $('#email_p').val(); 
				let fono_1p = $('#fono_1p').val(); 
				let fono_2p = $('#fono_2p').val(); 

				// Obtener valor del radio button 
				// Obtiene el valor del radio button seleccionado
				let genero = $('input[name="genero"]:checked').val(); 

				let centro_derivado_p = $('#centro_derivado_p').val(); 
				let prevision_p = $('#prevision_p').val(); 
				let observacion = $('#observacion').val(); 
				let fecha_consulta = $('#fecha_consulta').text(); 
				let hora_consulta = $('#hora_consulta').text();
				// console.log(fecha_consulta);
				// console.log(hora_consulta);
				// exit(); 

				
				// console.log({
				// 	id_horario,
				// 	rut_m,
				// 	medico_agenda,
				// 	agendado_por,
				// 	lugar_consulta,
				// 	rut_p,
				// 	nombre_p,
				// 	apellido_1p,
				// 	apellido_2p,
				// 	fecha_nac_p,
				// 	direccion_p,
				// 	email_p,
				// 	fono_1p,
				// 	fono_2p,
				// 	genero,
				// 	centro_derivado_p,
				// 	prevision_p,
				// 	observacion
				// });

				// Array para almacenar campos vacíos
				let camposVacios = [];

				// Verificar si alguno de los campos está vacío
				if (!rut_p) camposVacios.push("RUT");
				if (!nombre_p) camposVacios.push("Nombre");
				if (!apellido_1p) camposVacios.push("Apellido 1");
				if (!apellido_2p) camposVacios.push("Apellido 2");
				if (!fecha_nac_p) camposVacios.push("Fecha de Nacimiento");
				if (!direccion_p) camposVacios.push("Dirección");
				if (!email_p) camposVacios.push("Email");
				if (!fono_1p) camposVacios.push("Teléfono 1");
				if (!fono_2p) camposVacios.push("Teléfono 2");
				if (!genero) camposVacios.push("Género");
				if (!centro_derivado_p) camposVacios.push("Centro Derivado");

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

				}else{
					// Almacenar datos en un arreglo data
					let data = {
						id_horario: id_horario,
						rut_m: id_medico,
						medico_agenda: medico_agenda,
						agendado_por: agendado_por,
						lugar_consulta: lugar_consulta,
						rut_p: rut_p,
						nombre_p: nombre_p,
						apellido_1p: apellido_1p,
						apellido_2p: apellido_2p,
						fecha_nac_p: fecha_nac_p,
						direccion_p: direccion_p,
						email_p: email_p,
						fono_1p: fono_1p,
						fono_2p: fono_2p,
						genero: genero,
						centro_derivado_p: centro_derivado_p,
						prevision_p: prevision_p,
						observacion: observacion,
						rut_medico: rut_medico,
						fecha_consulta: fecha_consulta,
						hora_consulta: hora_consulta,
						id_reserva: id_reserva

					};

					if(id_reserva !="" ){
						//Actualizar datos 
						data.id_reserva = id_reserva;
						$.ajax({
							url: '<?php echo constant('URL')?>agenda/actualizar_reserva', 
							type: 'POST',
							data: data,
							success: function(response) {
								//debugger;
								if (response == '"Reserva actualizada con exito"' ){
									Swal.fire({
										title: "Reserva actualizada con exito",
										text: `Médico tratante: ${medico_agenda} .`,
										icon: 'success'
									}).then((result) => {
										$('#buscar_bloque_medico').trigger('click'); // Disparar el evento click
										$('#reservaModal').modal('hide'); // Cerrar la modal
										$('#formAgendar')[0].reset();
									});

								}else{

									Swal.fire({
										title: "¡No se pudo actualizar la reserva!",
										text: "Por favor, verifica los datos e inténtalo nuevamente.",
										icon: 'error'
									}).then((result) => {
										
									});
									
									
								}
								// Aquí puedes manejar la respuesta
							},
							error: function(xhr, status, error) {
								console.error('Error al enviar datos:', error);
								// Aquí puedes manejar el error
							}
						});

					}else{
						//registra reserva 
						$.ajax({
							url: '<?php echo constant('URL')?>agenda/reservar_agenda', 
							type: 'POST',
							data: data,
							success: function(response) {
								//debugger;
								if (response == '"Reserva agendada con exito"' ){
									Swal.fire({
										title: "Reserva agendada con éxito",
										text: `Médico tratante: ${medico_agenda} .`,
										icon: 'success'
									}).then((result) => {
										$('#buscar_bloque_medico').trigger('click'); // Disparar el evento click
										$('#reservaModal').modal('hide'); // Cerrar la modal
										$('#formAgendar')[0].reset();
									});

								}else{

									Swal.fire({
										title: "¡No se pudo agendar la reserva!",
										text: "Por favor, verifica los datos e inténtalo nuevamente.",
										icon: 'error'
									}).then((result) => {
										// $('#reservaModal').modal('hide'); // Cerrar la modal
										// $('#formAgendar')[0].reset();
									});
									
									
								}
								// Aquí puedes manejar la respuesta
							},
							error: function(xhr, status, error) {
								console.error('Error al enviar datos:', error);
								// Aquí puedes manejar el error
							}
						});

					}

				


				}
				
				
			});



			$("#btn_agendar_sobre_cupo").click(function () {
				//valor del input oculto, que es necesario para generar la reserva
				let id_reserva = $("#cupo_id_reserva").val();
				let value = $('#medico').val(); // value contiene el id_medico y el rut del medico
				// Dividir el value por el punto
				let partes = value.split('.');
				// obtener el primer caracter del value (id_medico)
				let id_medico = partes[0]; 
				// obtener elimina el primer caracter del value para obtener el rut medico
				let rut_medico =  partes[1]; 
				// console.log(value);
				// console.log(id_medico);
				// console.log(rut_medico);
				// exit();

				let id_horario = $('#id_horario').val();
				// console.log(id_horario);
				// exit();
				// Obtener valores de los campos de texto
				let rut_m = $('#cupo_rut_m').text(); 
				let medico_agenda = $('#cupo_medico_agenda').text(); 
				let agendado_por = $('#cupo_agendado_por').text(); 
				let lugar_consulta = $('#cupo_lugar_consulta').text(); 

				let rut_p = $('#cupo_rut_p').val(); 
				let nombre_p = $('#cupo_nombre_p').val(); 
				let apellido_1p = $('#cupo_apellido_1p').val(); 
				let apellido_2p = $('#cupo_apellido_2p').val(); 
				let fecha_nac_p = $('#cupo_fecha_nac_p').val(); 
				let direccion_p = $('#cupo_direccion_p').val(); 
				let email_p = $('#cupo_email_p').val(); 
				let fono_1p = $('#cupo_fono_1p').val(); 
				let fono_2p = $('#cupo_fono_2p').val(); 

				// Obtener valor del radio button
				let genero = $('input[name="cupo_genero"]:checked').val(); 

				// Los siguientes elementos no están en el código HTML proporcionado, pero se dejaron igual 
				// suponiendo que están en otra parte del formulario
				let centro_derivado_p = $('#cupo_centro_derivado_p').val(); 
				let prevision_p = $('.prevision_p').val(); 
				let observacion = $('#cupo_observacion').val(); 
				let fecha_consulta = $('#cupo_fecha_consulta').text(); 
				let hora_consulta = $('#cupo_hora_consulta').text(); 
				// console.log(fecha_consulta);
				// console.log(hora_consulta);
				// exit(); 

				
				// console.log({
				// 	id_horario,
				// 	rut_m,
				// 	medico_agenda,
				// 	agendado_por,
				// 	lugar_consulta,
				// 	rut_p,
				// 	nombre_p,
				// 	apellido_1p,
				// 	apellido_2p,
				// 	fecha_nac_p,
				// 	direccion_p,
				// 	email_p,
				// 	fono_1p,
				// 	fono_2p,
				// 	genero,
				// 	centro_derivado_p,
				// 	prevision_p,
				// 	observacion
				// });
				// debugger;

				// Array para almacenar campos vacíos
				let camposVacios = [];

				// Verificar si alguno de los campos está vacío
				if (!rut_p) camposVacios.push("RUT");
				if (!nombre_p) camposVacios.push("Nombre");
				if (!apellido_1p) camposVacios.push("Apellido 1");
				if (!apellido_2p) camposVacios.push("Apellido 2");
				if (!fecha_nac_p) camposVacios.push("Fecha de Nacimiento");
				if (!direccion_p) camposVacios.push("Dirección");
				if (!email_p) camposVacios.push("Email");
				if (!fono_1p) camposVacios.push("Teléfono 1");
				if (!fono_2p) camposVacios.push("Teléfono 2");
				if (!genero) camposVacios.push("Género");
				if (!centro_derivado_p) camposVacios.push("Centro Derivado");

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

				}else{
					// Almacenar datos en un arreglo data
					let data = {
						id_horario: id_horario,
						rut_m: id_medico,
						medico_agenda: medico_agenda,
						agendado_por: agendado_por,
						lugar_consulta: lugar_consulta,
						rut_p: rut_p,
						nombre_p: nombre_p,
						apellido_1p: apellido_1p,
						apellido_2p: apellido_2p,
						fecha_nac_p: fecha_nac_p,
						direccion_p: direccion_p,
						email_p: email_p,
						fono_1p: fono_1p,
						fono_2p: fono_2p,
						genero: genero,
						centro_derivado_p: centro_derivado_p,
						prevision_p: prevision_p,
						observacion: observacion,
						rut_medico: rut_medico,
						fecha_consulta: fecha_consulta,
						hora_consulta: hora_consulta

					};

					if(id_reserva !=""){
						//Actualizar datos 
						data.id_reserva = id_reserva;
						$.ajax({
							url: '<?php echo constant('URL')?>agenda/actualizar_reserva', 
							type: 'POST',
							data: data,
							success: function(response) {
								//debugger;
								if (response == '"Reserva actualizada con exito"' ){
									Swal.fire({
										title: "Reserva actualizada con exito",
										text: `Médico tratante: ${medico_agenda} .`,
										icon: 'success'
									}).then((result) => {
										$('#buscar_bloque_medico').trigger('click'); // Disparar el evento click
										$('#reservaModal').modal('hide'); // Cerrar la modal
										$('#form_agendar_sobre_cupo')[0].reset();
									});

								}else{

									Swal.fire({
										title: "¡No se pudo actualizar la reserva!",
										text: "Por favor, verifica los datos e inténtalo nuevamente.",
										icon: 'error'
									}).then((result) => {
										
									});
									
									
								}
								// Aquí puedes manejar la respuesta
							},
							error: function(xhr, status, error) {
								console.error('Error al enviar datos:', error);
								// Aquí puedes manejar el error
							}
						});

					}else{
						//registra reserva 
						$.ajax({
							url: '<?php echo constant('URL')?>agenda/reservar_agenda', 
							type: 'POST',
							data: data,
							success: function(response) {
								//debugger;
								if (response == '"Reserva agendada con exito"' ){
									Swal.fire({
										title: "Reserva agendada con éxito",
										text: `Médico tratante: ${medico_agenda} .`,
										icon: 'success'
									}).then((result) => {
										$('#buscar_bloque_medico').trigger('click'); // Disparar el evento click
										$('#reservaModal').modal('hide'); // Cerrar la modal
										$('#form_agendar_sobre_cupo')[0].reset();
									});

								}else{

									Swal.fire({
										title: "¡No se pudo agendar la reserva!",
										text: "Por favor, verifica los datos e inténtalo nuevamente.",
										icon: 'error'
									}).then((result) => {
										// $('#reservaModal').modal('hide'); // Cerrar la modal
										// $('#formAgendar')[0].reset();
									});
									
									
								}
								// Aquí puedes manejar la respuesta
							},
							error: function(xhr, status, error) {
								console.error('Error al enviar datos:', error);
								// Aquí puedes manejar el error
							}
						});

					}

				


				}
				
				
			});



			$("#btn_eliminar_hora").click(function () {

				// Corregido el selector jQuery
				let motivo_anula = $('#observacion').val(); 
				if (!motivo_anula) {
					Swal.fire({
                        title: '¡Por favor, ingresa un motivo!',
                        text: "Debe ingresar un motivo para anular la reserva.",
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                   
				}else{
					// Obtener el id de la reserva
					let id_horario = $('#id_horario').val();
					let id_reserva = $('#id_reserva').val();
					let usuario_anula = $('#agendado_por').text();
					let fecha_consulta = $('#fecha_consulta').text(); 
					let hora_consulta = $('#hora_consulta').text();
					let lugar_consulta = $('#lugar_consulta').text();
					// console.log(fecha_consulta);
					// console.log(hora_consulta);
					// debugger;

					// Dividir la cadena en base al delimitador " a "
					let partes = hora_consulta.split(" a ");

					// Asignar valores a las variables
					let hora_inicio = partes[0];
					let hora_fin = partes[1];
				
					// let fecha_consulta = $('#fecha_consulta_e').text();
					// // console.log(fecha_consulta);
					// let hora_inicio = $('#hora_i_e').text();
					// let hora_fin = $('#hora_t_e').text();
					// let lugar_consulta = $('#lugar_consulta_mostrar_e').text();
					

					// Mensaje de confirmación
					Swal.fire({
						title: '¿Estás seguro de eliminar la reserva?',
						text: "Esta acción no se puede deshacer.",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Sí, eliminar'
					}).then((result) => {
						if (result.isConfirmed) {
							$.ajax({
								url: '<?php echo constant('URL')?>agenda/anular_reserva', 
								type: 'POST', // Tipo de solicitud, en este caso POST
								data: { id_horario: id_horario,
										id_reserva: id_reserva, 
										usuario_anula: usuario_anula,
										fecha_consulta: fecha_consulta, 
                                        hora_inicio: hora_inicio, 
                                        hora_fin: hora_fin,
										lugar_consulta: lugar_consulta,
                                        motivo_anula: motivo_anula
								}, 
								success: function(response) {
									// debugger;
									if (response ==="true") {
										// Mostrar mensaje de éxito
										Swal.fire({
											title: 'Cita anulada correctamente!',
											text: `Bloque: ${fecha_consulta} - ${hora_inicio} a ${hora_fin}.`,
											icon: 'success'
										}).then((result) => {
											if (result.isConfirmed) {
												$('#buscar_bloque_medico').trigger('click'); // Disparar el evento click
												$('#reservaModal').modal('hide'); // Cerrar la modal
												$('#formAgendar')[0].reset(); // Reiniciar el formulario
											}
										});

										

									} else {
										// Si hubo algún error
										Swal.fire(
											'Error',
											'Hubo un problema al anular la reserva. Inténtalo de nuevo.',
											'error'
										);
									}
								},
								error: function(xhr, status, error) {
									// Manejar errores en la solicitud AJAX
									console.error('Error en la solicitud:', error);
									Swal.fire(
										'Error',
										'Hubo un problema en el servidor. Inténtalo más tarde.',
										'error'
									);
								}
							});
						}
					});
				}
				
				
			});



			$("#btn_eliminar_hora_cupo").click(function () {

				// Corregido el selector jQuery
				let motivo_anula = $('#cupo_observacion').val(); 
				if (!motivo_anula) {
					Swal.fire({
						title: '¡Por favor, ingresa un motivo!',
						text: "Debe ingresar un motivo para anular la reserva.",
						icon: 'warning',
						confirmButtonText: 'Aceptar'
					});
				
				}else{
					// Obtener el id de la reserva
					let id_horario = $('#id_horario').val();
					let id_reserva = $('#cupo_id_reserva').val();
					let usuario_anula = $('#cupo_agendado_por').text();
					let fecha_consulta = $('#cupo_fecha_consulta').text(); 
					let hora_consulta = $('#cupo_hora_consulta').text();
					let lugar_consulta = $('#cupo_lugar_consulta').text();
					// console.log(fecha_consulta);
					// console.log(hora_consulta);
					// debugger;

					// Dividir la cadena en base al delimitador " a "
					let partes = hora_consulta.split(" a ");

					// Asignar valores a las variables
					let hora_inicio = partes[0];
					let hora_fin = partes[1];

					// let fecha_consulta = $('#cupo_fecha_consulta').text(); 
					// let hora_consulta = $('#cupo_hora_consulta').text(); 
					// debugger;


					// let fecha_consulta = $('#fecha_consulta_e').text();
					// // console.log(fecha_consulta);
					// let hora_inicio = $('#hora_i_e').text();
					// let hora_fin = $('#hora_t_e').text();
					// let lugar_consulta = $('#lugar_consulta_mostrar_e').text();
					

					// Mensaje de confirmación
					Swal.fire({
						title: '¿Estás seguro de eliminar la reserva?',
						text: "Esta acción no se puede deshacer.",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Sí, eliminar'
					}).then((result) => {
						if (result.isConfirmed) {
							$.ajax({
								url: '<?php echo constant('URL')?>agenda/anular_reserva', 
								type: 'POST', // Tipo de solicitud, en este caso POST
								data: { id_horario: id_horario,
										id_reserva: id_reserva, 
										usuario_anula: usuario_anula,
										fecha_consulta: fecha_consulta, 
										hora_inicio: hora_inicio, 
										hora_fin: hora_fin,
										lugar_consulta: lugar_consulta,
										motivo_anula: motivo_anula
								}, 
								success: function(response) {
									// debugger;
									if (response ==="true") {
										// Mostrar mensaje de éxito
										Swal.fire({
											title: 'Cita anulada correctamente!',
											text: `Bloque: ${fecha_consulta} - ${hora_inicio} a ${hora_fin}.`,
											icon: 'success'
										}).then((result) => {
											if (result.isConfirmed) {
												$('#buscar_bloque_medico').trigger('click'); // Disparar el evento click
												$('#reservaModal').modal('hide'); // Cerrar la modal
												$('#formAgendar')[0].reset(); // Reiniciar el formulario
											}
										});

										

									} else {
										// Si hubo algún error
										Swal.fire(
											'Error',
											'Hubo un problema al anular la reserva. Inténtalo de nuevo.',
											'error'
										);
									}
								},
								error: function(xhr, status, error) {
									// Manejar errores en la solicitud AJAX
									console.error('Error en la solicitud:', error);
									Swal.fire(
										'Error',
										'Hubo un problema en el servidor. Inténtalo más tarde.',
										'error'
									);
								}
							});
						}
					});
				}


			});
			



			
        });



		


		function instanciaFullcalendar(){
			//dayGridMonth ->condiguracion calendario para mostrar el mes
			let calendarEl = document.getElementById('calendar');
			let calendar = new FullCalendar.Calendar(calendarEl, {
				locale: 'es',  // Configura el calendario a español
				initialView: 'timeGridWeek', // Muestra la vista por semana
				slotLabelFormat:{hour: '2-digit', minute: '2-digit', hour12: false},
				slotDuration: '00:10:00',
				slotLabelInterval:"00:10:00",
				slotMinTime: '08:00:00',
				slotMaxTime: '19:10:00',
				eventTextColor: '#000',
				eventBorderColor: 'gray',
				allDaySlot: false, // Remueve la fila "Todo el día"
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'timeGridWeek,timeGridDay'
				},
				height: 730.815, // Configura la altura del calendario (en píxeles)
				editable: true,
				selectable: true,
				nowIndicator: true
			});

			calendar.render();

		}

// 		function instanciaFullcalendar() {
//     // Datos de los eventos con icono de reloj
//     const events = [
//         {
//             "id": "1",
//             "title": "Consulta Médica",
//             "start": "2024-11-27T09:00:00",
//             "end": "2024-11-27T09:30:00",
//             "backgroundColor": "#0074c36e",
//             "className": "evento-personalizado",
//             "extendedProps": {
//                 "detalle": "Consulta general con el Dr. López",
//                 "icono": "<i class='fa fa-clock'></i>" // Icono de reloj
//             }
//         },
//         {
//             "id": "2",
//             "title": "Revisión Pediátrica",
//             "start": "2024-11-27T10:00:00",
//             "end": "2024-11-27T10:30:00",
//             "backgroundColor": "#0074c36e",
//             "className": "evento-personalizado",
//             "extendedProps": {
//                 "detalle": "Revisión pediátrica para Juan Pérez",
//                 "icono": "<i class='fa fa-clock'></i>" // Icono de reloj
//             }
//         }
//     ];

//     // Seleccionar el contenedor para el calendario
//     let calendarEl = document.getElementById('calendar');

//     // Inicializar FullCalendar
//     let calendar = new FullCalendar.Calendar(calendarEl, {
//         locale: 'es',  // Configura el calendario a español
//         initialView: 'timeGridWeek', // Muestra la vista por semana
//         slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
//         slotDuration: '00:10:00',
//         slotLabelInterval: "00:10:00",
//         slotMinTime: '08:00:00',
//         slotMaxTime: '19:10:00',
//         eventTextColor: '#000',
//         eventBorderColor: 'gray',
//         allDaySlot: false, // Remueve la fila "Todo el día"
//         headerToolbar: {
//             left: 'prev,next today',
//             center: 'title',
//             right: 'timeGridWeek,timeGridDay'
//         },
//         editable: true,
//         selectable: true,
//         nowIndicator: true,
//         events: events, // Cargar los eventos aquí

//         // Manejar el clic en los eventos
//         eventClick: function(info) {
//             const eventObj = info.event;
//             const detalles = eventObj.extendedProps.detalle;
//             const icono = eventObj.extendedProps.icono;

//             alert('Detalles: ' + detalles + '\n' + 'Icono: ' + icono); // Muestra detalles del evento
//         },

//         // Personalizar la apariencia del evento
//         eventContent: function(info) {
//             let icono = info.event.extendedProps.icono; // Obtener el icono
//             let title = info.event.title; // Obtener el título del evento

//             // Crear el HTML personalizado para el evento
//             let content = document.createElement('div');
//             content.innerHTML = `
//                 <div class="evento-contenido">
//                     ${icono} ${title}
//                 </div>
//             `;
//             return { html: content.outerHTML }; // Devuelve el HTML del evento
//         }
//     });

//     // Renderizar el calendario
//     calendar.render();
// }


		function rellenarConCerosFecha(fecha) {
			// debugger;
			let partesFecha = fecha.split('/');  // Suponiendo que la fecha está en formato "DD/MM/AAAA"


			let dia = partesFecha[0].padStart(2, '0');   // Rellenar el día con ceros si tiene un solo dígito
			let mes = partesFecha[1].padStart(2, '0');   // Rellenar el mes con ceros si tiene un solo dígito
			let año = partesFecha[2].padStart(4, '0');   // Rellenar el año con ceros si tiene menos de 4 dígitos

			return `${dia}/${mes}/${año}`;
		}


		function rellenarConCerosHora(hora) {
			let partesHora = hora.split(':');  // Suponiendo que la hora está en formato "HH:MM:SS"

			let horas = partesHora[0].padStart(2, '0');   // Rellenar las horas con ceros si tienen un solo dígito
			let minutos = partesHora[1].padStart(2, '0'); // Rellenar los minutos con ceros si tienen un solo dígito
			let segundos = partesHora[2] ? partesHora[2].padStart(2, '0') : '00'; // Rellenar segundos con ceros si no existen

			// return `${horas}:${minutos}:${segundos}`;
			return `${horas}:${minutos}`;
		}


		function obtenerDiaEnPalabras(fecha) {
			// Dividir la fecha en día, mes y año
			let partesFecha = fecha.split('/');
			let dia = parseInt(partesFecha[0], 10);
			let mes = parseInt(partesFecha[1], 10) - 1; // Los meses en JavaScript son indexados desde 0
			let anio = parseInt(partesFecha[2], 10);
			
			// Crear un objeto de tipo Date
			let fechaObjeto = new Date(anio, mes, dia);
			
			// Obtener el día de la semana en español
			let opciones = { weekday: 'long' };
			let diaSemana = fechaObjeto.toLocaleDateString('es-ES', opciones);
			
			return diaSemana.charAt(0).toUpperCase() + diaSemana.slice(1); // Capitalizar la primera letra
		}


		function calcularIntervalo(horaInicio, horaFin) {
			// Convertir las horas a objetos Date usando un formato temporal con el mismo día
			let fecha = "01/01/1970";  // Fecha arbitraria para trabajar solo con la hora
			let inicio = new Date(`${fecha} ${horaInicio}`);
			let fin = new Date(`${fecha} ${horaFin}`);

			// Calcular la diferencia en milisegundos
			let diferenciaMs = fin - inicio;

			// Convertir la diferencia a minutos
			let diferenciaMin = Math.floor(diferenciaMs / (1000 * 60));

			return diferenciaMin;
		}


		function formatRut() {
            let $input = $('#rut_p'); // Selecciona el campo de entrada del RUT
            let value = $input.val().replace(/[^0-9kK]/g, ''); // Elimina todo lo que no sea dígito o k/K

            // Asegúrate de que hay al menos un dígito antes de formatear
            if (value.length > 1) {
                value = value.slice(0, -1) + '-' + value.slice(-1); // Agrega el guion antes del dígito verificador
            }

            // Actualiza el valor del campo de entrada con el formato correcto
            $input.val(value.toUpperCase()); // Convierte a mayúsculas el dígito verificador
        }



		function validarRut(rut) {
            // Eliminar puntos y convertir a minúsculas la letra k si existe
            rut = rut.replace(/[.-]/g, '').toLowerCase();
            
            // Verificar que el formato sea válido (8 o 9 dígitos seguidos de un guion y un dígito verificador)
            if (!/^\d{7,8}[0-9kK]{1}$/.test(rut)) {
                return false;
            }

            // Separar el cuerpo del dígito verificador
            const cuerpo = rut.slice(0, -1);
            const digitoVerificador = rut.slice(-1);

            // Calcular el dígito verificador esperado
            let suma = 0;
            let multiplicador = 2;

            for (let i = cuerpo.length - 1; i >= 0; i--) {
                suma += parseInt(cuerpo[i]) * multiplicador;
                multiplicador = multiplicador < 7 ? multiplicador + 1 : 2;
            }

            const mod11 = 11 - (suma % 11);
            let digitoEsperado;

            if (mod11 === 11) {
                digitoEsperado = '0';
            } else if (mod11 === 10) {
                digitoEsperado = 'k';
            } else {
                digitoEsperado = mod11.toString();
            }

            // Comparar el dígito verificador ingresado con el calculado
            return digitoVerificador === digitoEsperado;

        }


		function validarEmail(email) {
			// Expresión regular para validar el formato del email
			const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			return regex.test(email);
		}


		function buscarMedicos() {
			$.ajax({
				type: 'GET',
				url: '<?php echo constant('URL')?>agenda/obtenerMedicos',
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


		
		function obtener_bloque_medico() {
			return new Promise((resolve, reject) => {
				let value = $('#medico').val(); // value contiene el id_medico y el rut del medico
				// Dividir el value por el punto
				let partes = value.split('.');
				// obtener el primer caracter del value (id_medico)
				let id_medico = partes[0]; 
				// obtener elimina el primer caracter del value para obtener el rut medico
				let rut_medico =  partes[1]; 

				let medico_select = $('#medico').val();
				let fecha_bloque = $('#fecha_bloque').val();
				$.ajax({
					type: 'POST',  // Cambia el tipo de petición a POST
					url: '<?php echo constant('URL')?>agenda/obtener_bloque_medico',
					dataType: 'json',
					data: { 
						medico_select: id_medico,
						fecha_bloque: fecha_bloque
					},
					success: function(response) {
						console.log(response);
						resolve(response); // Resuelve la promesa con los datos de respuesta
					},
					error: function(xhr, status, error) {
						console.log(error);
						reject(error); // Rechaza la promesa en caso de error
					}
				});
			});
		}


		function cargar_reserva_agenda(eventId) {
			let id_horario = eventId;

			return new Promise((resolve, reject) => {
				$.ajax({
					url: '<?php echo constant('URL')?>agenda/cargar_reserva_agenda', 
					type: 'POST',
					data: { id_horario: id_horario },
					success: function(response) {
						resolve(response); // Resolviendo la promesa con la respuesta
					},
					error: function(xhr, status, error) {
						console.error('Error al enviar datos:', error);
						reject(new Error('Error al cargar la reserva de la agenda.')); // Rechazando la promesa con un mensaje de error
					}
				});
			});
		}



				
    </script>
	
</body>
</html>




