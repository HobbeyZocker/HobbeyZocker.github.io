<?php
include("../header.php");


if(isCurrentAdmin()){
    include("admin/adminairports.php");
}else{
    include("user/airports.php");
}


include("../footer.php");
?>