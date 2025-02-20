<?php
//session_start();
include_once 'public/PHPExcel.php';
include_once 'public/PHPExcel/Writer/Excel2007.php';

class GesModel extends Model
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


    public function get_pacientes_RS($iniciar,$autorizacionporpagina,$fecha, $fecha_hasta, $codigos_reserva_atencion_string) {
        try {
            $data_agenda = [
                'iniciar' => $iniciar,
                'autorizacionporpagina' => $autorizacionporpagina,
                'fecha' => $fecha,
                'fecha_hasta' => $fecha_hasta,
                'codigos_reserva_atencion_string' => $codigos_reserva_atencion_string
            ];

            $resultado = $this->llamarApi("/pacientes_atendidos","GET",$data_agenda);
            if($resultado){
                return $resultado;
            }
            return [];
           
        } catch (PDOException $e) {
            return [];
        }
    }
    

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
            //carga solo las citas activas
            $conditions[] = "c.codigo_estado_reserva = 1"; 
    
            // Combina las condiciones con la cláusula WHERE si existen
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
            $query .= " ORDER BY c.id";
            $stmt = $this->db->connect()->query($query);
    
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Agrega cada valor al arreglo
                $items[] = $row['codigo_reserva_atencion_rebsol'];
    
                // $items1[] = [
                //     'codigo_reserva_atencion_rebsol' => $row['codigo_reserva_atencion_rebsol'],
                //     'centro' => $row['centro']
                // ];
            }
    
            // Convierte el arreglo en una cadena separada por comas
            $items_coma = implode(',', $items);
    
            // Retorna ambos arreglos empaquetados en un arreglo asociativo
            // return  $items_coma;
            return [
                'items_reserva' => $items_coma, // String separado por comas
            ];
    
        } catch (PDOException $e) {
            return [];
        }
    }


    function llamarApi($endpoint, $metodo = 'GET', $data = null) {
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


   
}
?>
