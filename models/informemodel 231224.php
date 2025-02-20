<?php
//session_start();
include_once 'public/PHPExcel.php';
include_once 'public/PHPExcel/Writer/Excel2007.php';

class InformeModel extends Model
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
            $query=$this->db->connect()->query("SELECT * FROM medicos ORDER BY id ");
        while($row=$query->fetch()){
                array_push( $items, $row );
                }
        return $items;
        }catch(PDOException $e){
            return [];
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



    public function get_pacientes_RS($iniciar,$autorizacionporpagina,$fecha, $fecha_hasta, $codigos_reserva_atencion_string){
        try {
            $data_agenda = [
                'iniciar' => $iniciar,
                'autorizacionporpagina' => $autorizacionporpagina,
                'fecha' => $fecha,
                'fecha_hasta' => $fecha_hasta,
                'codigos_reserva_atencion_string' => $codigos_reserva_atencion_string
            ];

            $resultado = $this->llamarApi("/pacientes_atendidos","GET",$data_agenda);
            // echo "<pre>";
            // var_dump('datos');
            // var_dump($resultado);
            // echo "</pre>";
            // exit();
            if($resultado){
                return $resultado;
            }else{
                return [];

            }
           
           
        } catch (PDOException $e) {
            return [];
        }
    }



    // public function get_pacientes_CDS($fecha, $fecha_hasta) {
    //     $items = [];
    //     try {
           

    //         // Inicia la consulta base
    //         $query = "SELECT c.*, h.fecha, h.hora_inicio, h.hora_fin 
    //         FROM citas c 
    //         JOIN horarios h ON c.id_horario = h.id";

    //         // Condiciones adicionales
    //         $conditions = [];

    //         // Verifica si las fechas están definidas y agrega las condiciones correspondientes
    //         if (!empty($fecha) && empty($fecha_hasta)) {
    //         // Solo filtra por una fecha específica
    //         $conditions[] = "DATE(h.fecha) = '$fecha'";
    //         } elseif (!empty($fecha) && !empty($fecha_hasta)) {
    //         // Filtra por rango de fechas
    //         $conditions[] = "DATE(h.fecha) BETWEEN '$fecha' AND '$fecha_hasta'";
    //         }

    //         // Agrega la condición para filtrar donde codigo_reserva_atencion_rebsol no sea NULL
    //         $conditions[] = "c.codigo_reserva_atencion_rebsol IS NOT NULL";

    //         // Combina las condiciones con la cláusula WHERE si existen
    //         if (!empty($conditions)) {
    //         $query .= " WHERE " . implode(" AND ", $conditions);
    //         }

    //         // Orden y límite
    //         $query .= " ORDER BY c.id";

    //         // echo "<pre>";
    //         // var_dump('datos get_pacientes_CDS');
    //         // var_dump($query);
    //         // echo "</pre>";
    //         // exit();
    
    //         // Ejecuta la consulta
    //         $stmt = $this->db->connect()->query($query);
          
    //         // Itera sobre los resultados
    //         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //              // Agrega cada valor al arreglo
    //             $items[] = $row['codigo_reserva_atencion_rebsol'];

    //             // array_push($items, $item);
    //         }
    //         // Convierte el arreglo en una cadena separada por comas
    //         $items_coma = implode(',', $items);
    //         // return $items;
    //         return $items_coma;
    //     } catch (PDOException $e) {
    //         return [];
    //     }
    // }



    //ACTUALIZADO 19-12-2024 PARA FILTRAR POR RUT DEL PACIENTE
    public function get_pacientes_CDS($rut, $fecha, $fecha_hasta) {
        $items = [];
        $items1 = [];
        try {
            // Inicia la consulta base
            $query = "SELECT c.*, h.fecha, h.hora_inicio, h.hora_fin 
                      FROM citas c 
                      JOIN horarios h ON c.id_horario = h.id";
    
            // Condiciones adicionales
            $conditions = [];
    
            // Verifica si el rut está definido y agrega la condición correspondiente
            if (!empty($rut)) {
                $conditions[] = "c.rut = '$rut'";
            }
    
            // Verifica si las fechas están definidas y agrega las condiciones correspondientes
            if (!empty($fecha) && empty($fecha_hasta)) {
                // Solo filtra por una fecha específica
                $conditions[] = "DATE(h.fecha) = '$fecha'";
            } elseif (!empty($fecha) && !empty($fecha_hasta)) {
                // Filtra por rango de fechas
                $conditions[] = "DATE(h.fecha) BETWEEN '$fecha' AND '$fecha_hasta'";
            }
    
            // Agrega la condición para filtrar donde codigo_reserva_atencion_rebsol no sea NULL
            $conditions[] = "c.codigo_reserva_atencion_rebsol IS NOT NULL";
    
            // Combina las condiciones con la cláusula WHERE si existen
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
    
            
            $query .= " ORDER BY c.id";

          
    
            $stmt = $this->db->connect()->query($query);
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Agrega cada valor al arreglo
                $items[] = $row['codigo_reserva_atencion_rebsol'];
    
                
            }
    
            // Convierte el arreglo en una cadena separada por comas
            $items_coma = implode(',', $items);
    
            
            return [
                'items_reserva' => $items_coma, // String separado por comas
            ];
    
        } catch (PDOException $e) {
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



    public function get_atenciones() {
        $items = [];
        try {
            $query ="   SELECT c.*, h.fecha, h.hora_inicio, h.hora_fin 
                        FROM citas c 
                        JOIN horarios h ON c.id_horario = h.id";

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
            // Captura de errores con un mensaje claro
            return ["error" => "Error en la consulta: " . $e->getMessage()];
        }

    }



    // public function get_reserva_agenda($id_horario, $id_reserva) {
    //     $items = [];
    
    //     try {
    //         // Verificar si $id_reserva no está vacío ni es null
    //         if (!empty($id_reserva)) {
    //             // Consulta con filtro por $id_reserva
    //             $sql = "SELECT * FROM citas WHERE id_horario = :id_horario AND id = :id_reserva ORDER BY id ASC";
    //             $query = $this->db->connect()->prepare($sql);
    //             $query->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
    //             $query->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
    //         } else {
    //             // Consulta solo con filtro por $id_horario
    //             $sql = "SELECT * FROM citas WHERE id_horario = :id_horario ORDER BY id ASC";
    //             $query = $this->db->connect()->prepare($sql);
    //             $query->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
    //         }
    
    //         // Ejecutar la consulta
    //         $query->execute();

           
    
    //         // Procesar los resultados
    //         while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    //             $item = [
    //                 "id" => $row['id'],
    //                 "codigo_reserva_atencion_rebsol" => $row['codigo_reserva_atencion_rebsol'],
    //                 "rut" => $row['rut'],
    //                 "nombre" => $row['nombre'],
    //                 "apellido1" => $row['apellido1'],
    //                 "apellido2" => $row['apellido2'],
    //                 "fecha_nacimiento" => $row['fecha_nacimiento'],
    //                 "sexo" => $row['sexo'],
    //                 "direccion" => $row['direccion'],
    //                 "telefono" => $row['telefono'],
    //                 "telefono2" => $row['telefono2'],
    //                 "email" => $row['email'],
    //                 "centro" => $row['centro'],
    //                 "id_medico" => $row['id_medico'],
    //                 "nombre_medico" => $row['nombre_medico'],
    //                 "observacion" => $row['observacion']
    //             ];
    //             array_push($items, $item);
    //         }
    
    //         return $items;
    //     } catch (PDOException $e) {
    //         // Captura de errores con un mensaje claro
    //         return ["error" => "Error en la consulta: " . $e->getMessage()];
    //     }
    // }



   

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
    
            // Función para registrar mensajes en el log
            function registrar_log($mensaje, $log_file) {
                error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
            }

          
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





    public function descargar_Excel_pacientes($datos_informe){
        ini_set('memory_limit', '2012M'); // Ajusta el valor según sea necesario
        set_time_limit(0); // Esto eliminará el límite de tiempo de ejecución
        try {
            // Convertir el segundo string (JSON) en un arreglo
            $data = json_decode($datos_informe, true);
            
            //$nombreProfesional = $data[0]['nombre_profesional'];
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setLastModifiedBy("IOPA");
            $objPHPExcel->getProperties()->setTitle("Empresas");
            $objPHPExcel->getProperties()->setSubject("EmpresasiOPA");
            
            $objPHPExcel->setActiveSheetIndex(0);
            $numDetalle = count($data);
            
            // ENCABEZADO EXCEL EN MAYÚSCULAS Y NEGRITA
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUT");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "PACIENTE");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "FECHA N");
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', "SEXO");
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', "CENTRO");
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', "N° ANTEOJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', "FECHA AGENDA");
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', "DIAGNÓSTICO");
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', "AGUDEZA VIZUAL");
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', "AGUDEZA VIZUAL SIN_COR");
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', "ESTADO");

             // Aplicar formato de negrita al encabezado
            $encabezadoEstilo = $objPHPExcel->getActiveSheet()->getStyle('A1:K1');
            $encabezadoFuente = $encabezadoEstilo->getFont();
            $encabezadoFuente->setBold(true);

            $fila = 2;
            $contador=0;
            for ($i = 0; $i < $numDetalle; $i++) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_pnatural']);
                // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_completo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, $data[$i]['nombres'].' ' .$data[$i]['apellido_paterno'].' '.$data[$i]['apellido_materno']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $data[$i]['fecha_nacimiento']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fila, $data[$i]['sexo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fila,  $data[$i]['centro']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fila, 'No informado');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fila, $data[$i]['fecha_atencion']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fila, $data[$i]['detalle_atencion']);
                // Verificar si los valores existen en $data[$i] antes de usarlos
                $vision_lejos_od_lc = isset($data[$i]['sl_vision_lejos_od_lc']) ? $data[$i]['sl_vision_lejos_od_lc'] : '';
                $vision_lejos_oi_lc = isset($data[$i]['sl_vision_lejos_oi_lc']) ? $data[$i]['sl_vision_lejos_oi_lc'] : '';
                $vision_lejos_od_sin_cor = isset($data[$i]['sl_vision_lejos_od_sin_cor']) ? $data[$i]['sl_vision_lejos_od_sin_cor'] : '';
                $vision_lejos_oi_sin_cor = isset($data[$i]['sl_vision_lejos_oi_sin_cor']) ? $data[$i]['sl_vision_lejos_oi_sin_cor'] : '';

                // Verificar si los valores están disponibles y asignar los valores correspondientes
                if ($vision_lejos_od_lc !== '' && $vision_lejos_oi_lc !== '') {
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fila, $vision_lejos_od_lc.' | '.$vision_lejos_oi_lc);
                } else {
                    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fila, ''); // Campo vacío si no hay datos
                }

                if ($vision_lejos_od_sin_cor !== '' && $vision_lejos_oi_sin_cor !== '') {
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$fila, $vision_lejos_od_sin_cor.' | '.$vision_lejos_oi_sin_cor);
                } else {
                    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$fila, ''); // Campo vacío si no hay datos
                }

                // Verificar si ambos valores existen en $data[$i] antes de usarlos
                $recepcionado = isset($data[$i]['recepcionado']) ? $data[$i]['recepcionado'] : null;
                $codigo_pago_cuenta = isset($data[$i]['codigo_pago_cuenta']) ? $data[$i]['codigo_pago_cuenta'] : null;

                $estado = ($recepcionado == 1 && $codigo_pago_cuenta == 2) ? 'Asistió' : 'Agendado';
                $objPHPExcel->getActiveSheet()->SetCellValue('K'.$fila, $estado);
                
                $fila++; // Incremento de $fila en 1
                $contador++;
                //sleep(1); // Espera de 1 segundo para no sobrecargar 
                if($contador==299)
                {
                    $contador=0;
                    sleep(1);
                }
            }

          
            // Crear el escritor para Excel
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // Limpiar cualquier contenido anterior del búfer de salida
            ob_end_clean();

            // Encabezado para indicar el tipo de archivo Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            // Nombre del archivo de salida con extensión xlsx
            $informe = 'Informe_Pacientes_Agendados';
            header('Content-Disposition: attachment; filename="Importacion' . $informe . '.xlsx"');

            // Guardar el archivo Excel en el servidor
            $objWriter->save('views/informes/exportar_informe_pacientes/Informe_Pacientes_Agendados.xlsx');

            return true;

        } catch (PDOException $e) {

            echo $e->getMessage(); 
            return false;
        }
    }   





    public function descargar_Excel_Prestacion($datos_informe){
        ini_set('memory_limit', '2012M'); // Ajusta el valor según sea necesario
        set_time_limit(0); // Esto eliminará el límite de tiempo de ejecución
        try {

            
            // Convertir el segundo string (JSON) en un arreglo
            $data = json_decode($datos_informe, true);

            //$nombreProfesional = $data[0]['nombre_profesional'];
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setLastModifiedBy("IOPA");
            $objPHPExcel->getProperties()->setTitle("Empresas");
            $objPHPExcel->getProperties()->setSubject("EmpresasiOPA");
            
            $objPHPExcel->setActiveSheetIndex(0);
            $numDetalle = count($data);  

            // ENCABEZADO EXCEL EN MAYÚSCULAS Y NEGRITA
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUT");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "PACIENTE");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "FECHA N");
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', "SEXO");
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', "CENTRO");
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', "N° ANTEOJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', "FECHA AGENDA");
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', "DIAGNÓSTICO");
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', "ESTADO");

             // Aplicar formato de negrita al encabezado
            $encabezadoEstilo = $objPHPExcel->getActiveSheet()->getStyle('A1:I1');
            $encabezadoFuente = $encabezadoEstilo->getFont();
            $encabezadoFuente->setBold(true);

            $fila = 2;
            $contador=0;
            for ($i = 0; $i < $numDetalle; $i++) {
                // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_pnatural']);
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_completo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, $data[$i]['nombres'].' ' .$data[$i]['apellido_paterno'].' '.$data[$i]['apellido_materno']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $data[$i]['fecha_nacimiento']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fila, $data[$i]['sexo']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fila, $data[$i]['centro']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fila, 'No informado');
                $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fila, $data[$i]['fecha_atencion']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fila, $data[$i]['detalle_atencion']);
                // Verificar si ambos valores existen en $data[$i] antes de usarlos
                $recepcionado = isset($data[$i]['recepcionado']) ? $data[$i]['recepcionado'] : null;
                $codigo_pago_cuenta = isset($data[$i]['codigo_pago_cuenta']) ? $data[$i]['codigo_pago_cuenta'] : null;

                $estado = ($recepcionado == 1 && $codigo_pago_cuenta == 2) ? 'Asistió' : 'Agendado';
                $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fila, $estado);
                
                $fila++; // Incremento de $fila en 1
                $contador++;
                //sleep(1); // Espera de 1 segundo para no sobrecargar 
                if($contador==299)
                {
                    $contador=0;
                    sleep(1);
                }
            }

            // Crear el escritor para Excel
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // Limpiar cualquier contenido anterior del búfer de salida
            ob_end_clean();

            // Encabezado para indicar el tipo de archivo Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            // Nombre del archivo de salida con extensión xlsx
            $informeComisionafp = 'Informe_Prestaciones';
            header('Content-Disposition: attachment; filename="Importacion' . $informeComisionafp . '.xlsx"');

            // Guardar el archivo Excel en el servidor
            $objWriter->save('views/informes/exportar_informe_prestacion/Informe_Prestaciones.xlsx');

            return true;

        } catch (PDOException $e) {

            echo $e->getMessage(); 
            return false;
        }
    }   




    public function descargar_Excel_optica($datos_informe){
        ini_set('memory_limit', '2012M'); // Ajusta el valor según sea necesario
        set_time_limit(0); // Esto eliminará el límite de tiempo de ejecución
        try {

           
            // Convertir el segundo string (JSON) en un arreglo
            $data = json_decode($datos_informe, true);

            //$nombreProfesional = $data[0]['nombre_profesional'];
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setLastModifiedBy("IOPA");
            $objPHPExcel->getProperties()->setTitle("Empresas");
            $objPHPExcel->getProperties()->setSubject("EmpresasiOPA");
            
            $objPHPExcel->setActiveSheetIndex(0);
            $numDetalle = count($data);  

           // ENCABEZADO EXCEL EN MAYÚSCULAS Y NEGRITA
           $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUT");
           $objPHPExcel->getActiveSheet()->SetCellValue('B1', "PACIENTE");
           $objPHPExcel->getActiveSheet()->SetCellValue('C1', "FECHA N");
           $objPHPExcel->getActiveSheet()->SetCellValue('D1', "SEXO");
           $objPHPExcel->getActiveSheet()->SetCellValue('E1', "FECHA AGENDA");
           $objPHPExcel->getActiveSheet()->SetCellValue('F1', "ESTADO");
           $objPHPExcel->getActiveSheet()->SetCellValue('G1', "CENTRO");


            // Aplicar formato de negrita al encabezado
           $encabezadoEstilo = $objPHPExcel->getActiveSheet()->getStyle('A1:G1');
           $encabezadoFuente = $encabezadoEstilo->getFont();
           $encabezadoFuente->setBold(true);

           $fila = 2;
           $contador=0;
           for ($i = 0; $i < $numDetalle; $i++) {
               // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_pnatural']);
               $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_completo']);
               $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, $data[$i]['nombres'].' ' .$data[$i]['apellido_paterno'].' '.$data[$i]['apellido_materno']);
               $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $data[$i]['fecha_nacimiento']);
               $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fila, $data[$i]['sexo']);
               $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fila, $data[$i]['fecha_atencion']);
               // Verificar si ambos valores existen en $data[$i] antes de usarlos
               $recepcionado = isset($data[$i]['recepcionado']) ? $data[$i]['recepcionado'] : null;
               $codigo_pago_cuenta = isset($data[$i]['codigo_pago_cuenta']) ? $data[$i]['codigo_pago_cuenta'] : null;

               $estado = ($recepcionado == 1 && $codigo_pago_cuenta == 2) ? 'Asistió' : 'Agendado';
               $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fila, $estado);
               $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fila,  $data[$i]['centro']);
             
               
               $fila++; // Incremento de $fila en 1
               $contador++;
               //sleep(1); // Espera de 1 segundo para no sobrecargar 
               if($contador==299)
               {
                   $contador=0;
                   sleep(1);
               }
           }

            // Crear el escritor para Excel
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // Limpiar cualquier contenido anterior del búfer de salida
            ob_end_clean();

            // Encabezado para indicar el tipo de archivo Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            // Nombre del archivo de salida con extensión xlsx
            $informeComisionafp = 'Informe_Optica';
            header('Content-Disposition: attachment; filename="ImportacionOC' . $informeComisionafp . '.xlsx"');

            // Guardar el archivo Excel en el servidor
            $objWriter->save('views/informes/exportar_informe_optica/Informe_Optica.xlsx');

            return true;

        } catch (PDOException $e) {

            echo $e->getMessage(); 
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


   
}
?>
