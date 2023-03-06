<?php
require_once('../Classes/Filliere.php');
$filiere = new Filliere();
include 'header.php';
if (!empty($CAdmin)) {
    $filiers = $filiere->show_Filliers();
?>
    <style>
        .card_container {
            margin-top: 5%;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            place-items: center;
            justify-content: space-around;

        }

        .card {
            width: 40%;
            height: 200px;
            margin-left: 5%;
            background-color: #ECEEFF;
            text-align: center;
            padding-top: 40px;
            margin-bottom: 30px;
            border-radius: 20px;
        }

        .card_head {
            width: 90%;
            height: 60px;
            margin-top: -20px;
            margin-bottom: 10px;
            background-color: #2C74F7;
            padding-top: 50px;
            border-radius: 20px 20px 0 0;
            text-align: center;
            color: white;
            font-weight: bold;
        }

        h1 {
            margin-left: 20px;
            font-size: 30px
        }
    </style>
    <h1>Nombre d'inscreptions pour chaque Filiere: </h1>

    <div class="card_container">
        <?php foreach ($filiers as $Filier) { ?>
            <div class="card">
                <p class="card_head"><?php echo $Filier['filiere'] ?></p>
                <h4>Nombre d'inscreption: <?php echo $filiere->get_FilierCount($Filier['id_dept'])['NI']; ?></h4>
            </div>
        <?php } ?>
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