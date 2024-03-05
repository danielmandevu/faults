<!DOCTYPE html>
<html>
    <head>
        <link href='../../css/tailwind.css' rel='stylesheet' type='text/css'>
        <link href='../../css/fontawesome/css/all.min.css' rel='stylesheet' type='text/css'>
    </head>
    <body style="font-family:Arial, Helvetica, sans-serif" class='overflow-hidden w-screen'>
    <nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
        <img src='../../img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
        <div class=''>
            <h1 class="font-extrabold">The City Council</h1>
            <h1 class='text-green-500 font-bold'>Fault/Complaints Reporting</h1>
        </div>
        <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
            <a href='../../' class='mx-4'>Home</a>
            <a href='../../knowledge/' class=' mx-4'>Knowledge Base</a>
                <?php
                    session_start();
                    $prompt = 'Login';
                    $link = '../../login';
                    if(isset($_SESSION['user_id']) && isset($_SESSION['user_role'])){
                        $prompt = 'Logout';
                        $link = '../../logout/';
                    }
                    echo "<a href='$link' class='mx-4'>$prompt</a>";
                ?>
        </div>
    </nav>
    <div class='w-3/4 p-4 border rounded shadow bg-white shadow-lg m-auto my-4'>
        <?php
            require_once '../../db.php';
            if(isset($_GET['id'])){
                $id = $_GET['id'];
                if($res = mysqli_query($conn, "SELECT * FROM `knowledge_articles` WHERE ID = '$id'")){
                    $title;
                    $body;
                    $reads = 0;
                    while($row = mysqli_fetch_array($res)){
                        $title = $row['articleTitle'];
                        $body = $row['articleBody'];
                        $reads = $row['readsNum'];
                    }
                    $reads++;
                    mysqli_query($conn, "UPDATE `knowledge_articles` SET `readsNum`=$reads WHERE ID = '$id'");
                }
                echo "<title>$title</title>";
                echo "<h1 class='font-extrabold my-8'>$title</h1>$body";
             }
             else{
                 //redirect
                 //header('location: ../');
             }
        ?>
        </div>
    </body>