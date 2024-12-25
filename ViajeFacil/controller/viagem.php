<?php

class Viagem {
    private $destino;
    private $data_ida;
    private $data_volta;
    private $numero_adultos;
    private $numero_criancas;

    // Getter e Setter para destino
    public function getDestino() {
        return $this->destino;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }

    // Getter e Setter para data de ida
    public function getDataIda() {
        return $this->data_ida;
    }

    public function setDataIda($data_ida) {
        $this->data_ida = $data_ida;
    }

    // Getter e Setter para data de volta
    public function getDataVolta() {
        return $this->data_volta;
    }

    public function setDataVolta($data_volta) {
        $this->data_volta = $data_volta;
    }

    // Getter e Setter para número de adultos
    public function getNumeroAdultos() {
        return $this->numero_adultos;
    }

    public function setNumeroAdultos($numero_adultos) {
        $this->numero_adultos = $numero_adultos;
    }

    // Getter e Setter para número de crianças
    public function getNumeroCriancas() {
        return $this->numero_criancas;
    }

    public function setNumeroCriancas($numero_criancas) {
        $this->numero_criancas = $numero_criancas;
    }
}
?>
