<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_userftp
 *
 * @author MTosti
 */
class class_userftp {
    //put your code here
    private $tabella_ftpuser;
    private $lista_accountftp = array();
    
    private $mysql_server;
    private $mysql_user;
    private $mysql_password;
    private $mysql_db;
    private $tabella_utentiftp;

    public function set_db($db){
        $this->mysql_db = $db;
    }

    public function set_tabella_utentiftp($user){
        $this->tabella_utentiftp = $user;
    }
    
    public function set_mysql_server($server){
        $this->mysql_server = $server;
    }
    
    public function set_mysql_user($user){
        $this->mysql_user = $user;
    }
    
    public function set_mysql_password($pass){
        $this->mysql_password = $pass;
    }
    
    public function set_tabella_ftpuser($user2){
        $this->tabella_ftpuser = $user2;
    }

    public function get_lista_accountftp(){
        return $this->lista_accountftp;
    }

    public function apri_database(){
        #apre una sessione database e restituisce la connect
        $connect = mysql_connect($this->mysql_server, $this->mysql_user, $this->mysql_password) 
                or die ("Connesione al db fallita");
        
        if (isset($connect)){
            $this->conn=$connect;
            return $connect;
        }else{
            return FALSE;
        }
     }

    public function accesso_ftp(){
        #estrae i dati dell'utente per l'accesso ftp
         #deleziona il database
        $db = mysql_select_db($this->mysql_db );
        if (!isset($db)){
            return false;
        }

        
        $select = "select `ftp-uname`, `ftp-server`, `ftp-accountname`, `ftp-accountpass` 
                    from `ftp-users` where `ftp-uname` = '" . $_SESSION['nome_utente'] . "';";
        
       $query = mysql_query ($select);
        if (!$query){
            return FALSE;
        }
        
        $this->lista_accountftp = mysql_fetch_assoc($query);
         
    }
    
    public function get_serverdefault(){
        
        $ftp_default = $this->lista_accountftp['ftp-server'];
        return $ftp_default;
        
    }
    
    public function get_lista_serverftp(){
         #deleziona il database
        $db = mysql_select_db($this->mysql_db );
        if (!isset($db)){
            return false;
        }
        
        $select = "select `ftp-server` 
                    from `ftp-users` where `ftp-uname` = '" . $_SESSION['nome_utente'] . "';";
       
       $query = mysql_query ($select);
        if (!$query){
            return FALSE;
        }
        $lista_server = array();
        
        #while($row = mysql_fetch_($query)){
        #    $lista_server[] = $row;
        #}
         
        return  $lista_server;
        
    }
 
}

?>
