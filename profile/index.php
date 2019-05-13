<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
    $getun = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
    if(DB::Query('SELECT username FROM users WHERE username = :username', array(':username' => $getun)))
    {
        $username = DB::Query('SELECT username FROM users WHERE username = :username', array(':username' => $getun))['0']['username'];
        $userid = DB::Query('SELECT user_id FROM users WHERE username = :username', array(':username' => $username))['0']['user_id'];
        $fname = DB::Query('SELECT fname FROM users WHERE username = :username', array(':username' => $getun))['0']['fname'];
        $lname = DB::Query('SELECT lname FROM users WHERE username = :username', array(':username' => $getun))['0']['lname'];
        $summary = DB::Query('SELECT summary FROM profiles WHERE user_id = :user_id', array(':user_id' => $userid))['0']['summary'];
        $location = DB::Query('SELECT location FROM profiles WHERE user_id = :user_id', array(':user_id' => $userid))['0']['location'];
        $avatar = 'https://d2rvrc9f32zpxz.cloudfront.net/users/'.$userid.'/avatar.jpg';
        $banner = 'https://d2rvrc9f32zpxz.cloudfront.net/users/'.$userid.'/banner.jpg';
    }
    else
    {
        header('Location: https://inventshare.co/');
    }
?>
<!DOCTYPE html>
<html>
    <header>
        <title><?php echo $username; ?>'s Profile on InventShare</title>
        <link rel="stylesheet" href="https://inventshare.co/css/act/profile.css">
    </header>
    <body>
        <div class="content">
            <div class="profilehead">
                <div id="userpic">
                    <img id="pavatar" src="<?php echo $avatar; ?>" onerror="DefaultAvatar(this)">
                </div>
                <div id="profilebanner">
                    <img id="pbanner" src="<?php echo $banner; ?>" onerror="DefaultBanner(this)">
                </div>
                <?php
                    if($userid === ActLog::IsLogged())
                    {
                        include($_SERVER['DOCUMENT_ROOT'].'/classes/php/act/profileedit.php');
                    }
                ?>
            </div>
            <div class="info">
                <div id="username">
                    <text id="pinfotext"><?php echo $username; ?></text>
                </div>
                <div id="realname">
                    <text id="pinfotext"><?php echo $fname.' '.$lname; ?></text>
                </div>
                <div id="summary">
                    <text id="pinfosummary"><?php echo $summary; ?></text>
                </div>
                <div id="location">
                    <text id="pinfotext"><?php echo $location; ?></text>
                </div>
            </div>
            <div class="feed">
                
            </div>
        </div>
    </body>
</html>