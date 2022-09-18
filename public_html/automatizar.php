<?php
require_once __DIR__ . '/requires.php';

/*
$objCampo1 = new Campo("idHipotese","int",true,null,false,false,null);
$objCampo2 = new Campo("hipotese","longtext",false,null,false,false,null);
$objCampo3 = new Campo("idSubprojeto","int",false,null,false, true,"Subprojeto");
$objConversao = new ConversaoTabela("hipotese","Hipotese",array($objCampo1,$objCampo2,$objCampo3));


Gerar::gerarArquivo($objConversao,Indices::$TIPO_BANCO_DADOS);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_REGRA_NEGOCIO);
Gerar::gerarArquivo($objConversao,"");
Gerar::gerarArquivo($objConversao,Indices::$TIPO_MONTAR_BD);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_TAGS);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_INTERFACE);


$objCampo1 = new Campo("idCurtida","int",true,null,false,false,null);
$objCampo2 = new Campo("idProjeto","int",false,null,false,true,"Projeto");
$objCampo3 = new Campo("idUsuario","int",false,null,false, true,"Usuario");
$objConversao = new ConversaoTabela("curtidas","Curtida",array($objCampo1,$objCampo2,$objCampo3));


Gerar::gerarArquivo($objConversao,Indices::$TIPO_BANCO_DADOS);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_REGRA_NEGOCIO);
Gerar::gerarArquivo($objConversao,"");
Gerar::gerarArquivo($objConversao,Indices::$TIPO_MONTAR_BD);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_TAGS);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_INTERFACE);

$objCampo1 = new Campo("idSubprojetoAlunos","int",true,null,false,false,null);
$objCampo2 = new Campo("idSubProjeto","int",false,null,false,true,"SubProjeto");
$objCampo3 = new Campo("idUsuario","int",false,null,false, true,"Usuario");
$objConversao = new ConversaoTabela("subprojeto_alunos","SubProjetoAlunos",array($objCampo1,$objCampo2,$objCampo3));


Gerar::gerarArquivo($objConversao,Indices::$TIPO_BANCO_DADOS);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_REGRA_NEGOCIO);
Gerar::gerarArquivo($objConversao,"");
Gerar::gerarArquivo($objConversao,Indices::$TIPO_MONTAR_BD);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_TAGS);
Gerar::gerarArquivo($objConversao,Indices::$TIPO_INTERFACE);

*/

$objConversao = new ConversaoTabela("","",null);
$campos = ""; $numeroCampos = "";
if(isset($_POST['btnSubmit'])){
    $numeroCampos = (int)$_POST['qtde_campos'];

    $arrCampos = array();
    for($i=1; $i<=$numeroCampos; $i++){
        $objCampo = new Campo(
            $_POST['campo_'.$i.'_nome'],
            $_POST['campo_'.$i.'_tipo'],
            $_POST['campo_'.$i.'_ehId'],
            $_POST['campo_'.$i.'_tamanho'],
            $_POST['campo_'.$i.'_nulo'],
            $_POST['campo_'.$i.'_ehChaveEstrangeira'],
            $_POST['campo_'.$i.'_nomeClasseChaveEstrangeira']);
        $campos .= '
        <h5 style="padding: 5px; margin-top: 10px">Campo '.$i.'</h5>
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group styleform">
                    <label for="campo_'.$i.'_nome">Nome</label>
                    <input type="text" class="form-control" name="campo_'.$i.'_nome" value="'.$objCampo->getNome().'">
                </div>
            </div>   
            <div class="col-sm-4">
                <div class="form-group styleform">
                    <label for="campo_'.$i.'_tipo">tipo</label>
                    <input type="text" class="form-control" name="campo_'.$i.'_tipo" placeholder="string, int" value="'.$objCampo->getTipo().'">
                </div>
           </div>
           <div class="col-sm-4">
                <div class="form-group styleform">   
                    <label for="campo_'.$i.'_ehId">EhId</label>
                    <input type="text" class="form-control" name="campo_'.$i.'_ehId" placeholder="true or false" value="'.$objCampo->getEhId().'">
            </div>
           </div>
        </div>
        
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group styleform">
                    <label for="campo_'.$i.'_tamanho">Tamanho</label>
                    <input type="text" class="form-control" name="campo_'.$i.'_tamanho" value="'.$objCampo->getTamanho().'">
                </div>
            </div>
             <div class="col-sm-6">
                <div class="form-group styleform">
                    <label for="campo_'.$i.'_nulo">nulo</label>
                    <input type="text" class="form-control" name="campo_'.$i.'_nulo" placeholder="true or false" value="'.$objCampo->getNulo().'">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group styleform">    
                    <label for="campo_'.$i.'_ehChaveEstrangeira">EhChaveEstrangeira</label>
                    <input type="text" class="form-control" name="campo_'.$i.'_ehChaveEstrangeira" placeholder="true or false" value="'.$objCampo->getChaveEstrangeira().'">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group styleform">
                    <label for="campo_'.$i.'_nomeClasseChaveEstrangeira">Nome da classe da chave estrangeira</label>
                    <input type="text" class="form-control" name="campo_'.$i.'_nomeClasseChaveEstrangeira" placeholder="" value="'.$objCampo->getClasseEstrangeira().'">
                </div>
            </div>
        </div>
        
    ';
        $arrCampos[] = $objCampo;
    }

    $objConversao->setNomeClasse($_POST['nome_classe']);
    $objConversao->setNomeTabela($_POST['nome_tabela']);
    $objConversao->setArrCampos($arrCampos);
    if(count($arrCampos) > 0){
        Gerar::gerarArquivo($objConversao,"");
        Gerar::gerarArquivo($objConversao,Indices::$TIPO_REGRA_NEGOCIO);
        Gerar::gerarArquivo($objConversao,Indices::$TIPO_MONTAR_BD);
        Gerar::gerarArquivo($objConversao,Indices::$TIPO_BANCO_DADOS);
        Gerar::gerarArquivo($objConversao,Indices::$TIPO_TAGS);
        Gerar::gerarArquivo($objConversao,Indices::$TIPO_INTERFACE);
    }
}

Pagina::head();
Pagina::abrir_body();
echo '
  
<form method="post" style="margin:10px">
  <div class="form-group styleform">
    <label for="nome_tabela">Nome da tabela</label>
    <input type="text" class="form-control" id="nome_tabela" name="nome_tabela" placeholder="Nome da tabela" value="'.$objConversao->getNomeTabela().'">
  </div>
  
  <div class="form-group styleform">
    <label for="nome_classe">Nome da classe</label>
    <input type="text" class="form-control" id="nome_classe" name="nome_classe" placeholder="Nome da classe" value="'.$objConversao->getNomeClasse().'">
  </div>

  <div class="form-group styleform">
    <label for="qtde_campos">Quantidade de campos</label>
    <input type="number" class="form-control" id="qtde_campos" name="qtde_campos" aria-describedby="Quantidade de campos" placeholder="Quantidade de campos" value="'.$numeroCampos.'">
  </div>
   '.$campos.'
  <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
</form>
';

Pagina::fechar_body();