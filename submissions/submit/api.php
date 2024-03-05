<?php
    header('response-type: text/json');
    require_once '../../db.php';
    session_start();
    $result = array();
    if(isset($_SESSION['user_id']) && isset($_SESSION['user_role'])){
        $user_id = $_SESSION['user_id'];
        $user_role = $_SESSION['user_role'];
        $query = "SELECT * FROM `faults` WHERE fault_status = 'pending'";
        if($user_role == 1){
            $query = "SELECT A.* FROM faults AS A WHERE A.category = (SELECT team_category FROM response_teams WHERE ID = (SELECT teamid FROM teammembers WHERE memberid = '$user_id')) AND A.fault_status = 'pending'";
        }
        if($res = mysqli_query($conn, $query)){
            while($row = mysqli_fetch_array($res)){
                array_push($result, $row);
            }
        }
    }
    print_r(json_encode($result));
?>