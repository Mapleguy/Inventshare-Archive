<script>
    function SubmitPassword()
    {
        var pass = document.getElementById('resetfield').value;
        var pass2 = document.getElementById('resetfield1').value;
        if(pass.length > 12)
        {
            if(pass.length < 64)
            {
                if(pass.indexOf('#') <= 0 || pass.indexOf('$') <= 0 || pass.indexOf('%') <= 0 || pass.indexOf('@') <= 0 || pass.indexOf('&') <= 0 || pass.indexOf('(') <= 0 || pass.indexOf(')') <= 0)
                {
                    if(pass2 !== '')
                    {
                        if(pass === pass2)
                        {
                            $.ajax
                            ({
                                url: 'https://inventshare.co/classes/php/act/resetpass.php',
                                type: 'post',
                                data:
                                {
                                    resetpass: pass2,
                                    user_id: <?php echo "'".$user_id."'" ?>
                                },
                                success: function(output)
                                {
                                    if(output === 'succ')
                                    {
                                        Redirect('https://inventshare.co/');
                                    }
                                    else
                                    {
                                        document.getElementById('error').setAttribute('style', 'line-height: 1vw; visibility: visible;');
                                        document.getElementById('error').innerHTML = 'Unknown Error!';
                                    }
                                }
                            });
                        }
                        else
                        {
                            document.getElementById('error').setAttribute('style', 'line-height: 1vw; visibility: visible;');
                            document.getElementById('error').innerHTML = 'New Password and Confirmation Do Not Match!';
                        }
                    }
                    else
                    {
                        document.getElementById('error').setAttribute('style', 'line-height: 1vw; visibility: visible;');
                        document.getElementById('error').innerHTML = 'Please Confirm Your Password!';
                    }
                }
                else
                {
                    document.getElementById('error').setAttribute('style', 'line-height: 1vw; visibility: visible;');
                    document.getElementById('error').innerHTML = 'Password Contains an Invalid Character!';
                }
            }
            else
            {
                document.getElementById('error').setAttribute('style', 'line-height: 1vw; visibility: visible;');
                document.getElementById('error').innerHTML = 'Password Too Long! 12 - 64 Characters!';
            }
        }
        else
        {
            document.getElementById('error').setAttribute('style', 'line-height: 1vw; visibility: visible;');
            document.getElementById('error').innerHTML = 'Password Too Short! 12 - 64 Characters!';
        }
    }
</script>
<!DOCTYPE html>
<html>
    <body>
        <div class="resetfield">
            <text style="font-family: 'Sansation'; font-size: 2vw;">Ready to reset your password?</text></br>
            <text style="font-family: 'Sansation'; font-size: 1vw;">Type your new password below then type it in the next field to confirm it.</text></br>
            <input id="resetfield" type="password" placeholder="New Password..." value=""></br>
            <input id="resetfield1" type="password" placeholder="Confirm New Password..." value=""></br>
            <text id="error">ERROR</text><br>
            <input id="resetfield2" type="submit" value="Change Password" onclick="SubmitPassword()">
        </div>
    </body>
</html>