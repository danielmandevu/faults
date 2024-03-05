
<?php
 session_start();
 require_once '../../db.php';
if(isset($_SESSION['user_id']) AND isset($_SESSION['user_role'])){
    $mysqli = $conn;
    $userId=  $_SESSION['user_id'];
    $type = $_SESSION['user_role'];
    $limit = 6;
                            $page = '';
                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }else{
                                $page = 1;
                            }
                            $start_from = ($page - 1) * $limit;
$result = $mysqli->query("SELECT * FROM faults WHERE user_id = '$userId' LIMIT $start_from, $limit") or die($mysqli->error);
//pre_r($result);
//pre_r($result->fetch_assoc());
//pre_r($result->fetch_assoc());

function pre_r($array){
    echo'<pre>';
    print_r($array);
    echo'</pre>';
}

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
        <link rel= "stylesheet" href="../../css/tailwind.css">
        <link rel= "stylesheet" href="../../css/fontawesome-all.css">
        <link rel= "stylesheet" href="../../css/fontawesome-all.min.css">
        <link rel= "stylesheet" href="../../css/style.css">
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
                <a href="../report"  class='w-full border-b block  font-bold p-4 px-8'>Report Fault</a>
                <a href="" class='text-red-500 w-full px-8 border-b block font-bold p-4'>Fault status</a>
            </div>
            <div class="w-3/4 p-8 m-4">
<div class="w-full bg-white border shadow shadow-lg rounded rounded-lg">
<table class='border rounded m-auto'>
    <tr class='font-bold border'>
        <td class='p-4 text-center'>Fault Category</td>
        <td class='p-4 text-center'>Date</td>
        <td class='p-4 text-center'>Fault Description</td>
        <td class='p-4 text-center'>Fault Location</td>
        <td class='p-4 text-center'>Fault Status</td>
    </tr>
      <?php
        while ($row= $result->fetch_assoc()): ?>
             <tbody id="tbody">
             <tr class='border'>
             <td class='p-4 text-center'><?php echo $row['category'];?></td>
             <td class='p-4 text-center'><?php echo $row['date_reported']; ?></td>
             <td class='p-4 text-center'> <?php echo $row['fault_description'];?></td>
             <td class='p-4 text-center'> <?php echo $row['fault_location'];?></td>
             <td class='p-4 text-center'> <?php echo $row['fault_status']  ;?></td>
           </tr>
           <?php endwhile; ?>
         </tbody>

    </table>
    <?php
    $page_query = "SELECT * FROM faults WHERE user_id = '$userId'";
    $page_result = mysqli_query($conn, $page_query);
                                $total_records = mysqli_num_rows($page_result);
                                $total_pages = ceil($total_records/$limit);
                                for($i=1;$i<=$total_pages;$i++){
                                    echo "<ul class='inline-flex'>
                                    <li class='mx-2 border rounded text-gray-400 px-4 py-2'><a href = '?page=".$i."'>".$i."</a></li>
                                    </ul>";
                                }
                                ?>
  </div>
        </div>


        </div>
       
    </body>
        
</html>





