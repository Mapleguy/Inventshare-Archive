<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');   
    if(isset($_GET['i']))
    {
        $getid = $_GET['i'];
    }
    else
    {
        $getid = 'INVALID';
    }
    $invname = DB::Query('SELECT inventionname FROM inventions WHERE inventionid = :invid', array(':invid' => $getid))['0']['inventionname'];
    $invdesc = DB::Query('SELECT inventiondesc FROM inventions WHERE inventionid = :invid', array(':invid' => $getid))['0']['inventiondesc'];
    $invsumm = DB::Query('SELECT inventionsumm FROM inventions WHERE inventionid = :invid', array(':invid' => $getid))['0']['inventionsumm'];
    $invcat = DB::Query('SELECT inventioncategory FROM inventions WHERE inventionid = :invid', array(':invid' => $getid))['0']['inventioncategory'];
    $invtype = DB::Query('SELECT inventiontype FROM inventions WHERE inventionid = :invid', array(':invid' => $getid))['0']['inventiontype'];
    $inventorid = DB::Query('SELECT inventorid FROM inventions WHERE inventionid = :invid', array(':invid' => $getid))['0']['inventorid'];
    $inventor = DB::Query('SELECT username FROM users WHERE user_id = :userid', array(':userid' => $inventorid))['0']['username'];
    $key = fopen($_SERVER['DOCUMENT_ROOT'].'/secure/access.key', 'r');
    $newkey = fread($key, filesize($_SERVER['DOCUMENT_ROOT'].'/secure/access.key'));
    fclose($key);
    $secret = fopen($_SERVER['DOCUMENT_ROOT'].'/secure/secret.key', 'r');
    $newsecret = fread($secret, filesize($_SERVER['DOCUMENT_ROOT'].'/secure/secret.key'));
    fclose($secret);
