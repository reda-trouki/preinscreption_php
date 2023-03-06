<?php
require_once('../Classes/Filliere.php');
$filiere = new Filliere();
include 'header.php';
if (!empty($CAdmin)) {
    if (isset($_POST['Modifier'])) {
        $id = $_POST['id_dept'];
        $filier = $_POST['filier'];
        $places = $_POST['places'];
        $filiere->Modifier_Filier($filier, $places, $id);
    }
    if (isset($_POST['Ajouter'])) {
        $filiere = $_POST['filiere'];
        $places = $_POST['places'];
        $filiere->Ajouter_Fillier($filiere, $places);
    }
    if (isset($_POST['AjouterCoeff'])) {
        $id_dept = $_POST['id_dept'];
        $TypeBac = $_POST['Type_bac'];
        $coefficient = $_POST['coefficient'];
        $db->Add_Coefficient($id_dept, $TypeBac, $coefficient);
    }
    $Filiers = $filiere->show_Filliers();
    $Types = $db->get_types();
?>
    <style>
        .Filiers {
            margin: 0 auto;
            width: 100%;
            margin-top: 5%;
            display: flex;
            flex-wrap: wrap;
            align-items: center;

        }

        .Filier_S {
            background-color: #F7F8FF;
            padding: 30px;
            font-size: 36px;
            border-radius: 15px;
            margin-bottom: 20px;
            width: 40%;
            -moz-box-shadow: -1px 7px 40px -4px rgba(46, 42, 42, 0.82);
            -webkit-box-shadow: -1px 7px 40px -4px rgba(46, 42, 42, 0.82);
            box-shadow: -1px 7px 40px -4px rgba(46, 42, 42, 0.82);
        }

        .popup-box,
        .popup-box2 {
            width: 30%;
            background-color: #F7F8FF;
            padding: 30px;
            font-size: 36px;
            position: absolute;
            top: 50%;
            left: 55%;
            transform: translate(-50%, -50%);
            border-radius: 10px;
            display: none;
            z-index: 2;
            opacity: 1;
            -moz-box-shadow: -1px 7px 40px -4px rgba(46, 42, 42, 0.82);
            -webkit-box-shadow: -1px 7px 40px -4px rgba(46, 42, 42, 0.82);
            box-shadow: -1px 7px 40px -4px rgba(46, 42, 42, 0.82);
        }

        .popup-box span,
        .popup-box2 span {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 20px;
            height: 20px;
            background-color: red;
            color: white;
            padding: 5px;
            border-radius: 50%;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }

        form {
            margin-top: 10px;
            width: 100%;
            display: block;
        }

        form>label,
        form>input,
        select {
            width: 100%;
            height: 40px;
            font-size: 20px;
            border-radius: 5px;
        }

        form>input,
        select {
            border: 1px solid #000;
        }

        form>input:focus,
        form>input:active {
            outline: 1px solid #2C74F7;
        }

        form>label {
            font-weight: bold;
        }

        form input[type="submit"] {
            margin-top: 20px;
            background-color: #2C74F7;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
        }

        .FilierHeader {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            background-color: #7069E6;
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .Modifier_btn {
            width: 40%;
            background-color: #009ABA;
            cursor: pointer;
            border: 1px solid black;
            color: #fff;
            border-radius: 5px;
            font-weight: bold;
            padding: 5px;
        }

        .Ajouter_F {
            margin: 0 auto;
            margin-left: 15%;
            width: 80%;
            height: 10%;
            display: flex;
            align-items: center;
        }

        .Ajouter_F form {
            width: 100%;
        }

        .Ajouter_F form input[type="text"] {
            width: 30%;
        }

        .Ajouter_F form input[type="submit"] {
            width: 20%;
        }
    </style>
    <div class="Ajouter_F">
        <form action="" method="post">
            <input type="text" name="filiere" placeholder="Nom de Filiere" />
            <input type="text" name="places" placeholder="Nombre des places" />
            <input type="submit" value="Ajouter" name="Ajouter">
        </form>
    </div>
    <div class="Filiers">
        <?php foreach ($Filiers as $Filier) { ?>
            <div class="Filier_S">
                <h2 class="FilierHeader"><?php echo $Filier['filiere'] ?></h2>
                <h3>Nombre des places: <?php echo $Filier['places'] ?></h3>
                <div>
                    <h3>Notes Apogé pour chaque Type de bac: </h3>
                    <?php foreach ($Types as $Type) { ?>
                        <div>
                            <?php echo $Type['type_bac'] . ': ' ?>
                            <?php $coefficient = $db->get_coefficient($Filier['id_dept'], $Type['id_type_bac']);
                            if ($coefficient) {
                                echo '<b>' . $coefficient['not_apoge'] . '</b>';
                            } else {
                                echo " ";
                            } ?>
                        </div>
                    <?php } ?>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:10px;">
                    <input type="submit" value="Modifier" class="Modifier_btn" onclick="poPup(<?php echo $Filier['id_dept'] . ',\'' . $Filier['filiere'] . '\',' . $Filier['places'] ?>);">
                    <input style="background-color:#444655;" class="Modifier_btn" type="submit" value="Ajoueter coefficients" onclick="popUp2(<?php echo $Filier['id_dept']; ?>)">
                </div>

            </div>

        <?php } ?>
    </div>

    </div>
    <div class="popup-box">
        <form action="" method="post">
            <input type="text" id="id_dept" name="id_dept" value="" hidden>
            <label for="filier">Nom Filier:</label>
            <input type="text" id="filier" name="filier" value="" />
            <label for="places">Nombre des Places:</label>
            <input type="text" id="places" name="places" value="" />
            <input type="submit" value="Modifier" name="Modifier" />
        </form>
        <span id="close">X</span>
    </div>
    <div class="popup-box2">
        <form action="" method="post">
            <input type="text" value="" hidden id="id_dd" name="id_dept">
            <label for="Tbac">Type de Bac: </label>
            <select name="Type_bac" id="Tbac">
                <option selected disabled>--Type de bac--</option>
                <?php foreach ($Types as $Type) { ?>
                    <option value="<?php echo $Type['id_type_bac'] ?>"><?php echo $Type['type_bac']; ?></option>
                <?php } ?>
            </select>
            <label for="coef">Note apoge: </label>
            <input type="text" name="coefficient" id="coeff">
            <input type="submit" value="Ajouter" name="AjouterCoeff" />
        </form>
        <span id="close2">X</span>
    </div>
    </div>
    <script>
        let myPopup = document.querySelector(".popup-box");
        let myPopup2 = document.querySelector(".popup-box2");
        let btnClose = document.querySelector("#close");
        let btnClose2 = document.querySelector("#close2");
        let id = document.querySelector('#id_dept');
        let id2 = document.querySelector('#id_dd');
        let filier = document.querySelector('#filier');
        let place = document.querySelector('#places');
        let body = document.querySelector('.content');

        function poPup(dept, filiers, places) {
            myPopup.style.display = "block";
            id.setAttribute("value", dept);
            filier.setAttribute("value", filiers);
            place.setAttribute("value", places);
            body.style.opacity = "0.5";
            body.style.background = "grey";
        }

        function popUp2(dept) {
            myPopup2.style.display = "block";
            id2.setAttribute("value", dept);
            body.style.opacity = "0.5";
            body.style.background = "grey";
        }
        btnClose.onclick = function() {
            myPopup.style.display = "none";
            body.style.opacity = "1";
            body.style.background = "white";
        };
        btnClose2.onclick = function() {
            myPopup2.style.display = "none";
            body.style.opacity = "1";
            body.style.background = "white";
        }
    </script>
    </body>

    </html>
<?php
} else {
    header('location:index.php');
}
?>