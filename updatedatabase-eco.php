<?php

session_start();
if(array_key_exists("content", $_POST))
{
    
    include("connection.php");
//    $query = "INSERT INTO `user` (`diary`) VALUES ('".mysqli_real_escape_string($link, $_POST['content'])."')";
    
    
$query= "UPDATE `user` SET diary='".mysqli_real_escape_string($link, $_POST['content'])."' WHERE id= '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1 ";
    
    if(mysqli_query($link, $query))
    {
        
        echo $_POST['content'];
        
    }
    else
    {
        echo "failed to connect";
    }
    
  
    
}


?>
