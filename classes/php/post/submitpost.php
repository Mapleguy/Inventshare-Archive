<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    if(isset($_POST['newpost']))
    {
        session_start();
        $files;
        
        DB::Query('INSERT INTO inventions VALUES(null, :userid, :name, :desc, :summ, :cat, :type, :patent, "")', 
                array(':userid' => $_SESSION['user_id'], ':name' => $_POST['inventionname'], ':desc' => $_POST['inventiondesc'], ':summ' => $_POST['inventionsumm'],
                    ':cat' => $_POST['inventioncat'], ':type' => $_POST['inventiontype'], ':patent' => $_POST['haspatent']));
        $invid = DB::Query('SELECT MAX(inventionid) AS max FROM inventions WHERE inventorid = :userid', array(':userid' => $_SESSION['user_id']))['0']['max'];
        DB::Query('INSERT INTO dailyposts VALUES(:postid, null)', array(':postid' => $invid));
        echo $invid;
    }
?>