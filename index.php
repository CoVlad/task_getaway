<?php
$connect = mysqli_connect("", "", "", "");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Gateway Administrator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="./jquery.validate.min.js"></script>
</head>
<body>

<div class="container">
  <h3>Getaway Administrator</h3>
  <ul class="nav nav-tabs nav-justified">
    <li class="active"><a data-toggle="tab" href="#comp">Company</a></li>
    <li><a data-toggle="tab" href="#user">Users</a></li>
    <li><a data-toggle="tab" href="#abus">Abusers</a></li>
  </ul>
  <div class="tab-content">
  <div id="comp" class="tab-pane fade in active">
  <button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#compm">Add</button>
    <table class="table table-striped" id="compt">
    <thead>
      <tr>
        <th>Company</th>
        <th>Quota</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
    //find all company and make table
    $sql="SELECT * FROM task_company";
    $result = mysqli_query($connect, $sql);
        while($row = $result->fetch_assoc()) {
    ?>
      <tr id="cm<?php echo $row["ic"]; ?>">
        <td id="cmn<?php echo $row["ic"]; ?>"><?php echo $row["company"]; ?></td>
        <td ><span id="cmq<?php echo $row["ic"]; ?>"><?php echo round(intval($row["quota"])/1099511627776); ?></span> TB</td>
        <td>
            <button type="button" class="btn btn-success editcomp" data-toggle="modal" data-target="#compm" icb="<?php echo $row["ic"]; ?>">Edit</button>
            <button type="button" class="btn btn-danger delcomp" icb="<?php echo $row["ic"]; ?>">Delete</button>
        </td>
      </tr>
    <?php
    }
    ?>
    </tbody>
  </table>
  </div>
  <div id="user" class="tab-pane fade">
    <button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#userm">Add</button>
    <table class="table table-striped" id="usert">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Company</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
    //find all user and make table
    $sql="SELECT iu, name, mail, company, ic FROM task_users, task_company WHERE task_company.ic=task_users.comp_id";
    $result = mysqli_query($connect, $sql);
        while($row = $result->fetch_assoc()) {
    ?>
      <tr id="us<?php echo $row["iu"]; ?>">
        <td id="usn<?php echo $row["iu"]; ?>"><?php echo $row["name"]; ?></td>
        <td id="usm<?php echo $row["iu"]; ?>"><?php echo $row["mail"]; ?></td>
        <td id="usc<?php echo $row["iu"]; ?>" idcomp="<?php echo $row["ic"]; ?>"><?php echo $row["company"]; ?></td>
        <td>
            <button type="button" class="btn btn-success edituser" data-toggle="modal" data-target="#userm" iub="<?php echo $row["iu"]; ?>">Edit</button>
            <button type="button" class="btn btn-danger deluser" iub="<?php echo $row["iu"]; ?>">Delete</button>
        </td>
      </tr>
    <?php
    }
    ?>
      
    </tbody>
  </table>
  </div>
  <div id="abus" class="tab-pane fade">
    <button type="button" class="btn btn-warning" id="gen">Generate</button>
    <div class="alert alert-success fade">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Generate Success!</strong>
    </div>
    <div class="alert alert-danger fade">
     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Generate Error!</strong>
    </div>
     <form id="showf">
  <div class="form-group">
    <label for="month">Choose month for report:</label>
    <select class="form-control" name="month" id="month">
    <?php
    //make Select last 6 month
    $t=time();
    for ($m=6;$m>0;$m--) {
    ?>
        <option value="<?php echo $m;?>"><?php echo date("F",$t-$m*30*24*3600);?></option>      
    <?php
    }
    ?>
        
      </select>
  </div>  
  <button type="submit" class="btn btn-default">Submit</button>
</form>

<div class="row">
<div class="col-xs-12" id="report" >

</div>
</div>

  </div>
</div>

