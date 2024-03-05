<!DOCTYPE html>
<html>
    <?php
        session_start();
        if(!(isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) || $_SESSION['user_role'] != 2){
            header('Location: ../login/');
        }
    ?>
    <head>
        <link href='../css/tailwind.css' rel='stylesheet' type='text/css'>
        <link href='../css/fontawesome/css/all.min.css' rel='stylesheet' type='text/css'>
    </head>
    <body style="font-family:Arial, Helvetica, sans-serif" class='overflow-x-hidden'>
    <nav class='w-screen p-4 inline-flex shadow' style='background: #f2fbfe'>
        <img src='../img\Q_Ak8MlI_400x400.jpg' class='w-12 h-12 mx-4 rounded'>
        <div class=''>
            <h1 class="font-extrabold">The City Council</h1>
            <h1 class='text-green-500 font-bold'>Fault/Complaints Management</h1>
        </div>
        <div class="relative my-4 font-bold mx-64" style='color:#68696a'>
            <a href='../' class='mx-'>Home</a>
            <a href='../logout/' class='mx-4'>Logout</a>
        </div>
    </nav>
        <div class='inline-flex w-screen'>
        <div class='bg-white shadow shadow-lg w-1/4 h-screen'>
                <a href=""  class='w-full border-b text-red-500 block font-bold p-4 px-8'>Citizen Reports</a>
                <a href="teams/"  class='w-full border-b block font-bold p-4 px-8'>Manage Teams</a>
                <a href="reports/"  class='w-full border-b block font-bold p-4 px-8'>Reports</a>
                <a href="knowledge-base"  class='w-full border-b block font-bold p-4 px-8'>Manage Knowledge Base</a>
                <a href="../leaflet/"  class='w-full border-b block font-bold p-4 px-8'>Reports Map View</a>
            </div>
            <div class='w-3/4 p-8 m-4'>
                <table class='border rounded m-auto w-full shadow shadow-lg rounded rounded-lg'>
                    <tr class='font-bold border-b  font-bold'>
                        <td class=' p-4 text-center'>Fault Location</td>
                        <td class='p-4 text-center'>Fault Category</td>
                        <td class=' p-4 text-center'>Reported On</td>
                        <td class='p-4 text-center'>Point Person Contact</td>
                        <td class=' p-4 text-center'>Status</td>
                    </tr>
    
                        <?php
                            require_once '../db.php';
                            $limit = 6;
                            $page = '';
                            if(isset($_GET['page'])){
                                $page = $_GET['page'];
                            }else{
                                $page = 1;
                            }
                            $start_from = ($page - 1) * $limit;
                            $res = mysqli_query($conn, "SELECT `fault_id`, `category`, `date_reported`, `fault_description`, `fault_location`, `fault_status`, `user_id`, (SELECT B.phone_number FROM user AS B WHERE B.ID = A.user_id) AS phone_number FROM faults AS A ORDER BY fault_status DESC LIMIT $start_from, $limit;");
                            if($res){
                                $i = 1;
                                while($row = mysqli_fetch_array($res)){
                                    $i++;
                                    echo "<tr class=''>
                                    <td class='p-4 text-center'>$row[fault_location]</td>
                                    <td class=' p-4 text-center'>$row[category]</td>
                                    <td class=' p-4 text-center'>$row[date_reported]</td>
                                    <td class='p-4 text-center'>$row[phone_number]</td>
                                    <td class='p-4 text-center'>$row[fault_status]</td></tr>";
                                }
                                echo "</table>";
                                $page_query = "SELECT * FROM faults";
                                $page_result = mysqli_query($conn, $page_query);
                                $total_records = mysqli_num_rows($page_result);
                                $total_pages = ceil($total_records/$limit);
                                for($i=1;$i<=$total_pages;$i++){
                                    echo "<ul class='inline-flex'>
                                    <li class='mx-2 border rounded text-gray-400 px-4 py-2'><a href = '?page=".$i."'>".$i."</a></li>
                                    </ul>";
                                }
                            }
                        ?>
                </table>
        </div>
    </body>
</html>