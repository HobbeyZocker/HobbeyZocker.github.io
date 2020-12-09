<?php
function checkduplicate($mysqli, $dbentry, $dbname, $prim_id){
    if($dbentry["prim_id"] == -1){
        $result = $mysqli->query(
            "SELECT * FROM $dbname WHERE $prim_id = '".$dbentry["$prim_id"]."'"
        );
        if($result && $result->num_rows > 0){
            $result ->close();
            showerror("Ein Datensatz mit diesem ICAO-Code ist bereits vorhanden!", 1, "showflights.php");
        }
    }
}

function checkdeleteable($mysqli, $dbentry, $prim_id){
    if($dbentry["submittype"] == -1){
        if($prim_id == "icao_code"){
            if($result = $mysqli->query(
                "SELECT * FROM flight WHERE departure_airport_code = '".$dbentry["$prim_id"]."'"
            )){
                $result ->close();
                showerror("Der Flughafen mit diesem ICAO-Code wird noch in der Flugtabelle verwendet!", 1, "showflights.php");
            }else if($result = $mysqli->query(
                "SELECT * FROM flight WHERE destination_airport_code = '".$dbentry["$prim_id"]."'"
            )){
                $result ->close();
                showerror("Der Flughafen mit diesem ICAO-Code wird noch in der Flugtabelle verwendet!", 1, "showflights.php");
            }
        }else{
            if($result = $mysqli->query(
                "SELECT * FROM flight WHERE $prim_id = ".$dbentry["$prim_id"]
            )){
                $result ->close();
                showerror("Ein Datensatz mit diesem Prim&auml;rschl&uuml;ssel wird noch in der Flugtabelle verwendet!", 1, "showflights.php");
            }
        }
    }
}

function checkAirport($mysqli, $dbentry){
    foreach($dbentry as $key => $value){
        if(!isset($dbentry[$key])){
            return false;
        }    
    }

    var_dump($dbentry);
    checkduplicate($mysqli, $dbentry, "airport", "icao_code");
    checkdeleteable($mysqli, $dbentry, "icao_code");
    
    return true;
}

function checkAirline($mysqli, $dbentry){
    foreach($dbentry as $key => $value){
        if(!isset($dbentry[$key])){
            return false;
        }    
    }

    checkdeleteable($mysqli, $dbentry, "airline_id");

    return true;
}

function checkPlane($mysqli, $dbentry){
    foreach($dbentry as $key => $value){
        if(!isset($dbentry[$key])){
            return false;
        }    
    }

    checkdeleteable($mysqli, $dbentry, "plane_id");

    return true;
}

