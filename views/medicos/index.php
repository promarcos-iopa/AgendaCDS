<!DOCTYPE html>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Perfil Médicos</title>
	<link rel="stylesheet" href="">

	<style>
		label {
            color: #adadad !important;
            font-weight: bold !important;
        }
		.card-footer {
			padding: .5rem 1rem;
			background-color: rgb(255 255 255) !important;
			border-top: 1px solid rgba(0, 0, 0, .125);
		}
		
		
	</style>
</head>
<body>
	<?php require 'views/header.php'?>
	<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
		<div class="container" >
		<!-- <h2 class="center">Detalle Agenda Pacientes</h2> -->
			<div class="card" >
				<div class="card-body">
                    <!-- <form class="border rounded bg-light p-3"> -->
                        <div class="position-relative mb-4">
                            <h3>
                                <div class="alert alert-primary text-center">Perfil Médicos</div>
                            </h3>
                            <div id="divInfo" class="alert alert-warning alert-dismissible fade show position-absolute top-0 end-0" style="display: none;">
                                <span id="msg"></span>
                                <button type="button" id="cierre" class="btn-close" aria-label="Close"></button>
                            </div>
                        </div>

						<div class="card-header">
							<a href="<?php echo constant('URL')?>medicos/nuevoMedicos" class="btn btn-success btn-sm" style="width: 150px;">+ Nuevo</a>
						</div>
						<div class="card-body">
							<form class="row" id="form-buscar" action="<?php echo constant('URL'); ?>medicos/verPaginacionsearch/1" method="POST">
								<label for="txtbuscar">Buscar por rut</label>
								<div class="form-group col-md-3 d-flex align-items-end">
									<input type="text" class="form-control form-control-sm me-2" name="txtbuscar" id="txtbuscar">
									<button id="btnbuscar" type="submit" class="btn btn-secondary btn-sm" style="width: 150px;">Buscar</button>
								</div>
							</form>
							<br>
							<table class="table table-responsive table-striped">
								<thead>
									<tr>
										<th style="display:none;">ID</th>
										<th>Rut</th>
										<th>Médico</th>
										<th>Fecha nacimiento</th>
										<th>Dirección</th>
										<th>Especialidad</th>
										<th>Email</th>
										<th style="display:none;">Telefono</th>
										<th>Estado</th>
										<!-- <th>Acciones</th> -->
									</tr>
								</thead>
								<tbody>
									<?php
										include_once 'models/medicos.php';
										foreach($this->medicos as $row){
											$medicos = new Medicos();
											$medicos = $row;
									?>
									<tr>
										<td style="display:none;"><?php echo $medicos->id; ?></td>
										<td><?php echo $medicos->rut; ?></td>
										<td><?php echo $medicos->nombre . ' ' . $medicos->apellido1 . ' ' . $medicos->apellido2; ?></td>
										<td><?php echo $medicos->fecha_nacimiento; ?></td>
										<td><?php echo $medicos->direccion; ?></td>
										<td><?php echo $medicos->especialidad; ?></td>
										<td><?php echo $medicos->email; ?></td>
										<td style="display:none;"><?php echo $medicos->telefono; ?></td>
										<td><?php echo $medicos->estado; ?></td>
										<!-- <td>
											
											<a class="btn btn-warning btn-sm" style="padding-right: 5px;padding-left: 5px; color: #ffffff;padding-top: 2px;padding-bottom: 2px;" href="<?php echo constant('URL').'medicos/verMedicos/'.$medicos->id; ?>">
												<i class="fas fa-edit"></i> 
											</a>

											<a class="btn btn-danger btn-sm" style="padding-right: 6px;padding-left: 6px;padding-top: 2px;padding-bottom: 2px;" href="<?php echo constant('URL').'medicos/eliminarMedicos/'.$medicos->id; ?>">
												<i class="fas fa-trash-alt"></i> 
											</a>
										</td> -->
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
						<!-- paginacion tabla -->
						<div class="card-footer">
							<nav aria-label="Page navigation example">
								<ul class="pagination">
									<li class="page-item <?php echo $this->paginaactual <= 1 ? 'disabled' : ''; ?>">
										<a class="page-link" href="<?php echo constant('URL'); ?>medicos/verPaginacion/<?php echo $this->paginaactual - 1; ?>">Anterior</a>
									</li>
									<?php for ($i = 0; $i < $this->paginas; $i++): ?>
										<?php if ($i <= 10): ?>
											<li class="page-item <?php echo $this->paginaactual == $i + 1 ? 'active' : ''; ?>">
												<a class="page-link" href="<?php echo constant('URL'); ?>medicos/verPaginacion/<?php echo $i + 1; ?>">
													<?php echo $i + 1; ?>
												</a>
											</li>
										<?php endif; ?>
									<?php endfor; ?>
									<li class="page-item <?php echo $this->paginaactual >= $this->paginas ? 'disabled' : ''; ?>">
										<a class="page-link" href="<?php echo constant('URL'); ?>medicos/verPaginacion/<?php echo $this->paginaactual + 1; ?>">Siguiente</a>
									</li>
								</ul>
							</nav>
						</div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>





	
	<?php require 'views/footer.php'?>
</body>
</html>
