<?php
session_start();
//include_once 'models/pacienteComision.php';
class Agenda extends Controller{
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


    function verPaginacion($param=null){
        $this->view->usuario=$_SESSION['usuario'];
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        $this->view->render('agenda/index');
       
    }


    //sincronizar_agenda_rs agregado 10-12-2024
    function sincronizar_agenda_rs(){
        $respuesta = $this->model->get_sincronizar_agenda_rs(); 
        if ($respuesta) {
            // $mensaje = ['status' => 'success', 'message' => 'Sincronización exitosa'];
            $mensaje = 'sincronizado exitoso';
        } else {
            // $mensaje = ['status' => 'error', 'message' => 'Error al sincronizar la agenda'];
            $mensaje = 'Error al sincronizar la agenda';
        }
        echo json_encode($mensaje);	
        // $this->view->render('agenda/index');
    }


    function verPaginacionDetalle($param=null){

       
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

            }

            if (!empty($_POST['fecha_hasta'])) {
                $fecha_hasta = $_POST['fecha_hasta'];
            }else{
                $fecha_hasta = null;

            }
         
           
           $id = 1;
           
       } else if($param==NULL) {
           
           $rut = null;
           $fecha = null;
           $fecha_hasta = null;
           $id = 1;
       }
       else
       {
           $id = $param[0];
           $cantidad_elementos = count($param);
           if ($cantidad_elementos > 1){
              $rut = $param[1];
           }else{
              $rut = null;
           }
           
       }

        $autorizacionporpagina=5;
        $totalautorizaciones = $this->model->getregistros($rut);
        $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $iniciar = ($id-1)*$autorizacionporpagina; 
        $citas = $this->model->getpag($iniciar,$autorizacionporpagina,$rut, $fecha, $fecha_hasta);
        
        $this->view->citas=$citas;
        $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas=$paginas;
        $this->view->paginaactual=$id;
        $this->view->usuario=$_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        /*fin*/
        $this->view->render('agenda/detalleCitasAgendadas');
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


}


// echo "<pre>";
// var_dump($data);
// echo "</pre>";
// exit;
?>
