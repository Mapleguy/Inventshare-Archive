<?php
    $num = $_GET['i'];
    $invname = DB::Query('SELECT inventionname FROM inventions WHERE inventionid = :invid', array(':invid' => $num))['0']['inventionname'];
    $invdesc = DB::Query('SELECT inventiondesc FROM inventions WHERE inventionid = :invid', array(':invid' => $num))['0']['inventiondesc'];
    $invcat = DB::Query('SELECT inventioncategory FROM inventions WHERE inventionid = :invid', array(':invid' => $num))['0']['inventioncategory'];
    $invtype = DB::Query('SELECT inventiontype FROM inventions WHERE inventionid = :invid', array(':invid' => $num))['0']['inventiontype'];
    $inventorid = DB::Query('SELECT inventorid FROM inventions WHERE inventionid = :invid', array(':invid' => $num))['0']['inventorid'];
    $hlimg = DB::Query('SELECT highlightimg FROM inventions WHERE inventionid = :invid', array(':invid' => $num))['0']['highlightimg'];
    $invlink = "https://inventshare.co/invention?i=".$num; 
    
    switch($invcat)
    {
        case 1:
            $invcat = 'Aeronautics';
            break;
        case 2:
            $invcat = 'Astronautics';
            break;
        case 3:
            $invcat = 'Automation';
            break;
        case 4:
            $invcat = 'Business';
            break;
        case 5:
            $invcat = 'Computing';
            break;
        case 6:
            $invcat = 'Economics';
            break;
        case 7:
            $invcat = 'Electronics';
            break;
        case 8:
            $invcat = 'Energy';
            break;
        case 9:
            $invcat = 'Industry';
            break;
        case 10:
            $invcat = 'Mathematics';
            break;
        case 11:
            $invcat = 'Medicine';
            break;
        case 12:
            $invcat = 'Recreation';
            break;
        case 13:
            $invcat = 'Robotics';
            break;
        case 14:
            $invcat = 'Science';
            break;
        case 15:
            $invcat = 'Transportation';
            break;
        case 16:
            $invcat = 'Other';
            break;
        case 'null':
            $invcat = 'ERROR';
            break;
        default:
            $invcat = 'ERROR';
            break;
    }
    
    switch($invtype)
    {
        case 1:
            $invtype = 'Code';
            break;
        case 2:
            $invtype = 'Concept';
            break;
        case 3:
            $invtype = 'Design';
            break;
        case 4:
            $invtype = 'Electrical';
            break;
        case 5:
            $invtype = 'Mechanical';
            break;
        case 6:
            $invtype = 'Process';
            break;
        case 7:
            $invtype = 'Theory';
            break;
        case 8:
            $invtype = 'Tool';
            break;
        case 9:
            $invtype = 'Other';
            break;
        case 'null':
            $invtype = 'BROKEN';
            break;
        default:
            $invtype = 'BROKEN';
            break;
    }
?>

<!DOCTYPE html>
<html>
    <body>
        <div class="postprev" name="<?php echo $num; ?>" onclick='Redirect("<?php echo $invlink; ?>")'>
            <img id="previmg" src="<?php echo $hlimg; ?>" alt=""></br>
            <div id="namebox">
                <text id="invname"> <?php echo $invname; ?></text>
            </div>
            <div id="descbox">
                <text id="desc"><?php echo $invdesc; ?></text>
            </div>
            <div id="cattype">
                <text id="cat"><?php echo $invcat; ?>, </text>
                <text id="type"><?php echo $invtype; ?></text>
            </div>
            <div id="divider"></div>
        </div>
    </body>
</html>