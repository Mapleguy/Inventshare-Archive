<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/testing/classes/php/db.php');
    echo DB::Query('SELECT inventionid FROM inventions ORDER BY inventionid DESC LIMIT 1', array())['0']['inventionid'];
?>