var currentLayoutView = 'v';
const FRAMMENTI = ['1447a', '1447b', '1448a', '1448b', '1449a', '1449b', '1450a', '1450b', '1451a', '1451b', '1452a', '1452b', '1453a', '1453b', '1454a', '1454b', '1455a', '1455b', '1456a', '1456b', '1457a', '1457b', '1458a', '1458b', '1459a', '1459b', '1460a', '1460b', '1461a', '1461b', '1462a', '1462b'];
function changeLayout(type='v', id='loaded_book'){

    if(type == 'v'){
         $("#"+id).attr("style", " width:100%; overflow-y: auto; display: block;")
         currentLayoutView = 'v';
    } else {
        $("#"+id).attr("style", " width:100%; overflow-x: auto; display: flex;")
        currentLayoutView = 'h';

    }
   setTimeout(function(){

    adjustFrammentiHeight();
    addResizibleObserver();
      
   },1000);

}

function addResizibleObserver(){
    let resizeObserver = new ResizeObserver(() => {
        adjustFrammentiHeight();
    });
    for(let i = 0; i<FRAMMENTI.length; i++){
        let frammentiRendered = $('.'+FRAMMENTI[i]);
        for(let j = 0; j<frammentiRendered.length; j++){
        elem = $(frammentiRendered)[j];
        resizeObserver.observe(elem);
        }
    }
}

function adjustFrammentiHeight(){
    
   

    for(let i = 0; i<FRAMMENTI.length; i++){
       

        let frammentiRendered = $('.'+FRAMMENTI[i]);
        let currentHeight = 0;
        for(let j = 0; j<frammentiRendered.length; j++){
            if($(frammentiRendered[j]).height() > currentHeight){
                $(frammentiRendered[j]).height("auto");
                currentHeight = $(frammentiRendered[j]).height();
                console.log(currentHeight);
                
            } 
        }
        for(let j = 0; j<frammentiRendered.length; j++){
            
            $(frammentiRendered[j]).height(currentHeight);
           
        }
       }
}
function printBook(id){
    var printContents = document.getElementById(id);
    var originalContents = document.body.innerHTML;
    $(printContents).find(".col-md-1").remove();
    $(printContents).find(".container_book").remove();
    
    

     document.body.innerHTML = printContents.innerHTML;

     window.print();

     document.body.innerHTML = originalContents;
}

