<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.12.min.js"></script>
<script>
    var imgpreviews;
    var fileupload;
    $('document').ready(function()
    {
        imgpreviews = document.querySelectorAll('#imgprv');
        fileupload = document.getElementById('invimages');

        $(fileupload).change(function()
        {
            if(fileupload.value !== null)
            {
                Updatepreviews();
            }
        });
    });
    function Openfiles()
    {
        fileupload.click();
    }
    function Updatepreviews()
    {
        var imagecount = fileupload.files.length;
        document.getElementById('imgcount').innerHTML = imagecount+' Images Selected';
    }
    function Selectimages()
    {
        document.getElementById('invimages').click();
    }
    function AttemptPost()
    {
        if(document.getElementById('invname').value !== '')
        {
            if(document.getElementById('invdesc').value !== '')
            {
                if(document.getElementById('invsummary').value !== '')
                {
                    if(!(fileupload.files.length < 3))
                    {
                        if(!(fileupload.files.length > 7))
                        {
                            if(document.getElementById("invcategory").value !== 'null')
                            {
                                if(document.getElementById("invtype").value !== 'null')
                                {
                                    if(document.getElementById('invpatent').value !== 'null')
                                    {
                                        if(document.getElementById('invpatent').value === '0')
                                        {
                                            if(document.getElementById('invterms').checked === true)
                                            {
                                                SubmitPost();
                                            }
                                            else
                                            {
                                                UpdateError('Please agree to the terms of posting!');
                                            }
                                        }
                                        else
                                        {
                                            UpdateError("We don't accept patented inventions right now!");
                                        }
                                    }
                                    else
                                    {
                                        UpdateError('Let us know if your invention has a patent!');
                                    }
                                }
                                else
                                {
                                    UpdateError('Your invention needs a type!');
                                }
                            }
                            else
                            {
                                UpdateError('Your invention needs a category!');
                            }
                        }
                        else
                        {
                            UpdateError('You must select less than 7 images!');
                        }
                    }
                    else
                    {
                        UpdateError('You need to select more images!');
                    }
                }
                else
                {
                    UpdateError('Your invention needs a summary!');
                }
            }
            else
            {
                UpdateError('Your invention needs a description!');
            }
        }
        else
        {
            UpdateError('Your invention needs a name!');
        }
    }
    function SubmitPost()
    {
        $.ajax({
            url: 'https://inventshare.co/classes/php/post/submitpost.php',
            type: 'post',
            data:
            {
                newpost: 'true',
                inventionname: document.getElementById('invname').value,
                inventiondesc: document.getElementById('invdesc').value,
                inventionsumm: document.getElementById('invsummary').value,
                inventioncat: document.getElementById("invcategory").value,
                inventiontype: document.getElementById("invtype").value,
                haspatent: document.getElementById('invpatent').value
            },
            success: function(output)
            {
                //Update AWS config
                AWS.config = new AWS.Config();
                AWS.config.accessKeyId = "AKIAJKXUJC3OQQ26CPHQ";
                AWS.config.secretAccessKey = "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";
                var imgs = document.getElementById('invimages');
                var S3 = new AWS.S3();
                for(var i = 0; i < imgs.files.length; i++)
                {
                    var bucket =
                    {
                        Bucket: "img.inventshare.co/inventions/"+output
                    };

                    var params =
                    {
                        Bucket: 'img.inventshare.co/inventions/'+output,
                        Key: imgs.files[i].name,
                        Body: imgs.files[i],
                        ACL: 'public-read'
                    };

                    S3.createBucket(bucket);

                    S3.putObject(params, function(err, data)
                    {
                        if(!err)
                        {
                            window.location.href = 'https://inventshare.co/invention?i='+output;
                        }
                        else
                        {
                            alert(err);
                        }
                    });
                }
            }
        });
    }
    function ShowHelp(tipid)
    {
        document.getElementById(tipid).setAttribute('style', 'visibility: visible;');
    }
    function HideHelp(tipid)
    {
        document.getElementById(tipid).setAttribute('style', 'visibility: hidden;');
    }
    function UpdateError(error)
    {
        document.getElementById('submiterror').innerHTML = error;
        document.getElementById('submiterror').setAttribute('style', 'visibility: visible');
    }
