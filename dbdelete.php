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

// crudStatus instance creation using OOP approach
$crudStatus = new StatusCRUD('delete', null, null, null);

if ($data != null) {
  $crudStatus->data = $data;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("DELETE FROM marks WHERE id=:id");
    $stmt->bindParam(':id', $id);

    foreach ($data as $item) {
      $id = $item->id;
      $stmt->execute();
    }

    $crudStatus->status = 'success';

  } catch (PDOException $e) {
    $crudStatus->status = 'fail';
    $crudStatus->error_msg = $e->getMessage();
  }
}

echo json_encode($crudStatus);
?>
