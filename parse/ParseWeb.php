<?php 
namespace parse;

include_once __DIR__ . '\phpQuery\phpQuery\phpQuery.php';
include 'models\procedure.php';

use models\Procedure;
use phpQuery;

class ParseWeb {

    public static function Parse(string $siteName){
        $procArray = [];
        $baseAdress = "https://etp.eltox.ru";

        $html = file_get_contents($siteName);
        $doc = phpQuery::newDocument($html);
        $procedures = $doc->find('body div [class="registerBox procedure-list-item"]');   
        foreach ($procedures as $proc) {
            $currentProcedure = new Procedure();
            $pqProc = pq($proc);
            //find 
            $number = $pqProc->find('table tbody tr td dl dt a');
            $oocNumber = $pqProc->find('table tbody tr td dl dt span');
            $adress = pq($number)->attr('href');
            //procedure number
            $currentProcedure->number = pq($number)->text();
            $currentProcedure->number = substr($currentProcedure->number, 47);
            //procedure ooc number
            $currentProcedure->ooc_number = pq($oocNumber)->text();
            $currentProcedure->ooc_number = substr($currentProcedure->ooc_number, 53);
            //procedure page adress
            $currentProcedure->adress = $baseAdress . $adress;
            ParseWeb::ParseProcedurePage($currentProcedure, $currentProcedure->adress);
            // echo "proc adress:", $currentProcedure->adress;
            // echo "current number:", $currentProcedure->number;
            // echo "current ooc:", $currentProcedure->ooc_number;
            // echo " mail: ", $currentProcedure->mail;
            $procArray[] = $currentProcedure;
        }


        return $procArray;
    }

    static private function ParseProcedurePage(Procedure &$proc) {
        $html = file_get_contents($proc->adress);
        $doc = phpQuery::newDocument($html);
        $entry = $doc->find('body div table tr');
        //Извлечь почту
        foreach ($entry as $row) {
            $row = pq($row);
            $name = $row->find('th:eq(0)')->text();
            // echo "name : ", $name;
            if ($name == "Почта") {
                $proc->mail = $row->find('td:eq(0)')->text();
                // echo " mail: ", $proc->mail;
            }
        }    
    }
}
?>