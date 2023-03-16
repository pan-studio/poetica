<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php 
$isReader = false;
$role = $_SESSION["user_info"]["role"];
if($role == "reader")
$isReader = true;
?>

<div class="container">
    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
                <select id="elastic_combo_book" size="1" class="form-control border-0 small">
                    <?php 
                    $book_mysql_result = $book_mysql_result["book"];
                    ?>
                <?php for($i=0; $i<count($book_mysql_result); $i++) {?>
                    <option value="<?php echo $book_mysql_result[$i]["bid"]; ?>">
                    <?=$book_mysql_result[$i]["title"]." - ".$book_mysql_result[$i]["name"]." ".$book_mysql_result[$i]["surname"]?>
                    </option>
                    <?php } ?>
                </select>
        </div>
       
        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
            <div onclick="getBookById('poetica',document.getElementById('elastic_combo_book').value,'loaded_book',<?=$isReader?>)" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                Aggiungi
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
        <select size="1" class="form-control border-0 small" id="visione"> 
                                     <option>Seleziona visualizzazione</option>
                                     <option value="h">Orizzontale</option> 
                                     <option value="v">Verticale</option> 
         </select>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
            <div onclick="changeLayout(document.getElementById('visione').value,'loaded_book')" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                Cambia
            </div>
        </div>
    </div>
</div>
<div class="container">
   
    <div class="row">
        <div class="loaded_book" id="loaded_book">
        </div>
    </div>
</div>

<script>
var intervalBook = setInterval(function(){
    if(typeof getBookById !== "undefined"){
    <?php
        for($i=0; $i<count($book_mysql_result); $i++) {
        
        echo "getBookById('poetica',".$book_mysql_result[$i]["bid"].",'loaded_book',false);";
       

        }
        echo "changeLayout('h');";
    ?>
 
    clearInterval(intervalBook);
    }
    },500)
        </script>