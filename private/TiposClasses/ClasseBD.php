<?php


class ClasseBD
{
    public static function escrever(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo .= self::cadastrar($objConversao);
        $conteudo .= self::alterar($objConversao);
        $conteudo .= self::consultar($objConversao);
        $conteudo .= self::listar($objConversao);
        $conteudo .= self::remover($objConversao);


        return $conteudo;
    }



    public static function cadastrar(ConversaoTabela $objConversao){
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function cadastrar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().", Banco \$objBanco) {";
        $conteudo .= "\n\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$INSERT = 'INSERT INTO '.".$objConversao->getNomeClasse()."Montar::\$TABLE_NAME.' ( ' .";

        $virgula ="";$interrogacoes = $virgulaInterrogacoes ="";
        foreach ($objConversao->getArrCampos() as $objCampo) {
            $conteudo .=  $virgula."\n\t\t\t\t" .$objConversao->getNomeClasse() . "Montar::".$objCampo->getNome()."()";
            $virgula =".','.";

            $interrogacoes .=$virgulaInterrogacoes."?";
            $virgulaInterrogacoes = ',';
        }

        $conteudo .="\n\t\t\t.') VALUES (".$interrogacoes.")';\n";
        $conteudo .= "\n\t\t\t\$arrayBind = array();\n";$tipo="";
        foreach ($objConversao->getArrCampos() as $objCampo) {
            if(!$objCampo->getEhId()) {
                if ($objCampo->getTipo() == TiposCampos::$TIPO_LONGTEXT || $objCampo->getTipo() == TiposCampos::$TIPO_CHAR || $objCampo->getTipo() == TiposCampos::$TIPO_VARCHAR) $tipo = 's';
                if ($objCampo->getTipo() == TiposCampos::$TIPO_INT) $tipo = 'i';
                $conteudo .= "\t\t\t\$arrayBind[] = array('" . $tipo . "',\$obj" . $objConversao->getNomeClasse() . "->get" . ucfirst($objCampo->getNome()) . "());\n";
            }
        }

        $conteudo .= "\n\n\t\t\t\$objBanco->executarSQL(\$INSERT,\$arrayBind);";
        foreach ($objConversao->getArrCampos() as $objCampo) {
            if($objCampo->getEhId()) {
                $conteudo .= "\n\n\t\t\t\$obj" . $objConversao->getNomeClasse() . "->set".ucfirst($objCampo->getNome())."(\$objBanco->obterUltimoID());";
            }
        }
        $conteudo .= "\n\t\t\treturn \$obj" . $objConversao->getNomeClasse() . ";";

        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro cadastrando ".$objConversao->getNomeClasse()."',\$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function alterar(ConversaoTabela $objConversao){
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function alterar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().", Banco \$objBanco) {";
        $conteudo .= "\n\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$UPDATE = 'UPDATE '.".$objConversao->getNomeClasse()."Montar::\$TABLE_NAME.' SET'.";

        $virgula =" .'=?,'."; $id="";$i=0;
        foreach ($objConversao->getArrCampos() as $objCampo) {

            if ($i == count($objConversao->getArrCampos())-1) {
                $virgula =" .'=?'.";
            }
            $conteudo .=  "\n\t\t\t\t" .$objConversao->getNomeClasse() . "Montar::".$objCampo->getNome()."()".$virgula;


            if($objCampo->getEhId()) {
                $id =$objCampo->getNome()."()";
            }
            $i++;
        }

        $conteudo .="\n\t\t\t' where '.".$objConversao->getNomeClasse()."Montar::".$id.".'=?';\n";

        $conteudo .= "\n\t\t\t\$arrayBind = array();\n";$tipo=$id="";
        foreach ($objConversao->getArrCampos() as $objCampo) {
            if(!$objCampo->getEhId()) {
                if ($objCampo->getTipo() == TiposCampos::$TIPO_LONGTEXT || $objCampo->getTipo() == TiposCampos::$TIPO_CHAR || $objCampo->getTipo() == TiposCampos::$TIPO_VARCHAR) $tipo = 's';
                if ($objCampo->getTipo() == TiposCampos::$TIPO_INT) $tipo = 'i';
                $conteudo .= "\t\t\t\$arrayBind[] = array('" . $tipo . "',\$obj" . $objConversao->getNomeClasse() . "->get" . ucfirst($objCampo->getNome()) . "());\n";
            }else{
                $id = "\t\t\t\$arrayBind[] = array('i',\$obj" . $objConversao->getNomeClasse() . "->get" . ucfirst($objCampo->getNome()) . "());\n";
            }
        }
        $conteudo .= $id;

        $conteudo .= "\n\n\t\t\t\$objBanco->executarSQL(\$UPDATE,\$arrayBind);";
        $conteudo .= "\n\t\t\treturn \$obj" . $objConversao->getNomeClasse() . ";";

        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro alterando ".$objConversao->getNomeClasse()."',\$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function consultar(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function consultar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().", Banco \$objBanco) {";
        $conteudo .= "\n\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$SELECT = 'SELECT * FROM '.".$objConversao->getNomeClasse()."Montar::\$TABLE_NAME.' WHERE'.";

        $id=$idget="";
        foreach ($objConversao->getArrCampos() as $objCampo) {
            if($objCampo->getEhId()) {
                $id =$objCampo->getNome()."()";
                $idget = ucfirst($objCampo->getNome())."()";
            }
            if($objCampo->getChaveEstrangeira()){
                $chavesArray[] = $objCampo;
            }
        }

        $conteudo .="\n\t\t\t".$objConversao->getNomeClasse()."Montar::".$id.".'=?';\n";

        $conteudo .= "\n\t\t\t\$arrayBind = array();\n";
        $conteudo .= "\t\t\t\$arrayBind[] = array('i',\$obj" . $objConversao->getNomeClasse() . "->get" . $idget . ");\n";


        $conteudo .= "\n\n\t\t\t\$arr = \$objBanco->consultarSQL(\$SELECT,\$arrayBind);";
        $conteudo .= "\n\t\t\tif(count(\$arr) > 0 ) {";

        $conteudo .= "\n\t\t\t\t\$objRet" . $objConversao->getNomeClasse() ." = new ".$objConversao->getNomeClasse()."();";
        $conteudo .= "\n\t\t\t\t" . $objConversao->getNomeClasse() ."Montar::montar_consulta(\$objRet" . $objConversao->getNomeClasse() .", \$arr,'consultar');";

        foreach ($chavesArray as $campo) {
            $conteudo .= "\n\n\t\t\t\tif(!is_null(\$objRet" . $objConversao->getNomeClasse() ."->get".ucfirst($campo->getNome())."())){";
            $conteudo .= "\n\t\t\t\t\t\$objRet" . $campo->getClasseEstrangeira() ." = new ".$campo->getClasseEstrangeira()."();";
            $conteudo .= "\n\t\t\t\t\t". $campo->getClasseEstrangeira() ."Montar::montar_consulta(\$objRet" . $campo->getClasseEstrangeira() .", \$arr,'consultar');";
            $conteudo .= "\n\t\t\t\t\t\$objRet" . $objConversao->getNomeClasse() . "->setObj".$campo->getClasseEstrangeira()."(\$objRet" . $campo->getClasseEstrangeira().");";
            $conteudo .= "\n\t\t\t\t}\n";
        }

        $conteudo .= "\n\t\t\t\treturn \$objRet" . $objConversao->getNomeClasse() .";";
        $conteudo .= "\n\t\t\t}";

        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro consultando ".$objConversao->getNomeClasse()."',\$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function listar(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function listar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().", \$numLimite=null,\$arrPesquisa=null,Banco \$objBanco) {";
        $conteudo .= "\n\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$SELECT = 'SELECT * FROM '.".$objConversao->getNomeClasse()."Montar::\$TABLE_NAME;";
        $conteudo .= "\n\t\t\t\$FROM = '';";
        $conteudo .= "\n\t\t\t\$WHERE = '';";
        $conteudo .= "\n\t\t\t\$AND = '';";
        $conteudo .= "\n\t\t\t\$arrayBind = array();";

        $id=$idget="";
        foreach ($objConversao->getArrCampos() as $objCampo) {
                $conteudo .= "\n\t\t\tif(!is_null(\$obj".$objConversao->getNomeClasse()."->get".ucfirst($objCampo->getNome())."()) && strlen(\$obj".$objConversao->getNomeClasse()."->get".ucfirst($objCampo->getNome())."()) > 0) {";
                $conteudo .= "\n\t\t\t\t\$WHERE .=  \$AND.".$objConversao->getNomeClasse()."Montar::".$objCampo->getNome()."().' = ?  ';";
                $conteudo .= "\n\t\t\t\t\$AND = ' and ';";
                $conteudo .= "\n\t\t\t\t\$arrayBind[] = array('s', \$obj".$objConversao->getNomeClasse()."->get".ucfirst($objCampo->getNome())."());";
                $conteudo .= "\n\t\t\t}\n";

            if($objCampo->getChaveEstrangeira()){
                $chavesArray[] = $objCampo;
            }
        }

        $conteudo .= "\n\t\t\tif(\$WHERE != ''){";
        $conteudo .= "\n\t\t\t\t\$WHERE = ' where '.\$WHERE;";
        $conteudo .= "\n\t\t\t}\n";

        $conteudo .= "\n\t\t\t\$LIMIT = '';";
        $conteudo .= "\n\t\t\tif(!is_null(\$numLimite)){";
        $conteudo .= "\n\t\t\t\$LIMIT = ' LIMIT ?';";
        $conteudo .= "\n\t\t\t\t\$arrayBind[] = array('i',\$numLimite);";
        $conteudo .= "\n\t\t\t}\n";

        $conteudo .= "\n\n\t\t\t\$arr = \$objBanco->consultarSQL(\$SELECT.\$FROM.\$WHERE.\$LIMIT,\$arrayBind);";
        $conteudo .= "\n\n\t\t\t\$array = array();";
        $conteudo .= "\n\t\t\tif(count(\$arr) > 0 ) {";
        $conteudo .= "\n\t\t\t\tforeach (\$arr as \$reg) {";

        $conteudo .= "\n\t\t\t\t\t\$objRet" . $objConversao->getNomeClasse() ." = new ".$objConversao->getNomeClasse()."();";
        $conteudo .= "\n\t\t\t\t\t" . $objConversao->getNomeClasse() ."Montar::montar_consulta(\$objRet" . $objConversao->getNomeClasse() .", \$reg,'listar');";

        foreach ($chavesArray as $campo) {
            $conteudo .= "\n\n\t\t\t\t\tif(!is_null(\$objRet" . $objConversao->getNomeClasse() ."->get".ucfirst($campo->getNome())."())){";
            $conteudo .= "\n\t\t\t\t\t\t\$objRet" . $campo->getClasseEstrangeira() ." = new ".$campo->getClasseEstrangeira()."();";
            $conteudo .= "\n\t\t\t\t\t\t". $campo->getClasseEstrangeira() ."Montar::montar_consulta(\$objRet" . $campo->getClasseEstrangeira() .", \$reg,'consultar');";
            $conteudo .= "\n\t\t\t\t\t\t\$objRet" . $objConversao->getNomeClasse() . "->setObj".$campo->getClasseEstrangeira()."(\$objRet" . $campo->getClasseEstrangeira().");";
            $conteudo .= "\n\t\t\t\t\t}\n";
        }

        $conteudo .= "\n\t\t\t\t\t\$array[] =\$objRet" . $objConversao->getNomeClasse() .";";
        $conteudo .= "\n\t\t\t\t}";

        $conteudo .= "\n\t\t\t}";


        $conteudo .= "\n\t\t\treturn \$array;";
        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro listando ".$objConversao->getNomeClasse()."',\$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function remover(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function remover(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().", Banco \$objBanco) {";
        $conteudo .= "\n\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$DELETE = 'DELETE FROM '.".$objConversao->getNomeClasse()."Montar::\$TABLE_NAME.' WHERE'.";

        $id=$idget="";
        foreach ($objConversao->getArrCampos() as $objCampo) {
            if($objCampo->getEhId()) {
                $id =$objCampo->getNome()."()";
                $idget = ucfirst($objCampo->getNome())."()";
            }
        }

        $conteudo .="\n\t\t\t".$objConversao->getNomeClasse()."Montar::".$id.".'=?';\n";

        $conteudo .= "\n\t\t\t\$arrayBind = array();\n";
        $conteudo .= "\t\t\t\$arrayBind[] = array('i',\$obj" . $objConversao->getNomeClasse() . "->get" . $idget . ");\n";


        $conteudo .= "\n\n\t\t\t\$objBanco->executarSQL(\$DELETE,\$arrayBind);";


        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro removendo ".$objConversao->getNomeClasse()."',\$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

}