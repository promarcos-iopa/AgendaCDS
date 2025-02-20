<?php
session_start();
// ini_set('display_errors', true);
//include_once 'models/pacienteComision.php';
class Ges extends Controller{
	function __construct()
	{
		parent::__construct();
			$this->view->comision=[];
                if (!isset($_SESSION['usuario'])){
                echo "Acceso Negado";
                  session_destroy();    
                $location=constant('URL');
                header("Location: " . $location);
                exit;
                }else{
            }
        $this->ges = $this->database();
	}

    public function database()
	{
        //Conexion con variables de entorno desde el archivo config
        //Agregado por marcos 20-02-2025
        //Asi apunte correctamente a desarrollo o profuccion.
        $host = constant('HOST_iopaweb');
		$db =constant('DB_iopaweb');
		$user =constant('USER_iopaweb'); 
		$password =constant('PASSWORD_iopaweb');

		try
		{
			$connection = "mysql:host=" . $host . ";dbname=" . $db;
			$options = [
				PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES   => false,
			];
		$pdo = new PDO($connection, $user, $password/*, $options*/);
			return $pdo;
		}
		catch(PDOException $e)
		{
			DeBug("Error al establecer conecion con la DB: ".$e->getMessage(),"Error");
		}
	}

    function verPaginacion_Detalle_Pacientes($param=null){

       
        if (!empty($_POST)) {
            // Acceder a los datos
           
            if (!empty($_POST['rut'])) {
                $rut = $_POST['rut'];
            }else{
                $rut = null;

            }
            
            if (!empty($_POST['fecha_desde'])) {
                $fecha = $_POST['fecha_desde'];
            }else{
                 $fecha = null;
                //$fecha = date('Y-m-d');
            

            }

            if (!empty($_POST['fecha_hasta'])) {
                $fecha_hasta = $_POST['fecha_hasta'];
            }else{
                $fecha_hasta = null;
                //$fecha_hasta = date('Y-m-d');

            }
         
           
           $id = 1;
           
       } else if($param==NULL) {
           
            $rut = null;
        //    $fecha = null;
        //    $fecha_hasta = null;
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $id = 1;
       }
       else
       {
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
           $id = $param[0];
           $cantidad_elementos = count($param);
        //    $fecha = null;
        //    $fecha_hasta = null;
           if ($cantidad_elementos > 1){
              $rut = $param[1];
           }else{
              $rut = null;
           }
           
       }
      

        $autorizacionporpagina=7;
        // $totalautorizaciones = $this->model->getregistros($rut);
        // $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $iniciar = ($id-1)*$autorizacionporpagina; 
        // $citas = $this->model->getpag($iniciar,$autorizacionporpagina,$rut, null, null);

        //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
        $citas_cds = $this->model->get_pacientes_CDS($rut, $fecha, $fecha_hasta);
        // $codigos_reserva_atencion_string = $citas_cds;
        $codigos_reserva_atencion_string = $citas_cds['items_reserva'];
       
        // Variable citas_rs =  lista de pacientes de rebsol recepcionados con atencion.
        $citas_rs = $this->model->get_pacientes_RS($iniciar,$autorizacionporpagina, $fecha, $fecha_hasta,$codigos_reserva_atencion_string);
        
        $datos_informe = $citas_rs['informe'];
        $resultadoPaginacion = $citas_rs['resultadoPaginacion'];
        $totalautorizaciones = $citas_rs['cantidadRegistros'];
        $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $this->view->citas=$resultadoPaginacion;
        $this->view->fecha = $fecha;
        $this->view->fecha_hasta = $fecha_hasta;
        $this->view->datos_informe = $datos_informe;
        $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas=$paginas;
        $this->view->paginaactual=$id;
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        /*fin*/
        $this->view->render('ges/detallePacientes');
      }


    function modal_cargar()
    {
        // var_dump($_POST);
        $this->view->paciente=$_POST["rut"];

        // setear fecha
        $formattedDate = date("Y-m-d", strtotime($_POST["fecha_atencion"]));
        $this->view->fecha_atencion=$formattedDate;
        $this->view->render('ges/modal_cargar');
    }


