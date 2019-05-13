<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    if(isset($_POST['submitedit']))
    {
        DB::Query('UPDATE inventions SET inventionsumm = :summ WHERE inventionid = :invid', array(':summ' => $_POST['summ'], ':invid' => $_POST['invid']));
        DB::Query('UPDATE inventions SET inventionname = :summ WHERE inventionid = :invid', array(':summ' => $_POST['name'], ':invid' => $_POST['invid']));
        DB::Query('UPDATE inventions SET inventiondesc = :summ WHERE inventionid = :invid', array(':summ' => $_POST['desc'], ':invid' => $_POST['invid']));
        DB::Query('UPDATE inventions SET inventioncategory = :summ WHERE inventionid = :invid', array(':summ' => $_POST['cat'], ':invid' => $_POST['invid']));
        DB::Query('UPDATE inventions SET inventiontype = :summ WHERE inventionid = :invid', array(':summ' => $_POST['type'], ':invid' => $_POST['invid']));
    }
?>