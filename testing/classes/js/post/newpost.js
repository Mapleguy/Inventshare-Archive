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
        url: '../classes/php/post/submitpost.php',
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
                        window.location.href = 'https://www.inventshare.co/testing/invention?i='+output;
                    }
                    else
                    {
                        alert(err);
                    }
                });
            }
            //window.location.href = 'https://www.inventshare.co/testing/invention?i='+output;
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