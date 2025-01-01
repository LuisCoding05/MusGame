<?php include_once "jugador.php";
    $jugador1 = new jugador(0);
    $jugador2 = new jugador(0);
    $jugador1Victorias = $jugador1->valor;
    $jugador2Victorias = $jugador2->valor;
    //Jugadas:Grande,Pequeño,Pares,Juegos

    function Jugadas($mano1,$mano2) {
        $valores1 = [];
        $valores2 = [];

        for ($i = 0; $i < count($mano1); $i++) {
            // Convertir el valor de mano1
            $valor1 = intval($mano1[$i]);
            if ($valor1 > 10) {
                $valores1[$i] = 10;
            } else {
                $valores1[$i] = $valor1;
            }
        
            // Convertir el valor de mano2
            $valor2 = intval($mano2[$i]);
            if ($valor2 > 10) {
                $valores2[$i] = 10;
            } else {
                $valores2[$i] = $valor2;
            }
        }
        

        

        return [Grande($valores1,$valores2),Pequeno($valores1,$valores2), Pares($mano1,$mano2), Juego($valores1,$valores2), imprimirGanador()];
    }


    function Grande($mano1,$mano2) {
        global $jugador1Victorias, $jugador2Victorias;
        while (count(value: $mano1) > 0 && count($mano2) > 0) {
            $max1 = max($mano1);
            $max2 = max($mano2);
    
            if ($max1 > $max2) {
                $jugador1Victorias += 1;
                return "La mano uno gana en la jugada grande con : $max1.";
            } else if ($max2 > $max1) {
                $jugador2Victorias += 1;
                return "La mano dos gana en la jugada grande con : $max2.";
            } else {
                $posicion1 = array_search($max1, $mano1);
                $posicion2 = array_search($max2, $mano2);
                
                unset($mano1[$posicion1]);
                unset($mano2[$posicion2]);
            }
        }
    
        if (count($mano1) === 0 && count($mano2) === 0) {
            return "Gana el que ha repartido las cartas";
        }

    }

    function Pequeno($mano1,$mano2) {
        global $jugador1Victorias, $jugador2Victorias;
        while (count($mano1) > 0 && count($mano2) > 0) {
            $min1 = min($mano1);
            $min2 = min($mano2);
    
            if ($min1 < $min2) {
                $jugador1Victorias += 1;
                return "La mano uno gana en la jugada pequeña con: $min1.";
            } else if ($min2 < $min1) {
                $jugador2Victorias += 1;
                return "La mano dos gana en la jugada pequeña con: $min2.";
            } else {
                $posicion1 = array_search($min1, $mano1);
                $posicion2 = array_search($min2, $mano2);
                
                unset($mano1[$posicion1]);
                unset($mano2[$posicion2]);
            }
        }
    
        if (count($mano1) === 0 && count($mano2) === 0) {
            return "Gana el que ha repartido las cartas";
        }
    }     


    function pares($mano1, $mano2) {
        global $jugador1Victorias, $jugador2Victorias;
        function comparacion($mano) {
            /*Como esta funcion recoge las manos
            sin transformarlas en los valores
            Las transformamos ahora pero manteniendo
            sus valores normales(sin igualar a 10 los mayores de 10)*/
            $valores = array_map('intval', $mano);
    
            $ganador = 0;
            /*Creamos un array con el conteo de cuantas veces se repite cada número*/
            $conteo = array_count_values($valores);
            $parejas = [];
            $trio = [];
            $resultado = 0;
            /*Este array guarda el valor de las parejas */
            $resultados = [];
            /*El "índice" en este array es el número que se ha repetido
            y el nº de veces que se repitió el valor que contiene*/
            foreach ($conteo as $numero => $cantidad) {
                if ($cantidad == 2) {
                /*Si se repite dos veces se agrega al array de las parejas*/
                    $parejas[] = $numero;
                    $ganador = max($ganador, 1);
                } elseif ($cantidad == 3) {
                    /*Si se repite tres el valor ganador aumenta*/
                    $trio[] = $numero;
                    $ganador = max($ganador, 2);
                }
            }
            /*Si hay dos parejas tenemos una dupla y por tanto aumenta el valor ganador */
            if (count($parejas) == 2) {
                $ganador = 3;
            }
            /*Si la jugada no es trio hará que
            cada valor sea como mucho 10 y se agregue al resultado*/ 
            if ($ganador !=2) {
                foreach ($parejas as $value) {
                    if($value > 10) {
                        $value = 10;
                    }
                    $resultado += $value;
                }
            }
            /*Si es trio simplemente el resultado es ese valor
            porque solo puede haber un trio y con la función min
            hacemos que el valor máximo sea 10*/ 
            else{
                $resultado += min($trio[0], 10);
            }

            /*Guardamos los resultados en el array, primero
            si es pareja, trio o dupla y después su valor total*/
            array_push($resultados, $ganador, $resultado);
            return $resultados;
        }
        /*Guardamos los resultados de cada mano en una variable*/
        $ganador1 = comparacion($mano1);
        $ganador2 = comparacion($mano2);
        /*Gracias al valor absoluto guardamos la diferencia en esta simple variable*/
        $diferencia = abs($ganador1[1] - $ganador2[1]);
    
        /*Primero hacemos comparaciones según el resultado es una pareja, trío, dupla o nada*/
        /*Y hacemos más corta y legible las posibilidades con ifs en línea*/
        
        if ($ganador1[0] > $ganador2[0]) {
            $jugador1Victorias += 1;
            if ($ganador1[0] == 3) {
                return "<p>Ha ganado la mano uno porque tenía dupla y la mano dos tenía " . 
                       ($ganador2[0] == 2 ? "un trío" : ($ganador2[0] == 1 ? "una pareja" : "nada")) . ".</p>";
            } elseif ($ganador1[0] == 2) {
                return "<p>Ha ganado la mano uno porque tenía un trío y la mano dos tenía " . 
                       ($ganador2[0] == 1 ? "una pareja" : "nada") . ".</p>";
            } else {
                return "<p>Ha ganado la mano uno porque tenía pareja y la mano dos no tenía nada.</p>";
            }
    
        } elseif ($ganador1[0] < $ganador2[0]) {
            $jugador2Victorias += 1;
            if ($ganador2[0] == 3) {
                return "<p>Ha ganado la mano dos porque tenía dupla y la mano uno tenía " . 
                       ($ganador1[0] == 2 ? "un trío" : ($ganador1[0] == 1 ? "una pareja" : "nada")) . ".</p>";
            } elseif ($ganador2[0] == 2) {
                return "<p>Ha ganado la mano dos porque tenía un trío y la mano uno tenía " . 
                       ($ganador1[0] == 1 ? "una pareja" : "nada") . ".</p>";
            } else {
                return "<p>Ha ganado la mano dos porque tenía pareja y la mano uno no tenía nada.</p>";
            }
            /*Si es empate hacemos la comparación con el valor total*/
        } else {
            if ($ganador1[1] > $ganador2[1]) {
                $jugador1Victorias += 1;
                return "<p>Ha ganado la mano uno por " . $diferencia . " puntos.</p>";
            } elseif ($ganador1[1] < $ganador2[1]) {
                $jugador2Victorias += 1;
                return "<p>Ha ganado la mano dos por " . $diferencia . " puntos.</p>";
            } else {
                return "<p>Es un empate o ninguno tiene una pareja.</p>";
            }
        }
    }
    
    function imprimirGanador(){
        global $jugador1Victorias, $jugador2Victorias;
        if ($jugador1Victorias > $jugador2Victorias) {
            return "<h2>La mano 1 ha ganado con " . $jugador1Victorias . " rondas" .
            " frente a " . $jugador2Victorias . " rondas.";
        }

        elseif ($jugador2Victorias > $jugador1Victorias) {
            return "<h2>La mano 2 ha ganado con " . $jugador2Victorias . " rondas" .
            " frente a " . $jugador1Victorias . " rondas.";
        }
        else{
            return "<h2>Es un empate (cada mano ha ganado 2 rondas)</h2>";
        }
    }
    

    function Juego($mano1,$mano2) {
        global $jugador1Victorias, $jugador2Victorias;
        $suma1 = 0;
        $suma2 = 0;


        for($i = 0; $i < count($mano1); $i++) {
            $suma1 += $mano1[$i];
            $suma2 += $mano2[$i];
        }

        if ($suma1 >= 31 && $suma2 >= 31 ) {

            if ($suma1 == 31 && $suma2 != 31) {
                $jugador1Victorias += 1;
                return "La mano uno gana en la jugada juegos con: $suma1.";
            } else if ($suma2 == 31 && $suma1 != 31) {
                $jugador2Victorias += 1;
                return "La mano dos gana en la jugada juegos con: $suma2.";
            }
        
            if ($suma1 == 32 && $suma2 != 31 && $suma2 != 32) {
                $jugador1Victorias += 1;
                return "La mano uno gana en la jugada juegos con: $suma1.";
            } else if ($suma2 == 32 && $suma1 != 31 && $suma1 != 32) {
                $jugador2Victorias += 1;
                return "La mano dos gana en la jugada juegos con: $suma2.";
            }
        
            if ($suma1 == 40 && $suma2 != 31 && $suma2 != 32 && $suma2 != 40) {
                $jugador1Victorias += 1;
                return "La mano uno gana en la jugada juegos con: $suma1.";
            } else if ($suma2 == 40 && $suma1 != 31 && $suma1 != 32 && $suma1 != 40) {
                $jugador2Victorias += 1;
                return "La mano dos gana en la jugada juegos con: $suma2.";
            }
        
            $clasificacion = [37, 36, 35, 34, 33];
        
            foreach ($clasificacion as $clasificado) {
                if ($suma1 == $clasificado && $suma2 != 31 && $suma2 != 32 && $suma2 != 40 && $suma2 != $clasificado) {
                    $jugador1Victorias += 1;
                    return "La mano uno gana en la jugada juegos con: $suma1.";
                } else if ($suma2 == $clasificado && $suma1 != 31 && $suma1 != 32 && $suma1 != 40 && $suma1 != $clasificado) {
                    $jugador2Victorias += 1;
                    return "La mano dos gana en la jugada juegos con: $suma2.";
                }
            }
        
            return "Es un empate en la jugada juegos con: $suma1.";  
            

        }   else {

            if($suma1 > $suma2) {
                $jugador1Victorias += 1;
                return "La mano uno gana en la jugada juegos con: $suma1.";
            }   else {
                $jugador2Victorias += 1;
                return "La mano dos gana en la jugada juegos con: $suma2.";
            }

        }



    }

?>