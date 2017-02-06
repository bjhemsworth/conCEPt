<?php

/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 09/01/17
 * Time: 12:19
 */
namespace Concept\Controller;
use Concept\Model\UserAuthModel;
use Klein\Route;
use Twig_Environment;
use Twig_Loader_Filesystem;

class UserAuthModel
{

    public function __construct($username)
    {
        $this->db = DB::getDB();
        $this->username = $username;
    }
    public function isAdmin() {
        //todo tidy this up

        $statement = $this->db->prepare("SELECT *
                                         FROM Admin
                                         WHERE Admin_ID=:user");

        $statement->bindValue(':user',$this->username,PDO::PARAM_STR);
        $statement->execute();

        return $this->statementHasResults($statement);
    }
    public function isMarker() {
        $statement = $this->db->prepare("SELECT *
                                         FROM Marker
                                         WHERE Marker_ID=:user");

        $statement->bindValue(':user', $this->username, PDO::PARAM_STR);
        $statement->execute();

        return $this->statementHasResults($statement);
    }


    private function statementHasResults($statement) {
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // if we have results, then user must be an admin
        if(isset($results[0])) {
            return true;
        }
        //otherwise they are not
        return false;
    }

}