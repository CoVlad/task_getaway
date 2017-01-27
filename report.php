<?php

$connect = mysqli_connect("", "", "", "");

if (isset($_POST["month"])){
    $p=json_decode($_POST["month"]);
    $m=date('n',mktime(0,0,0,date('n')-intval($p->month),date('j'), date('Y')));   
    $sql="SELECT * FROM (SELECT ic, company, sum(transfered)AS amount,quota FROM task_company, (SELECT transfered, comp_id FROM task_users, task_log WHERE task_users.iu=task_log.userid AND MONTH(dt)=$m) AS t1 WHERE task_company.ic=t1.comp_id  Group by company)AS t2 WHERE amount>quota ORDER BY amount DESC";
    $result = mysqli_query($connect, $sql);
    $json="[";
    while($row = $result->fetch_assoc()) {
        $json.="{\"id\": ".$row["ic"].",\"name\": \"".$row["company"]."\",\"used\": ".round($row["amount"]/1099511627776,4).",\"quota\": ".round($row["quota"]/1099511627776)."},";
    } 
    echo rtrim($json,",")."]";
    
}

mysqli_close($connect);
?>