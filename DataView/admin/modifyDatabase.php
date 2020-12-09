<?php

include("../header.php");

$mysqli = connectMySQL();

modifydb($mysqli, filter_input(INPUT_POST, "dbname", FILTER_SANITIZE_STRING));

// if($dbentry["submittype"] != -1){
//     if($dbentry["flight_id"] == -1){
//         if($mysqli->query(
//             "INSERT INTO ".$dbentry["dbname"]." 
//                 VALUES (
//                     NULL, 
//                     ".$dbentry["airline_id"].", 
//                     '".$dbentry["departure_airport_code"]."',
//                     '".$dbentry["destination_airport_code"]."',                     
//                     ".$dbentry["plane_id"].",                     
//                     '".$dbentry["departure_time"]."',                     
//                     '".$dbentry["departure_date"]."',                     
//                     ".$dbentry["passenger_seats"].",
//                     ".$dbentry["booked_seats"].",
//                     ".$dbentry["price"]."                   
//                     )"
//         ) === TRUE){
//             echo "Flug ".$dbentry["departure_airport_code"]." nach ".$dbentry["destination_airport_code"]." erfolgreich hinzugef&uuml;gt!";
//         }else{
//             echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//         }
//     }else{
//         if($mysqli->query(
//             "UPDATE ".$dbentry["dbname"]." 
//                 SET 
//                 airline_id=".$dbentry["airline_id"].", 
//                 departure_airport_code='".$dbentry["departure_airport_code"]."',
//                 destination_airport_code='".$dbentry["destination_airport_code"]."',                     
//                 plane_id=".$dbentry["plane_id"].",                     
//                 departure_time='".$dbentry["departure_time"]."',                     
//                 departure_date='".$dbentry["departure_date"]."',                     
//                 passenger_seats=".$dbentry["passenger_seats"].",
//                 booked_seats=".$dbentry["booked_seats"].",
//                 price=".$dbentry["price"]."
//                 WHERE 
//                     flight_id=".$dbentry["flight_id"]
//         ) === TRUE){
//             echo "Flug mit der ID: ".$dbentry["plane_id"]." erfolgreich bearbeitet!";
//         }else{
//             echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//         }
//     }
// }else{
//     if($mysqli->query(
//         "DELETE FROM ".$dbentry["dbname"]." 
//             WHERE flight_id = ".$dbentry["flight_id"]
//     ) === TRUE){
//         echo "Flug ".$dbentry["departure_airport_code"]." nach ".$dbentry["destination_airport_code"]." erfolgreich gel&ouml;scht!";
//     }else{
//         echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//     }
// }


// function modifyplane($mysqli){
//     $dbentry["submittype"] = filter_input(INPUT_POST, "submittype", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["dbname"] = filter_input(INPUT_POST, "dbname", FILTER_SANITIZE_STRING);
//     $dbentry["plane_id"] = filter_input(INPUT_POST, "plane_id", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["manufacturer_id"] = filter_input(INPUT_POST, "manufacturer_id",FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["model"] = filter_input(INPUT_POST, "model", FILTER_SANITIZE_STRING);
//     $dbentry["travel_speed"] = filter_input(INPUT_POST, "travel_speed", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["travel_height"] = filter_input(INPUT_POST, "travel_height", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["travel_range"] = filter_input(INPUT_POST, "travel_range", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["passenger_seats_factory"] = filter_input(INPUT_POST, "passenger_seats_factory", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["picture_path"] = filter_input(INPUT_POST, "picture_path", FILTER_SANITIZE_STRING);
    
//     if($dbentry["submittype"] != -1){
//         if($dbentry["plane_id"] == -1){
//             if($mysqli->query(
//                 "INSERT INTO ".$dbentry["dbname"]." 
//                     VALUES (
//                         NULL, 
//                         ".$dbentry["manufacturer_id"].", 
//                         '".$dbentry["model"]."',
//                         ".$dbentry["travel_speed"].",                     
//                         ".$dbentry["travel_height"].",                     
//                         ".$dbentry["travel_range"].",                     
//                         ".$dbentry["passenger_seats_factory"].",                     
//                         '".$dbentry["picture_path"]."')"
//             ) === TRUE){
//                 echo "Flugzeug ".$dbentry["model"]." erfolgreich hinzugef&uuml;gt!";
//             }else{
//                 echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//             }
//         }else{
//             if($mysqli->query(
//                 "UPDATE ".$dbentry["dbname"]." 
//                     SET 
//                         manufacturer_id='".$dbentry["manufacturer_id"]."',
//                         model='".$dbentry["model"]."',
//                         travel_speed=".$dbentry["travel_speed"].",
//                         travel_height=".$dbentry["travel_height"].",
//                         travel_range=".$dbentry["travel_range"].",
//                         passenger_seats_factory=".$dbentry["passenger_seats_factory"].",
//                         picture_path='".$dbentry["picture_path"]."'
//                     WHERE 
//                         plane_id=".$dbentry["plane_id"]
//             ) === TRUE){
//                 echo "Flugzeug mit der ID: ".$dbentry["plane_id"]." erfolgreich bearbeitet!";
//             }else{
//                 echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//             }
//         }
//     }else{
//         if($mysqli->query(
//             "DELETE FROM ".$dbentry["dbname"]." 
//                 WHERE plane_id = ".$dbentry["plane_id"]
//         ) === TRUE){
//             echo "Flugzeug ".$dbentry["model"]." erfolgreich gel&ouml;scht!";
//         }else{
//             echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//         }
//     }
// }

