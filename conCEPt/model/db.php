<?php
namespace Concept\Model;
class DB
{

    public static function getDB()
    {
        return new PDO("mysql:host=mysql.dur.ac.uk;dbname=Idcs8s04_conCEPt", 'dcs8s04', 'when58');
    }

}

