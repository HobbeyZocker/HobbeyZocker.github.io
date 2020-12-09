<?php

include("../header.php");

$mysqli = connectMySQL();
$type = filter_input(INPUT_POST, "dbname", FILTER_SANITIZE_STRING);
$val = filter_input(INPUT_POST, "primid", FILTER_SANITIZE_STRING);
$submittype = filter_input(INPUT_POST, "submittype", FILTER_SANITIZE_NUMBER_INT);

switch ($type) {
    case "plane":
        $dbentry = load_plane($mysqli);
        
        if($dbentry["submittype"] == -1){
            showPlane($mysqli, $dbentry, TRUE, TRUE);
        }else{
            if(checkPlane($mysqli, $dbentry)){
                showPlane($mysqli, $dbentry, TRUE, FALSE);
            }else{
                showerror("Deine Eingabe weist leider Fehler auf!", 1, "editdetail.php?type=plane&val=".$dbentry["plane_id"]);
            }
        }
    break;
        
    case "flight":
        $dbentry = load_flight($mysqli);

        if($dbentry["submittype"] == -1){
            showFlight($dbentry, TRUE, TRUE);
        }else{
            if(checkFlight($mysqli, $dbentry)){
                showFlight($dbentry, TRUE, FALSE);
            }else{
                showerror("Deine Eingabe weist leider Fehler auf!", 1, "editdetail.php?type=plane&val=".$dbentry["plane_id"]);
            }
        }
        break;
    case "airport":
        $dbentry = load_airport();

        if($dbentry["submittype"] == -1){
            showAirport($dbentry, TRUE, TRUE);
        }else{
            if(checkAirport($mysqli, $dbentry)){
                showAirport($dbentry, TRUE, FALSE);
            }else{
                showerror("Deine Eingabe weist leider Fehler auf!", 1, "editdetail.php?type=plane&val=".$dbentry["icao_code"]);
            }
        }
        break;
    case "airline":
        $dbentry = load_airline();

        if($dbentry["submittype"] == -1){
            showAirline($dbentry, TRUE, TRUE);
        }else{
            if(checkAirline($mysqli, $dbentry)){
                showAirline($dbentry, TRUE, FALSE);
            }else{
                showerror("Deine Eingabe weist leider Fehler auf!", 1, "editdetail.php?type=airline&val=".$dbentry["airline_id"]);
            }
        }
        break;
    default:
        showerror("Datenbanktyp unbekannt!", 0, "flights.php");
}

include("../footer.php");
?>