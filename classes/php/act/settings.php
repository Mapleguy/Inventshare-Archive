<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/PHPMailer.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/Exception.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/SMTP.php'); 
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    if(isset($_POST['setting']))
    {
        if($_POST['setting'] == 'password')
        {
            $oldpass = DB::Query('SELECT password FROM passwords WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']))['0']['password'];
            if(password_verify($_POST['curpass'], $oldpass))
            {
                $newpass = $_POST['newpass'];
                $newpass_e = password_hash($newpass, PASSWORD_BCRYPT);
                $doc = date('y/m/d');
                DB::Query('UPDATE passwords SET password = :password WHERE user_id = :user_id', array(':password' => $newpass_e, ':user_id' => $_SESSION['user_id']));
                DB::Query('UPDATE passwords SET doc = :doc WHERE user_id = :user_id', array(':doc' => $doc, ':user_id' => $_SESSION['user_id']));
                $user = DB::Query('SELECT username FROM users WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']));
                $email = DB::Query('SELECT uemail FROM email WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']))['0']['uemail'];
                $mail = new PHPMailer();
                $mail->SMTPDebug = false;
                $mail->isSMTP();
                $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'AKIAJY3KNXCLESBR34PQ';
                $mail->Password = 'Atq1Lp0Q+9qJPA3E9xJO36c272e9jCBrdDDEEQyYA2Q8';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                //Mail data
                $mail->setFrom('noreply@mail.inventshare.co', 'InventShare');
                $mail->addAddress($email, $user);
                $mail->isHTML(true);
                $mail->Body = "You have changed your password on InventShare! If you did not authorize this, change your password immediately!";
                $mail->Subject = 'InventShare - Confirm Your E-Mail Address';
                $mail->send();
                echo 'success';
            }
            else
            {
                echo 'WrongPass';
            }
        }
        else if($_POST['setting'] == 'email')
        {
            if(DB::Query('SELECT uemail FROM email WHERE uemail = :uemail', array(':uemail' => $_POST['newemail']))['0']['uemail'] == null)
            {
                $password = DB::Query('SELECT password FROM passwords WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']))['0']['password'];
                if(password_verify($_POST['password'], $password))
                {
                    $cn = rand(100000, 999999);
                    DB::Query('UPDATE email SET uemail = :email WHERE user_id = :user_id', array(':email' => $_POST['newemail'], ':user_id' => $_SESSION['user_id']));
                    DB::Query('UPDATE email SET confirmed = :cn WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id'], ':cn' => $cn));
                    $user = DB::Query('SELECT username FROM users WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']));
                    //Send confirmation email
                    try
                    {
                        $link = 'https://www.inventshare.co/verify?user='.$_SESSION['user_id'].'&cn='.$cn;
                        $mail = new PHPMailer();
                        $mail->SMTPDebug = false;
                        $mail->isSMTP();
                        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'AKIAJY3KNXCLESBR34PQ';
                        $mail->Password = 'Atq1Lp0Q+9qJPA3E9xJO36c272e9jCBrdDDEEQyYA2Q8';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        //Mail data
                        $mail->setFrom('noreply@mail.inventshare.co', 'InventShare');
                        $mail->addAddress($_POST['newemail'], $user);
                        $mail->isHTML(true);
                        $mail->Body = "You have changed your password on InventShare! Here is the link to verify your new E-Mail: ".$link;
                        $mail->Subject = 'InventShare - Confirm Your E-Mail Address';
                        $mail->send();
                    } 
                    catch (Exception $ex) 
                    {

                    }
                    echo 'success';
                }
                else
                {
                    echo 'WrongPass';
                }
            }
            else
            {
                echo 'TakenEmail';
            }
        }
        else
        {
            echo 'notavail';
        }
    }
    else
    {
        echo 'broken';
    }
?>