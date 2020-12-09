<?php

$mysqli = connectMySQL();
$type = filter_input(INPUT_GET, "type", FILTER_SANITIZE_STRING);
$val = filter_input(INPUT_GET, "val", FILTER_SANITIZE_STRING);

$query = get_query($mysqli, $type, $val);

build_detail($mysqli, $type, $query);

?>