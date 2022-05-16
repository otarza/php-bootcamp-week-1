<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" >
</head>
<body>

<?php if ($_SERVER['REQUEST_METHOD'] === 'GET') { ?>

  <div class="main_container">
  <form action="index.php" method="post" enctype="multipart/form-data" class="input_cont">
   
  <label for="" class="input_header">Enter Your Name:</label> 
    <input type="text" name="firstname" placeholder="Enter Firstname">

    <label for="" class="input_header">Enter Your Last Name:</label>
    <input type="text" name="lastname" placeholder="Enter Lastname">

    <label class="form-label input_header" for="formFile">Upload Profile Picture</label>
   <input type="file" name="file" class="form-control" id="formFile">
     
     <input type="submit" name="submit" value="Submit"/>
  </form>
</div>

<?php }  ?>
   

<?php if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
  $regex = "/^[a-zA-Z ]+$/i";
  $name = $_POST["firstname"];
  $lastName = $_POST["lastname"];

  $target_dir = "images/";
  $target_file = $target_dir . $_FILES["file"]["name"];
  
  if(preg_match($regex,$_POST['firstname']) && preg_match($regex,$_POST['lastname']) && $_FILES['file']['tmp_name']!=''){
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
    echo "<div class='user_info'> <br> <h2 class='name'> $name $lastName</h2>";
    echo '<img src="images/'. $_FILES['file']['name'] .'" >';
    echo "</div>";
    }else{ ?>
         <div class="main_container">
  <form action="index.php" method="post" enctype="multipart/form-data" class="input_cont">
   
  <label for="" class="input_header">Enter Your Name:</label> 
    <input type="text" name="firstname" placeholder="Enter Firstname">

    <label for="" class="input_header">Enter Your Last Name:</label>
    <input type="text" name="lastname" placeholder="Enter Lastname">

    <label class="form-label input_header" for="formFile">Upload Profile Picture</label>
   <input type="file" name="file" class="form-control" id="formFile">

   <div style="color: red; text-align:left;">
    <p> Incorrect Format! <br> 
    Please, fill all forms and 
    <br>
    contain only alphabetical characters </p>
    </div>
     <input type="submit" name="submit" value="Submit"/>
  </form>
</div>

<?php  } } ?>

</body>
</html>