function printPar(index, className){
    var printContents = document.getElementById("key_"+index+"_"+className).innerHTML+"<br>"+document.getElementById("value_"+index+"_"+className).innerHTML;
    var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

function hideOrShowPar(index, className){
    
    if( $("#key_"+index+"_"+className).hasClass("hide")){
        $("#key_"+index+"_"+className).removeClass("hide");
        $("#eye_"+index+"_"+className).removeClass("fa-eye-slash");
        $("#eye_"+index+"_"+className).addClass("fa-eye");
        $("."+className).show();
        $(".partoolbar").show();
    }
    else {
        $("."+className).hide();
    $("#key_"+index+"_"+className).show();
    $("#eye_"+index+"_"+className).removeClass("fa-eye");
    $("#eye_"+index+"_"+className).addClass("fa-eye-slash");
    $("#key_"+index+"_"+className).addClass("hide");
    $("#value_"+index+"_"+className).show();
    $(".partoolbar").hide();
    $("#partoolbar_"+index+"_"+className).show();
    }
}


function showSearchField(filter, selectorToHide){
    
    let searchFieldValue = filter.value;
    $("."+selectorToHide).hide();
    let elementToShow = searchFieldValue.split(",");
    for(var iel=0; iel<elementToShow.length; iel++){
        $("#"+elementToShow[iel]).show();
    }
}

function addToFilter(filter='searchfor', filterBar='filter_bar', form='searchform'){

   let randomId= makeid(10);
    let label_value = $('option:selected', "#"+filter).attr('label_value');
    let language = $("#language").val();
    let language_label = $('option:selected', "#language").attr('label_value');
    let filter_value = $("#"+filter).val();
    if(language == -1 && (filter_value == -1 || filter_value.replace(/\s/g,"") == "")){
        alert("selezionare o inserire dei filtri");
        return;
    }
    let filter_value_array = filter_value.split(",");
    let keyword_filter_value_array = [];
    for(var iel=0; iel<filter_value_array.length; iel++){
        
        keyword_filter_value_array[iel] = $("#"+filter_value_array[iel]).val();
        if(language == -1 && (keyword_filter_value_array[iel] == -1 || 
            keyword_filter_value_array[iel].replace(/\s/g,"") == "")){
                alert("compilare i campi");
                return;
            }
        
    }

    let element = "<div class='filter' id='"+randomId+"'><input type='hidden' name='randomId[]' value='"+randomId+"'>";
    if(filter_value_array.length == 2 && keyword_filter_value_array[0] && keyword_filter_value_array[1]){
        
        element = element+label_value+" "+keyword_filter_value_array[0]+"-"+keyword_filter_value_array[1]
    } else if(filter_value_array.length == 1 && keyword_filter_value_array[0] ){
        
        element = element+label_value+" "+keyword_filter_value_array[0]
    }
    

    switch (filter_value){
        case 'free_keyword_author':
            if(keyword_filter_value_array[0]){
            element = element+"<input type='hidden' name='author_"+randomId+"' value='"+keyword_filter_value_array[0]+"'>"
            element = element+'<select size="1" name="operator_'+randomId+'"><option value="AND">AND</option><option value="OR">OR</option></select></div>';

    
        }
            break;
        case 'year_from,year_to':
            if(keyword_filter_value_array[0] && keyword_filter_value_array[1]){
            element = element+"<input type='hidden' name='year_from_"+randomId+"' value='"+keyword_filter_value_array[0]+"'>"
            element = element+"<input type='hidden' name='year_to_"+randomId+"' value='"+keyword_filter_value_array[1]+"'>"
            element = element+'<select size="1" name="operator_'+randomId+'"><option value="AND">AND</option><option value="OR">OR</option></select></div>';


            }
            break;
        case 'century_from,century_to':
            if(keyword_filter_value_array[0] && keyword_filter_value_array[1]){

            element = element+"<input type='hidden' name='century_from_"+randomId+"' value='"+keyword_filter_value_array[0]+"'>"
            element = element+"<input type='hidden' name='century_to_"+randomId+"' value='"+keyword_filter_value_array[1]+"'>"
            element = element+'<select size="1" name="operator_'+randomId+'"><option value="AND">AND</option><option value="OR">OR</option></select></div>';


            }
            break;
        case 'free_keyword_text':
            if(keyword_filter_value_array[0]){

            element = element+"<input type='hidden' name='word_"+randomId+"' value='"+keyword_filter_value_array[0]+"'>"
            element = element+'<select size="1" name="operator_'+randomId+'"><option value="AND">AND</option><option value="OR">OR</option></select></div>';

            }
            break;
        case 'free_keyword_annotation':
            if(keyword_filter_value_array[0]){

            element = element+"<input type='hidden' name='annotation_"+randomId+"' value='"+keyword_filter_value_array[0]+"'>"
            element = element+'<select size="1" name="operator_'+randomId+'"><option value="AND">AND</option><option value="OR">OR</option></select></div>';

            }
            break;
            
        
    }
    if(language != -1){
        element = element+'Lingua: '+language_label;
        element = element+'<div id="language_'+randomId+'"><select size="1" name="operator_language_'+randomId+'"><option value="AND">AND</option><option value="OR">OR</option></select>';

        element = element+"<input type='hidden' name='language_"+randomId+"' value='"+language+"'></div>"
    }
    element = element+'<i onClick="removeFilter(\''+randomId+'\')" class="fa fa-window-close"></i></div>';

    $("#language").val(-1);
    $("#language").trigger('change');

    $("#"+filter).val(-1);
    $("#"+filter).trigger('change');

    $("#"+form).append(element);

}

function removeFilter(id){
    document.getElementById(id).remove();
}


function CreatePDFfromHTML(className) {
    var HTML_Width = $("."+className).width();
    var HTML_Height = $("."+className).height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($("."+className)[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) { 
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save("Your_PDF_Name.pdf");
        
    });
}

function blockBook(index, id){
    var parId = "value_"+index+"_"+id;
    if($("#"+parId).hasClass("blockedBook")){
        $("#"+parId).removeClass("blockedBook");
    } else {
        $("#"+parId).addClass("blockedBook");
    }
}
function closeBook(id){
    document.getElementById(id).remove();
}


function printSelectedText(obj){

    var winPrint = window.open('', '', 'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');
winPrint.document.write('<title>Stampa paragrafo</title><br /><br />  '+document.getSelection());
winPrint.document.close();
winPrint.focus();
winPrint.print();
winPrint.close(); 

}

function urlGetParam(name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)')
                      .exec(window.location.search);

    return (results !== null) ? results[1] || 0 : false;
}

// for IE8
if (!String.prototype.trim)
{
    String.prototype.trim = function ()
    {
        // return this.replace(/^\s+|\s+$/g, '');
        return this.replace(/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g, '');
    };
}

if (!String.prototype.trimStart)
{
    String.prototype.trimStart = function ()
    {
        // return this.replace(/^\s+/g, '');
        return this.replace(/^[\s\uFEFF\xA0]+/g, '');
    };
}

if (!String.prototype.trimEnd)
{
    String.prototype.trimEnd = function ()
    {
        // return this.replace(/\s+$/g, '');
return this.replace(/\s*$/,"");
};
}


function findTextInElementByClassName(className, text){
    var els = document.getElementsByClassName(className);
    
    text = text.toLowerCase();
    var startingIndices = [];

for(var i = 0; i<els.length; i++){
    let str = $(els[i]).text().toLowerCase();
    var indexOccurence = str.indexOf(text, 0);
while(indexOccurence >= 0) {
    
    startingIndices.push({pDiv:"/p["+(i+1)+"]",start:indexOccurence, end:(indexOccurence+(text.length))});
    indexOccurence = str.indexOf(text, indexOccurence + 1);
}
}
  return startingIndices;
}
function getOffset( el ) {
    var _x = 0;
    var _y = 0;
    while( el && !isNaN( el.offsetLeft ) && !isNaN( el.offsetTop ) ) {
          _x += el.offsetLeft - el.scrollLeft;
          _y += el.offsetTop - el.scrollTop;
          el = el.offsetParent;
    }
    return { top: _y, left: _x };
    }
var x = getOffset( document.getElementById('div') ).left;
var y = getOffset( document.getElementById('div') ).top;
console.log("x: "+ x);
console.log("y: "+ y);