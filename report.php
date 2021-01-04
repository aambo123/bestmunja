<?php
header('Content-type: application/x-www-form-urlencoded');
$servername = "192.168.0.2";
$username = "user";
$password = "123";
$db = "1worldsms";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sender = $_REQUEST['sid'];
$mobile = $_REQUEST['mno'];
$messageid = $_REQUEST['msgid'];
$date = $_REQUEST['date'];
$status = $_REQUEST['status'];

if($status == 'DELIVRD'){
    $st = 1;

    $sql = "UPDATE message_send_detail SET success = '$st' WHERE sender = '$sender' AND phone_number = '$mobile'";
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    mysqli_close($conn);
}

//$sql = "INSERT INTO delivery_report (sid, mno, msgid, dates, status) VALUES ('$sender', '$mobile', '$messageid', '$date', '$status')";
//if (mysqli_query($conn, $sql)) {
//    echo "New record created successfully";
//} else {
//    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//}
//mysqli_close($conn);
?>
