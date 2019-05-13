<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/PHPMailer.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/Exception.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/SMTP.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    if(isset($_POST['sendemail']))
    {
        $mail = new PHPMailer(true);
        try 
        {
            $link = "https://inventshare.co/verify?user=".$_POST['userid']."&cn=".$_POST['cn'];
            //Server data
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'AKIAJY3KNXCLESBR34PQ';
            $mail->Password = 'Atq1Lp0Q+9qJPA3E9xJO36c272e9jCBrdDDEEQyYA2Q8';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            //Mail data
            $mail->setFrom('noreply@mail.inventshare.co', 'InventShare');
            $mail->addAddress('admin@mail.inventshare.co ', 'Griffin Brown');
            $mail->isHTML(true);
            $mail->Body = "Welcome to InventShare, ".filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)."!"." Confirm your E-mail here: ".$link." If you do not know why you are receiving this E-mail, simply ignore it and delete it. You won't hurt our feelings.";
            $mail->Subject = 'InventShare - Confirm Your E-Mail Address';
            $mail->send();
        } 
        catch(Exception $ex) 
        {
            
        }
    }
?>