<div class="page">
<h2 id="tableheading">Flugzeuge</h2> <br>
<?php
    setTitle("Flugzeug&uuml;bersicht");
    $mysqli = connectMySQL();
    $filterfields = array(
        "manufacturer_id" => "Hersteller"
    );

    $sortfields = array(
        "plane_id" => "Flugnummer",
        "manufacturer_id" => "Hersteller",
        "travel_speed" => "Reisegeschwindigkeit",
        "travel_height" => "Reiseflugh&ouml;he"
    );;

    $selectedFilters = load_selected_filters($filterfields);
    $selectedOrder = load_selected_sort("plane_id");

    buildplanetable($mysqli, $selectedFilters, $selectedOrder, FALSE);
    build_sort_and_filter($mysqli, "plane", $filterfields, $selectedFilters, $sortfields, $selectedOrder);
    
    echo "</div>";
?>