<?php
    if(isset($_POST['getuid']))
    {
        session_start();
        echo $_SESSION['user_id'];
    }
?>