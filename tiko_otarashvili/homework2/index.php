<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href ="style.css" rel="stylesheet"/>
    <title>Second Challenge</title>
  </head>
  <body>

<div class="form_container">
  <form  action="index.php" method="POST" enctype="multipart/form-data" class="row g-3 form">
  <div class="col-md-4">
    <label for="validationDefault01" class="form-label">Enter Github Username:</label>
    <input type="text"  name="username" placeholder="Enter username" class="form-control">
  </div>
  <div class="col-md-3">
    <label for="validationDefault04" class="form-label">Choose List Type</label>
    <select class="form-select"  name="option" >
      <option selected  value="choose">Choose...</option>
      <option value="repositories">repositories</option>
      <option value="followers">followers</option>
      
    </select>
  
  </div>

  <div class="col-12">
  <input type="submit" name="submit" value="submit" class="btn btn-dark sub_btn">
  </div>
</form>
</div>

<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">URL</th>
      
    </tr>
  </thead>
  <tbody>

  <?php  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $msg = null; 
       $username = $_POST["username"];

      
   if( $_POST['option'] === "repositories" &&  strlen($username) !== 0 ) {
       
        $curlUser = curl_init();
        curl_setopt_array($curlUser,[
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_URL => "https://api.github.com/users/{$username}",
          CURLOPT_USERAGENT => 'Github'
        ]);
        
        $resp = curl_exec($curlUser);
$result = json_decode($resp, true);

$repoAmount = $result["public_repos"];

$count=1;
$pages = intval(ceil ($repoAmount / 100));
$curl = curl_init();

    curl_setopt_array($curl,[
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => "https://api.github.com/users/{$username}/repos?per_page=100&page=1",
      CURLOPT_USERAGENT => 'Github'
    ]);
    
    $response = curl_exec($curl);
    $information = json_decode($response, true);
    foreach($information as $info){ ?>
      <tr>
        <th scope="row"><?php echo $count++; ?></th>
        <td><img class="avatar_img" src="<?php echo $info["owner"]["avatar_url"];?>" alt="avatar image" ></td>
        <td><?php echo $info["full_name"];?></td>
        <td>  <a target="_blank" href="<?php echo $info["html_url"];?>"><?php echo $info["html_url"];?></a></td>
        
      <tr>
   <?php }?>
      
<?php $count = 100;
for($i=0; $i < $pages; $i++){
  $repoAmount -= 100;
if($repoAmount > 100){$curl = curl_init();
    curl_setopt_array($curl,[
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => "https://api.github.com/users/{$username}/repos?per_page=100&page={$i}",
      CURLOPT_USERAGENT => 'Github'
    ]);
    
    $response = curl_exec($curl);
    $information = json_decode($response, true);
    
    foreach($information as $info){   ?>

<tr>
        <th scope="row"><?php echo $count++; ?></th>
        <td><img class="avatar_img" src="<?php echo $info["owner"]["avatar_url"];?>" alt="avatar image" ></td>
        <td><?php echo $info["full_name"];?></td>
        <td>  <a target="_blank" href="<?php echo $info["html_url"];?>"><?php echo $info["html_url"];?></a></td>
        
      <tr>
    

    <?php } }
    else if($repoAmount < 100 && $repoAmount > 0 ){
      $curl = curl_init();
      $repoAmount += 1;
    curl_setopt_array($curl,[
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_URL => "https://api.github.com/users/{$username}/repos?per_page={$repoAmount}&page={$i}",
      CURLOPT_USERAGENT => 'Github'
    ]);
    
    $response = curl_exec($curl);
    $information = json_decode($response, true);
    
    foreach($information as $info){?>
    <tr>
        <th scope="row"><?php echo $count++; ?></th>
        <td><img class="avatar_img" src="<?php echo $info["owner"]["avatar_url"];?>" alt="avatar image" ></td>
        <td><?php echo $info["full_name"];?></td>
        <td>  <a target="_blank" href="<?php echo $info["html_url"];?>"><?php echo $info["html_url"];?></a></td>
        
      <tr>
<?php
} } } } else  if( $_POST['option'] === "followers"  && strlen($username) !== 0 ) {
       
  $curlUser = curl_init();
  curl_setopt_array($curlUser,[
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_URL => "https://api.github.com/users/{$username}",
    CURLOPT_USERAGENT => 'Github'
  ]);
  
  $resp = curl_exec($curlUser);
$result = json_decode($resp, true);
$followerAmount = $result["followers"];
$count=1;
$pages = intval(ceil ($followerAmount / 100));
$curl = curl_init();
curl_setopt_array($curl,[
CURLOPT_RETURNTRANSFER => true,
CURLOPT_URL => "https://api.github.com/users/{$username}/followers?per_page=100&page=1",
CURLOPT_USERAGENT => 'Github'
]);

$response = curl_exec($curl);
$followers = json_decode($response, true);
foreach($followers as $follower){ ?>
<tr>
    <th scope="row"><?php echo $count++; ?></th>
    <td><img class="avatar_img" src="<?php echo $follower["avatar_url"];?>" alt="user_img"></td>
    <td><?php echo $follower["login"];?></td>
    <td> <a target="_blank" href="<?php echo $follower["html_url"];?>"><?php echo $follower["html_url"];?></a></td>
    
  <tr>
<?php }?>

<?php $count = 100;
for($i=0; $i < $pages; $i++){
  $followerAmount -= 100;
if($followerAmount > 100){$curl = curl_init();
curl_setopt_array($curl,[
CURLOPT_RETURNTRANSFER => true,
CURLOPT_URL => "https://api.github.com/users/{$username}/followers?per_page=100&page={$i}",
CURLOPT_USERAGENT => 'Github'
]);

$response = curl_exec($curl);
$followers = json_decode($response, true);

foreach($followers as $follower){   ?>

<tr>
    <th scope="row"><?php echo $count++; ?></th>
    <td><img class="avatar_img" src="<?php echo $follower["avatar_url"];?>" alt="user_img"></td>
    <td><?php echo $follower["login"];?></td>
    <td> <a target="_blank" href="<?php echo $follower["html_url"];?>"><?php echo $follower["html_url"];?></a></td>
    
  <tr>


<?php } }
else if($followerAmount < 100 && $followerAmount > 0 ){
$curl = curl_init();
$followerAmount += 1;
curl_setopt_array($curl,[
CURLOPT_RETURNTRANSFER => true,
CURLOPT_URL => "https://api.github.com/users/{$username}/followers?per_page={$followerAmount}&page={$i}",
CURLOPT_USERAGENT => 'Github'
]);

$response = curl_exec($curl);
$followers = json_decode($response, true);

foreach($followers as $follower){?>
<tr>
    <th scope="row"><?php echo $count++; ?></th>
    <td><img class="avatar_img" src="<?php echo $follower["avatar_url"];?>" alt="user_img"></td>
    <td><?php echo $follower["login"];?></td>
    <td> <a target="_blank" href="<?php echo $follower["html_url"];?>"><?php echo $follower["html_url"];?></a></td>
    
  <tr>
<?php
} } } }  else if( $_POST['option'] === "choose"   && strlen($username) !== 0  || $_POST['option'] === "choose"  && strlen($username) == 0 || strlen($username) === 0 ){
  $msg = "You left one or more of the required fields..";
  echo ($msg !== null)?'<p class="fill_all">ERROR: ' . $msg . '</p>':null;
}  }  ?>

</body>
</html>