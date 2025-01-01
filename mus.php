<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Cartas</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: darkgrey; /* Color de fondo de la página */
            margin: 0;
        }
        .contenedor {
            margin: 2rem auto;
            background-color: darkgreen; /* Verde oscuro */
            color: white;
            padding: 20px;
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Sombra para dar profundidad */
            text-align: center;
        }
        
        img {
            width: 100px; /* Ancho fijo para las imágenes */
            height: 150px; /* Altura automática para mantener la proporción */
        }
        .mano {
            display: flex;
            gap: 10px;
            justify-content: center; /* Centrar las cartas */
            margin-bottom: 20px; /* Margen entre manos */
        }
        #creadores {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        #creadores span {
            text-decoration: underline;
            font-style: italic;
        }
        button {
            background-color: #4CAF50; /* Verde */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049; /* Verde más oscuro al pasar el ratón */
        }
    </style>
</head>
<body> 
    <div class="contenedor">
        <?php include_once 'baraja.php'; ?>
        <p id="creadores">Hecho por <span>Luis Miguel</span>, <span>Pablo Fernández</span> y <span>Chahine</span></p>
        <!-- Botón para refrescar la página -->
        <button onclick="window.location.reload();">Refrescar Página</button>
    </div>
</body>
</html>