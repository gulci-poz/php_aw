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
            $distance = 50;

            while ($distance <= 250) {
                echo '<tr>';
                echo '<td align=\"right\">' . $distance . '</td>';
                echo '<td align=\"right\">' . ($distance / 10) . '</td>';
                echo '</tr>';

                $distance += 50;
            }
            ?>
        </table>
    </body>
</html>