<?php
//session_start();
// Mostrar todos los errores
// error_reporting(E_ALL);

// // Habilitar la visualización de errores
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

class AgendaModel extends Model
{
	  public function __construct(){
        parent::__construct();
    }


    public function getmenu($idu){
        $items = [];
        include_once 'models/usuariosperfil.php';
        try{
            $query=$this->db->connect()->query("SELECT * FROM usuariosperfil WHERE idusuario='".$idu."' AND  habilitado='S'");
            while($row=$query->fetch()){
                 $item = new Usuariosperfil();
                 $item->id            = $row['id'];
                 $item->idusuario     = $row['idusuario'];
                 $item->menu          = $row['menu'];
                 $item->habilitado    = $row['habilitado'];
                 $item->principal    = $row['principal'];
                 array_push($items,$item);
                 }
          return $items;
       }catch(PDOException $e){
           return [];
       }
   }


    public function getumedicos(){
        $items = [];
        try{
            $query=$this->db->connect()->query("SELECT * 
                                                FROM medicos 
                                                ORDER BY nombre ASC;");
        while($row=$query->fetch()){
                array_push( $items, $row );
                }
        return $items;
        }catch(PDOException $e){
            return [];
        }
    }


    // public function get_reserva_agenda($id_horario, $id_reserva){
    //     $items = [];
    //     try{
    //         $query=$this->db->connect()->query("SELECT * FROM citas WHERE id_horario = '$id_horario' ORDER BY id ASC");
    //         // echo "<pre>";
    //         // var_dump("get_reserva_agenda");
    //         // var_dump($query);
    //         // echo "</pre>";
    //         // exit();
    //     while($row=$query->fetch()){
    //         $item["id"] = $row['id'];
    //         $item["codigo_reserva_atencion_rebsol"] = $row['codigo_reserva_atencion_rebsol'];
    //         $item["rut"] = $row['rut'];
    //         $item["nombre"] = $row['nombre'];
    //         $item["apellido1"] = $row['apellido1'];
    //         $item["apellido2"] = $row['apellido2'];
    //         $item["fecha_nacimiento"] = $row['fecha_nacimiento'];
    //         $item["sexo"] = $row['sexo'];
    //         $item["direccion"] = $row['direccion'];
    //         $item["telefono"] = $row['telefono'];
    //         $item["telefono2"] = $row['telefono2'];
    //         $item["email"] = $row['email'];
    //         $item["centro"] = $row['centro'];
    //         $item["id_medico"] = $row['id_medico'];
    //         $item["nombre_medico"] = $row['nombre_medico'];
    //         $item["observacion"] = $row['observacion'];
    //         array_push( $items, $item );
    //     }
    //     // echo "<pre>";
    //     // var_dump("get_reserva_agenda");
    //     // var_dump($items);
    //     // echo "</pre>";
    //     // exit();
    //     return $items;
    //     }catch(PDOException $e){
    //         return [];
    //     }
    // }



    // public function get_reserva_agenda($id_horario, $id_reserva) {

    //     $items = [];
    //     try {
    //         // Validar que $id_reserva no esté vacío ni sea null
    //         if (empty($id_reserva) || is_null($id_reserva)) {
    //            // Preparar la consulta con parámetros
    //             $sql = "SELECT * FROM citas WHERE id_horario = :id_horario AND id = :id_reserva ORDER BY id ASC";
    //             $query = $this->db->connect()->prepare($sql);
    //             $query->bindParam(':id_horario', $id_horario);
    //             $query->bindParam(':id_reserva', $id_reserva);

    //         }else {
    //             $query = $this->db->connect()->query("SELECT * FROM citas WHERE id_horario = :id_horario ORDER BY id ASC");
    //             $query = $this->db->connect()->prepare($sql);
    //             $query->bindParam(':id_horario', $id_horario);

    //         }

           
    //         //ejecutar la consulta
    //         $query->execute();

    //         echo "<pre>";
    //         var_dump("get_reserva_agenda");
    //         var_dump($query);
    //         echo "</pre>";
    //         exit();
    
    //         // Procesar los resultados
    //         while ($row = $query->fetch()) {
    //             $item["id"] = $row['id'];
    //             $item["codigo_reserva_atencion_rebsol"] = $row['codigo_reserva_atencion_rebsol'];
    //             $item["rut"] = $row['rut'];
    //             $item["nombre"] = $row['nombre'];
    //             $item["apellido1"] = $row['apellido1'];
    //             $item["apellido2"] = $row['apellido2'];
    //             $item["fecha_nacimiento"] = $row['fecha_nacimiento'];
    //             $item["sexo"] = $row['sexo'];
    //             $item["direccion"] = $row['direccion'];
    //             $item["telefono"] = $row['telefono'];
    //             $item["telefono2"] = $row['telefono2'];
    //             $item["email"] = $row['email'];
    //             $item["centro"] = $row['centro'];
    //             $item["id_medico"] = $row['id_medico'];
    //             $item["nombre_medico"] = $row['nombre_medico'];
    //             $item["observacion"] = $row['observacion'];
    //             array_push($items, $item);
    //         }
    
    //         return $items;
    //     } catch (PDOException $e) {
    //         return ["error" => "Error en la consulta: " . $e->getMessage()];
    //     }
    // }




    public function get_reserva_agenda($id_horario, $id_reserva) {
        $items = [];
    
        try {
            // Verificar si $id_reserva no está vacío ni es null
            if (!empty($id_reserva)) {
                // Consulta con filtro por $id_reserva
                $sql = "SELECT * FROM citas WHERE id_horario = :id_horario AND id = :id_reserva ORDER BY id ASC";
                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
                $query->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
            } else {
                // Consulta solo con filtro por $id_horario
                $sql = "SELECT * FROM citas WHERE id_horario = :id_horario ORDER BY id ASC";
                $query = $this->db->connect()->prepare($sql);
                $query->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
            }
    
            // Ejecutar la consulta
            $query->execute();

           
    
            // Procesar los resultados
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = [
                    "id" => $row['id'],
                    "codigo_reserva_atencion_rebsol" => $row['codigo_reserva_atencion_rebsol'],
                    "rut" => $row['rut'],
                    "nombre" => $row['nombre'],
                    "apellido1" => $row['apellido1'],
                    "apellido2" => $row['apellido2'],
                    "fecha_nacimiento" => $row['fecha_nacimiento'],
                    "sexo" => $row['sexo'],
                    "direccion" => $row['direccion'],
                    "telefono" => $row['telefono'],
                    "telefono2" => $row['telefono2'],
                    "email" => $row['email'],
                    "centro" => $row['centro'],
                    "id_medico" => $row['id_medico'],
                    "nombre_medico" => $row['nombre_medico'],
                    "observacion" => $row['observacion']
                ];
                array_push($items, $item);
            }

            // echo "<pre>";
            // var_dump("get_reserva_agenda");
            // var_dump($items);
            // echo "</pre>";
            // exit();
    
            return $items;
        } catch (PDOException $e) {
            // Captura de errores con un mensaje claro
            return ["error" => "Error en la consulta: " . $e->getMessage()];
        }
    }



