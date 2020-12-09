<?php

include("../header.php");

$num = filter_input(INPUT_POST, "ticketcount", FILTER_SANITIZE_NUMBER_INT);
$flight = filter_input(INPUT_POST, "flight_id", FILTER_SANITIZE_NUMBER_INT);

$_SESSION["session_cart"][$flight] = $num;

echo "Zum Warenkorb hinzugefügt.";

include("../footer.php");