<!-- Modal -->
<div id="userm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        
        
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <form id="userf">
        <input type="hidden" name="id" id="iu" />
  <div class="form-group">
    <label for="name">Name:</label>
    <input type="text" class="form-control" name="name" id="name">
  </div>
  <div class="form-group">
    <label for="eml">E-mail:</label>
    <input type="email" class="form-control" name="email" id="eml">
  </div>
  <div class="form-group">
    <label for="compid">Select company:</label>
      <select class="form-control" name="company_id" id="compid">
      <?php
    //find all company and make select
    $sql="SELECT * FROM task_company";
    $result = mysqli_query($connect, $sql);
        while($row = $result->fetch_assoc()) {
    ?>
        <option value="<?php echo $row["ic"]; ?>"><?php echo $row["company"]; ?></option>      
    <?php
    }
    ?>
        
      </select>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
      </div>
      
    </div>

  </div>
</div>


<!-- Modal -->
<div id="compm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
        
        
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <form id="compf">
        <input type="hidden" name="id" id="ic" value="0" />
  <div class="form-group">
    <label for="company">Company:</label>
    <input type="text" class="form-control" name="name" id="company">
  </div>
  <div class="form-group">
    <label for="quota">Quota(in TB):</label>
    <input type="number" class="form-control" name="quota" id="quota">
  </div>
  
  <button type="submit" class="btn btn-default">Submit</button>
</form>
      </div>
      
    </div>

  </div>
</div>

</div>

<script>

//make JSON string from form inputs
function formtojson(id){
    var str=$("#"+id).serialize();
    return "{\""+str.replace(/&/g,"\",\"").replace(/=/g,"\":\"") + "\"}";
}

//reset modal forms
$("button.add").click(function(){
   $(':input','#compf')
 .not(':button, :submit, :reset')
 .val('')
 .removeAttr('selected');
 $("#ic").val(0);
  $(':input','#userf')
 .not(':button, :submit, :reset')
 .val('')
 .removeAttr('selected');
 $("#iu").val(0);
});

//company tab

//change modal form
$(".editcomp").click(function (){
    var i=$(this).attr("icb");
    $("#ic").val(i);
    $("#company").val($("#cmn" + i).text());
    $("#quota").val($("#cmq" + i).text());
});

//delete company row
$(".delcomp").click(function (){
    var i=$(this).attr("icb");
    //ajax to server
    $.ajax({
        type: "POST",
        url: "./company.php",
        data: "delete="+i,               
        success: function(data, status, jqXHR) {
            var statusCode = jqXHR.status;
            switch (statusCode) {
                case 204:
                    //successful deleted
                    $("#cm"+i).remove();
                    break;
                case 404:
                    //error message
                    $("#cm"+i).remove();
                    alert(data);
                    break;
            }
        },
        fail:function(){
            alert("Error connection!");
        }
    });
    
});

//validate form
$("#compf").validate({
    debug: true,
    rules: {
				name: {
					required: true,
					minlength: 3
				},
				quota: {
					required: true,
                    minlength: 1,
					digits: true
				}
			},
			messages: {
				name: {
					required: "Please enter a Company",
					minlength: "Your Company must consist of at least 3 characters"
				},
				quota: {
					required: "Please provide a quota",
                    minlength: "Very small quota",
					digits: "Your quota must be number in TB"
				}
			},
  submitHandler: function(form) {
    //ajax and make change in table
    var d=formtojson("compf");
    var i = $("#ic").val(); 
    
     
    $.ajax({
        type: "POST",
        url: "./company.php",
        data: "query="+d,               
        success: function(data, status) {
            //reset form
            $(':input','#compf')
            .not(':button, :submit, :reset')
            .val('')
            .removeAttr('selected');
            $("#ic").val(0);
            //close modal
            $("#compm button.close").click();
            //parse answer from server
            var obj = JSON.parse(data);
            if (typeof obj.quota !=="undefined"){
            if (i=="0") {//add new row
                $("#compt tbody").append('<tr id="cm'+obj.id+'">\n<td id="cmn'+obj.id+'">'+obj.name+'</td>\n<td><span id="cmq'+obj.id+'">'+obj.quota+'</span> TB</td>\n<td>\n<button type="button" class="btn btn-success editcomp" data-toggle="modal" data-target="#compm" icb="'+obj.id+'">Edit</button>\n<button type="button" class="btn btn-danger delcomp" icb="'+obj.id+'">Delete</button>\n</td>\n</tr>');
            } else {//edit existing row
                $("#cmn"+obj.id).text(obj.name);
                $("#cmq"+obj.id).text(obj.quota);
            }
            } else {
                alert("Error with response from server!");
            }
        },
        fail:function(){
            alert("Error connection!");
        }
    });
  }
});

