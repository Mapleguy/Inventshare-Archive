function Login()
{
    var unamefield = document.getElementsByName('uname')['0'];
    var passfield = document.getElementsByName('pword')['0'];
    
    if(unamefield.value !== '')
    {
        if(passfield.value !== '')
        {
            $.ajax
            ({
                url: 'https://www.inventshare.co/testing/classes/php/act/actlog.php',
                type: 'post',
                data:
                {
                    log: 'in',
                    uname: unamefield.value,
                    pword: passfield.value
                },
                success: function(output)
                {
                    window.location = 'https://www.inventshare.co/testing/';
                }
            });}}}