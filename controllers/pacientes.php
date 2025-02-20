<?php
session_start();
class Pacientes extends Controller{
	function __construct()
	{
		parent::__construct();
      $this->view->medicos=[];
      if (!isset($_SESSION['usuario'])){
         echo "Acceso Negado";
         session_destroy();    
         $location=constant('URL');
         header("Location: " . $location);
         exit;
      }else{

      }
	}

   function render(){
      $permisos=$this->model->getmenu($_SESSION['usuario']); 	
      $this->view->usuariosperfil=$permisos;
      $this->view->render('pacientes/index');
   }


    



   function cargarExcel(){
      $respuesta = $this->model->leerExcel($_FILES);
      // echo "<pre>";
      // var_dump('imprime respuesta lectura de Excel');
      // var_dump($respuesta);
      // echo "</pre>";
      // exit();
      echo json_encode($respuesta);
      
   }


   function agendarRegistros(){
      header('Content-Type: application/json'); // Establece el tipo de respuesta como JSON
      // Decodifica los datos JSON enviados desde el cliente
      $jsonInput = file_get_contents('php://input');
      $data = json_decode($jsonInput, true);
  
      // Verifica si los arreglos están presentes
      if(isset($data['objArrImportacion']) && isset($data['data'])) {
            $objArrImportacion = $data['objArrImportacion']; // El primer arreglo
            $data_detalle_horario = $data['data']; // El segundo arreglo
   
            // Muestra los arreglos para depuración
            // echo "<pre>";
            // var_dump('Guardar Registros controlador');
            // var_dump($objArrImportacion); // Imprime el primer arreglo
            // var_dump($data_detalle_horario); // Imprime el segundo arreglo
            // echo "</pre>";
            // exit();



            $id_medico = $data_detalle_horario["id_medico"];
            $rut_medico = $data_detalle_horario["rut_medico"];
            $nombre_medico = $data_detalle_horario["nombre_medico"];
            $fecha_agenda = $data_detalle_horario["fecha_desde"];
            $array_dias_select = $data_detalle_horario["array_dias_select"];
            $lugar_consulta = 1;
            $prevision_p = 'PREVISION CDS';
            $duracion_consulta = 10;
            $rut_medico = $data_detalle_horario["rut_medico"];
            $filas = count($objArrImportacion);
            $ultima_fila = $filas -1;
            //OBTENER RANGO DE HORAS AGENDAR
            $hora_agenda_inicio = $objArrImportacion[0]["hora"];
            $hora_agenda_fin = $objArrImportacion[$ultima_fila]["hora"];

            // var_dump('imrime variables');
            // var_dump($filas);
            // var_dump($hora_agenda_inicio);
            // var_dump($hora_agenda_fin);
            // echo "</pre>";
            // exit();

            $respuesta = $this->model->buscar_bloque($fecha_agenda,'', $id_medico);
            // var_dump('imrime variables');
            // var_dump($respuesta);
            // echo "</pre>";
            // exit();
            if(!$respuesta ){
               $respuesta = $this->model->insertar_Bloque_horario_medico($id_medico, $fecha_agenda, $fecha_agenda, $hora_agenda_inicio, $hora_agenda_fin, $duracion_consulta, $array_dias_select, $rut_medico);
               if (is_array($respuesta) && count($respuesta) > 1) {
                  // $mensaje="Bloque médico creado con exito";
                  $id_bloque_medico_rs = $respuesta["id_bloque_medico_rebsol"];
                  $id_bloque_medico_cds = $respuesta["id_bloque_medico"];
               }else{
                  $mensaje="error al crear el bloque médico";
               }

            }else{
               $id_bloque_medico_rs = $respuesta[0]["id_bloque_medico_rebsol"];
               $id_bloque_medico_cds = $respuesta[0]["id_bloque_medico"];
             
            }

           
            for ($i = 0; $i < $filas; $i++) { // Recorrer desde 0 hasta el número de filas - 1

               $hora_agenda = $objArrImportacion[$i]["hora"];
               // Crear un objeto DateTime con la hora dada
               $hora_objeto = new DateTime($hora_agenda);
               // Sumar 10 minutos
               $hora_objeto->modify('+10 minutes');
               // Obtener la hora resultante en formato "H:i:s"
               $hora_fin = $hora_objeto->format('H:i:s');
               // $duracion_consulta = 10;
               $fecha_nacimiento = $objArrImportacion[$i]["fechaNacimiento"];
               $full_nombre = $objArrImportacion[$i]["nombre"];
               // Separar la cadena en partes
               $partes = explode(",", $full_nombre);

               $nombre = $partes[1];
               $apellidos = explode(" ", $partes[0]);

               // Dividir en apellido1 y apellido2
               $apellido1 =$apellidos[0]; // Primer apellido
               $apellido2 = $apellidos[1]; // Segundo apellido


               $rut_paciente = $objArrImportacion[$i]["rut"].'-'.$objArrImportacion[$i]["dv"];
               // $telefono1 = $objArrImportacion[$i]["telefono1"];
               // $telefono2 = $objArrImportacion[$i]["telefono2"];
               $telefono1 = isset($objArrImportacion[$i]["telefono1"]) && $objArrImportacion[$i]["telefono1"] !== null ? $objArrImportacion[$i]["telefono1"] : '';
               $telefono2 = isset($objArrImportacion[$i]["telefono2"]) && $objArrImportacion[$i]["telefono2"] !== null ? $objArrImportacion[$i]["telefono2"] : '';
               // $centro = utf8_decode($objArrImportacion[$i]["centro"]);
               $centro = $objArrImportacion[$i]["centro"];
               $correo = isset($objArrImportacion[$i]["correo"]) && $objArrImportacion[$i]["correo"] !== null ? $objArrImportacion[$i]["correo"] : '';
               //limpiar arreglo
               $data = array(); 
               $data = array(
                  'rut_p' => $rut_paciente,
                  'fecha_nac_p' => $fecha_nacimiento,
                  'nombre_p' => $nombre,
                  'apellido_1p' => $apellido1,
                  'apellido_2p' => $apellido2,
                  'direccion_p' => 'XXXXXXX',
                  'fono_1p' => $telefono1,
                  'fono_2p' => $telefono2,
                  'centro_derivado_p' => $centro,
                  'email_p' => $correo,
                  'id_medico' => $id_medico,
                  'medico_agenda' => $nombre_medico,
                  'fecha_consulta' => $fecha_agenda,
                  'rut_medico' => $rut_medico,
                  'hora_consulta' => $hora_agenda,
                  'lugar_consulta'=> $lugar_consulta,
                  'agendado_por' => $_SESSION["usuario"],
                  'prevision_p' => $prevision_p,
                  'observacion' => 'XXXXXXX',
                  'genero' => 'X',
                  'rut_m' => $id_medico,

               );


               //CONSULTAR HORARIO DISPONIBLE
               // $id_horario = $this->model->buscar_bloque($fecha_agenda, $hora_agenda, $id_medico);
               $respuesta = $this->model->buscar_bloque($fecha_agenda, $hora_agenda, $id_medico);
              
               
               if (!empty($respuesta)) {
                  $id_horario = $respuesta[0]["id"];
                  //agendar reserva 
                  if ($this->model->insert_reserva($data, $id_horario)){
                     $mensaje='Reserva agendada con exito';

                  }else{
                     $mensaje='No se pudo agendar la reserva';
                  }

               }else{

               //    if (isset($registro["estado"], $registro["sobre_cupo"]) && $registro["estado"] == 'ocupado' && $registro["sobre_cupo"] == 'ocupado') {
               //       continue; // Pasa al siguiente registro
               //   }

                  //insertar bloque horario
                  // $ultimo_id_horario = $this->model->insertar_bloque_horario($id_medico, $fecha_agenda, $fecha_agenda, $hora_agenda, $hora_fin, $duracion_consulta, $array_dias_select, $rut_medico, $id_bloque_medico);
                  $ultimo_id_horario = $this->model->insertar_bloque_horario($id_medico, $fecha_agenda, $fecha_agenda, $hora_agenda, $hora_fin, $duracion_consulta, 
                                                                                    $array_dias_select, $rut_medico, $id_bloque_medico_rs, $id_bloque_medico_cds);
                        
                  if ($ultimo_id_horario){
                     $mensaje='Bloque horario creado con exito';
                     //insertar reserva
                     if ($this->model->insert_reserva($data, $ultimo_id_horario)){
                        $mensaje='Reserva agendada con exito';

                     }else{
                        $mensaje='No se pudo agendar la reserva';
                     }
                  }

               }
            }
            // return $mensaje;
            echo json_encode($mensaje);
            // exit();
      }else {
          echo json_encode(['error' => 'Datos no válidos o faltantes']);
         //  exit();
      }



      
   }




}
?>
