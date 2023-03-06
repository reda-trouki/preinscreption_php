<?php
require_once('Connect.php');
class Filliere{
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
    public function show_Filliers()
    {
        $reqFilliers = $this->bdd->prepare("SELECT id_dept,filiere,places FROM dept");
        $reqFilliers->execute();

        return $reqFilliers->fetchAll();
    }
    public function get_FilierCount($id_dept)
    {
        $getCount = $this->bdd->prepare("SELECT count(*) as NI FROM inscrire WHERE id_dept = ?");
        $getCount->execute(array($id_dept));
        return $getCount->fetch();
    }
    public function Modifier_Filier($filier, $places, $id)
    {
        $updateFil = $this->bdd->prepare("UPDATE dept SET filiere = ? , places = ? WHERE id_dept = ?");
        $updateFil->execute(array($filier, $places, $id));
    }
    public function get_Filier($id_filier)
    {
        $getf = $this->bdd->prepare("SELECT filiere,places from dept where id_dept = ?");
        $getf->execute(array($id_filier));
        return $getf->fetch();
    }
    public function Ajouter_Fillier($nom, $places)
    {
        $insertF = $this->bdd->prepare("INSERT INTO dept(filiere,places) VALUES (?, ?)");
        $insertF->execute(array($nom, $places));
    }
}