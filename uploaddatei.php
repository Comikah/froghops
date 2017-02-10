<?php

class Uploaddatei
{
    public $id;
    public $filename;
    public $dateityp;
    public $groesse;
    public $text;
    public $datum;

    function __construct($data=null) {
        if (is_array($data)) {
            if (isset($data['id'])) $this->id = $data['id'];

            $this->filename = $data['filename'];
            $this->dateityp = $data['dateityp'];
            $this->groesse = $data['groesse'];
            $this->datum = $data['datum'];
            $this->text = $data['text'];
        }
    }

    public function __toString() {
        return $this->id." ".$this->filename." ".$this->dateityp." ".$this->groesse." ".$this->datum." ".$this->text;
    }
}

// filename = Betreff / dateityp = name / = groesse = text