    function CargarArchivoGES()
    {
       
        $fecha=$_POST['fecha'];
        $rut=$_POST['id_rut'];
        // var_dump($fecha);
        // var_dump($rut);
        if (isset($_FILES['archivo_ges']))
        {
            $archivo = $_FILES['archivo_ges'];
            $nombreArchivoOriginal  = basename($archivo['name']);  // Usamos el nombre que pases como parámetro
            $extencion = pathinfo($nombreArchivoOriginal, PATHINFO_EXTENSION);
            $nuevoNombreArchivo = $rut."_".$fecha ."_". microtime(true) . "." . $extencion;
            $raiz = realpath(__DIR__ . '/../..');
            // echo $raiz;
            // return;
            $sistema = "iopaGo";
            $carpeta_tipo="GES";// Apuntar a TEST o a GES
            $carpetaPDF = "public/PDF/".$carpeta_tipo;

            // Obtenemos la fecha actual en formato YYYY-MM-DD
            // $fechaCarpeta = date('2023-m-d');
            $fechaCarpeta = $fecha;
            // $fechaCarpeta = date('Y-m-d');
            
            // Ruta de la carpeta donde guardaremos los archivos, incluyendo la fecha
            $rutaDestino = $raiz . "/" . $sistema . "/" . $carpetaPDF . "/" . $fechaCarpeta;
            // echo'<pre>';
            // var_dump($rutaDestino);
            // echo'<pre>';
            // exit();
            
            // Verificamos si la carpeta de la fecha existe
            if (!is_dir($rutaDestino))
            {
                // Si no existe, la creamos con permisos 0777 para que se pueda escribir
                if (!mkdir($rutaDestino, 0777, true))
                {
                    $respuesta=array("success" => false, "message" => "Error al crear la carpeta.");
                    echo json_encode($respuesta);
                    return;
                }
            }

            // Ruta final del archivo a guardar
            $rutaArchivoFinal = $rutaDestino . "/" . $nuevoNombreArchivo;
            // echo'<pre>';
            // var_dump($rutaArchivoFinal);
            // echo'<pre>';
            // exit();

            // Mover el archivo subido a la carpeta destino
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivoFinal))
            {
                $fecharegistro=$fecha." ".date("H:i:s");
                $respuesta=$this->DB_ges_archivo($rut, $carpeta_tipo, $nuevoNombreArchivo,$carpeta_tipo, $fecharegistro);
            }
            else
            {
                // echo "Hubo un error al guardar el archivo.";
                $respuesta=array("success" => false, "message" => "Hubo un error al guardar el archivo.");
            }
        }
        else
        {
            // echo "No se recibió ningún archivo.";
            $respuesta=array("success" => true, "message" => "No se recibió ningún archivo.");
        }
        echo json_encode($respuesta);
    }


      function verPaginacion_Detalle_Prestaciones($param=null){
       
        if (!empty($_POST)) {
            // Acceder a los datos
           
            if (!empty($_POST['rut'])) {
                $rut = $_POST['rut'];
            }else{
                $rut = null;

            }
            
            if (!empty($_POST['fecha_desde'])) {
                $fecha = $_POST['fecha_desde'];
            }else{
                 $fecha = null;
                //$fecha = date('Y-m-d');
            

            }

            if (!empty($_POST['fecha_hasta'])) {
                $fecha_hasta = $_POST['fecha_hasta'];
            }else{
                $fecha_hasta = null;
                //$fecha_hasta = date('Y-m-d');

            }
         
           
           $id = 1;
           
       } else if($param==NULL) {
           
            $rut = null;
        //    $fecha = null;
        //    $fecha_hasta = null;
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $id = 1;
       }
       else
       {
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
           
            
          
           $id = $param[0];
           $cantidad_elementos = count($param);
        //    $fecha = null;
        //    $fecha_hasta = null;
           if ($cantidad_elementos > 1){
              $rut = $param[1];
           }else{
              $rut = null;
           }
           
       }
      

        $autorizacionporpagina=7;
        // $totalautorizaciones = $this->model->getregistros($rut);
        // $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $iniciar = ($id-1)*$autorizacionporpagina; 
        // $citas = $this->model->getpag($iniciar,$autorizacionporpagina,$rut, null, null);

        //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
        $citas_cds = $this->model->get_pacientes_CDS($rut, $fecha, $fecha_hasta);
        // $codigos_reserva_atencion_string = $citas_cds;
        $codigos_reserva_atencion_string = $citas_cds['items_reserva'];
       
        // Variable citas_rs =  lista de pacientes de rebsol recepcionados con atencion.
        $citas_rs = $this->model->get_pacientes_RS($iniciar,$autorizacionporpagina, $fecha, $fecha_hasta,$codigos_reserva_atencion_string);
        
        $datos_informe = $citas_rs['informe'];
        $resultadoPaginacion = $citas_rs['resultadoPaginacion'];
        $totalautorizaciones = $citas_rs['cantidadRegistros'];
        $paginas =$totalautorizaciones/$autorizacionporpagina;  
        $this->view->citas=$resultadoPaginacion;
        $this->view->fecha = $fecha;
        $this->view->fecha_hasta = $fecha_hasta;
        $this->view->datos_informe = $datos_informe;
        $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas=$paginas;
        $this->view->paginaactual=$id;
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        $this->view->render('ges/detallePrestaciones');
      }



      function verPaginacion_Detalle_Optica($param=null){
       
        if (!empty($_POST)) {
            // Acceder a los datos
           
            // if (!empty($_POST['rut'])) {
            //     $rut = $_POST['rut'];
            // }else{
            //     $rut = null;

            // }
            if (!empty($_POST['fecha_desde'])) {
                $fecha = $_POST['fecha_desde'];
            }else{
                // $fecha = null;
                $fecha = date('Y-m-d');
            

            }

            if (!empty($_POST['fecha_hasta'])) {
                $fecha_hasta = $_POST['fecha_hasta'];
            }else{
                // $fecha_hasta = null;
                $fecha_hasta = date('Y-m-d');

            }
         
           
           $id = 1;
           
       } else if($param==NULL) {
           
            $rut = null;
        //    $fecha = null;
        //    $fecha_hasta = null;
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $id = 1;
       }
       else
       {
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
           
          
           $id = $param[0];
           $cantidad_elementos = count($param);
       
           if ($cantidad_elementos > 1){
              $rut = $param[1];
           }else{
              $rut = null;
           }
           
       }
      

        $autorizacionporpagina=7;
        $iniciar = ($id-1)*$autorizacionporpagina; 
        //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
        $citas_cds = $this->model->get_pacientes_CDS($fecha, $fecha_hasta);
        $codigos_reserva_atencion_string = $citas_cds;
        
        // Variable citas_rs =  lista de pacientes de rebsol recepcionados con atencion.
        $citas_rs = $this->model->get_pacientes_RS($iniciar,$autorizacionporpagina, $fecha, $fecha_hasta,$codigos_reserva_atencion_string);
        

        $datos_informe = $citas_rs['informe'];
        $resultadoPaginacion = $citas_rs['resultadoPaginacion'];
        $totalautorizaciones = $citas_rs['cantidadRegistros'];
       
        $paginas =$totalautorizaciones/$autorizacionporpagina;  
        $this->view->citas=$resultadoPaginacion;
        $this->view->fecha = $fecha;
        $this->view->fecha_hasta = $fecha_hasta;
        $this->view->datos_informe = $datos_informe;
        $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas=$paginas;
        $this->view->paginaactual=$id;
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        $this->view->render('ges/detalleOptica');
      }

  

    function DB_ges_archivo($rut, $nombre_carpeta, $nombre_archivo_ges, $tipo_ges, $fecharegistro)
    {
        try
        {
            // Preparamos la consulta
            // $sql = "INSERT INTO formulario_ges (rut, nombre_carpeta, nombre_archivo_ges, tipo_ges,fecha_registro) 
            //         VALUES (:rut, :nombre_carpeta, :nombre_archivo_ges, :tipo_ges,NOW())";


            // echo'<pre>';
            // var_dump($rut);
            // var_dump($nombre_carpeta);
            // var_dump($nombre_archivo_ges);
            // var_dump($tipo_ges);
            // var_dump($fecharegistro);
            // echo'<pre>';
            // exit();

            $sql = "INSERT INTO formulario_ges (rut, nombre_carpeta, nombre_archivo_ges, tipo_ges,fecha_registro) 
                    VALUES (:rut, :nombre_carpeta, :nombre_archivo_ges, :tipo_ges, :fecha_registro)";

            // Preparamos la sentencia
            $query = $this->ges->prepare($sql);

            // Vinculamos los parámetros
            $query->bindParam('rut', $rut);
            $query->bindParam('nombre_carpeta', $nombre_carpeta);
            $query->bindParam('nombre_archivo_ges', $nombre_archivo_ges);
            $query->bindParam('tipo_ges', $tipo_ges);
            $query->bindParam('fecha_registro', $fecharegistro);

            // Ejecutamos la consulta
            $query->execute();

            // Verificamos si la inserción fue exitosa
            if ($query->rowCount() > 0)
            {
                // Si la inserción fue exitosa, podemos retornar un mensaje de éxito
                $respuesta=array("success" => true, "message" => "Archivo insertado correctamente");
                return $respuesta;
            }
            else
            {
                // Si no se insertaron filas (aunque la consulta se haya ejecutado), es un error
                $respuesta=array("success" => false, "message" => "No se insertó el archivo");
                return $respuesta;
            }
        }
        catch (PDOException $e)
        {
            // Si ocurre un error con la base de datos, lo capturamos y mostramos un mensaje
            $respuesta=array("success" => false, "message" => "Error en la base de datos: " . $e->getMessage());
            return $respuesta;
        }
    }


}
?>
