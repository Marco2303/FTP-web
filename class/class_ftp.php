<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_ftp
 *
 * @author MTosti
 */
class class_ftp {
    //gestione dell'accesso ftp
    var $server;
    var $user;
    var $password;
    
    private $lista_cartella = array();
    private $path_ftp = "";
    private $nome_file = "";
    private $byte_file = 0;
    
    function __construct(){
         $this->path_ftp = "/";
    } 

    public function set_path_ftp($crt){
        $this->path_ftp = $crt;
    }
    
    public function set_server($srv){
        $this->server = $srv;
    }
    
    public function set_user($usr){
        $this->user = $usr;
    }

    public function set_pass($pass){
        $this->password = $pass;
    }
    
    public function get_lista_cretella(){
        return $this->lista_cartella;
    }

    public function get_tipo_cretella(){
        #restituisce true se è una cartella
        return $this->cartella;
    }

    public function get_nome_file(){
        #restituisce il nome del file dalla stringa passata a estrai_da_lista
        return $this->nome_file;
    }

    public function get_byte_file(){
        #restituisce la grandezza del file dalla stringa passata a estrai_da_lista
        return $this->byte_file;
    }

        public function get_path_ftp(){
        #restituisce la il percorso ftp
        return $this->path_ftp;
    }

    public function accedi_ftp() {
        
        echo "server " . $this->server;
        echo $this->user;
        echo $this->password;
        $connect = ftp_connect($this->server);
        echo $connect;
        $result = ftp_login($connect,$this->user, $this->password);
        echo $result;
        if ($result==FALSE){ print "impossibile accedere al server ftp";}
        
        $this->lista_cartella = ftp_rawlist($connect, $this->path_ftp);
            
        }
     
   function estrai_da_lista($string){
        #Questa funzione estrae le informzioni da una riga della lista generata da accedi_ftp e le
        #inserisce in semplici variabili

       $this->nome_file = substr($string, 55, strlen($string) - 55);
       $this->byte_file = trim(substr($string, 33,10));


       if (strtoupper(substr($string,0,1)) == "D"){
           $this->cartella = TRUE;
       }else{
           $this->cartella = FALSE;
       }       
    }
}

?>
