<?php
include("../config/db.php");

$data = json_decode(file_get_contents("php://input"));

$name = $data->name;
$email = $data->email;
$password = md5($data->password);

$sql = "INSERT INTO users (name, email, password)
VALUES ('$name', '$email', '$password')";

echo mysqli_query($conn, $sql)
    ? json_encode(["message"=>"Signup success"])
    : json_encode(["message"=>"Signup failed"]);
?>