
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Requerir los archivos de PHPMailer
require __DIR__ . '/../public/mailerPHP/Exception.php';
require __DIR__ . '/../public/mailerPHP/PHPMailer.php';
require __DIR__ . '/../public/mailerPHP/SMTP.php';


class EmailController
{
    // Método para la conexión a la base de datos
    public function database()
    {
        $host = "localhost";
        $db = "agenda_cds";
        $user = "portal";
        $password = "portal2024IOPA#";

        try {
            $connection = "mysql:host=" . $host . ";dbname=" . $db;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($connection, $user, $password, $options);
            return $pdo;
        } catch (PDOException $e) {
            error_log("Error al establecer conexión con la base de datos: " . $e->getMessage());
            die("Error en la conexión con la base de datos.");
        }
    }

    // Función para enviar el correo
    public function envioMail()
    {
        $rut = null;
        $iniciar = 0;
        $autorizacionporpagina = 7;
        $fecha = date('Y-m-d');
        $fecha_hasta = date('Y-m-d');
        // $fecha = date('Y-m-d', strtotime('-1 day'));
        // $fecha_hasta = date('Y-m-d', strtotime('-1 day'));

        // Obtener pacientes de CDS
        $citas_cds = $this->get_pacientes_CDS($rut, $fecha, $fecha_hasta);
        
        $codigos_reserva_atencion_string = $citas_cds['items_reserva'];

        // Obtener pacientes de RS
        $citas_rs = $this->get_pacientes_RS($iniciar, $autorizacionporpagina, $fecha, $fecha_hasta, $codigos_reserva_atencion_string);
        // echo "<pre>";
        // var_dump('get_pacientes_RS');
        // var_dump($citas_rs);
        // echo "</pre>";
        // exit();
        
        $pacientes_atendidos = $citas_rs["informe"];

        // Configurar PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración de SendGrid
            $mail->isSMTP();
            $mail->Host = 'smtp.sendgrid.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'apikey';
            $mail->Password = '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';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('iopaweb@iopa.cl', 'CLINICA IOPA');
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Correo de prueba para "marcos.h.soto@gmail.com"
            $mail->addAddress('marcos.huenchunir@iopa.cl', 'Marcos Soto');
            $mail->addAddress('genesis.cofre@iopa.cl','Genesis Cofre '); 
            $mail->addAddress('yeremi.ortega@iopa.cl','Yeremi Ortega '); 
            $mail->addAddress('karina.iturrieta@iopa.cl','Karina Iturrieta '); 
            $mail->addAddress('nelson.stuardo@iopa.cl','Nelson Stuardo'); 
            $mail->addAddress('catalina.marin@iopa.cl','Catalina Marin'); 
            $mail->addAddress('elias.ghali@iopa.cl','Elias Ghali'); 
            $mail->Subject = 'Pacientes agendados el día :' . $fecha;
            // $mail->Subject = 'PRUEBA';
            $mail->Body = '<p>Estimad@, se envían registros de los pacientes atendidos del día ' . $fecha . ' correspodientes al convenio CDS.<br></p>';
            $mail->Body .= '<table style="border: 2px solid #ccc; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 2px solid #ccc; padding: 8px;">RUT</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Nombre</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Sexo</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Teléfono</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Dirección</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Fecha de Nacimiento</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Correo Electrónico</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Fecha atencion</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Hora agenda</th>
                                <th style="border: 2px solid #ccc; padding: 8px;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>';

            // Recorrer todos los pacientes y agregarlos a la tabla del correo
            foreach ($pacientes_atendidos as $paciente) {
                list($fecha, $hora) = explode(" ", $paciente['fecha_atencion']);
                
                // Determinar el estado y color
                if ($paciente['recepcionado'] == 1 && $paciente['codigo_pago_cuenta'] >= 2) {
                    $estado = "Asistió";
                    $color = "green";  // Verde
                } else {
                    $estado = "No Asistío";
                    $color = "red";  // rojo
                }

                // Agregar fila a la tabla
                $mail->Body .= '<tr>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $paciente['rut_completo'] . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $paciente['nombres'] . ' ' . $paciente['apellido_paterno'] . ' ' . $paciente['apellido_materno'] . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $paciente['sexo'] . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $paciente['telefono2'] . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $paciente['direccion'] . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $paciente['fecha_nacimiento'] . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $paciente['correo_electronico'] . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $fecha . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px;">' . $hora . '</td>
                                    <td style="border: 2px solid #ccc; padding: 8px; background-color: ' . $color . ';">' . $estado . '</td>
                                </tr>';
            }

            $mail->Body .= '</tbody></table>';

            $mail->AltBody = 'Este es un mensaje en texto plano.';
            $mail->send();

            return true;
        } catch (Exception $e) {
            error_log("Error al enviar el correo: " . $mail->ErrorInfo);
            die("Error al enviar el correo.");
        }
    }

    // Método para obtener pacientes agendados CDS
    public function get_pacientes_CDS($rut, $fecha, $fecha_hasta)
    {
        $items = [];
        try {
            $query = "SELECT c.*, h.fecha, h.hora_inicio, h.hora_fin 
                      FROM citas c 
                      JOIN horarios h ON c.id_horario = h.id";

            $conditions = [];

            if (!empty($rut)) {
                $conditions[] = "c.rut = '$rut'";
            }

            if (!empty($fecha) && empty($fecha_hasta)) {
                $conditions[] = "DATE(h.fecha) = '$fecha'";
            } elseif (!empty($fecha) && !empty($fecha_hasta)) {
                $conditions[] = "DATE(h.fecha) BETWEEN '$fecha' AND '$fecha_hasta'";
            }

            $conditions[] = "c.codigo_reserva_atencion_rebsol IS NOT NULL";
            //carga solo las citas activas
            $conditions[] = "c.codigo_estado_reserva = 1"; 

            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            $query .= " ORDER BY c.id";

            $stmt = $this->database()->query($query);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $items[] = $row['codigo_reserva_atencion_rebsol'];
            }

            $items_coma = implode(',', $items);

            return ['items_reserva' => $items_coma];
        } catch (PDOException $e) {
            error_log("Error al obtener pacientes CDS: " . $e->getMessage());
            return [];
        }
    }

    // Método para obtener detalle de atencion pacientes del REBSOL
    public function get_pacientes_RS($iniciar, $autorizacionporpagina, $fecha, $fecha_hasta, $codigos_reserva_atencion_string)
    {
        try {
            $data_agenda = [
                'iniciar' => $iniciar,
                'autorizacionporpagina' => $autorizacionporpagina,
                'fecha' => $fecha,
                'fecha_hasta' => $fecha_hasta,
                'codigos_reserva_atencion_string' => $codigos_reserva_atencion_string,
            ];

            $resultado = $this->llamarApi("/pacientes_atendidos", "GET", $data_agenda);

            if ($resultado) {
                return $resultado;
            }
            return [];
        } catch (Exception $e) {
            error_log("Error al obtener pacientes RS: " . $e->getMessage());
            return [];
        }
    }

    // Método ficticio para llamar a una API (reemplaza con tu implementación real)
    private function llamarApi($endpoint, $metodo = 'GET', $data = null){
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

// Ejecutar el envío del correo
$controller = new EmailController();
$controller->envioMail();

?>
