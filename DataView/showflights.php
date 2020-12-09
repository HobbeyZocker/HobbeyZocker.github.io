<?php
include("../header.php");

if(isCurrentAdmin()){
    include("admin/adminflights.php");
}else{
    include("user/flights.php");
}


include("../footer.php");