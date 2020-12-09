<?php
include("../header.php");

if(isCurrentAdmin()){
    include("admin/adminplanes.php");
}else{
    include("user/planes.php");
}


include("../footer.php");
?>