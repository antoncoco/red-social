<?php
namespace Cocol\Redsocial\lib;

class View {
    private array $data;

    function render(string $nombre, array $data = []) {
        $this->data = $data;
        require 'src/views/' . $nombre . '.php';
    } 
}