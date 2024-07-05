<?php
header("Content-type:application/json");
header("Access-Control-Allow-Origin: *");

// set the $servername, $dbname, $username, and $password
include 'dbconfig.php';
include 'StatusCRUD.php';

// sleep for 1 second (enable it if you want to see
// how spin icon is working for slow AJAX connection)
sleep(1);

$data = null;

if (isset($_REQUEST["jsonStr"])) {
  $jsonStr = $_REQUEST["jsonStr"];
  $data = json_decode($jsonStr);
}
// debug json data
//var_dump($data);
//echo json_encode($data);
//exit();

// option to directly create $crudStatus instance 
// by using jsone_decode function
//$crudStatus = json_decode('{"type":"create", "data":null, "status":null, "error_msg": null}');

// crudStatus instance creation  using OOP approach
$crudStatus = new StatusCRUD('delete', null, null, null);

if ($data != null) {
  $crudStatus->data = $data;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    // ???
    // ???
    // ???

    $crudStatus->status = 'success';

  } catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
    $crudStatus->status = 'fail';
    $crudStatus->error_msg = $e->getMessage();
  }
}

echo json_encode($crudStatus);
?>