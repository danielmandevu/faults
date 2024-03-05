<?php

if (isset($_POST['submit'])){
  
   $category =$_POST['category'];
   $location= $_POST['location'];
   $description= $_POST['description'];
   $latitude =$_POST['latitude'];
   $longititude =$_POST['longitude'];


  $mysqli->query ("INSERT INTO faults (category, date_modified, fault_description, fault_location, latitude, longtitude) VALUES
  ('$category', now(), '$description', '$location', '$latitude', '$longititude' )" ); //or die($mysqli->error);



if(mysqli_query($mysqli, 'new')){

    TextNode("success", "Record has been Added Successfully...!");
  }else{
      echo "Error";
  };
  
  
  



}else{
    TextNode("error", "Provide Data in the Textbox");

};






function TextNode($classname, $msg){
    $element ="<h6 class='$classname'>$msg</h6>";

     echo $element;
 };

?>



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

        <style><?php include "css/style.css"?></style>

       <!-- <link rel= "stylesheet" href="css/style.css">-->
       
        <script src='js/jquery/jquery.min.js'></script>

        <script>
            if (window.history.replaceState){
                window.history.replaceState(null, null, window.location.href);
            }
        </script>

    </head>
    <body >

    <main>
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

        <form action="op.php" method="POST">

            <h2 class="text-center"><strong>Fill in details of Fault/complaint</strong> below.</h2>

            <div class="form-group"> <select class="form-control form-group" type="text" name="category" id="category"  >

              <option value ="" selected> Select Report Cartigory </option>

              <option value = "Dumped Rubish">Dumped rubish</option>
              <option value = "Broken Street Lights"> Broken Street Lights </option>
              <option value = "Potholes"> Potholes </option>
              <option value = "Land demarcation" >Land demarcation</option>
              <option value = "Broken Road signs">Broken Road signs</option>
              <option value = "No Electricity">No Electricity </option>
              
            </div>

            <div class="form-group"><input class="form-control" type="location" name="location" id="location" placeholder=" Fault Location"></div>
            
            <div class="form-group"> <textarea id ="" cols ="30" rows ="5"  class="form-control" type="text" name="description" id ="description" placeholder="Briefly desrcibe fault"></textarea> </div>
            <input class="form-control hidden" type="hidden" name="latitude" id ="latitude" placeholder="Briefly desrcibe fault">
            <input class="form-control hidden" type="hidden" name="longitude" id ="longitude" placeholder="Briefly desrcibe fault">
          
            <div class="form-group"><button class="btn btn-primary btn-block submit-btn" type="submit" name= "submit"> Submit Report</button></div> 
        </form>
    </div>
</section>
</main>

    <script>
        let latitude, longitude
        if(navigator.geolocation){
            console.log(0)
            navigator.geolocation.getCurrentPosition(function(location){
                let coords = location.coords
                console.log(coords)
                if(coords.latitude && coords.longitude){
                    console.log(1)
                    $('#latitude').val(coords.latitude)
                    $('#longitude').val(coords.longitude)
                }
            }, function(err){
                console.log(err);
            })
        }
    </script>



    </main>
    </body>
        
</html>