// function modifyflight($mysqli){
//     $dbentry["submittype"] = filter_input(INPUT_POST, "submittype", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["dbname"] = filter_input(INPUT_POST, "dbname", FILTER_SANITIZE_STRING);
//     $dbentry["flight_id"] = filter_input(INPUT_POST, "flight_id", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["airline_id"] = filter_input(INPUT_POST, "airline_id",FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["departure_airport_code"] = filter_input(INPUT_POST, "departure_airport_code", FILTER_SANITIZE_STRING);
//     $dbentry["destination_airport_code"] = filter_input(INPUT_POST, "destination_airport_code", FILTER_SANITIZE_STRING);
//     $dbentry["plane_id"] = filter_input(INPUT_POST, "plane_id", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["departure_time"] = filter_input(INPUT_POST, "departure_time", FILTER_SANITIZE_STRING);
//     $dbentry["departure_date"] = filter_input(INPUT_POST, "departure_date", FILTER_SANITIZE_STRING);
//     $dbentry["passenger_seats"] = filter_input(INPUT_POST, "passenger_seats", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["booked_seats"] = filter_input(INPUT_POST, "booked_seats", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["price"] = filter_input(INPUT_POST, "price", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    
    
    

// }

// function modifyairport($mysqli){
//     $dbentry["submittype"] = filter_input(INPUT_POST, "submittype", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["dbname"] = filter_input(INPUT_POST, "dbname", FILTER_SANITIZE_STRING);
//     $dbentry["primid"] = filter_input(INPUT_POST, "primid", FILTER_SANITIZE_STRING);
//     $dbentry["icao_code"] = filter_input(INPUT_POST, "icao_code", FILTER_SANITIZE_STRING);
//     $dbentry["name"] = filter_input(INPUT_POST, "name",FILTER_SANITIZE_STRING);
//     $dbentry["city"] = filter_input(INPUT_POST, "city",FILTER_SANITIZE_STRING);
//     $dbentry["country"] = filter_input(INPUT_POST, "country", FILTER_SANITIZE_STRING);
    
//     if($dbentry["submittype"] != -1){
//         if($dbentry["primid"] == -1){
//             if($mysqli->query(
//                 "INSERT INTO ".$dbentry["dbname"]." 
//                     VALUES (
//                         '".$dbentry["icao_code"]."', 
//                         '".$dbentry["name"]."', 
//                         '".$dbentry["city"]."',
//                         '".$dbentry["country"]."'
//                         )"
//             ) === TRUE){
//                 echo "Flughafen ".$dbentry["name"]." erfolgreich hinzugef&uuml;gt!";
//             }else{
//                 echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//             }
//         }else{
//             if($mysqli->query(
//                 "UPDATE ".$dbentry["dbname"]." 
//                     SET
//                         name='".$dbentry["name"]."', 
//                         city='".$dbentry["city"]."',
//                         country='".$dbentry["country"]."'
//                     WHERE 
//                         icao_code='".$dbentry["icao_code"]."'"
//             ) === TRUE){
//                 echo "Flughafen mit der ID: ".$dbentry["icao_code"]." erfolgreich bearbeitet!";
//             }else{
//                 echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//             }
//         }
//     }else{
//         if($mysqli->query(
//             "DELETE FROM ".$dbentry["dbname"]." 
//                 WHERE icao_code = ".$dbentry["icao_code"]
//         ) === TRUE){
//             echo "Flughafen ".$dbentry["model"]." erfolgreich gel&ouml;scht!";
//         }else{
//             echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//         }
//     }
// }

// function modifyairline($mysqli){
//     $dbentry["submittype"] = filter_input(INPUT_POST, "submittype", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["dbname"] = filter_input(INPUT_POST, "dbname", FILTER_SANITIZE_STRING);
//     $dbentry["airline_id"] = filter_input(INPUT_POST, "airline_id", FILTER_SANITIZE_NUMBER_INT);
//     $dbentry["name"] = filter_input(INPUT_POST, "name",FILTER_SANITIZE_STRING);
//     $dbentry["picture_path"] = filter_input(INPUT_POST, "picture_path", FILTER_SANITIZE_STRING);
    
//     if($dbentry["submittype"] != -1){
//         if($dbentry["airline_id"] == -1){
//             if($mysqli->query(
//                 "INSERT INTO ".$dbentry["dbname"]." 
//                     VALUES (
//                         NULL, 
//                         '".$dbentry["name"]."', 
//                         '".$dbentry["picture_path"]."'
                        
//                         )"
//             ) === TRUE){
//                 echo "Airline ".$dbentry["name"]." erfolgreich hinzugef&uuml;gt!";
//             }else{
//                 echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//             }
//         }else{
//             if($mysqli->query(
//                 "UPDATE ".$dbentry["dbname"]." 
//                     SET 
//                         name='".$dbentry["name"]."',
//                         picture_path='".$dbentry["picture_path"]."'
//                     WHERE 
//                         airline_id=".$dbentry["airline_id"]
//             ) === TRUE){
//                 echo "Airline mit der ID: ".$dbentry["airline_id"]." erfolgreich bearbeitet!";
//             }else{
//                 echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//             }
//         }
//     }else{
//         if($mysqli->query(
//             "DELETE FROM ".$dbentry["dbname"]." 
//                 WHERE airline_id = ".$dbentry["airline_id"]
//         ) === TRUE){
//             echo "Airline ".$dbentry["name"]." erfolgreich gel&ouml;scht!";
//         }else{
//             echo "Fehler beim Schreiben auf die Datenbank: ".$mysqli->error;
//         }
//     }
// }


include("../footer.php");
?>
