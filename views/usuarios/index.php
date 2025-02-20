<!DOCTYPE html>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Usuarios</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<?php require 'views/header.php'?>
	<div class="container">
		<h3 class="center">Usuarios</h3>
		<a href="<?php echo constant('URL')?>usuarios/nuevoUsuarios" class="btn btn-primary">+ Nuevo</a><br><br>
	<form id="form-buscar" action="<?php echo constant('URL'); ?>usuarios/verPaginacionsearch/1" method="POST" >
		Buscar<input type="text" name="txtbuscar" id="txtbuscar"><button id="btnbuscar" type="Submit">Buscar</button>
        </form>
         <table class="table table-responsive table-striped">
         	<thead>
         		<tr>
                 <th>id</th>
                 <th>email</th>
                 <th>pass</th>
                 <th>foto</th>
                 <th></th>
                 <th></th>
         		</tr>
         	</thead>
         	<tbody>
         		<?php
         		   include_once 'models/usuarios.php';
                   foreach($this->usuarios as $row){
                   	  $usuarios=new Usuarios();
                   	  $usuarios=$row;
         		?>
         		<tr>
         			<td><?php echo $usuarios->id;?></td>
         			<td><?php echo $usuarios->email;?></td>
         			<td><?php echo $usuarios->pass;?></td>
         			<td><img src='<?php echo constant('URL')?>public/uploads/<?php echo $usuarios->foto;?>' width='50px' height='50px'></td>
         			<td><a class="btn btn-outline-secondary" href="<?php echo constant('URL').'usuarios/verUsuarios/'.$usuarios->id; ?>">Editar</a></td>
         			<td><a class="btn btn-danger" href="<?php echo constant('URL').'usuarios/eliminarUsuarios/'.$usuarios->id; ?>" >Eliminar</a></td>
         		</tr>
         			<?php
                     }
             	?>
         	</tbody>
         </table>
 <nav aria-label="Page navigation example">
       <ul class="pagination">
       <li class="page-item
       <?php  echo $this->paginaactual<=1 ? 'disabled' : '' ?>
       "><a class="page-link" href="<?php echo constant('URL'); ?>usuarios/verPaginacion/<?php echo $this->paginaactual-1 ?>">Anterior</a></li>
       <?php for($i=0;$i<$this->paginas;$i++):?>
       <?php if ($i<=10){ ?>
       <li class="page-item <?php  echo $this->paginaactual>=$this->paginas==$i+1 ? 'active' :'' ?>">
            <a class="page-link" href="<?php echo constant('URL'); ?>usuarios/verPaginacion/<?php echo $i+1 ?>">
           <?php echo $i+1 ?>
        </a></li>
         <?php } ?>
         <?php endfor ?>
       <li class="page-item
       <?php  echo $this->paginaactual>=$this->paginas ? 'disabled' : '' ?>
       "><a class="page-link" href="<?php echo constant('URL'); ?>usuarios/verPaginacion/<?php echo $this->paginaactual+1 ?>">Siguiente</a></li>
       </ul>
     </nav>
	</div>
	<?php require 'views/footer.php'?>
</body>
</html>
