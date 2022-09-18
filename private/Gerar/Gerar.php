<?php


class Gerar
{

    private static $nomeArquivo;
    private static $tipoArquivo;

    public static function gerarArquivo(ConversaoTabela $objConversao,$tipo)
    {
        self::$tipoArquivo = $tipo;
        self::$nomeArquivo = $objConversao->getNomeClasse().self::$tipoArquivo;
        $nome_arquivo_nova_com_ext =self::$nomeArquivo.".php";

        $caminho  = __DIR__ .'/../../Gerados/'.$objConversao->getNomeClasse().'/';
        Utils::criarPasta($caminho);
        $arquivo = fopen($caminho.$nome_arquivo_nova_com_ext, "w");
        self::escrever($arquivo,$objConversao);
    }


    public static function escrever($arquivo,ConversaoTabela $objConversao)
    {
        $conteudo = "<?php \nclass ".self::$nomeArquivo;
        $valsClasse =$implements="";
        switch (self::$tipoArquivo){
            case Indices::$TIPO_NORMAL:
                $valsClasse .= ClasseNormal::escrever($objConversao);
                break;
            case Indices::$TIPO_REGRA_NEGOCIO:
                $valsClasse .= ClasseRN::escrever($objConversao);
                break;
            case Indices::$TIPO_MONTAR_BD:
                $implements = " implements MontarBD";
                $valsClasse .= ClasseMontar::escrever($objConversao);
                break;
            case Indices::$TIPO_BANCO_DADOS:
                $valsClasse .= ClasseBD::escrever($objConversao);
                break;
            case Indices::$TIPO_INTERFACE:
                $valsClasse .= ClasseINT::escrever($objConversao);
                break;
        }

        $conteudo .=$implements;
        $conteudo .="{ \n\n";
        $conteudo .= $valsClasse;
        $conteudo .= "\n}\n?>";
       fwrite($arquivo,$conteudo);
       fclose($arquivo);
    }
}