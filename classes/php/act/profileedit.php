<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.12.min.js"></script>
<script>
    var editAvatar;
    var editBanner;
    var editing;
    //AWS DATA
    var bucket = 'img.inventshare.co';
    var region = 'us-east-2';
    var poolID = 'us-east-1:69377d1c-380f-4cbb-8e6c-63f07b98a590';
    //Update AWS config
    AWS.config = new AWS.Config();
    AWS.config.accessKeyId = "REDACTED";
    AWS.config.secretAccessKey = "REDACTED";
    $(document).ready(function()
    {
        editAvatar = 'false';
        editBanner = 'false';
        editing = 'false';
        $(document.getElementsByName('file')['0']).change(function(){
            var file = document.getElementsByName('file')['0'].files[0];
            $.ajax
            ({
                url: 'https://inventshare.co/classes/php/getuid.php',
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
                            document.getElementById('pcutimg').src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/'+output+'/avatar.jpg?'+new Date().getTime();
                            document.getElementById('pavatar').src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/'+output+'/avatar.jpg?'+new Date().getTime();
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
                url: 'https://inventshare.co/classes/php/getuid.php',
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
                            document.getElementById('pbanner').src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/'+output+'/banner.jpg?'+new Date().getTime()
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
                url: 'https://inventshare.co/classes/php/getuid.php',
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
                            document.getElementById('pavatar').src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/default/avatar.jpg';
                            document.getElementById('pcutimg').src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/default/avatar.jpg';
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
                url: 'https://inventshare.co/classes/php/getuid.php',
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
                            document.getElementById('pbanner').src = 'https://d2rvrc9f32zpxz.cloudfront.net/users/default/banner.jpg';
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
            url: 'https://inventshare.co/classes/php/act/submitedit.php',
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
</script>
<?php
    $fname = DB::Query('SELECT fname FROM users WHERE user_id = :userid', array(':userid' => $_SESSION['user_id']))['0']['fname'];
    $lname = DB::Query('SELECT lname FROM users WHERE user_id = :userid', array(':userid' => $_SESSION['user_id']))['0']['lname'];
    $location = DB::Query('SELECT location FROM profiles WHERE user_id = :userid', array(':userid' => $_SESSION['user_id']))['0']['location'];
    $summary = DB::Query('SELECT summary FROM profiles WHERE user_id = :userid', array(':userid' => $_SESSION['user_id']))['0']['summary'];
?>
<!DOCTYPE html>
<html>
    <body style="text-align: center;">
        <form id="fileup" enctype="multipart/form-data" method="post" style="position: absolute; height: 0px; width: 0px; top: -5000px; left: -5000px;">
            <input type="file" name="file" accept="image/jpeg, image/jpg, image/png">
            <input type="file" name="file" accept="image/jpeg, image/jpg, image/png">
        </form>
        <div class="editbutton">
            <input type="button" id="editbtn" name="editbtn" value="EDIT">
        </div>
        <div class="banneredit">
            <input type="button" id="bannerbtn" name="bannerbtn" value="">
            <img src="https://inventshare.co/img/ui/photo.png">
        </div>
        <div class="avataredit">
            <input type="button" id="avatarbtn" name="avatarbtn" value="">
            <img src="https://inventshare.co/img/ui/photo.png">
        </div>
        <div class="avatarwindow" id="avatarwindow">
            <input id="avbutton" type="button" value="UPLOAD" style="margin-top: 4%;" onclick="Loadfile('0')">
            <input id="avbutton" type="button" value="REMOVE" style="margin-top: 4%;" onclick="RemoveImage('avatar')">
            <input id="avbutton" type="button" value="CANCEL" style="margin-top: 4%;" onclick="Avataredit()">
        </div>
        <div class="bannerwindow" id="bannerwindow">
            <input id="avbutton" type="button" value="UPLOAD" style="margin-top: 4%;" onclick="Loadfile('1')">
            <input id="avbutton" type="button" value="REMOVE" style="margin-top: 4%;" onclick="RemoveImage('banner')">
            <input id="avbutton" type="button" value="CANCEL" style="margin-top: 4%;" onclick="Banneredit()">
        </div>
        <div class="infowindow" id="infowindow">
            <input type="text" id="fnamefield" value="<?php echo $fname ?>" placeholder="<?php echo $fname ?>">
            <input type="text" id="lnamefield" value="<?php echo $lname ?>" placeholder="<?php echo $lname ?>">
            <textarea id="summaryfield" placeholder="<?php echo $summary ?>"><?php echo $summary ?></textarea>
            <input type="text" id="locationfield" value="<?php echo $location ?>" placeholder="<?php echo $location ?>">
        </div>
    </body>
</html>