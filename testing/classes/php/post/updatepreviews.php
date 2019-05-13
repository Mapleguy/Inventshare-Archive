<?php
    session_start();
    
    $uid = $_SESSION['user_id'];
    $count = count($_FILES);
    
    if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/'))
    {
        if(mkdir($_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/', 0777, true))
        {
            if(mkdir($_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/tmp/', 0777, true))
            {
                echo $count.',';
                for($i = 0; $i < $count; $i++)
                {
                    move_uploaded_file($_FILES['file'.$i]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/tmp/'.$_FILES['file'.$i]["name"]);
                    echo $_FILES['file'.$i]["name"].',';
                }
            }
            else
            {
                echo 'Failed to make tmp dir!';
            }
        }
        else
        {
           echo 'Failed to make user dir!'; 
        }
    }
    else if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/tmp/'))
    {
        if(mkdir($_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/tmp/', 0777, true))
        {
            echo $count.',';
            for($i = 0; $i < $count; $i++)
            {
                move_uploaded_file($_FILES['file'.$i]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/tmp/'.$_FILES['file'.$i]["name"]);
                echo $_FILES['file'.$i]["name"].','; 
            }
        }
        else
        {
            echo 'Failed to make tmp dir 2!';
        }
    }
    else
    {
        echo $count.',';
        for($i = 0; $i < $count; $i++)
        {
            move_uploaded_file($_FILES['file'.$i]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].'/img/invention/'.$uid.'/tmp/'.$_FILES['file'.$i]["name"]);
            echo $_FILES['file'.$i]["name"].','; 
        }
    }
?>