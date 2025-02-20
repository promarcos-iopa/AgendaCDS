<?php

session_start();

include_once '../../../libreria/PHPExcel.php';
include_once "../../../libreria/php/coneccionBD.php";


$nombreArchivo = $_FILES['archivos']['name'];
//print_r($nombreArchivo);
//array_push($this->arrObj, $arrTemp);	

//crea y lee excel
$tmpfname = $_FILES['archivos']['tmp_name'];
$leerExcel = PHPExcel_IOFactory::createReaderForFile($tmpfname);

$excelObj = $leerExcel->load($tmpfname);

$hoja = $excelObj->getSheet(0);
$filas = $hoja->getHighestRow();
$columnas = $hoja->getHighestColumn();
//obtener las dimensiones de la hoja con:
$dimension = $hoja->calculateWorksheetDimension();
// $Cantidad = 0;
// $error=0;
// $numSinCodigo = 0;

//$arrObjImportar = new ImportarExcelOC();

$arrObjError = array();
//$arrObj2 = array();
//$arrObjNoCargados = array();
//$ObjImportar = array();
$ObjImportar = new ImportarRelacionOC();   
$ObjNoImportar = new ImportarRelacionOC();   
$obj = new ImportarRelacionOC();  




if ($columnas == 'AD'){


    $nOrdenCompraAnterior = '';
    
    $nOrdenCompra = $hoja->getCellByColumnAndRow(0,14)->getValue();
    $centroGestion = $hoja->getCellByColumnAndRow(1,1)->getValue();
    $fechaDesde = $hoja->getCellByColumnAndRow(1,9)->getValue();
    $fechaHasta = $hoja->getCellByColumnAndRow(1,10)->getValue(); 
    $dia = substr($fechaHasta, 0,2);
    $mes = substr($fechaHasta, 3,2);
    $ano = substr($fechaHasta, 6,4);

    $fechaHastaImportacion = $ano.'-'.$mes.'-'.$dia;

    $numIndice =stripos( $nOrdenCompra,'-');
    $codigoCentro = substr($nOrdenCompra, 0,  $numIndice);
    $fechaUltimaImportacion ='';

    $objCnn = new coneccion();
    $cnn = $objCnn->accion();
    $objRelacionOC = new ImportarRelacionOC($cnn);        
    if ($objRelacionOC->cargarUltimaImportacion($cnn, $codigoCentro,'','','S')){
        $fechaUltimaImportacion = $objRelacionOC->arrObjHistorial[0]["fechaHasta"];
        $d = substr($fechaUltimaImportacion, 0,2);
        $m = substr($fechaUltimaImportacion, 3,2);
        $a = substr($fechaUltimaImportacion, 6,4);
        $fechaUltimaImportacion1 = $a.'-'.$m.'-'.$d;
        //$fechaUltimaImportacion = '25-10-2023';
    
    }
    
    if ($fechaUltimaImportacion =='') {

        for ($i=14; $i<= $filas; $i++){

            
            $obj->centroGestion = $hoja->getCellByColumnAndRow(1,1)->getValue();
            //$nombreCG = $hoja->getCellByColumnAndRow(0,1)->getValue();
            $obj->fechaDesde = $hoja->getCellByColumnAndRow(1,9)->getValue();
            $obj->fechaHasta = $hoja->getCellByColumnAndRow(1,10)->getValue(); 
    
            $obj->oc = $hoja->getCellByColumnAndRow(0,$i)->getValue();
            $nOrdenCompra = $hoja->getCellByColumnAndRow(0,$i)->getValue();
            if($nOrdenCompra !=''){

           
    
          
                $fechaValida = FALSE;
                $obj->fecha = $hoja->getCellByColumnAndRow(2,$i)->getValue();
                $obj->rutProveedor = $hoja->getCellByColumnAndRow(7,$i)->getValue();
                // $obj->cabOpeFecha = $hoja->getCellByColumnAndRow(3,$i)->getValue();
                $obj->codigoMaterial = $hoja->getCellByColumnAndRow(9,$i)->getValue();
                $obj->descripcionMaterial = $hoja->getCellByColumnAndRow(10,$i)->getValue();
                $obj->partida = $hoja->getCellByColumnAndRow(14,$i)->getValue();
                $obj->unidad = $hoja->getCellByColumnAndRow(15,$i)->getValue(); 
                $obj->cantidadTotal = $hoja->getCellByColumnAndRow(16,$i)->getValue();
                $obj->cantidadRecibida = $hoja->getCellByColumnAndRow(22,$i)->getValue();
                $obj->saldo = $hoja->getCellByColumnAndRow(25,$i)->getValue();
                $obj->estadoOCIC = $hoja->getCellByColumnAndRow(28,$i)->getValue();
        
                if($nOrdenCompra != $nOrdenCompraAnterior || $nOrdenCompraAnterior =='' ) {
                    
                    $existeRelacionOC ='';
                    $existeRelacionCentroGestion ='';
        
        
                    //Consultar exitencia de relacion OC
                    $objCnn = new coneccion();
                    $cnn = $objCnn->accion();
                    $objRelacionOC = new RelacionGrupoOC($cnn);        
                    if ($objRelacionOC->cargarGrupoMaterialRelacinado($cnn,  $nOrdenCompra,'','')){
                        $existeRelacionOC = $objRelacionOC->objRelacionGrupoMaterialOC[0]["ordenCompra"];
                        $codGrupoMaterial = $objRelacionOC->objRelacionGrupoMaterialOC[0]["codigoGrupo"];
                        $obj->nombreGrupo = $objRelacionOC->objRelacionGrupoMaterialOC[0]["nombreGrupo"];
                        $obj->codigoCentroGestion = $objRelacionOC->objRelacionGrupoMaterialOC[0]["codigoCentroGestion"];
                        $existeRelacionCentroGestion = $objRelacionOC->objRelacionGrupoMaterialOC[0]["codigoCentroGestion"];
                        $obj->nombreCentroGestion = $objRelacionOC->objRelacionGrupoMaterialOC[0]["nombreCentroGestion"];
         
                    }
                   
                }
        
                //$existeRelacionOC = '';
                if ($existeRelacionOC !=''){
                    $arrTemp =array();
                    $arrTemp = (array) $obj;
                    array_push($ObjImportar->arrObj, $arrTemp);
        
                }else{
        
                    //$obj->mensaje='OC';
                    $arrTemp =array();
                    $arrTemp = (array)  $obj;
                    array_push($ObjNoImportar->arrObj, $arrTemp);	
        
                       
        
                   
                   
                }
                $nOrdenCompraAnterior = $nOrdenCompra;
                
            }
           
            
        }
        fncCrearExcelNoRelacionadas($ObjNoImportar);
        fncCrearExcelRelacionadas($ObjImportar);
        echo  json_encode($ObjImportar);
        

    }else  if (date( $fechaHastaImportacion) >= date($fechaUltimaImportacion1) ){
        for ($i=14; $i<= $filas; $i++){

            
            $obj->centroGestion = $hoja->getCellByColumnAndRow(1,1)->getValue();
            //$nombreCG = $hoja->getCellByColumnAndRow(0,1)->getValue();
            $obj->fechaDesde = $hoja->getCellByColumnAndRow(1,9)->getValue();
            $obj->fechaHasta = $hoja->getCellByColumnAndRow(1,10)->getValue(); 
    
            $obj->oc = $hoja->getCellByColumnAndRow(0,$i)->getValue();
            $nOrdenCompra = $hoja->getCellByColumnAndRow(0,$i)->getValue();
            if($nOrdenCompra !=''){
    
          
                $fechaValida = FALSE;
                $obj->fecha = $hoja->getCellByColumnAndRow(2,$i)->getValue();
                $obj->rutProveedor = $hoja->getCellByColumnAndRow(7,$i)->getValue();
                // $obj->cabOpeFecha = $hoja->getCellByColumnAndRow(3,$i)->getValue();
                $obj->codigoMaterial = $hoja->getCellByColumnAndRow(9,$i)->getValue();
                $obj->descripcionMaterial = $hoja->getCellByColumnAndRow(10,$i)->getValue();
                $obj->partida = $hoja->getCellByColumnAndRow(14,$i)->getValue();
                $obj->unidad = $hoja->getCellByColumnAndRow(15,$i)->getValue(); 
                $obj->cantidadTotal = $hoja->getCellByColumnAndRow(16,$i)->getValue();
                $obj->cantidadRecibida = $hoja->getCellByColumnAndRow(22,$i)->getValue();
                $obj->saldo = $hoja->getCellByColumnAndRow(25,$i)->getValue();
                $obj->estadoOCIC = $hoja->getCellByColumnAndRow(28,$i)->getValue();
        
                if($nOrdenCompra != $nOrdenCompraAnterior || $nOrdenCompraAnterior =='' ) {
                    
                    $existeRelacionOC ='';
                    $existeRelacionCentroGestion ='';
        
        
                    //Consultar exitencia de relacion OC
                    $objCnn = new coneccion();
                    $cnn = $objCnn->accion();
                    $objRelacionOC = new RelacionGrupoOC($cnn);        
                    if ($objRelacionOC->cargarGrupoMaterialRelacinado($cnn,  $nOrdenCompra,'','')){
                        $existeRelacionOC = $objRelacionOC->objRelacionGrupoMaterialOC[0]["ordenCompra"];
                        $codGrupoMaterial = $objRelacionOC->objRelacionGrupoMaterialOC[0]["codigoGrupo"];
                        $obj->nombreGrupo = $objRelacionOC->objRelacionGrupoMaterialOC[0]["nombreGrupo"];
                        $obj->codigoCentroGestion = $objRelacionOC->objRelacionGrupoMaterialOC[0]["codigoCentroGestion"];
                        $existeRelacionCentroGestion = $objRelacionOC->objRelacionGrupoMaterialOC[0]["codigoCentroGestion"];
                        $obj->nombreCentroGestion = $objRelacionOC->objRelacionGrupoMaterialOC[0]["nombreCentroGestion"];
         
                    }
                   
                }
        
                //$existeRelacionOC = '';
                if ($existeRelacionOC !=''){
                    $arrTemp =array();
                    $arrTemp = (array) $obj;
                    array_push($ObjImportar->arrObj, $arrTemp);
        
                }else{
        
                    //$obj->mensaje='OC';
                    $arrTemp =array();
                    $arrTemp = (array)  $obj;
                    array_push($ObjNoImportar->arrObj, $arrTemp);	
        
                       
        
                   
                   
                }
                $nOrdenCompraAnterior = $nOrdenCompra;
            }    
    
           
            
        }
        fncCrearExcelNoRelacionadas($ObjNoImportar);
        fncCrearExcelRelacionadas($ObjImportar);
        echo  json_encode($ObjImportar);

    }else{
        $obj->mensaje='Error 2';
        $arrTemp =array();
        $arrTemp = (array)  $obj;
        array_push($ObjImportar->arrObj, $arrTemp);	
        echo  json_encode($ObjImportar);
       
    }

    

}else{
   
    $obj->mensaje='Error 1';
    $arrTemp =array();
    $arrTemp = (array)  $obj;
    array_push($ObjImportar->arrObj, $arrTemp);	
    echo  json_encode($ObjImportar);
}
 


?>