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
$crudStatus = new StatusCRUD('create', null, null, null);

if ($data != null) {
  $crudStatus->data = $data;

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO marks (name, session, cw, fe) VALUES (:name, :session, :cw, :fe)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':session', $session);
    $stmt->bindParam(':cw', $cw);
    $stmt->bindParam(':fe', $fe);

    foreach ($data as $item) {
      $name = $item->name;
      $session = $item->session;
      $cw = $item->cw;
      $fe = $item->fe;
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
