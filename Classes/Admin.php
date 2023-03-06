<?php

require_once('Connect.php');
require_once('Etudiant.php');
require_once('Filliere.php');
class Admin
{
    protected $bdd;
    function __construct()
    {
        $this->connect_db();
    }
    private function connect_db()
    {
        $cn = new Connect();
        $this->bdd = $cn->connection_db();
    }
    public function connecter($login, $pass)
    {
        if (!empty($login) && !empty($pass)) {

            /*$pass = sha1($pass);*/
            $reqlogin = $this->bdd->prepare("SELECT * FROM admin WHERE login = ?");
            $reqlogin->execute(array($login));
            $result = $reqlogin->fetch();
            if (!empty($result)) {
                if ($pass == $result['password']) {
                    header("location:principale.php?login=" . urlencode($result['nom'] . "&" . urlencode($result['prenom'])));
                    $_SESSION['login'] = $result['login'];
                } else {
                    $erreur[0] = " mot de passe n'est pas correct";
                    $erreur[1] = "red";
                }
            } else {
                $erreur[0] = "aucune compte avec ce login";
                $erreur[1] = "red";
            }
        } else {
            $erreur[0] = "remplir tous les champs";
            $erreur[1] = "orange";
        }
        return $erreur;
    }
    public function show_admins()
    {
        $reqAdmins = $this->bdd->prepare('SELECT * FROM admin');
        $reqAdmins->execute();
        $Admins = $reqAdmins->fetchAll();

        return $Admins;
    }
    public function get_AdminType($login)
    {
        $reqAdmin = $this->bdd->prepare('SELECT type FROM admin WHERE login = ?');
        $reqAdmin->execute(array($login));

        return $reqAdmin->fetch();
    }
    public function Ajouter_Admin($nom, $prenom, $login, $password, $type)
    {
        if (!empty($nom) && !empty($prenom) && !empty($login) && !empty($password) && !empty($type)) {
            $insertA = $this->bdd->prepare('INSERT INTO admin(nom,prenom,login,password,type) VALUES(?,?,?,?,?)');
            $insertA->execute(array($nom, $prenom, $login, $password, $type));
        }
    }
    public function Modifier_Admin($id, $nom, $prenom, $login, $password, $type)
    {
        $ModiAdmin = $this->bdd->prepare("UPDATE admin SET nom = ? , prenom = ?, login = ?, password = ?, type = ? WHERE id_admin = ?");
        $ModiAdmin->execute(array($nom, $prenom, $login, $password, $type, $id));
    }
    public function Delete_Admin($id)
    {
        $deletAdm = $this->bdd->prepare("DELETE FROM admin WHERE id_admin = ?");
        $deletAdm->execute(array($id));
    }
    public function Get_ville($id)
    {
        $getVille = $this->bdd->prepare("SELECT ville FROM ville WHERE id_ville = ?");
        $getVille->execute(array($id));
        return $getVille->fetch();
    }
    public function change_dateFin($dateD, $dateF)
    {
        $setDate = $this->bdd->prepare("UPDATE date_inscri SET date_debut = ?, date_fin = ? WHERE id_date = 1");
        $setDate->execute(array($dateD, $dateF));
    }
    public function get_Date()
    {
        $getDate = $this->bdd->prepare("SELECT date_debut,date_fin FROM date_inscri WHERE id_date = 1");
        $getDate->execute();
        return $getDate->fetch();
    }
    public function get_types()
    {
        $getType = $this->bdd->prepare("SELECT * FROM type_bac");
        $getType->execute();
        return $getType->fetchAll();
    }
    public function Add_Coefficient($id_dept, $TypeBac, $coefficient)
    {
        $getCoe = $this->bdd->prepare("SELECT id_type_bac FROM coefficients WHERE id_dept = ? AND id_type_bac = ?");
        $getCoe->execute(array($id_dept, $TypeBac));
        $count = $getCoe->rowCount();
        if ($count == 0) {
            $insertCoe = $this->bdd->prepare("INSERT INTO coefficients(id_dept,id_type_bac,not_apoge) VALUES(?,?,?)");
            $insertCoe->execute(array($id_dept, $TypeBac, $coefficient));
        } else {
            $upCoe = $this->bdd->prepare("UPDATE coefficients SET not_apoge = ? WHERE id_dept = ? AND id_type_bac = ?");
            $upCoe->execute(array($coefficient, $id_dept, $TypeBac));
        }
    }
    public function get_coefficient($id_dept, $TypeBac)
    {
        $getCoeff = $this->bdd->prepare("SELECT not_apoge FROM coefficients WHERE id_dept = ? AND id_type_bac = ? ");
        $getCoeff->execute(array($id_dept, $TypeBac));
        return $getCoeff->fetch();
    }
    public function get_bac($id_bac)
    {
        $getB = $this->bdd->prepare("SELECT type_bac FROM type_bac WHERE id_type_bac = ?;");
        $getB->execute(array($id_bac));

        return $getB->fetch();
    }
}
