<?php
//setting starting empty values of errors array and invalid names to empty strings
$errors = [];
$invalidFirstName = $invalidLastName = '';
//regex for validator 
$regex = "/^[a-zA-Z]+$/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //assigning variable values when user submits form 
    $firstName = $_POST['fname'];
    $lastName = $_POST['lname'];
    $image = $_FILES['image'] ?? null;
    $imagePath = '';
    //form validation logic
    if (!$firstName) {
        $invalidFirstName = 'empty value,please enter your name';
        array_push($errors, $invalidFirstName);
    } else if (!preg_match($regex, $firstName)) {
        $firstName = '';
        $invalidFirstName = 'type error,name should contain only alphanumeric charecters';
        array_push($errors, $invalidFirstName);
    }
    if (!$lastName) {
        $invalidLastName = 'empty value,please enter your surname';
        array_push($errors, $invalidLastName);
    } else if (!preg_match($regex, $lastName)) {
        $lastName = '';
        $invalidLastName = 'type error,surname should contain only alphanumeric charecters';
        array_push($errors, $invalidLastName);
    };
    //making directory for image if its not presented,reasigning image path  and moveing image file to that directory
    if (!is_dir('images')) {
        mkdir('images');
    };
    if ($image) {
        $imagePath = 'images/' . $image['name'];
        move_uploaded_file($image['tmp_name'], $imagePath);
    };
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <input type="text" id="fname" name="fname" aria-label="firstName" placeholder="first name">
        <input type="text" id="lname" name="lname" aria-label="lastName" placeholder="last name">
        <label for="upload-file" class="upload">upload file</label>
        <input type="file" id="upload-file" name="image">
        <button type="submit">submit</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <div class="output">
            <div class="firstName"><?php if (!empty($firstName)) echo 'name:' . $firstName ?></div>
            <div class="lastName"><?php if (!empty($lastName)) echo 'surname:' . $lastName ?></div>
            <?php if (!empty($image) && strlen($imagePath) > 8) : ?>
                <div class="image">
                    <img src="<?php echo $imagePath ?>" alt="<?php echo $image['name'] ?>">
                <?php endif; ?>
                </div>
                <?php if (!empty($errors)) : ?>
                    <div class="errors">
                        <?php foreach ($errors as $error) : ?>
                            <div><?php echo $error ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
        </div>
    <?php endif; ?>
</body>

</html>