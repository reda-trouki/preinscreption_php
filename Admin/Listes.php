<?php
require_once('../Classes/Filliere.php');
$filiere = new Filliere();
require_once('../Classes/Liste.php');
$li = new Liste();
include 'header.php';
if (!empty($CAdmin)) {
    $Filiers = $filiere->show_Filliers();
    $Types = $db->get_types();
    $listes = $li->get_Liste(1);
    $fili = "GI";
    $id_dept = 1;
    foreach ($Filiers as $Filier) {
        if (isset($_POST[$Filier['filiere']])) {
            $id_dept = $_POST['idFil'];
            $fili = $Filier['filiere'];
            $listes = $li->get_Liste($id_dept);
        }
    }

?>
    <style>
        .choix_FL {
            width: 100%;
            height: 5%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 1%;
        }

        .button_n {
            width: 140px;
            height: 50px;
            border: none;
            border-bottom: 1px solid black;
            background-color: white;
            font-weight: bold;
            cursor: pointer;

        }

        .show {
            width: 140px;
            height: 50px;
            border: none;
            background-color: white;
            font-weight: bold;
            cursor: pointer;
            background-color: #2C74F7;
            color: #fff;
            border-bottom: 2px solid white;
            text-align: center;
        }

        .profile {
            width: 100px;
            height: 100px;
        }

        .btns_pdf {
            display: flex;
            width: 100%;
            margin-top: 20px;
        }

        .btn1,
        .btn2 {
            color: white;
            height: 50px;
            border: 1px solid grey;
            border-radius: 10px;
            cursor: pointer;
        }

        .btn1 {
            background-color: #2C74F7;

        }

        .btn2 {
            background-color: grey;

        }
    </style>
    <div class="choix_FL">
        <?php foreach ($Filiers as $Filier) { ?>
            <div>
                <form action="" method="post">
                    <input type="text" name="idFil" hidden value="<?php echo $Filier['id_dept'] ?>">
                    <input type="submit" <?php if ($fili == $Filier['filiere']) {
                                                echo 'class="show';
                                            } else {
                                                echo 'class="button_n"';
                                            } ?> id="<?php echo $Filier['filiere'] ?>" value="<?php echo $Filier['filiere'] ?>" name="<?php echo $Filier['filiere'] ?>">
                </form>

            </div>

        <?php } ?>
    </div>
    <div style="margin-top:30px;">
        <h1>Liste des Etudiant Inscrit Dans <?php echo $fili; ?> Par Ordre de (Note Regionale*25% + Note Nationale *75%) * Note d'apoge:</h1>
    </div>
    <div class="btns_pdf">
        Telecharger PDF:
        <form action="listePrincipale.php" method="GET">
            <input type="text" name="filiere" value="<?php echo $id_dept; ?>" hidden>
            <input type="submit" value="Liste Principale" class="btn1">
        </form>
        <form action="liste_Attente.php" method="GET">
            <input type="text" name="filiere" value="<?php echo $id_dept; ?>" hidden>
            <input type="submit" value="Liste d'Attente" class="btn2">
        </form>
    </div>
    <div class="tableau">
        <table id="produit">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>CNI</th>
                    <th>CNE</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Bac</th>
                    <th>Note</th>

                </tr>

            </thead>
            <tbody>
                <?php foreach ($listes as $liste) { ?>
                    <tr>
                        <td>
                            <img class="profile" src="<?php echo '../Etudiant/' . $liste['photo'] ?>" alt="">
                        </td>
                        <td>
                            <?php echo $liste['CIN']; ?>
                        </td>
                        <td>
                            <?php echo $liste['CNE']; ?>
                        </td>
                        <td>
                            <?php echo $liste['nom']; ?>
                        </td>
                        <td>
                            <?php echo $liste['prenom']; ?>
                        </td>
                        <td>
                            <?php echo $db->get_bac($liste['id_TypeBac'])['type_bac']; ?>
                        </td>
                        <td>
                            <?php echo number_format($liste['note'], 2, ',', ''); ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>
    </body>

    </html>
<?php
} else {
    header('location:index.php');
}
?>