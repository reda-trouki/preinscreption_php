<?php
require_once('Connect.php');
require_once('Documents.php');
class Etudiant
{

    protected $bdd;
    public $erreur = array();
    function __construct()
    {
        $this->connect_db();
    }
    private function connect_db()
    {
        $cn = new Connect();
        $this->bdd = $cn->connection_db();
    }
    public function creation_compte($cne, $email, $mdp)
    {
        if (!empty($cne) and !empty($email) and !empty($mdp)) {
            $cnelength = strlen($cne);
            if ($cnelength <= 10) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $reqmail = $this->bdd->prepare("SELECT * FROM users WHERE email = ?");
                    $reqmail->execute(array($email));
                    $mailexist = $reqmail->rowCount();
                    if ($mailexist == 0) {

                        $insertmbr = $this->bdd->prepare("INSERT INTO users(CNE, email, password) VALUES(?, ?, ?)");

                        $insertmbr->execute(array($cne, $email, $mdp));

                        $erreur[0] = "Votre compte a bien été créé ! ";
                        $erreur[1] = "green";
                    } else {
                        $erreur[0] = "Adresse mail déjà utilisée !";
                        $erreur[1] = "red";
                    }
                } else {
                    $erreur[0] = "Votre adresse mail n'est pas valide !";
                    $erreur[1] = "orange";
                }
            } else {
                $erreur[0] = "Votre CNE ne doit pas dépasser 10 caractères !";
                $erreur[1] = "orange";
            }
        } else {
            $erreur[0] = "Tous les champs doivent être complétés !";
            $erreur[1] = "red";
        }
        return $erreur;
    }
    public function connecter($email, $pass)
    {
        if (!empty($email) && !empty($pass)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $pass = sha1($pass);
                $reqmail = $this->bdd->prepare("SELECT * FROM users WHERE email = ?");
                $reqmail->execute(array($email));
                $result = $reqmail->fetch();
                if (!empty($result)) {
                    if ($pass == $result['password']) {
                        header("location:formulaire.php?CNE=" . urlencode($result['CNE']));
                        $_SESSION['CNE'] = $result['CNE'];
                    } else {
                        $erreur[0] = " mot de passe n'est pas correct";
                        $erreur[1] = "red";
                    }
                } else {
                    $erreur[0] = "aucune compte avec ce mail";
                    $erreur[1] = "red";
                }
            } else {
                $erreur[0] = "email not valide";
                $erreur[1] = "orange";
            }
        } else {
            $erreur[0] = "remplir tous les champs";
            $erreur[1] = "orange";
        }
        return $erreur;
    }
    public function insert_toEtudiant($CIN, $nom, $prenom, $CNE, $Addresse, $NoteR, $NoteN, $NoteG, $Mention, $DN, $idVille, $idRegion, $photo, $TypeBac, $Anne_bac, $doc1, $doc2, $doc3, $choix1, $choix2)
    {
        $erreur = array();
        if (!empty($CIN) && !empty($nom) && !empty($prenom) && !empty($CNE) && !empty($Addresse) && !empty($NoteR) && !empty($NoteN) && !empty($NoteG) && !empty($Mention) && !empty($DN) && !empty($idVille) && !empty($idRegion)  && !empty($photo) && !empty($TypeBac) && !empty($Anne_bac)) {

            $insertEtu = $this->bdd->prepare("INSERT INTO etudiant(CIN,nom,prenom,CNE,adresse,note_regional,note_national,note_general,mention,date_N,id_ville,id_region,photo,Anne_bac,id_TypeBac ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $insertEtu->execute(array($CIN, $nom, $prenom, $CNE, $Addresse, $NoteR, $NoteN, $NoteG, $Mention, $DN, $idVille, $idRegion, $photo, $Anne_bac, $TypeBac));

            $selectEtu = $this->select_id($CNE);
            $id_etu = $selectEtu->fetch();
            $document = new Documents();
            $document->insert_documents('CIN', $doc1, $id_etu[0]);
            $document->insert_documents('Releve Note', $doc2, $id_etu[0]);
            $document->insert_documents('Bac', $doc3, $id_etu[0]);
            if ($choix1 != $choix2) {
                $this->insert_choix($choix1, $id_etu[0], '1');
                $this->insert_choix($choix2, $id_etu[0], '2');
            } else {
                $erreur[0] = "choisir deux choix deffrents!!";
                $erreur[1] = "red";
                return $erreur;
            }
            $erreur[0] = "votre inscreption a éte bien fait";
            $erreur[1] = "green";
            return $erreur;
        }
    }
    public function update_Etudiant($CIN, $nom, $prenom, $CNE, $Addresse, $NoteR, $NoteN, $NoteG, $Mention, $DN, $idVille, $idRegion, $photo, $TypeBac, $Anne_bac, $doc1, $doc2, $doc3, $choix1, $choix2)
    {

        if (!empty($CIN) && !empty($nom) && !empty($prenom) && !empty($CNE) && !empty($Addresse) && !empty($NoteR) && !empty($NoteN) && !empty($NoteG) && !empty($Mention) && !empty($DN) && !empty($idVille) && !empty($idRegion)  && !empty($photo) && !empty($TypeBac) && !empty($Anne_bac)) {
            $updateEtu = $this->bdd->prepare("UPDATE etudiant SET CIN = ?,nom = ?,prenom = ?,adresse=?,note_regional = ?,note_national = ?,note_general = ?,mention = ?,date_N=?,id_ville = ?,id_region = ?,photo = ?,Anne_bac=?,id_TypeBac = ? WHERE etudiant.CNE = ?");
            $updateEtu->execute(array(
                $CIN, $nom, $prenom, $Addresse, $NoteR, $NoteN, $NoteG, $Mention, $DN, $idVille, $idRegion,
                $photo, $Anne_bac, $TypeBac, $CNE
            ));
            $selectEtu = $this->select_id($CNE);

            $id_etu = $selectEtu->fetch();
            $document = new Documents();
            $document->update_documents('CIN', $doc1, $id_etu[0]);
            $document->update_documents('Releve Not', $doc2, $id_etu[0]);
            $document->update_documents('Bac', $doc3, $id_etu[0]);

            $this->update_choix($choix1, $id_etu[0], '1');
            $this->update_choix($choix2, $id_etu[0], '2');
            return 0;
        } else {
            return 1;
        }
    }

    public function update_choix($choix, $id_etu, $ordre)
    {
        $updateChoi = $this->bdd->prepare("UPDATE inscrire SET id_dept = ? WHERE id_insc = ? AND ordre = ? ");
        $updateChoi->execute(array($choix, $id_etu, $ordre));
    }
    public function show_etuInfo($CNE)
    {
        $reqetu = $this->bdd->prepare("SELECT * FROM etudiant WHERE CNE = ?");
        $reqetu->execute(array($CNE));
        $result = $reqetu->fetchAll();
        return $result;
    }

    public function get_choix($id, $order)
    {
        $reChoix = $this->bdd->prepare("SELECT id_dept FROM inscrire WHERE id_insc = ? AND ordre = ?");
        $reChoix->execute(array($id, $order));
        return $reChoix->fetch();
    }
    public function select_id($CNE)
    {
        $selectEtu = $this->bdd->prepare("SELECT id_insc FROM etudiant WHERE CNE = ?");
        $selectEtu->execute(array($CNE));
        return $selectEtu;
    }
    public function deja_inscri($CIN, $CNE)
    {
        $selectEtu = $this->bdd->prepare("SELECT id_insc FROM etudiant WHERE CIN = ? OR CNE =?");
        $selectEtu->execute(array($CIN, $CNE));
        $CINexist = $selectEtu->rowCount();
        return $CINexist;
    }
    public function insert_choix($choix, $etudiant, $ordre)
    {
        $queryChoix = $this->bdd->prepare("INSERT INTO inscrire(id_dept,id_insc,ordre) VALUES(?,?,?)");
        $queryChoix->execute(array($choix, $etudiant, $ordre));
    }
    public function show_TypeBac()
    {
        $reqType = $this->bdd->prepare("SELECT * FROM type_bac");
        $reqType->execute();

        return $reqType;
    }
    
    public function show_region()
    {
        $reqregion = $this->bdd->prepare("SELECT * FROM region");
        $reqregion->execute();

        return $reqregion;
    }
    public function show_villes()
    {
        $reqcity = $this->bdd->prepare("SELECT * FROM ville");
        $reqcity->execute();
        return $reqcity;
    }

    public function get_DateFin()
    {
        $get_Fin = $this->bdd->prepare("SELECT date_fin FROM date_inscri WHERE id_date = 1");
        $get_Fin->execute();
        return $get_Fin->fetch();
    }
    public function get_Students($id_dept = -1)
    {
        if ($id_dept != -1) {
            $getEtuIns = $this->bdd->prepare('SELECT e.id_insc,e.CIN,e.nom,e.prenom,e.CNE,e.adresse,note_regional,note_national,e.date_N,e.id_ville,e.photo FROM etudiant e INNER JOIN inscrire i ON e.id_insc = i.id_insc WHERE id_dept = ?');
            $getEtuIns->execute(array($id_dept));
        } else {
            $getEtuIns = $this->bdd->prepare('SELECT e.id_insc,id_dept,e.CIN,e.nom,e.prenom,e.CNE,e.adresse,note_regional,note_national,e.date_N,e.id_ville,e.photo FROM etudiant e INNER JOIN inscrire i ON e.id_insc = i.id_insc;');
            $getEtuIns->execute(array());
        }
        return $getEtuIns->fetchAll();
    }
    public function getEtudiant($Etudiant)
    {
        $getEtu = $this->bdd->prepare("SELECT * FROM etudiant WHERE id_insc = $Etudiant");
        $getEtu->execute();
        return $getEtu->fetch();
    }
}
