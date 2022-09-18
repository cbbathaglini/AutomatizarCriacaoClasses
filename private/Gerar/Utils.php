<?php


class Utils
{
    public static function criarPasta($caminho){
        mkdir($caminho, 0770, true);
    }


}