<?php
//session_start();


class BloqueModel extends Model
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
            $query=$this->db->connect()->query("SELECT * FROM medicos ORDER BY nombre ASC   ");
        while($row=$query->fetch()){
                array_push( $items, $row );
                }
        return $items;
        }catch(PDOException $e){
            return [];
        }
    }


    public function insertarBloque($id_medico, $fecha, $fecha_hasta, $hora_inicio, $hora_fin, $duracion_consulta, $array_dias_select, $rut_medico) {
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
            if (!file_exists($log_file)){
                file_put_contents($log_file, '');
            }
    
            // Función para registrar mensajes en el log
            function registrar_log($mensaje, $log_file) {
                error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
            }
    
    
            // Arreglo asociativo de días
            $diasInt = [
                "lunes" => 1,
                "martes" => 2,
                "miércoles" => 3,
                "jueves" => 4,
                "viernes" => 5,
                "sábado" => 6,
                "domingo" => 7
            ];
    
            foreach ($array_dias_select as $dia) {
                if (array_key_exists($dia, $diasInt)) {
                    $valorDia = $diasInt[$dia];
                   
                    // Paso 1: Insertar en bloque_horario_medico DB agenda_cds
                    $sql = "INSERT INTO bloque_horario_medico (id_medico, dia, codigo_sucursal, fecha_desde, fecha_hasta, horario_inicio, horario_termino, duracion_consulta, usuario_registra, id_bloque_medico_rebsol, fecha_registro_bloque) 
                    VALUES (:id_medico, :dia, :codigo_sucursal, :fecha_desde, :fecha_hasta, :horario_inicio, :horario_termino, :duracion_consulta, :usuario_registra, 0, NOW())";
            

                    //Parametro
                    $usuario = substr($_SESSION['rut'], 0, -2);
                    // Conexión a la base de datos
                    $dbConnection = $this->db->connect();

                    // Preparar la sentencia
                    $stmt = $dbConnection->prepare($sql);

                    // $stmt = $this->db->connect()->prepare($sql);
                    $codigo_sucursal = 1;
                    // Variable para almacenar el último ID insertado
                    $id_bloque_medico = null;

                    // Preparar los parámetros comunes
                    $stmt->bindParam(':id_medico', $id_medico);
                    $stmt->bindParam(':codigo_sucursal', $codigo_sucursal);
                    $stmt->bindParam(':fecha_desde', $fecha);
                    $stmt->bindParam(':fecha_hasta', $fecha_hasta);
                    $stmt->bindParam(':horario_inicio', $hora_inicio);
                    $stmt->bindParam(':horario_termino', $hora_fin);
                    $stmt->bindParam(':duracion_consulta', $duracion_consulta);
                    $stmt->bindParam(':usuario_registra',  $usuario); 
                    $stmt->bindParam(':dia', $valorDia);

    
                    // Ejecutar la consulta para cada día
                    if ($stmt->execute()) {
                        $id_bloque_medico = $dbConnection->lastInsertId();
                        // echo"<pre>";
                        // var_dump($id_bloque_medico);
                        // echo"<pre>";
                        // exit();

                        $data = [
                            "rut_profesional" => $rut_medico,
                            "dia" => $valorDia,
                            "lugar_atencion" => 1,
                            "fecha_desde" => $fecha,
                            "fecha_hasta" => $fecha_hasta,
                            "hora_inicio" => $hora_inicio,
                            "hora_termino" => $hora_fin,
                            "codigo_estado" => 1,
                            "duracion_consulta" => $duracion_consulta,
                            'usuario' => $usuario
                        ];

                        // Paso 2: Uso de la api (ApiCitasCds)
                        // Insertar Bloque Medico en rebsol
                        $resultado = $this->llamarApi("bloque_medico","POST",$data);
                        
                        if ($resultado){
                            $id_bloque_medico_rebsol = $resultado['id_bloque_horario_medico'];

                            // Definir la sentencia SQL para actualizar e incorporar el id bloque medico obtenido desde rebsol
                            // a bloque_horario_medico de DB agenda_cds
                            $sqlUpdate = "UPDATE bloque_horario_medico 
                            SET id_bloque_medico_rebsol = :id_bloque_medico_rebsol 
                            WHERE id = :id_bloque_horario_medico";

                            // Conexión a la base de datos
                            $dbConnection = $this->db->connect();
                            $stmtUpdate = $dbConnection->prepare($sqlUpdate);
                            $stmtUpdate->bindParam(':id_bloque_medico_rebsol', $id_bloque_medico_rebsol);
                            $stmtUpdate->bindParam(':id_bloque_horario_medico', $id_bloque_medico);

                            // Ejecutar la sentencia
                            if ($stmtUpdate->execute()) {
                                // Paso 3: Insertar en horarios
                                // Convertir fechas a formato DateTime
                                $fecha_inicio = new DateTime($fecha);
                                $fecha_final = new DateTime($fecha_hasta);
                            
                                // Convertir horas de inicio y fin a objetos DateTime
                                $hora_inicio_dt = new DateTime($hora_inicio);
                                $hora_fin_dt = new DateTime($hora_fin);

                                
                                $sql = "INSERT INTO horarios (fecha, fecha_hasta, hora_inicio, hora_fin, duracion_consulta, id_bloque_medico) 
                                VALUES (:fecha, :fecha_hasta, :hora_inicio, :hora_fin, :duracion_consulta, :id_bloque_medico)";
                                $stmtHorario = $this->db->connect()->prepare($sql);
                                
                                $baneraHorarios = false;
                                // Recorrer cada día en el rango de fechas
                                while ($fecha_inicio <= $fecha_final) {
                                    // Obtener el nombre del día actual
                                    $nombre_dia_actual = strtolower($fecha_inicio->format('l')); // 'l' devuelve el nombre del día (en inglés)
                                    
                                    // Traducir el nombre del día de inglés a español
                                    $dias_semana = array(
                                        'monday' => 'lunes',
                                        'tuesday' => 'martes',
                                        'wednesday' => 'miércoles',
                                        'thursday' => 'jueves',
                                        'friday' => 'viernes',
                                        'saturday' => 'sábado',
                                        'sunday' => 'domingo'
                                    );
                                    $nombre_dia_actual_es = $dias_semana[$nombre_dia_actual];
                                    
                                    if ($nombre_dia_actual_es === $dia) {
                                        $fecha_actual = $fecha_inicio->format('Y-m-d');
                                        $hora_actual_dt = clone $hora_inicio_dt;
                            
                                        // Bucle para generar bloques horarios por cada intervalo de tiempo
                                        while ($hora_actual_dt < $hora_fin_dt) {
                                            $hora_fin_bloque = clone $hora_actual_dt;
                                            $hora_fin_bloque->modify('+' . $duracion_consulta . ' minutes');
                            
                                            if ($hora_fin_bloque > $hora_fin_dt) {
                                                continue;
                                            }
                            
                                            // Guardar los resultados de las funciones en variables antes de pasarlas a bindParam
                                            $hora_inicio_formateada = $hora_actual_dt->format('H:i');
                                            $hora_fin_formateada = $hora_fin_bloque->format('H:i');


                                            // Guardar los resultados para enviarlo a la API, para insertar horarios en rebsol 
                                            $bloques_horarios [] = [
                                                'fecha' => $fecha_actual,
                                                'fecha_hasta' => $fecha_actual,
                                                'hora_inicio' => $hora_inicio_formateada,
                                                'hora_fin' => $hora_fin_formateada,
                                                'duracion_consulta' => $duracion_consulta,
                                                'id_bloque_medico' => $id_bloque_medico_rebsol,
                                                'rut_profesional' => $rut_medico,
                                                'usuario' => $usuario
                                            ];
                            
                                            // Vincular los parámetros a la sentencia preparada
                                            $stmtHorario->bindParam(':fecha', $fecha_actual);
                                            $stmtHorario->bindParam(':fecha_hasta', $fecha_actual);
                                            $stmtHorario->bindParam(':hora_inicio', $hora_inicio_formateada);
                                            $stmtHorario->bindParam(':hora_fin', $hora_fin_formateada);
                                            $stmtHorario->bindParam(':duracion_consulta', $duracion_consulta);
                                            $stmtHorario->bindParam(':id_bloque_medico', $id_bloque_medico);

                                        
                                            // Ejecutar la consulta
                                            if (!$stmtHorario->execute()) {

                                                // error_log("Error al insertar el bloque: " . implode(", ", $stmtHorario->errorInfo()));
                                                $mensaje =  error_log("Error al insertar el bloque: " . implode(", ", $stmtHorario->errorInfo()));
                                                registrar_log($mensaje, $log_file);
                                            }
                                            $baneraHorarios = true;
                            
                                            // Avanzar a la siguiente hora
                                            $hora_actual_dt->modify('+' . $duracion_consulta . ' minutes');
                                        }
                                    }
                            
                                    // Avanzar al siguiente día
                                    $fecha_inicio->modify('+1 day');
                                }

                                if($baneraHorarios == true) {
                                    // Paso 4: Insertar horarios en rebsol
                                    $resultado = $this->llamarApi("horarios_medicos","POST",$bloques_horarios);
                                    if (!$resultado){
                                        $mensaje =  error_log("Error al insertar horarios en rebsol : " . implode(", ", $stmtHorario->errorInfo()));
                                        registrar_log($mensaje, $log_file);
                                       

                                    }
                                    
                                }

                            
                            } else {
                                $mensaje =  error_log("Error al actualizar el registro bloque_horario_medico : " . implode(", ", $stmtUpdate->errorInfo()));
                                registrar_log($mensaje, $log_file);
                            }

                        }else{
                            $mensaje =  error_log("Error al insertar en bloque_horario_medico_rebsol : " . implode(", ", $resultado->errorInfo()));
                            registrar_log($mensaje, $log_file);
                        }
                       

                    } else {
                        $mensaje = "Error al insertar bloque_horario_medico: " . implode(", ", $stmt->errorInfo());
                        registrar_log($mensaje, $log_file);
                    }
                }
            }
            return true;
            
        } catch (PDOException $e) {
            $mensaje = sprintf(
                "Error en la inserción: %s. Código de error: %s.",
                $e->getMessage(),
                $e->getCode()
            );
            registrar_log($mensaje, $log_file);
            return false;
        }
    }




    function llamarApi($endpoint, $metodo = 'GET', $data = null) {

        // URL base de la API
        $baseUrl = "http://186.64.123.171/ApiCitasCds/public/";
    
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
        // echo "IMPRIMIR CURL";
        // echo "<pre>";
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
    

   
}
?>
