<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Form</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg,#f7971e,#9face6);
            font-family: Arial, sans-serif;
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
        .field{ margin-bottom: 20px; text-align: left; }
        input{
            width: 100%;
            height: 35px;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            margin-bottom: 15px;
            box-shadow: 3px 3px 6px rgba(0,0,0,0.3),-3px -3px 6px rgba(255,255,255,0.7);
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
            background: linear-gradient(to right,#6a11cb,#2575fc);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        #loginbtn:hover{
            transform: translateY(-2px);
            box-shadow: 0px 6px 12px rgba(0,0,0,0.2);
        }
        a{ text-decoration: none; color: #000; }
        a:hover{ text-decoration: underline; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <form id="form" action="" method="POST">
        <h2>SIGN IN FORM</h2>
        <div class="field">
            <input id="name" type="text" placeholder="Name" name="na" required>
        </div>
        <div class="field">
            <input id="email" type="text" placeholder="Gmail or phone"  
                   name="gm" pattern="[a-zA-Z0-9._%+-]+@gmail\.com" required>
        </div>
        <div class="field">
            <input id="i2" type="password" placeholder="Password" name="ps" required>
        </div>
        <a href="#">Forget password?</a> 
        <div id="bt">
            <button type="submit" id="loginbtn" name="but">Sign In</button>
        </div>
    </form>

    <?php

    if(isset($_POST['but']))
        {
            $name=$_POST['na'];
            $email=$_POST['gm'];
            $psw=$_POST['ps'];
            
            
        
            
            
    $servername = "localhost";
    $username   = "u913997673_prasanna";
    $password   = "Ko%a/2klkcooj]@o";
    $dbname     = "u913997673_prasanna";


            $conn = new mysqli($servername,$username,$password,$dbname);

            if($conn->connect_error){
                die("connection failed:".$conn->connect_error);
            }

            $sql="INSERT INTO signin (name,email,password) values('".$name."','".$email."','".$psw."')";


            if ($conn->query($sql)=== TRUE){
                echo "<script>window.open('loginform.php','_self')</script>";
            } else{
                echo "Error:".$sql."<br>".$conn->error;
            }

            $conn->close();
           

        }
    ?>

</body>
</html>
