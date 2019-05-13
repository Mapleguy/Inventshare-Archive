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
            $mail->Body = "You have changed your password on InventShare! If you did not authorize this, change your password immediately!";
            $mail->Subject = 'InventShare - Confirm Your E-Mail Address';
            
            $mail->send();
        } 
        catch(Exception $ex) 
        {
            
        }
    }
?>