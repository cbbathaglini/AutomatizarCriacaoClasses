<?php


class Campo
{
    private $nome;
    private $tipo;
    private $ehId;
    private $tamanho;
    private $nulo;
    private $chaveEstrangeira;
    private $classeEstrangeira;

    /**
     * Campo constructor.
     * @param $nome
     * @param $tipo
     * @param $ehId
     * @param $tamanho
     * @param $nulo
     */
    public function __construct($nome, $tipo, $ehId, $tamanho, $nulo,$chaveEstrangeira,$classeEstrangeira)
    {
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->ehId = $ehId;
        $this->tamanho = $tamanho;
        $this->nulo = $nulo;
        $this->chaveEstrangeira = $chaveEstrangeira;
        $this->classeEstrangeira = $classeEstrangeira;
    }


    /**
     * @return mixed
     */
    public function getEhId()
    {
        return $this->ehId;
    }

    /**
     * @param mixed $ehId
     */
    public function setEhId($ehId)
    {
        $this->ehId = $ehId;
    }




    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getTamanho()
    {
        return $this->tamanho;
    }

    /**
     * @param mixed $tamanho
     */
    public function setTamanho($tamanho)
    {
        $this->tamanho = $tamanho;
    }

    /**
     * @return mixed
     */
    public function getNulo()
    {
        return $this->nulo;
    }

    /**
     * @param mixed $nulo
     */
    public function setNulo($nulo)
    {
        $this->nulo = $nulo;
    }

    /**
     * @return mixed
     */
    public function getChaveEstrangeira()
    {
        return $this->chaveEstrangeira;
    }

    /**
     * @param mixed $chaveEstrangeira
     */
    public function setChaveEstrangeira($chaveEstrangeira)
    {
        $this->chaveEstrangeira = $chaveEstrangeira;
    }

    /**
     * @return mixed
     */
    public function getClasseEstrangeira()
    {
        return $this->classeEstrangeira;
    }

    /**
     * @param mixed $classeEstrangeira
     */
    public function setClasseEstrangeira($classeEstrangeira)
    {
        $this->classeEstrangeira = $classeEstrangeira;
    }



}