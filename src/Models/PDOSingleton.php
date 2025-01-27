<?php
namespace Models;

use PDO;
use PDOException;

class PDOSingleton
{
    private static $instance = null; // Stocke l'instance unique de la classe
    private $pdo; // La connexion PDO
    // Informations de connexion à la base de données (généralement déportées)
    private $host = 'localhost';
    private $db = 'NOMBDD'; // Remplacez par le nom de votre base de donn ées
    private $user = 'PSEUDO'; // Remplacez par votre nom d' utilisateur MySQL
    private $pass = 'MOTDEPASSE'; // Remplacez par votre mot de passe MySQL
    private $charset = 'utf8mb4';
    // Constructeur privé pour empêcher la création d'instances directement
    private function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Gérer les erreurs avec des exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Résultats sous forme de tableaux associatifs
            PDO::ATTR_EMULATE_PREPARES => false, // Désactiver l'émulation des requêtes préparées
        ];
        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    // Empêche la duplication d'instances par clonage
    private function __clone() {}
    // Empêche la désérialisation
    public function __wakeup() {}
    // Mé thode pour obtenir l'instance unique ( Singleton )
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    // Récupère l'objet PDO pour exé cuter des requ êtes SQL
    public function getConnection()
    {
        return $this->pdo;
    }
}


//SELECT * FROM slimLogBook.users;