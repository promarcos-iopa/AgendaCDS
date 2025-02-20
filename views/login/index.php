<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login CDS</title>
  <link rel="stylesheet" type="text/css" href="<?php echo constant('URL');?>public/css/bootstrap.css" crossorigin="anonymous"> 
  <link rel="Stylesheet" href="<?php echo constant('URL'); ?>public/sweetalert/css/sweetalert2.min.css"  /> 

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  
  <script src="<?php echo constant('URL'); ?>public/sweetalert/js/sweetalert2.all.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <style>

/* body {
    font-family: Arial, Helvetica, sans-serif;
    background: #141414;
    background: rgb(72 123 121);
    background: linear-gradient(144deg, rgb(65 70 83) 0%, rgb(36 175 172) 50%);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  } */



  /* body {
    font-family: Arial, Helvetica, sans-serif;
    background: #141414;
    background: rgb(72 123 121);
    background: linear-gradient(144deg, rgb(75 125 255) 0%, rgb(145 197 233) 50%);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  } */

  body {
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    background-color: #f1f8ff;
    height: 100vh;
    background-image: linear-gradient(180deg, #0c72c9 0%, #d6f6ff 100%);
    /* color: #fff; */
}
    

img.avatar {
  width: 100%;
  border-radius: 25%;
  padding: 20px;
}




.login-page {
width: 360px;
padding: 8% 0 0;
margin: auto;
}

.form {
  position: relative;
  z-index: 1;
  background: #FFFFFF;
  max-width: 360px;
  margin: 0 auto 400px;
  padding: 45px;
  text-align: center;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
  border-radius: 10px; 
}
.rounded-button {
  border-radius: 20px; /* Ajusta el valor de acuerdo a tus preferencias */
  padding: 10px 20px; /* Ajusta el padding según sea necesario */
  background-color: #4CAF50; /* Color de fondo */
  color: white; /* Color del texto */
  border: none; /* Quita el borde si lo deseas */
  cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
}
.form input {
  /* font-family: "Roboto", sans-serif; */
  outline: 0;
  background: #f2f2f2;
  width: 100%;
  border: 0;
  margin: 0 0 15px;
  padding: 15px;
  box-sizing: border-box;
  font-size: 14px;
}
.form button {
  /* font-family: "Roboto", sans-serif; */
  text-transform: uppercase;
  outline: 0;
  background: #2bbcd3;
  width: 100%;
  border: 0;
  padding: 15px;
  color: #FFFFFF;
  font-size: 14px;
  -webkit-transition: all 0.3 ease;
  transition: all 0.3 ease;
  cursor: pointer;
}
.form button:hover,.form button:active,.form button:focus {
  /* background: #2b75d3; */
  background: #1aa1de;
}
.form .message {
  margin: 15px 0 0;
  color: #b3b3b3;
  font-size: 12px;
}
.form .message a {
  color: #0a8ddd;
  text-decoration: none;
}
.form .register-form {
  display: none;
}
.container {
  position: relative;
  z-index: 1;
  max-width: 400px;
  margin: 0 auto;
}
.container:before, .container:after {
  content: "";
  display: block;
  clear: both;
}
.container .info {
  margin: 50px auto;
  text-align: center;
}
.container .info h1 {
  margin: 0 0 15px;
  padding: 0;
  font-size: 36px;
  font-weight: 300;
  color: #1a1a1a;
}
.container .info span {
  color: #4d4d4d;
  font-size: 12px;
}
.container .info span a {
  color: #000000;
  text-decoration: none;
}
.container .info span .fa {
  color: #EF3B3A;
}
H1{
  color: #FFF;
  font-size: 30px;
  font-weight: 300;
  text-align: center;
  
}

</style>
</head>
<body>

  <div class="login-page">
    <h1>Atenciones CDS</h1>
    <div class="form">
      
      <div class="imgcontainer">
        <img src="<?php echo constant('URL'); ?>public/img/logo_iopa.jpg" alt="Avatar" class="avatar">
      </div>
      <form class='form-signin' method='POST' action='login/verificar'>
        <label for='login'>Login</label>
        <input type='text' class='form-control' required id='email' name='email' placeholder='Ingrese Email' autocomplete="username">
        <label for='pass'>Password</label>
        <input type='password' class='form-control' required id='pass' name='pass' placeholder='Ingrese Pass' autocomplete="current-password">
        <button type="submit" class="rounded-button">login</button>
        <!-- <span class="psw">Olvido su  <a href="#">clave?</a></span> -->
      </form>
      <input type="text" class="form-control rounded-pill" id="mensaje" name="mensaje" value="<?php echo $this->mensaje;?>" hidden>
    </div>
  </div>


  <script>

    $(document).ready(function(){
      let mensaje = $("#mensaje").val();
      if (mensaje =="error"){
        Swal.fire({
                  title: "¡Usuario o contraseña incorrectos!",
                  icon:'warning'
        }).then((result) => {
            mensaje = "";
            window.location.href = "https://www.iopanet.cl/agenda_medica_cds/";
        });

      }
    });
  
 </script>

</body>
</html>
