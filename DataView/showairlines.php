<?php
include("../header.php");


if(isCurrentAdmin()){
    include("admin/adminairlines.php");
}else{
    include("user/airlines.php");
}


include("../footer.php");
?>