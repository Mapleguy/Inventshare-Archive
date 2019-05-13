var editing = false;

$('document').ready(function()
{
    
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
        url: 'https://www.inventshare.co/testing/classes/php/post/submitedit.php',
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