<?php 
// Mostrar todos los errores y advertencias
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar opciones de Dompdf
$options = new Options();
// echo "<pre>";
// var_dump($this);
// echo "</pre>";

$html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body style="font-family: Arial, Helvetica, sans-serif; font-size:10px;">

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
                <td colspan="6" style="border: 1px solid; text-align: center; background-color:#d7ecec">'.$this->nombre_medico.'</td>
            </tr>
            <tr>
                <td colspan="1" style="border: 0px solid; text-align: left;width:5%">&nbsp;RUN:</td>
                <td colspan="2" style="border: 1px solid; text-align: center; background-color:#d7ecec;width:20%">'.$this->rut_medico.'</td>
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
                <td  style="border: 1px solid; text-align: left; background-color:#d7ecec;width=80%;">'.$this->nombrePaciente.'</td>
        
            </tr>

                <tr>
                <td  style="border: 0px solid; text-align: left; width:13%">Nombre social:</td>
                <td  style="border: 1px solid; text-align: left; background-color:#d7ecec;width=80%;">'.$this->nombre_social_paciente.'</td>
        
            </tr>
            </table>

            <table width="100%" border="0">
            <tr>
                <td  style="border: 0px solid; text-align: left;width:10%; ">RUN:</td>
                <td  style="border: 1px solid; text-align: left;width:35%; background-color:#d7ecec; ">'.$this->rut.'</td>
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
                <td  style="border: 1px solid; text-align: left;width:40%;  background-color:#d7ecec">'.$this->direccion.'</td>
                <td  style="border: 0px solid; text-align: left;width:3%; ">&nbsp;Comuna:</td>
                <td  style="border: 1px solid; text-align: left;width:40%;  background-color:#d7ecec">'.$this->comuna.'</td>
            </tr>
            </table>

             <table width="100%" border="0" >
            <tr>
                <td style="border: 0px solid; text-align: left;width:3%;">Región:</td>
                <td style="border: 1px solid; text-align: left;width:27%; background-color:#d7ecec">'.$this->region.'</td>
                <td style="border: 0px solid; text-align: left;width:5%;">&nbsp;Teléfono</td>
                <td style="border: 1px solid; text-align: left;width:20%; background-color:#d7ecec">'.$this->telefono.'</td>
                <td style="border: 0px solid; text-align: left;width:13%;">&nbsp;Correo electrónico:</td>
                <td style="border: 1px solid; text-align: left; background-color:#d7ecec;width:32%">'.$this->email.'</td>
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
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
            <tr colspan="7" style="border: 0px solid; text-align: left;">
            <!-- <tr> -->
                <table width="100%" border="0">
                    <tr>
                        <td style="border: 0px solid; text-align: left;width:30%;">
                            Problema de salud GES Oncológico:
                        </td>
                        <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:70%;">
                            
                    </tr>
                <!-- </table> -->
                </table>
                <!-- <td style="border: 0px solid; text-align: left;width:25%;">
                    Problema de Salud GES:
                </td>
                <td style="border: 1px solid; text-align: left; vertical-align:top; background-color:#d7ecec;width:75%; ">
                
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



        </table>

    </body>
    ';
// echo $html;
// Cargar el HTML en Dompdf
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter', 'portrait');
$dompdf->render();

// Mostrar el PDF en el navegador
$dompdf->stream("documento.pdf", ["Attachment" => false]);
    
?>