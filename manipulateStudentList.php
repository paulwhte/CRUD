<?php
/*

    Receive post data and modify database according to data
    type = what type of operation to perform with data
    id = primary key in database

*/
require("common.php");

$error = "";
$studentList = array();

//Type will always be set
$type = $_POST["type"];
//ID will be set if it's an edit or delete op
if(isset($_POST["id"]))
{
    $id = $_POST["id"];
}
//First and last will be set unless it's a reload op
if(isset($_POST["firstName"]))
{
    $firstName = $_POST["firstName"];
}
if(isset($_POST["lastName"]))
{
    $lastName = $_POST["lastName"];
}

try
{
    switch($type)
    {
        case "add":
            $sql = "INSERT INTO student (firstName, lastName) VALUES (:firstName, :lastName)";
            $insert = $con->prepare($sql);
            $insert->execute(array(':firstName'=>$firstName, ':lastName'=>$lastName));
            break;
        case "edit":
            $sql = "UPDATE student SET firstName=:firstName, lastName=:lastName WHERE id=:id";
            $update = $con->prepare($sql);
            $update->execute(array(':firstName'=>$firstName, ':lastName'=>$lastName, ':id'=>$id));
            break;
        case "delete":
            $sql = "UPDATE student SET deleted='1' WHERE id=:id";
            $update = $con->prepare($sql);
            $update->execute(array(':id'=>$id));
            break;
        case "reload":
            
            break;
        default:
            $error = $error . "<br>There was an error (case switch)";
            break;
    }
}
catch(PDOException $e)
{
    $error = $error . "<br>There was an error (PDO Exception): " . $e->getMessage();
}

try
{
    //Prepare data for returning
    $sql = "SELECT id, firstName, lastName FROM student WHERE deleted='0' ORDER BY dateAdded DESC";
    $data = $con->query($sql);
    $data->setFetchMode(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
    $error = $error . "<br>There was an error (PDO Exception): " . $e->getMessage();
}

//Make studentList friendly for encoding
foreach($data as $row)
{
    $student = array('firstName'=>$row['firstName'], 'lastName'=>$row['lastName'], 'id'=>$row['id']);
    array_push($studentList, $student);
}

$jsonObj = array();
$jsonObj['error'] = $error;
$jsonObj['studentList'] = $studentList;
//Encode in json object and echo
$encodedJson = json_encode($jsonObj);
echo $encodedJson;

?>