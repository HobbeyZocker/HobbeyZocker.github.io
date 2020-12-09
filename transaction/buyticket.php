<?php
include("../header.php");
?>

<div class="page buyticket">
    <?php
    $mysqli = connectMySQL();
    $flight_id = filter_input(INPUT_GET, "flight", FILTER_SANITIZE_NUMBER_INT);
    if(!(isset($_SESSION["login"]) && $_SESSION["login"] === TRUE)){
        showerror("Sie m&uuml;ssen angemeldet sein um Tickets zu kaufen!", 2, "../index.php");
    }

    $info = $mysqli->query("
            SELECT * FROM flightview WHERE flight_id = $flight_id
        ");
    $info = $info->fetch_array(MYSQLI_ASSOC);
    $max = $info["passenger_seats"] - $info["booked_seats"];

    if ($max == 0) {
        showerror("Dieses Ticket ist bereits ausverkauft.", 1, "/HypertextPreprocessor/index.php");
    }

    echo "
        <form action=\"processTransaction.php\" enctype=\"multipart/form-data\" method=\"POST\">
        <input type='hidden' name='flight_id' value='$flight_id'>
        <div>
            <img height='".get_airline_picture_height()."' src=\"" .get_picture_path("airlines").$info["airline_picture"] . "\">
            <h1>" . $info["airline_name"] . ": " . $info["departure_airport_code"] . " - " . $info["destination_airport_code"] . " (" . $info["flight_id"] . ")</h1>
        </div>
        
        <div>
            <strong>Datum: </strong> ". convertDate($info["departure_date"]) ." <br>
            <strong>Start: </strong>" . $info["departure_time"] . " - " . $info["dep_city"] . " (" . $info["dep_name"] . ")" . " <br>
            <strong>Ziel: </strong>" . $info["dest_city"] . " (" . $info["dest_name"] . ")" . " <br>
            <hr>
            
            <strong>Gebuchte Plätze: </strong>" . $info["booked_seats"] . " / " . $info["passenger_seats"] . " <br>
            <strong>Preis pro Ticket: </strong>" . $info["price"] . " &euro;" ." <br>
            <strong>Anzahl: </strong> <input type=\"number\" max=\"$max\" value=\"1\" name=\"ticketcount\" min=\"1\">
        </div>
        <div>
            <button class=\"ui\" id=\"secon\" type=\"button\" onclick=\"location.href='/HypertextPreprocessor/DataView/showflights.php'\">Abbrechen</button>
            <button class=\"ui\" id=\"prim\" type=\"submit\">Ticket(s) zum Warenkorb hinzuf&uuml;gen</button>
        </div>
                    
        </form>";
    ?>
</div>

<?php
include("../footer.php");
?>
