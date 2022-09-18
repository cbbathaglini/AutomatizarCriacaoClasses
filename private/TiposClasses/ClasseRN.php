<?php


class ClasseRN
{


    public static function escrever(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        foreach ($objConversao->getArrCampos() as $objCampo){
            switch ($objCampo->getTipo()){
                case TiposCampos::$TIPO_INT:
                    $conteudo .=self::tipoInteiro($objConversao,$objCampo);
                    break;
                case TiposCampos::$TIPO_LONGTEXT:
                    $conteudo .=self::tipoLongText($objConversao,$objCampo);
                    break;
            }
        }

        $conteudo .= self::cadastrar($objConversao);
        $conteudo .= self::alterar($objConversao);
        $conteudo .= self::consultar($objConversao);
        $conteudo .= self::listar($objConversao);
        $conteudo .= self::remover($objConversao);


        return $conteudo;
    }

    public static function tipoInteiro($objConversao,$objCampo){
        $conteudo = "";
        $conteudo .= "\n\n\tprivate function validar".ucfirst($objCampo->getNome())."(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().", Excecao \$objExcecao){";
        $conteudo .= "\n\t\t \$strInt = trim(\$obj".$objConversao->getNomeClasse()."->get".ucfirst($objCampo->getNome())."());";
        $else="";
        if(!$objCampo->getNulo()) {
            $else = "else";
            $conteudo .= "\n\t\t if(!Utils::getInstance()->validarPalavra(\$strInt,null,true)) {";
            $conteudo .= "\n\t\t\t \$objExcecao->adicionar_validacao('O campo " . $objCampo->getNome() . " não foi informado',Alert::\$danger);";
            $conteudo .= "\n\t\t }";
        }
        $conteudo .= "\n\t\t ".$else." if(!Utils::getInstance()->validarPalavra(\$strInt,null,null,true, true)){";
        $conteudo .= "\n\t\t\t \$objExcecao->adicionar_validacao('O campo ".$objCampo->getNome()." é inválido',Alert::\$danger);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t\t \$obj".$objConversao->getNomeClasse()."->set".ucfirst($objCampo->getNome())."(\$strInt);";
        $conteudo .= "\n\t } \n\n";
        return $conteudo;
    }

    public static function tipoLongText($objConversao,$objCampo){
        $conteudo = "";
        $conteudo .= "\n\n\tprivate function validar".ucfirst($objCampo->getNome())."(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().", Excecao \$objExcecao){";
        $conteudo .= "\n\t\t \$strLongText = trim(\$obj".$objConversao->getNomeClasse()."->get".ucfirst($objCampo->getNome())."());";
        $else="";
        if(!$objCampo->getNulo()) {
            $else = "else";
            $conteudo .= "\n\t\t if(!Utils::getInstance()->validarPalavra(\$strLongText,null,true)) {";
            $conteudo .= "\n\t\t\t \$objExcecao->adicionar_validacao('O campo " . $objCampo->getNome() . " não foi informado',Alert::\$danger);";
            $conteudo .= "\n\t\t }";
        }
        $conteudo .= "\n\t\t ".$else." if(!Utils::getInstance()->validarPalavra(\$strLongText,null,null,true, true)){";
        $conteudo .= "\n\t\t\t \$objExcecao->adicionar_validacao('O campo ".$objCampo->getNome()." é inválido',Alert::\$danger);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t\t \$obj".$objConversao->getNomeClasse()."->set".ucfirst($objCampo->getNome())."(\$strLongText);";
        $conteudo .= "\n\t } \n\n";
        return $conteudo;
    }

