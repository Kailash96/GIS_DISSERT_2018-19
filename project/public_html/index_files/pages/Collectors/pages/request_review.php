<?php
  include("../../../../../config/db_connect.php");
  
  $act = $_POST['act'];
  $id = $_POST['id'];
  $id = explode("_", $id)[0];

  if ($act == "true") {
      $accept_query = "UPDATE tbl_collection_request SET Approval = 1 WHERE RID = $id";
      mysqli_query($conn, $accept_query);
  } else {
      $reject_query = "DELETE FROM tbl_collection_request WHERE RID = $id";
      mysqli_query($conn, $reject_query);
  }

  echo json_encode(1);
?>