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
        if(isset($_POST['allcheck'])){
            $deleteall->execute();
            header("Location:userpage.php");
        }else{
            //Here goes the code for individual deletion
            foreach($_POST['check'] as $selected){
                $id = $selected;
                $delete->execute();
                header("Location:userpage.php");
            }
        }
    }else if(isset($_POST['print'])){
        if(isset($_POST['check']) || isset($_POST['allcheck'])){
                ?>
                <form action="print.php" method="post">
                <div class="container">
                    Tamaño de etiqueta
                    <div class="form-check">
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="Radios" id="5x5" value="option1" checked>
                    <label class="form-check-label" for="5x5">
                        5x5
                    </label>
                    </div>
                    <div class="form-check">
                    <input class="form-check-input" type="radio" name="Radios" id="3x3" value="option2">
                    <label class="form-check-label" for="3x3">
                        3x3
                    </label>
                    </div>
                    ¿Desea incluir fecha?
                    <input type="checkbox" name="date">
                    <input type="submit" name="print" class="btn btn-success btn-block" value="Imprimir">
                    <input type="submit" name="cancel" class="btn btn-success btn-block" value="Cancelar">
                </div>
            </form>
            <?php
            //Here, we save the "check" values for further use
            if(isset($_POST['check'])){
                $_SESSION['check'] = $_POST['check'];
            }else if(isset($_POST['allcheck'])){
                $_SESSION['checkall'] = true;
            }
        }else{
            //message to session, nothing to print
            header("Location:userpage.php");
        }
        
        
    }
    include("includes/footer.php");
?>