<?php  session_start();
if(isset($_SESSION['access'])){
  header('location:loginform.php');
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg,#f7971e,#5b86e5);
            font-family: Arial,  sans-serif;
        }
        #form{
            text-align: center;
            padding: 40px;
            width: 350px;
            background: rgba(255, 255, 255,0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
           box-shadow: 0px 8px 25px rgba(0,0,0,0.2);
            animation: fadeIn 1s ease-in-out;
            border-radius: 20px;  
 
        }
        #form h2{
            margin-bottom: 25px;
            color: #333;
            font-size: 24px;
        }
        
        .field{
           
            margin-bottom: 20px;
            text-align: left;

        }
       
        
       input{
            width: 100%;
            height: 35px;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-bottom: 15px;
            box-shadow: 2px 2px 6px rgba(0,0,0,0.3),-2px -2px 6px rgba(255,255,255,0.7);
            background: #fff;
            transition: 0.3s;
        }
        input:focus{
            outline: none;
            border-color: #2575fc;
            box-shadow: 0px 0px 8px rgba(37,117,252,0.4) ;
        }
        #loginbtn{
            margin-top: 10px;
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            background: linear-gradient(to right,#ff512f,#dd2476);
            transition: transform 0.2 ease, box-shadow 0.2s easa;
        }
        #loginbtn:hover{
            transform: translateY(-2px);
            box-shadow: 0px 6px 12px rgba(0,0,0,0.2);
        }
         a:hover{
            
            text-decoration: underline;
        }
        a{
            text-decoration: none;
            color: #000;
        }
        @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}
        
    </style>
    
</head>
<body>
    <form  method="POST" action="loginform.php">
    <div id="form"><h2>LOG IN FORM</h2>
    <div class="field"> <input id="name" type="text" placeholder=" gmail or phone" pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required  name="em"> </div>
     <div class="field"><input id="name"type="password"placeholder=" password"  name="ps"> </div>
     <a href="#"  > forget password</a> 
    <div id="bt"><button id="loginbtn"  type="submit" name="but">log in</button></div>
    <a href="signin.php"> SIGN IN</a>
    </form>
</div>
<?php

 if(isset($_POST['but']))
    {
       
        $email=$_POST['em'];
        $psw=$_POST['ps'];



        $servername = "localhost";
    $username   = "u913997673_prasanna";
    $password   = "Ko%a/2klkcooj]@o";
    $dbname     = "u913997673_prasanna";


        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

       
$sql="SELECT * FROM signin where email='$email' and password='$psw'";

    $query_run=mysqli_query($conn,$sql);

    if(mysqli_num_rows($query_run)==1){
        $_SESSION['access']=$email;

           echo "<script>window.open('display.php','_self')</script>";

    }else{


        echo "<script>alert('invalid user name')</script>";
    }


        $conn->close();

        }
?>


</body>
</html>