<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
    $query = $_GET['query'];
    $user = DB::Query('SELECT user_id, username FROM users WHERE username = :username', array(':username' => $query))['0'];
    $user_json = json_encode($user);
    $inventions = DB::Query('SELECT inventionid, inventionname FROM inventions WHERE inventionname LIKE :quer', array(':quer' => "%".$query."%"));
    $inventions_json = json_encode($inventions);
?>

<script>
    var user;
    var inventions;
    $('document').ready(function()
    {
        user = <?php echo $user_json ?>;
        if(user)
        {
            AddUser(user);
        }
        inventions = <?php echo $inventions_json ?>;
        if(inventions)
        {
            for(var i = 0; i < Object.keys(inventions).length; i++)
            {
                AddInvention(inventions[i]);
            }
        }
    });
    function AddUser(user)
    {
        alert('User: '+user['username']);
    }
    function AddInvention(invention)
    {
        alert('Invention: '+invention['inventionname']);
    }
</script>
<!DOCTYPE html>
<html>
    <head>
        <title>Search on InventShare</title>
    </head>
    <body>
        
    </body>
</html>