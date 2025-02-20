<?php
class Login extends Controller{
	function __construct()
	{
		//llama al constructor del Controlador Base
		parent::__construct();
	}

	function render(){
 	  $this->view->render('login/index');
  }


  function verificar(){
    $email=$_POST['email'];
    // $pass=md5($_POST['pass']); //password codificada
    $pass=$_POST['pass'];
    $usuario = $this->model->verificar($email, $pass);

    //comprobar que la variable $usuario no es false y tampoco está vacía.
    if($usuario && !empty($usuario)){
      session_start(); 
      $rut = $usuario['rut'];
      $email = $usuario['email'];
      $nombre = $usuario['nombre'];
      $apellido1 = $usuario['apellido1'];
      $apellido2 = $usuario['apellido2'];
      $_SESSION["rut"] = $rut;
      $_SESSION["usuario"] = $email;
      $_SESSION["nombre"] = $nombre. " ".$apellido1." ".$apellido2;

      // Llama a la función
      $ip_usuario = $this->obtener_ip_usuario();
      // echo "La IP del usuario es: " . $ip_usuario;
      // exit();
      $this->model->insertLogUsuariosCds($email, $ip_usuario); 	
     
      // Obtener los permisos del usuario y pasarlos a la vista
      $permisos = $this->model->getmenu($email); 	
      $this->view->usuariosperfil = $permisos;
      // Renderizar la vista principal
      $this->view->render('main/index');

    } else {
      // Si la autenticación falla, mostrar un mensaje de error y volver a la página de inicio de sesión
      //remove all session variables
        session_unset(); 
      // destroy the session 
        //  session_destroy();
        $mensaje = "error";
        $this->view->mensaje = $mensaje;
        $this->view->render('login/index');
        
    }
    
  }


  function obtener_ip_usuario() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // IP desde el proxy compartido
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // IP pasada desde el encabezado HTTP_X_FORWARDED_FOR
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // IP directa del cliente
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Si es una dirección IPv6 (::1), intenta convertirla a IPv4
    if ($ip === '::1') {
        $ip = gethostbyname(gethostname());
    }

    return $ip;
  }





  function salir(){
 	  $this->view->render('login/index');
  }

}
?>
