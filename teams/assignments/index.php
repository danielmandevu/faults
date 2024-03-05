<?php 

include_once '../../db.php';
include_once('../inc/header.php');
if(isset($_GET['id'])){
    $id = $_GET['id'];   
    $query1="SELECT fault_status FROM faults WHERE fault_id = '$id'";
            $result1=mysqli_query($conn, $query1);
            

            if(mysqli_num_rows($result1)>0){
                $row = mysqli_fetch_assoc($result1);
                
                $status = "cleared";
                
                        $query="UPDATE faults SET fault_status='$status', date_cleared=SYSDATE() WHERE fault_id = '$id'";
                        $result=mysqli_query($conn,$query) or die("activation failed" .mysqli_error($conn));
                        echo "<div class='bg-blue-300 p-4 w-full text-white'>Error Cleared Successfully</div>";
            }
        }
    $query="SELECT * FROM faults WHERE fault_status = 'pending' AND category = '$category'";
    $result=mysqli_query($conn, $query);
    $_SESSION['faults'] = mysqli_num_rows($result);
?>
<style>
    .panel{
        padding: 20px;
    }

</style>
<!DOCTYPE html>
<html>
    <head>
        <title>Team Assignments</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link href='../../css/tailwind.css' rel='stylesheet' type='text/css'>
        <link href='../../css/style.css' rel='stylesheet' type='text/css'>
        <script>
            if (window.history.replaceState){
                window.history.replaceState({}, document.title, "/" + "mzgrp3/teams/assignments/index.php");
            }
        </script>
        <style>
             /* *{
                padding: 0px;
                margin: 0px;
            }
            body{
                background-color: rgb(219, 214, 214);
            }
            .wrapper {
                width: 100%;
                align-items: stretch;
                padding-top: 100px;
            }
            .header{
                width: 100%;
                background-color: white;
                padding: 10px;
                border-bottom: 2px solid black;
                position: fixed;
            }
            #content{
                margin: 25px;
                position: static;
            }
            .nav{
                font-size: 18px;
                padding: 5px;
            }
            i{
                padding: 5px;
            }
            .active1{
                color: orange;
            } */
        </style>
    </head>
    <body>
<nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
        <img src='../../img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
        <div class=''>
            <h1 class="font-extrabold">The City Council</h1>
            <h1 class='text-green-500 font-bold'>Fault/Complaints Management</h1>
        </div>
        <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
            <a href='../../' class='mx-4'>Home</a>
            <a href='../../logout' class='mx-4'>Logout</a>
        </div>
    </nav>
    <div class='inline-flex w-screen'>
            <div class='bg-white shadow shadow-lg w-1/4 h-screen'>
                <a href=""  class='w-full border-b block font-bold p-4 px-8'>Profile</a>
                <a href="assignments/"  class='text-red-500 w-full border-b block font-bold p-4 px-8'>Assignments <span class='italic text-red-300'><?php echo $_SESSION['faults']?></span></a>
                <a href="../../leaflet/"  class='w-full border-b block font-bold p-4 px-8'>Map View</span></a>
            </div>
            <div class="w-3/4 p-8 m-4">

    <div class="w-full bg-white border shadow shadow-lg rounded rounded-lg m-auto">

    <table class='rounded w-full'>

    <tr class='font-bold'>
                        <th class='p-4 text-center'>Date Reported</th>                                              
                        <th class='p-4 text-center'>Fault Description</th>
                        <th class='p-4 text-center'>Fault Category</th>
                        <th class='p-4 text-center'>Fault Location</th>
                        <th class='p-4 text-center'>Point Contact</th>
                        <th class='p-4 text-center'></th>
                    </tr>

                    <?php
                        $limit = 10;
                        $page = '';
                        if(isset($_GET['page'])){
                            $page = $_GET['page'];
                        }else{
                            $page = 1;
                        }
                        $start_from = ($page - 1) * $limit;
                        $query="SELECT *, (SELECT phone_number FROM user WHERE ID = user_id) AS phoneNumber FROM faults WHERE fault_status = 'pending' AND category = '$category' LIMIT $start_from, $limit";
                        $result=mysqli_query($conn, $query);
                        echo mysqli_error($conn);
                        if (mysqli_num_rows($result) > 0){
                            $i = 0;
                            while($row = mysqli_fetch_assoc($result)) {
                                $i++;
                    ?>

                    <tr>
                        <td class=' p-4 text-center'><?php echo $row['date_reported']; ?></td>
                        <td class=' p-4 text-center'><?php echo $row['fault_description']; ?></td>
                        <td class=' p-4 text-center'><?php echo $row['category']; ?></td>
                        <td class=' p-4 text-center'><?php echo $row['fault_location']; ?></td>
                        <td class='p-4 text-center'><?php echo $row['phoneNumber']; ?></td>
                        <td class='p-4 text-center'>

                            <?php
                                if($row['fault_status']=='pending'){
                                    echo "<a class='p-2 rounded bg-blue-400 text-white font-bold' onclick='return confirm('Are You Sure to Clear?')' href=?id=$row[fault_id]>Clear</a>";
                                }
                            ?>
                        </td>
                        
                    </tr>

                    <?php } }else{
                        echo "No assignments";
                    } ?>

                </table>
                <?php
                    $page_query = "SELECT * FROM faults WHERE fault_status = 'pending'";
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
</div>