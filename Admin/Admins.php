<?php

include 'header.php';
if (!empty($CAdmin)) {
$Type_Admin = $db->get_AdminType($CAdmin);
if (isset($_POST['Ajouter_A'])) {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $login = htmlspecialchars($_POST['Login']);
    $password = htmlspecialchars($_POST['Password']);
    $type = htmlspecialchars($_POST['type']);
    $db->Ajouter_Admin($nom, $prenom, $login, $password, $type);
    header('Location:Admins.php?valid');
}
if (isset($_POST['Supprimer'])) {
    $id_A = $_POST['id_A'];
    $db->Delete_Admin($id_A);
}
if (isset($_POST['Modifier_A'])) {
    $id_A = htmlspecialchars($_POST['id_A']);
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $login = htmlspecialchars($_POST['Login']);
    $password = htmlspecialchars($_POST['Password']);
    $type = htmlspecialchars($_POST['type']);
    $db->Modifier_Admin($id_A, $nom, $prenom, $login, $password, $type);
}
$Admins = $db->show_admins();
?>
<style>
    .popup-box {
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

    .popup-box span {
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

    form input:last-child {
        margin-top: 20px;
        background-color: #2C74F7;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }

    .btn_ajouter {
        position: absolute;
        right: 50px;
        cursor: pointer;
        padding: 10px;
        background-color: #009BBD;
        color: white;
        border-radius: 10px;
        font-weight: bold;
    }
</style>

<?php if ($Type_Admin[0] == 'sup') { ?>
    <div style="position:relative;">
        <p class="btn_ajouter" onclick="poPup();">Ajouter<span>+</span></p>
    </div>
<?php } ?>
<div class="tableau">
    <table id="produit">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Login</th>
                <th>Type</th>
                <th colspan="2">Action</th>


            </tr>

        </thead>
        <tbody>
            <?php
            foreach ($Admins as $Admin) {

                echo "<tr>";
            ?>
                <td><?php echo $Admin['nom']; ?></td>
                <td><?php echo $Admin['prenom']; ?> </td>
                <td><?php echo $Admin['login']; ?></td>
                <td><?php echo $Admin['type']; ?></td>

                <td><?php if ($Type_Admin[0] == 'sup') {  ?>

                        <button class="btn_action" type="submit" name="Modifier" onclick="poPup(<?php echo $Admin['id_admin'] . ',\'' . $Admin['nom'] . '\',\'' . $Admin['prenom'] . '\',\'' . $Admin['login'] . '\',' . $Admin['password'] . ',\'' . $Admin['type'] . '\''; ?>);">
                            <img class=" trash" src="../images/edit.png" alt="Modifier">
                        </button>

                    <?php } ?>
                </td>
                <td>
                    <?php if ($Type_Admin[0] == 'sup') {  ?>
                        <form action="" method="post">
                            <input type="text" value="<?php echo $Admin['id_admin']  ?>" hidden name="id_A">
                            <button class="btn_action" type="submit" name="Supprimer">
                                <img class="trash" src="../images/trash.png" alt="Supprimer">
                            </button>
                        </form>
                    <?php } ?>
                </td>


            <?php
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
</div>
<div class="popup-box">
    <h1 id="headAdmin">Ajouter Admin</h1>
    <form action="" method="post">
        <input type="text" name="id_A" id="id_A" hidden>
        <label for="Nom">Nom:</label>
        <input type="text" id="Nom" name="nom" />
        <label for="Prenom">Preom:</label>
        <input type="text" id="Prenom" name="prenom" />
        <label for="Login">Login:</label>
        <input type="text" id="Login" name="Login" />
        <label for="Password">Password:</label>
        <input type="text" id="Password" name="Password" />
        <label for="Type">Type d'admin:</label>
        <select name="type" id="Type" value="sup">
            <option selected disabled>--Type d'admin--</option>
            <option id="option1" value="sup">Admin Superieur</option>
            <option id="option2" value="normal">Admin Normal</option>
        </select>
        <input type="submit" value="Ajouter" name="Ajouter_A" id="Btn_Action" />
    </form>
    <span id="close">X</span>
</div>
<script>
    let myPopup = document.querySelector(".popup-box");
    let btnClose = document.querySelector("#close");
    let body = document.querySelector('.content');
    let headAdmin = document.querySelector('#headAdmin');
    let id_Admin = document.querySelector('#id_A');
    let nom = document.querySelector('#Nom');
    let prenom = document.querySelector('#Prenom');
    let login = document.querySelector('#Login');
    let pass = document.querySelector('#Password');
    let option1 = document.querySelector('#option1');
    let option2 = document.querySelector('#option2');
    let btn_A = document.querySelector('#Btn_Action');

    function poPup(idA = "", nomA = "", prenomA = "", loginA = "", passwordA = "", typeA = "") {
        myPopup.style.display = "block";
        body.style.opacity = "0.5";
        if (idA != "") {
            headAdmin.innerHTML = 'Modifier Admin';
            btn_A.setAttribute('value', 'Modifier');
            btn_A.setAttribute('name', 'Modifier_A');
        } else {
            headAdmin.innerHTML = 'AjouterAdmin';
            btn_A.setAttribute('value', 'Ajouter');
            btn_A.setAttribute('name', 'Ajouter_A');
        };
        if (option1.getAttribute('value') == typeA) {
            console.log(option1.getAttribute('value'));
            option1.setAttribute('selected', "");
            option2.removeAttribute('selected');
        } else if(option2.getAttribute('value') == typeA) {
            option2.setAttribute('selected', "");
            option1.removeAttribute('selected');
        }
        id_Admin.setAttribute('value', idA);
        nom.setAttribute('value', nomA);
        prenom.setAttribute('value', prenomA);
        login.setAttribute('value', loginA);
        pass.setAttribute('value', passwordA);
        body.style.background = "grey";
    }

    btnClose.onclick = function() {
        myPopup.style.display = "none";
        body.style.opacity = "1";
        body.style.background = "white";
    };
</script>
</body>

</html>
<?php
}else{
    header('location:index.php');
}
?>