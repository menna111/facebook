<?php
$error=[];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 if(!(isset($_POST['fname']) && !empty($_POST['fname']))){
   $error[]="fname";
 };

  if(!(isset($_POST['lname']) && !empty($_POST['lname']))){
    $error[]="lname";
  };

  if(!(isset($_POST['email']) && filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){
    $error[]='email';
  };

  if (!(isset($_POST['password']) && strlen($_POST['password'])>5)){
    $error[]="password";
};
// var_dump($_POST);
  if($error){
    header("Location:register.php");
};
  //connect to db

  $conn=mysqli_connect("localhost","root","","facebook");
  if(!$conn){
    echo mysqli_connect_error();
  };
  $fname=mysqli_escape_string($conn,$_POST['fname']);
  $lname=mysqli_escape_string($conn,$_POST['lname']);
  $email=mysqli_escape_string($conn,$_POST['email']);
  $password=sha1($_POST['password']);
  $gender=$_POST['gender'];

  $uploads_dir=$_SERVER['DOCUMENT_ROOT'].'\FACEBOOK\facebook\uploads\\';
  $img='';
  // if($_FILES['img']['error']==UPLOAD_ERR_OK){
  $tmp_name=$_FILES['img']['tmp_name'];
  $img=$_FILES['img']['name'];
  move_uploaded_file($tmp_name,$uploads_dir . $img);
  // }else{
  //     echo "can’t upload file";
  //     exit;
  // }

  

  $query="INSERT INTO `users` (`fname`,`lname`,`email`, `password`, `gender`, `image`) VALUES ('.$fname.','.$lname.','.$email.','.$password.','.$gender.','.$img.')";
  $result=mysqli_query($conn,$query);
  if($result){
    header("Location:./users/home.php");

  }else{
    echo mysqli_error($conn);
    exit;
  }

mysqli_close($conn);
}





?>


<!-- <?php var_dump($error); ?> -->

<html>
<head>
  <title>Bootstrap Example</title>
 <?php include("bootstrap.php")   ?>
  <link rel="stylesheet" href="index.css">
</head>

 <body >
    <div class="container">
        <div class="row mt-5 ">
            <div class="col d-flex">
                <form action="register.php" method="POST" enctype="multipart/form-data" style=" margin:auto" class="border p-3   justify-item:center">
                  <h4 class="mb-3">Register</h4>
                <div class="mb-3">
                  <label  class="form-label">FirstName</label>
                  <input type="text" class="form-control" name="fname">
                  <?php if(in_array("fname",$error)) echo " <p style='color:red'>*please inter your name </p>";  ?>
                  </div>

                  <div class="mb-3">
                  <label  class="form-label">Last Name</label>
                  <input type="text" class="form-control" name="lname">
                  <?php if(in_array("lname",$error)) echo " <p style='color:red'>*please inter your name </p>";  ?>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email"  aria-describedby="emailHelp">
                    <?php if(in_array("email",$error)) echo "<p style='color:red'>*please inter a valid email </p>";  ?>
                   
                  </div>
                  <div class="mb-3">
                  <label for="exampleInputPassword1" class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                  <?php if(in_array("password",$error)) echo "<p style='color:red'>*please inter a password not less than 6 </p>";  ?>
                </div>
                   <div class="mb-3 form-check">
                     <label>Gender: &nbsp</label>
                  <input type="radio" name="gender" value="male">
                   <label class="form-check-label" class="me-1" for="exampleCheck1">male</label>
                   <input type="radio" name="gender" class="rad" value="female" class="form-check-input" id="exampleCheck2">
                  <label class="form-check-label" for="exampleCheck2">female</label>

                 </div>

                 <div class="mb-2 form-check">
                   <label>Profile picture</label>
                   <input type="file" name="img">
                  </div>

                <div class="d-grid gap-2">
                 <button type="submit" >Register</button>
                </div>

             
               </form>
            </div>
        </div>

    </div>
 </body>
</html>