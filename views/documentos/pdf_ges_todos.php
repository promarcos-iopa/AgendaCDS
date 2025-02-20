<?php 
// echo "<pre>";
// var_dump($this->reservas_cds[0]);
// echo "</pre>";
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opciones de Dompdf
$options = new Options();
// $options->set('defaultFont', 'Arial');


// Construir un solo HTML con saltos de página
$html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .page-break { page-break-before: always; } /* Salto de página */
    </style>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:10px;">';

foreach ($this->reservas_cds as $index => $doc)
{
    if ($index > 0)
    {
        $html .= '<div class="page-break"></div>'; // Agrega salto de página entre secciones
    }
    if(empty($doc["nombre_social_paciente"]) OR $doc["nombre_social_paciente"]=="")
    {
        $nombre_social=$doc["nombres"].' '.$doc["apellido_paterno"].' '.$doc["apellido_materno"];
    }
    else
    {
        $nombre_social=$doc["nombre_social_paciente"];
    }
    if(is_null($doc["diagnostico_ges"]) OR $doc["diagnostico_ges"]=="")
    {
        // para el pregunte por esta &%$%&%$, quitalo y veras el motivo, SUERTE!!! by Dimas
        $doc["diagnostico_ges"]="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
    $html .= '
        <table width="100%">
            <tr>
                <td colspan="2" style="border: 0px solid; text-align: center; font-size:17px;"><strong>FORMULARIO DE CONSTANCIA INFORMACIÓN AL PACIENTE GES</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="border: 0px solid; text-align: center; font-size:10px; font-weight: normal;">(Articulo 24°, Ley 19.966)</td>
            </tr>
            <tr>
                <td colspan="3" style="border-bottom: 2px solid #000;"></td>
            </tr>
        </table>

        <table width="100%" border="0">
            <tr>
                <td colspan="8" style="border: 0px solid; text-align: left; width:50%;"><strong>Datos del prestador</strong></td>
            </tr>
            <tr>
                <td colspan="2" style="border: 0px solid; text-align: left;width:35%;">
                    <table width="100%">
                        <tr>
                            <td>Institución (Hospital, Clínica, Consultorio, etc.):</td>
                        </tr>
                    </table>
                </td>
        
                <td colspan="6" style="width:70%;">
                    <table width="100%">
                        <tr>
                            <td style="border: 1px solid; text-align: center; background-color:#d7ecec;">INSTITUTO OFTALMOLÓGICO PROFESOR ARENTSEN SA</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="1" style="border: 0px solid; text-align: left;width:5%">Dirección:</td>
                <td colspan="3" style="border: 1px solid; text-align: center; background-color:#d7ecec;width:45%">AVDA. LOS LEONES 391</td>
                <td colspan="1" style="border: 0px solid; text-align: left;width:5%">&nbsp;Ciudad:</td>
                <td colspan="2" style="border: 1px solid; text-align: center; background-color:#d7ecec;width:45%">SANTIAGO</td>
            </tr>

            <tr>
                <td colspan="1" style="border: 0px solid; text-align: left;width:20%">&nbsp;Nombre persona que notifica:</td>
                <td colspan="6" style="border: 1px solid; text-align: center; background-color:#d7ecec">'.$doc["med_nombre"].' '.$doc["med_apellido_paterno"].' '.$doc["med_apellido_materno"].'</td>
            </tr>
            <tr>
                <td colspan="1" style="border: 0px solid; text-align: left;width:5%">&nbsp;RUN:</td>
                <td colspan="2" style="border: 1px solid; text-align: center; background-color:#d7ecec;width:20%">'.$doc["med_rut_completo"].'</td>
                <td colspan="4"></td>
            </tr>

            <tr>
                <td colspan = "8" style="border-bottom: 2px solid #000;">&nbsp;</td>
            </tr>
        </table>

        <table width="100%" border="0">
            <tr>
                <td colspan = "2" style="border: 0px solid; text-align: left;"><strong>Antecedentes del/la paciente</strong></td>
            </tr>
            <tr>
                <td  style="border: 0px solid; text-align: left; width:13%;">Nombre legal:</td>
                <td  style="border: 1px solid; text-align: left; background-color:#d7ecec;width=80%;">'.$doc["nombres"].' '.$doc["apellido_paterno"].' '.$doc["apellido_materno"].'</td>
        
            </tr>

                <tr>
                <td  style="border: 0px solid; text-align: left; width:13%">Nombre social:</td>
                <td  style="border: 1px solid; text-align: left; background-color:#d7ecec;width=80%;">'.$nombre_social.'</td>
        
            </tr>
            </table>

            <table width="100%" border="0">
            <tr>
                <td  style="border: 0px solid; text-align: left;width:10%; ">RUN:</td>
                <td  style="border: 1px solid; text-align: left;width:35%; background-color:#d7ecec; ">'.$doc["rut_completo"].'</td>
                <td  style="width:20%">&nbsp;</td>
                <td  style="border: 0px solid; text-align: left;width:10%; ">Previsión:</td>    
                    
                <td  style="border: 0px solid; text-align: left;width:5%;">Fonasa</td>
                <td  style="border: 1px solid; text-align: left;width:4%; background-color:#d7ecec;">&nbsp;</td>        
                <td  style="border: 0px solid; text-align: left;width:5%;">Isapre</td>      
                <td  style="border: 1px solid; text-align: left ;width:4%; background-color:#d7ecec;">&nbsp;</td>   
                <td  style="border: 0px solid; text-align: left;width:32%;">&nbsp;</td> 

                
            </tr>
            </table>

        <table width="100%" border="0">

     
            <tr>
                <td  style="border: 0px solid; text-align: left;width:3%;">Dirección:</td>
                <td  style="border: 1px solid; text-align: left;width:40%;  background-color:#d7ecec">'.$doc["direccion"].'</td>
                <td  style="border: 0px solid; text-align: left;width:3%; ">&nbsp;Comuna:</td>
                <td  style="border: 1px solid; text-align: left;width:40%;  background-color:#d7ecec">'.$doc["comuna"].'</td>
            </tr>
            </table>

             <table width="100%" border="0" >
            <tr>
                <td style="border: 0px solid; text-align: left;width:3%;">Región:</td>
                <td style="border: 1px solid; text-align: left;width:27%; background-color:#d7ecec">'.$doc["region"].'</td>
                <td style="border: 0px solid; text-align: left;width:5%;">&nbsp;Teléfono</td>
                <td style="border: 1px solid; text-align: left;width:20%; background-color:#d7ecec">'.$doc["telefono1"].'</td>
                <td style="border: 0px solid; text-align: left;width:13%;">&nbsp;Correo electrónico:</td>
                <td style="border: 1px solid; text-align: left; background-color:#d7ecec;width:32%">'.$doc["correo_electronico"].'</td>
            </tr>

            <tr>
                <td colspan="8" style="border-bottom: 2px solid #000;">&nbsp;</td>
            </tr>
            </table>
    

        <table width="100%" border="0">
            <tr>
                <td colspan="7" style="border: 0px solid; text-align: left;"><strong>Información médica</strong></td>
            </tr>
            <tr colspan="7" style="border: 0px solid; text-align: left;">
            <!-- <tr> -->
                <table width="100%" border="0">
                    <tr>
                        <td style="border: 0px solid; text-align: left;width:20%;">
                            Problema de Salud GES:
                        </td>
                        <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:80%;">
                            '.$doc["diagnostico_ges"].'
                        </td>
                    </tr>
                <!-- </table> -->
                </table>
                <!-- <td style="border: 0px solid; text-align: left;width:25%;">
                    Problema de Salud GES:
                </td>
                <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:75%; ">
                .$doc["diagnostico_ges"].
                </td> -->
            <!-- </tr> -->
            </tr>
            <td colspan="7" style="border: 0px solid; text-align: left;">
               <!--  <td style="border: 0px solid; text-align: left;width:25%;">
                    Confirmacion:
                </td>
                <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                    &nbsp;
                </td> -->
                <table width="100%" border="0">
                    <tr>
                        <td style="width: 5%;">
                            Confirmación
                        </td>
                        <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 5%;">
                            X
                        </td>
                        
                        <td style="width: 80%;">
                            &nbsp;
                        </td>
                        <!-- <td style="width: 10%;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                        
                        <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                            &nbsp;
                        </td>
                        <td style="width: 10%;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                       
                         <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                            &nbsp;
                        </td>
                        <td style="width: 10%;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                         <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                            &nbsp;
                        </td>
                        <td style="width: 10%;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </td> -->
                    </tr>
                </table>
            </tr>
            <tr>
                <td colspan="9" style="border-bottom: 2px solid #000;"></td>
            </tr>
            <!-- <tr>
                <td colspan="9">&nbsp;</td>
            </tr> -->
            <!-- <tr>
                <td colspan="7" style="border: 0px solid; text-align: left;"><strong>Información médica</strong></td>
            </tr> -->
            <tr colspan="5" style="border: 0px solid; text-align: left;">
            <!-- <tr> -->
                <table width="100%" border="0">
                    <tr>
                        <td style="border: 0px solid; text-align: left;width:30%;">
                            Problema de salud GES Oncológico:
                        </td>
                        <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:70%;">
                            &nbsp;
                        </td>
                    </tr>
                <!-- </table> -->
                </table>
                <!-- <td style="border: 0px solid; text-align: left;width:25%;">
                    Problema de Salud GES:
                </td>
                <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:75%; ">
                {!! $patologias !!}
                </td> -->
            <!-- </tr> -->
            </tr>
            <tr>
                <td colspan="7">
                    <table width="100%" border="0">
                        <!-- <tr>    
                            <td style="border: 0px solid; text-align: left;width:10%;">
                                Problema de Salud GES:
                            </td>
                        </tr>
                        <tr>    
                            <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:70%; ">
                            {!! $patologias !!}
                            </td>
                        
                            <td style="border: 0px solid; text-align: left;width:10%;">
                                N°
                            </td>
                            
                            <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width:20%;">
                                {!! $numero_notificacion !!}
                            </td>
                        </tr> -->


                <tr>
                     <td colspan="5" style="border: 0px solid; text-align: left;">
                     <table width="100%">
                        <tr>
                            
                            <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                                &nbsp;
                            </td>
                            <td style="width: 5%;">
                                Sospecha
                            </td>
                            <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                                &nbsp;
                            </td>
                            <td style="width: 5%;">
                                Confirmación
                            </td>
                            
                            <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                                &nbsp;
                            </td>
                            <td style="width: 5%;">
                                Etapificación
                            </td>
                            
                            <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                                &nbsp;
                            </td>
                            <td style="width: 5%;">
                                Tratamiento
                            </td>
                           
                             <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                                &nbsp;
                            </td>
                            <td style="width: 5%;">
                                Seguimiento
                            </td>
                             <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width: 3%;">
                                &nbsp;
                            </td>
                            <td style="width: 5%;">
                                Rehabilitación
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="9" style="border-bottom: 2px solid #000;">&nbsp;</td>
            </tr>
                    </table>
                </td>
            
            </tr>
           
             <!-- <tr>
                <td colspan="9" style="border-bottom: 2px solid #000;">&nbsp;</td>
            </tr> -->
        </table>
        <!-- <table width="100%" border="0">
            <tr>
                <td colspan="7" style="border: 0px solid; text-align: left;"><strong>Tipo de atención</strong></td>
            </tr>
        </table> -->
        <table width="100%" border="0">
            <tr>
                <td style="border: 0px solid; text-align: left;width:15%"><strong>Tipo de atención</strong></td>
                <td style="text-align: left; vertical-align:top;width:15%">Presencial</td>
                <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width:5%">X</td>
                <td style="text-align: center; vertical-align:top;width:15%">Teleconsulta</td>
                <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width:5%">&nbsp;</td>
                <td style="width:60%"></td>
            
            </tr>
        </table>
        <table width="100%" border="0">

    
            <tr>
                <td colspan="9" style="border-bottom: 2px solid #000;">&nbsp;</td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td style="border: 0px solid; text-align: left; font-size:12px;"><strong>Constancia</strong></td>
                <td style="border: 0px solid; text-align: left; font-size:10px;">&nbsp;</td>
                <td style="border: 0px solid; text-align: left; font-size:10px;">&nbsp;</td>
            </tr>
            <tr>
                <td style="border: 0px solid; text-align: justify; font-size:12px;">
                    <p style="margin: 0">Tomo conocimiento que tengo derecho  a acceder a las Garantías Explícitas en Salud, en la medida que me atienda en la</p>
                </td>
            </tr>

            <tr>
                <td style="border: 0px solid; text-align: justify; font-size:12px;">
                    <p style="margin: 0">red de Prestadores que asigne el Fonasa o la Isapre, según corresponda.</p>
                </td>
            
            </tr>
        </table>

            <table width="100%" border="0">
            <tr>
                    <td style="text-align: left; vertical-align:top;">
                    
                        <tr>    
                            <td style="border: 0px solid; text-align: left;width:35%">
                                Fecha y hora de notificación
                            </td>
                    
                            <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:65%">
                                '.$doc["fecha_atencion"].'
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </table>
            <br>
            <table width="100%" border="0">
            <tr>

                <td>
                    <table width="100%">
                        <tr>
                            <td style="border: 0px solid; text-align: center; font-size:10px;">
                                <strong>________________________</strong><br>
                                <strong>Informe problema salud GES</strong><br>
                                (Firma de  persona que notifica)
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td style="border: 0px solid; text-align: center; font-size:10px;">
                                <strong>________________________</strong><br>
                                <strong>Tomé conocimiento*</strong><br>
                                (Firma o huella digital de paciente o representante)
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>


            <!-- <tr>
                <td colspan = "3" style="border-bottom: 2px solid #000;">&nbsp;</td>
            </tr> -->
        </table>
        <table width="100%" border="0" style="border-collapse: collapse; border-spacing: 0;">
            <tr>
                <td colspan="8" style="border: 0px solid; text-align: left; font-size:12px;"><strong>*En la modalidad TELECONSULTA, en <u>ausencia de la firma o huella</u>, se registrará el medio a través del cual el/la paciente o su represententante tomó conocimiento:</strong></td>
            </tr>
            <tr>
                
                <td style="text-align: left; vertical-align:top;width:15%">Correo Electrónico</td>
                <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width:5%">&nbsp;</td>
                <td style="text-align: center; vertical-align:top;width:15%">Carta certificada</td>
                <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width:5%">&nbsp;</td>
                <td style="text-align: center; vertical-align:top;width:15%">Otros (indicar)</td>
                <td style="border: 1px solid; text-align: center; background-color:#d7ecec;width:60%">&nbsp;</td>
                <!-- <td style="width:60%"></td> -->
            
            </tr>
            <!-- <tr>
                <td colspan = "6" style="border-bottom: 2px solid #000;">&nbsp;</td>
            </tr> -->
        </table>
        <table width="100%" border="0" style="border-collapse: collapse; border-spacing: 0;">
            <tr>
                <td colspan="8" style="border: 0px solid; text-align: left; font-size:12px;">En caso que la persona que tomó conocimiento no sea el/la paciente, identificar:</td>
            </tr>
        </table>

          <table width="100%" border="0" style="border-collapse: collapse; border-spacing: 0;">
            <tr>
                <td  style="border: 0px solid; text-align: left;width:5%">Nombre&nbsp;</td>
                <td  style="border: 1px solid; text-align: left;width:55% ;background-color:#d7ecec">&nbsp;</td>
                <td  style="border: 0px solid; text-align: center;width:5%">&nbsp;RUN</td>
                <td  style="border: 1px solid; text-align: left;width:30%; background-color:#d7ecec">&nbsp;</td>
            </tr>
            </table>
            <br>
            <table width="100%" border="0" style="border-collapse: collapse; border-spacing: 0;">
            <tr>
                <td  style="border: 0px solid; text-align: left;width:5%">&nbsp;Teléfono</td>
                <td  style="border: 1px solid; text-align: left;width:30%; background-color:#d7ecec">&nbsp;</td>
                <td  style="border: 0px solid; text-align: center;width:15%">&nbsp;Correo electrónico</td>
                <td  style="border: 1px solid; text-align: left;width:45%; background-color:#d7ecec">&nbsp;</td>
            </tr>
            </table>

        <br>
        <table width="100%">
             <tr>
                <td  colspan="6"style="border: 0px solid; text-align: justify; font-size:12px;padding: 0; ">
                    <p style="margin: 0"><strong>Importante: Tenga presente que si no se cumplen las garantías usted puede reclamar ante Fonasa o la</strong></p>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>    
                <td colspan="6" style="border: 0px solid; text-align: justify; font-size:12px;padding: 0; ">
                    <p style="margin: 0"><strong>Isapre, según corresponda. Si la respuesta no es satisfactoria, usted puede recurrir en segunda instancia a</strong></p>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            <tr>        
                <td colspan="6" style="border: 0px solid; text-align: justify; font-size:12px;padding: 0; ">
                    <p style="margin: 0"><strong>la Superintendencia de Salud</strong></p>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            
            </tr>



        </table>';
}

$html .= '</body></html>';
// echo $html;
// Generar el PDF
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();

// Mostrar el PDF en el navegador
$dompdf->stream("documento.pdf", ["Attachment" => false]);

// // Mostrar el PDF en el navegador
// $dompdf->stream("documento.pdf", ["Attachment" => false]);
// Mostrar todos los errores y advertencias
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

// require_once('./public/fpdf/fpdf.php');


// $pdf = new FPDF();

// foreach ($this->reservas_cds as $index => $row) {

//     // print_r($row);Exit();

//     $rut = trim($row["rut_completo"]);
//     $nombrePaciente = trim(utf8_decode($row["nombres"] . ' ' . $row["apellido_paterno"] . ' ' . $row["apellido_materno"]));
//     list($fecha_atencion, $hora_atencion) = explode(' ', $row["fecha_atencion"]);
//     $centro = trim(utf8_decode($row["centro"]));
//     $email = trim(utf8_decode($row["correo_electronico"]));
    
//     $telefono = "";
//     if (!empty($row["telefono1"])) {
//         $telefono = trim($row["telefono1"]);
//     }
//     elseif (!empty($row["telefono2"])) {
//         $telefono = trim($row["telefono2"]);
//     }
//     elseif (!empty($row["telefono3"])) {
//         $telefono = trim($row["telefono3"]);
//     }

//     $nombre_social = "";
//     $direccion = "";
//     $comuna = "";
//     $region = "";
//     $rut_medico = trim($row["med_rut"]);
//     $nombre_medico = trim(utf8_decode($row["med_nombre"] . ' ' . $row["med_apellido_paterno"] . ' ' . $row["med_apellido_materno"]));

//     $pdf->AddPage();
//     $pdf->SetFont('Arial','B',16);
    
//     $pdf->Cell(20,5,utf8_decode("FORMULARIO DE CONSTANCIA INFORMACION AL PACIENTE GES"));
//     $pdf->SetFont('Arial','',9);
//     $pdf->ln();
//     $pdf->cell(60);
//     $pdf->Cell(20,5,utf8_decode("(Articulo 24°,Ley 19.966)"));
//     $pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("_____________________________________________________________________________________________________"));
//     $pdf->ln();
//     $pdf->SetFont('Arial','B',9);
//     $pdf->Cell(20,5,utf8_decode("Datos del prestador"));
//     $pdf->SetFont('Arial','',9);
//     $pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("Institución(Hospital,Clínica,Consultorio,etc.):"));
//     $pdf->cell(70);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(90, 5, utf8_decode('Clínica Oftlamológica Profesor Arentsen S.A'), 1, 0, 'C', True);
    
//     $pdf->ln();$pdf->ln();
//     $pdf->Cell(10,5,utf8_decode("Dirección:"));
//     $pdf->cell(10);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(90, 5, 'Avda. Los Leones 391', 1, 0, 'C', True);
//     $pdf->cell(10);
//     $pdf->Cell(20,5,utf8_decode("Ciudad:"));
//     $pdf->cell(10);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(30, 5, 'Santiago', 1, 0, 'C', True);
//     $pdf->ln();$pdf->ln();
    
//     $pdf->Cell(50,5,utf8_decode("Nombre persona que notifica:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(110, 5, $nombre_medico, 1, 0, 'C', True);
    
//     $pdf->ln();$pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("RUN:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(40, 5, $rut_medico, 1, 0, 'C', True);
//     $pdf->ln();
    
//     $pdf->Cell(20,5,utf8_decode("_____________________________________________________________________________________________________"));
    
//     $pdf->ln();
//     $pdf->SetFont('Arial','B',9);
//     $pdf->Cell(20,5,utf8_decode("Antecedentes del Paciente"));
//     $pdf->SetFont('Arial','',9);
//     $pdf->ln();
//     $pdf->Cell(30,5,utf8_decode("Nombre Legal:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(110, 5, ($nombrePaciente), 1, 0, 'C', True);
    
//     $pdf->ln();$pdf->ln();
//     $pdf->Cell(30,5,utf8_decode("Nombre Social:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(110, 5, ($nombre_social), 1, 0, 'C', True);
    
//     $pdf->ln();$pdf->ln();

//     $pdf->Cell(20,5,utf8_decode("RUN:"));
//     $pdf->cell(20);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(20, 5, $rut, 1, 0, 'C', True);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(20,5,utf8_decode("Prevision:"));
//     $pdf->cell(5);
//     $pdf->Cell(6, 5, 'X', 1, 0, 'C', True);
//     $pdf->Cell(15,5,utf8_decode("Fonasa"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(6, 5, '', 1, 0, 'C', True);
//     $pdf->Cell(20,5,utf8_decode("Isapre"));
//     $pdf->ln();$pdf->ln();
    
//     $pdf->Cell(17,5,utf8_decode("Domicilio:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(55, 5, $direccion, 1, 0, 'C', True);
//     $pdf->cell(5);
//     $pdf->Cell(10,5,utf8_decode("Comuna:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->cell(10);
//     $pdf->Cell(45, 5, $comuna, 1, 0, 'C', True);
//     $pdf->Cell(10,5,utf8_decode("Región:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->cell(10);
//     $pdf->Cell(5, 5, $region, 1, 0, 'C', True);
//     $pdf->ln();$pdf->ln();
        
//     //$pdf->cell(5);
//     $pdf->Cell(15,5,utf8_decode("Teléfono:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(20, 5, $telefono, 1, 0, 'L', True);
    
//     $pdf->Cell(10,5,utf8_decode("Correo electrónico:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->cell(20);
//     // $pdf->Cell(45, 5, $email, 1, 0, 'C', True);
//     $pdf->Cell(70, 5, $email, 1, 0, 'C', True); // Cambia el ancho a 70 y el alto a 10
//     $pdf->ln();
    
//     $pdf->Cell(20,5,utf8_decode("_____________________________________________________________________________________________________"));
        
//     $pdf->ln();
//     $pdf->SetFont('Arial','B',9);
//     $pdf->Cell(20,5,utf8_decode("Informacion medica"));
//     $pdf->SetFont('Arial','B',9);
//     $pdf->cell(100);
//     $pdf->Cell(20,5,utf8_decode(""));
//     $pdf->SetFont('Arial','',9);
//     $pdf->ln();
//     $pdf->Cell(50,5,utf8_decode("Problema de Salud GES:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(80, 5, '', 1, 0, 'C', True);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(5,5,utf8_decode("Nª:"));
//     $pdf->cell(10);
//     $pdf->Cell(10, 5, '', 1, 0, 'C', True);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->ln();$pdf->ln();
        
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(6, 5, '', 1, 0, 'C', True);
//     $pdf->Cell(20,5,utf8_decode("Sospecha"));
    
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->cell(10);
//     $pdf->Cell(6, 5, '', 1, 0, 'C', True);
//     $pdf->Cell(30,5,utf8_decode("Diagnóstico"));
    
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(6, 5, '', 1, 0, 'C', True);
//     $pdf->Cell(30,5,utf8_decode("Tratamiento"));
    
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(6, 5, '', 1, 0, 'C', True);
//     $pdf->Cell(20,5,utf8_decode("Seguimiento"));
    
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(6, 5, '', 1, 0, 'C', True);
//     $pdf->Cell(20,5,utf8_decode("Rehabilitación"));
    
//     $pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("_____________________________________________________________________________________________________"));
    
//     $pdf->ln();
//     $pdf->SetFont('Arial','B',9);
//     $pdf->Cell(40,5,utf8_decode("Tipo de atencion"));
//     $pdf->SetFont('Arial','',9);
//     $pdf->Cell(20,5,utf8_decode("Presencial"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(6, 5, 'X', 1, 0, 'C', True);
    
//     $pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("_____________________________________________________________________________________________________"));
    
//     $pdf->ln();
//     $pdf->SetFont('Arial','B',9);
//     $pdf->Cell(20,5,utf8_decode("Constancia"));
//     $pdf->SetFont('Arial','',9);
//     $pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("Tomo conocimiento que tengo derecho a acceder a las Garantías Explícitas en salud, en la medida que me atiendan en"));
//     $pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("red de prestadores que asigne el Fonasa o la Isapre, según corresponda"));
//     $pdf->ln();$pdf->ln();
//     $pdf->SetFont('Arial','',9);
//     $pdf->Cell(50,5,utf8_decode("Fecha y Hora de notificacion:"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(130, 5, $fecha_atencion." - ".$hora_atencion, 1, 0, 'C', True);
//     $pdf->ln();
//     $pdf->ln();$pdf->ln();
//     $pdf->cell(30);
//     $pdf->Cell(20,5,utf8_decode("________________________"));
//     $pdf->cell(50);
//     $pdf->Cell(20,5,utf8_decode("________________________"));
//     $pdf->ln();
//     $pdf->cell(30);
//     $pdf->Cell(20,5,utf8_decode("Informé Problema Salud GES"));
//     $pdf->cell(50);
//     $pdf->Cell(20,5,utf8_decode("      Tomé conocimiento*"));
//     $pdf->ln();
//     $pdf->cell(30);
//     $pdf->Cell(20,5,utf8_decode("Firma de persona que notifica"));
//     $pdf->cell(30);
//     $pdf->Cell(20,5,utf8_decode("(Firma o huella digital de paciente o representante"));
    
//     $pdf->ln();$pdf->ln();$pdf->ln();
    
//     $pdf->Cell(20,5,utf8_decode("En caso que la persona que tomó conocimiento no sea el/la paciente, identificar :"));
//     $pdf->ln();
    
//     $pdf->SetFont('Arial','',9);
//     $pdf->ln();
//     $pdf->Cell(20,5,utf8_decode("Nombre "));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(100, 5, '', 1, 0, 'C', True);
//     $pdf->cell(10);
//     $pdf->Cell(20,5,utf8_decode("RUN"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(30, 5, '', 1, 0, 'C', True);
//     $pdf->ln();
    
//     $pdf->ln();
    
//     $pdf->Cell(20,5,utf8_decode("Telefono"));
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(20, 5, '', 1, 0, 'C', True);
        
//     $pdf->Cell(10,5,utf8_decode("email"));
//     $pdf->cell(10);
//     $pdf->SetTextColor(2,2,2);
//     $pdf->SetFillColor(215, 236, 236);
//     $pdf->Cell(120, 5, '', 1, 0, 'C', True);
//     $pdf->ln();$pdf->ln();
//     $pdf->SetFont('Arial','B',9);
//     $pdf->Cell(40,5,utf8_decode("Importante : Tenga presente que si no se cumplen las garantías usted puede reclamar ante Fonasa o la"));
//     $pdf->ln();
//     $pdf->Cell(40,5,utf8_decode("Isapre,según corresponda.Si la respuesta no es satisfactoria,usted puede recurrir en segunda instancia a "));
//     $pdf->ln();
//     $pdf->Cell(40,5,utf8_decode("la Superintendencia de Salud"));
    
//     $pdf->ln();

// }

// $pdf->Output("I","Documentos",false);

?>