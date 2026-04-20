<?php
class Modulo{
    private int $id;
    private string $nombre;
    private float $costo_Adicional;

    public function __construct(int $id, string $nombre, float $costo_Adicional){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->costo_Adicional = $costo_Adicional;

    }

    public function getId(){
        return $this->id;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getCosto(){
        return $this->costo_Adicional;
    }
}