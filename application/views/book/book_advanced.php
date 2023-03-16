<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php 
$isReader = false;
$role = $_SESSION["user_info"]["role"];
if($role == "reader")
$isReader = true;
 $book_mysql_result = $book_mysql_result["book"];

?>

<script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
<link href="<?php echo base_url()?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

<div class="container">
   
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
        <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
            <a href="#collapseCardBook" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardBook">
                    <h6 class="m-0 font-weight-bold text-primary">Traduzioni (<?= count($book_mysql_result) ?>)</h6>
            </a>
                                <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardBook" style="">
            <div class="card-body">
            <?php echo form_open('/books/find_advanced_books', 'method="post" id="search_advanced_form"'); ?> 

            <table class="table table-bordered" id="dataTableBooks" width="100%" cellspacing="0">
                                 <thead>
                                        <tr>
                                            <th>Titolo</th>
                                            <th>Anno</th>
                                            <th>Traduttore</th>
                                            <th>Aggiungi alla ricerca</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Titolo</th>
                                            <th>Anno</th>
                                            <th>Traduttore</th>
                                            <th>Aggiungi alla ricerca</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                <?php foreach($book_mysql_result as $book) { 
                    
                    
                                    echo "<tr><td>".$book["title"]."</td>";
                                     echo "<td>".$book["year"]."</td>";
                        echo "<td> <div onClick='showModal(\"AUTHOR\", \"Scheda traduttore\", \"".$book['author_id']."\")' class='btn btn-primary'>".$book['name']." ".$book['surname']."</div></td>";
                        echo "<td><input style='    display: inline-flex;
                        margin: auto;
                        width: 15px;
                        height: 15px;'
                        type='checkbox' class='form form-control' id='".$book["bid"]."' name='bookIds[]' value='".$book['bid']."'></td></tr>";
                       } ?>
                   </tbody>
                                    </table>
                    <input type="submit" class="btn btn-primary" value="Mostra traduzioni selezionate">
                    <?php echo form_close();?>
                        
                   </div>
            </div>
        </div>
        </div>


        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
        <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
            <a href="#collapseCardTag" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardTag">
                    <h6 class="m-0 font-weight-bold text-primary">Tags (<?= count($tags_mysql_result) ?>)</h6>
            </a>
                                <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardTag" style="">
            <div class="card-body">
            <table class="table table-bordered" id="dataTableTags" width="100%" cellspacing="0">
                                 <thead>
                                        <tr>
                                            <th>TAG</th>
                                            <th>Descrizione</th>
                                            <th>Mostra Scheda</th>
                                         </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>TAG</th>
                                            <th>Descrizione</th>
                                            <th>Mostra Scheda</th>
                                         </tr>
                                    </tfoot>
                                    <tbody>
                <?php foreach($tags_mysql_result as $tag) { ?>
                    
                    <?php echo "<tr><td>". $tag["tag"]."</td>";
                        echo "<td>".$tag["description"]."</td>";
                        echo "<td><button onClick='showModal(\"TAG\", \"".$tag["tag"]."\", \"".$tag['id']."\")' class='btn btn-primary'>Mostra Tag</button></td></tr>";
                         } ?>
                   </tbody>
                                    </table>
                   </div>
            </div>
        </div>
        </div>

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" >
        <div class="card shadow mb-4">
                                <!-- Card Header - Accordion -->
            <a href="#collapseCardBiblio" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapseCardBiblio">
                    <h6 class="m-0 font-weight-bold text-primary">Bibliografia (<?= count($biblio_mysql_result) ?>)</h6>
            </a>
                                <!-- Card Content - Collapse -->
            <div class="collapse" id="collapseCardBiblio" style="">
            <div class="card-body">
            <table class="table table-bordered" id="dataTableTags" width="100%" cellspacing="0">
                                 <thead>
                                        <tr>
                                            <th>TAG</th>
                                            <th>Descrizione</th>
                                            <th>Mostra Scheda</th>
                                         </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>TAG</th>
                                            <th>Descrizione</th>
                                            <th>Mostra Scheda</th>
                                         </tr>
                                    </tfoot>
                                    <tbody>
                <?php foreach($biblio_mysql_result as $biblio) { ?>
                    <?php echo "<tr><td> ". $biblio["title"]."</td>";
                        echo "<td>".$biblio["description"]."</td>";
                        echo "<td><button onClick='showModal(\"BIBLIO\", \"".$biblio["title"]."\", \"".$biblio['id']."\")' class='btn btn-primary'>Mostra Bibliografia</button></td></tr>";
                         } ?>
                   </tbody>
                                    </table>
                   </div>
            </div>
        </div>
        </div>
    </div>
</div>

<div  class="modal fade" id="groceryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div  style="max-width:80%;" class="modal-dialog" role="document">
            <div   class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="groceryModalTitle"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div style="height:70vh;" id="groceryModalBody" class="modal-body">
                    
                
                 </div>
                <div style="display:none;" id="groceryModalSelectedElement">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" onclick="saveGroceryData()" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showModal(type, title, id){
            $("#groceryModalTitle").html(title);
            if(type == 'TAG'){
               
                $("#groceryModalBody").html('<iframe id="grocery_frame" src="http://212.224.88.77/poetica/index.php/cruds/load_tags_list/read/'+id+'"  width="100%" height="100%" frameborder="0"></iframe>');
            }
            if(type == 'BIBLIO'){
               
               $("#groceryModalBody").html('<iframe id="grocery_frame" src="http://212.224.88.77/poetica/index.php/cruds/load_biblio_list/read/'+id+'"  width="100%" height="100%" frameborder="0"></iframe>');
           }
           if(type == 'AUTHOR'){
               
               $("#groceryModalBody").html('<iframe id="grocery_frame" src="http://212.224.88.77/poetica/index.php/cruds/load_author_list/read/'+id+'"  width="100%" height="100%" frameborder="0"></iframe>');
           }
            $("#groceryModal").modal("toggle");

        }
    </script>
     
    
    <script>

$(document).ready(function() {
   
  $('#dataTableBooks').DataTable();
  $('#dataTableTags').DataTable();
}
);
</script>