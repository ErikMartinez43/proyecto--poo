<?php
class SoftwareBase implements Producto{
    private int $id;
    private string $descripcion;
    private float $costo;
    private string $nombre;

    public function __construct(int $id, string $nombre, string $descripcion, float $costo )
    {
        //throw new \Exception('Not implemented');
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->costo = $costo;

    }

    public function getId():int{
        return $this->id;
    }

    public function getNombre():string{
        return $this->nombre;
    }

    public function getDescripcion():string{
        return $this->descripcion;
    }
    public function getCosto():float{
        return $this->costo;
    }

    public function getInfo(): string {
        return "ID: $this->id, Nombre: $this->nombre, Descripcion: $this->descripcion, Costo: $this->costo";
    }
}