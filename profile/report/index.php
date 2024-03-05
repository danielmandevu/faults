<?php
session_start();
require_once '../../db.php';
if(isset($_SESSION['user_id']) AND isset($_SESSION['user_role'])){
    
if (isset($_POST['submit']) AND $_SESSION['user_role'] == '0' ){
  
    $category =$_POST['category'];
    $location= $_POST['location'];
    $description= $_POST['description'];
    $latitude =$_POST['latitude'];
    $longititude =$_POST['longitude'];
    $userId =    $_SESSION['user_id'];
   if($conn->query ("INSERT INTO faults (category, date_reported, fault_description, fault_location, latitude, longtitude, user_id) VALUES
   ('$category', now(), '$description', '$location', '$latitude', '$longititude', '$userId' )" ) or die($conn->error)){
       echo "<div class='bg-blue-300 p-4 w-full text-white'>Your report was logged succesfully it will be attended to as soon as possible, Thank you. You can track it here <a href='../track-faults' class='underline'>Fault Status</a></div>";
   }
   else{
     echo "<div class='bg-red-300 p-4 w-full text-white'>An error occured logging your fault try again</div>";
   }
 
 }

}
else{
    header('location: ../login/');
}
if(!(isset($_SESSION['user_id']) AND isset($_SESSION['user_role']))){
    header('location: ../login/');
}
?>



<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <!--<link href='css/tailwind.css' rel='stylesheet' type='text/css'>-->
        <link rel= "stylesheet" href="../../css/tailwind.css">
        <!-- <link rel= "stylesheet" href="css/bootstrap.css"> -->
        <link rel= "stylesheet" href="../../css/fontawesome/css/all.min.css">
        <script src='../../js/jquery/jquery.min.js'></script>
        
       <script>
            if (window.history.replaceState){
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
    </head>
    <body >
    <nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
        <img src='../../img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
        <div class=''>
            <h1 class="font-extrabold">The City Council</h1>
            <h1 class='text-green-500 font-bold'>Fault/Complaints Reporting</h1>
        </div>
        <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
            <a href='../../' class='mx-4'>Home</a>
            <a href='../../knowledge/' class='mx-4'>Knowledge Base</a>
            <a href='../../logout' class='mx-4'>Logout</a>
        </div>
    </nav>
        <div class='inline-flex w-screen'>
            <div class='bg-white shadow shadow-lg w-1/4 h-screen'>
                <a href="../"  class='w-full border-b  block font-bold p-4 px-8'>Profile</a>
                <a href=""  class='w-full border-b block text-red-500 font-bold p-4 px-8'>Report Fault</a>
                <a href="../track-faults/" class='w-full px-8 border-b block font-bold p-4'>Fault status</a>
            </div>
            <div class="w-3/4 p-8 m-4">
                <div class='w-3/4 m-auto border bg-white rounded rounded-lg shadow shadow-lg'>
                    <div class='bg-blue-400 w-full text-white p-4'>
                    <h1>Some of your complaints can be addressed in our knowledge area <a href='../../knowledge/' class='underline font-bold'>Browse</a></h1>
                    </div>
                    <div class='p-4'>
                    <form class="form" method ="POST" id="form">
                    <label class='block text-gray-400'>What kind of report would you like to make</label>
                    <select class="block w-full p-2 border my-2 rounded shadow bg-white" type="text" name="category" id="category" placeholder="Select Report Cartigory"  >
                        <option value ="" selected>Select Report Category</option>
                        <?php
                            if($res = mysqli_query($conn, "SELECT DISTINCT team_category FROM `response_teams`")){
                                while($row = mysqli_fetch_array($res)){
                                    echo "<option value ='$row[team_category]'>$row[team_category]</option>";
                                }
                            }
                        ?>
                    </select>
                    <label class='block text-gray-400'>Which part of Mzuzu is the report on</label>
                    <input class="block w-full p-4 border my-2 rounded shadow" type="location" name="location" id="location" placeholder=" Fault Location">
                    <label class='block text-gray-400'>Describe the issue in detail.</label>
                    <textarea cols ="30" rows ="5"  class="my-2 block rounded shadow w-full p-4 border" type="text" name="description" id ="description" placeholder="Briefly desrcibe fault"></textarea>
                    <input class="form-control hidden my-2 rounded shadow" type="hidden" name="latitude" id ="latitude" placeholder="Briefly desrcibe fault">
                    <input class="form-control hidden my-2 rounded shadow" type="hidden" name="longitude" id ="longitude" placeholder="Briefly desrcibe fault">
                    <button class="bg-blue-500 p-4 text-white rounded" type="submit" name= "submit" id="submit"> Submit Report</button>
                    </form>
                    </div>
                </div>
            </div>
            


<script>
        let latitude, longitude
        if(navigator.geolocation){
            console.log(0)
            navigator.geolocation.getCurrentPosition(function(location){
                let coords = location.coords
                console.log(coords)
                if(coords.latitude && coords.longitude){
                    console.log()
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





