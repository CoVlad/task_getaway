<?php

$connect = mysqli_connect("", "", "", "");

//data for generate
$namesite = array(
    1 => "bar",
    2 => "foo",
    3 => "google",
    4 => "site",
    5 => "yahoo",
    6 => "yandex",
    7 => "call",
    8 => "facebook",
    9 => "vk",
    10 => "ok",
);
$sufsite = array(
    1 => "top",
    2 => "com",
    3 => "ua",
    4 => "biz",
    5 => "pro",
    6 => "net",
    7 => "gov",
    8 => "ru",
    9 => "club",
    10 => "room",
);

//make array from users in db
$sql="SELECT iu FROM task_users";
$result = mysqli_query($connect, $sql);
$i=1;
while($row = $result->fetch_assoc()) {
    $user[$i]=$row["iu"];
    $i++;
    }
$n=$i-1;//number of users in db

//generate data  for the last 6 months according to the following rules
/*
Each user of the company has at least one transfer every month.
Every transfer has a random number of bytes from 100 bytes to 10 TB
Every user may have several transfers any given day
Every user should have approximately 50-500 records for the 6-month period.
*/
$q="";
$begin=time()-180*24*3600;//begining of generate by time
for($d=1;$d<=180;$d++){//count every day last 6 month
    for($u=1;$u<=$n;$u++){//count every user in db
       $nt=rand(1,3);//random amount of transfer for user per day
       for($tr=1;$tr<=$nt;$tr++){
        $userid=$user[$u];
        $dt=date("Y-m-d H:i:s",($begin+$d*24*3600-rand(1,86400)));
        $resource="http://".$namesite[rand(1,10)].".".$sufsite[rand(1,10)];
        $transfered=100+rand(1,1024)*rand(1,1024)*rand(1,1024)*rand(1,1024);
        $q.="($userid,\"$dt\",\"$resource\", $transfered),";
       }
    }
    if ($d % 30 ==0){//insert in db every month
        $q=rtrim($q,',');        
        $sql="INSERT INTO task_log (userid, dt,resource, transfered) VALUES ".$q;
        $result = mysqli_query($connect, $sql);
        $q="";
    }
}
header("HTTP/1.0 200");
mysqli_close($connect);

?>