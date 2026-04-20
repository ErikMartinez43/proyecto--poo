<?php
class Activacion{
    private int $id;
    private int $id_software;
    private int $id_modulo;

    public function __construct(int $id, int $id_software, int $id_modulo){
        $this->id = $id;
        $this->id_software = $id_software;
        $this->id_modulo = $id_modulo;

    }

    public function getId(){
        return $this->id;
    }
    public function getIdSoftware(){
        return $this->id_software;
    }
    public function getIdModulo(){
        return $this->id_modulo;
    }
}