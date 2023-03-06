	<?php
	session_start();
	session_destroy();
	session_start();
	require_once("../Classes/Etudiant.php");
	$bd = new Etudiant();
	$e = array();
	$erreur = "";
	$erreur_cl = "";

	/*****************************Inscription******************************/
	if (isset($_POST['forminscription'])) {
		$cne = htmlspecialchars($_POST['cne']);
		$email = htmlspecialchars($_POST['email']);
		$mdp = sha1($_POST['mdp']);
		$e = $bd->creation_compte($cne, $email, $mdp);
		$erreur = $e[0];
		$erreur_cl = $e[1];
	}
	/*****************************Connection******************************/
	if (isset($_POST['Connecter'])) {
		$email = htmlspecialchars($_POST['connect_mail']);
		$pass = htmlspecialchars($_POST['connect_password']);
		$e = $bd->connecter($email, $pass);
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
		<link rel="stylesheet" href="../styles/style.css">
		<link rel="icon" href="../images/estsIcon.png" type="image/x-icon">
		<title>ESTS-inscreption</title>
	</head>

	<body>
		<div class="left_side">
			<img src="../images/fillForm.png" alt="fill_form_logo">
		</div>
		<div class="right_side">
			<div class="connect_form">
				<form method="post" action="index.php" id="form1">
					<div class="icon_container">
						<img src="../images/user.png" id="icon" alt="Etudiant Icon" />
					</div>
					<div class="inputbox">
						<input type="email" placeholder=" " name="connect_mail" required="required">
						<span>E-mail</span>
					</div>
					<div class="inputbox">
						<input type="password" placeholder=" " name="connect_password" id="password1" required="required">
						<span>mot de passe</span>
					</div>
					<div class="affiche_mot">
						<input type="checkbox" onclick="show_pass('password1')" class="affiche_pass" name="affiche_pass" value="aff_pass">
						<label for="afiche_pass"> afficher le mot de passe</label><br>
					</div>
					<div class="inputbox">
						<input type="submit" name="Connecter" value="Connexion">
					</div>
					<div class="inputbox">
						<input type="button" value="Sinscrire" onclick="creer_compte()">
					</div>
				</form>
				<form method="post" action="" id="form2" hidden>
					<div class="icon_container">
						<img src="../images/user.png" id="icon" alt="Etudiant Icon" />
					</div>
					<div class="inputbox">
						<input type="text" placeholder=" " name="cne" required="required">
						<span>CNE</span>
					</div>
					<div class="inputbox">
						<input type="email" placeholder=" " name="email" required="required">
						<span>E-mail</span>
					</div>
					<div class="inputbox">
						<input type="password" placeholder=" " name="mdp" id="password2" required="required">
						<span>mot de passe</span>
					</div>
					<div class="affiche_mot">
						<input type="checkbox" onclick="show_pass('password2')" id="affiche_pass" class="affiche_pass" name="affiche_pass" value="aff_pass">
						<label for="afiche_pass"> afficher le mot de passe</label><br>
					</div>
					<div class="inputbox">
						<input type="submit" name="forminscription" value="créer un compte">
					</div>
					<div class="inputbox">
						<input type="button" value="Connexion" onclick="connecter()">
					</div>



				</form>

				<?php
				/*******************Show erreur toast**********************/
				if (isset($erreur)) {
					echo '<div id="snackbar" style="background-color:' . $erreur_cl . ';" >' . $erreur . '</div>';
				}
				?>
			</div>
		</div>
		<script>
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

			let form1 = document.querySelector("#form1");
			let form2 = document.querySelector("#form2");

			function show_pass(targetId) {
				var pass = document.getElementById(targetId);
				if (pass.type === "password") {
					pass.type = "text";
				} else {
					pass.type = "password";
				}
			}

			function creer_compte() {
				form1.style.display = "none";
				if (form2.hasAttribute("hidden"))
					form2.removeAttribute("hidden");
				form2.style.display = "block";
			}

			function connecter() {
				form2.style.display = "none";
				form1.style.display = "block";
			}
		</script>
	</body>

	</html>