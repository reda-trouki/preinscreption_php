<?php

session_start();
$CNE = $_SESSION['CNE'];
if (!empty($CNE)) {
    require_once('../Classes/Documents.php');
    $document = new Documents();
    require_once('../Classes/Filliere.php');
    $filiere = new Filliere();
    require_once("../Classes/Etudiant.php");
    $bd = new Etudiant();

    $fin = $bd->get_DateFin();
    $today = date('Y-m-d H:i:s');
    if ($today < $fin['date_fin']) {

        $e = array();
        $erreur = "";
        $erreur_cl = "";
        $cc = "";

        function upload_files($name)
        {
            if (($_FILES[$name]['name'] != "")) {
                $target_dir = "EtudiantFiles/";
                $file = $_FILES[$name]['name'];
                $path = pathinfo($file);
                $filename = $path['filename'];
                $ext = $path['extension'];
                $temp_name = $_FILES[$name]['tmp_name'];
                $path_filename_ext = $target_dir . $filename . "." . $ext;
                move_uploaded_file($temp_name, $path_filename_ext);
                //echo $path_filename_ext;
                return $path_filename_ext;
            }
        }
        if (isset($_POST['submit'])) {

            $CNI = htmlspecialchars($_POST['CNI']);
            $Nom = htmlspecialchars($_POST['nom']);
            $Prenom = htmlspecialchars($_POST['prenom']);
            $Addresse = htmlspecialchars($_POST['addresse']);
            $Region = htmlspecialchars($_POST['Region']);
            $Ville = htmlspecialchars($_POST['Ville']);
            $DN = htmlspecialchars($_POST['DN']);
            $T_bac = htmlspecialchars($_POST['Type_bac']);
            $anne_bac = htmlspecialchars($_POST['Anne_bac']);
            $NoteR = htmlspecialchars($_POST['NoteR']);
            $NoteN = htmlspecialchars($_POST['NoteN']);
            $NoteG = htmlspecialchars($_POST['NoteG']);
            $Mention = htmlspecialchars($_POST['Mention']);
            $photo_profile = 'profile_image';
            $profile = upload_files($photo_profile);
            $Choix1 = htmlspecialchars($_POST['Choix1']);
            $Choix2 = htmlspecialchars($_POST['Choix2']);

            if (!empty($profile)) {
                $Cin_doc = 'Cni_doc';
                $Releve_doc = 'Releve_doc';
                $Bac_doc = 'Bac_doc';
                /******************* */
                $Doc_CNI = upload_files($Cin_doc);
                $Doc_Releve = upload_files($Releve_doc);
                $Doc_Bac = upload_files($Bac_doc);
                $CINexist = $bd->deja_inscri($CNI, $CNE);
                if ($CINexist == 0) {
                    $e = $bd->insert_toEtudiant($CNI, $Nom, $Prenom, $CNE, $Addresse, $NoteR, $NoteN, $NoteG, $Mention, $DN, $Ville, $Region, $profile, $T_bac, $anne_bac, $Doc_CNI, $Doc_Releve, $Doc_Bac, $Choix1, $Choix2);
                    $erreur = $e[0];
                    $erreur_cl = $e[1];
                }
            } else {
                $erreur = "Choisir une image de profile";
                $erreur_cl = 'red';
            }
            /****************************************** */
        }

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../styles/formulaire_style.css">
            <link rel="icon" href="../images/estsIcon.png" type="image/x-icon">
            <title>ESTS-inscreption</title>

        </head>

        <body>
            <?php
            $data = $bd->show_etuInfo($CNE);
            if (isset($_POST['Modifier'])) {
                $CNI = htmlspecialchars($_POST['CNI']);
                $Nom = htmlspecialchars($_POST['nom']);
                $Prenom = htmlspecialchars($_POST['prenom']);
                $Addresse = htmlspecialchars($_POST['addresse']);
                $Region = htmlspecialchars($_POST['Region']);
                $Ville = htmlspecialchars($_POST['Ville']);
                $DN = htmlspecialchars($_POST['DN']);
                $T_bac = htmlspecialchars($_POST['Type_bac']);
                $anne_bac = htmlspecialchars($_POST['Anne_bac']);
                $NoteR = htmlspecialchars($_POST['NoteR']);
                $NoteN = htmlspecialchars($_POST['NoteN']);
                $NoteG = htmlspecialchars($_POST['NoteG']);
                $Mention = htmlspecialchars($_POST['Mention']);
                $photo_profile = 'profile_image';
                $profile = upload_files($photo_profile);
                $Choix1 = htmlspecialchars($_POST['Choix1']);
                $Choix2 = htmlspecialchars($_POST['Choix2']);
                /********************************************* */
                $Cin_doc = 'Cni_doc';
                $Releve_doc = 'Releve_doc';
                $Bac_doc = 'Bac_doc';
                /******************* */
                $Doc_CNI = upload_files($Cin_doc);
                $Doc_Releve = upload_files($Releve_doc);
                $Doc_Bac = upload_files($Bac_doc);
                if (empty($profile)) $profile = $data[0]['photo'];
                if (empty($Doc_Bac)) $Doc_Bac = $document->getDocuments('Bac', $data[0]['id_insc']);
                if (empty($Doc_Releve)) $Doc_Releve = $document->getDocuments('Releve Not', $data[0]['id_insc']);
                if (empty($Doc_CNI)) $Doc_CNI = $document->getDocuments('CIN', $data[0]['id_insc']);
                $test = $bd->update_Etudiant($CNI, $Nom, $Prenom, $CNE, $Addresse, $NoteR, $NoteN, $NoteG, $Mention, $DN, $Ville, $Region, $profile, $T_bac, $anne_bac, $Doc_CNI, $Doc_Releve, $Doc_Bac, $Choix1, $Choix2);
                if ($test == 0) {
                    $erreur = "inscreption a ete modifie avec success";
                    $erreur_cl = "green";
                } else {
                    $erreur = "Erreur accured!!!";
                    $erreur_cl = "red";
                }
            }
            $data = $bd->show_etuInfo($CNE);
            ?>

            <header class="header">
                <div class="logo">
                    <img src="../images/ests.png" alt="est safi logo" />
                </div>
                <div class="user_info">
                    <div class="dropdown">
                        <img onclick="show_menu()" src="<?php if ($data) {
                                                            echo './' . $data[0]['photo'];
                                                        } else {
                                                            echo '../images/defaultuser.png';
                                                        }; ?>" class="dropbtn" id="profile" alt="">
                        <div id="myDropdown" class="dropdown-content">
                            <label>
                                <b><?php echo $_SESSION['CNE']; ?></b>
                            </label>
                           
                            <a href="index.php">
                                <img src="../images/deconnecter.png" alt="">
                                deconnecter
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            <div class="info">
                <form action="<?php if ($data) {
                                    echo "formulaire.php";
                                } ?>" method="post" name="frm" id="frm" enctype="multipart/form-data">

                    <span class="image_upl">
                        <img src=<?php
                                    if ($data) {
                                        echo './' . $data[0]['photo'];
                                    } else {
                                        echo "../images/defaultuser.png";
                                    } ?> id="profile2" alt="" class="profile_image">
                        <label class="lien_telechrge" for="profileimage"><img src="../images/img_download.png" alt="" />Ajouter une Image</label>
                    </span>
                    <input <?php if ($data) echo 'value = ' . $data[0]['photo'] ?> type="file" accept="image/png,image/jpeg,image/jpg" name="profile_image" id="profileimage" onchange="affiche_img(this)" hidden />
                    <h3>Information Personnel:</h3>
                    <div class="personnel_info">
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label for="">CNE</label></div>
                                <div><input required type="text" value=<?php echo $_SESSION['CNE']; ?> disabled /></div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">CNI<span>*</span></label></div>
                                <div><input <?php if ($data) {
                                                echo "value=" . $data[0]['CIN'];
                                            } ?> required type="text" placeholder="Entrer votre CNI" name="CNI" /></div>
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Nom<span>*</span></label></div>
                                <div>
                                    <input <?php
                                            if ($data) {
                                                echo "value=" . $data[0]['nom'];
                                            } ?> required type="text" placeholder="Entrer votre Nom" name="nom" />
                                </div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Prenom<span>*</span></label></div>
                                <div><input <?php if ($data) {
                                                echo "value=" . $data[0]['prenom'];
                                            } ?> required type="text" placeholder="Entrer votre Prenom" name="prenom" /></div>
                            </div>
                        </div>

                        <div class="inputs">
                            <div class="input_gr2">
                                <div> <label class="text-label" for="">Addresse<span>*</span></label></div>
                                <div><input value="<?php
                                                    if ($data) {
                                                        echo $data[0]['adresse'];
                                                    }
                                                    ?>" required type="text" placeholder="Addresse..." class="input_big" name="addresse" /></div>
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Region<span>*</span></label></div>
                                <div>
                                    <select name="Region" id="Region" class="choix" required>
                                        <option selected disabled>--Choisir Votre Region--</option>
                                        <?php
                                        $regions = array();
                                        $result = $bd->show_region();
                                        $regions = $result->fetchAll();
                                        if (!empty($regions)) {
                                            foreach ($regions as $region) { ?>
                                                <option value="<?php echo $region['id_region']; ?>" <?php if ($data && $data[0]['id_region'] == $region['id_region']) echo "selected"; ?>><?php echo $region['region']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Ville<span>*</span></label></div>
                                <div>
                                    <select name="Ville" id="Ville" class="choix" required>
                                        <option selected disabled>--Choisir Votre Ville--</option>
                                        <?php
                                        $villes = array();
                                        $result = $bd->show_villes();
                                        $villes = $result->fetchAll();
                                        if (!empty($villes)) {
                                            foreach ($villes as $ville) { ?>
                                                <option value="<?php echo $ville['id_ville'] ?>" <?php if ($data && $data[0]['id_ville'] == $ville['id_ville']) echo "selected"; ?>><?php echo $ville['ville'] ?></option>
                                        <?php }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="input_gr2">
                                <div>
                                    <label class="text-label" for="">Date de Naissance<span>*</span></label>
                                </div>
                                <div><input value="<?php echo $data[0]['date_N'] ?>" required type="date" placeholder="Addresse..." class="input_big" name="DN" /></div>
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="input_gr2">
                                <div> <label class="text-label" for="">Telecharger Votre CIN <span>(pdf)</span></label></div>
                                <?php if ($data) {
                                    $chemin_CIN = $document->getDocuments('CIN', $data[0]['id_insc']);
                                } ?>
                                <div><input value="<?php if ($data) echo $chemin_CIN; ?>" type="file" accept="application/pdf" class="input_big" name="Cni_doc" />
                                    <p class="file"><?php if ($data) echo $chemin_CIN; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Information sur le Bacalaureat:</h3>
                    <div class="Document_info">
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Type de Bac<span>*</span></label></div>
                                <div>
                                    <select name="Type_bac" id="Type_bac" class="choix" required>
                                        <option selected disabled>--Choisir Votre Type de Bac--</option>
                                        <?php
                                        $Types = array();
                                        $result = $bd->show_TypeBac();
                                        $Types = $result->fetchAll();
                                        if (!empty($Types)) {
                                            foreach ($Types as $Type) { ?>
                                                <option <?php if ($data && $data[0]['id_TypeBac'] == $Type['id_type_bac']) echo 'selected'; ?> value="<?php echo $Type['id_type_bac']; ?>"><?php echo $Type['type_bac']; ?></option>
                                        <?php }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Annee d'obtenation<span>*</span></label></div>
                                <div><input value="<?php if ($data) echo $data[0]['Anne_bac']; ?>" required type="text" placeholder="Annee de bac..." name="Anne_bac" /></div>
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Note de Regional<span>*</span></label></div>
                                <div><input value="<?php if ($data) echo $data[0]['note_regional']; ?>" required type="text" placeholder="Example: 14.00" name="NoteR" /></div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Note de National<span>*</span></label></div>
                                <div><input value="<?php if ($data) echo $data[0]['note_national']; ?>" required type="text" placeholder="Example: 14.00" name="NoteN" /></div>
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Note Generale<span>*</span></label></div>
                                <div><input value="<?php if ($data) echo $data[0]['note_general']; ?>" required type="text" placeholder="Example: 14.00" name="NoteG" /></div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Mention<span>*</span></label></div>
                                <select name="Mention" id="choix-mention" name="Mention" required>
                                    <option selected disabled>--Choisir votre Mention--</option>
                                    <option <?php if ($data && $data[0]['mention'] == 'passable') echo 'selected'; ?> value="passable">passable</option>
                                    <option <?php if ($data && $data[0]['mention'] == 'A.bien') echo 'selected'; ?> value="A.bien">assez bien</option>
                                    <option <?php if ($data && $data[0]['mention'] == 'bien') echo 'selected'; ?> value="bien">bien</option>
                                    <option <?php if ($data && $data[0]['mention'] == 'T.bien') echo 'selected'; ?> value="T.bien">trés bien</option>
                                </select>
                                <!-- <div><input type="text" placeholder="Mention de bac..." /></div> -->
                            </div>
                        </div>
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Telecharger Votre Releve de Note<span>(pdf)</span></label></div>
                                <?php if ($data) {
                                    $chemin_Releve = $document->getDocuments('Releve Not', $data[0]['id_insc']);
                                } ?>
                                <div><input value="<?php if ($data) echo $chemin_Releve; ?>" type="file" accept="application/pdf" class="input_big" name="Releve_doc" />
                                    <p class="file"><?php if ($data) echo $chemin_Releve; ?></p>
                                </div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Telecharger Votre Bac<span>(pdf)</span></label></div>
                                <?php if ($data) {
                                    $chemin_bac = $document->getDocuments('Bac', $data[0]['id_insc']);
                                } ?>
                                <div><input value="<?php if ($data) echo $chemin_bac; ?>" type="file" accept="application/pdf" class="input_big" name="Bac_doc" />
                                    <p class="file"><?php if ($data) echo $chemin_bac; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Choix de Filliere:</h3>
                    <div class="choix_filliere">
                        <div class="inputs">
                            <div class="input_gr">
                                <div> <label class="text-label" for="choix-fi">Choix 1<span>*</span></label></div>
                                <div>
                                    <select id="choix-fi" name="Choix1" required>
                                        <option selected disabled>--Choisir Votre Choix--</option>
                                        <?php
                                        $Filiers = array();
                                        $Filiers = $filiere->show_Filliers();
                                        if (!empty($Filiers)) {
                                            $id_choix1 = $bd->get_choix($data[0]['id_insc'], '1');
                                            foreach ($Filiers as $Filier) { ?>
                                                <option <?php if ($data && $id_choix1[0] == $Filier['id_dept']) echo 'selected'; ?> value="<?php echo $Filier['id_dept'] ?>"><?php echo $Filier['filiere']; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="input_gr">
                                <div> <label class="text-label" for="">Choix 2<span>*</span></label></div>
                                <div>
                                    <select id="choix-fi" name="Choix2" required>
                                        <option selected disabled>--Choisir Votre Choix--</option>
                                        <?php
                                        $Filiers = array();
                                        
                                        $Filiers = $filiere->show_Filliers();
                                        if (!empty($Filiers)) {
                                            $id_choix2 = $bd->get_choix($data[0]['id_insc'], '2');

                                            foreach ($Filiers as $Filier) {

                                        ?>
                                                <option <?php if ($data && $id_choix2[0] == $Filier['id_dept']) echo 'selected'; ?> value="<?php echo $Filier['id_dept'] ?>"><?php echo $Filier['filiere']; ?></option>
                                        <?php }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="inputs">
                        <div class="input_gr2">
                            <?php if ($data) { ?>
                                <input type="submit" class="btn-sub input_big" name="Modifier" value="Modifier" />
                            <?php } else { ?>
                                <input type="submit" class="btn-sub input_big" name="submit" />
                            <?php } ?>
                        </div>
                    </div>
                </form>

            </div>
            <?php
            /*******************Show erreur toast**********************/
            if (isset($erreur)) {
                echo '<div id="snackbar" style="background-color:' . $erreur_cl . ';" >' . $erreur . '</div>';
            }
            ?>
            <script>
                function show_menu() {
                    document.getElementById("myDropdown").classList.toggle("show");
                }

                // Close the dropdown menu if the user clicks outside of it
                window.onclick = function(event) {
                    if (!event.target.matches('.dropbtn')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                            var openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }

                function affiche_img(e) {
                    const reader = new FileReader();
                    reader.addEventListener('load', function() {
                        const upload_img = reader.result;
                        // let img = document.querySelector("#profile");
                        let img2 = document.querySelector("#profile2");

                        img2.src = upload_img;
                    });
                    reader.readAsDataURL(e.files[0]);
                }
            </script>
        </body>
        <script>
            function show_toast(e) {
                var error = <?php echo json_encode($erreur); ?>;
                let toast = document.querySelector('#snackbar');
                //console.log(toast)
                if (error) {
                    toast.setAttribute("class", "show");
                }

                setTimeout(function() {
                    toast.removeAttribute("class")

                }, 3000);

            }

            show_toast();
        </script>

        </html>
<?php
    } else {
        header('location:delai_depasse.php');
    }
} else {
    header('location:index.php');
} ?>