    public static function cadastrar(ConversaoTabela $objConversao){
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function cadastrar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().") {";
        $conteudo .= "\n\t\t\$objBanco = new Banco();";
        $conteudo .= "\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$objExcecao = new Excecao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirConexao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirTransacao();\n";

        foreach ($objConversao->getArrCampos() as $objCampo) {
            if(!$objCampo->getEhId()) {
                $conteudo .= "\n\t\t\t\$this->validar" . ucfirst($objCampo->getNome()) . "(\$obj" . $objConversao->getNomeClasse() . ",\$objExcecao);";
            }
        }
        $conteudo .= "\n\n\t\t\t\$objExcecao->lancar_validacoes();";

        $conteudo .= "\n\n\t\t\t\$obj".$objConversao->getNomeClasse()."BD = new ".$objConversao->getNomeClasse()."BD();";
        $conteudo .= "\n\t\t\t\$obj".$objConversao->getNomeClasse()." = \$obj".$objConversao->getNomeClasse()."BD->cadastrar(\$obj".$objConversao->getNomeClasse().",\$objBanco);";
        $conteudo .= "\n\n\t\t\t\$objBanco->confirmarTransacao();";
        $conteudo .= "\n\t\t\t\$objBanco->fecharConexao();";
        $conteudo .= "\n\t\t\treturn \$obj".$objConversao->getNomeClasse().";";
        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\t\$objBanco->cancelarTransacao();";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro cadastrando ".$objConversao->getNomeClasse().".', \$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function alterar(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function alterar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().") {";
        $conteudo .= "\n\t\t\$objBanco = new Banco();";
        $conteudo .= "\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$objExcecao = new Excecao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirConexao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirTransacao();\n";

        foreach ($objConversao->getArrCampos() as $objCampo) {
             $conteudo .= "\n\t\t\t\$this->validar" . ucfirst($objCampo->getNome()) . "(\$obj" . $objConversao->getNomeClasse() . ",\$objExcecao);";
        }
        $conteudo .= "\n\n\t\t\t\$objExcecao->lancar_validacoes();";

        $conteudo .= "\n\n\t\t\t\$obj".$objConversao->getNomeClasse()."BD = new ".$objConversao->getNomeClasse()."BD();";
        $conteudo .= "\n\t\t\t\$obj".$objConversao->getNomeClasse()." = \$obj".$objConversao->getNomeClasse()."BD->alterar(\$obj".$objConversao->getNomeClasse().",\$objBanco);";
        $conteudo .= "\n\n\t\t\t\$objBanco->confirmarTransacao();";
        $conteudo .= "\n\t\t\t\$objBanco->fecharConexao();";
        $conteudo .= "\n\t\t\treturn \$obj".$objConversao->getNomeClasse().";";
        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\t\$objBanco->cancelarTransacao();";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro alterando ".$objConversao->getNomeClasse().".', \$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function consultar(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function consultar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().") {";
        $conteudo .= "\n\t\t\$objBanco = new Banco();";
        $conteudo .= "\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$objExcecao = new Excecao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirConexao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirTransacao();\n";

        foreach ($objConversao->getArrCampos() as $objCampo) {
            if($objCampo->getEhId()) {
                $conteudo .= "\n\t\t\t\$this->validar" . ucfirst($objCampo->getNome()) . "(\$obj" . $objConversao->getNomeClasse() . ",\$objExcecao);";
                break;
            }
        }
        $conteudo .= "\n\n\t\t\t\$objExcecao->lancar_validacoes();";

        $conteudo .= "\n\n\t\t\t\$obj".$objConversao->getNomeClasse()."BD = new ".$objConversao->getNomeClasse()."BD();";
        $conteudo .= "\n\t\t\t\$obj".$objConversao->getNomeClasse()." = \$obj".$objConversao->getNomeClasse()."BD->consultar(\$obj".$objConversao->getNomeClasse().",\$objBanco);";
        $conteudo .= "\n\n\t\t\t\$objBanco->confirmarTransacao();";
        $conteudo .= "\n\t\t\t\$objBanco->fecharConexao();";
        $conteudo .= "\n\t\t\treturn \$obj".$objConversao->getNomeClasse().";";
        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\t\$objBanco->cancelarTransacao();";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro consultando ".$objConversao->getNomeClasse().".', \$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function listar(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function listar(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().",\$numLimite=null,\$arrPesquisa=null) {";
        $conteudo .= "\n\t\t\$objBanco = new Banco();";
        $conteudo .= "\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$objExcecao = new Excecao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirConexao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirTransacao();\n";

        $conteudo .= "\n\n\t\t\t\$objExcecao->lancar_validacoes();";

        $conteudo .= "\n\n\t\t\t\$obj".$objConversao->getNomeClasse()."BD = new ".$objConversao->getNomeClasse()."BD();";
        $conteudo .= "\n\t\t\t\$obj".$objConversao->getNomeClasse()." = \$obj".$objConversao->getNomeClasse()."BD->listar(\$obj".$objConversao->getNomeClasse().",\$numLimite,\$arrPesquisa,\$objBanco);";
        $conteudo .= "\n\n\t\t\t\$objBanco->confirmarTransacao();";
        $conteudo .= "\n\t\t\t\$objBanco->fecharConexao();";
        $conteudo .= "\n\t\t\treturn \$obj".$objConversao->getNomeClasse().";";
        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\t\$objBanco->cancelarTransacao();";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro listando ".$objConversao->getNomeClasse().".', \$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }

    public static function remover(ConversaoTabela $objConversao)
    {
        $conteudo = "";
        $conteudo = "";
        $conteudo .= "\n\n\tpublic function remover(".$objConversao->getNomeClasse()." \$obj".$objConversao->getNomeClasse().") {";
        $conteudo .= "\n\t\t\$objBanco = new Banco();";
        $conteudo .= "\n\t\ttry {";
        $conteudo .= "\n\t\t\t\$objExcecao = new Excecao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirConexao();";
        $conteudo .= "\n\t\t\t\$objBanco->abrirTransacao();\n";

        foreach ($objConversao->getArrCampos() as $objCampo) {
            if($objCampo->getEhId()) {
                $conteudo .= "\n\t\t\t\$this->validar" . ucfirst($objCampo->getNome()) . "(\$obj" . $objConversao->getNomeClasse() . ",\$objExcecao);";
                break;
            }
        }
        $conteudo .= "\n\n\t\t\t\$objExcecao->lancar_validacoes();";

        $conteudo .= "\n\n\t\t\t\$obj".$objConversao->getNomeClasse()."BD = new ".$objConversao->getNomeClasse()."BD();";
        $conteudo .= "\n\t\t\t\$obj".$objConversao->getNomeClasse()." = \$obj".$objConversao->getNomeClasse()."BD->remover(\$obj".$objConversao->getNomeClasse().",\$objBanco);";
        $conteudo .= "\n\n\t\t\t\$objBanco->confirmarTransacao();";
        $conteudo .= "\n\t\t\t\$objBanco->fecharConexao();";
        $conteudo .= "\n\t\t\treturn \$obj".$objConversao->getNomeClasse().";";
        $conteudo .= "\n\n\t\t} catch (Throwable \$e) {";
        $conteudo .= "\n\t\t\t\$objBanco->cancelarTransacao();";
        $conteudo .= "\n\t\t\tthrow new Excecao('Erro consultando ".$objConversao->getNomeClasse().".', \$e);";
        $conteudo .= "\n\t\t}";
        $conteudo .= "\n\t}";
        return $conteudo;
    }



//
//    private function validarCodigo(Habilidade $objHabilidade,Excecao $objExcecao){
//        $strCodigo = trim($objHabilidade->getCodigo());
//
//        if (!Utils::getInstance()->validarPalavra($strCodigo,null,true)) {
//            $objExcecao->adicionar_validacao('O código da habilidade não foi informado',Alert::$danger);
//        }else if(!Utils::getInstance()->validarPalavra($strCodigo,true)){
//            $objExcecao->adicionar_validacao('O código da habilidade é inválido',Alert::$danger);
//        }else if(strlen($strCodigo) > self::$TAM_STR_CODIGO){
//            $objExcecao->adicionar_validacao('O código da habilidade tem um tamanho é inválido',Alert::$danger);
//        }
//
//        $objHabilidade->setCodigo($strCodigo);
//    }
}