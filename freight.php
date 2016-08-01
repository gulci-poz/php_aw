<!DOCTYPE html>
<html>
    <head>
        <title>Freight Cost</title>
    </head>

    <body>
        <table border="0" cellpadding="3">
            <tr bgcolor="#cccccc">
                <td align="center">Distance</td>
                <td align="center">Cost</td>
            </tr>
            <?php

            /*
            $distance = 50;

            while ($distance <= 250) {
                echo '<tr>';
                echo '<td align=\"right\">' . $distance . '</td>';
                echo '<td align=\"right\">' . ($distance / 10) . '</td>';
                echo '</tr>';

                $distance += 50;
            }
            */

            # ten sam kod z użyciem for
            # mamy też pętlę foreach
            for ($distance = 50; $distance <= 250; $distance += 50) {
                echo '<tr>';
                echo '<td align=\"right\">' . $distance . '</td>';
                echo '<td align=\"right\">' . ($distance / 10) . '</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <?php
        # iterowanie po polach formularza o podobnych nazwach za pomocą var var
        /*
        $name1 = "seb";
        $name2 = "kar";
        $name3 = "wik";
        $name4 = "mel";
        $numnames = 4;

        for ($i = 1; $i <= $numnames; $i++) {
            $temp = "name$i";
            echo $$temp . "<br />";
        }
        */

        # do while
        $num = 10;

        do {
            echo $num . "<br />";
            $num -= 1;
        } while ($num > 0);

        # break - wyskok z pętli
        # continue - przejście do następnego obiegu pętli
        # exit - wyjście ze skryptu, PHP zaprzestaje wykonywania skryptu
        # zamiast klamer można użyć dwukropka i zamykającego słowa:
        # endif, endswitch, endwhile, endfor, endforeach (nie ma dla do while)

        # deklaracja dyrektywy wywołania dla bloku kodu
        # dyrektywa - definiuje zasady wykonania kodu
        /*
        declare (directive) {
            # blok kodu
        }
        */
        # jest zaimplementowana tylko jedna dyrektywa ticks=n, kod w dyrektywie zostanie wykonany co n linii kodu
        ?>
    </body>
</html>