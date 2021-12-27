<?php

namespace App\Model;

use App\Config\Database;
use PDO;

class Model
{

    private $connexion;
    private String $table;

    /**
     * @param $connexion
     * @param $table
     */
    public function __construct($table)
    {
        $database = new Database();
        $this->connexion = $database->getConnection();
        $this->table = $table;
    }

    public function read($id) : array
    {
        $sql = "SELECT * FROM ".$this->table." WHERE id=".$id;
        $retour = $this->connexion->query($sql);
        $content = $retour->fetch(PDO::FETCH_ASSOC);

        return $content;

    }

    public function find(): array
    {
        $sql = "select * from $this->table;";
        $tables = $this->connexion->query($sql);
        $table = $tables->fetchAll(\PDO::FETCH_ASSOC);
        return $table;
    }

    // GETTERS
    /**
     * @return String
     */
    public function getTable(): string
    {
        return $this->table;
    }

    public function getConnexion(): PDO
    {
        return $this->connexion;
    }


    // SETTERS
    /**
     * @param String $table
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
    }

}