<?php
$userName = '';

//creating header
$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);

// check if  request is sent 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //getting username from form 
    $userName = $_POST['userName'];

    //declaring variables of url-s
    $reposUrl = 'https://api.github.com/users/' . $userName . '/repos' . '?page=1&per_page=100';
    $followersUrl = "https://api.github.com/users/$userName/followers" . '?page=1&per_page=100';
    //getting and decoding json 
    $reposData = file_get_contents($reposUrl, false, $context);
    $reposDecoded = json_decode($reposData, true);
    $followersData = file_get_contents($followersUrl, false, $context);
    $followersDecoded = json_decode($followersData, true);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./assets/css/main.css">
</head>

<body>
    <form action="" method="post">
        <input type="text" name="userName" id="userName" placeholder="enter username">
        <button type="submit">fetch data</button>
    </form>
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <div class="output">
            <table class="repos">
                <thead>
                    <tr>
                        <th>repository</th>
                        <th>description</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($reposDecoded as $dec) : ?>
                        <tr>
                            <td> <a href="<?php echo $dec['html_url'] ?> " class="repo_name"><?php echo $dec['name'] ?></a></td>
                            <td class="repo_description"><?php echo $dec['description'] ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <table class="followers">
                <thead>
                    <tr>
                        <th>follower icon</th>
                        <th>follower username</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($followersDecoded as $followers) : ?>
                        <tr>
                            <td class="follower_img"><?php echo '<a href="' . $followers['html_url'] . '">' . '<img src ="' . $followers['avatar_url'] . '" > </a>' ?> </td>
                            <td class="follower_name"><?php echo $followers['login'] ?> </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>

        </div>
    <?php endif; ?>
</body>

</html>