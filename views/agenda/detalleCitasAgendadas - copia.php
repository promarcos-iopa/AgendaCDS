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
					<label for="txtbuscar">Buscador de pacientes</label>
					<div class="form-group col-md-3 d-flex align-items-end mt-3">
						<!-- Campo para buscar por RUT -->
						<input type="text" class="form-control me-2" name="txtbuscar" id="txtbuscar" placeholder="Buscar por RUT">
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
				<br>
				<table class="table table-responsive table-striped">
					<!-- style="width: 1462px; -->
					<thead>
						<tr>
							<th style="display:none;">ID</th>
							<th>rut</th>
							<th>Paciente</th>
							<th>Fecha Agenda</th>
							<th>Hora Agenda</th>
							<!-- <th>Telefono</th>
							<th>Email</th> -->
							<!-- <th>Sucursal</th> -->
							<th>Centro</th>
							<th style="text-align: center;">Documentos</th>
							<!-- <th>Rut Médico</th> -->
							<!-- <th>Médico Tratande</th>
							<th>Usuario Agenda</th> -->
							<th style="display:none;"></th>
						</tr>
					</thead>
					<tbody>
						<?php
							include_once 'models/medicos.php';
							foreach($this->citas as $row){
								
						?>
						<tr>
							<td style="display:none;"><?php echo $row["id"]; ?></td>
							<td><?php echo $row["rut"]; ?></td>
							<td><?php echo $row["nombre"] . ' ' . $row["apellido1"] . ' ' . $row["apellido2"]; ?></td>
							<td><?php echo $row["fecha"]; ?></td>
							<td><?php echo $row["hora_inicio"].' a '.$row["hora_fin"]; ?></td>
							<!-- <td><?php //echo 'Fono1: '.$row["telefono"].' ' .'Fono2: '.$row["telefono2"]; ?></td>
							<td><?php //echo $row["email"]; ?></td> -->
							<!-- <td><?php //echo $row["sucursal"]; ?></td> -->
							<td><?php echo $row["centro"]; ?></td>
							<!-- <td><?php //echo $row["rut_medico"]; ?></td> -->
							<!-- <td><?php //echo $row["nombre_medico"]; ?></td>
							<td><?php //echo $row["usuario_agenda"]; ?></td> -->
							<td>
								<a href="" >Recetas</a>
								<a href="">Exámenes</a>
								<a href="">Indicaciones</a>
								<a href="http://localhost/iopaGo/public/PDF/GES/2024-11-08/FORMULARIO_GES_25928724-3.pdf">Ges</a>
							</td>
                            <td style="display:none;"><?php echo $row["id_horario"]; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
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
	<?php require 'views/footer.php'?>
</body>
</html>