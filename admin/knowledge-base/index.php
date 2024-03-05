<!DOCTYPE html>
<html>
    <head>
        <link href='../../css/tailwind.css' rel='stylesheet' type='text/css'>
        <link href='../../css/fontawesome/css/all.min.css' rel='stylesheet' type='text/css'>
    </head>
    <?php
        require_once '../../db.php';
        if(isset($_GET['delete'])){
            $id = $_GET['delete'];
            mysqli_query($conn, "DELETE FROM `knowledge_articles` WHERE ID = '$id'");
        }
    ?>
    <body style="font-family:Arial, Helvetica, sans-serif" class='overflow-hidden'>
        <nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
            <img src='../../img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
            <div class=''> 
                <h1 class="font-extrabold">The City Council</h1>
                <h1 class='text-green-500 font-bold'>Fault/Complaints Management</h1>
            </div>
            <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
                <a href='../../' class='mx-'>Home</a>
                <a href='editor/' class='mx-'>Add Article</a>
                <a href='../../logout/' class='mx-4'>Logout</a>
            </div>
        </nav>
        <div class='inline-flex w-screen'>
            <div class='bg-white shadow shadow-lg w-1/4 h-screen'>
                <a href="../"  class='w-full border-b block font-bold p-4 px-8'>Citizen Reports</a>
                <a href="../teams"  class='w-full border-b block font-bold p-4 px-8'>Manage Teams</a>
                <a href="../reports"  class='w-full border-b block font-bold p-4 px-8'>Reports</a>
                <a href=""  class='w-full border-b block font-bold p-4 px-8  text-red-500'>Manage Knowledge Base</a>
                <a href="../../leaflet/"  class='w-full border-b block font-bold p-4 px-8'>Reports Map View</a>
            </div>
            <div class='w-3/4 p-8 m-4'>
            <div class='border rounded m-auto w-full shadow shadow-lg bg-white p-4 rounded rounded-lg'>
                <table class='rounded m-auto w-full'>
                    <tr class='font-boldbg-gray-300 text-green-500 border-b'>
                        <td class='p-4 underline'>Article Title</td>
                        <td class='p-4 underline'>Date Reported</td>
                        <td class='p-4 underline'>Action</td>
                    </tr>
                    <?php
                        $res = mysqli_query($conn, "SELECT * FROM `knowledge_articles`");
                        if($res){
                            while($row = mysqli_fetch_array($res)){
                                echo "<tr class='border-b'>
                                <td class='p-4'>$row[articleTitle]</td>
                                <td class='p-4 '>$row[publishedOn]</td>
                                <td class='p-4 text-center'><a href='index.php?delete=$row[ID]'><i class='fa fa-trash text-red-500 font-bold font-center'></i></a></td>
                            </tr>";
                            }
                        }
                    ?>
                </table>
                    </div>
            </div>
