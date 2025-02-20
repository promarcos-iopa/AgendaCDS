<?php
session_start();
//include_once 'models/pacienteComision.php';
class Informe extends Controller{
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
	}

    function verPaginacion_Detalle_Pacientes($param=null){

        if (!empty($_POST)) {
           

            if (!empty($_POST['rut'])) {
                $rut = $_POST['rut'];
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                }else{
                    $fecha = null;
                    
                
    
                }
    
                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                }else{
                    $fecha_hasta = null;
                    
    
                }
            }else{
                $rut = null;
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                }else{
                    $fecha = null;
                  
    
                }
    
                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                }else{
                    $fecha_hasta = null;
                   
                   
    
                }
              
            }


            
         
           
           $id = 1;
           
       } else if($param==NULL) {
           
            $rut = null;
       
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $id = 1;
            $this->view->mensaje='';
       }
       else
       {
           $id = $param[0];
           $cantidad_elementos = count($param);
           $fecha = $_GET['fecha'] ?? date('Y-m-d');
           $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
           $this->view->mensaje='';
           $rut = null;
       
           
       }
      

        $autorizacionporpagina=7;
        // $totalautorizaciones = $this->model->getregistros($rut);
        // $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $iniciar = ($id-1)*$autorizacionporpagina; 
        // $citas = $this->model->getpag($iniciar,$autorizacionporpagina,$rut, null, null);

       
         //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
       $citas_cds = $this->model->get_pacientes_CDS($rut, $fecha, $fecha_hasta);
       
        $this->view->mensaje = '';  
       if ($citas_cds['items_reserva'] =='') {
            $fecha = date('Y-m-d');
            $fecha_hasta = date('Y-m-d');
            $this->view->mensaje = "No hay resultados encontrados para este filtro";
            $citas_cds = $this->model->get_pacientes_CDS(null, $fecha, $fecha_hasta);
            
            
        }

        // echo "<pre>";
        // var_dump($citas_cds);
        // echo "</pre>";
        // exit(); 

        $codigos_reserva_atencion_string = $citas_cds['items_reserva'];
        // echo "<pre>";
        // var_dump($codigos_reserva_atencion_string);
        // echo "</pre>";
        // exit(); 
       
       

        // Variable citas_rs =  lista de pacientes de rebsol recepcionados con atencion.
        $citas_rs = $this->model->get_pacientes_RS($iniciar,$autorizacionporpagina, $fecha, $fecha_hasta,$codigos_reserva_atencion_string);
        // echo "<pre>";
        // var_dump($citas_rs);
        // echo "</pre>";
        // exit(); 
        

        $datos_informe = $citas_rs['informe'];
        $resultadoPaginacion = $citas_rs['resultadoPaginacion'];
        $totalautorizaciones = $citas_rs['cantidadRegistros'];
       
        $paginas =$totalautorizaciones/$autorizacionporpagina; 
        // echo "<pre>";
        // var_dump($resultadoPaginacion);
        // echo "</pre>";
        // exit(); 
        $this->view->citas=$resultadoPaginacion;
        $this->view->fecha = $fecha;
        $this->view->fecha_hasta = $fecha_hasta;
        $this->view->datos_informe = $datos_informe;
        // $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas=$paginas;
        $this->view->paginaactual=$id;
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        /*fin*/
        $this->view->render('informes/detallePacientes');
      }



    function verPaginacion_Detalle_Prestaciones($param=null){
        
        if (!empty($_POST)) {
           

            if (!empty($_POST['rut'])) {
                $rut = $_POST['rut'];
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                }else{
                    $fecha = null;
                    
                
    
                }
    
                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                }else{
                    $fecha_hasta = null;
                    
    
                }
            }else{
                $rut = null;
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                }else{
                    $fecha = null;
                  
    
                }
    
                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                }else{
                    $fecha_hasta = null;
                   
                   
    
                }
              
            }


            
         
           
           $id = 1;
           
       } else if($param==NULL) {
           
            $rut = null;
       
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $id = 1;
            $this->view->mensaje='';
       }
       else
       {
           $id = $param[0];
           $cantidad_elementos = count($param);
           $fecha = $_GET['fecha'] ?? date('Y-m-d');
           $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
           $this->view->mensaje='';
           $rut = null;
       
           
       }
      

        $autorizacionporpagina=7;
        // $totalautorizaciones = $this->model->getregistros($rut);
        // $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $iniciar = ($id-1)*$autorizacionporpagina; 
        // $citas = $this->model->getpag($iniciar,$autorizacionporpagina,$rut, null, null);

       
         //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
       $citas_cds = $this->model->get_pacientes_CDS($rut, $fecha, $fecha_hasta);
        // echo "<pre>";
        // var_dump('get_pacientes_CDS');
        // var_dump($citas_cds);
        // echo "</pre>";
        // exit(); 
        
       
        $this->view->mensaje = '';  
       if ($citas_cds['items_reserva'] =='') {
            $fecha = date('Y-m-d');
            $fecha_hasta = date('Y-m-d');
            $this->view->mensaje = "No hay resultados encontrados para este filtro";
            $citas_cds = $this->model->get_pacientes_CDS(null, $fecha, $fecha_hasta);
            
            
        }
        
        $codigos_reserva_atencion_string = $citas_cds['items_reserva'];
        

        // Variable citas_rs =  lista de pacientes de rebsol recepcionados con atencion.
        // $citas_rs = $this->model->get_pacientes_RS($iniciar,$autorizacionporpagina,null, null);
        $citas_rs = $this->model->get_pacientes_RS($iniciar,$autorizacionporpagina, $fecha, $fecha_hasta,$codigos_reserva_atencion_string);
        
       

        $datos_informe = $citas_rs['informe'];
        $resultadoPaginacion = $citas_rs['resultadoPaginacion'];
        $totalautorizaciones = $citas_rs['cantidadRegistros'];
        // Verifica si $citas_rs es un arreglo válido
        
        $paginas =$totalautorizaciones/$autorizacionporpagina;  

        $this->view->citas=$resultadoPaginacion;
        $this->view->fecha = $fecha;
        $this->view->fecha_hasta = $fecha_hasta;
        $this->view->datos_informe = $datos_informe;
        // $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas=$paginas;
        $this->view->paginaactual=$id;
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        $this->view->render('informes/detallePrestaciones');
      }



      function verPaginacion_Detalle_Optica($param=null){
       
    

        if (!empty($_POST)) {
           

            if (!empty($_POST['rut'])) {
                $rut = $_POST['rut'];
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                }else{
                    $fecha = null;
                    
                
    
                }
    
                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                }else{
                    $fecha_hasta = null;
                    
    
                }
            }else{
                $rut = null;
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                }else{
                    $fecha = null;
                  
    
                }
    
                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                }else{
                    $fecha_hasta = null;
                   
                   
    
                }
              
            }


            
         
           
           $id = 1;
           
       } else if($param==NULL) {
           
            $rut = null;
       
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $id = 1;
            $this->view->mensaje='';
       }
       else
       {
           $id = $param[0];
           $cantidad_elementos = count($param);
           $fecha = $_GET['fecha'] ?? date('Y-m-d');
           $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
           $this->view->mensaje='';
           $rut = null;
       
           
       }
      

        $autorizacionporpagina=7;
        // $totalautorizaciones = $this->model->getregistros($rut);
        // $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $iniciar = ($id-1)*$autorizacionporpagina; 
        // $citas = $this->model->getpag($iniciar,$autorizacionporpagina,$rut, null, null);

       
         //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
       $citas_cds = $this->model->get_pacientes_CDS($rut, $fecha, $fecha_hasta);
        // echo "<pre>";
        // var_dump('get_pacientes_CDS');
        // var_dump($citas_cds);
        // echo "</pre>";
        // exit(); 
        // 1838350,1838337,1838341,1838342,1838343,1838344,1838346,1839097
        // 1838344
       
        $this->view->mensaje = '';  
       if ($citas_cds['items_reserva'] =='') {
            $fecha = date('Y-m-d');
            $fecha_hasta = date('Y-m-d');
            $this->view->mensaje = "No hay resultados encontrados para este filtro";
            $citas_cds = $this->model->get_pacientes_CDS(null, $fecha, $fecha_hasta);
            
            
        }

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
        // $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas=$paginas;
        $this->view->paginaactual=$id;
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        $this->view->render('informes/detalleOptica');
      }




    public function descargarExcel() {
        $valor = $_POST['valor'];  
        $datos_informe = $_POST['datos'];
        $mensaje = "";
    
        switch ($valor) {
            case 1:
                // Caso 1: Descargar Excel informe Pacientes
                if ($this->model->descargar_Excel_pacientes($datos_informe)) {
                    $mensaje = 'Excel Descargado Correctamente';
                } else {
                    $mensaje = 'Error al Descargar Excel';
                }
                break;
    
            case 2:
                // Caso 2: Descargar Excel informe Prestaciones
                if ($this->model->descargar_Excel_Prestacion($datos_informe)) {
                    $mensaje = 'Excel Descargado Correctamente';
                } else {
                    $mensaje = 'Error al Descargar Excel';
                }
                break;
    
            case 3:
                // Caso 3: Descargar Excel informe optica
                if ($this->model->descargar_Excel_optica($datos_informe)) {
                    $mensaje = 'Excel Descargado Correctamente';
                } else {
                    $mensaje = 'Error al Descargar Excel';
                }
                break;
    
            default:
                // Caso por defecto: Valor no reconocido
                $mensaje = 'Error: Tipo de Excel no reconocido';
                break;
        }
    
        echo json_encode($mensaje);
    }









    


    public function obtenerMedicos(){
        $medicos = $this->model->getumedicos();
        echo json_encode($medicos);
    }


    public function obtener_bloque_medico(){
        $medico = $_POST['medico_select'];
        $fecha = $_POST['fecha_bloque'];
        $bloque_medico = $this->model->get_Bloque_medico($medico, $fecha);
        echo json_encode($bloque_medico);
    }


    public function reservar_agenda(){
        if ($this->model->insert_reserva($_POST)){
            $mensaje='Reserva agendada con exito';
        }else{
            $mensaje='No se pudo agendar la reserva';
        }
        echo json_encode($mensaje);
    }


    public function cargar_reserva_agenda(){
        $id_horario = $_POST['id_horario'];
        $datos_reserva = $this->model->get_reserva_agenda($id_horario,'');
        echo json_encode($datos_reserva);
       
    }


    public function actualizar_reserva(){
        // echo "<pre>";
        // var_dump('actualizar reserva');
        // var_dump($_POST);
        // echo "</pre>";
        // exit();
        $respuesta = $this->model->update_reserva_agenda($_POST);
         // echo "<pre>";
        // var_dump('respuesta de la actualizacion');
        // var_dump($respuesta);
        // echo "</pre>";
        // exit();
        if ($respuesta){
            $mensaje='Reserva actualizada con exito';
        }else{
            $mensaje='No se pudo actualizar la reserva';
        }
       
        echo json_encode($mensaje);
    }



    public function anular_reserva() {
        // echo "<pre>";
        // var_dump('respuesta de la actualizacion');
        // var_dump($_POST);
        // echo "</pre>";
        // exit();

        $id_horario = $_POST['id_horario'];
        $id_reserva = $_POST['id_reserva'];
        $usuario_anula = $_POST['usuario_anula'];
        $fecha_consulta = $_POST['fecha_consulta'];
        $hora_inicio = $_POST['hora_inicio'];
        $hora_fin = $_POST['hora_fin'];
        $lugar_consulta = $_POST['lugar_consulta'];
        $motivo_anula = $_POST['motivo_anula'];
        // Definir ruta para los logs, bajamos un nivel para encontrar la carpeta 
        $log_dir = __DIR__ . '/../logs';
        
        // Generar el nombre del archivo de log basado en la fecha actual
        $fecha_actual = date('Y-m-d');
        $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
        
        // Verificar si la carpeta de logs existe, si no, crearla
        if (!is_dir($log_dir)) {
            mkdir($log_dir, 0777, true);
        }
    
        // Verificar si el archivo de log existe, si no, crearlo
        if (!file_exists($log_file)) {
            file_put_contents($log_file, ''); // Crea el archivo si no existe
        }
    
        $mensaje = '';
    
        // Función para registrar los mensajes en el log
        function registrar_log($mensaje, $log_file) {
            error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
        }

        $exito =false;

        $datos_reserva = $this->model->get_reserva_agenda($id_horario, $id_reserva);
        $cod_reserva_rebsol = $datos_reserva[0]["codigo_reserva_atencion_rebsol"];
        // echo "<pre>";
        // // var_dump($datos_reserva);
        // var_dump('anular reserva');
        // var_dump($fecha_consulta);
        // echo "</pre>";
        // exit();
    
        if (!$datos_reserva) {
            $mensaje = 'No se encontró la reserva para el id_horario: ' . $id_horario;
            registrar_log($mensaje, $log_file);
        } elseif (!$this->model->insert_anular_agenda($datos_reserva, $usuario_anula, $fecha_consulta, $hora_inicio, $hora_fin, $lugar_consulta, $motivo_anula, $id_horario, $id_reserva)) {
            $mensaje = 'No se pudo anular la reserva para el id_horario: ' . $id_horario;
            registrar_log($mensaje, $log_file);
        } elseif (!$this->model->delete_reserva_agenda($id_horario, $id_reserva, $cod_reserva_rebsol)) {
            $mensaje = 'No se pudo eliminar la reserva para el id_horario: ' . $id_horario;
            registrar_log($mensaje, $log_file);
        } else {
            $mensaje = 'Reserva anulada con éxito para el id_horario: ' . $id_horario;
            registrar_log($mensaje, $log_file);
            $exito = true;
        }
    
        echo json_encode($exito);
    }



    public function cargarConsentimiento(){

        $rut = $_POST['rut'];
        $fecha_atencion = $_POST['fecha_atencion'];
        $documento_consentimiento=$this->model->buscarDocConsentimiento($rut,$fecha_atencion);
        echo json_encode($documento_consentimiento);


    }


}


// echo "<pre>";
// var_dump($data);
// echo "</pre>";
// exit;
?>
