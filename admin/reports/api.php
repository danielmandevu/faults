<?php
    header('response-type: text/json');
    require_once '../../db.php';
    $date = array();
    $date_from = '01/01/2022';
    $date_to = date('d/m/y', time());
    if(isset($_POST['from']) && $_POST['from'] != ""){
        $date_from = $_POST['from'];
    }
    if(isset($_POST['date_to']) && $_POST['date_to'] != ""){
        $date_to = $_POST['date_to'];
    }
        //get totals first
        $date_to = strtotime($date_to);
        $date_to = date('Y-m-d', $date_to);
        $date_from = strtotime($date_from);
        $date_from = date('Y-m-d', $date_from);
        $totals = array();
        $reported_ = array();
        $cleared_ = array();
        //SELECT COUNT(ID) AS total, (SELECT COUNT(status_) FROM userreports WHERE status_ = 'pending' AND reportedon between $date_from and $date_to) AS pending_num, (SELECT COUNT(status_) FROM userreports WHERE status_ = 'cleared' AND reportedon between $date_from and $date_to) AS cleared_num FROM `userreports` WHERE reportedon between $date_from and $date_to
        $res = mysqli_query($conn, "SELECT COUNT(fault_id) AS total, (SELECT COUNT(fault_id) FROM faults WHERE fault_status = 'pending' AND date_reported <= '$date_to' AND date_reported >= '$date_from') AS pending_num, (SELECT COUNT(fault_id) FROM faults WHERE fault_status = 'Cleared' AND date_cleared <= '$date_to' AND date_cleared >= '$date_from') AS cleared_num FROM `faults` WHERE date_reported <= '$date_to' AND date_reported >= '$date_from'");
        while ($row = mysqli_fetch_array($res)) {
            array_push($totals, $row);
        }
        $res_reported_on = mysqli_query($conn, "SELECT date_reported AS date, COUNT(fault_id) AS total_reported FROM `faults` WHERE date_reported <= '$date_to' AND date_reported >= '$date_from' GROUP BY date_reported");
        while($row = mysqli_fetch_array($res_reported_on)){
            array_push($reported_, $row);
        }
        if($res_cleared_on = mysqli_query($conn, "SELECT date_cleared AS date_cleared, COUNT(fault_id) AS total_cleared FROM `faults` WHERE fault_status = 'cleared' AND date_cleared <= '$date_to' AND date_cleared >= '$date_from' GROUP BY date_cleared")){
            while($row = mysqli_fetch_array($res_cleared_on)){
                array_push($cleared_, $row);
            }
        }
        $res_total_reads = mysqli_query($conn, "SELECT SUM(readsNum) AS totalReads FROM `knowledge_articles`");
        $total_reads = 0;
        while($row = mysqli_fetch_array($res_total_reads)){
            $total_reads = $row['totalReads'];
        }
        $knowledge = mysqli_query($conn, 'SELECT ID, articleTitle, readsNum FROM `knowledge_articles`');
        $str_break = array();
        while($row = mysqli_fetch_array($knowledge)){
            array_push($str_break, $row);
        }
        print_r(json_encode(array('totals'=>$totals, 'reported'=>$reported_, 'cleared'=>$cleared_, 'story'=>array('totalReads'=>$total_reads, 'breakDown'=>$str_break))));
    
?>