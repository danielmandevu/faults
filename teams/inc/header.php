<?php
    session_start();
    include_once 'db.php';

    //logout
    if(!(isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) || $_SESSION['user_role'] != 1){
        header('Location: ../login/');
    }
    $cat_query = mysqli_query($conn, "SELECT teamid, (SELECT team_category FROM response_teams WHERE ID = teamid) AS category  FROM `teammembers` WHERE  memberid = '$_SESSION[user_id]'");
    $category = '';
    while($r = mysqli_fetch_array($cat_query)){
        $category = $r['category'];
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>complaint management system</title>
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <!-- <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <script type="text/javascript"  src="js/jquery/jquery-3.5.1.js"></script> 
        <script src="sweetalert2.min.js"></script>
        <script src="sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="sweetalert2.css">
        <script type="text/javascript"  src="js/bootstrap.min.js"></script>
        <link href='css/fontawesome/css/all.min.css' rel='stylesheet' type='text/css'> -->
        <link href='../css/tailwind.css' rel='stylesheet' type='text/css'>
        <link href='../css/style.css' rel='stylesheet' type='text/css'>
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
    
    