//users tab


//change modal form
$(".edituser").click(function (){
    var i=$(this).attr("iub");
    $("#iu").val(i);
    $("#name").val($("#usn" + i).text());
    $("#eml").val($("#usm" + i).text());
    $("#compid option:selected").removeAttr("selected");
    var j =$("#usc"+i).attr("idcomp");
    $("#compid option[value="+j+"]").prop("selected", true);
});

//delete user row
$(".deluser").click(function (){
    var i=$(this).attr("iub");
    //ajax to server
    $.ajax({
        type: "POST",
        url: "./user.php",
        data: "delete="+i,               
        success: function(data, status, jqXHR) {
            var statusCode = jqXHR.status;
            switch (statusCode) {
                case 204:
                    //successful deleted
                    $("#us"+i).remove();
                    break;
                case 404:
                    //error message
                    $("#us"+i).remove();
                    alert(data);
                    break;
            }
        },
        fail:function(){
            alert("Error connection!");
        }
    });
    
});

//validate form
$("#userf").validate({
    debug: true,
    rules: {
				name: {
					required: true,
					minlength: 3
				},
				eml: {
					required: true,
                    email: true
				}
			},
			messages: {
				name: {
					required: "Please enter a User",
					minlength: "Your User must consist of at least 3 characters"
				},
				eml: {
					required: "Please provide a email",
                    email: "Your email is wrong"
				}
			},
  submitHandler: function(form) {
    //ajax and make change in table
    var d=formtojson("userf");
    var i = $("#iu").val(); 
     
     
    $.ajax({
        type: "POST",
        url: "./user.php",
        data: "query="+d,               
        success: function(data, status) {
            //reset form
            $(':input','#userf')
            .not(':button, :submit, :reset')
            .val('')
            .removeAttr('selected');
            $("#iu").val(0);
            //close modal
            $("#userm button.close").click();
            //parse answer from server
            var obj = JSON.parse(data);
            if (typeof obj.name !=="undefined"){
            if (i=="0") {//add new row
                $("#usert tbody").append('<tr id="us'+obj.id+'">\n<td id="usn'+obj.id+'">'+obj.name+'</td>\n<td id="usn'+obj.id+'">'+obj.email+'</td>\n<td id="usm'+obj.id+'">'+obj.company+'</td>\n<td>\n<button type="button" class="btn btn-success edituser" data-toggle="modal" data-target="#userm" iub="'+obj.id+'">Edit</button>\n<button type="button" class="btn btn-danger deluser" iub="'+obj.id+'">Delete</button>\n</td>\n</tr>');
            } else {//edit existing row
                $("#usn"+obj.id).text(obj.name);
                $("#usm"+obj.id).text(obj.email);
                $("#usc"+obj.id).text(obj.company);
            }
            } else {
                alert("Error with response from server!");
            }
        },
        fail:function(){
            alert("Error connection!");
        }
    });
  }
});


//abusers tab

$("#gen").click(function(){
    $("div.alert-success").addClass("in");
    $.ajax({
        type: "POST",
        url: "./generate.php",           
        success: function() {
            $("div.alert-success").addClass("in");
        },
        fail:function(){
            $("div.alert-danger").addClass("in");
        }
    });
});

$("form#showf").submit(function(e){
    e.preventDefault();
    $("#report").empty();
    $.ajax({
        type: "POST",
        url: "./report.php",  
        data: "month="+formtojson("showf"),        
        success: function(data) {
            if (data!="[]"){
            $("#report").append("<table class=\"table table-striped\">\n<thead>\n<tr>\n<th>Company</th>\n<th>Used</th>\n<th>Quota</th>\n</tr>\n</thead>\n<tbody>\n</tbody>\n</table>");
            var obj =JSON.parse(data);
            obj.forEach(function(el){
                $("#report table").append("<tr>\n<td>"+el.name+"</td>\n<td>"+el.used+" TB</td>\n<td>"+el.quota+" TB</td>\n</tr>");
            });
            } else {
                alert("No exceed company!");
            }
        },
        fail:function(){
            $("#report").append("Conecting error");
        }
    });
})

</script>

</body>
</html>

<?php
mysqli_close($connect);
?>