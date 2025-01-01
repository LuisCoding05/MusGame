<div class="contenedor">

    <?php

    $espada = ['1E', '2E', '3E', '4E', '5E', '6E', '7E', '10E', '11E', '12E'];
    $copa = ['1C', '2C', '3C', '4C', '5C', '6C', '7C', '10C', '11C', '12C'];
    $basto = ['1B', '2B', '3B', '4B', '5B', '6B', '7B', '10B', '11B', '12B'];
    $oro = ['1O', '2O', '3O', '4O', '5O', '6O', '7O', '10O', '11O', '12O'];

    // Suponiendo que el archivo de imágenes está bien incluido
    include_once 'imagenes.php';

    // Crear la baraja completa
    $barajaCompleta = array_merge($espada, $copa, $basto, $oro);
    $baraja = $barajaCompleta;

    function asignarMazo(&$baraja) {
        $mano = [];
        for ($i = 0; $i < 4; $i++) {
            $random = array_rand($baraja);
            $mano[$i] = $baraja[$random];
            unset($baraja[$random]);
        }
        return $mano; // Retornar la mano sin imprimir
    }

    function imprimirManoConImagenes($mano, $imagenes) {
        echo "<div class='mano'>"; // Usar flexbox para alinear imágenes
        foreach ($mano as $carta) {
            if (isset($imagenes[$carta])) {
                echo "<div style='text-align: center;'>"; // Centrar la imagen
                echo "<img src='" . $imagenes[$carta] . "' alt='$carta'><br>"; // Ajusta el tamaño
                echo "<span>$carta</span>"; // Mostrar el valor de la carta debajo
                echo "</div>";
            }
        }
        echo "</div>";
    }

    // Asignar manos
    $mano1 = asignarMazo($baraja);
    $mano2 = asignarMazo($baraja);
    
    // Imprimir las manos
    echo "<h3>Mano 1:</h3>";
    imprimirManoConImagenes($mano1, $imagenes);

    echo "<h3>Mano 2:</h3>";
    imprimirManoConImagenes($mano2, $imagenes);

    // Incluir el archivo de jugadas
    include_once 'jugadas.php'; 

    // Llamar a la función Jugadas para determinar quién gana
    $resultados = Jugadas($mano1, $mano2);

    /*Imprime los resultados de las jugadas con un switch que maneja cada resultado de juego*/
    foreach ($resultados as $key => $resultado) {
        if ($resultado) {
            switch ($key) {
                case 0: 
                    echo "<h3>Resultado de la jugada de los grandes(" . ($key +1) . "): </h3>";
                    break;
                case 1: 
                    echo "<h3>Resultado de la jugada de los chicos(" . ($key +1) . "): </h3>";
                    break;
                case 2: 
                    echo "<h3>Resultado de la jugada de los pares(" . ($key +1) . "): </h3>";
                    break;
                case 3: 
                    echo "<h3>Resultado de la jugada de juego(" . ($key +1) . "): </h3>";
                    break;
            }
            echo "<p>$resultado</p>";
        }
    }

    ?>
</div>
