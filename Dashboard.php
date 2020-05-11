<br>

<?php

session_start();
if(isset($_SESSION['userEmail']))
{
    include 'connection.php';
    $query = "SELECT * FROM contacts";
    $result = mysqli_query($con, $query);
?>


<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <script src="Bootstrap/js/jquery-3.5.1.min.js"></script>
    <script src="Bootstrap/js/jquery-3.5.1.slim.min.js"></script>
    <script src="Bootstrap/js/jquery-3.5.1.js"></script>
    <!--Bootstrap js link-->
    <script src="Bootstrap/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    <style type="text/css">

    </style>
</head>
<body>
    <!--========================================Navigation Bar=============================================-->

    <!--fixed-top class is used to fix the navigation bar to the top while scrolling(it is necessay to use margin-top(in the container on line 52) with this class)-->
    <nav class="navbar navbar-expand-sm bg-primary navbar-dark justify-content-center fixed-top">
        <a href="#" class="navbar-brand" style="vertical-align:central"><p>CONTACT BOOK</p></a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navcollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcollapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="#" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Contact us</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Via Email</a>
                        <a href="#" class="dropdown-item">Via Facebook</a>
                        <a href="#" class="dropdown-item">Via Whatsapp</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">About</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link"><?php echo $_SESSION['userEmail'] ?></a>
                </li>
                <li class="nav-item">
                    <a href="Logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <br><br><br>

    <!--========================================PopUp=============================================-->
<span class="alert alert-success" id="successMsg" role="alert"></span>
<div class="container">
    <div class="position-absolute">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mymodal">Add Record</button>
    </div>
    <div style="text-align:right">
		<button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#mymodal-->">Export Contact</button>
	</div>
    <br><br>
	<table class="table ">
	    <thead>
		    <tr>
                <th scope="col">ID</th>
			    <th scope="col">Name</th>
			    <th scope="col">Email</th>
			    <th scope="col">Phone</th>
			    <th scope="col">Country</th>
			    <th scope="col">Action</th>
		    </tr>
		</thead>
        <tbody>
            <?php 
                if(mysqli_num_rows($result) > 0){

                    while($row = mysqli_fetch_assoc($result)){
            ?>
                            <tr>
                                <td id="id"><?php echo $row["ID"] ?></td>
                                <td id="nameUp<?php echo $row["ID"]?>"><?php echo $row["Name"] ?></td>
                                <td id="emailUp<?php echo $row["ID"]?>"><?php echo $row["Email"] ?></td>
                                <td id="phoneUp<?php echo $row["ID"]?>"><?php echo $row["Phone"] ?></td>
                                <td id="countryUp<?php echo $row["ID"]?>"><?php echo $row["Country"] ?></td>
                                <td>
                                    <button type="button" data-toggle="modal" data-target="#editModal" value="<?php echo $row["ID"]?>" id="editBTn" class="btn btn-primary editBtn">Edit</button>
                                    <button type="button" class="btn btn-primary">Detail</button>
                                    <button type="button" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
	<div class="modal fade" id="mymodal">
		<div class="modal-dialog modal-md modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add new Record</h4>
				</div>
			    <div class="modal-body">
                 <form class="container" id="insertForm" style="margin-top: 1vw" method="post" action="">
					<div class="form-group">
  	                    <label>Name</label>
                        <input type="text" name="name" id="name" placeholder="enter name" class="form-control" />
                        <span style="color:red" id="nameErr"></span>
			        </div>
  			        <div class="form-group">
    				    <label>Email</label>
			            <input type="email" name="email" id="email" placeholder="enter email" class="form-control" />
                        <span style="color:red" id="emailErr"></span>
				    </div>
				    <div class="form-group">
   				        <label>Phone</label>
 				        <input type="text" name="phone" id="phone" placeholder="enter Phone" class="form-control" />
                         <span style="color:red" id="phoneErr"></span>
   				    </div>
 				    <div class="form-group">
    			        <label>Select Country</label>
      			        <select class="form-control" id="country" name="country">
   			                <option value="Pakistan">Pakistan</option>
  			                <option value="India">India</option>
       			            <option value="England">England</option>
      			            <option value="USA">USA</option>
      			        </select>
      			    </div>
    			    <button class="btn btn-primary" type="button" id="submitBtn">Submit</button>
      			    <button class="btn btn-basic" data-dismiss="modal">Cancel</button>
                  </form>
  				</div>
			</div>
		</div>
	</div>
    <!-- =================================================EDIT MODAL============================================================= -->
    
	<div class="modal fade" id="editmodal">
		<div class="modal-dialog modal-md modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Record</h4>
				</div>
			    <div class="modal-body">
                 <form class="container" id="editForm" style="margin-top: 1vw" method="post" action="">
					<input type="hidden" id="recordID" >
                    <div class="form-group">
  	                    <label>Name</label>
                        <input type="text" name="name" id="nameEdit" placeholder="enter name" class="form-control" />
                        <span style="color:red" id="nameErrEdit"></span>
			        </div>
  			        <div class="form-group">
    				    <label>Email</label>
			            <input type="email" name="email" id="emailEdit" placeholder="enter email" class="form-control" />
                        <span style="color:red" id="emailErrEdit"></span>
				    </div>
				    <div class="form-group">
   				        <label>Phone</label>
 				        <input type="text" name="phone" id="phoneEdit" placeholder="enter Phone" class="form-control" />
                         <span style="color:red" id="phoneErrEdit"></span>
   				    </div>
 				    <div class="form-group">
    			        <label>Select Country</label>
      			        <select class="form-control" id="countryEdit" name="country">
   			                <option value="Pakistan">Pakistan</option>
  			                <option value="India">India</option>
       			            <option value="England">England</option>
      			            <option value="USA">USA</option>
      			        </select>
      			    </div>
    			    <button class="btn btn-primary updateBtn" type="button" id="updateBtn">Update</button>
      			    <button class="btn btn-basic" data-dismiss="modal">Cancel</button>
                  </form>
  				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>

<?php

    }
    else
        header("Location: Login.php")


?>

<script type="text/javascript">
    $("#submitBtn").click(function(){
        $.ajax({
            url: "insert.php",
            method: "POST",
            data: $("#insertForm").serialize(),
            success: function(data){
                //alert(data);
                var array = $.parseJSON(data);
                if(array.status == "submitted"){
                    $("#insertForm")[0].reset();
                    $("#mymodal").modal('hide');
                    $("#nameErrEdit").html("");
                    $("#emailErrEdit").html("");
                    $("#phoneErrEdit").html("");
                    $("#successMsg").html("Record submitted successfully");
                    $("table tbody").append("<tr><td>"+ array.id +"</td><td id='nameUp" + array.id + "'>"+ array.name +"</td><td id='emailUp" + array.id + "'>"+ array.email +"</td><td id='phoneUp" + array.id + "'>"+ array.phone +"</td><td id='countryUp" + array.id + "'>"+ array.country +"</td><td>"
                     +"<button type='button' data-toggle='modal' data-target='#editModal' class='btn btn-primary editBtn mr-1' value="+ array.id +">Edit</button><button type='button' class='btn btn-primary mr-1'>Detail</button><button type='button' class='btn btn-danger'>Delete</button>"+ "</td></tr>");
                }
                else{
                    $("#nameErr").html(array.nameErr);
                    $("#emailErr").html(array.emailErr);
                    $("#phoneErr").html(array.phoneErr);
                    $("#successMsg").html("");
                }
            }
        });
    });
    $(document).on("click", "button.editBtn", function(){
        id = $(this).val();
        $.ajax({
            url: "update.php",
            method: "POST",
            data: {id
            },
            success: function(data){
                array = $.parseJSON(data);
                //alert(array.id);
                $("#nameEdit").val(array.name);
                $("#emailEdit").val(array.email);
                $("#phoneEdit").val(array.phone);
                $("#countryEdit").val(array.country);
                $("#recordID").val(array.id);
            }
        });
    });
    
    $(document).on("click", "button.updateBtn", function(){
       name = $("#nameEdit").val();
       email = $("#emailEdit").val();
       phone = $("#phoneEdit").val();
       country = $("#countryEdit").val();
       status = "updateRecord";
       id = $("#recordID").val();
       $.ajax({
           url: "insert.php",
           method: "POST",
           data: {
               id: id,
               name: name,
               email: email,
               phone: phone,
               country: country,
               status: status
           },
           success: function(data){
                var array = $.parseJSON(data);
                if(array.status == "updated"){
                    $("#editForm")[0].reset();
                    $("#editmodal").modal('hide');
                    $("#nameErrEdit").html("");
                    $("#emailErrEdit").html("");
                    $("#phoneErrEdit").html("");
                    $("#successMsg").html("Record updated successfully");
                    $("#nameUp" + array.id).html(array.name);
                    $("#emailUp" + array.id).html(array.email);
                    $("#phoneUp" + array.id).html(array.phone);
                    $("#countryUp" + array.id).html(array.country);    
                }
                else{
                    $("#nameErrEdit").html(array.nameErr);
                    $("#emailErrEdit").html(array.emailErr);
                    $("#phoneErrEdit").html(array.phoneErr);
                    $("#successMsgEdit").html("");
                }
           }
       });

    });
</script>