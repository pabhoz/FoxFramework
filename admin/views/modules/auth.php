<?php
$userId = Session::get("aid");//Replace for an User BL method
if(empty($userId)){
  header("Location:".URL."Login");
}
?>
