<?php
include_once('./../db/db.php');
include_once('./../service/user.php');

header('Content-Type: application/json');

$user = new User();
switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':
    if (isset($_GET["id"])) {
      echo $user->getOneUser($_GET["id"]);
      return;
    }
    echo $user->getAllUsers();
    return;
  case 'POST':
    $body = json_decode(file_get_contents("php://input"));
    $school_name = $body->school_name;
    $gender = $body->gender;
    $name = $body->name;
    $age = $body->age;
    $errors = array();
    $errors["errors"] = array();
    empty($school_name) ? array_push($errors["errors"], array("message" => "School name is required")) : null;
    empty($gender) ? array_push($errors["errors"], array("message" => "gender is required")) : null;
    empty($name) ? array_push($errors["errors"], array("message" => "name is required")) : null;
    empty($age) ? array_push($errors["errors"], array("message" => "age is required")) : null;
    if (count($errors["errors"]) !== 0) {
      echo json_encode($errors);
    } else {
      echo $user->createUser($name, $school_name, $gender, $age);
    }
    return;
  case 'PUT':
    $body = json_decode(file_get_contents("php://input"));
    $user->school_name = $body->school_name;
    $user->name = $body->name;
    $user->gender = $body->gender;
    $user->age = $body->age;
    echo $user->updateOne($_GET["id"]);
    return;
  case 'DELETE':
    echo $user->delete($_GET["id"]);
    return;
}
