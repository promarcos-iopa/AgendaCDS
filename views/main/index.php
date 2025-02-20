<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Médica CDS </title>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"> -->
    <style>
        /* body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f1f8ff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: linear-gradient(135deg, #1f9ed5 0%, #c2f1ff 100%);
            color: #fff;
        } */

        h1 {
            font-size: 2.5em;
            font-weight: 600;
            text-align: center;
            margin: 0;
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
            color: #ffffff; /* Cambiado a blanco */
        }

        #main {
            text-align: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            margin-top: 250px;
            margin-bottom: 521px;
            margin-right: 500px;
            margin-left: 500px;

           
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .welcome-message {
            font-size: 1.2em;
            margin-top: 15px;
            opacity: 0;
            animation: fadeIn 2.5s ease-in-out forwards;
			color: #074994;
        }
    </style>
</head>
<body>
    <?php require 'views/header.php'; ?>
    <div id='main'>
        <h1>Bienvenido Clínica Oftalmológica IOPA</h1>
        <p class="welcome-message">Nos alegra tenerte aquí. Explora nuestros servicios y funcionalidades.</p>
    </div>
    <?php require 'views/footer.php'; ?>
</body>
</html>