<?php

namespace Models;

use Models\PDOSingleton;
use Interfaces\IActiveRecord;
use PDO;

/**
 * Classe ARUsers
 * Implémente le pattern Active Record pour gérer les entrées de la table "users".
 * 
 * @package Models
 */
class ARUser extends ActiveRecord implements IActiveRecord
{
    /**
     * Nom de la table associée à cette classe.
     * 
     * @var string
     */
    protected static $table = 'User';

    /**
     * Identifiant unique de l'utilisateur.
     * 
     * @var int|null
     */
    public $id = null;

    /**
     * Nom d'utilisateur.
     * 
     * @var string
     */
    public $pseudo = '';

    /**
     * Mot de passe de l'utilisateur.
     * 
     * @var string
     */
    public $hashPassword = '';

    /**
     * Indique si l'utilisateur est administrateur (1 pour admin, 0 sinon).
     * 
     * @var int
     */
    public $admin = 0;

    /**
     * Constructeur de la classe ARUsers.
     * Initialise les propriétés avec les données fournies et appelle le constructeur parent.
     * 
     * @param array $data Données initiales pour remplir les propriétés de l'objet.
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * Crée une nouvelle entrée dans la table "users".
     * Initialise l'identifiant de l'objet après insertion.
     * 
     * @return void
     */
    public function create()
    {
        $sql = "INSERT INTO " . static::$table . " (pseudo, hashPassword, admin) VALUES (:pseudo, :hashPassword, :admin);";
        $this->executeQuery($sql, [
            'pseudo' => $this->pseudo,
            'hashPassword' => $this->hashPassword, // Hash sécurisé du mot de passe
            'admin' => $this->admin,
        ]);

        // Récupère le dernier ID inséré et l'assigne à l'objet
        $this->id = $this->pdoConnection->lastInsertId();
    }

    /**
     * Met à jour l'entrée existante dans la table "users".
     * 
     * @return void
     */
    public function update()
    {
        $sql = "UPDATE " . static::$table . " SET pseudo = :pseudo, password = :password, is_admin = :is_admin WHERE id = :id;";
        $this->executeQuery($sql, [
            'pseudo' => $this->pseudo,
            'hashPassword' => password_hash($this->hashPassword, PASSWORD_DEFAULT), // Hash sécurisé du mot de passe
            'admin' => $this->admin,
            'id' => $this->id,
        ]);
    }

    /**
     * Supprime l'entrée actuelle de la table "users".
     * Supprime également les entrées associées dans d'autres tables (ex : blogs).
     * 
     * @return void
     */
    public function delete()
    {        
        // Supprime l'utilisateur lui-même
        $sql = "DELETE FROM " . static::$table . " WHERE id = :id;";
        $this->executeQuery($sql, ['id' => $this->id]);
    }

    public static function isValid($pseudo, $hashPassword): bool
    {
        $pdoInstance = PDOSingleton::getInstance();
        $sql = "SELECT * FROM " . static::$table . " WHERE pseudo = :pseudo;";
        $stmt = $pdoInstance->getConnection()->prepare($sql);
        $stmt->execute(['pseudo' => $pseudo]);

        // Récupère les données de l'utilisateur
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie le mot de passe
        Alert::add("danger",var_dump($user));
        if ($user && $hashPassword == $user['hashPassword']) {
            // Initialise la session utilisateur
            $_SESSION['user_connected'] = [
                'id' => $user['id'],
                'admin' => $user['admin'],
            ];
            return true;
        }
        return false;
    }

    public static function findIDViaUser($pseudo)
    {
        $sql = "SELECT * FROM " . static::$table . " WHERE pseudo = :pseudo";

        // Prépare la requête pour l'identifiant donné
        $pdoInstance = PDOSingleton::getInstance();
        $stmt = $pdoInstance->getConnection()->prepare($sql);
        $stmt->execute(['pseudo' => $pseudo]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            // Retourne une instance de la classe enfant avec les données
            return new static($data);
        }

        // Retourne null si aucun enregistrement n'est trouvé
        return null;
    }

    public static function isAdmin($id)
    {
        $user = parent::find($id);
        if ($user->admin == 0) {
            return false;
        }
        return true;
    }
}
