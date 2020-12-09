<?php
function get_query_line($query){
    if($query === -1){
        return NULL;
    }else{
        if ($query === FALSE || $query->num_rows == 0) {
            showerror("Prim&auml;rschl&uuml;ssel unbekannt!", 0, "showflights.php");
        }
        return $query->fetch_array(MYSQLI_ASSOC);
    }
}

function show_start($query, $queryisentry, $showdeletemsg){
    if($queryisentry === TRUE){
        $content = $query;
    }else{
        $content = get_query_line($query);
    }

    if($showdeletemsg === TRUE){
        echo "<h1>Sind sie sicher, dass Sie den folgenden Eintrag l&ouml;schen wollen?</h1><br>";
    }

    return $content;
}

function build_edit($mysqli, $type, $query){
    echo "<div class=\"page\">";
    switch ($type) {
        case "plane":
            editPlane($mysqli, $query);
        break;
        case "flight":
            editFlight($mysqli, $query);
        break;
        case "airport":
            editAirport($mysqli, $query);
        break;
        case "airline":
            editAirline($mysqli, $query);
        break;
    }
    echo "</div>";
}

function print_form_start($dbname, $prim_id){
    echo "
    <form action='confirmchanges.php' method='POST'>
        <input type='hidden' name='dbname' value='$dbname'>
        <input type='hidden' name='primid' value='".($prim_id ?? "-1")."'>";
}

function editAirport($mysqli, $query) {
    $content = get_query_line($query);

    print_form_start("airport", $content["icao_code"]);    
    echo "  <strong>Flughafen </strong><input type='text' name='name' value='".($content["name"] ?? "")."'> <br><br>
                <strong>Stadt: </strong><input type='text' name='city' value='".($content["city"] ?? "")."'> <br><br>
                        <strong>Land: </strong><input type='text' name='country' value='".($content["country"] ?? "")."'> <br><br>
                        <strong>ICAO: </strong>";
                        if(isset($content["icao_code"])){
                            echo $content["icao_code"];
                        }else{
                            echo "<input type='text' name='icao_code'>";
                        }

    echo "<br>";
    print_form_end($query, "showairports.php");
}

function print_form_end($query, $url){
    echo "<button class=\"ui drei\" type='button' onclick=\"location.href='$url'\">&Auml;nderungen verwerfen</button>\n";
    if($query !== -1){
        echo "<button class=\"ui drei\" type='submit' name='submittype' value='-1'>Eintrag l&ouml;schen!</button>\n";
    }
    echo "<button class=\"ui drei\" type='submit' name='submittype' value='1'>&Auml;nderungen speichern!</button>\n
    </form>";
}

function build_select_with_options($options, $selected_option, $select_name){
    echo "<select name='$select_name'>\n";
    foreach($options as $key => $value){
            echo "<option value='$key' ".($key == $selected_option ? "selected" : "").">$value</option>\n";
    }
    echo "</select>\n";
}

function editFlight($mysqli, $query) {
    $content = get_query_line($query);

    print_form_start("flight", $content["flight_id"]);
    
    echo 
        "<h1>Flug ".($content["flight_id"] ?? "")."</h1>
        <strong>Datum: </strong><input type='date' name='departure_date' value='".($content["departure_date"] ?? "")."'>
        <br> <br>
        <strong>Abflug: </strong><input type='time' name='departure_time' value='".($content["departure_time"] ?? "")."'>\n <br> <br>";
    
    $airports = collect_airport_options($mysqli);
    echo "<strong>Startflughafen: </strong>\n";
        build_select_with_options($airports, $content["departure_airport_code"], "departure_airport_code");
    
    echo "<br>
    <strong>Zielflughafen: </strong>";
        build_select_with_options($airports, $content["destination_airport_code"], "destination_airport_code");
        
    echo "<br><hr><br>\n
    <strong>Airline: </strong>";
    build_select_with_options(collect_airport_options($mysqli), $content["airline_id"], "airline_id");
    
    echo "<br> <strong>Typ: </strong>";
    build_select_with_options(collect_plane_options($mysqli), $content["plane_id"], "plane_id");
    
    echo "<br>
    <strong>Belegung: </strong>
        <input type='number' name='booked_seats' value='".($content["booked_seats"] ?? "")."'> / <input type='number' name='passenger_seats' value='".($content["passenger_seats"] ?? "")."'>
    <strong><br><br>Ticketpreis: </strong><input min='0' step='.01' type='number' name='price' value='".($content["price"] ?? "")."'>
    <br>";

    print_form_end($query, "showairport.php");
}



