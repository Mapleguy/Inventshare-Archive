<script>
    var invid;
    var editing = false;
    $('document').ready(function()
    {
        invid = <?php echo $getid ?>;
        invcat = <?php echo $invcat; ?>;
        intype = <?php echo $invtype; ?>;
        document.getElementById('nameinput').value = <?php echo "'".$invname."'" ?>;
        document.getElementById('descinput').value = <?php echo "'".$invdesc."'" ?>;
        document.getElementById('summinput').value = <?php echo "'".$invsumm."'" ?>;
        document.getElementById('typeinput').value = <?php echo "'".$invtype."'" ?>;
        document.getElementById('catinput').value = <?php echo "'".$invcat."'" ?>;
        $(document.getElementById('invimages')).change(function()
        {
            var files = document.getElementById('invimages').files;
            if(files.length > 10 - Object.keys(imgs).length)
            {
                alert('Too many files!');
            }
            else
            {
                AWS.config = new AWS.Config();
                AWS.config.accessKeyId = "AKIAJKXUJC3OQQ26CPHQ";
                AWS.config.secretAccessKey = "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";
                S3 = new AWS.S3();
                for(var i = 0; i < files.length; i++)
                {
                    var params =
                    {
                        Bucket: 'img.inventshare.co/inventions/'+invid,
                        Key: files[i].name,
                        Body: files[i],
                        ACL: 'public-read'
                    };
                    S3.putObject(params, function(err, data)
                    {
                        if(!err)
                        {
                            var params = 
                            {
                                Bucket: 'img.inventshare.co',
                                Prefix: 'inventions/'+invid
                            };
                            S3.listObjects(params, function(err, data)
                            {
                                if(!err)
                                {
                                    for(var i = 0; i < data.Contents.length; i++)
                                    {
                                        imgs[i] = data.Contents[i].Key;
                                    }
                                    document.getElementById('prvmax').innerHTML = (Object.keys(imgs).length);
                                }
                                else
                                {
                                    alert('no did 2');
                                }
                            });
                        }
                        else
                        {
                            alert('no did');
                        }
                    });
                }
            }
        });
    });   
    function ToggleEdit()
    {
        if(editing)
        {
            HideEdit();
        }
        else
        {
            ShowEdit();
        }
    }
    function ShowEdit()
    {
        document.getElementById('cattext').setAttribute('style', 'visibility: hidden;');
        document.getElementById('typetext').setAttribute('style', 'visibility: hidden;');
        document.getElementsByClassName('summary')['0'].setAttribute('style', 'visibility: hidden;');
        document.getElementById('name').setAttribute('style', 'visibility: hidden;');
        document.getElementById('desc').setAttribute('style', 'visibility: hidden;');
        document.getElementsByClassName('editinput')['0'].setAttribute('style', 'visibility: visible;');
        editing = true;
    }
    function HideEdit()
    {
        document.getElementById('cattext').setAttribute('style', 'visibility: visible;');
        document.getElementById('typetext').setAttribute('style', 'visibility: visible;');
        document.getElementsByClassName('summary')['0'].setAttribute('style', 'visibility: visible;');
        document.getElementById('name').setAttribute('style', 'visibility: visible;');
        document.getElementById('desc').setAttribute('style', 'visibility: visible;');
        document.getElementsByClassName('editinput')['0'].setAttribute('style', 'visibility: hidden;');
        editing = false;
        SubmitEdit();
    }
    function SubmitEdit()
    {
        var name = document.getElementById('nameinput');
        var desc = document.getElementById('descinput');
        var type = document.getElementById('typeinput');
        var cat = document.getElementById('catinput');
        var summ = document.getElementById('summinput');
        $.ajax
        ({
            url: 'https://inventshare.co/classes/php/post/submitedit.php',
            type: 'post',
            data:
            {
                submitedit: 'true',
                invid: invid,
                name: name.value,
                desc: desc.value,
                type: type.value,
                cat: cat.value,
                summ: summ.value
            },
            success: function(output)
            {
                switch(type.value)
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
                switch(cat.value)
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
                document.getElementById('name').innerHTML = name.value;
                document.getElementById('desc').innerHTML = desc.value;
                document.getElementById('summp').innerHTML = summ.value;
            }
        });
    }  
    function DeleteImage()
    {
        AWS.config = new AWS.Config();
        AWS.config.accessKeyId = "AKIAJKXUJC3OQQ26CPHQ";
        AWS.config.secretAccessKey = "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";
        var S3 = new AWS.S3();
        var params =
        {
            Bucket: 'img.inventshare.co',
            Key: imgs[curimg]
        };
        
        if(imgs.length < 4)
        {
            alert('NOT ENOUGH IMAGES');
        }
        else
        {
            S3.deleteObject(params, function(err, data)
            {
                if(!err)
                {
                    alert('DID');
                }
                else
                {
                    alert(err);
                }
            });
        }
    }
</script>
<html>
    <body>
        <div class="editbutton" onclick="ToggleEdit()">
            <text>EDIT</text>
        </div>
        <div class="editinput">
            <input id="nameinput" type="text" placeholder="Invention Name..." value="">
            <input id="descinput" type="text" placeholder="Invention Description..." value="">
            <textarea id="summinput" type="textarea" placeholder="Invention Summary..." value="" rows="8"></textarea>
            <select id="catinput">
                <option value="null">Select Category...</option>
                <option value="1">Aeronautics</option>
                <option value="2">Astronautics</option>
                <option value="3">Automation</option>
                <option value="4">Business</option>
                <option value="5">Computing</option>
                <option value="6">Economics</option>
                <option value="7">Electronics</option>
                <option value="8">Energy</option>
                <option value="9">Industry</option>
                <option value="10">Mathematics</option>
                <option value="11">Medicine</option>
                <option value="12">Recreation</option>
                <option value="13">Robotics</option>
                <option value="14">Science</option>
                <option value="15">Transportation</option>
                <option value="16">Other</option>
            </select>
            <select id="typeinput">
                <option value="null">Select Type...</option>
                <option value="1">Code</option>
                <option value="2">Concept</option>
                <option value="3">Design</option>
                <option value="4">Electrical</option>
                <option value="5">Mechanical</option>
                <option value="6">Process</option>
                <option value="7">Theory</option>
                <option value="8">Tool</option>
                <option value="9">Other</option>
            </select>
            <div class="imgmanager">
                <div id="upload" onclick="document.getElementById('invimages').click();">
                    <img src="https://inventshare.co/img/ui/upload.png" style="width: 100%; height: 100%;">
                </div>
                <div id="delete" onclick="document.getElementById('delconfirm').setAttribute('style', 'visibility: visible;')">
                    <img src="https://inventshare.co/img/ui/trash.png" style="width: 100%; height: 100%;">
                </div>
                <div id="delconfirm">
                    <div id="t"><text>Delete this image?</text></div>
                    <div id="b" onclick="DeleteImage()"><text>DELETE, DELETE</text></div>
                    <div id="b" onclick="document.getElementById('delconfirm').setAttribute('style', 'visibility: hidden;')"><text>No, don't delete.<text></div>
                </div>
                <input id="invimages" type="file" multiple="true" accept="image/jpeg, image/jpg, image/png">
            </div>
        </div>
        <div id="margin" style="position: absolute; top: 58vw; width: 100%; height: 3vw;"></div>
    </body>
</html>