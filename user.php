<?php
$connect = mysqli_connect("", "", "", "");

if (isset($_POST["delete"])){
    //delete row
    $sql="DELETE FROM task_users WHERE iu=".$_POST["delete"];
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
$n = mysqli_real_escape_string($connect,$p->name);
$e = mysqli_real_escape_string($connect,$p->email);
$i=intval($p->id);
$cid=intval($p->company_id);
if ($i==0){
    //create row
    $sql="INSERT INTO task_users (name, mail, comp_id) VALUES (\"$n\",\"$e\",$cid)";
} else {
    //update row
    $sql="UPDATE task_users SET name=\"$n\", mail=\"$e\", comp_id=$cid WHERE iu=$i";
}

$result = mysqli_query($connect, $sql);
if($i==0){
    $i=mysqli_insert_id($connect);
}
//find company name by comp_id
$sql="SELECT company FROM task_company WHERE ic=".$cid." LIMIT 1";
$result = mysqli_query($connect, $sql);
$company="";
while($row = $result->fetch_assoc()) {
    $company=$row["company"];
    }

//return result
echo '{"id":'.$i.',"name":"'.$n.'","email":"'.$e.'","company_id":'.$cid.',"company":"'.$company.'"}';
}
mysqli_close($connect);
?>