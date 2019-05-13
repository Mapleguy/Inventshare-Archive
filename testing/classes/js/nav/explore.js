var postnum;
var exploremode;

$('document').ready(function()
{
    //ExploreSwap('newest');
});

function ExploreSwap(type)
{
    ClearContent();
    switch(type)
    {
        case 'newest':
            exploremode = type;
            LoadNewest();
            break;
            
        case 'top':
            exploremode = type;
            LoadTop();
            break;
            
        case 'random':
            exploremode = type;
            LoadRandom();
            break;
            
        default:
            exploremode = 'newest';
            LoadNewest();
            break;
    }
}

function LoadNewest()
{
    $.ajax
    ({
        type: "POST",
        url: "https://www.inventshare.co/testing/classes/php/post/postnum.php",
        data:
        {
            type: 'newest'
        },
        success: function(output)
        {
            NewPreview(output, function()
            {
                NewPreview(output - 1, function()
                {
                    NewPreview(output - 2, function()
                    {
                        NewPreview(output - 3, function()
                        {
                            NewPreview(output - 4, function()
                            {
                                NewPreview(output - 5, function()
                                {
                                    NewPreview(output - 6, function()
                                    {
                                        NewPreview(output - 7, function()
                                        {
                                            NewPreview(output - 8, function()
                                            {
                                                NewPreview(output - 9);
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    });
                });
            });
        }
    });
}

function LoadTop()
{
    alert('Top!');
}

function LoadRandom()
{
    alert('Random!');
}

function NewPreview(postcount, callback)
{
    $.ajax
    ({
        type: "GET",
        url: "https://www.inventshare.co/testing/post/postpreview.php",
        data:
        {
            num: postcount
        },
        success: function(output)
        {
            $('.content').append(output);
            if(callback)
            {
                callback();
            }
        }
    });
}

function ClearContent()
{
    $('.postprev').remove();
}