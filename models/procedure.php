<?php 
namespace models;

class Procedure {
    //Номер процедуры, вида: 2187
    public $number;
    //ООС номер процедуры вида: 321
    public $ooc_number;
    //Ссылка на страницу процедуры
    //Например:https://etp.eltox.ru/procedure/read/2187
    public $adress;
    //Поле почта со страницы процедуры
    public $mail;
    //документация массив
    public $doc;
}

?>