<!doctype HTML>
<html>
    <head> 

    </head>

    <form action="/form.php" method="POST">
        <input type="text" name="number1" placeholder="Number 1" />
        <input type="text" name="number2" placeholder="Number 2" />
        <input type="submit" name="submit" />
    </form> 

    <?php 
        if($_POST['number1'] && $_POST['number2']) {
            print "✅ Sum equals: " . $_POST['number1'] + $_POST['number1'] . "\n";
        }
    ?>

</html>