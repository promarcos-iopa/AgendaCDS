<?php
//session_start();
include_once 'public/PHPExcel.php';
include_once 'public/PHPExcel/Writer/Excel2007.php';

class FacturacionModel extends Model
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

        // echo "<pre>";
        // var_dump('datos get_pacientes_RS');
        // var_dump($fecha);
        // var_dump($fecha_hasta);
        // echo "</pre>";
        // exit();
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



 

    //ACTUALIZADO PARA FILTRAR POR RUT DEL PACIENTE
    public function get_pacientes_CDS($rut, $fecha, $fecha_hasta) {
        $items = [];
        $items1 = [];
        // TEST
        // $rut = "7354543-9";
        // $fecha = "2025-01-13";
        // $fecha_hasta = "2025-01-13";

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

            // echo "<pre>";
            // var_dump('datos get_pacientes_CDS');
            // var_dump($query);
            // echo "</pre>";
            // exit();
    
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



    public function documentos_facturacion($centro, $anio, $mes) {
        try {
            // Consulta SQL segura con placeholders
            $query = "SELECT * FROM documentos_facturacion 
                      WHERE centro = :centro 
                      AND mes = :mes 
                      AND anio = :anio";
    
            // Preparar la consulta
            $stmt = $this->db->connect()->prepare($query);
            $stmt->bindParam(':centro', $centro, PDO::PARAM_STR);
            $stmt->bindParam(':mes', $mes, PDO::PARAM_STR);
            $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
            
            // Ejecutar la consulta
            $stmt->execute();
    
            // Obtener todos los resultados
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $resultados; // Retorna un array con todos los datos
    
        } catch (PDOException $e) {
            error_log("Error en documentos_facturacion: " . $e->getMessage());
            return [];
        }
    }




    public function descargar_Excel_cierreMes_GES($datos_informe, $centro_selecionado){
        ini_set('memory_limit', '2012M'); // Ajusta el valor según sea necesario
        set_time_limit(0); // Esto eliminará el límite de tiempo de ejecución
        try {

           
            // Convertir el segundo string (JSON) en un arreglo
            $data = json_decode($datos_informe, true);


            // echo "<pre>";
            // var_dump('descargar_Excel_Prestacion');
            // var_dump($centro_selecionado);
            // var_dump($data);
            // echo "</pre>";
            // exit();

            



            //$nombreProfesional = $data[0]['nombre_profesional'];
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setLastModifiedBy("IOPA");
            $objPHPExcel->getProperties()->setTitle("Empresas");
            $objPHPExcel->getProperties()->setSubject("EmpresasiOPA");
            
            $objPHPExcel->setActiveSheetIndex(0);
            $numDetalle = count($data);  
            // var_dump($arreglo);
            // var_dump($numDetalle);
            // echo "</pre>";
            // exit();

            // ENCABEZADO EXCEL EN MAYÚSCULAS Y NEGRITA
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "RUT");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "PACIENTE");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "FECHA N");
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', "SEXO");
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', "CENTRO");
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', "FECHA AGENDA");
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', "LENTES INDICADOS");
            // CAMPOS DIOGTRIA
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', "ESF_OD_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', "CIL_OD_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', "ESF_OI_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', "CIL_OI_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', "ESF_OD_CERCA");
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', "CIL_OD_CERCA");
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', "ESF_OI_CERCA");
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', "CIL_OI_CERCA");
            // FIN
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', "DIAGNÓSTICO");
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', "TIPO ATENCION");
            $objPHPExcel->getActiveSheet()->SetCellValue('R1', "COSTO ($)");
            $objPHPExcel->getActiveSheet()->SetCellValue('S1', "MEDICO TRATANTE");

             // Aplicar formato de negrita al encabezado
            $encabezadoEstilo = $objPHPExcel->getActiveSheet()->getStyle('A1:S1');
            $encabezadoFuente = $encabezadoEstilo->getFont();
            $encabezadoFuente->setBold(true);

            if($centro_selecionado == "ALESSANDRI"){
                $centros_validos = ['ALESSANDRI', 'alessandri', 'MARIN', 'MARÍN'];

            }else if($centro_selecionado == "AGUILUCHO" ){
                $centros_validos = ['AGUILUCHO','Aguilucho','ANDACOLLO'];

            }else{
                $centros_validos = ['LENG'];
            }

            $fila = 2;
            $contador=0;
            $pacientes_atendidos = 0;
            for ($i = 0; $i < $numDetalle; $i++){
                //PROGRAMA
                $fecha_nacimiento = $data[$i]['fecha_nacimiento'];
                $fecha_atencion = $data[$i]['fecha_atencion'];
                // Dividir la cadena en fecha y hora
                list($fecha, $hora) = explode(' ', $fecha_atencion);
                //$fecha_actual = date('Y-m-d');
                // Calcular la edad
                $edad = date_diff(date_create($fecha_nacimiento), date_create($fecha))->y;
                // Determinar el texto a mostrar (PROGRAMA)
                $programa = ($edad >= 65) ? 'GES' : 'RESOLUTIVIDAD';

                $centro = '';
                if (strpos($data[$i]['centro'], 'Í') !== false) {
                    $centro = str_replace('Í', 'ÍN', $data[$i]['centro']); 
                    $centro = preg_replace('/N.*/', 'N', $centro); 
                } else {
                    $centro = $data[$i]['centro'];
                }
                $centro = strtoupper($centro);
                $centro = trim($centro);


                // if ($data[$i]['rut_completo'] =='3683156-1'){
                //     echo "<pre>";
                //     var_dump($data[$i]['rut_completo']);
                //     var_dump($data[$i]["codigo_tipo_prestacion_agenda"]);
                //     var_dump($data[$i]['recepcionado']);
                //     var_dump($data[$i]['codigo_pago_cuenta']);
                //     var_dump($centro);
                //     echo "</pre>";
                //     exit();

                // }

                // echo "<pre>";
                // var_dump('VALOR FINAL');
                // var_dump($centro);
                // echo "</pre>";
                // exit();

            
                
                // Filtrar pacientes que estén en los centros seleccionados
                // AGREGAR A LA VALIDACION TIPO DE ATENCION SEA IGUAL A CONSULTA
                if (in_array($centro, $centros_validos) && $data[$i]["codigo_tipo_prestacion_agenda"] == 1 && $data[$i]['recepcionado'] == 1 &&  $data[$i]['codigo_pago_cuenta'] >= 2 && $programa =="GES") {
                    $pacientes_atendidos ++;
                     // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_pnatural']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_completo']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, $data[$i]['nombres'].' ' .$data[$i]['apellido_paterno'].' '.$data[$i]['apellido_materno']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $data[$i]['fecha_nacimiento']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fila, $data[$i]['sexo']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fila, strtoupper($data[$i]['sexo']));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fila, $centro);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fila, $data[$i]['fecha_atencion']);
                    //Lentes indicados
                    //valida que a lo menos un registro tenga datos receta de lentes lejos
                    $receta_lejos = (bool) (!empty($data[$i]["adicion_lejos_od"]) || !empty($data[$i]["adicion_lejos_oi"]) || !empty($data[$i]["cil_od"]) || !empty($data[$i]["cil_oi"]) || !empty($data[$i]["eje_od"]) || !empty($data[$i]["eje_oi"]));
                    //valida que a lo menos un registro tenga datos receta de lentes cerca
                    $receta_cerca = (bool) (!empty($data[$i]["adicion_cerca_od"]) || !empty($data[$i]["adicion_cerca_oi"]) || !empty($data[$i]["cil_cerca_od"]) || !empty($data[$i]["cil_cerca_oi"]) || !empty($data[$i]["eje_cerca_od"]) || !empty($data[$i]["eje_cerca_oi"]));
                    $cantidad_lentes = ($receta_lejos && $receta_cerca) ? 2 : (($receta_lejos || $receta_cerca) ? 1 : 0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fila, $cantidad_lentes);
                    //CAMPO DIOGTERIA
                    // lEJOS
                    // $valor = $data[$i]['adicion_lejos_od'];
                    // // Verifica si el valor es positivo para agregar el signo "+"
                    // $formatoValor = ($valor > 0) ? sprintf("+%.2f", $valor) : sprintf("%.2f", $valor);
                    // $objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$fila, $formatoValor, PHPExcel_Cell_DataType::TYPE_STRING);
                    // $objPHPExcel->getActiveSheet()->SetCellValueExplicit('H'.$fila, sprintf("%+.2f", $data[$i]['adicion_lejos_od']), PHPExcel_Cell_DataType::TYPE_STRING);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fila, $data[$i]['adicion_lejos_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fila, $data[$i]['cil_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('J'.$fila, $data[$i]['adicion_lejos_oi']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('K'.$fila, $data[$i]['cil_oi']);
                   
                    // CERCA
                    // rpfc.rc_od_sph_m AS esf_cerca_od, --> ESF OD
                    // rpfc.rc_oi_sph_m AS esf_cerca_oi, --> ESF OI
                    // $objPHPExcel->getActiveSheet()->SetCellValue('L'.$fila, $data[$i]['esf_cerca_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('M'.$fila, $data[$i]['cil_cerca_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('N'.$fila, $data[$i]['esf_cerca_oi']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('O'.$fila, $data[$i]['cil_cerca_oi']);

                    //new formatos a las celdas de dioptria visual
                    $valores = [
                        'H' => $data[$i]['adicion_lejos_od'],
                        'I' => $data[$i]['cil_od'],
                        'J' => $data[$i]['adicion_lejos_oi'],
                        'K' => $data[$i]['cil_oi'],
                        'L' => $data[$i]['esf_cerca_od'],
                        'M' => $data[$i]['cil_cerca_od'],
                        'N' => $data[$i]['esf_cerca_oi'],
                        'O' => $data[$i]['cil_cerca_oi']
                    ];
                    
                    foreach ($valores as $columna => $valor) {
                        $formatoValor = ($valor > 0) ? sprintf("+%.2f", $valor) : sprintf("%.2f", $valor);
                        
                        $objPHPExcel->getActiveSheet()->SetCellValueExplicit(
                            $columna.$fila, 
                            $formatoValor, 
                            PHPExcel_Cell_DataType::TYPE_STRING
                        );
                    }


                    //Diagnostico GES 
                    $texto_diagnostico = strtoupper($data[$i]["diagnostico_ges"]); // Convertir a mayúsculas para comparación
                    $miopia = (strpos($texto_diagnostico, "MIOPÍA") !== false) ? "MIOPÍA" : "";
                    $astigmatismo = (strpos($texto_diagnostico, "ASTIGMATISMO") !== false) ? "ASTIGMATISMO" : "";
                    $presbicia = (strpos($texto_diagnostico, "PRESBICIA") !== false) ? "PRESBICIA" : "";
                    $hipermetropia = (strpos($texto_diagnostico, "HIPERMETROPÍA") !== false) ? "HIPERMETROPÍA" : "";
                    $diagnostico_ges = $miopia.' '.$astigmatismo.' '.$presbicia.' '.$hipermetropia;
                    if ($diagnostico_ges =="   "){
                        $diagnostico_ges = $data[$i]["detalle_atencion"];
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$fila, $diagnostico_ges);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$fila, 'CONSULTA');
                    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$fila, 25500);

                    
                    // // Estado atencion  y colores
                    // $recepcionado = $data[$i]['recepcionado'] ?? null;
                    // $codigo_pago_cuenta = $data[$i]['codigo_pago_cuenta'] ?? null;
                    // $fecha_atencion = isset($data[$i]['fecha_atencion']) ? strtotime($data[$i]['fecha_atencion']) : null;
                    // $fechaHora_actual = time();

                    // // Definir estados y colores
                    // $estados = [
                    //     'Asistió'  => ['fondo' => 'a6dfa6', 'texto' => '008000'], // Verde
                    //     'Ausente'  => ['fondo' => 'f8d7da', 'texto' => 'FF0000'], // Rojo
                    //     'Agendado' => ['fondo' => 'f1c97e', 'texto' => 'FFA500']  // Naranjo
                    // ];

                    // $estado = ($fecha_atencion !== null && $fecha_atencion <= $fechaHora_actual) 
                    //             ? (($recepcionado == 1 && $codigo_pago_cuenta >= 2) ? 'Asistió' : 'Ausente') 
                    //             : 'Agendado';

                    // $color_fondo = $estados[$estado]['fondo'];
                    // $color_texto = $estados[$estado]['texto'];

                    // // Asignar valores y aplicar formato en Excel
                    // $celda_estado = 'I'.$fila;
                    // $objPHPExcel->getActiveSheet()->SetCellValue($celda_estado, $estado)
                    //     ->getStyle($celda_estado)->applyFromArray([
                    //         'fill' => ['fillType' => PHPExcel_Style_Fill::FILL_SOLID, 'startColor' => ['rgb' => $color_fondo]],
                    //         'font' => ['color' => ['rgb' => $color_texto], 'bold' => true]
                    //     ]);

                    // Nombre medico
                    $nombre_medico = $data[$i]["med_nombre"].' '.$data[$i]["med_apellido_paterno"].' '.$data[$i]["med_apellido_materno"];
                    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$fila,  strtoupper($nombre_medico));


                    
                    $costo_total_atenciones += 25500;
                    $fila++; // Incremento de $fila en 1
                    $contador++;
                    //sleep(1); // Espera de 1 segundo para no sobrecargar 
                    if($contador==299)
                    {
                        $contador=0;
                        sleep(1);
                    }

                }
               
            }

            $fila += 4;
            // Unir celdas B y C en la fila correspondiente
            $objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");

            // Aplicar estilos: centrar texto, agregar bordes, color de fondo y color de fuente
            $styleArray = [
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allborders' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FFFF00'], // Fondo amarillo
                ],
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FF8000'], // Texto naranja
                ],
            ];

            // Aplicar el estilo a las celdas unidas
            $objPHPExcel->getActiveSheet()->getStyle("B{$fila}:C{$fila}")->applyFromArray($styleArray);

            // Insertar el texto "RESUMEN" en la celda unida
            $objPHPExcel->getActiveSheet()->SetCellValue("B{$fila}", "RESUMEN");
            $fila += 1;
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, 'Total Pacientes Atendidos');
            // Aplicar estilo de negrita al texto
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
            // $i = cantidad pacientes atendidos 
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $pacientes_atendidos);
            $fila += 1;
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, 'Costo Atención');
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
            // $i = cantidad pacientes atendidos 
            // $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, 25500);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, '$' . number_format(25500, 0, ',', '.'));
            $fila += 1;
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, 'TOTAL ATENCIONES');
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
            // $i = cantidad pacientes atendidos 
            // $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $costo_total_atenciones);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, '$' . number_format($costo_total_atenciones, 2, '.', '.'));
            


            if ($centro_selecionado == "ALESSANDRI"){
                $centro_informe = 'informe_centro_alessandri';
                $archivo_excel = 'Informe_programa_ges_alessandri.xlsx';

            }else if($centro_selecionado == "AGUILUCHO"){
                $centro_informe = 'informe_centro_aguilucho';
                $archivo_excel = 'Informe_programa_ges_aguilucho.xlsx';
                

            }else if($centro_selecionado == "LENG"){
                $centro_informe = 'informe_centro_leng';
                $archivo_excel = 'Informe_programa_ges_leng.xlsx';

            }
            

            // Crear el escritor para Excel
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // Limpiar cualquier contenido anterior del búfer de salida
            ob_end_clean();

            // Encabezado para indicar el tipo de archivo Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            // Nombre del archivo de salida con extensión xlsx
            $informe = 'Informe_cierre';
            header('Content-Disposition: attachment; filename="Importacion' . $informe . '.xlsx"');

            // Guardar el archivo Excel en el servidor
            // $objWriter->save('views/facturacion/. $centro_informe./$archivo_excel');
            $objWriter->save("views/facturacion/$centro_informe/$archivo_excel");

            return true;

        } catch (PDOException $e) {

            echo $e->getMessage(); 
            return false;
        }
    }   




    public function descargar_Excel_cierreMes_RES($datos_informe, $centro_selecionado){
        ini_set('memory_limit', '2012M'); // Ajusta el valor según sea necesario
        set_time_limit(0); // Esto eliminará el límite de tiempo de ejecución
        try {

          
            // Convertir el segundo string (JSON) en un arreglo
            $data = json_decode($datos_informe, true);

            // echo "<pre>";
            // var_dump('descargar_Excel_cierreMes_RES');
            // var_dump($centro_selecionado);
            // var_dump($data);
            // echo "</pre>";
            // exit();

            



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
             $objPHPExcel->getActiveSheet()->SetCellValue('F1', "FECHA AGENDA");
             $objPHPExcel->getActiveSheet()->SetCellValue('G1', "LENTES INDICADOS");
               // CAMPOS DIOGTRIA
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', "ESF_OD_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', "CIL_OD_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', "ESF_OI_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', "CIL_OI_LEJOS");
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', "ESF_OD_CERCA");
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', "CIL_OD_CERCA");
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', "ESF_OI_CERCA");
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', "CIL_OI_CERCA");
            // FIN
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', "DIAGNÓSTICO");
            $objPHPExcel->getActiveSheet()->SetCellValue('Q1', "TIPO ATENCION");
            $objPHPExcel->getActiveSheet()->SetCellValue('R1', "COSTO ($)");
            $objPHPExcel->getActiveSheet()->SetCellValue('S1', "MEDICO TRATANTE");
            //  $objPHPExcel->getActiveSheet()->SetCellValue('H1', "DIAGNÓSTICO");
            //  $objPHPExcel->getActiveSheet()->SetCellValue('I1', "TIPO ATENCION");
            //  $objPHPExcel->getActiveSheet()->SetCellValue('J1', "COSTO ($)");
            //  $objPHPExcel->getActiveSheet()->SetCellValue('K1', "MEDICO TRATANTE");
 
              // Aplicar formato de negrita al encabezado
             $encabezadoEstilo = $objPHPExcel->getActiveSheet()->getStyle('A1:S1');
             $encabezadoFuente = $encabezadoEstilo->getFont();
             $encabezadoFuente->setBold(true);
             
            
            if($centro_selecionado == "ALESSANDRI"){
                $centros_validos = ['ALESSANDRI', 'alessandri','MARIN', 'MARÍN'];

            }else if($centro_selecionado == "AGUILUCHO" ){
                $centros_validos = ['AGUILUCHO','Aguilucho', 'ANDACOLLO'];

            }else{
                $centros_validos = ['LENG'];
            }
            
            $fila = 2;
            $contador=0;
            $pacientes_atendidos = 0;
            for ($i = 0; $i < $numDetalle; $i++){
                
                //PROGRAMA
                $fecha_nacimiento = $data[$i]['fecha_nacimiento'];
                $fecha_atencion = $data[$i]['fecha_atencion'];
                // Dividir la cadena en fecha y hora
                list($fecha, $hora) = explode(' ', $fecha_atencion);
                //$fecha_actual = date('Y-m-d');
                // Calcular la edad
                $edad = date_diff(date_create($fecha_nacimiento), date_create($fecha))->y;
                // Determinar el texto a mostrar (PROGRAMA)
                $programa = ($edad >= 65) ? 'GES' : 'RESOLUTIVIDAD';
                $centro = '';
                if (strpos($data[$i]['centro'], 'Í') !== false) {
                    $centro = str_replace('Í', 'ÍN', $data[$i]['centro']); 
                    $centro = preg_replace('/N.*/', 'N', $centro); 
                } else {
                    $centro = $data[$i]['centro'];
                }
                $centro = strtoupper($centro);
                $centro = trim($centro);

                // if ($data[$i]['rut_completo'] =='14415810-5'){
                //     echo "<pre>";
                //     var_dump($data[$i]['rut_completo']);
                //     var_dump($data[$i]["codigo_tipo_prestacion_agenda"]);
                //     var_dump($data[$i]['recepcionado']);
                //     var_dump($data[$i]['codigo_pago_cuenta']);
                //     var_dump($centro);
                //     echo "</pre>";
                //     exit();

                // }

                // Filtrar pacientes que estén en los centros seleccionados
                // AGREGAR A LA VALIDACION TIPO DE ATENCION SEA IGUAL A CONSULTA
                if (in_array($centro, $centros_validos) && $data[$i]["codigo_tipo_prestacion_agenda"] == 1 && $data[$i]['recepcionado'] == 1 &&  $data[$i]['codigo_pago_cuenta'] >= 2 && $programa =="RESOLUTIVIDAD") {
                     // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_pnatural']);
                     $pacientes_atendidos ++;
                     // $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_pnatural']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$fila, $data[$i]['rut_completo']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, $data[$i]['nombres'].' ' .$data[$i]['apellido_paterno'].' '.$data[$i]['apellido_materno']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $data[$i]['fecha_nacimiento']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fila, $data[$i]['sexo']);
                    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$fila, strtoupper($data[$i]['sexo']));
                    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$fila, $centro);
                    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$fila, $data[$i]['fecha_atencion']);
                    //Lentes indicados
                    //valida que a lo menos un registro tenga datos receta de lentes lejos
                    $receta_lejos = (bool) (!empty($data[$i]["adicion_lejos_od"]) || !empty($data[$i]["adicion_lejos_oi"]) || !empty($data[$i]["cil_od"]) || !empty($data[$i]["cil_oi"]) || !empty($data[$i]["eje_od"]) || !empty($data[$i]["eje_oi"]));
                    //valida que a lo menos un registro tenga datos receta de lentes cerca
                    $receta_cerca = (bool) (!empty($data[$i]["adicion_cerca_od"]) || !empty($data[$i]["adicion_cerca_oi"]) || !empty($data[$i]["cil_cerca_od"]) || !empty($data[$i]["cil_cerca_oi"]) || !empty($data[$i]["eje_cerca_od"]) || !empty($data[$i]["eje_cerca_oi"]));
                    $cantidad_lentes = ($receta_lejos && $receta_cerca) ? 2 : (($receta_lejos || $receta_cerca) ? 1 : 0);
                    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$fila, $cantidad_lentes);
                      //CAMPO DIOGTERIA
                    // // lEJOS
                    // $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fila, $data[$i]['adicion_lejos_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fila, $data[$i]['cil_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('J'.$fila, $data[$i]['adicion_lejos_oi']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('K'.$fila, $data[$i]['cil_oi']);
                    // // CERCA
                    // $objPHPExcel->getActiveSheet()->SetCellValue('L'.$fila, $data[$i]['adicion_cerca_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('M'.$fila, $data[$i]['cil_cerca_od']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('N'.$fila, $data[$i]['adicion_cerca_oi']);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('O'.$fila, $data[$i]['cil_cerca_oi']);

                    //new formatos a las celdas de dioptria visual
                    $valores = [
                        'H' => $data[$i]['adicion_lejos_od'],
                        'I' => $data[$i]['cil_od'],
                        'J' => $data[$i]['adicion_lejos_oi'],
                        'K' => $data[$i]['cil_oi'],
                        'L' => $data[$i]['esf_cerca_od'],
                        'M' => $data[$i]['cil_cerca_od'],
                        'N' => $data[$i]['esf_cerca_oi'],
                        'O' => $data[$i]['cil_cerca_oi']
                    ];
                    
                    foreach ($valores as $columna => $valor) {
                        $formatoValor = ($valor > 0) ? sprintf("+%.2f", $valor) : sprintf("%.2f", $valor);
                        
                        $objPHPExcel->getActiveSheet()->SetCellValueExplicit(
                            $columna.$fila, 
                            $formatoValor, 
                            PHPExcel_Cell_DataType::TYPE_STRING
                        );
                    }


                    //Diagnostico GES 
                    $texto_diagnostico = strtoupper($data[$i]["diagnostico_ges"]); // Convertir a mayúsculas para comparación
                    $miopia = (strpos($texto_diagnostico, "MIOPÍA") !== false) ? "MIOPÍA" : "";
                    $astigmatismo = (strpos($texto_diagnostico, "ASTIGMATISMO") !== false) ? "ASTIGMATISMO" : "";
                    $presbicia = (strpos($texto_diagnostico, "PRESBICIA") !== false) ? "PRESBICIA" : "";
                    $hipermetropia = (strpos($texto_diagnostico, "HIPERMETROPÍA") !== false) ? "HIPERMETROPÍA" : "";
                    $diagnostico_ges = $miopia.' '.$astigmatismo.' '.$presbicia.' '.$hipermetropia;
                    if ($diagnostico_ges =="   "){
                        $diagnostico_ges = $data[$i]["detalle_atencion"];
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$fila, $diagnostico_ges);
                    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$fila, 'CONSULTA');
                    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$fila, 25500);


                    // //Diagnostico GES 
                    // $texto_diagnostico = strtoupper($data[$i]["diagnostico_ges"]); // Convertir a mayúsculas para comparación
                    // $miopia = (strpos($texto_diagnostico, "MIOPÍA") !== false) ? "MIOPÍA" : "";
                    // $astigmatismo = (strpos($texto_diagnostico, "ASTIGMATISMO") !== false) ? "ASTIGMATISMO" : "";
                    // $presbicia = (strpos($texto_diagnostico, "PRESBICIA") !== false) ? "PRESBICIA" : "";
                    // $hipermetropia = (strpos($texto_diagnostico, "HIPERMETROPÍA") !== false) ? "HIPERMETROPÍA" : "";
                    // $diagnostico_ges = $miopia.' '.$astigmatismo.' '.$presbicia.' '.$hipermetropia;
                    // $objPHPExcel->getActiveSheet()->SetCellValue('H'.$fila, $diagnostico_ges);
                    // $objPHPExcel->getActiveSheet()->SetCellValue('I'.$fila, 'CONSULTA');
                    // $objPHPExcel->getActiveSheet()->SetCellValue('j'.$fila, 25500);
                    // Nombre medico
                    $nombre_medico = $data[$i]["med_nombre"].' '.$data[$i]["med_apellido_paterno"].' '.$data[$i]["med_apellido_materno"];
                    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$fila,  strtoupper($nombre_medico));


                    $costo_total_atenciones += 25500;
                    $fila++; // Incremento de $fila en 1
                    $contador++;
                    //sleep(1); // Espera de 1 segundo para no sobrecargar 
                    if($contador==299)
                    {
                        $contador=0;
                        sleep(1);
                    }

                }
               
            }
            $fila += 4;
            // Unir celdas B y C en la fila correspondiente
            $objPHPExcel->getActiveSheet()->mergeCells("B{$fila}:C{$fila}");

            // Aplicar estilos: centrar texto, agregar bordes, color de fondo y color de fuente
            $styleArray = [
                'alignment' => [
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allborders' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => ['rgb' => 'FFFF00'], // Fondo amarillo
                ],
                'font' => [
                    'bold'  => true,
                    'color' => ['rgb' => 'FF8000'], // Texto naranja
                ],
            ];

            // Aplicar el estilo a las celdas unidas
            $objPHPExcel->getActiveSheet()->getStyle("B{$fila}:C{$fila}")->applyFromArray($styleArray);

            // Insertar el texto "RESUMEN" en la celda unida
            $objPHPExcel->getActiveSheet()->SetCellValue("B{$fila}", "RESUMEN");
            $fila += 1;
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, 'Total Pacientes Atendidos');
            // Aplicar estilo de negrita al texto
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
            // $i = cantidad pacientes atendidos 
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $pacientes_atendidos);
            $fila += 1;
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, 'Costo Atención');
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
            // $i = cantidad pacientes atendidos 
            // $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, 25500);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, '$' . number_format(25500, 0, ',', '.'));
            $fila += 1;
            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$fila, 'TOTAL ATENCIONES');
            $objPHPExcel->getActiveSheet()->getStyle('B'.$fila)->getFont()->setBold(true);
            // $i = cantidad pacientes atendidos 
            // $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, $costo_total_atenciones);
            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$fila, '$' . number_format($costo_total_atenciones, 2, '.', '.'));
            

            if ($centro_selecionado == "ALESSANDRI"){
                $centro_informe = 'informe_centro_alessandri';
                $archivo_excel = 'Informe_programa_resolutividad_alessandri.xlsx';

            }else if($centro_selecionado == "AGUILUCHO"){
                $centro_informe = 'informe_centro_aguilucho';
                $archivo_excel = 'Informe_programa_resolutividad_aguilucho.xlsx';
                

            }else if($centro_selecionado == "LENG"){
                $centro_informe = 'informe_centro_leng';
                $archivo_excel = 'Informe_programa_resolutividad_leng.xlsx';

            }
            

            // Crear el escritor para Excel
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            // Limpiar cualquier contenido anterior del búfer de salida
            ob_end_clean();

            // Encabezado para indicar el tipo de archivo Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            // Nombre del archivo de salida con extensión xlsx
            $informe = 'Informe_cierre';
            header('Content-Disposition: attachment; filename="Importacion' . $informe . '.xlsx"');

            // Guardar el archivo Excel en el servidor
            // $objWriter->save('views/facturacion/. $centro_informe./$archivo_excel');
            $objWriter->save("views/facturacion/$centro_informe/$archivo_excel");

            return true;

        } catch (PDOException $e) {

            echo $e->getMessage(); 
            return false;
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
