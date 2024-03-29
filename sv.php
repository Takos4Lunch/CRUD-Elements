<?php
    include('cnct.php');
    
    //Prepared statement gotta test later
    $sve = $connection->prepare("INSERT INTO user(Nm, K) VALUES(?,?)");
    $sve->bind_param("ss",$sj,$ac);
    $elementsv = $connection->prepare("INSERT INTO elementos(Nombre,Densidad,UserID) VALUES(?,?,?)");
    $elementsv->bind_param("sdi",$nm,$density,$userid);
    //Execute
    if(isset($_POST['Register'])){
        $sj = $_POST['Username'];
        $unpac = $_POST['Password'];
        $dup = mysqli_query($connection,"SELECT Nm FROM user WHERE Nm = '$sj'");

        if(mysqli_num_rows($dup)>0){
            //message to session
        }else if(preg_match('/\s/',$unpac)==FALSE && preg_match('/\s/',$sj)==FALSE){
            $ac = password_hash($unpac,PASSWORD_DEFAULT);
            $sve->execute();
            if(!$sve){
                echo "Failed";
            }
        }else{
            //message to session here
            //Re-think this code
        }
        
        header("Location:index.php");
    }

    if(isset($_POST['Save'])){
        //here, we save the element to the server using the user's ID
        if(empty($_POST['element_name']) || empty($_POST['density']))
        {
            //message to session, nothing to save
            header("Location:userpage.php");
        }else if(isset($_POST['element_name']) && isset($_POST['density'])){
            $nm = $_POST['element_name'];
            $density = $_POST['density'];
            $userid = $_SESSION['user_id'];
            $elementsv->execute();
            
            if(!$elementsv){
            echo "Failed";
            }
            header("Location:userpage.php");
        }
        
    }else if(isset($_POST['Return'])){
        header("Location:userpage.php");
    }

    //Here we could add another if statement for the Element
?>