<?php

session_start();


if(array_key_exists("id", $_COOKIE))
{
    $_SESSION['id']=$_COOKIE['id'];
}

if(array_key_exists("id", $_SESSION) AND $_SESSION['id'])
{
    echo "<p> logged in succesfully <a href='styledform-eco.php?logout=1'> Logout </a> </p>";
}
else
{
    
    header("Location:styledform-eco.php");
}

include ("file.php");
?>


    <div class="container-fluid form-group"> 
    <textarea id="textarea" > </textarea>
</div>



<?php 

include("footer.php");  


?>