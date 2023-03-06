<?php
require_once('Connect.php');
class Liste{
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
    public function get_Liste($id_dept)
    {
        $getL = $this->bdd->prepare("SELECT e.photo,e.CIN,e.CNE,e.nom,e.prenom,e.id_TypeBac,d.filiere,(e.note_regional*0.25+e.note_national*0.75)*c.not_apoge AS note, d.places as places FROM etudiant e INNER JOIN inscrire i INNER JOIN dept d INNER JOIN coefficients c ON e.id_insc = i.id_insc AND i.id_dept = c.id_dept AND e.id_TypeBac = c.id_type_bac AND i.id_dept = d.id_dept WHERE i.id_dept =? ORDER BY note DESC;");
        $getL->execute(array($id_dept));
        return $getL->fetchAll();
    }
    public function get_ListeP($id_dept)
    {
        $f = new Filliere();
        $limit = $f->get_Filier($id_dept)['places'];
        $getL = $this->bdd->prepare("SELECT e.photo,e.CIN,e.CNE,e.nom,e.prenom,e.id_TypeBac,d.filiere,(e.note_regional*0.25+e.note_national*0.75)*c.not_apoge AS note, d.places as places FROM etudiant e INNER JOIN inscrire i INNER JOIN dept d INNER JOIN coefficients c ON e.id_insc = i.id_insc AND i.id_dept = c.id_dept AND e.id_TypeBac = c.id_type_bac AND i.id_dept = d.id_dept WHERE i.id_dept =? ORDER BY note DESC LIMIT $limit;");
        $getL->execute(array($id_dept));
        return $getL->fetchAll();
    }
    public function get_ListeAtt($id_dept)
    {
        $f = new Filliere();
        $limit = $f->get_Filier($id_dept)['places'];
        $Etudiant = new Etudiant();
        $n = $Etudiant->get_Students($id_dept);
        $nt =  count($n);
        $l = $nt - $limit;
        if ($l < 0) {
            $l = 0;
        }
        $getL = $this->bdd->prepare("SELECT photo,CIN,CNE,nom,prenom,id_TypeBac,filiere, note FROM (SELECT e.photo,e.CIN,e.CNE,e.nom,e.prenom,e.id_TypeBac,d.filiere,(e.note_regional*0.25+e.note_national*0.75)*c.not_apoge AS note FROM etudiant e INNER JOIN inscrire i INNER JOIN dept d INNER JOIN coefficients c ON e.id_insc = i.id_insc AND i.id_dept = c.id_dept AND e.id_TypeBac = c.id_type_bac AND i.id_dept = d.id_dept WHERE i.id_dept =$id_dept ORDER BY note ASC LIMIT $l )Var1 ORDER BY note DESC;");
        $getL->execute(array());
        return $getL->fetchAll();
    }
    
}