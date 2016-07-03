<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>FTP-web</title>
        <link rel="stylesheet" type="text/css" href="css/struttura.css"></link>
    </head>
    <body>
        <?php
        include_once 'conf/config.inc';
        include_once 'inc/function.php';
        include_once 'class/class_user.php';

        session_start();

        if (isset($_REQUEST['controllo'])) {

            #crea la classe e legge l'autenticazione dell'utente
            $cls_user = new class_user();

            #DB
            $cls_user->set_mysql_server($mysql_server);
            $cls_user->set_mysql_user($mysql_user);
            $cls_user->set_mysql_password($mysql_password);

            $conn = $cls_user->apri_database();
            if ($conn == false) {
                print "<h3>Impossibile accedere al batabase. </h3>";
            } else {
                #autenticazione utente
                if (trim($_REQUEST['nome_utente']) == "") {
                    $msg_err = "Inserire il nome utente";
                } else {
                    $cls_user->set_UtenteNome($_REQUEST['nome_utente']);
                    #seil nome utene è Ok controlla la password
                    if (trim($_REQUEST['password_utente']) == "") {
                        $msg_err = "Inserire la password";
                    } else {
                        $cls_user->set_UtentePassword($_REQUEST['password_utente']);
                        #controllo che l'utente sia registrato
                        $cls_user->set_db($mysql_db);
                        $cls_user->set_tabella_utenti($mysql_tabella_utenti);
                        
                        $result = $cls_user->identifica_utente();
                        if ($result == TRUE) {
                            #lacio la pagina principale
                            $_SESSION['nome_utente']=$_REQUEST['nome_utente'];
                            $_SESSION['password_utente']=$_REQUEST['password_utente'];
                            $_SESSION['id_sessione'] = Generatore();
                            #echo $percorso;
                            #header('Location: http://192.168.10.165:/FTP-web/home.php');
                            echo '<script>location.href = "home.php"; </script>';
                            #echo var_dump(headers_sent());
                            #echo $_SERVER['DOCUMENT_ROOT'];
                            #exit ();
                        }else{
                            #scrivo il messaggio di errore
                            $msg_err = "Impossibile accedere controlla utente e password";
                        }
                    }
                }
            }
        }
        ?>

        <div class="centra_form">
            <br></br>
            <h1>FTP-web</h1>
            <h5>Accesso FTP G.M.F. tramite sito WEB</h5>
            <hr></hr>
            <br></br>
            <!-- immissione dati per autenticazione -->
            <form  action="" method="post">
                <table>
                    <tr>
                        <td>
                            <label> Nome utente </label>
                        </td>
                        <td>
                            <input type="text" name="nome_utente" size="20" 
                                <?php 
                                    if(isset($_REQUEST['nome_utente'])){
                                        echo 'value='. $_REQUEST['nome_utente'] . ">";                                          
                                        } 
                                ?>
                            </input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password</label>
                        </td>
                        <td>
                            <input type="password" name="password_utente" size="20"></input>
                            <input type="hidden" name="controllo" value="0"></input>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br></br>
                            <input type="submit" value="  Entra  "></input> 
                        </td>
                    </tr>
                </table>
                <br></br>
                <br></br>
<?php
if (isset($msg_err)) {
    print "<div class='errore_autentica'> </h2 >" . $msg_err . "</h2></div>";
}
?>
            </form>
        </div>
    </body>
</html>