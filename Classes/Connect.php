<?php
DEFINE("DB_HOST", "127.0.0.1");
DEFINE("DB", "projet_php");
class Connect
{
    protected $host = DB_HOST;
    protected $dbname = DB;
    public function connection_db()
    {
        return new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, "root", '');
    }
}
