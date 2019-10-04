<?php

//print_r($_POST);

class Mensagem
{
    private $para = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function mensagemValida()
    {
        // se algo tiver vazio...
        if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
            return false;
        }
        return true;
    }
}
$mensagem = new Mensagem();

// isso só funciona porque coloquei os names lá no index.php
// o valor vem da $_POST do índice ['para]...['assunto']... etc, os índices são definidos pelos names dos campos
// então isso recupera os valores
// dentro do parenteses vem os atributos do objeto mensagem e depois do post os valores dos respectivos atributos
$mensagem->__set('para', $_POST['para']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);

if ($mensagem->mensagemValida()) {
    echo 'Mensagem é valida'; 
} else {
    echo 'Mensagem não é valida';
}

