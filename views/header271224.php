<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Dinámico</title>
    
    <link href="<?php echo constant('URL'); ?>public/bootstrap-5.0.2/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/sweetalert/css/sweetalert2.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/fontawesome-free/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/> -->
    <!-- Select2 -->
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="<?php echo constant('URL'); ?>public/sweetalert/js/sweetalert2.all.min.js"></script>
    <script src="<?php echo constant('URL'); ?>public/bootstrap-5.0.2/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        /* @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap'); */
        /* body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f1f8ff;
            height: 100vh;
            background-image: linear-gradient(135deg, #1f9ed5 0%, #c2f1ff 100%);
           
        } */

        /* .container {
    margin-top: 120px !important;
    height: 73vh;
} */

        .container {
            margin-bottom: 128px;
            height: 73vh;
        }

        /* body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f1f8ff;
            height: 100vh;
            background-image: linear-gradient(180deg, #0c72c9 0%, #d6f6ff 100%);
            
        } */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f1f8ff;
            min-height: 100vh; /* Asegura que cubra al menos toda la altura de la ventana */
            background-image: linear-gradient(180deg, #0c72c9 0%, #d6f6ff 100%);
            background-repeat: no-repeat; /* Evita que se repita el fondo */
            background-attachment: fixed; /* Fija el fondo para que no reinicie al hacer scroll */
            background-size: cover; /* Asegura que cubra toda el área del body */
        }
       
       /* body {
          margin: 0;
          font-family: "Nunito", sans-serif;
          background-color: #F1F8FF;
       } */
        /* Estilo del navbar OLD*/
        /* .navbar {
            background-image: linear-gradient(#d6f6ff 100%);
            transition: background-color 0.4s ease;
            padding: 15px;
        } */

         /* Estilo del navbar NEW*/
         .navbar {
            background-image: linear-gradient(#d6f6ff 100%);
            background-image: linear-gradient(143deg, #1384e5 0%, #13d0ff 100%);
            transition: background-color 0.4s ease;
            padding: 15px;
        }

        .navbar.scrolled {
            /* background-color: rgba(9, 181, 255, 1);  */
            background-color: #1377cb;  
        }

        .navbar-brand, .nav-link {
            color: white !important;
        }

        .nav-link:hover {
            color: #005f7f !important;
        }

        .dropdown-menu {
            background-color: #09b5ff !important;
        }

        .dropdown-menu a {
            color: white !important;
        }

        .dropdown-menu a:hover {
            background-color: #005f7f !important;
        }

        .iopaLogo {
          max-width: 240px;
          height: auto;
          padding-right: 30px;
          padding-left: 30px;
          margin-right: 30px;

        }

        .container{
            margin-top: 120px !important;
        }


        .btn-guardar {
            background-color: #54bae1;
            border-color: #00efff;
            color: white;  
            border-radius: 12px;
        }


        .btn-guardar:hover {
            background-color: #1aa6db; 
            color: white;
            border-color: #00efff;
        }

        .btn-guardar:disabled {
            background-color: #d6d6d6; /* Gris claro para el botón deshabilitado */
            border-color: #d6d6d6;
            cursor: not-allowed; /* Cambia el cursor cuando el botón está deshabilitado */
        }


        .btn-limpiar {
            background-color: #ffc52c;
            border-color: #ffe066;
            color: white;
            border-radius: 12px;
        }

        .btn-limpiar:hover {
            background-color: #efae00; /* Azul marino */
            color: white;
            border-color: #ffe066;
        }


        .btn-eliminar {
            background-color: #d92d2d;
            border-color: #ff6f6f;
            color: white;
            border-radius: 12px;
        }


        .btn-eliminar:hover {
            background-color: #bb0000;
            color: white;
            border-color: #ff6f6f;
        }


        .btn-cerrar {
            background-color: #6c757d;
            border-color: #b1b1b1;
            color: white;
            border-radius: 12px;
        }


        .btn-cerrar:hover {
            background-color: #4b5259;
            border-color: #b1b1b1;
            color: white;
            
        }


        .check-guardar {
          user-select: none;
          display: inline-block;
          fill: currentcolor;
          flex-shrink: 0;
          font-size: 1.5rem;
          width: 24px;
          height: 24px;
          color: #ffffff;
          margin-top: 5px;
          transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1);
          margin-top: 0px;
          margin-bottom: 5px;
        }

        .center{
            color: #fff;
        }

        
      
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="navbar" style="padding-top: 0px;padding-bottom: 0px;">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="#">Afp</a> -->
            <img src="<?php echo constant('URL'); ?>public/img/Iopa-TRANSPARENTE.PNG" alt="Iopa" class="iopaLogo ">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tablasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Documentos</a>
                        <ul class="dropdown-menu" aria-labelledby="tablasDropdown">
                        <?php
                            include_once 'models/usuariosperfil.php';
                            foreach ($this->usuariosperfil as $row) {
                                $usuariosperfil = new Usuariosperfil();
                                $usuariosperfil = $row;

                                if ($usuariosperfil->principal == "Documentos") {
                                    if ($usuariosperfil->menu == "docConsentimiento") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo 'consentimiento'; ?>/verPaginacion_consentimiento">
                                                <?php echo 'Consentimiento'; ?>
                                            </a>
                                        </li>
                                    <?php } elseif ($usuariosperfil->menu == "detalleprestaciones") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo 'informe'; ?>/verPaginacion_Detalle_Prestaciones">
                                                <?php echo 'Detalle Prestaciones'; ?>
                                            </a>
                                        </li>
                                    <?php } elseif ($usuariosperfil->menu == "detalleoptica") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo 'informe'; ?>/verPaginacion_Detalle_Optica">
                                                <?php echo 'Detalle Recetas Ópticas'; ?>
                                            </a>
                                        </li>
                                    <?php }
                                }
                            }
                        ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tablasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Informes CDS</a>
                        <ul class="dropdown-menu" aria-labelledby="tablasDropdown">
                        <?php
                            include_once 'models/usuariosperfil.php';
                            foreach ($this->usuariosperfil as $row) {
                                $usuariosperfil = new Usuariosperfil();
                                $usuariosperfil = $row;

                                if ($usuariosperfil->principal == "Informe CDS") {
                                    if ($usuariosperfil->menu == "detalleagendas") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo 'informe'; ?>/verPaginacion_Detalle_Pacientes">
                                                <?php echo 'Detalle Pacientes Atendidos'; ?>
                                            </a>
                                        </li>
                                    <?php } elseif ($usuariosperfil->menu == "detalleprestaciones") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo 'informe'; ?>/verPaginacion_Detalle_Prestaciones">
                                                <?php echo 'Detalle Prestaciones Realizadas'; ?>
                                            </a>
                                        </li>
                                    <?php } elseif ($usuariosperfil->menu == "detalleoptica") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo 'informe'; ?>/verPaginacion_Detalle_Optica">
                                                <?php echo 'Detalle Recetas Ópticas'; ?>
                                            </a>
                                        </li>
                                    <?php }
                                }
                            }
                        ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="tablasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Agenda Médica</a>
                        <ul class="dropdown-menu" aria-labelledby="tablasDropdown">
                        <?php
                            include_once 'models/usuariosperfil.php';
                            foreach ($this->usuariosperfil as $row) {
                                $usuariosperfil = new Usuariosperfil();
                                $usuariosperfil = $row;

                                if ($usuariosperfil->principal == "Agenda Medica") {
                                    if ($usuariosperfil->menu == "agenda") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo $usuariosperfil->menu; ?>/verPaginacion">
                                                <?php echo 'Agendar Cita '; ?>
                                            </a>
                                        </li>
                                    <?php } elseif ($usuariosperfil->menu == "detalleagendas") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo 'agenda'; ?>/verPaginacionDetalle">
                                                <?php echo 'Detalle Citas Reservadas'; ?>
                                            </a>
                                        </li>
                                    <?php } elseif ($usuariosperfil->menu == "pacientes") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?>pacientes/render">
                                                <?php echo 'Cargar Agenda Pacientes'; ?>
                                            </a>
                                        </li>
                                    <?php }
                                }
                            }
                        ?>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="formulariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Bloques Médicos</a>
                        <ul class="dropdown-menu" aria-labelledby="formulariosDropdown">
                            <?php
                            include_once 'models/usuariosperfil.php';
                            foreach ($this->usuariosperfil as $row) {
                                $usuariosperfil = new Usuariosperfil();
                                $usuariosperfil = $row;

                                if ($usuariosperfil->principal == "Medicos") {
                                    if ($usuariosperfil->menu == "medicos") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo $usuariosperfil->menu; ?>/verPaginacion">
                                                <?php echo 'Perfil Médicos'  ?>
                                            </a>
                                        </li>
                                    <?php } elseif ($usuariosperfil->menu == "bloque") { ?>
                                        <li>
                                            <a class="dropdown-item" href="<?php echo constant('URL'); ?><?php echo $usuariosperfil->menu; ?>/verPaginacion">
                                                <?php echo 'Crear Bloques Médicos'?>
                                            </a>
                                        </li>
                                    <?php }
                                }
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION["usuario"] ?></a>
                    </li>
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link d-flex align-items-center" href="<?php echo constant('URL'); ?>">
                            <img src="<?php echo constant('URL'); ?>public/img/salir.png" alt="salir" class="salir me-2" style="width: 20px; height: 20px;">
                            Salir
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        // Cambiar color del navbar al hacer scroll
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>