<?php
abstract class SoftwareDecorador implements Producto{
    protected Producto $producto;

    public function __construct(Producto $producto)
    {
        //throw new \Exception('Not implemented');
        $this->producto = $producto;
    }

    public function getNombre(): string
    {
        return $this->producto->getNombre();
    }
    public function getCosto(): float
    {
        return $this->producto->getCosto();
    }
}