?>
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.12.min.js"></script>
<script>
    var imgs = [];
    var curimg = 0;
    $('document').ready(function()
    {
        //Update AWS config
        AWS.config = new AWS.Config();
        AWS.config.accessKeyId = <?php echo "'".$newkey."'" ?>;
        AWS.config.secretAccessKey = <?php echo "'".$newsecret."'" ?>;
        var S3 = new AWS.S3();
        var params = 
        {
            Bucket: 'img.inventshare.co',
            Prefix: 'inventions/'+<?php echo $getid ?>
        };
        S3.listObjects(params, function(err, data)
        {
            if(!err)
            {
                for(var i = 0; i < data.Contents.length; i++)
                {
                    imgs[i] = data.Contents[i].Key;
                }
                document.getElementById('mainimage1').src = 'https://d2rvrc9f32zpxz.cloudfront.net/'+imgs[curimg];
                document.getElementById('prvmax').innerHTML = (Object.keys(imgs).length);
            }
        });       
        //Setup invention info
        switch(<?php echo "'".$invtype."'" ?>)
        {
            case '1':
            document.getElementById('typetext').innerHTML = 'Type: Code';
            break;
            case '2':
            document.getElementById('typetext').innerHTML = 'Type: Concept';
            break;
            case '3':
            document.getElementById('typetext').innerHTML = 'Type: Design';
            break;
            case '4':
            document.getElementById('typetext').innerHTML = 'Type: Electrical';
            break;
            case '5':
            document.getElementById('typetext').innerHTML = 'Type: Mechanical';
            break;
            case '6':
            document.getElementById('typetext').innerHTML = 'Type: Process';
            break;
            case '7':
            document.getElementById('typetext').innerHTML = 'Type: Theory';
            break;
            case '8':
            document.getElementById('typetext').innerHTML = 'Type: Tool';
            break;
            case '9':
            document.getElementById('typetext').innerHTML = 'Type: Other';
            break;
            default:
            document.getElementById('typetext').innerHTML = 'Type: ERROR';
            break;
        } 
        switch(<?php echo "'".$invcat."'" ?>)
        {
            case '1':
            document.getElementById('cattext').innerHTML = 'Category: Aeronautics';
            break;
            case '2':
            document.getElementById('cattext').innerHTML = 'Category: Astronautics';
            break;
            case '3':
            document.getElementById('cattext').innerHTML = 'Category: Automation';
            break;
            case '4':
            document.getElementById('cattext').innerHTML = 'Category: Business';
            break;
            case '5':
            document.getElementById('cattext').innerHTML = 'Category: Computing';
            break;
            case '6':
            document.getElementById('cattext').innerHTML = 'Category: Economics';
            break;
            case '7':
            document.getElementById('cattext').innerHTML = 'Category: Electronics';
            break;
            case '8':
            document.getElementById('cattext').innerHTML = 'Category: Energy';
            break;
            case '9':
            document.getElementById('cattext').innerHTML = 'Category: Industry';
            break;
            case '10':
            document.getElementById('cattext').innerHTML = 'Category: Mathematics';
            break;
            case '11':
            document.getElementById('cattext').innerHTML = 'Category: Medicine';
            break;
            case '12':
            document.getElementById('cattext').innerHTML = 'Category: Recreation';
            break;
            case '13':
            document.getElementById('cattext').innerHTML = 'Category: Robotics';
            break;
            case '14':
            document.getElementById('cattext').innerHTML = 'Category: Science';
            break;
            case '15':
            document.getElementById('cattext').innerHTML = 'Category: Transportation';
            break;
            case '16':
            document.getElementById('cattext').innerHTML = 'Category: Other';
            break;
            default:
            document.getElementById('cattext').innerHTML = 'Category: ERROR';
            break;
        }
    });
    function NextImage()
    {
        if(curimg < Object.keys(imgs).length - 1)
        {
            curimg++;
            document.getElementById('mainimage1').src = 'https://d2rvrc9f32zpxz.cloudfront.net/'+imgs[curimg];
            document.getElementById('prvcur').innerHTML = (curimg + 1);
        }
    }
    function PrevImage()
    {
        if(curimg > 0)
        {
            curimg--;
            document.getElementById('mainimage1').src = 'https://d2rvrc9f32zpxz.cloudfront.net/'+imgs[curimg];
            document.getElementById('prvcur').innerHTML = (curimg + 1);
        }
    }
    function ShowImage()
    {
        document.getElementById('imagewindow').style.visibility = 'visible';
        document.getElementById('windowimg').src = document.getElementById('mainimage1').src;
    }
    function HideImage()
    {
        document.getElementById('imagewindow').style.visibility = 'hidden';
    }
</script>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $invname ?> on InventShare</title>
        <link rel="stylesheet" href="https://inventshare.co/css/post/invention.css">
    </head>
    <body>
        <div class="content">
            <div class="title">
                <text id="name"><?php echo $invname ?></text></br>
                <text id="desc"><?php echo $invdesc ?></text>
            </div>
            <div class="imagepreview">
                <div id="mainimage">
                    <img id="mainimage1" src='' alt='' onclick="ShowImage()">
                </div>
                <div class="prvleftbutton" onclick="PrevImage()"><text><</text></div>
                <div class="prvnum">
                    <text id="prvcur">1</text>
                    <text>/</text>
                    <text id="prvmax"></text>
                </div>
                <div class="prvrightbutton" onclick="NextImage()"><text>></text></div>
            </div>
            <div class="info">
                <text>Inventor: <a href="https://inventshare.co/profile?user=<?php echo $inventor ?>"><?php echo $inventor ?></a></text></br>
                <text id="cattext">Category: </text></br>
                <text id="typetext">Type: ''</text>
            </div>
            <div class="summary">
                <text>Summary</text>
                <p id="summp"><?php echo $invsumm ?></p>
            </div>
        </div>
        <div class="imagewindow" id="imagewindow" name="imagewindow">
            <img id="windowimg" src="" alt="" name="windowimg">
            <div id="windowexit" onclick="HideImage()"><text>X</text></div>
        </div>
    </body>
</html>

<?php
    if($_SESSION['user_id'] === $inventorid)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/post/invedit.php');
    }
?>