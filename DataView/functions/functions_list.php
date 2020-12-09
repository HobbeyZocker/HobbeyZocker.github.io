<?php

function load_selected_filters($filterfields){
    if(filter_input(INPUT_POST, "filterbtn", FILTER_SANITIZE_STRING) == "reset"){
        foreach($filterfields as $key => $val){
            $selectedFilters[$key] = null;
        }
    }else{
        foreach($filterfields as $key => $val){
            $selectedFilters[$key] = filter_input(INPUT_POST, "select$key", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        }
    }

    return $selectedFilters;
}

function load_selected_sort($standard_sort){
    if(filter_input(INPUT_POST, "filterbtn", FILTER_SANITIZE_STRING) == "reset"){
        $selectedOrder = $standard_sort;
    }else{
        $selectedOrder = filter_input(INPUT_POST, "sortselect", FILTER_SANITIZE_STRING) ?? $standard_sort;
    }

    return $selectedOrder;
}

function load_selected_ranges($rangefields){
    if(filter_input(INPUT_POST, "filterbtn", FILTER_SANITIZE_STRING) == "reset"){
        foreach($rangefields as $key => $val){
            $selectedRanges[$key]["min"] = null;
            $selectedRanges[$key]["max"] = null;
        }
    }else{
        foreach($rangefields as $key => $val){
            $selectedRanges[$key]["min"] = filter_input(INPUT_POST, $key."_min", FILTER_SANITIZE_STRING);
            $selectedRanges[$key]["max"] = filter_input(INPUT_POST, $key."_max", FILTER_SANITIZE_STRING);
        }
    }

    return $selectedRanges ?? false;
}

function print_filter_start(){
    echo "
        <details>
            <summary>
                <strong>Filter anzeigen:</strong>
            </summary>
            <form method='POST'>";
}

function print_sort($sortfields, $selectedOrder){
    echo "
        <h2>sortieren nach:</h2>
        <select id=\"sortselect\" name=\"sortselect\">";

    foreach($sortfields as $key=>$data){
        if($selectedOrder == "$key ASC"){
            echo "<option selected value='$key ASC'>$data - aufsteigend</option>";
        }else{
            echo "<option value='$key ASC'>$data - aufsteigend</option>";
        }
        if($selectedOrder == "$key DESC"){
            echo "<option selected value='$key DESC'>$data - absteigend</option>";
        }else{
            echo "<option value='$key DESC'>$data - absteigend</option>";
        }
    }

    echo "</select>";
}

function build_sort($sortfields, $selectedOrder){
    print_filter_start();
    print_sort($sortfields, $selectedOrder);
    print_filter_end();
}

function print_filter_end(){
    echo "
        <br>
        <button class=\"ui\" id=\"secon\" type='submit' name='filterbtn' value='reset'>Filter zur&uuml;cksetzen</button>
        <button class=\"ui\" id=\"prim\" type='submit' name='filterbtn' value='continue'>Filter &uuml;bernehmen</button>
    </form>
    </details>";
}

function create_filter_options($mysqli, $filterfields, $dbname){
    foreach($filterfields as $key=>$data){
        $filterarray[$key] = get_all_possible_values($mysqli, $key, $dbname);
    }

    return $filterarray;
}

function create_range_options($mysqli, $rangefields, $dbname){
    foreach($rangefields as $key=>$data){
        $rangearray[$key] = get_min_max($mysqli, $key, $dbname);
        if($key == "departure_time"){
            foreach($rangearray[$key] as $name=>$val){
                $rangearray[$key][$name] = substr($val, 0, 5);
            }
        }
    }

    return $rangearray;
}

function print_filter($filterfields, $filterarray, $selectedFilters){
    echo "<h2>Filteroptionen:</h2>\n";
        foreach($filterfields as $key => $value){
            echo "
                <div class=\"filter\">
                    <strong>$value</strong>\n
                </div>";
        }

    echo "<br>\n";
        
    foreach($filterarray as $key=>$values){
        echo "<select class=\"filter\" id=\"select$key\" name='select$key"."[]' multiple='multiple'>\n";
        foreach($values as $value){
            if(isset($selectedFilters[$key]) && in_array($value, $selectedFilters[$key])){
                echo "<option selected value='$value'>$value</option>\n";
            }else{
                echo "<option value='$value'>$value</option>\n";
            }
        }
        echo "</select>\n";
    }   
}

function print_manufacturer_filter($mysqli, $filterfields, $filterarray, $selectedFilters){
    echo "<h2>Filteroptionen:</h2>\n";
        foreach($filterfields as $key => $value){
            echo "<strong>$value</strong>\n";
        }

    echo "<br>\n";
        
    foreach($filterarray as $key=>$values){
        echo "<select id=\"select$key\" name='select$key"."[]' multiple='multiple'>\n";
        foreach($values as $value){
            if(isset($selectedFilters[$key]) && in_array($value, $selectedFilters[$key])){
                echo "<option selected value='$value'>".get_name_for_manufacturer($mysqli, $value)."</option>\n";
            }else{
                echo "<option value='$value'>".get_name_for_manufacturer($mysqli,$value)."</option>\n";
            }
        }
        echo "</select>\n";
    }   
}

function print_range($fieldname, $inputtype, $options, $rangefields, $rangearray, $selectedRanges){
    echo    "<strong>".$rangefields["$fieldname"].": </strong> 
            von <input type='$inputtype' $options name='".$fieldname."_min' value='".($selectedRanges["$fieldname"]["min"] ?? $rangearray["$fieldname"]["min"])."' min='".$rangearray["$fieldname"]["min"]."' max='".$rangearray["$fieldname"]["max"]."' required>
            bis <input type='$inputtype' $options name='".$fieldname."_max' value='".($selectedRanges["$fieldname"]["max"] ?? $rangearray["$fieldname"]["max"])."' min='".$rangearray["$fieldname"]["min"]."' max='".$rangearray["$fieldname"]["max"]."' required>
            <br>
            ";
}

function build_sort_and_filter_and_flight_ranges($mysqli, $filterfields, $selectedFilters, $rangefields, $selectedRanges, $sortfields, $selectedOrder){
    $filterarray = create_filter_options($mysqli, $filterfields, "flightview");
    $rangearray = create_range_options($mysqli, $rangefields, "flightview");
    
    print_filter_start();
    print_filter($filterfields, $filterarray, $selectedFilters);
    echo "   
    <br> <div class=\"filter_inputs\">";
        print_range("departure_date", "date", "", $rangefields, $rangearray, $selectedRanges); 
        print_range("departure_time", "time", "", $rangefields, $rangearray, $selectedRanges);
        print_range("price", "number", " stepsize='0.01' ", $rangefields, $rangearray, $selectedRanges);
    echo "</div>";
    print_sort($sortfields, $selectedOrder);
    
    print_filter_end();
}


function build_sort_and_filter($mysqli, $dbname, $filterfields, $selectedFilters, $sortfields, $selectedOrder){
    $filterarray = create_filter_options($mysqli, $filterfields, $dbname);

    print_filter_start();
    if($dbname == "plane"){
        print_manufacturer_filter($mysqli, $filterfields, $filterarray, $selectedFilters);
    }else{
        print_filter($filterfields, $filterarray, $selectedFilters);
    }
    
    print_sort($sortfields, $selectedOrder);
    
    print_filter_end();
}

function get_header_for_db($dbname){
    switch($dbname){
        case "airline":
            return array(
                "Airlinenummer",
                "Name",
                "Bild",
                ""
                );        
        case "plane":
            return array(
                "Flugzeug ID",
                "Hersteller",
                "Modell",
                "Reisegeschwindigkeit",
                "Reiseflugh&ouml;he",
                "Reichweite",
                "Maximale Sitzplatzanzahl",
                ""
            );

        case "airport":
            return array(
                "ICAO Code",
                "Flughafenname",
                "Stadt",
                "Land",
                ""
            );

        case "flightview":
            return array(
                "Flugnummer",
                "Airline",
                "Startort",
                "Zielort",
                "Flugzeug",
                "Startdatum",
                "Startzeit",
                "Gebuchte Pl&auml;tze / Verfügbare Pl&auml;tze",
                "Ticketpreis",
                ""
            );
    }
}

function build_airline_body($query, $isAdmin){
    echo        "<tbody>";
    while($body = $query->fetch_array(MYSQLI_ASSOC)){
        echo 
            "<tr>
                <td>".$body["airline_id"]."</td>
                <td>".$body["name"]."</td>
                <td><img height='25px' src='".get_picture_path("airlines").$body["picture_path"]."' alt='Airline Bild'></td>";
            print_view_or_edit_button($isAdmin, "airline", $body["airline_id"], "Airline");
            echo "</tr>";
    }
    echo "  </tbody></table></div>";
}

function print_view_or_edit_button($isAdmin, $dbname, $prim_id, $name){
    if($dbname != "flight"){
        echo "
            <td>
                <button onclick=\"location.href='showdetail.php?type=$dbname&val=$prim_id'\">
                    $name ".($isAdmin === TRUE ? "bearbeiten" : "anzeigen")."
                </button>";
    }else{
        if($isAdmin === FALSE){
            echo "
                <td>
                    <button onclick=\"location.href='../transaction/buyticket.php?flight=$prim_id'\">
                        Ticket kaufen!
                    </button>";
        }else{
            echo "
                <td>
                    <button onclick=\"location.href='showdetail.php?type=$dbname&val=$prim_id'\">
                        Flug bearbeiten
                    </button>";
        }
    }
}

function print_add_button($isAdmin, $dbname, $name){
    if($isAdmin === TRUE){
        echo "
            <button class=\"ui edit_button\" onclick=\"location.href='/HypertextPreprocessor/DataView/showdetail.php?type=$dbname&val=-1'\">$name hinzuf&uuml;gen</button>
            ";
    }
}

function buildairlinetable($mysqli, $orderby, $isAdmin){
    $query = $mysqli->query("
        SELECT * FROM airline ORDER BY $orderby
    ");
    
    build_table_header(get_header_for_db("airline"));
    build_airline_body($query, $isAdmin);

    print_add_button($isAdmin, "airline", "Airline");

    $query->free();
}

function build_table_header($header){
    echo "
    <div class=\"scroll\">
        <table class=\"ui contenttable\">
            <thead>
                <tr>";
            foreach($header as $val){
                echo "<th>$val</th>\n";
            }
        echo "  </tr>
            </thead>";
}

function get_query_filter_string($filterarray){
    $querystring_filter = "";
    foreach($filterarray as $key => $values){
        if($values){
            $querystring_filter = $querystring_filter." $key in ('";
            foreach($values as $val){
                $querystring_filter = $querystring_filter.$val."', '";
            }
            $querystring_filter = substr($querystring_filter, 0, strlen($querystring_filter)-3);
            $querystring_filter = $querystring_filter.") AND ";
        }
    }
    if($querystring_filter == ""){
        $querystring_filter = "1";
    }else{
        $querystring_filter = substr($querystring_filter, 0, strlen($querystring_filter)-4);
    }

    return $querystring_filter;
}

function get_query_range_string($rangearray){
    $querystring_range = "";
    foreach($rangearray as $key => $values){
        if($values["min"] && $key == "price"){
            $querystring_range = $querystring_range." $key >= ".$values["min"]." AND $key"." <= ".$values["max"]." AND";
        }elseif($values["min"]){
            $querystring_range = $querystring_range." $key >= '".$values["min"]."' AND $key"." <= '".$values["max"]."' AND";
        }
    }
    
    if($querystring_range == ""){
        $querystring_range = "1";
    }else{
        $querystring_range = substr($querystring_range, 0, strlen($querystring_range)-4);
    }

    return $querystring_range;
}

function build_flight_body($query, $isAdmin){
    echo "<tbody>";
    while($body = $query->fetch_array(MYSQLI_ASSOC)){
        echo 
            "<tr>
                <td><a href=\"showdetail.php?type=flight&val=".$body["flight_id"]."\">".$body["flight_id"]."</a></td>
                <td><a href=\"showdetail.php?type=airline&val=".$body["airline_id"]."\">".$body["airline_name"]."</a></td>
                <td><a href=\"showdetail.php?type=airport&val=".$body["departure_airport_code"]."\">".$body["dep_city"]." (".$body["dep_name"].")"."</a></td>
                <td><a href=\"showdetail.php?type=airport&val=".$body["destination_airport_code"]."\">".$body["dest_city"]." (".$body["dest_name"].")"."</a></td>
                <td><a href=\"showdetail.php?type=plane&val=".$body["plane_id"]."\">".$body["pm_name"]." ".$body["model"]."</a></td>
                <td>".convertDate($body["departure_date"])."</td>
                <td>".$body["departure_time"]."</td>
                <td>".$body["booked_seats"]." / ".$body["passenger_seats"]."</td>
                <td>".$body["price"]."</td>";

                print_view_or_edit_button($isAdmin, "flight", $body["flight_id"], "Flug");
           echo " </tr>";
    }
    echo "</tbody></table></div>";

    print_add_button($isAdmin, "flight", "Flug");
    print_add_button($isAdmin, "airline", "Airline");
    print_add_button($isAdmin, "airport", "Flughafen");
    print_add_button($isAdmin, "plane", "Flugzeug");
}

function buildflighttable($mysqli, $filterarray, $rangearray, $orderby, $isAdmin){
    $query = $mysqli->query("
        SELECT * FROM flightview WHERE ".get_query_filter_string($filterarray)." AND ".get_query_range_string($rangearray)." ORDER BY ".($orderby ?? "flight_id")
    );

    build_table_header(get_header_for_db("flightview"));

    build_flight_body($query, $isAdmin);

    $query->free();
}

function build_airport_body($query, $isAdmin){
    echo "<tbody>";
    while($body = $query->fetch_array(MYSQLI_ASSOC)){
        echo 
            "<tr>
                    <td>".$body["icao_code"]."</td>
                    <td>".$body["name"]."</td>
                    <td>".$body["city"]."</td>
                    <td>".$body["country"]."</td>";
                    print_view_or_edit_button($isAdmin, "airport", $body["icao_code"], "Flughafen");
            echo "</tr>";
    }
    echo "</tbody></table></div>";
    print_add_button($isAdmin, "airport", "Flughafen");
}

function buildairporttable($mysqli, $filterarray, $orderby, $isAdmin){
    $query = $mysqli->query("
        SELECT * FROM airport WHERE ".get_query_filter_string($filterarray)." ORDER BY ".($orderby ?? "icao_code")
    );
    
    build_table_header(get_header_for_db("airport"));

    build_airport_body($query, $isAdmin);

    $query->free();
}

function build_plane_body($mysqli, $query, $isAdmin){
    echo "<tbody>";
    while($body = $query->fetch_array(MYSQLI_ASSOC)){
        echo 
            "<tr>
                <td>".$body["plane_id"]."</td>
                <td>".get_name_for_manufacturer($mysqli, $body["manufacturer_id"])."</td>
                <td>".$body["model"]."</td>
                <td>".$body["travel_speed"]." km/h</td>
                <td>".$body["travel_height"]." m</td>
                <td>".$body["travel_range"]." km</td>
                <td>".$body["passenger_seats_factory"]."</td>";

                print_view_or_edit_button($isAdmin, "plane", $body["plane_id"], "Flugzeug");

            echo "</tr>";
    }
    echo '</tbody></table></div>';

    print_add_button($isAdmin, "plane", "Flugzeug");
}

function buildplanetable($mysqli, $filterarray, $orderby, $isAdmin){
    $query = $mysqli->query("
            SELECT * FROM plane WHERE ".get_query_filter_string($filterarray)." ORDER BY ".($orderby ?? "plane_id")
    );
    
    build_table_header(get_header_for_db("plane"));
    build_plane_body($mysqli, $query, $isAdmin);
    $query->free();
}

?>