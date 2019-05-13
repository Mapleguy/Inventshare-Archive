<script>   
    function AttemptLog()
    {
        $.ajax
        ({
            url: 'https://inventshare.co/classes/php/act/actlog.php',
            type: 'post',
            data: 
            {
                log: 'in',
                uname: document.getElementById('navun').value,
                pword: document.getElementById('navpass').value
            },
            success: function(output)
            {
                var newout = output.replace(/\s/g, '');
                switch(newout)
                {
                    case 'success':
                        location.reload(true);
                        break;
                        
                    case 'invalidun':
                        document.getElementById('navun').value = "Wrong Username";
                        document.getElementById('navpass').value = "";
                        break;
                        
                    case 'invalidpass':
                        document.getElementById('navun').value = "Wrong Password";
                        document.getElementById('navpass').value = "";
                        break;
                        
                    default:
                        document.getElementById('navun').value = "Other Error";
                        document.getElementById('navpass').value = "";
                        break;
                }
            }
        });
    }
    
</script>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="https://inventshare.co/css/nav/navlistguest.css">
    </head>  
    <body>
        <div class="navoptions" id="navoptions">
            <div id="navinput" name="navusername">
                <input type="text" placeholder="Username" value="" id="navun" name="navinput">
            </div>
            <div id="navinput" name="navpassword">
                <input type="password" placeholder="Password" value="" id="navpass"  name="navinput">
            </div>
            <div id="navlogin" name="navlogin" onclick="AttemptLog()" name="navinput">
                <text id="loginlabel" name="navinput">Login</text>
            </div>
            <div id="navbutton" name="navsignup" onclick="Redirect('https://inventshare.co/signup')" name="navinput">
                <text id="navlabel" name="navinput">Sign Up</text>
            </div>
            <div id="navbutton" name="navsignup" onclick="Redirect('https://inventshare.co/recover')" name="navinput">
                <text id="navlabel" name="navinput">Can't Sign In?</text>
            </div>
        </div>
    </body>
</html>