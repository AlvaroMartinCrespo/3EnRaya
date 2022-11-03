<?php

function crearMatriz($matriz)
{
    echo '<table>';
    echo '<tbody>';

    for ($i = 0; $i < 3; $i++) {

        echo '<tr class="border">';

        for ($j = 0; $j < 3; $j++) {

            if ($matriz[$i][$j] === 'X') {
                echo '<td class="red">' . $matriz[$i][$j] . '</td>';
            } else {
                echo '<td class="blue">' . $matriz[$i][$j] . '</td>';
            }
        }

        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
