<?php
/*

    Receive post data and modify database according to data
    type = what type of operation to perform with data
    id = primary key in database

*/

require("common.php");

$error = "";
$studentList = array();

if( $_POST["type"] && $_POST["firstName"] && $_POST["lastName"] )
{
    $type = $_POST["type"];
    $id = $_POST["id"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    //All data is populated by something, validate that id is a number
    if(is_numeric($id))
    {
        switch($type){
            case "add":
                //Insert as a new student
                //$sql = "UPDATE playsession SET endTime=?, postScore=?, postBits=?, postAnswers=? WHERE sessionID=?";
                $sql = "INSERT INTO student (firstName, lastName) VALUES firstName=:firstName, lastName=:lastName";
                $insert = $con->prepare($sql);
                $insert->execute(array($firstName, $lastName));
                
                //$update = $con->prepare($sql);
                //$update->execute(array($endTime, $percentage, $postBits, $postAnswers, $sessionID));
                break;
            case "edit":
                //Update the student at the id
                break;
            case "delete":
                //Mark the entry at the id as deleted
                break;
            default:
                $error = "There was an error";
        }
    }
    else
    {
        $error = "There was an error";
    }
}
else if ($_POST["type"] == "reload")
{
    //Fetch the student data again and populate the array
}

//Prepare data for returning
$jsonObj = array();
$jsonObj['error'] = $error;
$jsonObj['studentList'] = $studentList;
//Encode in json object and echo
$encodedJson = json_encode($jsonObj);
echo $encodedJson;

?>