<?php
require_once('../Classes/Documents.php');
require_once('../Classes/Etudiant.php');
$Etuu = new Etudiant();
$document = new Documents();
include 'header.php';
if (isset($_POST['show'])) {
    $Etudiant = $_POST['id_Etu'];
    $EtuInfo = $Etuu->getEtudiant($Etudiant);
}
?>
<style>
    .back {
        text-decoration: none;
        color: black;
        font-size: 50px;
        font-weight: bold;
        margin-top: 20px;
        width: 5%;

    }

    .back img {
        width: 80px;
        height: 50px;
        background-color: #00C6CF;
        padding: 10px;
        border-radius: 10px;
    }

    .image_pr {
        width: 20%;
        height: 200px;
        position: relative;
    }

    .image_pr img {
        width: 80%;
        position: absolute;
        left: 2%;
    }

    .info {
        width: 80%;
    }

    .info_content {
        margin: 50px auto;
        display: flex;
        width: 100%;
    }

    .link {
        text-decoration: none;
        color: #000;
    }

    .link:hover,
    .link span {
        color: red;
    }
</style>
<div style="width:100%;">
    <a class="back" href="EtuInscrit.php">
        <img src="../images/arrow.png" alt=""> </a>
</div>
<div class="info_content">
    <div class="image_pr">
        <img src="../Etudiant/<?php echo $EtuInfo['photo'] ?>" alt="">
    </div>
    <div class="info">
        <div><b>Nom:</b> <?php echo $EtuInfo['nom'] ?></div>
        <div><b>Preom:</b> <?php echo $EtuInfo['prenom'] ?></div>
        <div><b>Date de Naissance:</b> <?php echo $EtuInfo['date_N'] ?></div>
        <br />
        <div><b>CIN:</b> <?php echo $EtuInfo['CIN'] ?></div>
        <div><b>CNE:</b> <?php echo $EtuInfo['CNE'] ?></div>
        <br />
        <div><b>Adresse:</b> <?php echo $EtuInfo['adresse'] ?></div>
        <div><b>Ville:</b> <?php echo $db->Get_ville($EtuInfo['id_ville'])['ville']; ?></div>
        <br />
        <div><b>Note Regionale:</b> <?php echo $EtuInfo['note_regional'] ?></div>
        <div><b>Note Nationale:</b> <?php echo $EtuInfo['note_national'] ?></div>
        <div><b>Note Generale:</b> <?php echo $EtuInfo['note_general'] ?></div>
        <br />
        <div>
            <a class="link" href="../Etudiant/<?php echo $document->getDocuments('CIN', $EtuInfo['id_insc']) ?>">
                <h1> CIN <span>pdf</span>---></h1>
            </a>
            <a class="link" href="../Etudiant/<?php echo $document->getDocuments('Releve Not', $EtuInfo['id_insc']) ?>">
                <h1> Releve de Note <span>pdf</span>---></h1>
            </a>
            <a class="link" href="../Etudiant/<?php echo $document->getDocuments('Bac', $EtuInfo['id_insc']) ?>">
                <h1> Bac <span>pdf</span>---></h1>
            </a>
        </div>
    </div>
</div>
</div>
</div>
</body>

</html>