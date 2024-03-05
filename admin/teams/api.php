<?php
    require_once '../../db.php';
    if(isset($_POST['memberfName']) && isset($_POST['memberlName']) && isset($_POST['phoneNumber']) && isset($_POST['memberPassword']) && isset($_POST['teamId'])){
        if(mysqli_query($conn, "INSERT INTO `user`(`first_name`, `last_name`, `phone_number`, `password`, `type`) VALUES ('$_POST[memberfName]', '$_POST[memberlName]', '$_POST[phoneNumber]', '$_POST[memberPassword]', 1)")){
            $member_id = mysqli_insert_id($conn);
            if(mysqli_query($conn, "INSERT INTO `teammembers`(`teamid`, `memberid`) VALUES ('$_POST[teamId]', '$member_id')")){
                echo "User Registered";
            }
            else{
                echo "Registration Failed";
            }
        }
        else{
            echo "Registration Failed";
        }
    }
    else if(isset($_GET['list'])){
        if($res = mysqli_query($conn, "SELECT ID, (SELECT id FROM user WHERE id = memberid AND teamid = '$_GET[list]') AS userID, (SELECT first_name FROM user WHERE id = memberid AND teamid = '$_GET[list]') AS firstName, (SELECT last_name FROM user WHERE id = memberid AND teamid = '$_GET[list]') AS lastName FROM `teammembers`  WHERE teamid = '$_GET[list]'")){
            $str = "<h1 class='text-2xl border-b font-red-300'>Team List</h1>
            <table class='w-full'>";
            if(mysqli_num_rows($res) > 0){
                while($row = mysqli_fetch_array($res)){
                    $str = $str."<tr class='p-4 shadow border-b'><td class=''>$row[firstName] $row[lastName]</td><td class='text-red-500 text-center'><a href='#' onclick='dropMember($row[ID])'>Remove <i class='fa fa-trash'></i></td></tr>";
                }
                $str = $str ."</table>";
            }
            else{
                $str = $str."<h1 class='font-bold text-2xl text-green-500 text-center'>No members in team</h1>";
            }
            echo $str;
        }
    }
    else if(isset($_GET['drop'])){
        if(mysqli_query($conn, "DELETE FROM `teammembers` WHERE ID = '$_GET[drop]'")){
            echo 'DELETED';
        }
    }
    else{
        echo "Request rejected error";
    }
?>