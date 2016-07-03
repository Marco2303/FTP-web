<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_user
 *
 * @author MTosti
 */
class class_user {
    //put your code here
    private $utente_nome;
    private $utente_password;
    private $conn;
    
    private $mysql_server;
    private $mysql_user;
    private $mysql_password;
    private $mysql_db;
    private $tabella_utenti;
   
    
    protected function get_conn(){
        return $this->conn;
    }
    
    protected function get_mysqldb(){
        return $this->mysql_db;
    }
    
    public function set_UtenteNome($nome){
        $this->utente_nome = $nome;
    } 

    public function set_UtentePassword($pass){
        $this->utente_password = $pass;
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
    
    public function set_db($db){
        $this->mysql_db = $db;
    }

    public function set_tabella_utenti($user){
        $this->tabella_utenti = $user;
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
    public function identifica_utente(){
        #seleziona l'utente dalla tabella users e verifica che la password sia corretta
        
        #deleziona il database
        $db = mysql_select_db($this->mysql_db,  $this->conn);
        if (!isset($db)){
            return false;
        }
        
        #seleziona l'utente e controlla la password
        $temp = "select * from users where cusers_uname_ftp='" . $this->utente_nome . "';";
        $select = mysql_query ($temp);
        if (!isset($select)){
            return FALSE;
        }
        
        $select = mysql_fetch_assoc($select);
        foreach ($select as $key => $value) {
            if($key == "cusers_pass_ftp"){
                if($value == trim($this->utente_password)){
                    #memorizza le informazioni dell'utente in una variabile di sessione
                    return TRUE;
                }
                else {
                    return FALSE;
                }
            }            
        }               
    }    
}
?>