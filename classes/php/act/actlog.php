<?php  
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    class ActLog
    {
        public function Login($userid, $passtext)
        {
            if(ActLog::IsLogged() === 'false')
            {
                if(password_verify($passtext, DB::Query('SELECT password FROM passwords WHERE user_id = :userid', array(':userid' => $userid))['0']['password']))
                {
                    $cstrong = true;
                    $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                
                    DB::Query('INSERT INTO logintokens VALUES(null, :token, :userid)', array(':token' => sha1($token), ':userid' => $userid));
                    setcookie('ISLT', $token, time() + 60 * 60 * 24 * 7, '/', null, null, true);
                    
                    echo 'success';
                }
                else
                {
                    echo 'invalidpass';
                }
            }
            else
            {
                echo 'loggedin';
            }
        }
        
        public function LogOut($userid)
        {
            if(ActLog::IsLogged() != 'false')
            {
                DB::Query('DELETE FROM logintokens WHERE token = :token', array(':token' => sha1($_COOKIE['ISLT'])));
                setcookie('ISLT', 1, time() - 3600, '/', null, null, true);
            }
            else
            {
                echo 'eh';
            }
        }
        
        public function IsLogged()
        {
            if(isset($_COOKIE['ISLT']))
            {
                if(DB::Query('SELECT user_id FROM logintokens WHERE token = :token', array(':token' => sha1($_COOKIE['ISLT']))))
                {
                    $userid = DB::Query('SELECT user_id FROM logintokens WHERE token = :token', array(':token' => sha1($_COOKIE['ISLT'])))['0']['user_id'];
                    return $userid;
                }
                return 'false';
            }
            else
            {
                return 'false';
            }
        }
        
        public function IsConfirmed($userid)
        {
            if(DB::Query('SELECT confirmed FROM email WHERE user_id = :userid', array(':user_id' => $userid)) == '1')
            {
                return 'true';
            }
            else
            {
                return 'false';
            }
        }

    }
    
    if(isset($_POST['log']) && filter_input(INPUT_POST, 'log', FILTER_SANITIZE_STRING) === 'in')
    {
        $username = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
        $passtext = filter_input(INPUT_POST, 'pword', FILTER_SANITIZE_STRING);
        
        if(DB::Query('SELECT username FROM users WHERE username = :username', array(':username' => $username)))
        {
            if($userid = DB::Query('SELECT user_id FROM users WHERE username = :username', array(':username' => $username))['0']['user_id'])
            {
                ActLog::Login($userid, $passtext);
            }
        }
        else
        {
            echo 'invalidun';
        }
    }
    
    if(isset($_POST['logout']) && $_POST['logout'] != null)
    {
        $logout = ActLog::IsLogged();
        ActLog::LogOut($logout);
    }
?>