function editAirline($mysqli, $query) {
    $content = get_query_line($query);
    
    print_form_start("airline", $content["airline_id"]);

    echo "<strong>Airline: </strong><input type='text' name='name' value='".($content["name"] ?? "")."'><br>
            <img height='".get_airline_picture_height()."' src=\"".get_picture_path("airlines").($content["picture_path"] ?? "")."\" alt=\"Airline Bild\"><br>
        <strong>Bildpfad: </strong><input type='text' name='picture_path' value='".($content["picture_path"] ?? "")."'><br>";

    print_form_end($query, "showairport.php");
}

function build_detail($mysqli, $type, $query){
    switch ($type) {
        case "plane":
            showPlane($mysqli, $query, FALSE, FALSE);
        break;
        case "flight":
            showFlight($query, FALSE, FALSE);
        break;
        case "airport":
            showAirport($query, FALSE, FALSE);
        break;
        case "airline":
            showAirline($query, FALSE, FALSE);
        break;
    }
}

function showAirport($query, $queryisentry, $showdeletemsg) {
    $content = show_start($query, $queryisentry, $showdeletemsg);

    echo "
    <div class=\"page\">
        <h1>Flughafen ".$content["name"]."</h1>
            <br> 
                <strong>Stadt: </strong>" . $content["city"] . "
            <br> 
                <strong>Land: </strong>" . $content["country"] . "
            <br>
                <strong>ICAO: </strong>" . $content["icao_code"];

    if($queryisentry === TRUE){
        build_modify_db("flight", $query, $content["icao_code"]);
    }

    echo "</div>";
}

function showFlight($query, $queryisentry, $showdeletemsg) {
    $content = show_start($query, $queryisentry, $showdeletemsg);

    echo "
    <div class=\"page\">
    <h1>Flug ".$content["flight_id"]."</h1>
        <strong>Datum: </strong>".convertDate($content["departure_date"])."
    <br>
        <strong>Abflug: </strong>".$content["departure_time"]."
    <br>
    <br>        
        <strong>Startflughafen: </strong>".$content["dep_city"]." (".$content["dep_name"]."), ".$content["dep_country"]."
    <br>
        <strong>Zielflughafen: </strong>".$content["dest_city"]." (".$content["dest_name"]."), ".$content["dest_country"]."
    
    <hr>
        <strong>Airline: </strong> ".$content["airline_name"]."
    <br>
        <strong>Typ: </strong> ".$content["pm_name"]." ".$content["model"]."<br>
        <strong>Belegung: </strong> ".$content["booked_seats"]." / ".$content["passenger_seats"]."
    <br><br>";

    if($queryisentry === TRUE){
        build_modify_db("flight", $query, $content["flight_id"]);
    }else{
        echo "
            <button class=\"ui\" id=\"secon\" onclick=\"location.href='showflights.php'\">Zur&uuml;ck zur &Uuml;bersicht</button>
            <button class=\"ui\" id=\"prim\">Jetzt Buchen!</button>\n";
    }

    echo "</div>";
}

function showAirline($query, $queryisentry, $showdeletemsg) {
    $content = show_start($query, $queryisentry, $showdeletemsg);

    echo "
    <div class=\"page\">
    <h1>Airline: ".$content["name"]."</h1>
    <img height='".get_airline_picture_height()."' src=\"".get_picture_path("airlines").$content["picture_path"]. "\" alt=\"Airline Bild\">";

    if($queryisentry === TRUE){
        build_modify_db("airline", $query, $content["airline_id"]);
    }

    echo "</div>";
}

function editPlane($mysqli, $query) {
    $content = get_query_line($query);

    print_form_start("plane", $content["plane_id"]);
    
    echo "<h1>Flugzeug: </h1>";
    echo "<img height='".get_plane_picture_height()."' src=\"".get_picture_path("planes").($content["picture_path"] ?? "")."\" alt=\"Flugzeug Bild\"> <br> <br>";
    
    build_select_with_options(collect_plane_manufacturer_options($mysqli), $content["manufacturer_id"], "manufacturer_id");
    
    echo "<input type='text' name='model' value='".($content["model"] ?? "")."'>\n <br>
          <strong>Bildpfad: </strong><input type='text' name='picture_path' value='".($content["picture_path"] ?? "")."'>
    <br> <br>
        <strong>Reisegeschwindigkeit: </strong><input type='number' min='0' name='travel_speed' value='".($content["travel_speed"] ?? "")."'> km/h <br><br>
        <strong>Reiseflugh&ouml;he: </strong><input type='number' min='0' name='travel_height' value='".($content["travel_height"] ?? "")."'> m
    <br> <br>
        <strong>Reichweite: </strong><input type='number' min='0' name='travel_range' value='".($content["travel_range"] ?? "")."'> km <br> <br>
        <strong>Verf&uuml;gbare Sitzpl&auml;tze: </strong><input type='number' min='0' name='passenger_seats_factory' value='".($content["passenger_seats_factory"] ?? "")."'>
    <br> <br>";
    print_form_end($query, "showairport.php");
    
    echo "</form>";
}


