<?php

session_start();

if(isset($_POST['submit']))
{
    include 'db.inc.php';

    // $uid = mysqli_real_escape_string($connection, $_POST['uid']);
    // $name = mysqli_real_escape_string($connection, $_POST['name']);
    // $pswd = mysqli_real_escape_string($connection, $_POST['pswd']);

    $name = $_POST['name'];
    $pswd = $_POST['pswd'];

    if(empty($name) || empty($pswd))
    {
        header("Location: ../index.php?login=empty");
        exit();
    }
    else
    {
        //setup query
        $nameCheck = "SELECT * FROM User WHERE name='$name'";

        //perform query
        $result = mysqli_query($connection,$nameCheck);
        $resultCheck = mysqli_num_rows($result);

        //if no such user found from in the db
        if($resultCheck < 1)
        {
            header("Location: ../index.php?login=error");
            exit();
        }
        else
        {
            if($row = mysqli_fetch_assoc($result))
            {
                /*
                $pswdCheck =  "SELECT * FROM user WHERE name='$name' AND '$row[pswd]'='$pswd'";

                
                $result = mysqli_query($connection, $pswdCheck);
                $resultCheck = mysqli_num_rows($result);
                
                if($resultCheck != 1)
                {
                    header("Location: ../index.php?login=error");
                    exit();
                }
                elseif($resultCheck == 1)
                {
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_pswd'] = $row['pswd'];
                    header("Location: ../index.php?login=success");
                    exit();
                }
                */

                //if you are not okay with this hashed function 
                //then comment the whole code below and uncomment the above 
                
                // /*
                $hashPswd = password_verify($pswd,$row['pswd']);
                if($hashPswd == false)
                {
                    header("Location: ../index.php?login=error");
                    exit();
                }
                elseif($hashPswd == true)
                {
                    $_SESSION['user_name'] = $row['name'];
                    $_SESSION['user_pswd'] = $row['pswd'];
                    header("Location: ../index.php?login=success");
                    exit();
                }
                // */ 
            }
        }
    }
}
else
{
    header("Location: ../index.php?login=error");
    exit();
}