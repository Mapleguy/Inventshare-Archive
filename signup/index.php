<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
?>
<script>
    var unamegood, dobgood, emailgood, emailmatch, passgood, passmatch, agreeterms, agreeprivacy;
    function createstart()
    {
        document.getElementById('submitbtn').disabled = false;
    }
    function actsubmit()
    {
        $month = parseInt(document.getElementById('dobmonth').value) + 1;
        $.ajax
        ({
            url: 'https://inventshare.co/classes/php/act/actsubmit.php',
            type: 'post',
            data:
            {
                actsubmit: 'true',
                fname: document.getElementsByName('fname')['0'].value,
                lname: document.getElementsByName('lname')['0'].value,
                uname: document.getElementsByName('uname')['0'].value,
                email: document.getElementsByName('email')['0'].value,
                pass: document.getElementsByName('confpass')['0'].value,
                dob: document.getElementById('dobyear').value+"-"+$month+"-"+document.getElementById('dobday').value
            },
            success: function(output)
            {
                if(output === 'succ')
                {
                    Redirect('https://inventshare.co');
                }
            }
        });
    }
    function checkuname()
    {
        if(document.getElementsByName('uname')['0'].value === '')
        {
            document.getElementsByName('uname')['0'].setAttribute("style", "border: 1px solid black;");
            unamegood = false;
            checksubmit();
            ClearError();
        }
        else
        {
            $.ajax
            ({
                url: 'https://inventshare.co/classes/php/act/actsubmit.php',
                type: 'post',
                data:
                {
                    chkuname: document.getElementsByName('uname')['0'].value
                },
                success: function(output)
                {
                    if(output === 'open')
                    {
                        document.getElementsByName('uname')['0'].setAttribute('style', 'border: 1px solid #2db950');
                        ClearError();
                        unamegood = true;
                    }
                    else if(output === 'taken')
                    {
                        document.getElementsByName('uname')['0'].setAttribute('style', 'border: 1px solid red');
                        UpdateError('Username Taken');
                        unamegood = false;
                    }
                    else
                    {
                        document.getElementsByName('uname')['0'].setAttribute('style', 'border: 1px solid red');
                        UpdateError('Unkown Username Error');
                        unamegood = false;
                    }
                    checksubmit();
                }
            });
        }
    }
    function checkemail()
    {
        if(document.getElementsByName('email')['0'].value === '')
        {
            document.getElementsByName('email')['0'].setAttribute('style', 'border: 1px solid black;');
            emailgood = false;
            checksubmit();
            ClearError();
        }
        else
        {
            $.ajax
            ({
                url: 'https://inventshare.co/classes/php/act/actsubmit.php',
                type: 'post',
                data:
                {
                    chkemail: document.getElementsByName('email')['0'].value
                },
                success: function(output)
                {
                    if(output === 'open')
                    {
                        document.getElementsByName('email')['0'].setAttribute('style', 'border: 1px solid #2db950');
                        ClearError();
                        emailgood = true;
                    }
                    else if(output === 'taken')
                    {
                        document.getElementsByName('email')['0'].setAttribute('style', 'border: 1px solid red');
                        UpdateError('That E-Mail is in Use');
                        emailgood = false;
                    }
                    else
                    {
                        document.getElementsByName('email')['0'].setAttribute('style', 'border: 1px solid red');
                        UpdateError('Unknown E-Mail Error');
                        emailgood = false;
                    }
                    checksubmit();
                }
            });
        }
    }
    function matchemail()
    {
        var email = document.getElementsByName('email')['0'];
        var conffield = document.getElementsByName('confemail')['0'];
        if(email.value !== '' && conffield.value !== '')
        {
            if(conffield.value === email.value)
            {
                conffield.setAttribute("style", "border-color: green; border-width: 2px;");
                emailmatch = true;
            }
            else
            {
                conffield.setAttribute("style", "border-color: red; border-width: 2px;");
                emailmatch = false;
            }
        }
        else
        {
            emailmatch = false;
            conffield.setAttribute("style", "border: default;");
        }
        checksubmit();
    }
    function checkpass()
    {
        var passfield = document.getElementsByName('pass')['0'];
        if(passfield.value !== '')
        {
            if(passfield.value.length < 12)
            {
                passfield.setAttribute("style", "border-color: red; border-width: 2px;");
                passgood = false;
            }
            else if(passfield.value.length > 64)
            {
                passfield.setAttribute("style", "border-color: red; border-width: 2px;");
                passgood = false;
            }
            else if(passfield.value.indexOf('#') >= 0 || passfield.value.indexOf('$') >= 0 || passfield.value.indexOf('%') >= 0 || passfield.value.indexOf('@') >= 0 || passfield.value.indexOf('&') >= 0 || passfield.value.indexOf('(') >= 0 || passfield.value.indexOf(')') >= 0)
            {
                passfield.setAttribute("style", "border-color: red; border-width: 2px;");
                passgood = false;
            }
            else
            {
                passfield.setAttribute("style", "border-color: green; border-width: 2px;");
                passgood = true;
                matchpass();
            }
        }
        else
        {
            passfield.setAttribute("style", "border: default;");
            passgood = false;
        }
        checksubmit();
    }
    function matchpass()
    {
        var passfield = document.getElementsByName('pass')['0'];
        var conffield = document.getElementsByName('confpass')['0'];
        if(passfield.value !== '' && conffield.value !=='')
        {
            if(conffield.value === passfield.value)
            {
                conffield.setAttribute("style", "border-color: green; border-width: 2px;");
                passmatch = true;
            }
            else
            {
                conffield.setAttribute("style", "border-color: red; border-width: 2px;");
                passmatch = false;
            }
        }
        else
        {
            conffield.setAttribute("style", "border: default;");
            passmatch = false;
        }
        checksubmit();

    }
    function checkdob()
    {
        var dayfield = document.getElementsByName('dobday')['0'];
        var monthfield = document.getElementsByName('dobmonth')['0'];
        var yearfield = document.getElementsByName('dobyear')['0'];

        var date = new Date();
        var day = dayfield.value;
        var month = monthfield.value;
        var year = yearfield.value;
        if(date.getDate() - day >= 0)
        {
            if(date.getMonth() - month >= 0)
            {
                if(date.getFullYear() - year >= 13)
                {
                    dobgood = true;
                }
                else
                {
                    dobgood = false;
                }
            }
            else
            {
                if(date.getFullYear() - year >= 14)
                {
                    dobgood = true;
                }
                else
                {
                    dobgood = false;
                }
            }
        }
        else
        {
            if(date.getMonth() - month >= 0)
            {
                if(date.getFullYear() - year >= 14)
                {
                    dobgood = true;
                    alert('code 1');
                }
                else
                {
                    dobgood = false;
                    alert('code 2');
                }
            }
            else
            {
                if(date.getFullYear() - year >= 14)
                {
                    dobgood = true;
                }
                else
                {
                    dobgood = false;
                }
            }
        }
        checksubmit();
    }
    function checkterms()
    {
        var termsbox = document.getElementsByName('termsagree')['0'];
        if(termsbox.checked === true)
        {
            agreeterms = true;
        }
        else
        {
            agreeterms = false;
        }
        checksubmit();
    }
    function checkprivacy()
    {
        var privacybox = document.getElementsByName('privacyagree')['0'];
        if(privacybox.checked === true)
        {
            agreeprivacy = true;
        }
        else
        {
            agreeprivacy = false;
        }
        checksubmit();
    }
    function checksubmit()
    {
        if(unamegood === true && dobgood === true && emailgood === true && emailmatch === true && passgood === true && passmatch === true && agreeterms === true && agreeprivacy === true)
        {
            document.getElementById('submitbtn').disabled = false;
            document.getElementById('submitbtn').setAttribute('style', 'background-color: #2db950;');
        }
        else
        {
            document.getElementById('submitbtn').disabled = true;
            document.getElementById('submitbtn').setAttribute('style', 'background-color: red;');
        }
    }
    function UpdateError(error)
    {
        document.getElementById('createerror').innerHTML = error;
        document.getElementById('createerror').setAttribute('style', 'visibility: visible;');
    }
    function ClearError()
    {
        document.getElementById('createerror').setAttribute('style', 'visibility: hidden;');
    }
