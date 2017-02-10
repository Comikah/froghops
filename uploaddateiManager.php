<?php

require_once("dateiupload.php");
require_once("userdata.php");

class uploaddateiManager
{
    private $pdo;

    //Konstruktor entwerfen
   public function __construct($connection = null)
    {
        try {
            $this->pdo = $connection;
            if ($this->pdo === null) {
                $this->pdo = new PDO(
                    userdata::$dsn,
                    userdata::$dbuser,
                    userdata::$dbpass

                );
            }
        } catch (PDOException $e) {
            echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
            die();
        }
    }

    public function __destruct()
    {
        $this->pdo = null;
    }

    //Funktion sortieren nach ID - USERID???
    public function findById($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM uploads WHERE id = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Uploaddatei');
            $n = $stmt->fetch();
        } catch (PDOException $e) {
            echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
            die();
        }
        if (!$n) $n = null;
        return $n;
    }

    //Funktion für heraussuchen
    public function findAll()
    {
        try {
            $stmt = $this->pdo->prepare('
              SELECT * FROM uploads
            ');
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Uploaddatei');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
            die();
        }

    }

    //Funktion für speichern
    public function save(Uploaddatei $uploaddatei)
    {
        // wenn ID gesetzt, dann update...
        if (isset($uploaddatei->id)) {
            $this->update($uploaddatei);
            return $uploaddatei;
        }
        // ...sonst Anlage eines neuen Datensatzes
        try {
            $stmt = $this->pdo->prepare('
              INSERT INTO uploads
                (original_name, datei_typ, groesse, datum)
              VALUES
                (:filename, :dateityp , :groesse, NOW())
            ');
            $stmt->bindParam(':filename', $uploaddatei->filename);
            $stmt->bindParam(':dateityp', $uploaddatei->dateityp);
            $stmt->bindParam(':groesse', $uploaddatei->groesse);
            $stmt->execute();
            // lastinsertId() gibt die zuletzt eingefügte Id zurück -> damit Update der internen Id
            $uploaddatei->id = $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
            die();
        }
        return $uploaddatei;
    }


    //Funktion für Update/Änderung
    private function update(Uploaddatei $uploaddatei)
    {
        echo ("update!");
        try {
            $stmt = $this->pdo->prepare('
              UPDATE uploads
              SET original_name = :filename,
                  dateityp = :dateityp,
                  groesse = :groesse
              WHERE id = :id
            ');
            $stmt->bindParam(':id', $uploaddatei->id);
            $stmt->bindParam(':filename', $uploaddatei->filename);
            $stmt->bindParam(':dateityp', $uploaddatei->dateityp);
            $stmt->bindParam(':groesse', $uploaddatei->groesse);
            $stmt->execute();
        } catch (PDOException $e) {
            echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
            die();
        }
        return $uploaddatei;
    }


    //Funktion für Löschen
    public function delete(Uploaddatei $uploaddatei)
    {
        if (!isset($uploaddatei->id)) {
            $uploaddatei = null;
            return $uploaddatei;
        }
        try {
            $stmt = $this->pdo->prepare('
              DELETE FROM uploads WHERE id= :id
            ');
            $stmt->bindParam(':id', $uploaddatei->id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo("Fehler! Bitten wenden Sie sich an den Administrator...<br>" . $e->getMessage() . "<br>");
            die();
        }
        $uploaddatei = null;
        return $uploaddatei;
    }
}