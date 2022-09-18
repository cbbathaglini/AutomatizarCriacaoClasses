<?php


class ConversaoTabela
{
    private $nomeTabela;
    private $nomeClasse;
    private $arrCampos;



    /**
     * ConversaoTabela constructor.
     * @param $nomeTabela
     * @param $nomeClasse
     * @param $arrCampos
     */
    public function __construct($nomeTabela, $nomeClasse, $arrCampos)
    {
        $this->nomeTabela = $nomeTabela;
        $this->nomeClasse = $nomeClasse;
        $this->arrCampos = $arrCampos;
    }


    /**
     * @return mixed
     */
    public function getNomeTabela()
    {
        return $this->nomeTabela;
    }

    /**
     * @param mixed $nomeTabela
     */
    public function setNomeTabela($nomeTabela)
    {
        $this->nomeTabela = $nomeTabela;
    }

    /**
     * @return mixed
     */
    public function getNomeClasse()
    {
        return $this->nomeClasse;
    }

    /**
     * @param mixed $nomeClasse
     */
    public function setNomeClasse($nomeClasse)
    {
        $this->nomeClasse = $nomeClasse;
    }

    /**
     * @return mixed
     */
    public function getArrCampos()
    {
        return $this->arrCampos;
    }

    /**
     * @param mixed $arrCampos
     */
    public function setArrCampos($arrCampos)
    {
        $this->arrCampos = $arrCampos;
    }


}