function get_seats_for_plane($mysqli, $plane_id){
    $query = $mysqli->query("
        SELECT passenger_seats_factory FROM plane WHERE plane_id = $plane_id
    ");


    return $query->fetch_array(MYSQLI_NUM)[0];
}

function checkFlight($mysqli, $dbentry){
    foreach($dbentry as $key => $value){
        if(!isset($dbentry[$key])){
            return false;
        }
    }

    if($dbentry["booked_seats"] > $dbentry["passenger_seats"]){
        return false;
    }

    if($dbentry["passenger_seats"] > $dbentry["available_seats"]){
        return false;
    }

    return true;
}

function load_start(){
    $dbentry["submittype"] = filter_input(INPUT_POST, "submittype", FILTER_SANITIZE_NUMBER_INT);
    $dbentry["dbname"] = filter_input(INPUT_POST, "dbname", FILTER_SANITIZE_STRING);
    $dbentry["prim_id"] = filter_input(INPUT_POST, "prim_id", FILTER_SANITIZE_NUMBER_INT) ?? -1;

    return $dbentry;
}

function load_plane($mysqli){
    $dbentry = load_start();
    $dbentry["plane_id"] = filter_input(INPUT_POST, "prim_id", FILTER_SANITIZE_NUMBER_INT) ?? -1;
    $dbentry["manufacturer_id"] = filter_input(INPUT_POST, "manufacturer_id",FILTER_SANITIZE_NUMBER_INT);
    $dbentry["model"] = filter_input(INPUT_POST, "model", FILTER_SANITIZE_STRING);
    $dbentry["travel_speed"] = filter_input(INPUT_POST, "travel_speed",FILTER_SANITIZE_NUMBER_INT);
    $dbentry["travel_height"] = filter_input(INPUT_POST, "travel_height", FILTER_SANITIZE_NUMBER_INT);
    $dbentry["travel_range"] = filter_input(INPUT_POST, "travel_range", FILTER_SANITIZE_NUMBER_INT);
    $dbentry["passenger_seats_factory"] = filter_input(INPUT_POST, "passenger_seats_factory", FILTER_SANITIZE_NUMBER_INT);
    $dbentry["picture_path"] = filter_input(INPUT_POST, "picture_path", FILTER_SANITIZE_STRING);
    $dbentry["manufacturer_name"] = get_name_for_manufacturer($mysqli, $dbentry["manufacturer_id"]);
        
    return $dbentry;
}

function load_flight($mysqli){
    $dbentry = load_start();
    $dbentry["flight_id"] = filter_input(INPUT_POST, "prim_id", FILTER_SANITIZE_NUMBER_INT) ?? -1;
    $dbentry["airline_id"] = filter_input(INPUT_POST, "airline_id",FILTER_SANITIZE_NUMBER_INT);
    $dbentry["departure_airport_code"] = filter_input(INPUT_POST, "departure_airport_code", FILTER_SANITIZE_STRING);
    $dbentry["destination_airport_code"] = filter_input(INPUT_POST, "destination_airport_code",FILTER_SANITIZE_STRING);
    $dbentry["plane_id"] = filter_input(INPUT_POST, "plane_id", FILTER_SANITIZE_NUMBER_INT);
    $dbentry["departure_time"] = filter_input(INPUT_POST, "departure_time", FILTER_SANITIZE_STRING);
    $dbentry["departure_date"] = filter_input(INPUT_POST, "departure_date", FILTER_SANITIZE_STRING);
    $dbentry["passenger_seats"] = filter_input(INPUT_POST, "passenger_seats", FILTER_SANITIZE_NUMBER_INT);
    $dbentry["booked_seats"] = filter_input(INPUT_POST, "booked_seats", FILTER_SANITIZE_NUMBER_INT);
    $dbentry["price"] = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $dbentry["available_seats"] = get_seats_for_plane($mysqli, $dbentry["plane_id"]);

    return $dbentry;
}

function load_airport(){
    $dbentry = load_start();
    $dbentry["icao_code"] = filter_input(INPUT_POST, "icao_code", FILTER_SANITIZE_STRING) ?? filter_input(INPUT_POST, "primid", FILTER_SANITIZE_STRING);
    $dbentry["name"] = filter_input(INPUT_POST, "name",FILTER_SANITIZE_STRING);
    $dbentry["city"] = filter_input(INPUT_POST, "city", FILTER_SANITIZE_STRING);
    $dbentry["country"] = filter_input(INPUT_POST, "country",FILTER_SANITIZE_STRING);
    
    return $dbentry;
}

function load_airline(){
    $dbentry = load_start();
    $dbentry["airline_id"] = filter_input(INPUT_POST, "prim_id", FILTER_SANITIZE_STRING) ?? -1;
    $dbentry["name"] = filter_input(INPUT_POST, "name",FILTER_SANITIZE_STRING);
    $dbentry["picture_path"] = filter_input(INPUT_POST, "picture_path", FILTER_SANITIZE_STRING);
        
    return $dbentry;
}

function load_data_switch($mysqli, $dbname){
    switch($dbname){
        case "plane":
            return load_plane($mysqli);
        break;
        case "airline":
            return load_airline();
        break;
        case "flight":
            return load_flight($mysqli);
        break;
        case "airport":
            return load_airport();
        break;
    }
}

function get_airport_string($mysqli, $key){
    $query = $mysqli->query("
        SELECT name, city, country FROM airport WHERE icao_code = '$key'
    ");

    $value = $query->fetch_array(MYSQLI_ASSOC);

    $query->free();
    return $value["city"]." (".$value["name"]."), ".$value["country"];
}

function get_airline_string($mysqli, $key){
    $query = $mysqli->query("
        SELECT name FROM airline WHERE airline_id = '$key'
    ");

    $value = $query->fetch_array(MYSQLI_ASSOC);

    $query->free();
    return $value["name"];
}

function get_plane_string($mysqli, $key){
    $query = $mysqli->query("
        SELECT manufacturer_id, model FROM plane WHERE plane_id = '$key'
    ");

    $value = $query->fetch_array(MYSQLI_ASSOC);

    $query->free();
    return get_name_for_manufacturer($mysqli, $value["manufacturer_id"])." ".$value["model"];
}

function get_insert_string($dbentry, $dbname){
    switch($dbname){
        case "flight":
            return 
                "INSERT INTO ".$dbentry["dbname"]." 
                    VALUES (
                        NULL, 
                        ".$dbentry["airline_id"].", 
                        '".$dbentry["departure_airport_code"]."',
                        '".$dbentry["destination_airport_code"]."',                     
                        ".$dbentry["plane_id"].",                     
                        '".$dbentry["departure_time"]."',                     
                        '".$dbentry["departure_date"]."',                     
                        ".$dbentry["passenger_seats"].",
                        ".$dbentry["booked_seats"].",
                        ".$dbentry["price"]."                   
                    )";
        break;
        case "airline":
            return 
                "INSERT INTO ".$dbentry["dbname"]." 
                VALUES (
                    NULL, 
                    '".$dbentry["name"]."', 
                    '".$dbentry["picture_path"]."'
                )";
        break;
        case "plane":
            return
                "INSERT INTO ".$dbentry["dbname"]." 
                VALUES (
                    NULL, 
                    ".$dbentry["manufacturer_id"].", 
                    '".$dbentry["model"]."',
                    ".$dbentry["travel_speed"].",                     
                    ".$dbentry["travel_height"].",                     
                    ".$dbentry["travel_range"].",                     
                    ".$dbentry["passenger_seats_factory"].",                     
                    '".$dbentry["picture_path"]."'
                )";
        break;
        case "airport":
            return
                "INSERT INTO ".$dbentry["dbname"]." 
                VALUES (
                    '".$dbentry["icao_code"]."', 
                    '".$dbentry["name"]."', 
                    '".$dbentry["city"]."',
                    '".$dbentry["country"]."'
                )";
        break;
    }
}

function get_modify_string($dbentry, $dbname){
    switch($dbname){
        case "plane":
            return
            "UPDATE ".$dbentry["dbname"]." 
                    SET 
                        manufacturer_id='".$dbentry["manufacturer_id"]."',
                        model='".$dbentry["model"]."',
                        travel_speed=".$dbentry["travel_speed"].",
                        travel_height=".$dbentry["travel_height"].",
                        travel_range=".$dbentry["travel_range"].",
                        passenger_seats_factory=".$dbentry["passenger_seats_factory"].",
                        picture_path='".$dbentry["picture_path"]."'
                    WHERE 
                        plane_id=".$dbentry["plane_id"];
        break;
        case "airline":
            return
                "UPDATE ".$dbentry["dbname"]." 
                SET 
                    name='".$dbentry["name"]."',
                    picture_path='".$dbentry["picture_path"]."'
                WHERE 
                    airline_id=".$dbentry["airline_id"];
        break;
        case "flight":
            return
            "UPDATE ".$dbentry["dbname"]." 
                    SET 
                    airline_id=".$dbentry["airline_id"].", 
                    departure_airport_code='".$dbentry["departure_airport_code"]."',
                    destination_airport_code='".$dbentry["destination_airport_code"]."',                     
                    plane_id=".$dbentry["plane_id"].",                     
                    departure_time='".$dbentry["departure_time"]."',                     
                    departure_date='".$dbentry["departure_date"]."',                     
                    passenger_seats=".$dbentry["passenger_seats"].",
                    booked_seats=".$dbentry["booked_seats"].",
                    price=".$dbentry["price"]."
                    WHERE 
                        flight_id=".$dbentry["flight_id"];
        break;
        case "airport":
            return 
            "UPDATE ".$dbentry["dbname"]." 
            SET
                name='".$dbentry["name"]."', 
                city='".$dbentry["city"]."',
                country='".$dbentry["country"]."'
            WHERE 
                icao_code='".$dbentry["icao_code"]."'";
        break;
    }
}

function get_delete_string($dbentry, $dbname){
    switch($dbname){
        case "plane":
            return
                "DELETE FROM ".$dbentry["dbname"]." 
                WHERE plane_id = ".$dbentry["plane_id"];
        break;
        case "airline":
            return
                "DELETE FROM ".$dbentry["dbname"]." 
                    WHERE airline_id = ".$dbentry["airline_id"];
        break;
        case "flight":
            return
                "DELETE FROM ".$dbentry["dbname"]." 
                WHERE flight_id = ".$dbentry["flight_id"];
        break;
        case "airport":
            return
                "DELETE FROM ".$dbentry["dbname"]." 
                WHERE icao_code = '".$dbentry["icao_code"]."'";
        break;
    }
}

function modifydb($mysqli, $dbname){
    $dbentry = load_data_switch($mysqli, $dbname);

    // var_dump($dbentry);
    // var_dump(get_insert_string($dbentry, $dbname));

    if($dbentry["submittype"] != -1){
        if($dbentry["prim_id"] == -1){
            if($mysqli->query(
                get_insert_string($dbentry, $dbname)
            ) === TRUE){
                echo "Daten erfolgreich hinzugef&uuml;gt!";
            }else{
                echo "Fehler beim Einf&uuml;gen auf die Datenbank: ".$mysqli->error;
            }
        }else{
            if($mysqli->query(
                get_modify_string($dbentry, $dbname)
            ) === TRUE){
                echo "Daten erfolgreich bearbeitet!";
            }else{
                echo "Fehler beim Modifizieren der Datenbank: ".$mysqli->error;
            }
        }
    }else{
        if($mysqli->query(
           get_delete_string($dbentry, $dbname)
        ) === TRUE){
            echo "Daten erfolgreich gel&ouml;scht!";
        }else{
            echo "Fehler beim L&ouml;schen auf der Datenbank: ".$mysqli->error;
        }
    }
}

?>