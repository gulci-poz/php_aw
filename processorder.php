<!DOCTYPE html>
    <html>
    <head>
        <title>Bob's Auto Parts - Order Results</title>
    </head>

    <body>
        <h1>Bob's Auto Parts</h1>
        <h2>Order Results</h2>
        <?php
        if (empty($_POST['tireqty'])) {
            $tireqty = 0;
        } else {
            $tireqty = $_POST['tireqty'];
        }

        if (empty($_POST['oilqty'])) {
            $oilqty = 0;
        } else {
            $oilqty = $_POST['oilqty'];
        }

        if (empty($_POST['sparkqty'])) {
            $sparkqty = 0;
        } else {
            $sparkqty = $_POST['sparkqty'];
        }

        define('TIREPRICE', 100);
        define('OILPRICE', 10);
        define('SPARKPRICE', 4);

        $date_order = date('H:i, jS F Y');

        echo "<p>Order processed at ";
        echo $date_order;
        echo "</p>";

        $totalqty = 0;
        $totalamount = 0.00;

        $totalqty = $tireqty + $oilqty + $sparkqty;

        if ($tireqty < 10) {
            $discount = 0;
        } elseif (($tireqty >= 10) && ($tireqty <= 49)) {
            $discount = 0.05;
        } elseif (($tireqty >= 50) && ($tireqty <= 99)) {
            $discount = 0.1;
        } elseif ($tireqty >= 100) {
            $discount = 0.15;
        }

        $find = $_POST['find'];

        switch($find) {
            case "a":
                echo "<p>Regular customer.</p>";
                break;
            case "b":
                echo "<p>Customer referred by TV advert.</p>";
                break;
            case "c":
                echo "<p>Customer referred by phone directory.</p>";
                break;
            case "d":
                echo "<p>Customer referred by word of mouth.</p>";
                break;
            default:
                echo "<p>We do not know how you found us.</p>";
                break;
        }

        if ($totalqty == 0) {
            echo '<p style="color:red">';
            echo 'You did not order anything on the previous page!';
            echo '</p>';
        } else {
            echo "<p>Your order is as follows: </p>";

            if ($tireqty > 0) {
                echo $tireqty . " tires, $" . TIREPRICE . " per piece<br />";
            }

            if ($oilqty > 0) {
                echo $oilqty . " bottles of oil, $" . OILPRICE . " per piece<br />";
            }

            if ($sparkqty > 0) {
                echo $sparkqty . " spark plugs, $" . SPARKPRICE . " per piece";
            }
        }

        echo "<br />====================<br />";
        echo "Items ordered: $totalqty<br />";

        $totalamount = $tireqty * TIREPRICE * (1 - $discount) + $oilqty * OILPRICE + $sparkqty * SPARKPRICE;

        if ($discount > 0) {
            echo "Discount on tires: $" . number_format($tireqty * TIREPRICE * $discount) . "<br />";
        }

        echo "Subtotal: $" . number_format($totalamount, 2) . "<br />";

        $taxrate = 0.1;
        $totalamount = $totalamount * (1 + $taxrate);
        echo "Total including tax: $" . number_format($totalamount, 2) . "<br />";

        # otwieranie pliku
        # to jest korzeń serwera www
        # $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

        # korzeń naszego skryptu
        # na potrzeby nauki umieszczam pliki w folderze aplikacji
        # folder, w którym wszyscy mogą zapisywać lepiej umieścić poza folderem skryptu/aplikacji
        $SCRIPT_ROOT = dirname(__FILE__);

        # handle/pointer do pliku
        # fopen() zwraca false, jeśli otwarcie pliku nie powiedzie się
        # pomijamy błąd  i sami go obsługujemy
        # jeśli plik nie istnieje, to z użyciem a będzie próba stworzenia nowego pliku
        @$fp = fopen("$SCRIPT_ROOT/orders/orders.txt", "a");

        if (!$fp) {
            echo "<p><strong>Your order could not be processed.</strong></p>";
        }
        /*
        else {
            echo "<p>File opening... done.</p>";
        }
        */

        # fputs() jest aliasem na fwrite()
        # trzeci argument to dlugość stringa w bajtach, można użyć strlen() do uzyskania długości stringa
        # trzeba dodać jeden, bo strlen() nie liczy znaku końca linii PHP_EOL
        # można użyć przy zapisie binarnym - kompatybilność na różnych platformach
        $address = $_POST['address'];
        $out = $date_order . "\t"
            . $tireqty . " tires" . "\t"
            . $oilqty . " oil" . "\t"
            . $sparkqty . " plugs" . "\t"
            . "$" . $totalamount . "\t"
            . $address
            . PHP_EOL;
        fwrite($fp, $out, strlen($out) + 1);

        # mamy jeszcze funkcje file_put_contents() i file_get_contents()
        # nie trzeba wtedy używać fopen() i fclose()

        # true, jeśli wszystko poszło ok
        fclose($fp);

        # r, r+, w, w+, x, x+, a, a+, b, t
        # domyślnie jest zawsze b
        # trzeci parametr to include_path z konfiguracji PHP, nie trzeba wtedy podawać ścieżki
        # podajemy go jako 1 lub true
        # czwarty parametr to protokół, np. http://
        # otwarcie pliku w zdalnej lokalizacji
        # można wyłączyć tę możliwość za pomocą allow_url_fopen w konfiguracji

        # ==============================

        # komentarz w stylu shell script
        # to jednoliniowy komentarz do końca linii lub do zamykającego tagu

        # echo phpinfo();

        # składnia heredoc z Perla
        # jeden string
        # zamykający tag musi być na samym początku linii, bez tabów
        /*
        echo <<<theEnd
            $tireqty
            ===
            $oilqty
            ===
            $sparkqty
theEnd;
        */

        # nazwy funkcji nie są case sensitive
        # funkcja może mieć taką samą nazwę jak zmienna, ale różną od nazwy innej funkcji
        # typy danych: Integer, Float (Double), String, Boolean, Array, Object
        # zmienne są dynamicznie typowane
        # NULL - zmienne bez nadanej wartośći, zmienne ze zrobionym unset, zmienne z nadaną wartością NULL
        # resource - reprezentują zewnętrzne zasoby (np. połączenia do bazy danych);
        # często zwracane przez funkcję, używane do przekazania do innej funkcji (np. wbudowane funkcje bazy danych)
        # nie manipulujemy bezpośrednio wartościami typu resource

        # stałe, przechowują tylko skalary: int, float, bool, string

        # type casting
        # $totalamount = (float)$totalqty

        # variable variables - możliwość dynamicznej zmiany nazwy zmiennej
        /*
        $varname = 'varvar';
        $$varname = 10;
        */

        # scope zmiennych
        # - wbudowane superglobalne (autoglobalne)
        # $_GLOBALS - tablica zmiennych globalnych, można dodać nową, żeby był dostęp z wewnątrz funkcji
        # $_GLOBALS['myvar']
        # $_SERVER - zmienne środowiskowe serwera
        # $_GET, $_POST, $_COOKIE, $_REQUEST - zawiera inputy z pozostałych trzech
        # $_FILES - zmienne związane z uploadem plików
        # $_ENV - zmienne środowiskowe
        # $_SESSION - sesje
        # - stałe są globalne, widoczne również wewnątrz funkcji
        # - zmienne globalne, nie są widoczne wewnątrz funkcji
        # - zmienne wewnątrz funkcji zadeklarowane jako globalne - referują do globalnych zmiennych o tej samej nazwie
        # - zmienne statyczne wewnątrz funkcji - wartość jest pamiętana między wykonaniami funkcji
        # - zmienne lokalne wewnątrz funkcji

        # operatory arytmetyczne ze stringami, PHP próbuje przetworzyć stringi do liczb
        # w przypadku niepowodzenia zwraca 0; można odczytać e lub E ze stringa
        # przypisanie, wartość wyrażenia to wartość przypisana do zmiennej po lewej
        # można zrobić przypisanie wewnątrz wyrażenia
        # $a = 6 + ($a = 5)
        # przypisanie zmiennej jest przez kopię, jest tworzona nowa zmienna w nowym miejscu w pamięci
        # $b = $a
        # możemy użyć referencji, wówczas zmiany zachodzą na zmiennej przechowywanej w jednym miejscu pamięci
        # referencja to coś jak alias, a nie wskaźnik
        # $b = &$a
        # unset można zrobić na wybranej zmiennej, nie zmienia on wartości drugiej zmiennej,
        # ale odlinkowanej zmiennej daje wartość NULL (undefined)
        /*
        $a = 5;
        $b = 7;
        $b = &$a;
        $a = 10;
        echo "$a $b";
        unset($a);
        # zmienna $a będzie undefined, zmienna $b zachowa swoją wartość
        echo "$a $b";
        */

        # testowanie identyczności === lub !== porównuje wartość i typ
        # te operatory zwracają 1 lub nic
        /*
        if (0 !== (int)"0") {
            echo "not identical";
        } else {
            echo "identical";
        }
        */

        # operatory logiczne
        # ! $$ ||
        # w if ! wymaga zawarcia go w dodatkowym nawiasie
        # and or mają niższy priorytet
        # xor - false jeśli obie wartości są true lub obie są false

        # operatory bitowe & | ~ ^
        # << >> przesunięcie o ileś bitów
        # uwaga na znak przy negacji
        /*
        $a = 4;
        $b = 2;
        $c = -5;
        echo $a & $b;
        echo "<br />";
        echo $a | $b;
        echo "<br />";
        echo ~$c;
        echo "<br />";
        echo $a ^ $b;
        echo "<br />";
        echo $a << 1;
        echo "<br />";
        echo $a >> 1;
        echo "<br />";
        */

        # operator new - powołanie instancji klasy
        # operator -> - dostęp do członka klasy
        # przecinek to też operator

        /*
        $grade = 51;
        echo $grade > 50 ? "Passed" : "Failed";
        */

        # operator error suppression
        /*
        $a = @(32 / 0);
        # potrzebujemy track_errors włączonego w php.ini
        echo $php_errormsg;
        */

        # operator wykonania w linii komend serwera
        /*
        $out = `dir`;
        echo "<pre>$out</pre>"
        */

        # operatory tablicowe
        # [] =>
        # + unia tablic
        # == te same pary klucz/wartość
        # === (!==) te same pary klucz/wartość w tej samej kolejności
        # != lub <> (również w skalarach są oba)

        # operator instaceof
        /*
        class sampleClass {};
        $myObject = new sampleClass();
        if ($myObject instanceof sampleClass) {
            echo "instance of sampleClass";
        }
        */

        # print jest nieznacznie wolniejszy od echo
        # print i echo mogą być wywołane jako funkcje
        # print() zwraca wartość 1

        /*
        $a = 32;
        echo gettype($a) . "<br />";
        settype($a, "double");
        echo $a . " " . gettype($a);
        */

        # is_array(), is_double(), is_float(), is_real(), is_long(), is_int(), is_integer()
        # is_string(), is_bool(), is_object(), is_resource(), is_null(), is_scalar()
        # is_numeric() - również numeryczny string
        # is_callable() - sprawdza, czy zmienna jest nazwą funkcji

        # badanie istnienia zmiennej
        # isset() zwraca 1 lub nic
        # można podać wiele argumentów, jeśli wszstkie będą istniały, to dostaniemy true
        /*
        $a = 32;
        echo isset($a) . "<br />";
        unset($a);
        echo isset($a);
        */

        # empty() - sprawdza istnienie oraz czy zawartość jest niepusta i niezerowa

        # intval(), floatval(), strval()
        # jeśli mamy string, to intval() może przyjąć drugi argument - bazę liczby

        # pierwszy prawdziwy elseif (else if) się wykona

        # switch - warunek musi dać się wyliczyć do prostej wartości - int, float, string
        ?>
    </body>
</html>