function showPlane($mysqli, $query, $queryisentry, $showdeletemsg) {
    $content = show_start($query, $queryisentry, $showdeletemsg);

    echo "
    <div class=\"page\">
        <h1>
            Flugzeug: ".
                get_name_for_manufacturer($mysqli, $content["manufacturer_id"]).
            " ".
                $content["model"].
            "</h1>\n
        <img height='".get_plane_picture_height()."' src=\"".get_picture_path("planes").$content["picture_path"]. "\" alt=\"Flugzeug Bild\">
    <br>
    <strong>Reisegeschwindigkeit: </strong>".$content["travel_speed"]." km/h
    <br>
    <strong>Reiseflugh&ouml;he: </strong>" . $content["travel_height"] . " m
    <br>
    <strong>Reichweite: </strong>" . $content["travel_range"] . " km
    <br>
    <strong>Verf&uuml;gbare Sitzpl&auml;tze: </strong>" . $content["passenger_seats_factory"] . "</td>\n
    </div>";

    if($queryisentry === TRUE){
        build_modify_db("plane", $query, $content["plane_id"]);
    }
}

function get_query($mysqli, $type, $val){
    if($val == -1){
        return -1;
    }

    switch ($type) {
        case "plane":
            return $mysqli->query("
                    SELECT * FROM plane WHERE plane_id = $val
                ");
            
            break;
        case "flight":
            return $mysqli->query("
                            SELECT * FROM flightview WHERE flight_id = $val
                        ");
            break;
        case "airport":
            return $mysqli->query("
                            SELECT * FROM airport WHERE icao_code = '$val'
                        ");
            break;
        case "airline":
            return $mysqli->query("
                SELECT * FROM airline WHERE airline_id = $val
                ");
            break;
        default:
            showerror("Datenbanktyp unbekannt!", 0, "/HypertextPreprocessor/index.php");
    }
}



function collect_plane_manufacturer_options($mysqli){
    $query = $mysqli->query("
        SELECT manufacturer_id, name FROM plane_manufacturer ORDER BY name
    ");

    while($value = $query->fetch_array(MYSQLI_ASSOC)){
        $array[$value["manufacturer_id"]] = $value["name"];
    }

    $query->free();
    return $array;
}

function collect_plane_options($mysqli){
    $query = $mysqli->query("
        SELECT p.plane_id, p.model, pm.name FROM plane_manufacturer as pm, plane as p WHERE p.manufacturer_id = pm.manufacturer_id ORDER BY pm.name, p.model
    ");

    while($value = $query->fetch_array(MYSQLI_ASSOC)){
        $array[$value["plane_id"]] = $value["name"]." ".$value["model"];
    }

    $query->free();
    return $array;
}

function collect_airline_options($mysqli){
    $query = $mysqli->query("
        SELECT airline_id, name FROM airline ORDER BY name
    ");

    while($value = $query->fetch_array(MYSQLI_ASSOC)){
        $array[$value["airline_id"]] = $value["name"];
    }

    $query->free();
    return $array;
}

function collect_airport_options($mysqli){
    $query = $mysqli->query("
        SELECT icao_code, name, city, country FROM airport ORDER BY country, city
    ");

    while($value = $query->fetch_array(MYSQLI_ASSOC)){
        $array[$value["icao_code"]] = $value["city"]." (".$value["name"]."), ".$value["country"];
    }

    $query->free();
    return $array;
}

function build_modify_db($dbtype, $dbentry, $primid){
    echo "
    <form action='modifyDatabase.php' method='POST'>";
    foreach($dbentry as $key => $val){
        echo "<input type='hidden' name='$key' value='$val'>";
    }
    echo "
    <button type='button' onclick='location.href=\"showdetail.php?type=$dbtype&val=$primid\"''>&Auml;nderungen verwerfen!</button>
    <button type='submit'>Datensatz ver&auml;ndern!</button>
    </form>";
}

?>