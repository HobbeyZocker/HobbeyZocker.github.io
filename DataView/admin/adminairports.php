<div class="page">
<h2 id="tableheading">Flugh&auml;fen</h2> <br>
<?php
    setTitle("Flughafen&uuml;bersicht");
    $mysqli = connectMySQL();
    $filterfields = array(
        "country" => "Land"
    );

    $sortfields = array(
        "icao_code" => "ICAO Code",
        "name" => "Flughafenname",
        "city" => "Stadt",
        "country" => "Land"
    );

    $selectedFilters = load_selected_filters($filterfields);
    $selectedOrder = load_selected_sort("icao_code");

    buildairporttable($mysqli, $selectedFilters, $selectedOrder, TRUE);
    build_sort_and_filter($mysqli, "airport", $filterfields, $selectedFilters, $sortfields, $selectedOrder);
    
    echo "</div>";
?>