<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: board.html");
  exit;
}
$username_err="";
$password_err="";
require_once('config.php');
if(isset($_POST['sub'])){
$uname=htmlspecialchars($_POST['user']);
$pass=htmlspecialchars($_POST['pass']);
if(!empty($uname)&& !empty($pass)){
  $sql = "SELECT ssn, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            $param_username = $uname;
            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $ssn, $uname, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($pass, $hashed_password)){
                          session_start();
                         $_SESSION['loggedin']=true;
                         $_SESSION['username']=$uname;
                         $_SESSION['ssn']=$ssn;
                         $_SESSION['trans']="";
                         $_SESSION['wd']="";
                         $_SESSION['dep']="";
                         $_SESSION['tto']="";
                         $_SESSION['tfrom']="";
                        header("location:board.html");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
}
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
  body{
  background: #f6f5f7;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  font-family: 'Montserrat', sans-serif;
  margin-left: 38%;
  margin-top: 10%;
  margin-right:40%; 
  }
.button {
  background-color: #008CBA;
  border: 1px;
  border-color:#008CBA;
  border-radius:6px;
  color: white;
  padding: 8px 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  cursor: pointer;
  width: 75px;
}
 .imp{
  border:1px solid #C1B7AA;
  border-radius: 2.5px;
  width: 250px;
  height: 30px;
 }
  .button{
    background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
 }

</style>
</head>
<body>
  <div style="border: 1px solid black; border-radius: 5px; width: 250px; padding: 20px;">
  <form  action="" method="POST">
    <h2 style="text-align:center;"><b>Login to TRELLO</b></h2>
    <div>
      <input class="imp" type="text" placeholder="Username" id="user" name="user" required>
      <p style="color: red;" id="demo"><?php echo $username_err?></p>
    </div>
    <div>
      <input class="imp" type="password" placeholder="Password" id="passw" name="pass" required>
      <p style="color: red;" id="demo1"><?php echo $password_err?></p>
    </div>
  </form>
  <div>
        <button class="button" name="sub"><a href="board.html">Login</a></button>
    <br>
    <p></p>
    <center><a href="forgotpassword.html">Forgot your password?</a></center>
    <h5>Don't have an account? <a href="register.php">Sign up now</a></h5>
  </div>
</div>
  <script>
  document.getElementById("user").addEventListener("input",usrname);
  function usrname(){
  var x=document.getElementById("user").value;
  if(x.length==0){
  document.getElementById("user").style.borderColor="red";
  document.getElementById("demo").innerHTML = "The username cannot be empty";
  x=document.getElementById("ver");
  x.disabled=true;
  x.style.cursor="not-allowed"; 

   }
  else if(x.length>0 && x.length<5)
  {
   document.getElementById("user").style.borderColor="red";
   document.getElementById("demo").innerHTML = "The username should be a minimum of 5 characters";
   x=document.getElementById("ver");
   x.disabled=true;
   x.style.cursor="not-allowed"; 
  }
  else{
  document.getElementById("user").style.borderColor="green";
  document.getElementById("demo").innerHTML = "";
  x=document.getElementById("ver");
  var z=document.getElementById("passw").value;
  if(z.length>=1){
  x.disabled=false;
  x.style.cursor="pointer"; 
  }
}
}
  document.getElementById("passw").addEventListener("input",passwo);
  function passwo(){
    var x=document.getElementById("passw").value;
    if(x.length==0){
    document.getElementById("passw").style.borderColor="red";
    document.getElementById("demo1").innerHTML = "Password cannot be empty";
    x=document.getElementById("ver");
    x.disabled=true;
    x.style.cursor="not-allowed"; 
    }
    else{
  document.getElementById("passw").style.borderColor="green";
  document.getElementById("demo1").innerHTML = "";
  x=document.getElementById("ver");
  var z=document.getElementById("user").value;
  if(z.length>=5){
  x.disabled=false;
  x.style.cursor="pointer"; 
  }
  }
  }
</script>
</body>
</html>