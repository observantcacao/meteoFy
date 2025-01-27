<?php

namespace Models;

use PDO;

abstract class ActiveRecord
{
    protected $pdoConnection;
    protected static $table;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $pdo = PDOSingleton::getInstance();
        $this->pdoConnection = $pdo->getConnection();
    }

    protected function executeQuery($sql, $params = [])
    {
        $stmt = $this->pdoConnection->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Récupère un enregistrement spécifique de la table associée à la classe.
     *
     * @param int $id Identifiant unique de l'enregistrement recherché.
     * @return static|null Instance de la classe enfant ou null si non trouvé.
     */
    public static function find($id) {
        $sql = "SELECT * FROM " . static::$table . " WHERE id = :id";

        $pdoInstance = PDOSingleton::getInstance();
        $stmt = $pdoInstance->getConnection()->prepare($sql);
        $stmt->execute(['id' => $id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new static($data); // Crée une instance de la classe enfant avec les données
        }

        return null; // Retourne null si aucun enregistrement n'est trouvé
    }
    
    public static function findAll() {
        $pdo = PDOSingleton::getInstance();
        $table = static::$table;        
        // Préparation de la requête pour récupérer tous les enregistrements
        $stmt = $pdo->getConnection()->query("SELECT * FROM $table ");
        $datas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($datas as $row) {
            $result[] = new static($row);
        }        
        return $result;
    }

    /**
     * 
     */
    public function toString()
    {
        $properties = get_object_vars($this); // Récupère les propriétés de l'objet courant
        $output = [];
        foreach ($properties as $name => $value) {
            if (is_object($value)) {
                continue; // Ignore les propriétés qui sont des objets
            }
            $output[] = "[$name : $value]";
        }
        return sprintf(
            "** %s ** : %s",
            get_class($this),
            implode(' ', $output)
        );
    }
}
