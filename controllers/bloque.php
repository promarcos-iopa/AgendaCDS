<?php
session_start();
//include_once 'models/pacienteComision.php';
class Bloque extends Controller{
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


    public function obtenerMedicos(){
      $medicos = $this->model->getumedicos();
      echo json_encode($medicos);
    }

    public function crearBloqueMedico(){
      $id_medico = $_POST['id_medico'];
      $fecha = $_POST['fecha_desde'];
      $fecha_hasta = $_POST['fecha_hasta'];
      $hora_inicio = $_POST['hora_inicio'];
      $hora_fin = $_POST['hora_fin'];
      $duracion_consulta = $_POST['duracion_consulta'];
      $array_dias_select = $_POST['array_dias_select'];
      $rut_medico = $_POST['rut_medico'];
      $usuario = $_SESSION['rut'];
      // $id_medico = $this->calcularRutFormateado($id_medico);

      if ($this->model->insertarBloque( $id_medico, $fecha, $fecha_hasta, $hora_inicio, $hora_fin, $duracion_consulta, $array_dias_select, $rut_medico)){
        $mensaje="Bloque creado con exito";
      }else{
        $mensaje="error al crear el bloque";
      }
      echo json_encode($mensaje);
    }


    function verPaginacion($param=null){
        $this->view->usuario=$_SESSION['usuario'];
        $permisos=$this->model->getmenu($_SESSION['usuario']); 	
        $this->view->usuariosperfil=$permisos;
        $this->view->render('bloque/index');
    }


    // function apiCitasCds(){
        
    //     $result=$this->model->accesosApi(); 	
      
    // }



  //   function calcularRutFormateado($rut) {
  //     // Eliminar espacios y guiones
  //     $rut = preg_replace('/[^\d]/', '', $rut);
  
  //     // Validar que el RUT tenga al menos 7 dígitos
  //     if (strlen($rut) < 7) {
  //         return null; // RUT inválido
  //     }
  
  //     $suma = 0;
  //     $multiplicador = 2;
  
  //     // Calcular la suma para el dígito verificador
  //     for ($i = strlen($rut) - 1; $i >= 0; $i--) {
  //         $suma += $rut[$i] * $multiplicador;
  //         $multiplicador++;
  //         if ($multiplicador > 7) {
  //             $multiplicador = 2; // Reiniciar el multiplicador
  //         }
  //     }
  
  //     $resto = $suma % 11;
  //     $digitoVerificador = 11 - $resto;
  
  //     // Asignar el dígito verificador correspondiente
  //     if ($digitoVerificador == 11) {
  //         $digitoVerificador = '0';
  //     } elseif ($digitoVerificador == 10) {
  //         $digitoVerificador = 'K';
  //     }
  
  //     // Retornar el RUT formateado sin puntos
  //     return $rut.'-'.$digitoVerificador;
  // }


}
?>
