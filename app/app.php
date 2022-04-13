<?php

session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;


}

require_once "../config.php";
$loginn = $_SESSION["username"];
$valuees = @$_POST['wynik'];


    $sql2 = "UPDATE users SET Objetosc_kuli = $valuees WHERE username = '$loginn'";
    $resultat = $link->query($sql2);
     $positive = '<span style="display:block" id="close" class="alert alert-success">Wynik zapisany w bazie danych!</span>';


?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<script src="script.js" type="text/javascript">
</script>

<body>

    <div class="wrapper">
        <h2>Objętość Kuli</h2>
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
        <p class="parag">Uzupełnij pole.</p>
        <?php  if($resultat == true){
            echo $positive;
        }
        ?>
        <center><img src="img/images.png"></center>

        <div class="form-group">
            <form action="" method="POST">


                <label>Podaj promień Kuli</label>
                <input type="text" id="promien" class="form-control">
                <span class="invalid-feedback"></span>



                <input style="margin-top:10px" placeholder="Wynik:" type="text" id="wynik" name="wynik" class="form-control">
        </div>
        <div class="form-group">
            <input type="button" class="btn btn-primary" value="Oblicz" id="chuj" onclick="calc()">
            <input type="submit" class="btn btn-secondary ml-2" id="zapisz" value="Zapisz">


        </div>
        </form>
        <div class="logout">
            <p><a id="logout" href="../logout.php">Wyloguj</a></p>
        </div>

    </div>


</body>

</html>