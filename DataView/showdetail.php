<?php
include("../header.php");

if(isCurrentAdmin()){
    include("admin/editdetail.php");
}else{
    include("user/detailview.php");
}


include("../footer.php");