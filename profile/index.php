<?php
session_start();

require_once('../db.php');
if(isset($_SESSION['user_id']) AND isset($_SESSION['user_role'])){
  if ($_SESSION['user_role'] == '0' ){

  $userId=  $_SESSION['user_id'];
  $type =   $_SESSION['user_role'];


$result = $conn->query("SELECT * FROM user WHERE id = '$userId'") or die($conn->error);
  }
  else{
    echo '';
  }
}
else{
  echo 'hhh';
}
function pre_r($array){
  echo'<pre>';
  print_r($array);
  echo'</pre>';
}

?>
<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel= "stylesheet" href="../css/tailwind.css">
        <link href='../css/fontawesome/css/all.min.css' rel='stylesheet' type='text/css'>
        <link rel= "stylesheet" href="../css/style.css">


    </head>
    <body class='overflow-x-hidden'>
    <nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
        <img src='../img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
        <div class=''>
            <h1 class="font-extrabold">The City Council</h1>
            <h1 class='text-green-500 font-bold'>Fault/Complaints Reporting</h1>
        </div>
        <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
            <a href='../' class='mx-4'>Home</a>
            <a href='../knowledge/' class='mx-4'>Knowledge Base</a>
            <a href='../logout' class='mx-4'>Logout</a>
        </div>
    </nav>
        <div class='inline-flex w-screen'>
            <div class='bg-white shadow shadow-lg w-1/4 h-screen'>
                <a href="/"  class='w-full border-b text-red-500 block font-bold p-4 px-8'>Profile</a>
                <a href="report/"  class='w-full border-b block font-bold p-4 px-8'>Report Fault</a>
                <a href="track-faults/" class='w-full px-8 border-b block font-bold p-4'>Fault status</a>
            </div>
           <div class='bg-white shadow w-1/4 mx-auto h-2/4 p-2 my-4 rounded shadow-lg text-gray-400'>
                <div class='w-16 w-16 m-auto mx-4'>
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" viewBox="0 0 698 698"><defs><linearGradient id="b247946c-c62f-4d08-994a-4c3d64e1e98f-486" x1="349" y1="698" x2="349" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="gray" stop-opacity="0.25"/><stop offset="0.54" stop-color="gray" stop-opacity="0.12"/><stop offset="1" stop-color="gray" stop-opacity="0.1"/></linearGradient></defs><title>profile pic</title><g opacity="0.5"><circle cx="349" cy="349" r="349" fill="url(#b247946c-c62f-4d08-994a-4c3d64e1e98f-486)"/></g><circle cx="349.68" cy="346.77" r="341.64" fill="#f5f5f5"/><path d="M601,790.76a340,340,0,0,0,187.79-56.2c-12.59-68.8-60.5-72.72-60.5-72.72H464.09s-45.21,3.71-59.33,67A340.07,340.07,0,0,0,601,790.76Z" transform="translate(-251 -101)" fill="#6c63ff"/><circle cx="346.37" cy="339.57" r="164.9" fill="#333"/><path d="M293.15,476.92H398.81a0,0,0,0,1,0,0v84.53A52.83,52.83,0,0,1,346,614.28h0a52.83,52.83,0,0,1-52.83-52.83V476.92a0,0,0,0,1,0,0Z" opacity="0.1"/><path d="M296.5,473h99a3.35,3.35,0,0,1,3.35,3.35v81.18A52.83,52.83,0,0,1,346,610.37h0a52.83,52.83,0,0,1-52.83-52.83V476.35A3.35,3.35,0,0,1,296.5,473Z" fill="#fdb797"/><path d="M544.34,617.82a152.07,152.07,0,0,0,105.66.29v-13H544.34Z" transform="translate(-251 -101)" opacity="0.1"/><circle cx="346.37" cy="372.44" r="151.45" fill="#fdb797"/><path d="M489.49,335.68S553.32,465.24,733.37,390l-41.92-65.73-74.31-26.67Z" transform="translate(-251 -101)" opacity="0.1"/><path d="M489.49,333.78s63.83,129.56,243.88,54.3l-41.92-65.73-74.31-26.67Z" transform="translate(-251 -101)" fill="#333"/><path d="M488.93,325a87.49,87.49,0,0,1,21.69-35.27c29.79-29.45,78.63-35.66,103.68-69.24,6,9.32,1.36,23.65-9,27.65,24-.16,51.81-2.26,65.38-22a44.89,44.89,0,0,1-7.57,47.4c21.27,1,44,15.4,45.34,36.65.92,14.16-8,27.56-19.59,35.68s-25.71,11.85-39.56,14.9C608.86,369.7,462.54,407.07,488.93,325Z" transform="translate(-251 -101)" fill="#333"/><ellipse cx="194.86" cy="372.3" rx="14.09" ry="26.42" fill="#fdb797"/><ellipse cx="497.8" cy="372.3" rx="14.09" ry="26.42" fill="#fdb797"/></svg>
                </div>
                <?php while ($row= $result->fetch_assoc()): ?>
                    <h1 class='text-gray-500 font-bold mx-4'><?php echo $row['first_name'].' '. $row['last_name'];   ?></h1>
                    <h2 class='text-gray-400 mx-4'>Mzuzu Citizen</h2>
                    <div class='border-t border-b mx-4'>
                        <h3 class=''>Phone</3>
                        <h3 class='font-bold'><?php echo $row['phone_number'];   ?></h3>
                    </div>
                    <?php endwhile; ?>
          </div>
    </body>
        
</html>


