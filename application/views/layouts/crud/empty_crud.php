<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php 

foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; 
echo $output;
?>

<?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    <script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<!-- verifico se esiste GET[addto] -->
<script>
    function urlGetParam(src,name) {
        var frame_src = parent.document.getElementById(src).src
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(frame_src);

    return (results !== null) ? results[1] || 0 : false;
}

     
    
    $(document).ready(function(){
  (function( func ) {
    $.fn.addClass = function() { // replace the existing function on $.fn
        func.apply( this, arguments ); // invoke the original function
        this.trigger('classChanged'); // trigger the custom event
        return this; // retain jQuery chainability
    }
})($.fn.addClass); // pass the original function as an argument

(function( func ) {
    $.fn.removeClass = function() {
        func.apply( this, arguments );
        this.trigger('classChanged');

        return this;
    }
})($.fn.removeClass);

$(".delete-selected-button").on('classChanged', function(el){ 
if($(el.currentTarget).hasClass("hidden")){
    
    $(parent.document.getElementById('groceryModalSelectedElement')).html("");
} else {
    var selected = $(".select-row");
    var selectedElements = parent.document.getElementById('groceryModalSelectedElement');
    $(selectedElements).html("");
    $(selectedElements).append("<input type='hidden' id='id_to_append' name='id_to_append' value='"+urlGetParam("grocery_frame","type")+"_"+urlGetParam("grocery_frame","add_to_book")+"'>");
    $(selectedElements).append("<input type='hidden' id='type' name='type' value='"+urlGetParam("grocery_frame","type")+"'>");
    $(selectedElements).append("<input type='hidden' id='book_id' name='book_id' value='"+urlGetParam("grocery_frame","add_to_book")+"'>");
    var labelValue = "";
    for(var i = 0; i<selected.length; i++){
       if(selected[i].checked == true){
        var tag = $(selected[i]).parent().parent().find("td")
       var html = $(selectedElements).html();
       labelValue=labelValue+$(tag[2]).html();
       html = html+"<input type='hidden' name='element_id' label-val='"+$(tag[2]).html()+"' value='"+$(selected[i]).attr("data-id")+"'>";

       $(selectedElements).html(html+$(tag[2]).html());
       }
      
   } 
   $(selectedElements).append("<input type='hidden' id='label_value' name='label_value' value='"+labelValue+"'>");


}

});
    });


</script>
