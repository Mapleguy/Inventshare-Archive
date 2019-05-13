<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
?>
<script>
    $('document').ready(function()
    {
        document.getElementById('uname').value = '';
        document.getElementById('uname1').value = '';
        document.getElementById('uname2').value = '';
        document.getElementById('fname').value = '';
        document.getElementById('email').value = '';
        document.getElementById('message').value = '';
    });
    function ShowTab(tab)
    {
        if(tab === 'username')
        {
            document.getElementsByClassName('tab')['0'].setAttribute('style', 'visibility: visible;');
            document.getElementsByClassName('tab')['1'].setAttribute('style', 'visibility: hidden;');
            document.getElementsByClassName('tab')['2'].setAttribute('style', 'visibility: hidden;');
        }
        else if(tab === 'password')
        {
            document.getElementsByClassName('tab')['0'].setAttribute('style', 'visibility: hidden;');
            document.getElementsByClassName('tab')['1'].setAttribute('style', 'visibility: visible;');
            document.getElementsByClassName('tab')['2'].setAttribute('style', 'visibility: hidden;');
        }
        else
        {
            document.getElementsByClassName('tab')['0'].setAttribute('style', 'visibility: hidden;');
            document.getElementsByClassName('tab')['1'].setAttribute('style', 'visibility: hidden;');
            document.getElementsByClassName('tab')['2'].setAttribute('style', 'visibility: visible;');
        }
        document.getElementById('uname').value = '';
        document.getElementById('uname1').value = '';
        document.getElementById('uname2').value = '';
        document.getElementById('fname').value = '';
        document.getElementById('email').value = '';
        document.getElementById('message').value = '';
    }
    function RecoverUsername()
    {
        if(document.getElementById('uname').value !== '')
        {
            $.ajax
            ({
                url: 'https://inventshare.co/classes/php/act/recover.php',
                type: 'post',
                data:
                {
                    recover: 'username',
                    email: document.getElementById('uname').value
                },
                success: function(output)
                {
                    if(output === 'noemail')
                    {
                        alert('No Email');
                    }
                    else if(output === 'succ')
                    {
                        document.getElementById('uname').value = '';
                    }
                    else
                    {
                        alert(output);
                    }
                }
            });
        }
    }
    function RecoverPassword()
    {
        if(document.getElementById('uname1').value !== '')
        {
            $.ajax
            ({
                url: 'https://inventshare.co/classes/php/act/recover.php',
                type: 'post',
                data:
                {
                    recover: 'password',
                    user: document.getElementById('uname1').value
                },
                success: function(output)
                {
                    alert(output);
                }
            });
        }
    }
    function RecoverElse()
    {
        $.ajax
        ({
            url: 'https://inventshare.co/classes/php/act/recover.php',
            type: 'post',
            data:
            {
                recover: 'else'
            },
            success: function(output)
            {
                
            }
        });
    }
</script>
<!DOCTYPE html>
<html>
    <head>
        <title>Recover Your Account on InventShare</title>
        <link rel="stylesheet" href="https://inventshare.co/css/act/recover.css">
    </head>
    <body>
        <div class="tabs">
            <div id="tab_button" onclick="ShowTab('username')">
                <text>Forgot My Username</text>
            </div>
            <div id="tab_button" onclick="ShowTab('password')">
                <text>Forgot My Password</text>
            </div>
            <div id="tab_button" onclick="ShowTab('else')">
                <text>Something Else</text>
            </div>
        </div>
        <div style="position: absolute; width: 65vw; height: 250px; left: 17.5vw; top: calc(42px + 1vw);">
            <div class="tab" style="visibility: visible;">
                <text id="title">Username</text></br>
                <text id="desc">Fill out your account E-Mail below to be sent your username.</text></br>
                <text id="desc">Hint: You can also log in with your E-Mail, not just your username.</text></br>
                <input id="uname" type="text" placeholder="E-Mail..." value=""></br>
                <input id="submit" type="button" value="Submit" onclick="RecoverUsername()">
            </div>
            <div class="tab" style="visibility: hidden;">
                <text id="title">Password</text></br>
                <text id="desc">Fill out your username or E-Mail below and we will send you a reset link.</text></br>
                <input id="uname1" type="text" placeholder="Username or E-Mail..." value=""></br>
                <input id="submit" type="button" value="Submit" onclick="RecoverPassword()">
            </div>
            <div class="tab" style="visibility: hidden;">
                <text id="title">Something Else</text></br>
                <text id="desc">You seem to have a bigger problem than a simple web page can fix.</text></br>
                <text id="desc">Fill the form below and our team of intelligent watermelons will help you.</text></br>
                <input id="fname" type="text" placeholder="Full Name" value=""></br>
                <input id="uname2" type="text" placeholder="Username (If Known)" value=""></br>
                <input id="email" type="text" placeholder="Contact E-Mail" value=""></br>
                <textarea id="message" placeholder="Message" value=""></textarea></br>
                <input id="submit" type="button" value="Submit" onclick="RecoverElse()">
            </div>
        </div>
    </body>
</html>