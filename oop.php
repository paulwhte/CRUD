<?php

require("common.php");

try
{
    $sql = "SELECT * FROM student WHERE deleted='0'";
    $data = $con->query($sql);
    
    foreach($con->query($sql) as $row)
    {
        print "$row[firstName]";
    }
}
catch(PDOException $e)
{
    die("Error: " . $e->getMessage());
}
    
//var_dump($data);