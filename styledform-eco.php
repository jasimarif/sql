<?php
  session_start();

  $error= ""; 
  if(array_key_exists("logout", $_GET ))
  {
      unset($_SESSION);
      setcookie("id", "", time() - 60*60 );
      $_COOKIE["id"]="";
      
  }

else if((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id']))
{
    header("Location: loggedinpage.php");
}
 if (array_key_exists('email', $_POST) OR array_key_exists('password', $_POST)) {
 
     
     include ("connection-ecoweb.php");
     
     
     if ($_POST['email'] == '') {
            
        $error.= "<p>Email address is required.</p>";
        
    } 
      
    else if ($_POST['password'] == '') {
        
        $error.= "<p>Password is required.</p>";
        
    } 
    
     if ($error != "")
     {
         $error= "There were error(s) is the form <br>" .$error ;
     }
     else
     {
      
  if($_POST['signup']== '1' ) 
      {    
      
  $query= "SELECT id FROM `username` WHERE  email= '".mysqli_real_escape_string($link, $_POST['email'])."'"; 
  
  $result=mysqli_query($link, $query);
      
      
  if (mysqli_num_rows($result) > 0 )
     {
         
        $error.= "Already exists";
        }
        else
        {
            
       
            $query = "INSERT INTO `username` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link,  $_POST['password'])."')";
           
        
           
            if (!mysqli_query($link, $query))
         {   
            $error.="<p>There was a problem signing up- please try again</p>";
             
            
            }
            else
            {
                           
               $query= "UPDATE `username` SET password= '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id='".mysqli_insert_id($link)."' LIMIT 1 ";
               
               if(mysqli_query($link, $query))
               {
                $_SESSION['id']= mysqli_insert_id($link);
                
                if($_POST['checkbox']== '1')
                {
                    setcookie("id", mysqli_insert_id($link), time() + 3600*365);
                }
                
                header("Location:loggedinpage.php");
                }
                   else
                {
                    echo "can't login";
                }
               }
                
            }
          
        } 
      
            
     else
                {
                    $query= "SELECT * from `username` WHERE email= '".mysqli_real_escape_string($link, $_POST['email'])."'";
                    $result= mysqli_query($link, $query);
         
                    $row= mysqli_fetch_array($result);
                    if(isset( $row))
                    {
                        $hashedpassword= md5(md5($row['id']).$_POST['password']);
                        if($hashedpassword== $row['password'])
                        {
                            $_SESSION['id']= row['id'];
                            
                            if($_POST['checkbox']== '1')
                        {
                    setcookie("id", row['id'], time() + 3600*365);
                
                            }
                    header("Location:loggedinpage.php");
                        }
                        else
                        {
                           $error = "Email or password is incorrect"; 
                        }
                    }
                    else {
                        $error = "Email or password is incorrect";
                    }
                } 
      
        }}     

?>

<?php include("file.php") ?>

      <div class="container" id="homepagecontainer">
    
      <div id="error"> <?php  {echo $error;}  ?> </div>
      
       <h1>Secret Diary</h1>
     
    <form method="post" id="signupform"> 
  <div class="form-group">    
<input type="email" class="form-control" name="email" placeholder="Your Email">
        </div>
     <div class="form-group">    
<input type="password"  class="form-control" name="password" placeholder="Your Password">
        </div>
         <div class="form-group form-check" >
<input id="checkbox1" type="checkbox" class="form-check-input" name="checkbox" >
             <label class="form-check-label" id="checkbox">  <strong>  Stay logged in </strong></label>
        </div>
      <div class="form-group">   
<input type="hidden" name="signup" value="1">
      
<button type="submit" class="btn btn-success" name="submit"> Sign up </button>  
       </div>
        <p> <a class="toggleclass"> Login </a> </p>
</form>
   
   <form method="post" id="loginform">
<div class="form-group"> 
     
<input type="email" class="form-control" name="email" placeholder="Your Email">
        </div>
     <div class="form-group">    
<input type="password"  class="form-control" name="password" placeholder="Your Password">
        </div>
         <div class="form-group form-check" >
<input id="checkbox1" type="checkbox" class="form-check-input" name="checkbox" >
             <label class="form-check-label" id="checkbox">  <strong>  Stay logged in </strong></label>
        </div>
        <div class="form-group">
<input type="hidden" name="signup" value="0"> 
            
<button type="submit" class="btn btn-success" name="login"> Login     </button>     
       </div> 
            <p> <a class="toggleclass"> Signup </a> </p>   
    </form>
          
          
      </div>
  
      
<?php      include("footer.php") ?>
 


