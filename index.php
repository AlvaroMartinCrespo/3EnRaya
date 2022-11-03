<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/myStyle.css">
</head>

<body>

    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

        <?php

        require_once('./functions/functions.inc.php');
        require_once('./matriz.php');

        // print_r($_POST);

        if (!isset($_POST['submit'])) {
            $contador = 0;
        }

        /**
         * La primera vez que iniciamos el juego no se mete en el if ya que submit no esta creado
         * y crea el tablero con la matriz dada, al darle submit se mete por el if y una vez dentro
         * comprueba si se ha mandado por POST la nueva matriz serializada o es la matriz del principio.
         */

        if (isset($_POST['submit'])) {

            if (isset($_POST['nuevaMatriz'])) {
                $matrizDeserializada = unserialize(base64_decode($_POST['nuevaMatriz']));
                // print_r($matrizSerializada);
            } else {
                $matrizDeserializada = unserialize(base64_decode($_POST['matriz']));
                // print_r($matrizDeserializada);
            }

            //Si la columna y la fila esta creada y no esta vacía entra en el if
            if (isset($_POST['columna']) && !empty($_POST['columna']) && isset($_POST['fila']) && !empty($_POST['fila'])) {
                //Si elige una fila o columna incorrecta saltará un error a la hora de pintar por pantalla
                if ($_POST['columna'] < 0 || $_POST['columna'] > 3 || $_POST['fila'] < 0 || $_POST['fila'] > 3) {
                    echo '<p>Movimiento incorrecto</p>';
                } else {

                    if (isset($_POST['nuevoContador'])) {
                        $nuevoContador = $_POST['nuevoContador'];
                    } else {
                        $nuevoContador = $_POST['contador'];
                    }

                    if ($matrizDeserializada[$_POST['columna'] - 1][$_POST['fila'] - 1] === '-') {
                        if ($nuevoContador % 2 === 0) {
                            $fila = $_POST['fila'] - 1;
                            $columna = $_POST['columna'] - 1;
                            $matrizDeserializada[$columna][$fila] = 'X';
                            // print_r($matrizDeserializada);
                            $nuevaMatrizSerializada =
                                base64_encode(serialize($matrizDeserializada));
                            $nuevoContador++;
                        } else {
                            $fila = $_POST['fila'] - 1;
                            $columna = $_POST['columna'] - 1;
                            $matrizDeserializada[$columna][$fila] = '0';
                            // print_r($matrizDeserializada);
                            $nuevaMatrizSerializada =
                                base64_encode(serialize($matrizDeserializada));
                            $nuevoContador++;
                        }
                    } else {
                        echo '<p>Ese hueco ya esta ocupado</p>';
                        $nuevaMatrizSerializada =
                            base64_encode(serialize($matrizDeserializada));
                    }
                }
            }
            //Creacion de tablero
            crearMatriz($matrizDeserializada);
        } else {
            //Creacion de tablero
            crearMatriz($matriz);
        }


        ?>
        <span>Columna</span>
        <br>
        <input type="number" name="columna" value="columna">
        <br>
        <span>Fila</span>
        <br>
        <input type="number" name="fila" value="fila">
        <br>
        <input type="submit" name="submit" value="enviar">

        <?php

        /**
         * La primera vez que inicie el juego no va a entra en el if ya que no se ha creado el boton submit
         * y se meterá por el else serializando la matriz dada y mandandola por un input hidden, al darle al boton
         * submit la matriz se enviara por el nueva campo hidden con la nueva matriz y los cambios hechos.
         */
        if (isset($_POST['submit'])) {
        ?>
            <input type="hidden" name="nuevaMatriz" value="<?php echo $nuevaMatrizSerializada ?>">
            <input type="hidden" name="nuevoContador" value="<?php echo $nuevoContador ?>">
        <?php
        } else {

            $matrizSerializada =
                base64_encode(serialize($matriz));
            // print_r($matrizSerializada);
        ?>
            <input type="hidden" name="matriz" value="<?php echo $matrizSerializada ?>">
            <input type="hidden" name="contador" value="<?php echo $contador ?>">
        <?php
            // print_r($matriz);
        }

        ?>

    </form>

</body>

</html>