<div class="page">
<h2 id="tableheading">Airlines</h2> <br>
<?php
    setTitle("Airline&uuml;bersicht");
    $mysqli = connectMySQL();

    $sortfields = array(
        "airline_id" => "Airline Nummer",
        "name" => "Name"
    );

    $selectedOrder = load_selected_sort("airline_id");
    
    buildairlinetable($mysqli, $selectedOrder, FALSE);
    build_sort($sortfields, $selectedOrder);
    
    echo "</div>";
?>