<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/PHPMailer.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/Exception.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/SMTP.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    if(isset($_POST['recover']))
    {
        if($_POST['recover'] === 'username')
        {
            if(DB::Query('SELECT uemail FROM email WHERE uemail = :uemail', array(':uemail' => $_POST['email']))['0']['uemail'])
            {
                $user_id = DB::Query('SELECT user_id FROM email WHERE uemail = :uemail', array(':uemail' => $_POST['email']))['0']['user_id'];
                $username = DB::Query('SELECT username FROM users WHERE user_id = :user_id', array(':user_id' => $user_id))['0']['username'];
                $mail = new PHPMailer();
                try 
                {
                    $mail->isSMTP();
                    $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'AKIAJY3KNXCLESBR34PQ';
                    $mail->Password = 'Atq1Lp0Q+9qJPA3E9xJO36c272e9jCBrdDDEEQyYA2Q8';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    //Mail data
                    $mail->setFrom('noreply@mail.inventshare.co', 'InventShare');
                    $mail->addAddress($_POST['email'], $username);
                    $mail->isHTML(true);
                    $mail->Body = "As requested, your InventShare username is: ".$username.". Thank you for using InventShare!";
                    $mail->Subject = 'InventShare - Your InventShare Username';
                    $mail->send();
                    echo 'succ';
                } 
                catch(Exception $ex) 
                {
                    
                }
            }
            else
            {
                echo 'noemail';
            }
        }
        else if($_POST['recover'] === 'password')
        {
            if(DB::Query('SELECT user_id FROM email WHERE uemail = :uemail', array(':uemail' => $_POST['user']))['0']['user_id'])
            {
                $user_id = DB::Query('SELECT user_id FROM email WHERE uemail = :uemail', array(':uemail' => $_POST['user']))['0']['user_id'];
                $username = DB::Query('SELECT username FROM users WHERE user_id = :user_id', array(':user_id' => $user_id))['0']['username'];
                $email = DB::Query('SELECT uemail FROM email WHERE user_id = :user_id', array(':user_id' => $user_id))['0']['uemail'];
                $tmp = random_int(100000, 999999);
                DB::Query('UPDATE passwords SET temp = :tmp WHERE user_id = :user_id', array(':tmp' => $tmp, ':user_id' => $user_id));
                $mail = new PHPMailer();
                try 
                {
                    $mail->isSMTP();
                    $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'AKIAJY3KNXCLESBR34PQ';
                    $mail->Password = 'Atq1Lp0Q+9qJPA3E9xJO36c272e9jCBrdDDEEQyYA2Q8';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    //Mail data
                    $mail->setFrom('noreply@mail.inventshare.co', 'InventShare');
                    $mail->addAddress($email, $username);
                    $mail->isHTML(true);
                    $mail->Body = "Here is the link to reset your password: https://inventshare.co/recover/password?user=".$user_id."&tmp=".$tmp;
                    $mail->Subject = 'InventShare - Password Reset Request';
                    $mail->send();
                    echo 'succ';
                }
                catch(Exception $ex) 
                {

                }
                echo $tmp;
            }
            else
            {
                if(DB::Query('SELECT user_id FROM users WHERE username = :username', array(':username' => $_POST['user']))['0']['user_id'])
                {
                    $user_id = DB::Query('SELECT user_id FROM users WHERE username = :username', array(':username' => $_POST['user']))['0']['user_id'];
                    $username = DB::Query('SELECT username FROM users WHERE user_id = :user_id', array(':user_id' => $user_id))['0']['username'];
                    $email = DB::Query('SELECT uemail FROM email WHERE user_id = :user_id', array(':user_id' => $user_id))['0']['uemail'];
                    $tmp = random_int(100000, 999999);
                    DB::Query('UPDATE passwords SET temp = :tmp WHERE user_id = :user_id', array(':tmp' => $tmp, ':user_id' => $user_id));
                    $mail = new PHPMailer();
                    try 
                    {
                        $mail->isSMTP();
                        $mail->Host = 'email-smtp.us-east-1.amazonaws.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'AKIAJY3KNXCLESBR34PQ';
                        $mail->Password = 'Atq1Lp0Q+9qJPA3E9xJO36c272e9jCBrdDDEEQyYA2Q8';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;
                        //Mail data
                        $mail->setFrom('noreply@mail.inventshare.co', 'InventShare');
                        $mail->addAddress($email, $username);
                        $mail->isHTML(true);
                        $mail->Body = "Here is the link to reset your password: https://inventshare.co/recover/password?user=".$user_id."&tmp=".$tmp;
                        $mail->Subject = 'InventShare - Password Reset Request';
                        $mail->send();
                        echo 'succ';
                    } 
                    catch(Exception $ex) 
                    {

                    }
                    echo $tmp;
                }
                else
                {
                    echo 'nouser';
                }
            }
        }
        else if($_POST['recover'] === 'else')
        {
            echo 'Else';
        }
        else
        {
            header('Location: https://inventshare.co/');
        }
    }
    else
    {
        header('Location: https://inventshare.co/');
    }
?>