$('document').ready(function()
{
    LoadUser(1);
});

function LoadUser(user)
{
    var posts;
    $.ajax
    ({
        type: "POST",
        url: "https://www.inventshare.co/classes/php/post/userposts.php",
        data:
        {
            userid: user
        },
        dataType: "json",
        success: function(output)
        {
            posts = output;
            alert(output[0][0].inventionid);
        }
    });
}