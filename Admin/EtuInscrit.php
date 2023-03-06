<?php
require_once('../Classes/Etudiant.php');
$Etuu = new Etudiant();
require_once('../Classes/Filliere.php');
$filiere = new Filliere();
include 'header.php';
if (!empty($CAdmin)) {
    $id_dept = "";
    if (isset($_POST['submit'])) {
        $id_dept = $_POST['filliere'];
        $Etudiants = $Etuu->get_Students($id_dept);
    } else {
        $Etudiants = $Etuu->get_Students();
    }
?>
    <style>
        .btn_ajouter {
            position: absolute;
            right: 30px;
            cursor: pointer;
            padding: 10px;
            background-color: #009BBD;
            color: white;
            border-radius: 10px;
            font-weight: bold;
        }

        .Selected_Ch {
            position: absolute;
            right: 150px;
            width: 200px;
            font-size: 1.2em;
            padding: 8px;

        }

        .Selected_choix {
            position: relative;
            width: 100%;
            height: 10%;
        }

        .profile {
            width: 100px;
            height: 100px;
        }

        .eye {
            width: 30px;
            height: 30px;
        }

        .show_btn {
            background-color: transparent;
            border: none;
        }

        .show_btn:hover {
            background-color: #A6ACE3;
        }
    </style>


    <div class="Selected_choix">
        <form action="" method="post">
            <select class="Selected_Ch" name="filliere" id="filliere">
                <option value="-1" selected>-- tout--</option>
                <?php $Filiers = $filiere->show_Filliers();
                foreach ($Filiers as $Filier) { ?>
                    <option <?php if ($id_dept && $id_dept == $Filier['id_dept']) echo 'selected'; ?> value="<?php echo $Filier['id_dept'] ?>"><?php echo $Filier['filiere'] ?></option>
                <?php
                }
                ?>
            </select>
            <input class="btn_ajouter" type="submit" value="Afficher" name="submit">

        </form>
    </div>
    <div class="tableau">
        <table id="table-id" class="table2">
            <thead>
                <tr>
                    <th>photo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>CNI</th>
                    <th>CNE</th>
                    <th>Addresse</th>
                    <th>Ville</th>
                    <th>Date Naissance</th>
                    <th>Note</th>
                    <?php
                    if (!empty($Etudiants[0]['id_dept'])) { ?>
                        <th>Filiere</th>
                    <?php
                    }
                    ?>
                    <th>Action</th>
                </tr>

            </thead>
            <tbody>
                <?php
                foreach ($Etudiants as $Etudiant) {

                    echo "<tr>";
                ?>
                    <td><img class="profile" src="../Etudiant/<?php echo $Etudiant['photo']; ?>"></td>
                    <td><?php echo $Etudiant['nom']; ?> </td>
                    <td><?php echo $Etudiant['prenom']; ?></td>
                    <td><?php echo $Etudiant['CIN']; ?></td>
                    <td><?php echo $Etudiant['CNE']; ?></td>
                    <td><?php echo $Etudiant['adresse']; ?></td>
                    <td><?php echo $db->Get_ville($Etudiant['id_ville'])['ville']; ?></td>
                    <td><?php echo $Etudiant['date_N']; ?></td>
                    <td><?php echo $Etudiant['note_national'] * 0.75 + $Etudiant['note_regional'] * 0.25 ?></td>
                    <?php if (!empty($Etudiant['id_dept'])) { ?>
                        <td>
                            <?php $filier = $filiere->get_Filier($Etudiant['id_dept']);
                            echo $filier['filiere'];
                            ?>
                        </td>
                    <?php } ?>
                    <td>
                        <form action="EtudiantInfo.php" method="post">
                            <input type="text" name="id_Etu" value="<?php echo $Etudiant['id_insc'] ?>" hidden>
                            <button class="show_btn" type="submit" name="show"><img class="eye" src="../images/eye.png" alt=""></button>
                        </form>
                    </td>
                <?php
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </div>

    </div>

    </body>

    </html>
<?php
} else {
    header('location:index.php');
}
?>