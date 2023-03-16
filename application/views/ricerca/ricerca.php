<script>
var counterForm = 1;
</script>

<div class="container">

<?php echo form_open(base_url().'index.php/books/advanced_search', 'method="post" id="advnced_searchform"'); ?> 
                
<?php
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$randomId = generateRandomString(10);
?>
    <div id="advancedSearchBar">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
                <select onChange="changeBox('<?=$randomId?>', this)" name="cerca_per[]" class="form-control border-0 small search_book_field ">
                    <option value="traduttore">traduttore</option>
                    <option value="data">Data</option>
                    <option value="secolo">Secolo</option>
                    <option value="testo_nella_traduzione">Testo nella traduzione</option>
                    <option value="annotazione">Annotazione</option>
                    <option value="lingua">Lingua</option>
                    <option value="tag">Tag</option>
                </select>
            </div>
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
            <input  name="keyword[]" id="<?=$randomId?>" type="text" class="form-control bg-light border-0 small"
                                            placeholder="Keyword" aria-label="Search"
                                            aria-describedby="basic-addon2">
            </div>
            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
                <select  name="tipologia[]" class="form-control border-0 small search_book_field ">
                    <option value="contiene">Contiene</option>
                    <option value="frase_esatta">Frase Esatta</option>
                </select>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3">
                <select   name="andor[]" class="form-control border-0 small search_book_field ">
                    <option value="and">AND</option>
                    <option value="or">OR</option>
                </select>
            </div>
            <div class="col-md-1 col-lg-1 col-sm-3 col-xs-3">
            <div class="input-group-append">
                                            <button onclick='addNew()' class="btn btn-primary" type="button">
                                                <i class="fas fa-plus fa-sm"></i>
                                            </button>
                                        </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 col-sm-6 col-lg-3 col-md-3">
    <button onclick='search()' class="btn btn-primary" type="button">
        Cerca

    </button>
    </div>
</div>
<?php echo form_close();?>
</div>

<script>

function search(){

   /* var searchFor = document.getElementsByName('cerca_per');
    var keyword = document.getElementsByName('keyword');
    var tipologia = document.getElementsByName('tipologia');
    var andor = document.getElementsByName('andor');
    */
   document.getElementById('advnced_searchform').submit();


}
    function addNew(){
        let r = (Math.random() + 1).toString(36).substring(7);
        let randomId = '<?=generateRandomString(10)?>'
        let result='<div id="'+r+'" class="row">            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">                <select  onChange="changeBox(\''+randomId+'\',this)" name="cerca_per[]" class="form-control border-0 small search_book_field ">                                   <option value="traduttore">traduttore</option>                    <option value="data">Data</option>                    <option value="secolo">Secolo</option>                    <option value="testo_nella_traduzione">Testo nella traduzione</option>                    <option value="annotazione">Annotazione</option>                                 <option value="lingua">Lingua</option>             <option value="tag">Tag</option>                                 </select>            </div>            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">            <input  name="keyword[]" id="'+randomId+'" type="text" class="form-control bg-light border-0 small"                                            placeholder="Keyword" aria-label="Search"                                            aria-describedby="basic-addon2">            </div>            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">                <select  name="tipologia[]" class="form-control border-0 small search_book_field ">                                   <option value="contiene">Contiene</option>  <option value="frase_esatta">Frase Esatta</option>                                  </select>            </div>            <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3">                <select   name="andor[]" class="form-control border-0 small search_book_field ">                                     <option value="and">AND</option>                    <option value="or">OR</option>                </select>            </div>            <div class="col-md-1 col-lg-1 col-sm-3 col-xs-3">            <div class="input-group-append">                                            <button onclick="remove(\''+r+'\')" class="btn btn-primary" type="button">                                                <i class="fas fa-minus fa-sm"></i>                                            </button>                                        </div>            </div>        </div>';
        $("#advancedSearchBar").append(result);
    }

    function remove(id){
        $("#"+id).remove();
    }
    function changeBox(id,obj){
        let optionLang = "";
        let secoloBox = "";
        <?php 

        for($i=21; $i>=16; $i--){
            ?>
            secoloBox = secoloBox+'<option value="<?=$i?>"><?=$i?> Secolo</option>';

       <?php  }
        foreach ($languages->result() as $row)
        {
                ?>
            optionLang = optionLang+'<option value="<?=$row->id?>"><?=$row->language?></option>'
                <?php
        }
        ?>
        if(obj.value == 'lingua'){
            $("#"+id)
    .replaceWith('<select class="form form-control" name="keyword[]" id="'+id+'"' +
        optionLang+
        '</select>');
        }
        else if(obj.value == 'secolo'){
            $("#"+id)
            .replaceWith('<select class="form form-control" name="keyword[]" id="'+id+'"' +
            secoloBox+
        '</select>');
        
        } else {
            $("#"+id)
    .replaceWith('<input  name="keyword[]" id="'+id+'" type="text" class="form-control bg-light border-0 small"                                            placeholder="Keyword" aria-label="Search"                                            aria-describedby="basic-addon2">  ');
        }
        


    }
</script>