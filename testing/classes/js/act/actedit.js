var editAvatar;
var editBanner;
var editing;

//AWS DATA
var bucket = 'img.inventshare.co';
var region = 'us-east-2';
var poolID = 'us-east-1:69377d1c-380f-4cbb-8e6c-63f07b98a590';

//Update AWS config
AWS.config = new AWS.Config();
AWS.config.accessKeyId = "AKIAJKXUJC3OQQ26CPHQ";
AWS.config.secretAccessKey = "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";

$(document).ready(function()
{
    editAvatar = 'false';
    editBanner = 'false';
    editing = 'false';
    
    $(document.getElementsByName('file')['0']).change(function(){
        var file = document.getElementsByName('file')['0'].files[0];
        $.ajax
        ({
            url: 'https://www.inventshare.co/testing/classes/php/getuid.php',
            type: 'POST',
            data:
            {
                getuid: 'true'
            },
            success: function(output) 
            {
                var S3 = new AWS.S3();
                var params =
                {
                    Bucket: 'img.inventshare.co/users/'+output,
                    Key: 'avatar.jpg',
                    Body: file,
                    ACL: 'public-read'
                };

                S3.putObject(params, function(err, data)
                {
                    if(!err)
                    {
                        document.getElementById('pcutimg').src = 'http://img.inventshare.co/users/'+output+'/avatar.jpg?'+new Date().getTime();
                        document.getElementById('pavatar').src = 'http://img.inventshare.co/users/'+output+'/avatar.jpg?'+new Date().getTime();
                    }
                    else
                    {
                        alert(err);
                    }
                });
            }
        });
    });
    
    $(document.getElementsByName('file')['1']).change(function(){
        var file = document.getElementsByName('file')['1'].files[0];
        $.ajax
        ({
            url: 'https://www.inventshare.co/testing/classes/php/getuid.php',
            type: 'POST',
            data:
            {
                getuid: 'true'
            },
            success: function(output) 
            {
                var S3 = new AWS.S3();
                var params =
                {
                    Bucket: 'img.inventshare.co/users/'+output,
                    Key: 'banner.jpg',
                    Body: file,
                    ACL: 'public-read'
                };

                S3.putObject(params, function(err, data)
                {
                    if(!err)
                    {
                        document.getElementById('pbanner').src = 'http://img.inventshare.co/users/'+output+'/banner.jpg?'+new Date().getTime()
                    }
                    else
                    {
                        
                    }
                });
            }
        });
    });
});

function Editprofile()
{
    var aeditbtn = document.getElementsByClassName('avataredit')['0'];
    var beditbtn = document.getElementsByClassName('banneredit')['0'];
    var infowindow = document.getElementsByClassName('infowindow')['0'];
    if(editing === 'false')
    {
        aeditbtn.setAttribute('style', 'visibility: visible;');
        beditbtn.setAttribute('style', 'visibility: visible;');
        infowindow.setAttribute('style', 'visibility: visible;');
        document.getElementById('realname').setAttribute('style', 'visibility: hidden;');
        document.getElementById('summary').setAttribute('style', 'visibility: hidden;');
        document.getElementById('location').setAttribute('style', 'visibility: hidden;');
        editing = 'true';
    }
    else if(editing === 'true')
    {
        Submitinfo();
        aeditbtn.setAttribute('style', 'visibility: hidden;');
        beditbtn.setAttribute('style', 'visibility: hidden;');
        infowindow.setAttribute('style', 'visibility: hidden;');
        document.getElementById('realname').setAttribute('style', 'visibility: visible;');
        document.getElementById('summary').setAttribute('style', 'visibility: visible;');
        document.getElementById('location').setAttribute('style', 'visibility: visible;');
        editing = 'false';
    }
}

function Avataredit()
{
    var window = document.getElementById('avatarwindow');
    if(editAvatar === 'false')
    {
        window.setAttribute('style', 'visibility: visible;');
        editAvatar = 'true';
    }
    else if(editAvatar === 'true')
    {
        window.setAttribute('style', 'visibility: hidden;');
        editAvatar = 'false';
    }
}

function Hideavedit()
{
    document.getElementById('avatarwindow').setAttribute('style', 'visibility: hidden;');
    editAvatar = 'false';
}

function Banneredit()
{
    var window = document.getElementById('bannerwindow');
    if(editBanner === 'false')
    {
        window.setAttribute('style', 'visibility: visible;');
        editBanner = 'true';
    }
    else if(editBanner === 'true')
    {
        window.setAttribute('style', 'visibility: hidden;');
        editBanner = 'false';
    }
}

function Hidebanedit()
{
    document.getElementById('bannerwindow').setAttribute('style', 'visibility: hidden;');
    editBanner = 'false';
}

function Loadfile(num)
{
    document.getElementsByName('file')[num].click();
}

function RemoveImage(image)
{
    if(image === 'avatar')
    {
        $.ajax
        ({
            url: 'https://www.inventshare.co/testing/classes/php/getuid.php',
            type: 'POST',
            data:
            {
                getuid: 'true'
            },
            success: function(output) 
            {
                var S3 = new AWS.S3();
                var params =
                {
                    Bucket: 'img.inventshare.co/users/'+output,
                    Key: 'avatar.jpg'
                };

                S3.deleteObject(params, function(err, data)
                {
                    if(!err)
                    {
                        document.getElementById('pavatar').src = 'img.inventshare.co/users/default/avatar.jpg';
                        document.getElementById('pcutimg').src = 'img.inventshare.co/users/default/avatar.jpg';
                    }
                    else
                    {
                        
                    }
                });
            }
        });
    }
    else if(image === 'banner')
    {
        $.ajax
        ({
            url: 'https://www.inventshare.co/testing/classes/php/getuid.php',
            type: 'POST',
            data:
            {
                getuid: 'true'
            },
            success: function(output) 
            {
                var S3 = new AWS.S3();
                var params =
                {
                    Bucket: 'img.inventshare.co/users/'+output,
                    Key: 'banner.jpg'
                };

                S3.deleteObject(params, function(err, data)
                {
                    if(!err)
                    {
                        document.getElementById('pbanner').src = 'img.inventshare.co/users/default/banner.jpg';
                    }
                    else
                    {
                        
                    }
                });
            }
        });
    }
}

function Submitinfo()
{
    var info = document.getElementsByClassName('info')['0'].childNodes;
    var fname = document.getElementById('fnamefield');
    var lname = document.getElementById('lnamefield');
    var summary = document.getElementById('summaryfield');
    var location = document.getElementById('locationfield');
    $.ajax
    ({
        url: 'https://www.inventshare.co/testing/classes/php/act/submitedit.php',
        type: 'post',
        data:
        {
            dosubmit: 'true',
            fname: fname.value,
            lname: lname.value,
            summary: summary.value,
            location: location.value
        },
        success: function(output)
        {
            $(info[3]).text(fname.value + ' ' + lname.value);
            $(info[5]).text(summary.value);
            $(info[7]).text(location.value);
        }
    });
}