<?php
    //require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
    $postcount = DB::Query('SELECT COUNT(*) AS count FROM inventions', array())['0']['count'];
    $usercount = DB::Query('SELECT COUNT(*) AS count FROM users', array())['0']['count'];
    $dailycount = DB::Query('SELECT COUNT(*) AS count FROM dailyposts', array())['0']['count'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>InventShare Home</title>
        <link rel="stylesheet" href="css/post/postprev.css">
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>
        <div class="content">
            <div class="welcome">
                <div id="topline"></div>
                <div id="usercount">
                    <text>Inventors Registered:</text></br>
                    <text><?php echo $usercount; ?></text>
                </div>
                <div id="sep1"></div>
                <div id="postcount">
                    <text>Inventions Submitted:</text></br>
                    <text><?php echo $postcount; ?></text>
                </div>
                <div id="sep2"></div>
                <div id="posttoday">
                    <text>Today's Inventions:</text></br>
                    <text><?php echo $dailycount; ?></text>
                </div>
                <div id="bottomline"></div>
            </div>
            <div class="indexcat">
                <text id="title">Featured</text></br>
                <?php $_GET['i'] = 1;?>
                <?php $feat1 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
                <?php $feat2 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
                <?php $feat3 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
            </div>
            <div class="indexcat">
                <text id="title">Newest</text></br>

                <?php $top1 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
                <?php $top2 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
                <?php $top3 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
            </div>
            <div class="indexcat">
                <text id="title">Random</text></br>
                <?php $rand1 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
                <?php $rand2 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
                <?php $rand3 = include($_SERVER['DOCUMENT_ROOT'].'/post/postpreview.php');?>
            </div>
        </div>
        <div class="leftline"></div>
        <div class="rightline"></div>
    </body>
</html>