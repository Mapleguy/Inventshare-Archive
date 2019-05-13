<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/PHPMailer.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/Exception.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/SMTP.php');  
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    if(isset($_POST['chkuname']))
    {
        if(DB::Query('SELECT username FROM users WHERE username = :username', array(':username' => $_POST['chkuname'])))
        {
            echo 'taken';
        }
        else
        {
            echo 'open';
        }
    }
    if(isset($_POST['chkemail']))
    {
        if(DB::Query('SELECT uemail FROM email WHERE uemail = :email', array(':email' => $_POST['chkemail'])))
        {
            echo 'taken';
        }
        else
        {
            echo 'open';
        }
    }
    if(isset($_POST['actsubmit']))
    {
        date_default_timezone_set('America/New_York');
        $username = $_POST['uname'];
        $passtext = $_POST['pass'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $doc = date('y/m/d');
        $cn = random_int(100000, 999999);       
        $h1 = password_hash($passtext, PASSWORD_BCRYPT);
        DB::Query('INSERT INTO users VALUES(null, :uname, :fname, :lname, :doc, :dob)', array(':uname' => $username, ':fname' => $fname, ':lname' => $lname, ':doc' => $doc, ':dob' => $_POST['dob']));
        $id = DB::Query('SELECT user_id FROM users WHERE username = :username', array(':username' => $username))['0']['user_id'];
        DB::Query('INSERT INTO email VALUES(:id, :email, :confcode)', array(':id' => $id, ':email' => $email, ':confcode' => $cn));
        DB::Query('INSERT INTO profiles VALUES(:id, :sum, :loc)', array(':id' => $id, ':sum' => 'Hi! This is a fresh account!', ':loc' => 'The Internet'));
        DB::Query('INSERT INTO passwords VALUES(:id, :pass, :doc, :cn)', array(':id' => $id, ':pass' => $h1, ':doc' => $doc, ':cn' => $cn));
        $link = "https://inventshare.co/verify?user=".$id."&cn=".$cn;
        $mail = new PHPMailer(true);
        try 
        {
            //Server data
            $meail->SMTPDebug = 2;
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
            $mail->Body = "Welcome to InventShare, ".$username."! Confirm your E-Mail here: ".$link.".";
            $mail->Subject = 'InventShare - Confirm Your E-Mail Address';
            $mail->send();
            echo 'succ';
        } 
        catch(Exception $ex) 
        {
            
        }
    }
?>