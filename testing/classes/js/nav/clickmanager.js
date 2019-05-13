var menuvis = false;
var navmenu = document.getElementById('navoptions');

window.onclick = function(e)
{
    var elem = e.target.name;
    var type = e.target;
    switch(elem)
    {
        case "pcutimg":
            Togglenav();
            if(document.getElementById('avatarbtn'))
            {
                Hideavedit();
            }
            break;
            
        case "editbtn":
        {
            Editprofile();
            Hideavedit();
            Hidebanedit();
            Hidenav();
            break;
        }
         
        case "avatarbtn":
            Avataredit();
            Hidenav();
            Hidebanedit();
            break;
                    
        case "bannerbtn":
            Banneredit();
            Hidenav();
            Hideavedit();
            break;
        
        case "navlogin":
            break;
        
        case "loginlabel":
            break;
        
        case "navun":
            break;
        
        case "navpass":
            break;
        
        case "navinput":
            break;
        
        default:
            Hidenav();
            if(document.getElementById('avatarbtn'))
            {
                Hideavedit();
                Hidebanedit();
            }
            break;
    }
};

function Togglenav()
{
    var navmenu = document.getElementById('navoptions');
    if(menuvis === true)
    {
        navmenu.style.visibility = 'hidden';
        menuvis = false;
    }
    else if(menuvis === false)
    {
        navmenu.style.visibility = 'visible';
        menuvis = true;
    }
}

function Hidenav()
{
    var navmenu = document.getElementById('navoptions');
    navmenu.style.visibility = 'hidden';
    menuvis = false;
}