<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link href='css/tailwind.css' rel='stylesheet' type='text/css'>
        <!-- <link rel= "stylesheet" href="css/bootstrap.css"> -->
        <link rel= "stylesheet" href="css/fontawesome/css/fontawesome.min.css">
        <link rel= "stylesheet" href="css/style.css"> 
    </head>
    <body class='overflow-x-hidden'>
    <nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
        <img src='img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
        <div class=''>
            <h1 class="font-extrabold">The City Council</h1>
            <h1 class='text-green-500 font-bold'>Fault/Complaints Reporting</h1>
        </div>
        <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
            <a href='' class='mx-4 text-red-400'>Home</a>
            <a href='knowledge/' class='mx-4'>knowledge Base</a>
            <?php
                session_start();
                if(!(isset($_SESSION['user_id']) && isset($_SESSION['user_role']))){
                    echo "<a href='register/' class='mx-4' ><i class ='fa fa user'> </i> Register</a>
                    <a href='login/' class='mx-4'>Login</a>";
                }
                else{
                    echo "<a href='profile/' class='mx-4' ><i class ='fa fa user'> </i> Profile</a>
                    <a href='logout/' class='mx-4'>Logout</a>";
                }
            ?>
        </div>
    </nav>
    <div class="container" >
            <section>
                <div class= "left">
                    <div class="content">
                        <h3>Welcome to Mzuzu City Faults/Complaints System.<h3>
                            <h4>Reporting Faults in Mzuzu just got easy!!</h4>
                            <div class="para">
                            <p>Report any type of fault or complaint to the council on any device.</P>
                           <a href="register/"> <button > Register to get started</button></a>
                            </div>
                        </div>
                </div>

                <div class="right">
                    <img src="img/final-landing-image.png" class="img">
                </div>


            </section>

            
        </div>


       
    </body>
        
</html>




