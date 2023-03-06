<?php
session_start();
$CAdmin = $_SESSION['login'];
require_once('../Classes/Admin.php');
$db = new Admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/pageAdmin.css">
    <title>Admin-ESTS</title>
</head>

<body>
    <header class="header_nav">
        <div class="logo_admin">
            <img src="../images/administrator.png" alt="Default Admin">
            <h3>Admin</h3>
        </div>
        <div>
            <a href="index.php"><img src="../images/deconnecter.png" alt="Deconnecter" /></a>
        </div>
    </header>
    <div class="body_container">
        <div class="navbar">

            <ul class="links">
                <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'principale.php') echo 'SelectedLink'; ?>"><a href="principale.php"> <img src="../images/home.png" alt="home" />
                        <span>Accueille</span>
                    </a>
                </li>
                <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'Admins.php') echo 'SelectedLink'; ?>"> <a href="Admins.php"><img src="../images/Admins.png" alt="pen" />
                        <span>Admins</span>
                    </a>
                </li>
                <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'EtuInscrit.php') echo 'SelectedLink'; ?>"><a href="EtuInscrit.php"><img src="../images/pen.png" alt="pen" />
                        <span>Etudiant Inscrit</span>
                    </a>
                </li>
                <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'Filliers.php') echo 'SelectedLink'; ?>"><a href="Filliers.php"><img src="../images/people.png" alt="group" />
                        <span>Filliers</span>
                </li>
                <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'DateFin.php') echo 'SelectedLink'; ?>"><a href="DateFin.php"><img src="../images/calendar.png" alt="date" />
                        <span>Fin d'inscreption</span>
                    </a>
                </li>
                <li class="<?php if (basename($_SERVER['PHP_SELF']) == 'Listes.php') echo 'SelectedLink'; ?>"><a href="Listes.php"><img src="../images/list.png" alt="list" />
                        <span>Listes</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content">