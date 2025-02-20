<?php
session_start();
//include_once 'models/pacienteComision.php';
class Facturacion extends Controller{
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
        $this->facturacion = $this->database();
	}


    public function database()
	{
		
		$host = constant('HOST');
		$db = constant('DB');
		$user = constant('USER');
		$password = constant('PASSWORD');
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


    function verPaginacion(){
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        $this->view->render('facturacion/documentosfacturacion');

    }





   

    function verPaginacion_Detalle_Optica($param=null){
    if (!empty($_POST)) {
        

        if (!empty($_POST['mes'])) {
            $rut = null;

            //obtener l primera y ultima fecha del mes en base al dato de la variable $mes del año actual 
            $mes = $_POST['mes']; // Mes recibido por POST
            $anio = date('Y'); // Año actual
            // Obtener la primera y última fecha del mes
            $fecha = date('Y-m-d', strtotime("$anio-$mes-01"));
            $fecha_hasta = date('Y-m-t', strtotime($fecha));

          
            
        }else{
            //obtener el mes actual 
            $mes = date('m');
            //ahora obtener el primer primera y ultima fecha del mes 
            $primer_dia = date('Y-m-01');
            $ultimo_dia = date('Y-m-t');
            
            $fecha = $primer_dia;
            $fecha_hasta = $ultimo_dia;

           
           
            
            $rut = null;
            
            
        }


        
        
        
        $id = 1;
        
    } else if($param==NULL) {
        
        $rut = null;
        //obtener el mes actual 
        $mes = date('m');
        $anio = date('Y'); // Año actual
            // Obtener la primera y última fecha del mes
            $fecha = date('Y-m-d', strtotime("$anio-$mes-01"));
            $fecha_hasta = date('Y-m-t', strtotime($fecha));
        $id = 1;
        $this->view->mensaje='';
    }
    else
    {
        $id = $param[0];
        $cantidad_elementos = count($param);
        $mes = date('m');
        $anio = date('Y'); // Año actual
        // Obtener la primera y última fecha del mes
        $fecha = date('Y-m-d', strtotime("$anio-$mes-01"));
        $fecha_hasta = date('Y-m-t', strtotime($fecha));
        $this->view->mensaje='';
        $rut = null;
    
        
    }


    
    

    $autorizacionporpagina=7;
    $iniciar = ($id-1)*$autorizacionporpagina; 

    //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
    $citas_cds = $this->model->get_pacientes_CDS($rut, $fecha, $fecha_hasta);
    
    $this->view->mensaje = '';  
    if ($citas_cds['items_reserva'] =='') {
        $fecha = date('Y-m-d');
        $fecha_hasta = date('Y-m-d');
        $this->view->mensaje = "No hay resultados encontrados para este filtro";
        $citas_cds = $this->model->get_pacientes_CDS(null, $fecha, $fecha_hasta);
        
        
    }

    $codigos_reserva_atencion_string = $citas_cds['items_reserva'];

    // echo '<pre>';
    // var_dump($codigos_reserva_atencion_string);
    // echo '</pre>';
    // exit();
    
    // Variable citas_rs =  lista de pacientes de rebsol recepcionados con atencion.
    $citas_rs = $this->model->get_pacientes_RS($iniciar,$autorizacionporpagina, $fecha, $fecha_hasta,$codigos_reserva_atencion_string);

    // echo '<pre>';
    // var_dump($citas_rs['informe']);
    // echo '</pre>';
    // exit();

    
    

    $datos_informe = $citas_rs['informe'];
    $resultadoPaginacion = $citas_rs['resultadoPaginacion'];
    $totalautorizaciones = $citas_rs['cantidadRegistros'];
    
    $paginas =$totalautorizaciones/$autorizacionporpagina;  
    $this->view->citas=$resultadoPaginacion;
    $this->view->fecha = $fecha;
    $this->view->fecha_hasta = $fecha_hasta;
    $this->view->datos_informe = $datos_informe;
    $this->view->mes = $mes;
    // $this->view->mensaje='son'. $totalautorizaciones;
    $this->view->paginas=$paginas;
    $this->view->paginaactual=$id;
    $this->view->usuario=$_SESSION['usuario'];
    /*Pasar sus Permisos*/
    $permisos=$this->model->getmenu($_SESSION['usuario']); 	
    $this->view->usuariosperfil=$permisos;
    /*fin*/
    $this->view->render('facturacion/detalleFacturacion');
    }




    public function descargarExcel() {
        $valor = $_POST['valor'];  
        $datos_informe = $_POST['datos'];
        $centro_selecionado =$_POST['centro'];
        $mensaje = "";

       
    
        switch ($valor) {
            case 1:
                // Caso 1: Descargar Excel informe Pacientes
                if ($this->model->descargar_Excel_cierreMes_GES($datos_informe, $centro_selecionado)){
                    $mensaje = 'Excel Descargado Correctamente';
                } else {
                    $mensaje = 'Error al Descargar Excel';
                }
                break;
    
            case 2:
                // Caso 2: Descargar Excel informe Prestaciones
                if ($this->model->descargar_Excel_cierreMes_RES($datos_informe, $centro_selecionado)) {
                    $mensaje = 'Excel Descargado Correctamente';
                } else {
                    $mensaje = 'Error al Descargar Excel';
                }
                break;
    
            // case 3:
            //     // Caso 3: Descargar Excel informe optica
            //     if ($this->model->descargar_Excel_optica($datos_informe)) {
            //         $mensaje = 'Excel Descargado Correctamente';
            //     } else {
            //         $mensaje = 'Error al Descargar Excel';
            //     }
            //     break;
    
            default:
                // Caso por defecto: Valor no reconocido
                $mensaje = 'Error: Tipo de Excel no reconocido';
                break;
        }
    
        echo json_encode($mensaje);
    }



    function CargarArchivos(){

        $anio = $_POST['anio'];
        $valor_mes = $_POST['valor_mes'];
        $texto_mes = $_POST['texto_mes'];
        $tipo_documento = $_POST['tipo_documento'];
        $folio = $_POST['folio'];
        $centro = $_POST['centro'];
        $valor_programa = $_POST['valor_programa'];
        $texto_programa = $_POST['texto_programa'];

        
        // echo '<pre>';
        // var_dump( $anio);
        // var_dump($valor_mes);
        // var_dump($texto_mes);
        // var_dump($tipo_documento);
        // var_dump($folio);
        // var_dump($centro);
        // var_dump($valor_programa);
        // var_dump($texto_programa);
       
        // echo '</pre>';
        // exit();
       

        // var_dump($nombreArchivo);
        // $fecha=$_POST['fecha'];
        // $rut=$_POST['rut'];
        if (isset($_FILES['archivo'])){
            $archivo = $_FILES['archivo'];
            $nombreArchivoOriginal  = basename($archivo['name']);  // Usamos el nombre que pases como parámetro
            $extencion = pathinfo($nombreArchivoOriginal, PATHINFO_EXTENSION);
            // $nuevoNombreArchivo = $tipo_documento."_".$folio ."_". microtime(true) . "." . $extencion;
            $nuevoNombreArchivo = $tipo_documento."_".$folio ."_". $valor_programa."_". $texto_mes."." . $extencion;
            $raiz = realpath(__DIR__ . '/../..');

            // echo '<pre>';
            // var_dump($nombreArchivoOriginal);
            // var_dump($extencion);
            // var_dump( $nuevoNombreArchivo);
            // echo '</pre>';
            // exit();
            // echo $raiz;
            // return;
            $sistema = "agenda_medica_cds";
            $carpeta_tipo="DOCUMENTOS_FACTURACION";// Apuntar a TEST o a GES
            $carpetaPDF = "public/PDF/".$carpeta_tipo;

            // Obtenemos la fecha actual en formato YYYY-MM-DD
            // $fechaCarpeta = date('2023-m-d');
            // $fechaCarpeta = $fecha;
            // $fechaCarpeta = date('Y-m-d');
            
            // Ruta de la carpeta donde guardaremos los archivos, incluyendo la fecha
            $rutaDestino = $raiz . "/" . $sistema . "/" . $carpetaPDF . "/" . $centro. "/" .$texto_mes;

            // echo '<pre>';
            // var_dump($rutaDestino);
            // echo '</pre>';
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
            // echo '<pre>';
            // var_dump($rutaDestino);
            // echo '</pre>';
            // exit();

            // Ruta final del archivo a guardar
            $rutaArchivoFinal = $rutaDestino . "/" . $nuevoNombreArchivo;

            // Mover el archivo subido a la carpeta destino
            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivoFinal))
            {
                $respuesta=$this->DB_doc_facturacion_archivo($centro, $texto_mes, $anio, $tipo_documento, $texto_programa, $folio, $nuevoNombreArchivo);
                // $respuesta=array("success" => true, "message" => "Archivo insertado correctamente");
                
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


    function DB_doc_facturacion_archivo($centro, $texto_mes, $anio, $tipo_documento, $texto_programa, $folio, $nuevoNombreArchivo){
        try
        {
            

            $sql = "INSERT INTO documentos_facturacion (centro, mes, anio, tipo_documento, tipo_programa,  folio, nombre_archivo, fecha_registro_subida) 
                    VALUES (:centro, :mes, :anio, :tipo_documento, :tipo_programa, :folio, :nombre_archivo, NOW())";

            // Preparamos la sentencia
            $query = $this->facturacion->prepare($sql);

            // Vinculamos los parámetros
            $query->bindParam('centro', $centro);
            $query->bindParam('mes', $texto_mes);
            $query->bindParam('anio', $anio);
            $query->bindParam('tipo_documento', $tipo_documento);
            $query->bindParam('tipo_programa', $texto_programa);
            $query->bindParam('folio', $folio);
            $query->bindParam('nombre_archivo', $nuevoNombreArchivo);
           
            $query->execute();
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


    function cargar_documentos(){
        $centro = $_POST['centro'];
        $anio = $_POST['anio'];
        $mes = $_POST['mes'];
        $facturacion_cds = $this->model->documentos_facturacion($centro, $anio, $mes);
        // echo "<pre>";
        // var_dump($facturacion_cds);
        // echo "</pre>";
        // exit;
        if($facturacion_cds){
            $respuesta=array("success" => true, "message" => "Datos cargados correctamente", "datos" => $facturacion_cds);
        }else{
            $respuesta=array("success" => false, "message" => "No se encontraron datos");
            
        }

        echo json_encode($respuesta);
       
       
    }


}

?>
