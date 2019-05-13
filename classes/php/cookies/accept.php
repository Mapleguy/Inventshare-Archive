<?php
    if(isset($_POST['accept']))
    {
        setcookie('cookies', 'donedidit', time() + 60 * 60 * 24 * 61, '/', null, true, true);
    }
?>