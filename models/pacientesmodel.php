<?php
// include_once 'models/pacientes.php';

include_once 'public/PHPExcel.php';
include_once 'public/PHPExcel/Writer/Excel2007.php';
class PacientesModel extends Model
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
    public function get(){
        $items = [];
        try{
            $query=$this->db->connect()->query("SELECT * FROM medicos");
            while($row=$query->fetch()){
                 $item = new Medicos();
                 $item->id     = $row['id'];
                 $item->medico     = $row['medico'];
                 $item->foto     = $row['foto'];
                 array_push($items,$item);
                  }
           return $items;
        }catch(PDOException $e){
            return [];
        }
    }


    public function getregistros($s){
       
         try{
            if ($s==null){ 
                $query=$this->db->connect()->query("SELECT count(*) as son FROM medicos");
            }else{
                $query=$this->db->connect()->query("SELECT count(*) as son FROM medicos WHERE rut='$s'");                               
            }

             while($row=$query->fetch()){
                  $cuantos    = $row['son'];
                   }
            return $cuantos;
         }catch(PDOException $e){
             return [];
         }
     }


    public function getpag($iniciar,$autoporpag,$s){
        $items = [];
        try{
            if ($s==null){
                $query=$this->db->connect()->query("SELECT * FROM medicos order by id  LIMIT $iniciar,$autoporpag");
            }else{
                $query=$this->db->connect()->query("SELECT * FROM medicos WHERE rut=".$s." order by id  LIMIT $iniciar,$autoporpag");
            }
            while($row=$query->fetch()){
                $item = new Medicos();
                $item->id   =$row['id'];
                $item->rut  =$row['rut'];
                $item->nombre =$row['nombre'];
                $item->apellido1 =$row['apellido1'];
                $item->apellido2 =$row['apellido2'];
                $item->fecha_nacimiento =$row['fecha_nacimiento'];
                $item->direccion =$row['direccion'];
                $item->especialidad =$row['especialidad'];
                $item->email =$row['email'];
                $item->telefono =$row['telefono'];
                $item->estado =$row['estado'];

                array_push($items,$item);
            }
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function getById($id){
        $item=new Medicos();
        $query=$this->db->connect()->prepare("SELECT * FROM medicos WHERE id=:id");
        try{
           $query->execute(['id'=>$id]);
            while($row=$query->fetch()){
                $item->id   =$row['id'];
                $item->rut  =$row['rut'];
                $item->nombre =$row['nombre'];
                $item->apellido1 =$row['apellido1'];
                $item->apellido2 =$row['apellido2'];
                $item->fecha_nacimiento =$row['fecha_nacimiento'];
                $item->direccion =$row['direccion'];
                $item->especialidad =$row['especialidad'];
                $item->email =$row['email'];
                $item->telefono =$row['telefono'];
                $item->estado =$row['estado'];
                  }
           return $item;
        }catch(PDOException $e){
           return null;
        }
    }
    public function update($item){
$query=$this->db->connect()->prepare("UPDATE medicos SET medico=:medico,foto=:foto WHERE id=:id");
    try{
       $query->execute(['id'=>$item['id'],'medico'=>$item['medico'],'foto'=>$item['foto']]);
       return true;
    }catch(PDOException $e){
       return false;
    }
    }



public function insert($rut, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $direccion, $especialidad, $email, $telefono, $estado) {
    try {
        // Preparar la sentencia SQL con placeholders
        $sql = "INSERT INTO medicos (rut, nombre, apellido1, apellido2, fecha_nacimiento, direccion, especialidad, email, telefono, estado) 
                VALUES (:rut, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :direccion, :especialidad, :email, :telefono, :estado)";

        // Preparar la consulta
        $query = $this->db->connect()->prepare($sql);

        // Asignar los valores a los placeholders
        $query->bindParam(':rut', $rut);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellido1', $apellido1);
        $query->bindParam(':apellido2', $apellido2);
        $query->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $query->bindParam(':direccion', $direccion);
        $query->bindParam(':especialidad', $especialidad);
        $query->bindParam(':email', $email);
        $query->bindParam(':telefono', $telefono);
        $query->bindParam(':estado', $estado);

        // Ejecutar la consulta
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


//MASIVAMENTE
// public function insert($data) {
//     try {
//         // Preparar la sentencia SQL con placeholders
//         $sql = "INSERT INTO medicos (rut, nombre, apellido1, apellido2, fecha_nacimiento, direccion, especialidad, email, telefono, estado) 
//                 VALUES (:rut, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :direccion, :especialidad, :email, :telefono, :estado)";

//         // Preparar la consulta
//         $query = $this->db->connect()->prepare($sql);
//         $estado = 'activo'; 
//         $especialidad = 'Oftalmologia'; 
//         // Verificar si 'response' está en $data y es un array
//         if (isset($data['response']) && is_array($data['response'])) {
//             // Recorrer el arreglo de médicos en 'response'
//             foreach ($data['response'] as $medico) {
//                 // Asignar los valores del médico actual a las variables
//                 $rut = $medico['rut_pnatural'];
//                 $rut = $this->calcularRutFormateado($rut);
//                 $nombre = $medico['nombre_pnatural'];
//                 $apellido1 = $medico['apellido_paterno'];
//                 $apellido2 = $medico['apellido_materno'];
//                 $especialidad =  $especialidad;
//                 $estado = $estado;

//                 // echo"<pre>";
//                 // var_dump($rut);
//                 // var_dump($nombre);
//                 // var_dump($apellido1);
//                 // var_dump($apellido2);
//                 // var_dump($especialidad);
//                 // var_dump($estado);
//                 // echo"</pre>";
//                 // exit();
                
//                 // Valores adicionales que debes asignar o manejar
//                 $fecha_nacimiento = null;  // Asigna el valor real si está disponible
//                 $direccion = null;  // Asigna el valor real si está disponible
//                 $email = null;  // Asigna el valor real si está disponible
//                 $telefono = null;  // Asigna el valor real si está disponible

//                 // Asignar los valores a los placeholders
//                 $query->bindParam(':rut', $rut);
//                 $query->bindParam(':nombre', $nombre);
//                 $query->bindParam(':apellido1', $apellido1);
//                 $query->bindParam(':apellido2', $apellido2);
//                 $query->bindParam(':fecha_nacimiento', $fecha_nacimiento);
//                 $query->bindParam(':direccion', $direccion);
//                 $query->bindParam(':especialidad', $especialidad);
//                 $query->bindParam(':email', $email);
//                 $query->bindParam(':telefono', $telefono);
//                 $query->bindParam(':estado', $estado);

//                 // Ejecutar la consulta
//                 if (!$query->execute()) {
//                     return false; // Fallo en la inserción de algún registro
//                 }
//             }

//             return true; // Éxito al insertar todos los médicos
//         } else {
//             return false; // El formato de los datos no es correcto
//         }

//     } catch (PDOException $e) {
//         // Manejar el error de la excepción
//         error_log("Error en la inserción: " . $e->getMessage());
//         return false;
//     }
// }




public function insertcsv($datos){
       try{
         $query=$this->db->connect()->prepare('INSERT INTO medicos(id,medico,foto) VALUES  (:id,:medico,:foto)');
          $query->execute(['id'=>$datos['id'],'medico'=>$datos['medico'],'foto'=>$datos['foto']]);
           return true;
       }catch(PDOException $e){
          return false;
      }
    } 
    public function delete($id){
$query=$this->db->connect()->prepare("DELETE FROM medicos WHERE id=:id");
    try{
       $query->execute([
         'id'=>$id,
       ]);
       return true;
    }catch(PDOException $e){
       return false;
    }
    }

    function calcularRutFormateado($rut) {
        // Eliminar espacios y guiones
        $rut = preg_replace('/[^\d]/', '', $rut);
    
        // Validar que el RUT tenga al menos 7 dígitos
        if (strlen($rut) < 7) {
            return null; // RUT inválido
        }
    
        $suma = 0;
        $multiplicador = 2;
    
        // Calcular la suma para el dígito verificador
        for ($i = strlen($rut) - 1; $i >= 0; $i--) {
            $suma += $rut[$i] * $multiplicador;
            $multiplicador++;
            if ($multiplicador > 7) {
                $multiplicador = 2; // Reiniciar el multiplicador
            }
        }
    
        $resto = $suma % 11;
        $digitoVerificador = 11 - $resto;
    
        // Asignar el dígito verificador correspondiente
        if ($digitoVerificador == 11) {
            $digitoVerificador = '0';
        } elseif ($digitoVerificador == 10) {
            $digitoVerificador = 'K';
        }
    
        // Retornar el RUT formateado sin puntos
        return $rut.'-'.$digitoVerificador;
    }



    public function leerExcel($data){
        $items = [];
        $nombreArchivo = $data['archivos']['name'];
       

        //crea y lee excel
        $tmpfname = $data['archivos']['tmp_name'];
        $leerExcel = PHPExcel_IOFactory::createReaderForFile($tmpfname);

        $excelObj = $leerExcel->load($tmpfname);

        $hoja = $excelObj->getSheet(0);
        $filas = $hoja->getHighestRow();
        $columnas = $hoja->getHighestColumn();
        //obtener las dimensiones de la hoja con:
        $dimension = $hoja->calculateWorksheetDimension();
       

        if ($columnas == 'I'){
            for ($i=2; $i<= $filas; $i++){
                $hora = $hoja->getCellByColumnAndRow(0,$i)->getValue();
                $hora_formateada = $this->format_hora($hora);
                $fecha_nacimiento = $hoja->getCellByColumnAndRow(1,$i)->getValue();
                $fecha_formateada = $this->format_fecha($fecha_nacimiento);
                $nombre = $hoja->getCellByColumnAndRow(2,$i)->getValue();
                $rut = $hoja->getCellByColumnAndRow(3,$i)->getValue();
                $dv = $hoja->getCellByColumnAndRow(4,$i)->getValue();
                $telefono1 = $hoja->getCellByColumnAndRow(5,$i)->getValue();
                $telefono2 = $hoja->getCellByColumnAndRow(6,$i)->getValue();
                $centro = $hoja->getCellByColumnAndRow(7,$i)->getValue();
                $correo = $hoja->getCellByColumnAndRow(8,$i)->getValue();

                // echo "<pre>";
                // var_dump([
                //     'Hora' => $hora,
                //     'Hora Formateada' => $hora_formateada,
                //     'Fecha de Nacimiento' => $fecha_nacimiento,
                //     'Fecha Formateada' => $fecha_formateada,
                //     'Nombre' => $nombre,
                //     'RUT' => $rut,
                //     'DV' => $dv,
                //     'Teléfono 1' => $telefono1,
                //     'Teléfono 2' => $telefono2,
                //     'Centro' => $centro,
                //     'Correo Electrónico' => $correo,
                // ]);
                // echo "</pre>";
                // exit();
               
                $item = [
                    'Hora' => $hora_formateada,
                    'Fecha_nacimiento' => $fecha_formateada,
                    'Nombre' => $nombre,
                    'RUT' => $rut,
                    'DV' => $dv,
                    'Telefono1' => $telefono1,
                    'Telefono2' => $telefono2,
                    'Centro' => $centro,
                    'Correo_Electronico' => $correo,
                ];
               
                // exit();
                array_push($items, $item);
                
               
                
            }
            return $items;

            // fncCrearExcelNoRelacionadas($ObjNoImportar);
            // fncCrearExcelRelacionadas($ObjImportar);
            // echo  json_encode($ObjImportar);

        }else{
    
            $mensaje= 'Error 1';
            return $mensaje;
            // $arrTemp =array();
            // $arrTemp = (array)  $obj;
            // array_push($ObjImportar->arrObj, $arrTemp);	
            // echo  json_encode($mensaje);
        }
       
    }




    // public function buscar_bloque($fecha, $hora = null, $id_medico = null) {
    //     try {
    //         // Construir la consulta base
    //         // $sql_bloque_cita = "SELECT h.id_bloque_medico";
    //         $sql_bloque_cita = "SELECT h.id ,h.id_bloque_medico, h.id_horario_rebsol ";
    
    //         // Cambiar la selección si se proporciona una hora específica
    //         if (!empty($hora)) {
    //             $sql_bloque_cita = "SELECT h.id";
    //         }
    
    //         // Completar la consulta con la unión y la validación básica
    //         $sql_bloque_cita .= " FROM horarios h
    //                               INNER JOIN bloque_horario_medico bhm 
    //                               ON h.id_bloque_medico = bhm.id
    //                               WHERE DATE(h.fecha) = :fecha
    //                               AND (h.estado != 'ocupado' OR h.sobre_cupo != 'ocupado')";
    
    //         // Agregar filtro por médico si se proporciona
    //         if (!empty($id_medico)) {
    //             $sql_bloque_cita .= " AND bhm.id_medico = :id_medico";
    //         }
    
    //         // Agregar filtro por hora si se proporciona
    //         if (!empty($hora)) {
    //             $sql_bloque_cita .= " AND h.hora_inicio = :hora_inicio";
    //         }
    
    //         // Preparar la consulta
    //         $select_bloque_cita = $this->db->connect()->prepare($sql_bloque_cita);
    
    //         // Vincular los parámetros obligatorios
    //         $select_bloque_cita->bindParam(':fecha', $fecha);
    
    //         // Vincular los parámetros opcionales
    //         if (!empty($id_medico)) {
    //             $select_bloque_cita->bindParam(':id_medico', $id_medico);
    //         }
    
    //         if (!empty($hora)) {
    //             $select_bloque_cita->bindParam(':hora_inicio', $hora);
    //         }
    
    //         // Ejecutar la consulta
    //         $select_bloque_cita->execute();
    
    //         // Obtener los resultados
    //         $resultados = $select_bloque_cita->fetchAll(PDO::FETCH_ASSOC);
    
    //         // Si hay resultados, devolver el valor correspondiente (id_bloque_medico o id)
    //         if ($select_bloque_cita->rowCount() > 0) {
    //             return isset($resultados[0]['id_bloque_medico']) 
    //                 ? $resultados[0]['id_bloque_medico'] 
    //                 : (isset($resultados[0]['id']) ? $resultados[0]['id'] : null);
    //         }
    
    //         // Si no se encontraron resultados, retornar null
    //         return null;
    
    //     } catch (PDOException $e) {
    //         // Manejo de errores
    //         echo "Error: " . $e->getMessage();
    //         return null;
    //     }
    // }



public function buscar_bloque($fecha, $hora = null, $id_medico = null) {
    try {
        // Construir la consulta base
        $sql_bloque_cita = "SELECT h.id, h.id_bloque_medico, h.id_horario_rebsol, bhm.id_bloque_medico_rebsol
                            FROM horarios h
                            INNER JOIN bloque_horario_medico bhm 
                            ON h.id_bloque_medico = bhm.id
                            WHERE DATE(h.fecha) = :fecha
                            AND (h.estado != 'ocupado' OR h.sobre_cupo != 'ocupado')";

        // Si se proporciona una hora, agregar la condición para la hora y médico
        if (!empty($hora)) {
            $sql_bloque_cita .= " AND h.hora_inicio = :hora_inicio";
        }

        // Agregar filtro por médico si se proporciona
        if (!empty($id_medico)) {
            $sql_bloque_cita .= " AND bhm.id_medico = :id_medico";
        }

        // Preparar la consulta
        $select_bloque_cita = $this->db->connect()->prepare($sql_bloque_cita);

        // Vincular los parámetros obligatorios
        $select_bloque_cita->bindParam(':fecha', $fecha);

        // Vincular los parámetros opcionales
        if (!empty($hora)) {
            $select_bloque_cita->bindParam(':hora_inicio', $hora);
        }

        if (!empty($id_medico)) {
            $select_bloque_cita->bindParam(':id_medico', $id_medico);
        }

        // Ejecutar la consulta
        $select_bloque_cita->execute();

        // Obtener los resultados
        $resultados = $select_bloque_cita->fetchAll(PDO::FETCH_ASSOC);
        // echo "<pre>";
        // var_dump('buscar_bloque');
        // var_dump($resultados);
        // echo "</pre>";
        // exit();

        // Si hay resultados, devolver el array completo de resultados
        if ($select_bloque_cita->rowCount() > 0) {
            return $resultados; // Retorna todos los resultados como un array
        }

        // Si no se encontraron resultados, retornar null
        return null;

    } catch (PDOException $e) {
        // Manejo de errores
        echo "Error: " . $e->getMessage();
        return null;
    }
}





    public function format_hora($hora){
        $totalSegundos = round($hora * 86400); // 86400 segundos en un día
        // Convierte los segundos en horas, minutos y segundos.
        $horas = floor($totalSegundos / 3600);
        $minutos = floor(($totalSegundos % 3600) / 60);
        $segundos = $totalSegundos % 60;

        // Formatea la hora como HH:mm:ss.
        $horaFormateada = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
        return $horaFormateada;

    }


    public function format_fecha($fecha){
          // Convierte el valor en formato de Excel a una marca de tiempo UNIX
          $timestamp = ($fecha - 25569) * 86400; // 25569 = Días entre 1/1/1900 y 1/1/1970

          // Formatea la marca de tiempo a una fecha legible
          $fecha_formateada = date('Y-m-d', $timestamp);
          return $fecha_formateada;

        
    }


    // Función para registrar mensajes en el log
    public function registrar_log($mensaje, $log_file) {
        error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
    }


    public function insertar_Bloque_horario_medico($id_medico, $fecha, $fecha_hasta, $hora_inicio, $hora_fin, $duracion_consulta, $array_dias_select, $rut_medico) {
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
    
            // // Función para registrar mensajes en el log
            // function registrar_log($mensaje, $log_file) {
            //     error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
            // }
    
    
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
                            if ($stmtUpdate->execute()) {
                                // return  $id_bloque_medico_rebsol;
                                return [
                                    'id_bloque_medico_rebsol' => $id_bloque_medico_rebsol,
                                    'id_bloque_medico' => $id_bloque_medico
                                ];
                                

                            } else {
                                $mensaje =  error_log("Error al actualizar el registro bloque_horario_medico : " . implode(", ", $stmtUpdate->errorInfo()));
                                $this->registrar_log($mensaje, $log_file);
                            }


                        }else{
                            $mensaje =  error_log("Error al insertar en bloque_horario_medico_rebsol : " . implode(", ", $resultado->errorInfo()));
                            $this->registrar_log($mensaje, $log_file);
                        }


                    } else {
                        $mensaje = "Error al insertar bloque_horario_medico: " . implode(", ", $stmt->errorInfo());
                        $this->registrar_log($mensaje, $log_file);
                    }

                }

            }

        } catch (PDOException $e) {
            $mensaje = sprintf(
                "Error en la inserción: %s. Código de error: %s.",
                $e->getMessage(),
                $e->getCode()
            );
            $this->registrar_log($mensaje, $log_file);
            return false;
        }
    }



    public function insertar_bloque_horario($id_medico, $fecha, $fecha_hasta, $hora_inicio, $hora_fin, $duracion_consulta, $array_dias_select, $rut_medico, $id_bloque_medico_rs, $id_bloque_medico_cds) {
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
        //  function $this->registrar_log($mensaje, $log_file) {
        //      error_log(date('Y-m-d H:i:s') . " - " . $mensaje . PHP_EOL, 3, $log_file);
        //  }
 
        $fecha_inicio = new DateTime($fecha);
        $fecha_final = new DateTime($fecha_hasta);
    
        // Convertir horas de inicio y fin a objetos DateTime
        $hora_inicio_dt = new DateTime($hora_inicio);
        $hora_fin_dt = new DateTime($hora_fin);

        
        $sql = "INSERT INTO horarios (fecha, fecha_hasta, hora_inicio, hora_fin, duracion_consulta, id_bloque_medico) 
        VALUES (:fecha, :fecha_hasta, :hora_inicio, :hora_fin, :duracion_consulta, :id_bloque_medico)";
        // $stmtHorario = $this->db->connect()->prepare($sql);

        $dbConnection = $this->db->connect();

        // Preparar la sentencia
        $stmtHorario = $dbConnection->prepare($sql);

    
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

                //Parametro
                $usuario = substr($_SESSION['rut'], 0, -2);
                // Guardar los resultados para enviarlo a la API, para insertar horarios en rebsol 
                $bloques_horarios [] = [
                    'fecha' => $fecha_actual,
                    'fecha_hasta' => $fecha_actual,
                    'hora_inicio' => $hora_inicio_formateada,
                    'hora_fin' => $hora_fin_formateada,
                    'duracion_consulta' => $duracion_consulta,
                    'id_bloque_medico' => $id_bloque_medico_rs,
                    'rut_profesional' => $rut_medico,
                    'usuario' => $usuario
                ];

                // Vincular los parámetros a la sentencia preparada
                $stmtHorario->bindParam(':fecha', $fecha_actual);
                $stmtHorario->bindParam(':fecha_hasta', $fecha_actual);
                $stmtHorario->bindParam(':hora_inicio', $hora_inicio_formateada);
                $stmtHorario->bindParam(':hora_fin', $hora_fin_formateada);
                $stmtHorario->bindParam(':duracion_consulta', $duracion_consulta);
                $stmtHorario->bindParam(':id_bloque_medico', $id_bloque_medico_cds);
            
                // Ejecutar la consulta
                if (!$stmtHorario->execute()) {
                    // Obtener el ID del último registro insertado
                    // $ultimo_id_horario = $this->db->connect()->lastInsertId();
                    
                    // error_log("Error al insertar el bloque: " . implode(", ", $stmtHorario->errorInfo()));
                    $mensaje =  error_log("Error al insertar el bloque: " . implode(", ", $stmtHorario->errorInfo()));
                    $this->registrar_log($mensaje, $log_file);
                }
                $ultimo_id_horario = $dbConnection->lastInsertId();
                $baneraHorarios = true;

                // Avanzar a la siguiente hora
                $hora_actual_dt->modify('+' . $duracion_consulta . ' minutes');
            }
            
    
            // Avanzar al siguiente día
            $fecha_inicio->modify('+1 day');
        }

        if($baneraHorarios == true) {
            // Paso 4: Insertar horarios en rebsol
            $resultado = $this->llamarApi("horarios_medicos","POST",$bloques_horarios);
          
            if (!$resultado){
                $mensaje =  error_log("Error al insertar horarios en rebsol : " . implode(", ", $stmtHorario->errorInfo()));
                $this->registrar_log($mensaje, $log_file);
                

            }
            return $ultimo_id_horario;
            
        }

    }





    public function insert_reserva($data, $id_horario) {
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
            // function $this->registrar_log($mensaje, $log_file) {
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
            $valor_agendra = 'xxx';
            $sucursal = 1; 
    
            // Asignar los valores a los placeholders
            $query->bindParam(':rut', $data['rut_p']);
            $query->bindParam(':nombre', $data['nombre_p']);
            $query->bindParam(':apellido1', $data['apellido_1p']);
            $query->bindParam(':apellido2', $data['apellido_2p']);
            $query->bindParam(':fecha_nacimiento', $data['fecha_nac_p']);
            $query->bindParam(':sexo', $data['genero']); 
            $query->bindParam(':direccion', $data['direccion_p']);
            $query->bindParam(':telefono', $data['fono_1p']);
            $query->bindParam(':telefono2', $data['fono_2p']); 
            $query->bindParam(':email', $data['email_p']);
            $query->bindParam(':prevision', $data['prevision_p']); 
            $query->bindParam(':sucursal', $sucursal); 
            $query->bindParam(':centro', $data['centro_derivado_p']); 
            $query->bindParam(':id_medico',$data['id_medico']); 
            $query->bindParam(':nombre_medico', $data['medico_agenda']); 
            $query->bindParam(':usuario_agenda', $_SESSION["usuario"]); 
            $query->bindParam(':observacion', $data['observacion']); 
            $query->bindParam(':id_horario', $id_horario);
    
            // Ejecutar la consulta
            if ($query->execute()) {
                // Obtener el último ID insertado
                $id_reserva_cita = $dbConnection->lastInsertId();
                // validar si el horarios esta disponible
                $select_sql = "SELECT * FROM horarios WHERE id =:id_horario AND estado = 'ocupado'";
                $select_query = $this->db->connect()->prepare($select_sql);
                // $select_query->bindParam(':id_horario', $data["id_horario"]);
                $select_query->bindParam(':id_horario',  $id_horario);
                $select_query->execute();

                // Verificar si la consulta ha devuelto resultados
                if ($select_query->rowCount() > 0) {
                    // El horario está ocupado registra sobre cupo
                    $update_cupo_sql = "UPDATE horarios SET sobre_cupo = 'ocupado' WHERE id = :id_horario";
                    $update_cupo_query = $this->db->connect()->prepare($update_cupo_sql);
                    // $update_cupo_query->bindParam(':id_horario', $data["id_horario"]);
                    $update_cupo_query->bindParam(':id_horario',  $id_horario);
                    $update_cupo_query->execute();
                   
                }
    
                 // Actualizar el estado del horario
                 $update_sql = "UPDATE horarios SET estado = 'ocupado' WHERE id = :id_horario";
                 $update_query = $this->db->connect()->prepare($update_sql);
                //  $update_query->bindParam(':id_horario', $data["id_horario"]);
                 $update_query->bindParam(':id_horario',  $id_horario);
                 // $update_query->execute();
    
                 // exit();
    
    
               
    
                if($update_query->execute()){
                    //Agendar cita en rebsol
                    // arreglo de parametros
                    $rut_medico = $data["rut_medico"];
                    // Quitamos los últimos dos caracteres
                    $rut_medico = substr($rut_medico, 0, -2);
                    $rut_paciente = $data["rut_p"];
                    $rut_paciente = substr($rut_paciente, 0, -2);
                    $fecha_consulta = $data["fecha_consulta"];
                    // $fecha_formateada = DateTime::createFromFormat('d/m/Y', $fecha_consulta)->format('Y-m-d');
                    $fecha_formateada = $fecha_consulta;
                    $hora_consulta = $data["hora_consulta"];
                    $hora_consulta = substr($hora_consulta, 0, 5);
                    // Dividimos la cadena por la letra "a"
                    // $partes = explode('a', $hora_consulta);
    
                    // Eliminamos los espacios en blanco alrededor de las partes
                    // $hora_inicio = trim($partes[0]); // Texto anterior a la "a"
                    // $hora_termino = trim($partes[1]); // Texto posterior a la "a"
                    $hora_inicio = $hora_consulta;
                    $hora_termino = $hora_consulta;
                    $calcula_minutos1 = new DateTime($hora_inicio);
                    $calcula_minutos2 = new DateTime($hora_termino);
    
                    // Calculamos la diferencia en minutos
                    $diferencia = $calcula_minutos1->diff($calcula_minutos2);
                    // $duracion = ($diferencia->h * 60) + $diferencia->i; // Convertimos horas a minutos y sumamos los minutos
                    $duracion = 10; // Convertimos horas a minutos y sumamos los minutos
    
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

                    $codigo_reserva_atencion = $resultado['id_cita_agendada']['codigo_reserva'];
                    $id_horario_consulta = $resultado['id_cita_agendada']['id_horario_consulta'];
                    // echo"<pre>";
                    // var_dump('datos de rebsol');
                    // var_dump('codigo reserva atencion');
                    // var_dump($codigo_reserva_atencion);
                    // var_dump('id horario consulta');
                    // var_dump($id_horario_consulta);
                    // echo"</pre>";
                    // exit();
                   
                //    fin  hasti lleho 
                    // if($codigo_reserva_atencion > 0){
                    if (is_array($resultado) && count($resultado) > 1) {
    
                        // Actualizar registro en horarios para agregar id del horario de rebsol 
                        $update_sql_horario = "UPDATE horarios SET id_horario_rebsol = :id_horario_rebsol WHERE id = :id_horario";
                        $update_query_horario = $this->db->connect()->prepare($update_sql_horario);
                        
                        // Enlazar parámetros
                        $update_query_horario->bindParam(':id_horario_rebsol', $id_horario_consulta);
                        $update_query_horario->bindParam(':id_horario', $id_horario);
                        $update_query_horario->execute();
    
    
                       // Actualizar registro de cita para agregar código de reserva de atención de rebsol 
                        $update_sql_citas = "UPDATE citas SET codigo_reserva_atencion_rebsol = :codigo_reserva_atencion_rebsol WHERE id_horario = :id_horario AND id =:id_reserva_cita";
                        $update_query_citas = $this->db->connect()->prepare($update_sql_citas);
                        
                        // Enlazar parámetros
                        $update_query_citas->bindParam(':codigo_reserva_atencion_rebsol', $codigo_reserva_atencion);
                        $update_query_citas->bindParam(':id_horario', $id_horario);
                        $update_query_citas->bindParam(':id_reserva_cita', $id_reserva_cita);
                        
                        // Ejecutar la consulta
                        if($update_query_citas->execute()){
                           
                            return true;
                        } else {
                         
                            // Obtener información del error
                            $errorInfo = $update_query_citas->errorInfo();
                            $mensaje_error = "Error al actualizar citas: " . $errorInfo[2];
                            
                            // Registrar el error en el log
                            $this->registrar_log($mensaje_error, $log_file);
                            return false; 
                        }
                        // return $resultado;
                        
    
                    }else{
                        
                        $mensaje_error = "Error al agendar cita en rebsol";
                        $this->registrar_log($mensaje_error, $log_file);
                        return false; 
                    }
    
                }else{
                    $errorInfo = $update_query->errorInfo();
                    $mensaje_error = "Error al alctualizar estado horarios: " . $errorInfo[2];
                    // echo $mensaje_error;
                    $this->registrar_log($mensaje_error, $log_file);
                    return false; 
                }
    
                // return true; // Éxito al insertar y actualizar
    
            } else {
                 // Imprimir y registrar error al insertar
                $errorInfo = $query->errorInfo();
                $mensaje_error = "Error al insertar agenda cds: " . $errorInfo[2];
                // echo $mensaje_error;
                $this->registrar_log($mensaje_error, $log_file);
                return false; 
            }
    
        } catch (PDOException $e) {
            // Manejar el error de la excepción
            $mensaje = sprintf(
                "Error en la inserción: %s. Código de error: %s.",
                $e->getMessage(),
                $e->getCode()
            );
            $this->registrar_log($mensaje, $log_file);
            error_log("Error en la inserción: " . $e->getMessage());
            return false;
        }
    }



    function llamarApi($endpoint, $metodo = 'GET', $data = null) {

       // URL base de la API
        //Modificado por marcos 20-02-2025 para subir proyecto GIT 
        //Asi la api apunte correctamente a desarrollo o produccion.
        //Este caso apunta a desarrollo
        $baseUrl = constant('ApiCitasCds_d');
       
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
        // var_dump('imprime el resultado del curl');
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
