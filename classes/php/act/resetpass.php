<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/PHPMailer.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/Exception.php');
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/phpmailer/SMTP.php');
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    if(isset($_POST['resetpass']))
    {
        $pass = $_POST['resetpass'];
        $h1 = $h1 = password_hash($pass, PASSWORD_BCRYPT);
        $tmp = random_int(100000, 999999);
        DB::Query('UPDATE passwords SET password = :h1 WHERE user_id = :user_id', array(':h1' => $h1, ':user_id' => $_POST['user_id']));
        DB::Query('UPDATE passwords SET temp = :tmp WHERE user_id = :user_id', array(':tmp' => $tmp, ':user_id' => $_POST['user_id']));
        echo 'succ';
    }
?>