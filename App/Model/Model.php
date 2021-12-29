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

    public function create(array $data)
    {

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

        $retour = $this->connexion->exec($sql);
        return $retour;

    }

    public function delete($id)
    {
        $selectPrimaryKey = "SELECT DISTINCT TABLE_NAME ,column_name
                             FROM INFORMATION_SCHEMA.key_column_usage
                             WHERE TABLE_SCHEMA IN ('projet_web');";

        $keys = $this->getConnexion()->query($selectPrimaryKey);
        $key = $keys->fetchAll(PDO::FETCH_ASSOC);

        $i = 0;
        while ($i < 9) {
            if ($key[$i]['TABLE_NAME'] == $this->getTable()) {
                $primaryKey = $key[$i]['column_name'];

//                var_dump($primaryKey);

                $sql = "delete from $this->table where $primaryKey = '$id'";

                break;
            }
            $i++;
        }

        $retour = $this->getConnexion()->exec($sql);

    }

    // Récupérer une image
    public function getImage(): String
    {
        // Variables d'enregistrement
        $enregistrement = false;
        $aff = "";

        // ENREGISTREMENT DE L'IMAGE
        if (isset($_FILES) && $_FILES['image']['error'] == 0) {
            $enregistrement = move_uploaded_file($_FILES["image"]["tmp_name"], "image/groupe/" . $_FILES["image"]["name"]);
            $aff .= "Stored in: " . "image/groupe/" . $_FILES["image"]["name"];
        }

        // INSERTION
        $image = 'image/groupe/' . $_FILES["image"]["name"];

        return $image;
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