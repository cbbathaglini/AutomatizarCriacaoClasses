<?php


class ClasseNormal
{
    public static function escrever(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        foreach ($objConversao->getArrCampos() as $objCampo){
            $conteudo.=self::atributos($objCampo);

        }
        $conteudo .= "\n";
        foreach ($objConversao->getArrCampos() as $objCampo){
            $conteudo .= self::get($objCampo);
            $conteudo .= self::set($objCampo);

        }

        return $conteudo;
    }

    public static function atributos($objCampo){
        $conteudo = "";
        $conteudo .= "\n\tprivate \$".$objCampo->getNome().";";
        if($objCampo->getChaveEstrangeira()){
            $conteudo .= "\n\tprivate \$obj".$objCampo->getClasseEstrangeira().";";
        }

        return $conteudo;
    }


    public static function get($objCampo){
        $conteudo = "";
        $conteudo .= "\n\tpublic function get".ucfirst($objCampo->getNome())."(){";
        $conteudo .= "\n\t\t return \$this->".$objCampo->getNome().";";
        $conteudo .= "\n\t } \n";
        if($objCampo->getChaveEstrangeira()){
            $conteudo .= "\n\tpublic function getObj".ucfirst($objCampo->getClasseEstrangeira())."(){";
            $conteudo .= "\n\t\t return \$this->obj".$objCampo->getClasseEstrangeira().";";
            $conteudo .= "\n\t } \n";
        }
        return $conteudo;
    }

    public static function set($objCampo){
        $conteudo = "";
        $conteudo .= "\n\tpublic function set".ucfirst($objCampo->getNome())."(\$".$objCampo->getNome()."){";
        $conteudo .= "\n\t\t \$this->".$objCampo->getNome()."=\$".$objCampo->getNome().";";
        $conteudo .= "\n\t } \n";
        if($objCampo->getChaveEstrangeira()){
            $conteudo .= "\n\tpublic function setObj".ucfirst($objCampo->getClasseEstrangeira())."(\$obj".$objCampo->getClasseEstrangeira()."){";
            $conteudo .= "\n\t\t \$this->obj".$objCampo->getClasseEstrangeira()."=\$obj".$objCampo->getClasseEstrangeira().";";
            $conteudo .= "\n\t } \n";
        }
        return $conteudo;
    }
}