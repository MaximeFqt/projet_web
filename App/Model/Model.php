<?php

namespace App\Model;

use App\Config\Database;
use PDO;

class Model
{

    private PDO $connexion;
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

    public function create(array $data) {

        $sql="insert into $this->table (";
        foreach ($data as $key => $value) {
            unset($data["id"]);
            $sql.="`$key`,";
        }
        //suppression de la virgule
        $sql=substr($sql,0,-1);
        $sql.=" ) VALUES (";
        foreach ($data as $key => $value) {
            if(is_numeric($value))  $sql.=$value.",";
            else
                $sql.="'$value',";
        }
        $sql=substr($sql,0,-1);
        $sql.=" )";

        // Envoie de la requête

        $retour=$this->connexion->exec($sql);
        return $retour;

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