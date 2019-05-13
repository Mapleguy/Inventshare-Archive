<?php 
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
    if(!ActLog::IsLogged())
    {
        header('Location: https://inventshare.co/');
    }
    $email = json_encode(DB::Query('SELECT uemail, confirmed FROM email WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']))['0']);
    $doc_pass = DB::Query('SELECT doc FROM passwords WHERE user_id = :user_id', array(':user_id' => $_SESSION['user_id']))['0']['doc'];
?>
<script>
    $('document').ready(function()
    {
        var email = JSON.parse(<?php echo "'".$email."'" ?>);
        var doc = <?php echo "'".$doc_pass."'"; ?>;
        var tempDoc = new Date(doc);
        var rDoc = tempDoc.getFullYear()+'-'+(tempDoc.getMonth()+4)+'-'+(tempDoc.getDate()+1);
        InitSettings(doc, rDoc, email['uemail'], email['confirmed']);
        ShowGeneral();
    });
    function ShowGeneral()
    {
        document.getElementById('set_general').setAttribute('style', 'visibility: visible;');
        document.getElementById('set_privacy').setAttribute('style', 'visibility: hidden;');
        document.getElementById('set_password').setAttribute('style', 'visibility: hidden;');
        ClearValues();
    }
    function ShowPrivacy()
    {
        document.getElementById('set_general').setAttribute('style', 'visibility: hidden;');
        document.getElementById('set_privacy').setAttribute('style', 'visibility: visible;');
        document.getElementById('set_password').setAttribute('style', 'visibility: hidden;');
        ClearValues();
    }

    function ShowPassword()
    {
        document.getElementById('set_general').setAttribute('style', 'visibility: hidden;');
        document.getElementById('set_privacy').setAttribute('style', 'visibility: hidden;');
        document.getElementById('set_password').setAttribute('style', 'visibility: visible;');
        ClearValues();
    }
    //Clear input values
    function ClearValues()
    {
        //Clear Pass Fields
        document.getElementsByName('newpass')['0'].value = '';
        document.getElementsByName('newpass')['1'].value = '';
        document.getElementsByName('newpass')['2'].value = '';
        //Clear General Fields
        document.getElementsByName('newemail')['0'].value = '';
        document.getElementsByName('newemail')['1'].value = '';
        document.getElementsByName('newemail')['2'].value = '';
    }
    function InitSettings(doc, rDoc, email, conf)
    {
        document.getElementsByName('emaillabel')[0].innerHTML = email;
        if(conf === '1')
        {
            document.getElementsByName('conflabel')[0].innerHTML = 'Confirmed';
        }
        else
        {
            document.getElementsByName('conflabel')[0].innerHTML = 'Not Confirmed';
        }
        document.getElementsByName('doc_pass')['0'].innerHTML = doc;
        document.getElementsByName('doc_pass')['1'].innerHTML = rDoc;
        document.getElementById('errormessage_p').setAttribute('style', 'height: 0vw;');
        document.getElementById('errormessage_p').children[0].innerHTML = '';
        document.getElementById('errormessage_e').setAttribute('style', 'height: 0vw;');
        document.getElementById('errormessage_e').children[0].innerHTML = '';
    }
    function ChangeEmail()
    {
        var newemail = document.getElementsByName('newemail')[0].value;
        var confemail = document.getElementsByName('newemail')[1].value;
        var password = document.getElementsByName('newemail')[2].value;
        if(newemail !== '')
        {
            if(confemail !== '')
            {
                if(newemail === confemail)
                {
                    $.ajax
                    ({
                        url: 'https://inventshare.co/classes/php/act/settings.php',
                        type: 'post',
                        data:
                        {
                            setting: 'email',
                            newemail: confemail,
                            password: password
                        },
                        success: function(output)
                        {
                            if(output !== 'success')
                            {
                                EmailError(output);
                            }
                            else
                            {
                                document.getElementsByName('newemail')['0'].value = '';
                                document.getElementsByName('newemail')['1'].value = '';
                                document.getElementsByName('newemail')['2'].value = '';
                                document.getElementById('errormessage_e').setAttribute('style', 'height: 0vw;');
                                document.getElementById('errormessage_e').children[0].innerHTML = '';
                            }
                        }
                    });
                }
                else
                {
                    EmailError('Mismatch');
                }
            }
            else
            {
                EmailError('ConfEmail');
            }
        }
        else
        {
            EmailError('NewEmail');
        }
    }

    function ChangePass()
    {
        var newpass = document.getElementsByName('newpass')[0].value;
        var confpass = document.getElementsByName('newpass')[1].value;
        var curpass = document.getElementsByName('newpass')[2].value;
        if(newpass !== '')
        {
            if(confpass !== '')
            {
                if(newpass === confpass)
                {
                    if(curpass !== '')
                    {
                        $.ajax
                        ({
                            url: 'https://inventshare.co/classes/php/act/settings.php',
                            type: 'post',
                            data:
                            {
                                setting: 'password',
                                curpass: curpass,
                                newpass: confpass
                            },
                            success: function(output)
                            {
                                if(output !== 'success')
                                {
                                    PassError(output);
                                }
                                else
                                {
                                    document.getElementsByName('newpass')['0'].value = '';
                                    document.getElementsByName('newpass')['1'].value = '';
                                    document.getElementsByName('newpass')['2'].value = '';
                                    document.getElementById('errormessage_p').setAttribute('style', 'height: 0vw;');
                                    document.getElementById('errormessage_p').children[0].innerHTML = '';
                                }
                            }
                        });
                    }
                    else
                    {
                        PassError('CurPass');
                    }
                }
                else
                {
                    PassError('Mismatch');
                }
            }
            else
            {
                PassError('ConfPass');
            }
        }
        else
        {
            PassError('NewPass');
        }
    }
    function EmailError(error)
    {
        switch(error)
        {
            case 'NewEmail':
                document.getElementById('errormessage_e').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_e').children[0].innerHTML = 'Please Enter a New Email!';
                break;
            case 'ConfEmail':
                document.getElementById('errormessage_e').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_e').children[0].innerHTML = 'Please Enter a Confirmation Email!';
                break;
            case 'Mismatch':
                document.getElementById('errormessage_e').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_e').children[0].innerHTML = 'New Email and Confirmation Do Not Match!';
                break;
            case 'TakenEmail':
                document.getElementById('errormessage_e').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_e').children[0].innerHTML = 'That Email Is Taken!';
                break;
            case 'WrongPass':
                document.getElementById('errormessage_e').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_e').children[0].innerHTML = 'Your Password Is Incorrect!';
                break;
            default:
                document.getElementById('errormessage_e').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_e').children[0].innerHTML = 'An Unknown Error has Occured!';
                break;
        }
    }
    function PassError(error)
    {
        switch(error)
        {
            case 'NewPass':
                document.getElementById('errormessage_p').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_p').children[0].innerHTML = 'Please Enter A New Password!';
                break;
            case 'ConfPass':
                document.getElementById('errormessage_p').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_p').children[0].innerHTML = 'Please Confirm Your New Password!';
                break;
            case 'CurPass':
                document.getElementById('errormessage_p').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_p').children[0].innerHTML = 'Please Fill In Your Current Password!';
                break;
            case 'Mismatch':
                document.getElementById('errormessage_p').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_p').children[0].innerHTML = 'Password and Confirmation Do Not Match!';
                break;
            case 'WrongPass':
                document.getElementById('errormessage_p').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_p').children[0].innerHTML = 'Your Password Is Incorrect!';
                break;
            default:
                document.getElementById('errormessage_p').setAttribute('style', 'height: 1vw;');
                document.getElementById('errormessage_p').children[0].innerHTML = 'An Unkown Error Has Occured!';
                break;
        }
}
</script>
<!DOCTYPE html>
<html>
    <head>
        <title>Settings</title>
        <link rel="stylesheet" href="https://inventshare.co/css/act/settings.css">
    </head>
    <body>
        <div class="content">
            <div id="leftline"></div>
            <div id="rightline"></div>
            <div class="set_nav">
                <text id="set_op" onclick="ShowGeneral()">General</text></br>
                <text id="set_op" onclick="ShowPrivacy()">Privacy</text></br>
                <text id="set_op" onclick="ShowPassword()">Password</text></br>
            </div>
            <div class="set_general" id="set_general">
                <text id="title">General Settings</text></br>
                <text id="sec_label">Email</text></br>
                <div id="sec_info">
                    <text id="set_label">Current Email Address:</text><text id="set_label_right" name="emaillabel">TheEmail@website.com</text></br>
                    <text id="set_label">Email Address Confirmed?:</text><text id="set_label_right" name="conflabel">Confirmed</text>
                </div>
                <text id="sec_label">Change Email</text>
                <div id="sec_info">
                    <text id="set_label">New Email</text></br>
                    <input id="set_input_text" type="text" value="" placeholder="New Email..." name="newemail"></br>
                    <text id="set_label">Confirm New Email</text></br>
                    <input id="set_input_text" type="text" value="" placeholder="Confirm New Email..." name="newemail"></br>
                    <text id="set_label">Type Your Password</text></br>
                    <input id="set_input_text" type="password" value="" placeholder="Your Password..." name="newemail"></br>
                    <div id="errormessage_e"><text>This Is An Error</text></div>
                    <input id="set_button_cemail" type="button" value="Change Email" onclick="ChangeEmail()">
                </div>
            </div>
            <div class="set_privacy" id="set_privacy">
                <text id="title">Privacy Settings</text></br>
            </div>
            <div class="set_password" id="set_password">
                <text id="title">Password Settings</text></br>
                <text id="sec_label">Date of Change</text></br>
                <div id="sec_info">
                    <text id="set_label">Last Change Date:</text><text id="set_label_right" name="doc_pass">1 January 2018</text></br>
                    <text id="set_label">Suggested Change Date:</text><text id="set_label_right" name="doc_pass">1 April 2018</text>
                </div>
                <text id="sec_label">Change Password</text></br>
                <div id="sec_info">
                    <text id="set_label">Type Your New Password</text></br>
                    <input id="set_input_text" type="password" value="" placeholder="New Password" name="newpass"></br>
                    <text id="set_label">Confirm Your New Password</text></br>
                    <input id="set_input_text" type="password" value="" placeholder="Confirm New Password" name="newpass"></br>
                    <text id="set_label">Type Your Current Password</text></br>
                    <input id="set_input_text" type="password" value="" placeholder="Current Password" name="newpass"></br>
                    <div id="errormessage_p"><text>This Is An Error</text></div>
                    <input id="set_button_cpass" type="button" value="Change Password" onclick="ChangePass()">
                </div>
            </div>
        </div>
    </body>
</html>