    //NEW FUNCTIONS
    public function get_Bloque_medico($medico, $fecha){
        $items = [];
        $desde = null;
        $hasta = null;
        // echo "<pre>";
        // var_dump("get Bloque medico");
        // var_dump($medico);
        // var_dump($fecha);
        // echo "</pre>";
        try {
            // Conectar usando PDO
            $conn = $this->db->connect(); // Asegúrate de que $conn esté definido como conexión PDO
    
            // Consultar los horarios disponibles basados en la fecha seleccionada
            if ($fecha) {
                $stmt = $conn->prepare("
                    SELECT h.*,
                    group_concat(concat_ws(' ',c.rut,c.apellido1)) as rut_nombre
                    FROM bloque_horario_medico bhm 
                    left join medicos m  on bhm.id_medico  = m.id 
                    INNER JOIN horarios h ON bhm.id = h.id_bloque_medico  
                    INNER JOIN citas c on h.id  = c.id_horario 
                    WHERE bhm.id_medico = :medico AND h.fecha = :fecha
                    group  by id 
                ");
                $stmt->bindParam(':medico', $medico);
                $stmt->bindParam(':fecha', $fecha);
            } else {
                // Mostrar todos los horarios disponibles para el médico especificado si no se selecciona una fecha
                $stmt = $conn->prepare("
                    SELECT h.*,
                    group_concat(concat_ws(' ',c.rut,c.apellido1)) as rut_nombre
                    FROM bloque_horario_medico bhm 
                    left join medicos m  on bhm.id_medico  = m.id 
                    INNER JOIN horarios h ON bhm.id = h.id_bloque_medico  
                    INNER JOIN citas c on h.id  = c.id_horario 
                    WHERE bhm.id_medico = :medico
                    group  by id 
                ");
                $stmt->bindParam(':medico', $medico);
            }
    
            $stmt->execute();
            // Obtener los resultados
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $rut_nombre = $row['rut_nombre'];

                if (strpos($rut_nombre, ',') !== false) {
                    // Dividir la cadena en dos partes usando la coma como separador
                    $partes = explode(',', $rut_nombre);
                
                    // Limpiar los espacios en blanco adicionales
                    $nombre1 = trim($partes[0]); // Primer nombre 
                    $nombre2 = trim($partes[1]); // Segundo nombre
                
                    
                }else{
                    $nombre1 = $rut_nombre;
                    $nombre2 = '';

                }
               
                if($row['estado']=='disponible'){
                    // $item["id"] = $row['id'];
                    // $item["title"] = $row['estado'];
                    // $item["start"] = $row['fecha'].'T'.$row['hora_inicio'];
                    // $item["end"] = $row['fecha_hasta'].'T'.$row['hora_fin'];
                    // $item["backgroundColor"] = '#0074c36e';
                    // array_push($items, $item);
                    $item["id"] = $row['id'].' '.$row['estado']; 
                    $item["title"] = $row['estado'];
                    $item["start"] = $row['fecha'].'T'.$row['hora_inicio'];
                    $item["end"] = $row['fecha_hasta'].'T'.$row['hora_fin'];
                    // $item["backgroundColor"] = '#0074c36e';
                    // $item["backgroundColor"] = '#0dab62';
                    // $item["backgroundColor"] = '#3788d8c9';
                    $item["backgroundColor"] = '#487de2';
                    $item["textColor"] = '#ffff'; // Texto blanco
                    // Agregar el icono con la clase personalizada
                    $item["extendedProps"] = [
                        "icono" => "<i class='fa fa-clock custom-icon'></i>",  // Icono de reloj con la clase CSS personalizada
                        "detalle" => "Detalles del evento"
                    ];
                    
                    array_push($items, $item);

                }else{
                    // if ($row['sobre_cupo'] =='ocupado'){
                    //     $sobrecupo = 'sobrecupo';
                    //     $item["id"] = $row['id'];
                    //     $item["title"] = $sobrecupo;
                    //     $item["start"] = $row['fecha'].'T'.$row['hora_inicio'];
                    //     $item["end"] = $row['fecha_hasta'].'T'.$row['hora_fin'];
                    //     // $item["backgroundColor"] = '#f0724e78';
                    //     $item["backgroundColor"] = '#FFA500';
                    //     $item["extendedProps"] = [
                    //         "icono" => "<i class='fa fa-clock custom-icon'></i>",  // Icono de reloj con la clase CSS personalizada
                    //         "detalle" => "Detalles del evento"
                    //     ];

                    // }else{
                        $item["id"] = $row['id'].' '.$row['estado'];
                        // $item["title"] = $row['estado'];
                        $item["title"] = "
                        <div style='display: flex; align-items: center; width: 100%; box-sizing: border-box; justify-content: flex-start;'>
                       
                        <span style='flex-grow: 1; overflow: hidden; text-overflow: ellipsis; font-size: 10px; display: inline-block; vertical-align: middle; white-space: normal; margin-left: 5px; box-sizing: border-box; width: calc(100% - 60px);'>
                            <div style='margin-bottom: -2px;'>%nombre1_placeholder%</div>
                            <div>%nombre2_placeholder%</div>
                        </span>
                        </div>";
                        // Reemplazamos los marcadores de posición por los valores dinámicos
                        $item["title"] = str_replace(
                        ['%nombre1_placeholder%', '%nombre2_placeholder%'],
                        [htmlspecialchars($nombre1, ENT_QUOTES, 'UTF-8'), htmlspecialchars($nombre2, ENT_QUOTES, 'UTF-8')],
                        $item["title"]
                        );
                        $item["start"] = $row['fecha'].'T'.$row['hora_inicio'];
                        $item["end"] = $row['fecha_hasta'].'T'.$row['hora_fin'];
                        // $item["backgroundColor"] = '#f0724e78';
                        $item["backgroundColor"] = '#e9c130';
                        $item["textColor"] = '#ffff'; // Texto blanco
                        $item["extendedProps"] = [
                            "icono" => "<i class='fa fa-clock custom-icon'></i>",  // Icono de reloj con la clase CSS personalizada
                            "detalle" => "Detalles del evento"
                        ];

                    // }
                   
                    // if ($row['sobre_cupo'] =='ocupado'){
                    //     $estado = 'S';
                    //     $item["id"] = $row['id'];
                    //     $item["title"] = $estado . ' ' . 'm.heunchunir ' . '18089559-0'; 
                    //     $item["start"] = $row['fecha'].'T'.$row['hora_inicio'];
                    //     $item["end"] = $row['fecha_hasta'].'T'.$row['hora_fin'];
                    //     // $item["backgroundColor"] = '#f0724e78';
                    //     $item["backgroundColor"] = '#FFA500';
                    //     $item["textColor"] = '#ffff'; // Texto negro
                    //     $item["extendedProps"] = [
                    //         "icono" => "<i class='fa fa-clock custom-icon'></i>",  // Icono de reloj con la clase CSS personalizada
                    //         "detalle" => "Detalles del evento"
                    //     ];

                    // }else{
                    //     $estado = 'A';
                    //     $item["id"] = $row['id'];
                    //     // $item["title"] = $estado . ' ' . 'm.heunchunir ' . '18089559-0'; 
                       
                    //    // Definimos la plantilla HTML como un string
                    //     $item["title"] = "
                    //     <div style='display: flex; align-items: center; width: 100%; box-sizing: border-box; justify-content: flex-start;'>
                    //     <span style='margin-left: 5px; flex-shrink: 0; white-space: nowrap;'>
                    //         <i class='fa fa-clock custom-icon'></i>
                    //     </span>
                    //     <span style='flex-grow: 1; overflow: hidden; text-overflow: ellipsis; font-size: 12px; display: inline-block; vertical-align: middle; white-space: normal; margin-left: 10px; box-sizing: border-box; width: calc(100% - 60px);'>
                    //         <div style='margin-bottom: -2px;'>%nombre1_placeholder%</div>
                    //         <div>%nombre2_placeholder%</div>
                    //     </span>
                    //     </div>";
                        
                    //     $id_horario_rs_anterior = '';
                    //     if($row['id_horario_rebsol'] != $id_horario_rs_anterior) {
                    //         $primeraLetra  = substr($row['nombre'], 0, 1);
                    //         $nombre1 = $primeraLetra .'.'.$row['apellido_paterno']; // Primer nombre 
                    //         $nombre2 = ""; // Segundo nombre

                    //     }else{
                    //         $primeraLetra2  = substr($row['nombre'], 0, 1);
                    //         $nombre2 = $primeraLetra2 .'.'.$row['apellido_paterno']; // Segundo nombre
                            
                    //     }
                    //     // Valores dinámicos
                    //     // $nombre1 = "m.huenchunir"; // Primer nombre
                    //     // $nombre2 = "n.gonzales"; // Segundo nombre

                    //     // Reemplazamos los marcadores de posición por los valores dinámicos
                    //     $item["title"] = str_replace(
                    //     ['%nombre1_placeholder%', '%nombre2_placeholder%'],
                    //     [htmlspecialchars($nombre1, ENT_QUOTES, 'UTF-8'), htmlspecialchars($nombre2, ENT_QUOTES, 'UTF-8')],
                    //     $item["title"]
                    //     );
                    //     $item["start"] = $row['fecha'].'T'.$row['hora_inicio'];
                    //     $item["end"] = $row['fecha_hasta'].'T'.$row['hora_fin'];
                    //     // $item["backgroundColor"] = '#f0724e78';
                    //     $item["backgroundColor"] = '#e9c130';
                    //     $item["textColor"] = '#ffff'; // Texto negro
                    //     $item["extendedProps"] = [
                    //         "icono" => "<i class='fa fa-clock custom-icon'></i>",  // Icono de reloj con la clase CSS personalizada
                    //         "detalle" => "Detalles del evento"
                    //     ];

                    // }
                    
                    array_push($items, $item);
                }
                
               
            }

            return $items;
        } catch (PDOException $e) {
            // Manejar la excepción de la manera que prefieras
            error_log("Error en get_Bloque_medico: " . $e->getMessage());
            return [];
        }
    }



    // Función para registrar mensajes en el log
    function registrar_log($mensaje, $log_file) {
        error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
    }


    public function insert_reserva($data) {
        try {


            // echo"<pre>";
            // var_dump($data);
            // echo"</pre>";
            // exit();

            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }
    
            // // Función para registrar mensajes en el log
            // function registrar_log($mensaje, $log_file) {
            //     error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
            // }

          
            $dbConnection = $this->db->connect();

            // Preparar la consulta SQL
            $sql = "INSERT INTO citas (
                        codigo_reserva_atencion_rebsol, rut, nombre, apellido1, apellido2, fecha_nacimiento, sexo, direccion, telefono, telefono2, email, prevision, sucursal, centro, id_medico, nombre_medico, usuario_agenda, observacion, id_horario
                    ) VALUES (
                        NULL, :rut, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :sexo, :direccion, :telefono, :telefono2, :email, :prevision, :sucursal, :centro, :id_medico, :nombre_medico, :usuario_agenda, :observacion, :id_horario
                    )";

            // Preparar la consulta
            $query = $dbConnection->prepare($sql);

            // Asignar los valores a los placeholders
            $query->bindParam(':rut', $data["rut_p"]);
            $query->bindParam(':nombre', $data["nombre_p"]);
            $query->bindParam(':apellido1', $data["apellido_1p"]);
            $query->bindParam(':apellido2', $data["apellido_2p"]);
            $query->bindParam(':fecha_nacimiento', $data["fecha_nac_p"]);
            $query->bindParam(':sexo', $data["genero"]); 
            $query->bindParam(':direccion', $data["direccion_p"]);
            $query->bindParam(':telefono', $data["fono_1p"]);
            $query->bindParam(':telefono2', $data["fono_2p"]); 
            $query->bindParam(':email', $data["email_p"]);
            $query->bindParam(':prevision', $data["prevision_p"]); 
            $query->bindParam(':sucursal', $data["lugar_consulta"]); 
            $query->bindParam(':centro', $data["centro_derivado_p"]); 
            $query->bindParam(':id_medico', $data["rut_m"]); 
            $query->bindParam(':nombre_medico', $data["medico_agenda"]); 
            $query->bindParam(':usuario_agenda', $data["agendado_por"]); 
            $query->bindParam(':observacion', $data["observacion"]); 
            $query->bindParam(':id_horario', $data["id_horario"]);

            // Ejecutar la consulta
            if ($query->execute()) {
                // Obtener el último ID insertado
                $id_reserva_cita = $dbConnection->lastInsertId();
                // echo"<pre>";
                // var_dump('ultimo id de reserva insertado');
                // var_dump($id_reserva_cita);
                    

                // validar si el horarios esta disponible
                $select_sql = "SELECT * FROM horarios WHERE id =:id_horario AND estado = 'ocupado'";
                $select_query = $this->db->connect()->prepare($select_sql);
                $select_query->bindParam(':id_horario', $data["id_horario"]);
                $select_query->execute();
                // Verificar si la consulta ha devuelto resultados
                if ($select_query->rowCount() > 0) {
                    // El horario está ocupado registra sobre cupo
                    $update_cupo_sql = "UPDATE horarios SET sobre_cupo = 'ocupado' WHERE id = :id_horario";
                    $update_cupo_query = $this->db->connect()->prepare($update_cupo_sql);
                    $update_cupo_query->bindParam(':id_horario', $data["id_horario"]);
                    $update_cupo_query->execute();
                   
                }

                 // Actualizar el estado del horario
                 $update_sql = "UPDATE horarios SET estado = 'ocupado' WHERE id = :id_horario";
                 $update_query = $this->db->connect()->prepare($update_sql);
                 $update_query->bindParam(':id_horario', $data["id_horario"]);
                 // $update_query->execute();
 
                 // exit();


               

                if($update_query->execute()){

                    // echo"<pre>";
                    // var_dump('insert cita agenda cds');
                    // var_dump($data);
                    // echo"</pre>";
                    // exit();

                    //Agendar cita en rebsol
                    // arreglo de parametros
                    $rut_medico = $data["rut_medico"];
                    // Quitamos los últimos dos caracteres
                    $rut_medico = substr($rut_medico, 0, -2);
                    $rut_paciente = $data["rut_p"];
                    $rut_paciente = substr($rut_paciente, 0, -2);
                    $fecha_consulta = $data["fecha_consulta"];
                    $fecha_formateada = DateTime::createFromFormat('d/m/Y', $fecha_consulta)->format('Y-m-d');
                  
                    $hora_consulta = $data["hora_consulta"];
                    // Dividimos la cadena por la letra "a"
                    $partes = explode('a', $hora_consulta);

                    // Eliminamos los espacios en blanco alrededor de las partes
                    $hora_inicio = trim($partes[0]); // Texto anterior a la "a"
                    $hora_termino = trim($partes[1]); // Texto posterior a la "a"
                    $calcula_minutos1 = new DateTime($hora_inicio);
                    $calcula_minutos2 = new DateTime($hora_termino);

                    // Calculamos la diferencia en minutos
                    $diferencia = $calcula_minutos1->diff($calcula_minutos2);
                    $duracion = ($diferencia->h * 60) + $diferencia->i; // Convertimos horas a minutos y sumamos los minutos

                    $fecha_horario_inicio = $fecha_formateada.' '.$hora_inicio;
                    $usuario = substr($_SESSION['rut'], 0, -2);
                   
                    $data_agenda = [
                        'fecha_hora_inicio' => $fecha_horario_inicio,
                        'duracion' => $duracion,
                        'rut_paciente' => $rut_paciente,
                        'rut_profesional' => $rut_medico,
                        'id_sucursal' => 1,
                        'usuario' => $usuario,
                        'data' => $data
                    ];
                   
                    $resultado = $this->llamarApi("citas/agendar","POST",$data_agenda);
                    // echo"<pre>";
                    // var_dump('resultado agenda api ');
                    // var_dump($resultado);
                   
                    $codigo_reserva_atencion = $resultado['id_cita_agendada']['codigo_reserva'];
                    $id_horario_consulta = $resultado['id_cita_agendada']['id_horario_consulta'];
                    // echo"<pre>";
                    // var_dump('codigo reserva atencion');
                    // var_dump($codigo_reserva_atencion);
                    // var_dump('id horario consulta');
                    // var_dump($id_horario_consulta);
                    // echo"</pre>";
                    // exit();
                   
                   
                    if($codigo_reserva_atencion > 0){

                        // Actualizar registro en horarios para agregar id del horario de rebsol 
                        $update_sql_horario = "UPDATE horarios SET id_horario_rebsol = :id_horario_rebsol WHERE id = :id_horario";
                        $update_query_horario = $this->db->connect()->prepare($update_sql_horario);
                        
                        // Enlazar parámetros
                        $update_query_horario->bindParam(':id_horario_rebsol', $id_horario_consulta);
                        $update_query_horario->bindParam(':id_horario', $data["id_horario"]);
                        $update_query_horario->execute();


                       // Actualizar registro de cita para agregar código de reserva de atención de rebsol 
                        $update_sql_citas = "UPDATE citas SET codigo_reserva_atencion_rebsol = :codigo_reserva_atencion_rebsol WHERE id_horario = :id_horario AND id =:id_reserva_cita";
                        $update_query_citas = $this->db->connect()->prepare($update_sql_citas);
                        
                        // Enlazar parámetros
                        $update_query_citas->bindParam(':codigo_reserva_atencion_rebsol', $codigo_reserva_atencion);
                        $update_query_citas->bindParam(':id_horario', $data["id_horario"]);
                        $update_query_citas->bindParam(':id_reserva_cita', $id_reserva_cita);
                        
                        // Ejecutar la consulta
                        if($update_query_citas->execute()){
                            // echo"<pre>";
                            // var_dump('actualizado CITA');
                            // var_dump($resultado);
                            // var_dump($codigo_reserva_atencion);
                            // var_dump($data["id_horario"]);
                            // echo"<pre>";
                            return true;
                        } else {
                            // echo"<pre>";
                            // var_dump('no se pudo actualizar cita');
                            // echo"<pre>";
                            // Obtener información del error
                            $errorInfo = $update_query_citas->errorInfo();
                            $mensaje_error = "Error al actualizar citas: " . $errorInfo[2];
                            
                            // Registrar el error en el log
                            registrar_log($mensaje_error, $log_file);
                            return false; 
                        }
                        // return $resultado;
                        

                    }else{
                        
                        $mensaje_error = "Error al agendar cita en rebsol";
                        registrar_log($mensaje_error, $log_file);
                        return false; 
                    }

                }else{
                    $errorInfo = $update_query->errorInfo();
                    $mensaje_error = "Error al alctualizar estado horarios: " . $errorInfo[2];
                    // echo $mensaje_error;
                    registrar_log($mensaje_error, $log_file);
                    return false; 
                }
    
                // return true; // Éxito al insertar y actualizar

            } else {
                 // Imprimir y registrar error al insertar
                $errorInfo = $query->errorInfo();
                $mensaje_error = "Error al insertar agenda cds: " . $errorInfo[2];
                // echo $mensaje_error;
                registrar_log($mensaje_error, $log_file);
                return false; 
            }
    
        } catch (PDOException $e) {
            // Manejar el error de la excepción
            $mensaje = sprintf(
                "Error en la inserción: %s. Código de error: %s.",
                $e->getMessage(),
                $e->getCode()
            );
            registrar_log($mensaje, $log_file);
            error_log("Error en la inserción: " . $e->getMessage());
            return false;
        }
    }



    public function insert_anular_agenda($datos_reserva, $usuario_anula, $fecha_consulta, $hora_inicio, $hora_fin, $lugar_consulta, $motivo_anula, $id_horario, $id_reserva) {
        try {
          
           
            $fecha_formateada = DateTime::createFromFormat("d/m/Y", $fecha_consulta)->format("Y-m-d");
            // Convertir las horas a formato TIME (HH:MM:SS)
            $hora_inicio = date('H:i:s', strtotime($hora_inicio));
            $hora_fin = date('H:i:s', strtotime($hora_fin));
            $prevision = 'CDS';

           
            // Preparar la sentencia SQL con los campos actualizados
            $sql = "INSERT INTO citas_anuladas (
                        rut, nombre, apellido1, apellido2, fecha_nacimiento, sexo, direccion, telefono, telefono2, email, 
                        prevision, sucursal, centro, rut_medico, nombre_medico, usuario_anula, fecha_anula, 
                        fecha_consulta, hora_inicio, hora_fin, observacion, id_horario, id_reserva_cita
                    ) 
                    VALUES (
                        :rut, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :sexo, :direccion, :telefono, :telefono2, :email, 
                        :prevision, :sucursal, :centro, :rut_medico, :nombre_medico, :usuario_anula, NOW(), 
                        :fecha_consulta, :hora_inicio, :hora_fin, :observacion, :id_horario, :id_reserva
                    )";
    
            // Preparar la consulta
            $query = $this->db->connect()->prepare($sql);
    
            // Asignar los valores a los placeholders
            $query->bindParam(':rut', $datos_reserva[0]["rut"]);
            $query->bindParam(':nombre', $datos_reserva[0]["nombre"]);
            $query->bindParam(':apellido1', $datos_reserva[0]["apellido1"]);
            $query->bindParam(':apellido2', $datos_reserva[0]["apellido2"]);
            $query->bindParam(':fecha_nacimiento', $datos_reserva[0]["fecha_nacimiento"]);
            $query->bindParam(':sexo', $datos_reserva[0]["sexo"]); 
            $query->bindParam(':direccion', $datos_reserva[0]["direccion"]);
            $query->bindParam(':telefono', $datos_reserva[0]["telefono"]);
            $query->bindParam(':telefono2', $datos_reserva[0]["telefono2"]); 
            $query->bindParam(':email', $datos_reserva[0]["email"]);
            $query->bindParam(':prevision', $prevision); 
            $query->bindParam(':sucursal', $lugar_consulta); 
            $query->bindParam(':centro', $datos_reserva[0]["centro"]); 
            $query->bindParam(':rut_medico', $datos_reserva[0]["rut_medico"]); 
            $query->bindParam(':nombre_medico', $datos_reserva[0]["nombre_medico"]); 
            $query->bindParam(':usuario_anula', $usuario_anula); 
            $query->bindParam(':fecha_consulta', $fecha_formateada);
            $query->bindParam(':hora_inicio', $hora_inicio); 
            $query->bindParam(':hora_fin', $hora_fin); 
            $query->bindParam(':observacion', $motivo_anula); 
            $query->bindParam(':id_horario', $id_horario);
            $query->bindParam(':id_reserva', $id_reserva);
    
            // Ejecutar la consulta de inserción
            if ($query->execute()) {
                return true; // Éxito al insertar
            } else {
                return false; // Fallo al insertar
            }
    
        } catch (PDOException $e) {
            // Manejar el error de la excepción
            error_log("Error en la inserción: " . $e->getMessage());
            return false;
        }
    }


    public function delete_reserva_agenda($id_horario, $id_reserva, $cod_reserva_rebsol) {
        try {
            // La cita existe, proceder a eliminarla
            $sql_delete = "DELETE FROM citas WHERE id_horario = :id_horario AND id = :id_reserva";
            $delete_query = $this->db->connect()->prepare($sql_delete);
            $delete_query->bindParam(':id_horario', $id_horario);
            $delete_query->bindParam(':id_reserva', $id_reserva);
            if ($delete_query->execute()){
                // echo "<pre>";
                // var_dump('DELETE FROM citas ejecutada con exito');
                // echo "</pre>";
                // exit();
                // Actualizar horarios a 'disponibles'
                $update_sql = "UPDATE horarios
                                SET 
                                    estado = CASE 
                                                WHEN estado = 'ocupado' AND sobre_cupo != 'ocupado' THEN 'disponible'
                                                ELSE estado
                                            END,
                                    sobre_cupo = CASE 
                                                    WHEN estado = 'ocupado' AND sobre_cupo = 'ocupado' THEN 'disponible'
                                                    ELSE sobre_cupo
                                                END
                                WHERE id = :id_horario ";

                $update_query = $this->db->connect()->prepare($update_sql);
                $update_query->bindParam(':id_horario', $id_horario);



                // Eliminar el estado del horario
                // $update_sql = "UPDATE horarios SET estado = 'disponible' WHERE id = :id_horario";
                // $update_query = $this->db->connect()->prepare($update_sql);
                // $update_query->bindParam(':id_horario', $id_horario);
                // $update_query->execute();
                if( $update_query->execute()){
                    //Anular reserva en rebsol
                    // 'id' => $cod_reserva_rebsol
                    $data_anular_reserva = [
                        'estado_cita' => 2,
                        'sucursal' => 1,
                        'id' => $cod_reserva_rebsol
                    ];

                    // return true;
                    // echo "<pre>";
                    // var_dump('Parametros de envio anular reserva');
                    // var_dump($data_anular_reserva);
                    // echo "</pre>";

                    $resultado = $this->llamarApi("citas","PUT",$data_anular_reserva);
                    $succes =  $resultado['success'];
                    // echo "<pre>";
                    // var_dump('resultado anular');
                    // var_dump($resultado);
                    // echo "</pre>";
                    // exit();
                   
                    if($succes){
                        return true; // Éxito al anular la reserva en rebsol
                    }else{
                        error_log("Error al anular la reserva en rebsol: " .  $resultado['error']);
                    }
                   

                }else{
                    error_log("Error al actualizar horarios a 'disponibles': " . $update_query->errorInfo()[2]);
                }
                
               
            } else {
                error_log("Error al eliminar la cita: " . $update_query->errorInfo()[2]);
                return false; // Fallo al eliminar la cita
            }
           
    
        } catch (PDOException $e) {
            // Manejar el error de la excepción
            error_log("Error al eliminar la cita: " . $e->getMessage());
            return false;
        }
    }



    public function getregistros($s){
        try{
           if ($s==null){ 
               $query=$this->db->connect()->query("SELECT count(*) as son FROM citas");
           }else{
               $query=$this->db->connect()->query("SELECT count(*) as son FROM citas WHERE id=".$s);                               
           }
            while($row=$query->fetch()){
                 $cuantos    = $row['son'];
                  }
           return $cuantos;
        }catch(PDOException $e){
            return [];
        }
    }


    public function update_reserva_agenda($data) {
        try {
            // echo "<pre>";
            // var_dump('Actualizar reserva');
            // var_dump($data);
            // echo "</pre>";
    
            // Buscar cita con el ID proporcionado
            $respuesta = $this->buscar_cita($data["id_reserva"]);
            if (empty($respuesta)) {
                throw new Exception("No se encontró la cita con el ID proporcionado.");
            }
    
            // echo "<pre>";
            // var_dump('Resultado buscar cita');
            // var_dump($respuesta);
            // echo "</pre>";
    
            // Preparar comparación
            $cambios = [];
    
            if (!empty($respuesta) && isset($respuesta[0])) {
                $registro_actual = $respuesta[0];
    
                // Comparar cada campo relevante
                $mapa_claves = [
                    'rut_p' => 'rut',
                    'nombre_p' => 'nombre',
                    'apellido_1p' => 'apellido1',
                    'apellido_2p' => 'apellido2',
                    'fecha_nac_p' => 'fecha_nacimiento',
                    'direccion_p' => 'direccion',
                    'fono_1p' => 'telefono',
                    'fono_2p' => 'telefono2',
                    'email_p' => 'email',
                    'genero' => 'sexo',
                    'centro_derivado_p' => 'centro',
                    'observacion' => 'observacion',
                ];
    
                foreach ($mapa_claves as $clave_data => $clave_respuesta) {
                    if (isset($data[$clave_data]) && isset($registro_actual[$clave_respuesta])) {
                        $valor_data = trim($data[$clave_data]);
                        $valor_respuesta = trim($registro_actual[$clave_respuesta]);
    
                        // Comparar valores
                        if ($valor_data != $valor_respuesta) {
                            $cambios[$clave_data] = [
                                'campo' => $clave_data,
                                'valor_anterior' => $valor_respuesta,
                                'valor_nuevo' => $valor_data,
                            ];
                        }
                    }
                }
            }
    
            // // Mostrar cambios detectados
            // echo "<pre>";
            // var_dump('Cambios detectados:');
            // var_dump($cambios);
            // echo "</pre>";
    
            // Si no hay cambios, no hacemos nada
            if (empty($cambios)) {
                return "No hay cambios para actualizar.";
            }
    
            // Construir la consulta UPDATE dinámicamente
            $set_clause = [];
            foreach ($cambios as $campo_formulario => $detalles) {
                // Buscar el nombre de la columna en la base de datos según el mapeo
                if (isset($mapa_claves[$campo_formulario])) {
                    $nombre_columna = $mapa_claves[$campo_formulario];
                    // Agregar la cláusula SET al array usando el nombre del campo del formulario como parámetro
                    $set_clause[] = "$nombre_columna = :$campo_formulario";
                }
            }
    
            $set_clause = implode(", ", $set_clause);
            $sql = "UPDATE citas SET $set_clause WHERE id = :id";
    
            // echo "<pre>";
            // var_dump('SQL generado:');
            // var_dump($sql);
            // echo "</pre>";
    
            // Preparar y ejecutar la consulta
            $stmt = $this->db->connect()->prepare($sql);
    
            // Asignar valores a los parámetros
            foreach ($cambios as $campo_formulario => $detalles) {
                $stmt->bindValue(":$campo_formulario", $detalles['valor_nuevo']);
            }
    
            // Asignar el ID de la reserva
            $id_reserva = $data['id_reserva'];
            $stmt->bindValue(":id", $id_reserva, PDO::PARAM_INT);
    
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            return "Error al actualizar el registro: " . $e->getMessage();
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }


    public function buscar_cita($id_reserva){
        try{
            $items = [];
            $query=$this->db->connect()->query("SELECT * FROM citas WHERE id = '$id_reserva'");
            while($row=$query->fetch()){
                $item["id"] = $row['id'];
                $item["codigo_reserva_atencion_rebsol"] = $row['codigo_reserva_atencion_rebsol'];
                $item["rut"] = $row['rut'];
                $item["nombre"] = $row['nombre'];
                $item["apellido1"] = $row['apellido1'];
                $item["apellido2"] = $row['apellido2'];
                $item["fecha_nacimiento"] = $row['fecha_nacimiento'];
                $item["sexo"] = $row['sexo'];
                $item["direccion"] = $row['direccion'];
                $item["telefono"] = $row['telefono'];
                $item["telefono2"] = $row['telefono2'];
                $item["email"] = $row['email'];
                $item["centro"] = $row['centro'];
                $item["id_medico"] = $row['id_medico'];
                $item["nombre_medico"] = $row['nombre_medico'];
                $item["observacion"] = $row['observacion'];
                array_push( $items, $item );
            }
            return $items;
           
        }catch(PDOException $e){
            return [];
        }
    }




    public function getpag($iniciar, $autoporpag, $s, $fecha, $fecha_) {
        $items = [];
        try {
           

            // Inicia la consulta base
            $query = "SELECT c.*, h.fecha, h.hora_inicio, h.hora_fin 
            FROM citas c 
            JOIN horarios h ON c.id_horario = h.id";

            // Condiciones adicionales
            $conditions = [];
            if (!empty($s)) {
            $conditions[] = "c.rut = '$s'" ;
            }
            if (!empty($fecha) && empty($fecha_hasta)) {
            // Solo filtra por una fecha específica
            $conditions[] = "date(h.fecha) = '$fecha'";
            } elseif (!empty($fecha) && !empty($fecha_hasta)) {
            // Filtra por rango de fechas
            $conditions[] = "date(h.fecha) BETWEEN '$fecha' AND '$fecha_hasta'";
            }

            // Combina las condiciones con la cláusula WHERE si existen
            if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
            }

            // Orden y límite
            $query .= " ORDER BY c.id LIMIT $iniciar, $autoporpag";
    
            // Ejecuta la consulta
            $stmt = $this->db->connect()->query($query);
          
            // Itera sobre los resultados
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $item = [
                    "id" => $row['id'],
                    "rut" => $row['rut'],
                    "nombre" => $row['nombre'],
                    "apellido1" => $row['apellido1'],
                    "apellido2" => $row['apellido2'],
                    "fecha_nacimiento" => $row['fecha_nacimiento'],
                    "sexo" => $row['sexo'],
                    "direccion" => $row['direccion'],
                    "telefono" => $row['telefono'],
                    "telefono2" => $row['telefono2'],
                    "email" => $row['email'],
                    "prevision" => $row['prevision'],
                    "sucursal" => $row['sucursal'],
                    "centro" => $row['centro'],
                    "id_medico" => $row['id_medico'],
                    "nombre_medico" => $row['nombre_medico'],
                    "usuario_agenda" => $row['usuario_agenda'],
                    "observacion" => $row['observacion'],
                    "id_horario" => $row['id_horario'],
                    "fecha" => $row['fecha'],
                    "hora_inicio" => $row['hora_inicio'],
                    "hora_fin" => $row['hora_fin'], // Campo adicional de la tabla horarios
                ];

                array_push($items, $item);
            }
            return $items;
        } catch (PDOException $e) {
            return [];
        }
    }





    //CARGA DE RESERVAS AGENDADAS DE REBSOL PACIENTE CDS --------------------------------------------------------------------------------------

    // cargar paciente agendados 10-12-2024
    public function get_sincronizar_agenda_rs() {
        try {

            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }

            $resultado = $this->llamarApi("pacientes_agendados_CDS","GET");
            $reservas_cds = $resultado['reservas_cds'];
            // echo "<pre>";
            // var_dump('pacientes_agendados_CDS');
            // var_dump($reservas_cds);
            // echo "</pre>";
            // exit();
            if (isset($reservas_cds) && is_array($reservas_cds)) {
                // $count = 0;
                foreach ($reservas_cds as $reserva) {

                    // valores para insertar datos a la tabla bloque_horario_medico CDS
                    $id_bloque_medico_rs = $reserva['id_bloque_horario_medico'];
                    $dia = $reserva['dia'];
                    $fecha_desde = $reserva['fecha_desde'];
                    $fecha_hasta = $reserva['fecha_hasta'];
                    $hora_inicio = $reserva['hora_inicio'];
                    $hora_termino = $reserva['hora_termino'];
                    $duracion_consulta = $reserva['duracion_consulta'];
                    $duracion_consulta = $reserva['duracion_consulta'];
                    $rut_profesional = $reserva['rut_profesional'];
                    $rut_profesional = $this->formatearRutConDV($rut_profesional);
                    $id_medico_cds = $this->obtenerIdMedicoPorRut($rut_profesional);

                    $arreglo_bloque_medico = array(
                        'id_bloque_medico_rs' => $id_bloque_medico_rs,
                        'dia' => $dia,
                        'fecha_desde' => $fecha_desde,
                        'fecha_hasta' => $fecha_hasta,
                        'hora_inicio' => $hora_inicio,
                        'hora_termino' => $hora_termino,
                        'duracion_consulta' => $duracion_consulta,
                        'id_medico_cds' => $id_medico_cds
                    );

                    //existe bloque medico 
                    $existe_bloque_medico_rs = $this->existeBloqueMedico($id_bloque_medico_rs);
                    // Validar si el bloque médico existe
                    if ($existe_bloque_medico_rs !== 0) {
                        $id_bloque_medico_cds = $existe_bloque_medico_rs;
                    } else {
                        $id_bloque_medico_cds = $this->insertBloqueMedico($arreglo_bloque_medico);
                        
                    }

                    // valores para insertar datos a la tabla  horarios CDS
                    $id_horario_consulta_rs = $reserva['id_horario_consulta'];
                    $fecha_inicio_horario = $reserva['fecha_inicio_horario'];
                    $fecha_termino_horario = $reserva['fecha_termino_horario'];
                    $hora_inicio = $reserva['hora_inicio_horario'];
                    $hora_termino = $reserva['hora_termino_horario'];
                    $duracion_consulta = $reserva['duracion_consulta'];

                    $arreglo_horarios_medico = array(
                        'id_horario_consulta_rs' => $id_horario_consulta_rs,
                        'fecha_inicio_horario' => $fecha_inicio_horario,
                        'fecha_termino_horario' => $fecha_termino_horario,
                        'hora_inicio' => $hora_inicio,
                        'hora_termino' => $hora_termino,
                        'duracion_consulta' => $duracion_consulta,
                        'id_bloque_medico_cds' => $id_bloque_medico_cds
                    );

                    //existe horario medico 
                    $existe_horario_medico_rs = $this->existeHorarioMedico($id_horario_consulta_rs);
                    if ($existe_horario_medico_rs !== 0) {
                        $id_horario_medico_cds = $existe_horario_medico_rs;
                    } else {
                        $id_horario_medico_cds = $this->insertHorarioMedico($arreglo_horarios_medico);
                        // echo "<pre>";
                        // var_dump('ultimo id bloque medico y horario');
                        // var_dump($id_bloque_medico_cds);
                        // var_dump($id_horario_medico_cds);
                        // echo "</pre>";
                        // exit();
                        
                    }

                    // valores para insertar datos a la tabla  citas CDS
                    $codigo_reserva_atencion_rs = $reserva['codigo_reserva_atencion'];
                    $rut_paciente = $reserva['rut_pnatural'];
                    $rut_paciente = $this->formatearRutConDV($rut_paciente);
                    $nombres = $reserva['nombres'];
                    $apellido_paterno = $reserva['apellido_paterno'];
                    $apellido_materno = $reserva['apellido_materno'];
                    $sexo = $reserva['sexo'];
                    $telefono1 = $reserva['telefono1'];
                    $telefono2 = $reserva['telefono2'];
                    $direccion = $reserva['direccion'];
                    $fecha_nacimiento = $reserva['fecha_nacimiento'];
                    $correo_electronico = $reserva['correo_electronico'];
                    $prevision = 'CDS PROVIDENCIA';
                    $sucursal = 1;
                    $centro = '';
                    // $id_medico_cds = $id_medico_cds;
                    // $id_horario_medico_cds = $id_horario_medico_cds;
                    $med_nombre = $reserva['med_nombre'];

                    $arreglo_hreserva = array(
                        'codigo_reserva_atencion_rs' => $codigo_reserva_atencion_rs,
                        'codigo_estado_reserva' => $reserva['codigo_estado_reserva'],
                        'rut_paciente' => $rut_paciente,
                        'nombres' => $nombres,
                        'apellido_paterno' => $apellido_paterno,
                        'apellido_materno' => $apellido_materno,
                        'sexo' => $sexo,
                        'telefono1' => $telefono1,
                        'telefono2' => $telefono2,
                        'direccion' => $direccion,
                        'fecha_nacimiento' => $fecha_nacimiento,
                        'correo_electronico' => $correo_electronico,
                        'prevision' => $prevision,
                        'sucursal' => $sucursal,
                        'centro' => $centro,
                        'id_medico_cds' => $id_medico_cds,
                        'med_nombre' => $med_nombre,
                        'id_horario_medico_cds' => $id_horario_medico_cds,
                    );

                   //existe reserva  
                   $existe_reserva_rs = $this->existeReserva($codigo_reserva_atencion_rs);
                   if ($existe_reserva_rs !== 0) {
                       //ACTUALIZAR ESTADO DE LA RESERVA 
                       $this->actualizarReserva($codigo_reserva_atencion_rs, $reserva['codigo_estado_reserva']); 
                       continue;

                       //________________________________________________________________
                       // VALIDA SI LA RESERVA FUE ANULADA 
                       // if($reserva['codigo_estado_reserva'] == 0){
                       //     // //ELIMINA LA RESERVA FUE ANULADA
                       //     // $this->eliminarReserva($codigo_reserva_atencion_rs);
                       //     // continue;
                       // }

                   } else {
                       $id_horario_medico_cds = $this->insertReserva($arreglo_hreserva);
                      
                   }
                    
                   
                }
                // echo "Cantidad de registro: " . $count . "<br>";
            } else {
                echo "No hay reservas disponibles o el arreglo no es válido.";
            }
            return true;
            // Lógica del método
        } catch (PDOException $e) {
            // Obtener el mensaje de error de la excepción
            $mensaje_error = "Error al sincronizar rebsol: " . $e->getMessage();
            registrar_log($mensaje_error, $log_file);
            return null;
        }
    }



    function formatearRutConDV($rut) {
        // Asegúrate de que el RUT sea numérico
        if (!is_numeric($rut)) {
            return "El RUT debe ser numérico.";
        }
    
        // Cálculo del dígito verificador
        $suma = 0;
        $factor = 2;
    
        // Recorre el RUT desde el último dígito hacia el primero
        for ($i = strlen($rut) - 1; $i >= 0; $i--) {
            $suma += $rut[$i] * $factor;
            $factor = $factor == 7 ? 2 : $factor + 1;
        }
    
        $resto = $suma % 11;
        $dv = 11 - $resto;
    
        // Determina el DV
        if ($dv == 11) {
            $dv = '0';
        } elseif ($dv == 10) {
            $dv = 'K';
        }
    
        // Retorna el RUT con el formato correcto
        return $rut . '-' . $dv;
    }





    function obtenerIdMedicoPorRut($rutMedico) {
        try {

            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }


            // Sanear el valor del rut (para evitar inyección SQL)
            $rutMedico = htmlspecialchars($rutMedico, ENT_QUOTES, 'UTF-8');
        
            // Crear la consulta SQL con el rut directamente
            $query = "SELECT id FROM medicos WHERE rut = '$rutMedico'";
            // Preparar la consulta
            $stmt = $this->db->connect()->prepare($query);
        
            // Ejecutar la consulta
            $stmt->execute();
        
            // Obtener el resultado
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Verificar si se encontró un registro y retornar el ID
            return $resultado ? $resultado['id'] : null;

        } catch (Exception $e) {
            // Obtener información del error de PDOStatement
            $errorInfo = $stmt->errorInfo(); 
            // Crear un mensaje de error detallado
            $mensaje_error = "Error al obtener el ID del médico: " . ($errorInfo[2] ?? $e->getMessage());
            registrar_log($mensaje_error, $log_file);
            return null;
        }
    }




    function existeBloqueMedico($id_bloque_medico_rs) {
        try {
            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }


            // Sanear el valor de la entrada
            $idBloqueMedicoRebsol = (int)$id_bloque_medico_rs;
            $query = "SELECT id FROM bloque_horario_medico WHERE id_bloque_medico_rebsol = :idBloque";
            // Preparar la consulta
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':idBloque', $idBloqueMedicoRebsol, PDO::PARAM_INT);
        
            // Ejecutar la consulta
            $stmt->execute();
        
            // Verificar si se encontró un registro
            if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return $resultado['id']; // Retorna el id encontrado
            } else {
                // Si no existe, retornar 0
                return 0;
            }
        } catch (Exception $e) {
            // Obtener información del error de PDOStatement
            $errorInfo = $stmt->errorInfo(); 
            // Crear un mensaje de error detallado
            $mensaje_error = "Error al validar la existencia del bloque horario médico: " . ($errorInfo[2] ?? $e->getMessage());
            registrar_log($mensaje_error, $log_file);
            return 0;
        }
    }



    function existeHorarioMedico($id_horario_consulta_rs) {
        try {
            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }


           
            $idHorarioMedicoRebsol = (int)$id_horario_consulta_rs;
            $query = "SELECT * FROM horarios WHERE id_horario_rebsol = :idHorario";
            // Preparar la consulta
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':idHorario', $idHorarioMedicoRebsol, PDO::PARAM_INT);
        
            // Ejecutar la consulta
            $stmt->execute();
        
           // Verificar si se encontró un registro
           if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return $resultado['id']; // Retorna el id encontrado
            } else {
                // Si no existe, retornar 0
                return 0;
            }

        } catch (Exception $e) {
            // Obtener información del error de PDOStatement
            $errorInfo = $stmt->errorInfo(); 
            // Crear un mensaje de error detallado
            $mensaje_error = "Error al validar la existencia horario médico: " . ($errorInfo[2] ?? $e->getMessage());
            registrar_log($mensaje_error, $log_file);
            return 0;
        }
    }



    function existeReserva($codigo_reserva_atencion_rs) {
        try {
            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }

            $codigo_reserva_atencion_rs = (int)$codigo_reserva_atencion_rs;
            $query = "SELECT * FROM citas WHERE codigo_reserva_atencion_rebsol = :codigo_reserva_atencion_rebsol";
            // Preparar la consulta
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':codigo_reserva_atencion_rebsol', $codigo_reserva_atencion_rs, PDO::PARAM_INT);
        
            // Ejecutar la consulta
            $stmt->execute();
        
           // Verificar si se encontró un registro
           if ($stmt->rowCount() > 0) {
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
                return $resultado['id']; // Retorna el id encontrado
            } else {
                // Si no existe, retornar 0
                return 0;
            }
        } catch (Exception $e) {
            // Obtener información del error de PDOStatement
            $errorInfo = $stmt->errorInfo(); 
            // Crear un mensaje de error detallado
            $mensaje_error = "Error al validar la existencia la reserva: " . ($errorInfo[2] ?? $e->getMessage());
            registrar_log($mensaje_error, $log_file);
            return 0;
        }
    }


    //AGREGADO 08-01-2025  ACTUALIZA ESTADO DE LA RESERVA  ACTIVA O ANULADA
    function actualizarReserva($codigo_reserva_atencion_rs, $codigo_estado_reserva) {
        try {
           
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
           
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }

            // if($codigo_reserva_atencion_rs == '1848140'){
            //     echo "<pre>";
            //     var_dump('actualizarReserva');
            //     var_dump($codigo_reserva_atencion_rs);
            //     var_dump($codigo_estado_reserva);
            //     echo "</pre>";
            //     exit();

            // }

            
    
            
            $codigo_reserva_atencion_rs = (int)$codigo_reserva_atencion_rs;
            $codigo_estado_reserva = (int)$codigo_estado_reserva;
    
           
            $sql = "UPDATE citas 
                    SET codigo_estado_reserva = :codigo_estado_reserva 
                    WHERE codigo_reserva_atencion_rebsol = :codigo_reserva_atencion_rebsol";
    
            
            $stmt = $this->db->connect()->prepare($sql);
            $stmt->bindParam(':codigo_reserva_atencion_rebsol', $codigo_reserva_atencion_rs);
            $stmt->bindParam(':codigo_estado_reserva', $codigo_estado_reserva);
            $stmt->execute();
    
           
            if ($stmt->rowCount() > 0) {
                return true; 
            } else {
                // Registrar en el log si no se encontró el código
                // registrar_log("No se encontró la reserva con código: $codigo_reserva_atencion_rs para actualizar.", $log_file);
                return false;
            }
        } catch (Exception $e) {
            // Manejar errores y registrar en el log
            $errorInfo = $stmt->errorInfo();
            $mensaje_error = "Error al actualizar la reserva: " . ($errorInfo[2] ?? $e->getMessage());
            registrar_log($mensaje_error, $log_file);
            return false;
        }
    }



    // function eliminarReserva($codigo_reserva_atencion_rs) {
    //     try {
            
    //         $log_dir = __DIR__ . '/../logs';
    //         $fecha_actual = date('Y-m-d');
    //         $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
           
    //         if (!is_dir($log_dir)) {
    //             mkdir($log_dir, 0777, true);
    //         }
    
            
    //         if (!file_exists($log_file)) {
    //             file_put_contents($log_file, '');
    //         }
    
    //         $codigo_reserva_atencion_rs = (int)$codigo_reserva_atencion_rs;
    //         $query = "DELETE FROM citas WHERE codigo_reserva_atencion_rebsol = :codigo_reserva_atencion_rebsol";
    //         $stmt = $this->db->connect()->prepare($query);
    //         $stmt->bindParam(':codigo_reserva_atencion_rebsol', $codigo_reserva_atencion_rs, PDO::PARAM_INT);
    //         $stmt->execute();
    
    //         if ($stmt->rowCount() > 0) {
    //             return true; 
    //         } else {
    //             // Si no se encontró ninguna reserva para eliminar
    //             registrar_log("No se encontró la reserva con código: $codigo_reserva_atencion_rs", $log_file);
    //             return false;
    //         }
    //     } catch (Exception $e) {
    //         $errorInfo = $stmt->errorInfo();
    //         $mensaje_error = "Error al eliminar la reserva: " . ($errorInfo[2] ?? $e->getMessage());
    //         registrar_log($mensaje_error, $log_file);
    //         return false;
    //     }
    // }





    
    function insertBloqueMedico($arreglo_bloque_medico){
        try {
            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }


            $id_bloque_medico_rs = $arreglo_bloque_medico['id_bloque_medico_rs']; 
            $dia = $arreglo_bloque_medico['dia']; 
            $fecha_desde = $arreglo_bloque_medico['fecha_desde']; 
            $fecha_hasta = $arreglo_bloque_medico['fecha_hasta']; 
            $hora_inicio = $arreglo_bloque_medico['hora_inicio']; 
            $hora_termino = $arreglo_bloque_medico['hora_termino']; 
            $duracion_consulta = $arreglo_bloque_medico['duracion_consulta']; 
            $id_medico_cds = $arreglo_bloque_medico['id_medico_cds']; 
    
            $sql = "INSERT INTO bloque_horario_medico (id_medico, dia, codigo_sucursal, fecha_desde, fecha_hasta, horario_inicio, horario_termino, duracion_consulta, usuario_registra, id_bloque_medico_rebsol, fecha_registro_bloque) 
                    VALUES (:id_medico, :dia, :codigo_sucursal, :fecha_desde, :fecha_hasta, :horario_inicio, :horario_termino, :duracion_consulta, :usuario_registra, :id_bloque_medico_rebsol, NOW())";
    
            // Conexión a la base de datos
            $dbConnection = $this->db->connect();
    
            // Preparar la sentencia
            $stmt = $dbConnection->prepare($sql);
    
            // Parametros
            $usuario = substr($_SESSION['rut'], 0, -2);
            $codigo_sucursal = 1;
    
            // Vincular los parámetros
            $stmt->bindParam(':id_medico', $id_medico_cds);
            $stmt->bindParam(':codigo_sucursal', $codigo_sucursal);
            $stmt->bindParam(':fecha_desde', $fecha_desde);
            $stmt->bindParam(':fecha_hasta', $fecha_hasta);
            $stmt->bindParam(':horario_inicio', $hora_inicio);
            $stmt->bindParam(':horario_termino', $hora_termino);
            $stmt->bindParam(':duracion_consulta', $duracion_consulta);
            $stmt->bindParam(':id_bloque_medico_rebsol', $id_bloque_medico_rs);
            $stmt->bindParam(':usuario_registra', $usuario); 
            $stmt->bindParam(':dia', $dia);
    
            // Ejecutar la sentencia
            if ($stmt->execute()) {
                // Obtener el último ID insertado
                $id_bloque_medico = $dbConnection->lastInsertId();
        
                // Retornar el último ID insertado
                return $id_bloque_medico;
                
            } else {
                // Si la consulta falló, manejar el error
                $errorInfo = $stmt->errorInfo(); 
                $mensaje_error = "Error al ejecutar la consulta: " . ($errorInfo[2] ?? "Información del error no disponible");
                
                // Registrar el error en el log
                registrar_log($mensaje_error, $log_file);

                // Retornar false para indicar el fallo
                return false;
            }
    
           
        } catch (Exception $e) {
            // Obtener información del error de PDOStatement
            $errorInfo = $stmt->errorInfo(); 
            // Crear un mensaje de error detallado
            $mensaje_error = "Error al insertar bloque horario médico: " . ($errorInfo[2] ?? $e->getMessage());
            registrar_log($mensaje_error, $log_file);
            return false;
        }
    }




    function insertHorarioMedico($arreglo_horarios_medico) {
        try {
            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }

            // Recibir valores del arreglo
            $id_horario_consulta_rs = $arreglo_horarios_medico['id_horario_consulta_rs']; 
            $fecha_inicio_horario = $arreglo_horarios_medico['fecha_inicio_horario']; 
            $fecha_termino_horario = $arreglo_horarios_medico['fecha_termino_horario']; 
            $hora_inicio = $arreglo_horarios_medico['hora_inicio']; 
            $hora_termino = $arreglo_horarios_medico['hora_termino']; 
            $duracion_consulta = $arreglo_horarios_medico['duracion_consulta']; 
            $id_bloque_medico_cds = $arreglo_horarios_medico['id_bloque_medico_cds']; 
    
            // Consulta SQL para insertar el horario médico
            $sql = "INSERT INTO horarios (id_horario_rebsol, fecha, fecha_hasta, hora_inicio, hora_fin, duracion_consulta, id_bloque_medico) 
                    VALUES (:id_horario_rebsol, :fecha, :fecha_hasta, :hora_inicio, :hora_fin, :duracion_consulta, :id_bloque_medico)";
    
            // Conexión a la base de datos
            $dbConnection = $this->db->connect();
    
            // Preparar la sentencia
            $stmt = $dbConnection->prepare($sql);
    
            // Vincular los parámetros
            $stmt->bindParam(':id_horario_rebsol', $id_horario_consulta_rs);
            $stmt->bindParam(':fecha', $fecha_inicio_horario);
            $stmt->bindParam(':fecha_hasta', $fecha_termino_horario);
            $stmt->bindParam(':hora_inicio', $hora_inicio);
            $stmt->bindParam(':hora_fin', $hora_termino);
            $stmt->bindParam(':duracion_consulta', $duracion_consulta);
            $stmt->bindParam(':id_bloque_medico', $id_bloque_medico_cds);
    
            // Ejecutar la sentencia
            if ($stmt->execute()) {
                // Obtener el último ID insertado
                $id_horario_medico = $dbConnection->lastInsertId();
        
                // Retornar el último ID insertado
                return $id_horario_medico;
                
            } else {
                // Si la consulta falló, manejar el error
                $errorInfo = $stmt->errorInfo(); 
                $mensaje_error = "Error al ejecutar la consulta: " . ($errorInfo[2] ?? "Información del error no disponible");
                
                // Registrar el error en el log
                registrar_log($mensaje_error, $log_file);

                // Retornar false para indicar el fallo
                return false;
            }
            

        } catch (Exception $e) {
             // Obtener información del error de PDOStatement
            $errorInfo = $stmt->errorInfo(); 
            // Crear un mensaje de error detallado
            $mensaje_error = "Error al insertar horario médico: " . ($errorInfo[2] ?? $e->getMessage());
            registrar_log($mensaje_error, $log_file);
            return false;
           
        }
    }





    function insertReserva($arreglo_hreserva) {
       
        try {

            // Definir ruta para los logs
            $log_dir = __DIR__ . '/../logs';
            $fecha_actual = date('Y-m-d');
            $log_file = $log_dir . "/errores_reservas_{$fecha_actual}.log";
    
            // Verificar y crear la carpeta de logs si no existe
            if (!is_dir($log_dir)) {
                mkdir($log_dir, 0777, true);
            }
    
            // Verificar y crear el archivo de log si no existe
            if (!file_exists($log_file)) {
                file_put_contents($log_file, '');
            }
    
            // // Función para registrar mensajes en el log
            // function registrar_log($mensaje, $log_file) {
            //     error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
            // }

            // Recibir valores del arreglo
            $codigo_reserva_atencion_rs = $arreglo_hreserva['codigo_reserva_atencion_rs']; 
            $codigo_estado_reserva = $arreglo_hreserva['codigo_estado_reserva']; 
            $rut_paciente = $arreglo_hreserva['rut_paciente']; 
            $nombres = $arreglo_hreserva['nombres']; 
            $apellido_paterno = $arreglo_hreserva['apellido_paterno']; 
            $apellido_materno = $arreglo_hreserva['apellido_materno']; 
            $sexo = $arreglo_hreserva['sexo']; 
            $telefono1 = $arreglo_hreserva['telefono1']; 
            $telefono2 = $arreglo_hreserva['telefono2']; 
            $direccion = $arreglo_hreserva['direccion']; 
            $fecha_nacimiento = $arreglo_hreserva['fecha_nacimiento']; 
            $correo_electronico = $arreglo_hreserva['correo_electronico']; 
            $prevision = $arreglo_hreserva['prevision']; 
            $sucursal = $arreglo_hreserva['sucursal']; 
            $centro = $arreglo_hreserva['centro']; 
            $id_medico_cds = $arreglo_hreserva['id_medico_cds']; 
            $med_nombre = $arreglo_hreserva['med_nombre']; 
            $id_horario_medico_cds = $arreglo_hreserva['id_horario_medico_cds']; 
           

            //Parametro
            $usuario = substr($_SESSION['rut'], 0, -2);
            $observacion = '';
    
            $dbConnection = $this->db->connect();

            // Preparar la consulta SQL
            $sql = "INSERT INTO citas (
                        codigo_reserva_atencion_rebsol, codigo_estado_reserva, rut, nombre, apellido1, apellido2, fecha_nacimiento, sexo, direccion, telefono, telefono2, email, prevision, sucursal, centro, id_medico, nombre_medico, usuario_agenda, observacion, id_horario
                    ) VALUES (
                        :codigo_reserva_atencion_rebsol,:codigo_estado_reserva, :rut, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :sexo, :direccion, :telefono, :telefono2, :email, :prevision, :sucursal, :centro, :id_medico, :nombre_medico, :usuario_agenda, :observacion, :id_horario
                    )";

            // Preparar la consulta
            $query = $dbConnection->prepare($sql);

            // Asignar los valores a los placeholders
            $query->bindParam(':codigo_reserva_atencion_rebsol', $arreglo_hreserva['codigo_reserva_atencion_rs']);
            $query->bindParam(':codigo_estado_reserva', $arreglo_hreserva['codigo_estado_reserva']);
            $query->bindParam(':rut', $arreglo_hreserva['rut_paciente']);
            $query->bindParam(':nombre', $arreglo_hreserva['nombres']);
            $query->bindParam(':apellido1', $arreglo_hreserva['apellido_paterno']);
            $query->bindParam(':apellido2', $arreglo_hreserva['apellido_materno']);
            $query->bindParam(':fecha_nacimiento', $arreglo_hreserva['fecha_nacimiento']);
            $query->bindParam(':sexo', $arreglo_hreserva['sexo']); 
            $query->bindParam(':direccion', $arreglo_hreserva['direccion']);
            $query->bindParam(':telefono', $arreglo_hreserva['telefono1']);
            $query->bindParam(':telefono2', $arreglo_hreserva['telefono2']); 
            $query->bindParam(':email', $arreglo_hreserva['correo_electronico']);
            $query->bindParam(':prevision', $arreglo_hreserva['prevision']); 
            $query->bindParam(':sucursal',$arreglo_hreserva['sucursal']); 
            $query->bindParam(':centro', $arreglo_hreserva['centro']); 
            $query->bindParam(':id_medico', $arreglo_hreserva['id_medico_cds']); 
            $query->bindParam(':nombre_medico', $arreglo_hreserva['med_nombre']); 
            $query->bindParam(':usuario_agenda', $usuario); 
            $query->bindParam(':observacion', $observacion); 
            $query->bindParam(':id_horario', $arreglo_hreserva['id_horario_medico_cds']);

            // Ejecutar la consulta
            if ($query->execute()) {
                
                // validar si el horarios esta disponible
                $select_sql = "SELECT * FROM horarios WHERE id =:id_horario AND estado = 'ocupado'";
                $select_query = $this->db->connect()->prepare($select_sql);
                $select_query->bindParam(':id_horario', $data["id_horario"]);
                $select_query->execute();
                // Verificar si la consulta ha devuelto resultados
                if ($select_query->rowCount() > 0) {
                    // El horario está ocupado registra sobre cupo
                    $update_cupo_sql = "UPDATE horarios SET sobre_cupo = 'ocupado' WHERE id = :id_horario";
                    $update_cupo_query = $this->db->connect()->prepare($update_cupo_sql);
                    $update_cupo_query->bindParam(':id_horario', $arreglo_hreserva['id_horario_medico_cds']);
                    $update_cupo_query->execute();
                   
                }

                 // Actualizar el estado del horario
                 $update_sql = "UPDATE horarios SET estado = 'ocupado' WHERE id = :id_horario";
                 $update_query = $this->db->connect()->prepare($update_sql);
                 $update_query->bindParam(':id_horario', $arreglo_hreserva['id_horario_medico_cds']);
 

                if($update_query->execute()){
                    return true; 

                }else{
                    $errorInfo = $update_query->errorInfo();
                    $mensaje_error = "Error al alctualizar estado horarios: " . $errorInfo[2];
                    // echo $mensaje_error;
                    registrar_log($mensaje_error, $log_file);
                    return false; 
                }

            } else {
                // Imprimir y registrar error al insertar
                $errorInfo = $query->errorInfo();
                $mensaje_error = "Error al insertar agenda cds: " . $errorInfo[2];
                // echo $mensaje_error;
                registrar_log($mensaje_error, $log_file);
                return false; 
            }

        } catch (Exception $e) {
            // Manejo de errores
            error_log("Error al insertar reserva: " . $e->getMessage());
            return false;
        }
    }

    // FIN CARGA DE RESERVAS AGENDADAS DE REBSOL PACIENTE CDS ------------------------------------------------------------------------------------







    // ACCESO API ---------------------------------------------------------------------------------------------------------------------------------
    function llamarApi($endpoint, $metodo = 'GET', $data = null) {
        // // URL base de la API
        // $baseUrl = "http://186.64.123.171/ApiCitasCds/public/";
        // URL base de la API
        //Modificado por marcos 20-02-2025 para subir proyecto GIT 
        //Asi la api apunte correctamente a desarrollo o produccion.
        $baseUrl = constant('ApiCitasCds');
    
        // Inicializar cURL
        $ch = curl_init();
        
        // Configurar la URL completa
        $url = $baseUrl . $endpoint;
        curl_setopt($ch, CURLOPT_URL, $url);
        
        // Configurar el método
        if (strtoupper($metodo) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true); // Definir que es una petición POST
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Datos en formato JSON
        } elseif (strtoupper($metodo) === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
        } elseif (strtoupper($metodo) === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
            
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($metodo)); // Para otros métodos
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Enviar datos si no es NULL
            }
        }
    
        // Configurar opciones generales
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desactivar la verificación SSL
        
        // Headers
        $headers = [
            "Authorization: Bearer ef67c3bc52c879bf724afff06bcda380",
            "Content-Type: application/json"
        ];

        // Encabezados HTTP que serán enviados junto con la solicitud cURL para asegurar que la API reciba la información en el formato adecuado y con la autorización requerida.
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Esta línea desactiva la verificación del certificado del servidor al que se está haciendo la solicitud.
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    
        // Ejecutar la solicitud
        // $response = curl_exec($ch);
        $response = curl_exec($ch);

        // Imprime la respuesta para ver el contenido
        // echo "<pre>";
        // var_dump('imprime curl');
        // var_dump($response);
        // echo "</pre>";
        // exit();

        // Manejar errores
        if ($response === false) {
            echo "Error: " . curl_error($ch);
            return null;
        } else {
            // Retornar la respuesta decodificada
            return json_decode($response, true);
        }
    
        // Cerrar cURL
        curl_close($ch);
    }

    //FIN ACCESO API--------------------------------------------------------------------------------------------------------------------------------------------


   
}
?>
