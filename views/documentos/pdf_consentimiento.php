<?php 
// Mostrar todos los errores y advertencias
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

// Configuracion personalizada
// require_once('./views/Precierre/config/tcpdf_config_alt.php');

// Include the main TCPDF library (search for installation path).
require_once('./public/tcpdf/tcpdf.php');

$rut = $this->rut;
$nombrePaciente = $this->nombrePaciente;
$nombrePaciente = strtoupper($nombrePaciente);
$fecha_atencion = $this->fecha_atencion;
$centro = $this->centro;
$centro = strtoupper($centro);

$centro = trim($centro);

// Verifica si la cadena comienza con "M" (sin importar mayúsculas o minúsculas), para asignar el valor del centro.
if (stripos($centro, 'MAR') === 0) { 
    $centro = 'MARÍN';
}

// Crear instancia de TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Configuración del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Clínica Oftalmológica IOPA');
$pdf->SetTitle('Consentimiento de Atención por Convenio');
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->setFontSubsetting(true);
// $pdf->SetFont('helvetica', '', 10);
$pdf->SetFont('dejavusans', '', 12);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetMargins(20, PDF_MARGIN_TOP, 20);

// Añadir página
$pdf->AddPage();

// Agregar imágenes
$image1 = constant('URL') . 'public/img/logo_iopa2.jpg';
$image2 = constant('URL') . 'public/img/logo_cds_prov.jpg';

// Agregar imágenes JPG con tamaño más grande
$pdf->Image($image1, 15, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Primera imagen
$pdf->Image($image2, 145, 10, 50, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false); // Segunda imagen


// Espacio después de las imágenes
$pdf->Ln(30);

// Contenido HTML del PDF
$html = <<<EOD
<style>
    .title {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        text-decoration: underline;
        margin-bottom: 10px;
    }
    .section {
        margin-top: 10px;
        text-align: justify; /* Texto justificado */
        font-size: 12px;
        line-height: 1.5;
    }
    .section2 {
        text-align: justify; /* Texto justificado */
        font-size: 12px;
        line-height: 1.8;
    }
    ol.sub-list {
        list-style-type: lower-alpha; /* Cambia a letras en minúscula */
    }
    .table {
        border: 1px solid black;
        width: 100%;
        border-collapse: collapse;
    }
    .table td {
        border: 1px solid black;
        padding: 5px;
    }
</style>

<div class="title">CONSENTIMIENTO DE ATENCIÓN POR CONVENIO</div>

<p class="section">Por medio del presente documento se certifica que la <b>Corporación de Desarrollo Social de la Municipalidad de Providencia, RUT: 69.070.301-7</b>, mediante licitación pública <b>ID: 552975-82-LR24 “Servicios de suministro oftalmológicos Providencia”</b>, derivó a <b>Clínica Oftalmológica IOPA</b>, adjudicatario de la línea N°1 para dar resolutividad al ítem <b>“Consulta oftalmológica para vicio de refracción”</b>, a:</p>

<table class="table" style="border-collapse: collapse; width: 100%; font-size: 12px;">
    <tr>
        <td colspan="2" style="border: 0.5px solid black; line-height: 2.5;">NOMBRE PACIENTE: <b>$nombrePaciente</b></td>
    </tr>
    <tr>
        <td style="width: 40%; border: 0.5px solid black; line-height: 2.5;">RUT: <b>$rut</b></td>
        <td style="width: 60%; border: 0.5px solid black; line-height: 2.5;">FECHA DE ATENCIÓN: <b>$fecha_atencion</b></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 0.5px solid black; line-height: 2.5;">CENTRO DE SALUD QUE DERIVA: <b>$centro</b></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 0.5px solid black; line-height: 2.5;">PRESTACIÓN: <b>CONSULTA MEDICA</b></td>
    </tr>
</table>


<div class="section2" >
    <p style="line-height: 0.8;">El paciente individualizado en este documento declara lo siguiente:</p>
    <ol>
        <li>Conocer y aceptar las prestaciones a realizar, que consisten en: 
            <ol class="sub-list">
                <li>Toma de exámenes previos a la evaluación médica (autorrefractometría, tonometría de aire y revisión de anteojos con lensómetro).</li>
                <li>Evaluación médica para pesquisar vicios de refracción (miopía, astigmatismo, hipermetropía y/o presbicia).</li>
                <li>Entrega de receta para confección de anteojos, lágrimas artificiales, orden de derivación u otros, cuando corresponda.</li>
                <li>Entrega de notificación al paciente con patología GES, cuando corresponda.</li>
            </ol>
        </li>
        <li>Autoriza a <b>Clínica Oftalmológica IOPA</b> para acceder y utilizar sus datos personales, registros clínicos y cualquier otra información relevante necesaria para poder entregar la prestación.</li>
        <li>Autoriza a la <b>Dirección de Salud</b> de la <b>Corporación de Desarrollo Social de la Municipalidad de Providencia</b> y a quienes ellos autoricen de forma expresa, para acceder y utilizar tanto su información clínica como datos personales, para los efectos que esta estime conveniente.</li>
        <li>Autoriza a la empresa <b>Inversiones Óptica Prima SPA, RUT: 76.882.088-0,</b> adjudicatario de la línea N°2 <b>“Suministro de anteojos”</b> y a quienes ellos estimen conveniente, para acceder a su receta de anteojos.</li>
        <li>Asimismo, declara que no solicitará por ningún medio y bajo ninguna circunstancia al médico que otorgue la atención, o a cualquier otro funcionario de la Clínica, prestaciones adicionales o diferentes a las establecidas en el convenio celebrado entre Clínica Oftalmológica IOPA y la Corporación de Desarrollo Social de la Municipalidad de Providencia.</li>
        <li>A su vez, a través de este consentimiento, <b>libera expresamente a Clínica Oftalmológica IOPA</b> de toda responsabilidad sobre el uso que la <b>Corporación de Desarrollo Social de Providencia</b> y la empresa <b>Inversiones Óptica Prima SPA,</b> o quienes los representen, puedan dar a sus datos personales e información clínica.</li>
    </ol>
</div>
EOD;

// Escribir contenido en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Agregar espacio vertical antes de la tabla de las firmas
$pdf->Ln(40);

// Tabla de las firmas (directamente con TCPDF)
$tableFirmas = <<<EOD
<table style="width: 100%; font-size: 12px; text-align: center;">
    <tr>
        <td style="width: 50%;"><b>_________________________________</b><br />Firma paciente</td>
        <td style="width: 50%;"><b>_________________________________</b><br />Convenios Clínica IOPA</td>
    </tr>
</table>
EOD;

// Escribir tabla de las firmas
$pdf->writeHTML($tableFirmas, true, false, true, false, '');

$pdf->Ln(10);

$pieHtml = <<<EOD
<p style="text-align: justify; font-size: 11px;line-height: 1.5;color: #5a5a5a;">La cuenta debe ser pagada a través de la previsión “CDS Providencia” por el total del arancel cargado en REBSOL. Este documento se entenderá válido únicamente si cuenta con firma y timbre original del Área de Convenios de Clínica IOPA.</p>
EOD;

$pdf->writeHTML($pieHtml, true, false, true, false, '');


// Salida del PDF
$pdf->Output('consentimiento_atencion.pdf', 'I');
?>