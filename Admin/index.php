<?php
session_start();
session_destroy();
session_start();
require_once('../Classes/Admin.php');
$db = new Admin();
$e = array();
$erreur = "";
$erreur_cl = "";
if (isset($_POST['connecter'])) {
    $login = htmlspecialchars($_POST['login']);
    $pass = htmlspecialchars($_POST['password']);
    $_SESSION['login'] = $login;
    $e = $db->connecter($login, $pass);
    $erreur = $e[0];
    $erreur_cl = $e[1];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/admin_styles.css" />
    <title>Admin-ESTS</title>
</head>

<body>
    <?php
    /*******************Show erreur toast**********************/
    if (isset($erreur)) {
        echo '<div id="snackbar" style="background-color:' . $erreur_cl . ';" >' . $erreur . '</div>';
    }
    ?>
    <div class="wrapper fadeInDown">

        <div id="formContent">
            <!-- Tabs Titles -->
            <h2 class="active"> Bienvenue dans l'espace d'admin</h2>
            <!-- Icon -->
            <div class="fadeIn first">
                <img src="../images/administrator.png" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form action="index.php" method="post">
                <input type="text" id="login" class="fadeIn second" name="login" placeholder="Login" />
                <input type="password" id="password" class="fadeIn third" name="password" placeholder="Mot de passe" />
                <div class="affiche_mot fadeIn third">
                    <input type="checkbox" onclick="show_pass('password')" class="affiche_pass" name="affiche_pass" value="aff_pass">
                    <label for="afiche_pass"> afficher le mot de passe</label><br>
                </div>
                <input type="submit" class="fadeIn fourth" value="Connecter" name="connecter" />
            </form>

            <!-- Login Footer -->
            <div id="formFooter">
                &copy Copyright 2022-2023
            </div>

        </div>
    </div>

    <script>
        function show_pass(targetId) {
            var pass = document.getElementById(targetId);
            if (pass.type === "password") {
                pass.type = "text";
            } else {
                pass.type = "password";
            }
        }

        function show_toast() {
            var error = <?php echo json_encode($erreur); ?>;
            let toast = document.getElementById('snackbar');
            console.log(toast)
            if (error) {
                toast.setAttribute("class", "show");
            }
            setTimeout(function() {
                toast.removeAttribute("class")
            }, 3000);

        }

        show_toast();
    </script>
</body>

</html>