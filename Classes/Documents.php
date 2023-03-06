<?php
require_once('Connect.php');
class Documents
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
    public function insert_documents($nom, $document, $etudiant)
    {
        $doc = $this->bdd->prepare("INSERT INTO _documents(nom,chemin,id_insc) VALUES(?,?,?)");
        $doc->execute(array($nom, $document, $etudiant));
    }
    public function update_documents($name, $doc, $id_etu)
    {
        $updateDoc = $this->bdd->prepare("UPDATE _documents SET chemin = ? WHERE nom = ? AND id_insc = ?");
        $updateDoc->execute(array($doc, $name, $id_etu));
    }
    public function getDocuments($nom, $id)
    {
        $reqDoc = $this->bdd->prepare("SELECT * FROM _documents WHERE nom = ? AND id_insc = ?");
        $reqDoc->execute(array($nom, $id));
        $result = $reqDoc->fetch();
        $chemin = $result['chemin'];
        return $chemin;
    }
}
