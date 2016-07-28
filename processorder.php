<!DOCTYPE html>
    <html>
    <head>
        <title>Bob's Auto Parts - Order Results</title>
    </head>

    <body>
        <h1>Bob's Auto Parts</h1>
        <h2>Order Results</h2>
        <?php
            # komentarz w stylu shell script
            # jednoliniowy komentarz do końca linii lub do zamykającego tagu
            # php.init: always_populate_raw_post_data = -1

            $tireqty = $_POST['tireqty'];
            $oilqty = $_POST['oilqty'];
            $sparkqty = $_POST['sparkqty'];

            echo "<p>Order processed at ";
            echo date('H:i, jS F Y');
            echo "</p>";

            echo "<p>Your order is as follows: </p>";
            echo $tireqty . " tires<br />";
            echo $oilqty . " bottles of oil<br />";
            echo $sparkqty . " spark plugs<br />";
        ?>
    </body>
</html>