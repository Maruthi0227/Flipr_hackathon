<?php
$user = $ssn = $pass = $cpass = "";
$username_err= $ssn_err = $password_err = $cpassword_err = "";
//require('config.php');
if(isset($_POST['sub'])){
$uname=htmlspecialchars($_POST['user']);
$pass=htmlspecialchars($_POST['pass']);
$cpass=htmlspecialchars($_POST['cpass']);
$sql = "SELECT * FROM users WHERE username = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $uname);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                }
                else{
                  $sql="SELECT * FROM users where ssn=?";
                  if($stmt=mysqli_prepare($link,$sql)){
                    mysqli_stmt_bind_param($stmt,"s",$ssn);
                    if(mysqli_stmt_execute($stmt)){
                      mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt)==1){
                      $ssn_err="Account already created";
                    }
                    else{
                      if(!empty($uname)&& !empty($pass) && $pass==$cpass){
                        $sql = "INSERT INTO users (username, password,ssn) VALUES (?, ?,?)";
                        if($stmt = mysqli_prepare($link, $sql)){
                        mysqli_stmt_bind_param($stmt, "sss", $uname,$param_password ,$ssn);
                        $param_password = password_hash($pass, PASSWORD_DEFAULT);
                       if(mysqli_stmt_execute($stmt)){
                         header("location: login.php");
                          }
        
                      }
                    }
                    }
                    }
                  }
                }
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
  body{
    font: 14px sans-serif;
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
  <form style="border: 1px solid black; border-radius: 5px; width: 250px; padding: 20px;" action="" method="POST">
    <h2 style="text-align:center;">Sign Up</h2>
    <div>
      <input class="imp" type="text" placeholder="Enter TRELLO username" id="user" name="user" required>
      <p style="color: red;" id="demo"><?php echo $username_err?></p>
    </div>
    <div>
      <input class="imp" type="text" placeholder="Enter email id" id="user" name="user" required>
      <p style="color: red;" id="demo"><?php echo $username_err?></p>
    </div>
    <div>
      <input class="imp" type="password" placeholder="Password" id="passw" name="pass" required>
      <p style="color: red;" id="demo1"><?php echo $password_err?></p>
    </div>
    <div>
      <input class="imp" type="password" placeholder="Confirm Password" id="cpassw" name="cpass" required>
      <p style="color: red;" id="demo3"><?php echo $cpassword_err?></p>
    </div>
    <button id="ver" class="button" name="sub">Submit</button>
    <p>Already have an account? <a href="login.php">Login here</a></p>
  </form>
  <script>
  document.getElementById("ssn").addEventListener("input",ssn1);
  function ssn1(){
  var x=document.getElementById("ssn").value;
  if(x.length==0){
  document.getElementById("ssn").style.borderColor="red";
  document.getElementById("demo2").innerHTML = "Aadhaar cannot be empty";
  x=document.getElementById("ver");
  x.disabled=true;
  x.style.cursor="not-allowed"; 

   }
   else if(!x.match(/^[0-9]+$/)){
   document.getElementById("ssn").style.borderColor="red";
   document.getElementById("demo2").innerHTML = "Aadhaar only consists of numbers";
   x=document.getElementById("ver");
   x.disabled=true;
   x.style.cursor="not-allowed";
   }
  else if(x.length>0 && x.length<10)
  {
   document.getElementById("ssn").style.borderColor="red";
   document.getElementById("demo2").innerHTML = "Aadhaar should be a minimum of 10 characters";
   x=document.getElementById("ver");
   x.disabled=true;
   x.style.cursor="not-allowed"; 
  }
  else{
  document.getElementById("ssn").style.borderColor="green";
  document.getElementById("demo2").innerHTML = "";
  x=document.getElementById("ver");
  var y=document.getElementById("user").value;
  var z=document.getElementById("passw").value;
  var c=document.getElementById("cpassw").value;
  if(z.length>=1 && y.length>=5 && z==c){
  x.disabled=false;
  x.style.cursor="pointer"; 
  }
}
}
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
  var y=document.getElementById("ssn").value;
  var c=document.getElementById("cpassw").value;
  if(z.length>=1 && y.length>=10 && c==z){
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
  else if(x.match(/[a-z]/g) && x.match(/[A-Z]/g) && x.match(/[0-9]/g) && x.match(/[^a-zA-Z\d]/g) && x.length>=8){
    document.getElementById("passw").style.borderColor="green";
    document.getElementById("demo1").innerHTML = "";
    var b=document.getElementById("ver");
    var z=document.getElementById("user").value;
    var y=document.getElementById("ssn").value;
    var c=document.getElementById("cpassw").value;
    if(z.length>=5 && y.length>=10 && b==c){
    b.disabled=false;
    b.style.cursor="pointer"; 
    }
   }
    else{
    document.getElementById("passw").style.borderColor="red";
    document.getElementById("demo1").innerHTML = "weak password";
    x=document.getElementById("ver");
    x.disabled=true;
    x.style.cursor="not-allowed";
  }
}
  document.getElementById("cpassw").addEventListener("input",cpasswo);
  function cpasswo(){
    var x=document.getElementById("cpassw").value;
    var c=document.getElementById("passw").value;
    if(x!=c ){
    document.getElementById("cpassw").style.borderColor="red";
    document.getElementById("demo3").innerHTML = "Password's did not match";
    x=document.getElementById("ver");
    x.disabled=true;
    x.style.cursor="not-allowed"; 
    }
    else{
  document.getElementById("cpassw").style.borderColor="green";
  document.getElementById("demo3").innerHTML = "";
  var b=document.getElementById("ver");
  var z=document.getElementById("user").value;
  var y=document.getElementById("ssn").value;
  if(z.length>=5 && y.length>=10 && x==c){
  b.disabled=false;
  b.style.cursor="pointer"; 
  }
  }
  }
</script>
</body>
</html>