<div class="page">
<h2 id="tableheading">Fl&uuml;ge</h2> <br>
<?php
    setTitle("Flug&uuml;bersicht");
    $mysqli = connectMySQL();
    $filterfields = array(
        "airline_name" => "Airline",
        "dep_city" => "Startort",
        "dep_country" => "Startland",
        "dest_city" => "Zielort",
        "dest_country" => "Zielland",
        "pm_name" => "Flugzeughersteller",
        "model" => "Flugzeugmodell"
    );

    $sortfields = array(
        "flight_id" => "Flugnummer",
        "departure_date" => "Abflugtag",
        "departure_time" => "Abflugzeit",
        "price" => "Preis"
    );

    $rangefields = array(
        "departure_date" => "Abflugtag",
        "departure_time" => "Abflugzeit",
        "price" => "Preis"
    );

    $selectedFilters = load_selected_filters($filterfields);
    $selectedOrder = load_selected_sort("flight_id");
    $selectedRanges = load_selected_ranges($rangefields);

    buildflighttable($mysqli, $selectedFilters, $selectedRanges, $selectedOrder, FALSE);
    build_sort_and_filter_and_flight_ranges($mysqli, $filterfields, $selectedFilters, $rangefields, $selectedRanges, $sortfields, $selectedOrder);

    echo "</div>";
?>