</script>
<!DOCTYPE html>
<html>
    <head>
        <title>Create Account on InventShare</title>
        <link rel="stylesheet" href="https://inventshare.co/css/act/signup.css">
    </head>
    <body onload="createstart()">
        <div class="content">
            <div class="createform">
                <text id="fieldlabel">First and Last Name</text></br>
                <input id="fnameinput" type="text" name="fname" value="" placeholder="First Name">
                <input id="lnameinput" type="text" name="lname" value="" placeholder="Last Name"></br>
                <text id="fieldlabel">Username</text></br>
                <input id="actinputlong" type="text" name="uname" value="" placeholder="Username" onblur="checkuname()"></br>
                <text id="fieldlabel">Password</text></br>
                <input id="actinputlong" type="password" name="pass" value="" placeholder="Password" onblur="checkpass()"></br>
                <text id="fieldlabel">Confirm Password</text></br>
                <input id="actinputlong" type="password" name="confpass" value="" placeholder="Confirm Password" onblur="matchpass()"></br>
                <text id="fieldlabel">E-Mail</text></br>
                <input id="actinputlong" type="email" name="email" value="" placeholder="E-Mail Address" onblur="checkemail()"></br>
                <text id="fieldlabel">Confirm E-Mail</text></br>
                <input id="actinputlong" type="email" name="confemail" value="" placeholder="Confirm E-Mail" onblur="matchemail()"></br>
                <text id="fieldlabel">Date of Birth</text></br>
                <div class="dobfield">
                    <select id="dobday" name="dobday" onchange="checkdob()">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                    <select id="dobmonth" name="dobmonth" onchange="checkdob()">
                        <option value="0">January</option>
                        <option value="1">February</option>
                        <option value="2">March</option>
                        <option value="3">April</option>
                        <option value="4">May</option>
                        <option value="5">June</option>
                        <option value="6">July</option>
                        <option value="7">August</option>
                        <option value="8">September</option>
                        <option value="9">October</option>
                        <option value="10">November</option>
                        <option value="11">December</option>
                    </select>
                    <select id="dobyear" name="dobyear" onchange="checkdob()">
                        <option value="2005">2005</option>
                        <option value="2004">2004</option>
                        <option value="2003">2003</option>
                        <option value="2002">2002</option>
                        <option value="2001">2001</option>
                        <option value="2000">2000</option>
                        <option value="1999">1999</option>
                        <option value="1998">1998</option>
                        <option value="1997">1997</option>
                        <option value="1996">1996</option>
                        <option value="1995">1995</option>
                        <option value="1994">1994</option>
                        <option value="1993">1993</option>
                        <option value="1992">1992</option>
                        <option value="1991">1991</option>
                        <option value="1990">1990</option>
                        <option value="1989">1989</option>
                        <option value="1988">1988</option>
                        <option value="1987">1987</option>
                        <option value="1986">1986</option>
                        <option value="1985">1985</option>
                        <option value="1984">1984</option>
                        <option value="1983">1983</option>
                        <option value="1982">1982</option>
                        <option value="1981">1981</option>
                        <option value="1980">1980</option>
                        <option value="1979">1979</option>
                        <option value="1978">1978</option>
                        <option value="1977">1977</option>
                        <option value="1976">1976</option>
                        <option value="1975">1975</option>
                        <option value="1974">1974</option>
                        <option value="1973">1973</option>
                        <option value="1972">1972</option>
                        <option value="1971">1971</option>
                        <option value="1970">1970</option>
                        <option value="1969">1969</option>
                        <option value="1968">1968</option>
                        <option value="1967">1967</option>
                        <option value="1966">1966</option>
                        <option value="1965">1965</option>
                        <option value="1964">1964</option>
                        <option value="1963">1963</option>
                        <option value="1962">1962</option>
                        <option value="1961">1961</option>
                        <option value="1960">1960</option>
                        <option value="1959">1959</option>
                        <option value="1958">1958</option>
                        <option value="1957">1957</option>
                        <option value="1956">1956</option>
                        <option value="1955">1955</option>
                        <option value="1954">1954</option>
                        <option value="1953">1953</option>
                        <option value="1952">1952</option>
                        <option value="1951">1951</option>
                        <option value="1950">1950</option>
                        <option value="1949">1949</option>
                        <option value="1948">1948</option>
                        <option value="1947">1947</option>
                        <option value="1946">1946</option>
                        <option value="1945">1945</option>
                        <option value="1944">1944</option>
                        <option value="1943">1943</option>
                        <option value="1942">1942</option>
                        <option value="1941">1941</option>
                        <option value="1940">1940</option>
                    </select>
                </div></br>
                <text id="fieldlabel">Agree to the Terms and Conditions</text></br>
                <div class="termsagree">
                    <input type="checkbox" name="termsagree" onclick="checkterms()">
                    <text id="termstext">I Agree to the <a href="https://inventshare.co/legal/terms-and-conditions">Terms and Conditions</a></text>
                </div></br>
                <text id="fieldlabel">Agree to the Privacy Policy</text></br>
                <div class="privacyagree">
                    <input type="checkbox" name="privacyagree" onclick="checkprivacy()">
                    <text id="termstext">I Agree to the <a href="https://inventshare.co/legal/privacy-policy">Privacy Policy</a></text>
                </div></br>
                <text id="createerror">CREATE ERROR</text></br>
                <input id="submitbtn" type="button" name="submitbtn" value="Create Account" onclick="actsubmit()">
            </div>
        </div>
    </body>
</html>