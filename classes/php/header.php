<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    var menuvis = false;
    var navmenu = document.getElementById('navoptions');
    window.onclick = function(e){
    var elem = e.target.name;
    switch(elem)
    {
        case "pcutimg":
            Togglenav();
            if(document.getElementById('avatarbtn'))
            {
                Hideavedit();
            }
            break;
            
        case "editbtn":
        {
            Editprofile();
            Hideavedit();
            Hidebanedit();
            Hidenav();
            break;
        }
         
        case "avatarbtn":
            Avataredit();
            Hidenav();
            Hidebanedit();
            break;
                    
        case "bannerbtn":
            Banneredit();
            Hidenav();
            Hideavedit();
            break;
        
        case "navlogin":
            break;
        
        case "loginlabel":
            break;
        
        case "navun":
            break;
        
        case "navpass":
            break;
        
        case "navinput":
            break;
        
        default:
            Hidenav();
            if(document.getElementById('avatarbtn'))
            {
                Hideavedit();
                Hidebanedit();
            }
            break;
        }
    };
    function Togglenav()
    {
        var navmenu = document.getElementById('navoptions');
        if(menuvis === true)
        {
            navmenu.style.visibility = 'hidden';
            menuvis = false;
        }
        else if(menuvis === false)
        {
            navmenu.style.visibility = 'visible';
            menuvis = true;
        }
    }
    function Hidenav()
    {
        var navmenu = document.getElementById('navoptions');
        navmenu.style.visibility = 'hidden';
        menuvis = false;
    }
    function Redirect(loc)
    {
        window.location.href = loc;
    }
    function Search()
    {
        var query = document.getElementById('searchfield').value;
        //Redirect('https://inventshare.co/search?query='+query);
    }
    function DefaultAvatar(object)
    {
        object.src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/default/avatar.jpg';
    }   
    function DefaultBanner(object)
    {
        object.src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/default/banner.jpg';
    }
</script>
<?php
    class DB
    {
        private static function Connect()
        {
                $pdo = new pdo('mysql:host=localhost;dbname=inventshare;charset=utf8', 'root', 'password');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }

        public static function Query($query, $params)
        {
                $statement = self::Connect()->prepare($query);
                $statement->execute($params);
                if(explode(' ', $query)[0] == 'SELECT')
                {
                    $data = $statement->fetchAll();
                    return $data;
                }
        }

        private static function ConnectExternal($connection, $db)
        {
                $pdo = new pdo('mysql:host='.$connection.';dbname='.$db.';charset=utf8', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $pdo;
        }

        public static function QueryExternal($query, $params, $destination, $database)
        {
                $statement = self::ConnectExternal($destination, $database)->prepare($query);
                $statement->execute($params);
                if(explode(' ', $query)[0] == 'SELECT')
                {
                    $data = $statement->fetchAll();
                    return $data;   
                }
        }
    }
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
                
                    DB::Query('INSERT INTO logintokens VALUES(\'\', :token, :userid)', array(':token' => sha1($token), ':userid' => $userid));
                    setcookie('ISLT', $token, time() + 60 * 60 * 24 * 7, '/', null, true, true);
                    
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
    if(ActLog::IsLogged() != 'false')
    {
        session_start();
        $_SESSION['user_id'] = ActLog::IsLogged();
        $avatardir = 'https://d2rvrc9f32zpxz.cloudfront.net/users/'.$_SESSION['user_id'].'/avatar.jpg';
    }
    if(!isset($_COOKIE['cookies']))
    {
        require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/cookies/cookies.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" href="css/nav/header.css">
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112418071-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-112418071-2');
        </script>
    </head>
    <body>
        <div class="hcontent">
            <div class="mask">
                <div class="profilescut">
                    <img id="pcutimg" name="pcutimg" src="<?php echo $avatardir ?>" onerror="DefaultAvatar(this)" width="30" height="30">
                </div>
                <div class="homebutton" onclick="Redirect('https://localhost/')">
                    <img src="img/logo.png" alt="">
                </div>
                <div class="hsearch">
                    <input type="button" id="searchbutton" name="searchbutton" value="" onclick="">
                    <input type="text" id="searchfield" name="searchfield" value="" placeholder="Search...">
                </div>
                <?php
                if(ActLog::IsLogged() != 'false')
                {
                    include($_SERVER['DOCUMENT_ROOT'].'/classes/php/nav/navlist.php');
                }
                else
                {
                    include($_SERVER['DOCUMENT_ROOT'].'/classes/php/nav/navlistguest.php');
                }
                ?>
            </div>
        </div>
    </body>
</html>