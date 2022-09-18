<?php


class ClasseMontar
{

    public static function escrever(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo .= "\n\tpublic static \$TABLE_NAME = '".$objConversao->getNomeTabela()."';";
        foreach ($objConversao->getArrCampos() as $objCampo){
            $conteudo.=self::atributos($objCampo);
        }
        $conteudo .= "\n";
        $conteudo .= self::montar_consulta($objConversao);
        $conteudo .= self::cada_atributo($objConversao);

        return $conteudo;
    }

    public static function atributos($objCampo){
        $conteudo = "";
        $conteudo .= "\n\tpublic static \$".strtoupper($objCampo->getTipo())."_".strtoupper($objCampo->getNome())." = '".$objCampo->getNome()."';";
        return $conteudo;
    }

    public static function montar_consulta($objConversao){
        $conteudo = "";
        $conteudo .= "\n\tpublic static function montar_consulta(&\$obj".$objConversao->getNomeClasse().", \$arr, \$tipo){";
        $conteudo .= "\n\t\t\$array = \$arr;";
        $conteudo .= "\n\t\tif(\$tipo == 'consultar'){";
        $conteudo .= "\n\t\t\t\$array = \$arr[0];";
        $conteudo .= "\n\t\t}\n";
        foreach ($objConversao->getArrCampos() as $objCampo){
            $conteudo .= "\n\t\t\$obj".$objConversao->getNomeClasse()."->set".ucfirst($objCampo->getNome())."(\$array[self::\$".strtoupper($objCampo->getTipo())."_".strtoupper($objCampo->getNome())."]);";
        }
        $conteudo .= "\n\t}\n";
        return $conteudo;
    }

    public static function cada_atributo($objConversao){
        $conteudo = "";
        $conteudo .= "\n\tpublic static function nomeTabela(){\n";
        $conteudo .= "\t\t return self::\$TABLE_NAME;\n";
        $conteudo .= "\t}\n\n";

        foreach ($objConversao->getArrCampos() as $objCampo){
            $conteudo .= "\t public static function ".$objCampo->getNome()."(){\n";
            $conteudo .= "\t\t return self::\$TABLE_NAME.'.'.self::\$".strtoupper($objCampo->getTipo())."_".strtoupper($objCampo->getNome()).";\n";
            $conteudo .= "\t}\n\n";
        }

        return $conteudo;
    }


}