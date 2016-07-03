<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function Generatore(){
    #restituisce un numero casuale da 1 a 1000
    $numero = rand(1,1000);
    return $numero;
}
 
    function estrai_nomef($string){
        #Questa funzione estrae le informzioni da una riga della lista generata da accedi_ftp e le
        #inserisce in semplici variabili
        $nome = substr($string, 55, strlen($string) - 55);
        return $nome;
        
    }       
 function estrai_byte($string){
        #Questa funzione estrae le informzioni da una riga della lista generata da accedi_ftp e le
        #inserisce in semplici variabili

       $byte_file = trim(substr($string, 33,10));
       return $byte_file;

    }
 function estrai_cartella($string){
        #Questa funzione estrae le informzioni da una riga della lista generata da accedi_ftp e le
        #inserisce in semplici variabili
        $tmp = substr($string,0,1);
       if (strtoupper($tmp) == "D"){
           return  TRUE;
       }else{
           return FALSE;
       }       
    }
    
?>