</script>
<!DOCTYPE html>
<html>
    <head>
        <title>New Invention on InventShare</title>
        <link rel="stylesheet" href="https://inventshare.co/css/post/newpost.css">
    </head>
    <body>
        <div class="content">
            <form class="postinfo" enctype="multipart/form-data">
                <text id="postlabel">Invention Name</text>
                <text id="namehelper" onmouseover="ShowHelp('namehelp')" onmouseleave="HideHelp('namehelp')">?</text></br>
                <input id="invname" type="text" value="" placeholder="Invention Name"></br></br>
                <text id="postlabel">Invention Description</text>
                <text id="deschelper" onmouseover="ShowHelp('deschelp')" onmouseleave="HideHelp('deschelp')">?</text></br>
                <input id="invdesc" type="text" value="" placeholder="Invention Description"></br></br>
                <text id="postlabel">Invention Summary</text>
                <text id="summhelper" onmouseover="ShowHelp('summhelp')" onmouseleave="HideHelp('summhelp')">?</text></br>
                <textarea id="invsummary" placeholder="Invention Summary..."></textarea></br></br>
                <text id="postlabel">Invention Images</text>
                <text id="imghelper" onmouseover="ShowHelp('imghelp')" onmouseleave="HideHelp('imghelp')">?</text></br>
                <text id="imgcount">0 Images Selected</text></br>
                <input id="imagesbutton" type="button" value="Select Images" onclick="Selectimages()"></br></br>
                <text id="postlabel">Invention Category</text>
                <text id="namehelper" onmouseover="ShowHelp('cathelp')" onmouseleave="HideHelp('cathelp')">?</text></br>
                <select id="invcategory">
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
                </select></br>
                <text id="postlabel">Invention Type</text>
                <text id="namehelper" onmouseover="ShowHelp('typehelp')" onmouseleave="HideHelp('typehelp')">?</text></br>
                <select id="invtype">
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
                </select></br>
                <text id="postlabel">Does this invention have an existing patent?</text>
                <text id="namehelper" onmouseover="ShowHelp('pathelp')" onmouseleave="HideHelp('pathelp')">?</text></br>
                <select id="invpatent">
                    <option value="null">Select Option...</option>
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select></br>
                <text id="postlabel">Do you agree to the Terms of Posting an invention?</text><br>
                <input id="invterms" type="checkbox"><text id="invtermstext">Agree to Terms?</text></br>
                <text id="submiterror">ERROR?</text></br></br>
                <input id="postbutton" type="button" value="Post Invention" onclick="AttemptPost()">
                <input id="invimages" type="file" multiple="true" accept="image/jpeg, image/jpg, image/png">
            </form>
            <div class="namehelp" id="namehelp">
                <p>
                    What name will quickly tell an Inventor what this invention is? This will be the first thing they read about your invention.
                </p>
            </div>
            <div class="deschelp" id="deschelp">
                <p>
                    What description will give an Inventor an idea of what your invention does? Keep it brief and easy to understand.
                </p>
            </div>
            <div class="summhelp" id="summhelp">
                <p>
                    Here you can go into detail about your invention, how it works, and what it's made for. This is where you really flesh out your idea.
                </p>
            </div>
            <div class="imghelp" id="imghelp">
                <p>
                    Upload 3-5 images of your invention. They can be photos, blueprints, whatever. These will help Inventors visualize your invention.
                </p>
            </div>
            <div class="cathelp" id="cathelp">
                <p>
                    What is the major field this invention is intended for? What purpose did you conceptualize for this invention?
                </p>
            </div>
            <div class="typehelp" id="typehelp">
                <p>
                    What actually is this invention? A piece of machinery, some code, or purely a concept?
                </p>
            </div>
            <div class="pathelp" id="pathelp">
                <p>
                    InventShare does not currently support uploading inventions with currently active patents, only Public Domain inventions. We hope to soon!
                </p>
            </div>
        </div>
    </body>
</html>