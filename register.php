<?php

require_once "config.php";


$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["username"]))) {
        $username_err = "Wpisz E-mail";
    } else {

        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_username);


            $param_username = trim($_POST["username"]);


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Taki użytkownik już istnieje.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Coś poszło nie tak";
            }


            mysqli_stmt_close($stmt);
        }
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Wpisz hasło.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Hasło musi miec wiecej niż 6 znaków.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Prosze podtwierdzić Hasło.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Hasła nie pasuja do siebie.";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {


        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);


            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);


            if (mysqli_stmt_execute($stmt)) {
                $_SESSION["loggedin"] = true;
                if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {

                    $log_sc = '<span style="display:block"class="alert alert-success">Zarejestrowano pomyślnie!</span>';
                }
            } else {
                echo "Cos poszło nie tak";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="wrapper">
        <h2>Rejestracja</h2>
        <p class="parag">Uzupełnij pola aby się zarejestrować</p>
        <?php if (isset($log_sc)) {
            echo $log_sc;
        } ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Hasło</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Potwierdz Hasło</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Zarejestruj sie">
                <input type="reset" class="btn btn-secondary ml-2" value="Wyczyść">
            </div>
            <p>Masz konto? <a href="login.php">Zaloguj się</a>.</p>


        </form>
    </div>
</body>

</html>