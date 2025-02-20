<?php
session_start();
//include_once 'models/pacienteComision.php';
class Consentimiento extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->view->comision = [];
        if (!isset($_SESSION['usuario'])) {
            echo "Acceso Negado";
            session_destroy();
            $location = constant('URL');
            header("Location: " . $location);
            exit;
        } else {
        }
    }

    function verPaginacion_consentimiento($param = null)
    {

        if (!empty($_POST)) {

            if (!empty($_POST['rut'])) {

                $rut = $_POST['rut'];
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                } else {
                    $fecha = null;
                }

                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                } else {
                    $fecha_hasta = null;
                }

            } else {
                
                $rut = null;
                if (!empty($_POST['fecha_desde'])) {
                    $fecha = $_POST['fecha_desde'];
                } else {
                    $fecha = null;
                }

                if (!empty($_POST['fecha_hasta'])) {
                    $fecha_hasta = $_POST['fecha_hasta'];
                } else {
                    $fecha_hasta = null;
                }
            }
            $id = 1;
        } else if ($param == NULL) {

            $rut = null;

            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $id = 1;
            $this->view->mensaje = '';
        } else {
            $id = $param[0];
            $cantidad_elementos = count($param);
            $fecha = $_GET['fecha'] ?? date('Y-m-d');
            $fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-d');
            $this->view->mensaje = '';
            $rut = null;
        }

        $autorizacionporpagina = 7;
        // $totalautorizaciones = $this->model->getregistros($rut);
        // $paginas =$totalautorizaciones/$autorizacionporpagina; 
        $iniciar = ($id - 1) * $autorizacionporpagina;
        // $citas = $this->model->getpag($iniciar,$autorizacionporpagina,$rut, null, null);

        //Variable citas_cds = array (con los codigos reserva de rebsol almacenados en la tabla citas de la bd CDS)
        $citas_cds = $this->model->get_pacientes_CDS($rut, $fecha, $fecha_hasta);

        $this->view->mensaje = '';
        if ($citas_cds['items_reserva'] == '') {
            $fecha = date('Y-m-d');
            $fecha_hasta = date('Y-m-d');
            $this->view->mensaje = "No hay resultados encontrados para este filtro";
            $citas_cds = $this->model->get_pacientes_CDS(null, $fecha, $fecha_hasta);
        }

        $codigos_reserva_atencion_string = $citas_cds['items_reserva'];

        // Variable citas_rs =  lista de pacientes de rebsol recepcionados con atencion.
        $citas_rs = $this->model->get_pacientes_RS($iniciar, $autorizacionporpagina, $fecha, $fecha_hasta, $codigos_reserva_atencion_string);

        // echo "<pre>";
        // print_r($citas_rs);
        // echo "</pre>";
        // exit();

        $datos_informe = $citas_rs['informe'];
        $resultadoPaginacion = $citas_rs['resultadoPaginacion'];
        $totalautorizaciones = $citas_rs['cantidadRegistros'];

        $paginas = $totalautorizaciones / $autorizacionporpagina;
        $this->view->citas = $resultadoPaginacion;
        $this->view->fecha = $fecha;
        $this->view->fecha_hasta = $fecha_hasta;
        $this->view->datos_informe = $datos_informe;
        // $this->view->mensaje='son'. $totalautorizaciones;
        $this->view->paginas = $paginas;
        $this->view->paginaactual = $id;
        $this->view->usuario = $_SESSION['usuario'];
        /*Pasar sus Permisos*/
        $permisos = $this->model->getmenu($_SESSION['usuario']);
        $this->view->usuariosperfil = $permisos;
        /*fin*/
        $this->view->render('documentos/consentimiento');
    }
}
