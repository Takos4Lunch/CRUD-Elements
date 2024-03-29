<?php
    include("cnct.php");
    include("includes/header.php");
    $rows = $_SESSION['numrows'];
    $x = 0;
    $delete = $connection->prepare("DELETE FROM elementos WHERE ID=?");
    $delete->bind_param("i",$id);

    $deleteall = $connection->prepare("DELETE FROM elementos WHERE UserID=?");
    $deleteall->bind_param("i",$usid);

    $usid = $_SESSION['user_id'];

    if(isset($_POST['delete'])){
        if(isset($_POST['allcheck']) && isset($_POST['check'])){
            //message to session, you can't check both
            header("Location:userpage.php");
        }else if(isset($_POST['allcheck']) && !isset($_POST['check'])){
            $deleteall->execute();
            header("Location:userpage.php");
        }else if(isset($_POST['check']) && !isset($_POST['allcheck'])){
            //Here goes the code for individual deletion
            foreach($_POST['check'] as $selected){
                $id = $selected;
                $delete->execute();
                header("Location:userpage.php");
            }
        }else{
            //Message to session, nothing selected
            header("Location:userpage.php");
        }
    }else if(isset($_POST['print'])){
        if(isset($_POST['check']) && isset($_POST['allcheck'])){
            //message to session, you can't do both
            header("Location:userpage.php");
        }else if(isset($_POST['check']) || isset($_POST['allcheck'])){
                ?>
                
                <div class="container-fluid text-center">

                    <div class="row">
                        <div class="offset-md-5 row-md-4">
                            <form action="print.php" method="post">
                                <br>
                                Tamaño de etiqueta
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="Radios" value="5" checked>
                                    5x5 <br>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="Radios" value="3">
                                    3x3 <br>
                                </div>
                                ¿Desea incluir fecha?   <input type="checkbox" name="date">

                                <div class="form-group">
                                    <input type="submit" name="print" class="btn btn-success btn-block" value="Imprimir">
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="cancel" class="btn btn-success btn-block" value="Cancelar">
                                </div>
                            </form>    
                        </div>
                    </div>
 
                </div>
           
            <?php
            //Here, we save the "check" values for further use
            if(isset($_POST['check'])){
                $_SESSION['check'] = $_POST['check'];
            }else if(isset($_POST['allcheck'])){
                $_SESSION['checkall'] = true;
            }else if(isset($_POST['allcheck']) && isset($_POST['check'])){
                //message to session, you can't select both
                header("Location:userpage.php");
            }
        }else{
            //Message to session, none selected
            header("Location:userpage.php");
        }
        
        
    }
    include("includes/footer.php");
?>