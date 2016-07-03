<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FTP-web</title>
        <link rel="stylesheet" type="text/css" href="css/struttura.css"></link
    </head>
    <body>
        <?php
        #echo "OK home.php";
        include_once 'conf/config.inc';
        include_once 'inc/function.php';
        include_once 'class/class_userftp.php';
        include_once 'class/class_ftp.php';
        
        echo "aprtura sessione";
        session_start();
        
        #verifico che la sessione sia corretta
        if (!isset ($_SESSION['id_sessione'])){
            print "<h1> Accesso non consentito</h1> ";
            return;
        }
        #recupero i dati degli accessi ftp
        $cls_user_ftp = new class_userftp();
        $cls_user_ftp->set_mysql_server($mysql_server);
        echo $mysql_server;
        $cls_user_ftp->set_mysql_user($mysql_user);
        $cls_user_ftp->set_mysql_password($mysql_password);
        $cls_user_ftp->set_tabella_ftpuser($mysql_tabella_ftpuser);
        $cls_user_ftp->set_db($mysql_db);
        
        $conn = $cls_user_ftp->apri_database();
        if ($conn == false) {
            print "<h3>Impossibile accedere al batabase. </h3>";
        } else {
            #estrai dati accesso FTP
            if($cls_user_ftp->accesso_ftp()){
                print "<h3>Impossibile estrarre i dati di accesso ftp. </h3>";
            }
        #classe gestione ftp
         $userftp = array();
         $userftp = $cls_user_ftp->get_lista_accountftp();
         $cls_ftp = new class_ftp();
         $cls_ftp->set_server($userftp['ftp-server']); #server default 
         $cls_ftp->set_user($userftp['ftp-accountname']);
         $cls_ftp->set_pass($userftp['ftp-accountpass']);
         if (isset($_REQUEST['path_ftp'])){
             $cls_ftp->set_path_ftp($_REQUEST['path_ftp']); #se cambio cartella
         }
         $cls_ftp->accedi_ftp();   
        }

        ?>
        <div class="testata_centro">
            <h1>FTP-web</h1>
            <h5>Home page</h5>
            <hr></hr>
             <br></br>
        </div>
        <div class="box_centrale">
            
            <div class="selziona_ftp">
               
                <h4>user:<?php print $_SESSION['nome_utente']; ?></h4>
                <form method="post">
                    <label>Seleziona accesso</label>
                    <select name="select_ftp">
                        <!-- loop per gestire piu server -->
                        <?php
                            print "<option selected>";
                            print "" . $cls_user_ftp->get_serverdefault(); 
                            print "</option>";
                            $server = $cls_user_ftp->get_lista_serverftp();
                            foreach ( $server as $server_ftp) {
                                print "<option>";
                                print $server_ftp;
                                print "</option>";
                            }
                        ?>
                    </select>
                        <!-- griglia file del server -->
                        <!-- <div> -->
                            <br>
                            
                            <br>
                            <table border="1">
                                <?php
                                    foreach ($cls_ftp->get_lista_cretella() as $key => $value) {
                                        print "<form action='' method='post'>"; #inizio del form
                                        print "<tr>";
                                        //
                                        #prima colonna nome della cartelle o del file
                                        //
                                        print "<td>";
                                            #estrazione delle informazioni e gestione della crtella e del file
                                            #la cartella è inserita in un link, il file alla destra ha un tasto download

                                            $riga_lista = $cls_ftp->estrai_da_lista($value);
                                            #se è una cartella la iserisco in href
                                            if(estrai_cartella($value)){
                                                #Visualizza il nome della cartella
                                                echo estrai_nomef($value);                                               
                                                
                                            }else{
                                                //altrimenti visualizzo il file
                                                echo '<a href="download.php?name=' . estrai_nomef($value) . 
                                                    '?byte=' . estrai_byte($value) . '>' . estrai_nomef($value)
                                                        . '</a>';
                                            }
                                            #print str_replace('/','', $value);
                                        print "</td>";
                                        //
                                        #seconda colonna visualizza i byte
                                        //
                                        print "<td>";
                                        if (estrai_cartella($value)){
                                            print estrai_byte($value);
                                        }
                                        print "</td>";

                                        #terza colonna visualizza il tasto scelta
                                        print "<td>";
                                            #se è una cartella visualizzo il tasto accedi
                                            if(estrai_cartella($value)){
                                                #Visualizza il nome della cartella
                                                $percorso_ftp = $cls_ftp->get_path_ftp() . estrai_nomef($value); 
                                                print "<input type='hidden' name='path_ftp' value='" . $percorso_ftp . "'></input>";                                           
                                                print "<input type='submit' value='Accedi'></input>";
                                                
                                            }                                            
                                        print "</td>";

                                        print "</tr>";
                                        print "</form>";  #fine del form
                                    } #fine ciclo foreach - lista file/cartelle
                                ?>
                            </table>
                        <!-- </div> -->    
                       
                    </select>
                </form>
            </div>
        </div>
    </body>
</html>
