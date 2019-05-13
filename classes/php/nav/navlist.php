<script>  
    function LogOut()
    {
        $.ajax
        ({
            url: 'https://inventshare.co/classes/php/act/actlog.php',
            type: 'post',
            data:
            {
                logout: 'set'
            },
            success: function()
            {
                Redirect('https://inventshare.co/');
            }
        });
    }
</script>

<?php     
    if(ActLog::IsLogged() != 'false')
    {
        $username = DB::Query('SELECT username FROM users WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']))['0']['username'];
        $profileurl = 'https://inventshare.co/profile?user='.$username;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://inventshare.co/css/nav/navlist.css">
    </head>  
    <body>
        <div class="navoptions" id="navoptions">
            <div id="navbutton" name="navprofile" onclick="Redirect(<?php echo "'".$profileurl."'" ?>)">
                <text id="navlabel">Profile</text>
            </div>
            <div id="navbutton" name="navpost" onclick="Redirect('https://inventshare.co/post')">
                <text id="navlabel" >New Invention</text>
            </div>
            <div id="navbutton" name="navsettings" onclick="Redirect('https://inventshare.co/settings')">
                <text id="navlabel">Settings</text>
            </div>
            <div id="navbutton" name="navlogout" onclick="LogOut()">
                <text id="navlabel">Log Out</text>
            </div>
        </div>
    </body>
</html>