<?php
$DOCUMENT_ROOT = dirname(__FILE__);
?>
<html>
    <head>
        <title>Bob's Auto Part - Customer Orders</title>
    </head>
    <body>
    <?php
    # (1) odczyt linia po linii - fgets(), fgetss(), fgetcsv()

    # domyślnie jest operacja na pliku binarnym, "rb"
    @$fp = fopen("$DOCUMENT_ROOT/orders/orders.txt", "r");
    flock($fp, LOCK_SH);

    if (!$fp) {
        echo "<p><strong>No orders pending.</strong></p>";
        exit;
    }

    # w jednym obiegu pętli czytamy do napotkania nowej linii
    # odczytujemy maksymalnie 998 bajtów (parametr - 1) z linii
    # można podać wartość większą od ilości znaków w najdłuższej linii
    # czytamy do końca pliku - feof()
    # przesuwamy pointer po pliku
    while (!feof($fp)) {
        $order = fgets($fp, 999);
        echo $order . "<br />";
        # odczyt pozycji wskaźnika, w bajtach
        echo "Position: " . ftell($fp) . "<br />";
    }

    # fgets() - do odczytu plików tekstowych
    # fgetss() - odczyt z pominięciem tagów html i php,
    # w trzecim argumencie typu string można podać tagi, które chcemy odczytać
    # fgetcsv() - jako trzeci argument podajemy delimiter (np. "\t"), dostajemy tablicę
    # jest jeszcze czwarty argument typu string - enclosure, opakowanie każdego odczytanego elementu,
    # domyślnie jest to podwójny cudzysłów

    # jeśli chcemy ponownie odczytywać plik, to musimy przesunąć pointer z powrotem na początek
    rewind($fp);

    echo "<p>Record by record view:</p>";

    while (!feof($fp)) {
        $order = fgetcsv($fp, 999, "\t");
        # w przypadku pustej linii będziemy mieli pustą tablicę do iteracji i warning
        if ($order) {
            foreach ($order as $value) {
                echo $value . "<br />";
            }
            echo "<span>====================</span><br />";
        }
    }

    rewind($fp);

    # (2) odczyt zawartości całego pliku - fpassthru(), readfile(), file_get_contents(), file()

    # zawartość pliku na standardowe wyjście, od pozycji wskaźnika do końca pliku, zamyka plik
    # zwraca true/false
    # potrzebuje file handle
    fpassthru($fp);

    flock($fp, LOCK_UN);
    fclose($fp);

    echo "<p>File content:</p>";

    # odczyt całego pliku, wyjście na przeglądarkę, zamknięcie pliku
    # zwraca liczbę bajtów odczytanych z pliku
    # drugi argument - include_path
    # trzeci argument - kontekst, dla zdalnego otwierania plików
    $bytes_read = readfile("$DOCUMENT_ROOT/orders/orders.txt", "r");
    echo "<p>$bytes_read bytes read</p>";

    # podobna do readfile() jest funkcja file_get_contents(), zwraca stringa z zawartością pliku

    # odczyt pliku w postaci tablicy, funkcja file()
    # $file_array = file("$DOCUMENT_ROOT/orders/orders.txt", "r");

    # (3) odczyt znak po znaku - fgetc()

    echo "<p>Characters:</p>";

    @$fpc = fopen("$DOCUMENT_ROOT/orders/orders.txt", "r");

    if (!$fpc) {
        echo "<p><strong>No orders pending.</strong></p>";
        exit;
    }

    while (!feof($fpc)) {
        $char = fgetc($fpc);
        # fgetc() zwraca znak EOF, fgets() tego nie robi
        # trzeba zrobić sprawdzenie EOF
        if (!feof($fpc)) {
            echo ($char=="\n" ? "<br />" : $char);
        }
    }

    fclose($fpc);

    # (4) odczyt danej ilości bajtów - fread()

    # fread($fp, length)

    # (5) inne funkcje - file_exists(), filesize(), fread(), nl2br(), unlink()

    # sprawdzenie istnienia pliku bez jego otwierania
    if (file_exists("$DOCUMENT_ROOT/orders/orders.txt")) {
        echo "<p>File exists.</p>";
    } else {
        echo "<p>File doesn't exist.</p>";
    }

    $filesize = filesize("$DOCUMENT_ROOT/orders/orders.txt");
    echo "File size: $filesize<br />";

    echo "<p>Read all:</p>";
    $fpall = fopen("$DOCUMENT_ROOT/orders/orders.txt", "r");
    # konwersja "\n" na "<br />"
    echo nl2br(fread($fpall, $filesize));
    fclose($fpall);

    # usuwanie pliku, zwraca false (nic), jeśli nie uda się usunąć pliku
    # dodajemy @ żeby nie pokazywać warninga
    @$file_deleted = unlink("$DOCUMENT_ROOT/orders/orders2.txt");
    echo "File deleted: $file_deleted";

    # (6) przemieszczanie pointera - rewind(), ftell(), fseek()

    # przejście do wybranego punktu pliku
    # fseek($fp, offset[, whence])
    # przesunięcie pointera o offset bajtów od punktu whence
    # domyślnie whence ma wartość SEEK_SET - początek pliku (argument opcjonalny)
    # mamy też wartości SEEK_CUR i SEEK_END
    # rewind() to ekwiwalent fseek() z zerowym offsetem

    # (7) blokowanie pliku - flock()

    # wywołanie po otwarciu pliku, ale przed jakimkolwiek odczytem/zapisem, trzeba też odblokować
    # flock($fp, lock_type)
    # lock_type - stała
    # LOCK_SH - reading, inni mogą czytać plik
    # LOCK_EX - writing, plik nie może być dzielony
    # LOCK_UN - istniejący lock jest zwalniany
    # LOCK_NB - uniknięcie blokady
    # zwraca true/false
    # opcjonalny trzeci parametr - true, jeśli osiągnięcie loka zablokuje proces
    # flock() musi być użyty we wszystkich skryptach, gdzie używamy pliku, inaczej może się okazać bezcelowy
    # nie działa z NFS i innymi NFS-ami, nie działa z FAT
    # w niektórych systemach jest zaimplementowany na poziomie procesu
    # i nie działa poprawnie z wielowątkowymi API serwera
    # możliwa sytuacja: dwa skrypty będą chciały uzyskać loka w tym samym czasie
    # race condition - procesy się ścigają o loka
    ?>
    </body>
</html>
