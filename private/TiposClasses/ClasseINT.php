<?php


class ClasseINT
{

    public static function escrever(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo.="\n\tprivate static \$instance;";
        $conteudo.="\n\tpublic static  function getInstance(){";
        $conteudo.="\n\t\tif(self::\$instance == null){";
        $conteudo.="\n\t\t\t    self::\$instance= new ".$objConversao->getNomeClasse()."INT();";
        $conteudo.="\n\t\t }";
        $conteudo.="\n\t\treturn self::\$instance;";
        $conteudo.="\n\t}";
        return $conteudo;
    }
}