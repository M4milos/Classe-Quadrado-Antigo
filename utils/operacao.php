<?php

    require_once("../class/tabuleiro.class.php");

    function Exibir($chave, $dado){
        $str = "<option value=0>Selecione</option>";
        foreach($dado as $linha){
            $str .= "<option value='".$linha[$chave[0]]."'>ID: ".$linha[$chave[0]]." Lado: ".$linha[$chave[1]]."</option>";
        }
        return $str;
    }

    function ListarTabuleiro(){
        $tab = new Tabuleiro("","");
        $lista = $tab->Listar();
        var_dump($lista);
        return Exibir(array('idTabuleiro','Lado'),$lista);
    }
?>