<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--<link href='css/tailwind.css' rel='stylesheet' type='text/css'>-->
        <link rel= "stylesheet" href="css/tailwind.css">
        <link rel= "stylesheet" href="css/bootstrap.css">
        <link rel= "stylesheet" href="css/fontawesome-all.css">
        <link rel= "stylesheet" href="css/fontawesome-all.min.css">
        <link rel= "stylesheet" href="css/style.css">
        
    </head>
    <body >
        <nav class='w-screen p-6 inline-flex' style='background: #f2fbfe;'>
            <img src='img/Q_Ak8MlI_400x400.jpg' class='w-14 h-14 rounded-full'>
            <div class='my-3'>
                <h3 class="font-extrabold">Mzuzu City Council</h3>
                <h4 class='text-green-500 font-bold'>Fault/Complaints Reporting</h4>
            </div>

            <div class="relative left-1/4 my-4 font-bold">
                <a href='' class='mx-4'>Home</a>
                <a href='' class='mx-4'><i class ='fas fa-id-badge'> </i> Register</a>
                <a href='' class='mx-4'>Login</a>
            </div>
        
        </nav>

        <div class="sidebar">
            <ul>
                <li><a href="#"> <i class ="fas fa-qrcode"></i>  Dashboard</a> </li>
                <li><a href="#"> <i class ="fas fa-address-book"></i>  Profile</a> </li>
                <li><a href="#"> <i class ="fas fa-file"></i>  Report Fault</a></li>
                <li><a href="#"> <i class ="fas fa-chart-bar"></i>  Fault status</a> </li>
                <li><a href="#"> <i class ="fas fa-comments"></i>  FAQ's</a> </li>
                <li><a href="#"> <i class ="fas fa-sign-out-alt"></i>  Logout</a> </li>
                <li><a href="#"> <i class ="fas fa-qrcode"></i> </a> </li>
            </ul>

        </div>
<main>

<section class="register-photo">
    <div class="form-container">
        <div class="image-holder"></div>

        <form action="" method="POST">

            <h2 class="text-center"><strong>Fill in details of Fault/complaint</strong> below.</h2>
            <div class="form-group"><select class="form-control" type="Role" name="Role" id="Role"  >
              <option value ="" selected> Select Report Cartigory </option>
              <option value = "Dumped rubish" >Dumped rubish</option>
              <option value = "Broken_Street_Lights" > Broken Street Lights" </option>
              <option value = "Potholes" > Potholes </option>
              <option value = "Lan_demarcation" >Land demarcation</option>
              <option value = "Broken_Road_signs" >Broken Road signs</option>
              <option value = "No_Electricity" >No Electricity </option>
            </div>
            <div class="form-group"><input class="form-control" type="text" name="neighborhood" id="neighborhood" placeholder="Enter neighborhood complaint located"></div>
            
            <div class="form-group"> <textarea class="form-control" type="text" rows ="14" cols="50" name="description" id ="description" placeholder="Describe the area. ie. landmarks close to it"> </textarea>
          
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit" name= "submit"> Submit Report</button></div> 
            <a class="already" href="#">You already have an account? Login here.</a>
        </form>
    </div>
</section>
</main>


    </body>
        
</html>





