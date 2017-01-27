<?php
$connect = mysqli_connect("", "", "", "");

if (isset($_POST["delete"])){
    //delete row
    $sql="DELETE FROM task_company WHERE ic=".$_POST["delete"];
    $result = mysqli_query($connect, $sql);
    if ($result){
       //successfull delete 
       header("HTTP/1.0 204");
    } else {
        //error delete
        header("HTTP/1.0 404");
        echo '{"errors":"Company not found"}';
    }
} else {
    //create or update row
$p=json_decode($_POST["query"]);
$q1= intval($p->quota);
$q = $q1*1099511627776;
$i=intval($p->id);
$c = mysqli_real_escape_string($connect,$p->name);
if ($i==0){
    //create row
    $sql="INSERT INTO task_company (company, quota) VALUES (\"$c\",$q)";
} else {
    //update row
    $sql="UPDATE task_company SET company=\"$c\", quota=$q WHERE ic=$i";
}

$result = mysqli_query($connect, $sql);
if($i==0){
    $i=mysqli_insert_id($connect);
}

//return result
echo '{"id":'.$i.',"name":"'.$c.'","quota":'.$q1.'}';
}
mysqli_close($connect);
?>