const client = new elasticsearch.Client({ node: 'http://212.224.88.77:9200' })


async function getBookById(index='poetica', docId, appendTo='loaded_book', isReader=false){

if(document.getElementById(docId)){
  alert("già aggiunto alla selezione");
  return;
}
  const result = await client.get({
    index: index,
    id:docId
  }, (err, result) => {
      
    

    if (err){ console.log(err); return}

    var id = makeid(20);
    
    var resultJson = result._source.content;
    
   var newElement = "<div id='"+docId+"' class='draggable_container draggable_container_"+docId+"'><div class='container container_book'>";
    newElement+="<div class='row'><div class='col-md-3 col-lg-3 col-sm-4 col-xs-4'>";
    newElement+='<div onclick="showInfoModal(\'poetica\', '+docId+')" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Scheda</div></div>';
    newElement+="<div class='col-md-3 col-lg-3 col-sm-4 col-xs-4'>";
    newElement+='<a href = "'+result._source.file_path.replace("/assets/assets/","/assets/")+'" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Download</a></div>';
    newElement+="<div class='col-md-3 col-lg-3 col-sm-4 col-xs-4'>";
    newElement+='<div onclick="printBook('+docId+')" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">Stampa</div></div></div>';
    newElement+="</div>";
    newElement+="<h2>"+result._source.title+"</h2>";
    
    Object.keys(resultJson).forEach(function(i){
      newElement+="<div id='key_"+i+"_"+id+"' class='row "+id+"'>"
      newElement+="<div class='col-md-12 col-lg-12 col-sm-12 col-xs-12'><p >"+i+"</p> ";
      newElement+="</div></div><div class='row partoolbar' id='partoolbar_"+i+"_"+id+"' ><div class='col-md-1 col-lg-1 col-sm-1 col-xs-1'><div title='mostra o nascondi paragrafo' onclick='hideOrShowPar("+i+",\""+id+"\")' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>";
    
      newElement+="<i id='eye_"+i+"_"+id+"' class='fa fa-eye'></i></div></div>";
      newElement+="<div class='col-md-1 col-lg-1 col-sm-1 col-xs-1'><div title='stampa paragrafo' onclick='printPar("+i+",\""+id+"\")' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>";
    
      newElement+="<i id='print_"+i+"_"+id+"' class='fa fa-print'></i></div></div>"
      newElement+="<div class='col-md-1 col-lg-1 col-sm-1 col-xs-1'><div title='blocca paragrafo' onclick='blockBook("+i+",\""+id+"\")' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>";
    
      newElement+="<i id='block_"+i+"_"+id+"' class='fa fa-ban'></i></div></div>";
      newElement+="<div class='col-md-1 col-lg-1 col-sm-1 col-xs-1'><div title='sposta la traduzione' onclick='initDrag()' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dragbtn'>";
    
      newElement+="<i id='move_"+i+"_"+id+"' class='drag_stop fa fa-arrows-alt'></i></div></div>";
      newElement+="<div class='col-md-1 col-lg-1 col-sm-1 col-xs-1'><div title='chiudi questa traduzione' onclick='closeBook("+docId+")' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dragbtn'>";
    
      newElement+="<i id='close_"+i+"_"+id+"' class=' fa fa-window-close'></i></div></div>";
      newElement+="<div class='col-md-1 col-lg-1 col-sm-1 col-xs-1'><div title='mostra tutte le annotazioni di questo paragrafo' onclick='lookIn("+docId+")' class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm dragbtn'>";
    
      newElement+="<i id='lookIn_"+i+"_"+id+"' class=' fas fa-binoculars'></i></div></div>";
      
      newElement+="<div class='col-md-1 col-lg-1 col-sm-1 col-xs-1'><div title='mostra o nascondi le annotazioni' onclick=\"hideOrShowAnnotation("+i+",'"+id+"')\" class='d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm'>";
    
      newElement+="<i id='bulb_"+i+"_"+id+"' class=' fas fa-lightbulb'></i></div></div>";
      
      
      newElement+="</div>";
     
      newElement+="<p class='bookPar p_"+docId+" p_"+docId+"_"+i+" "+id+" "+i+"'  id='value_"+i+"_"+id+"'>"+resultJson[i].replace(/(<([^>]+)>)/ig,"")+"</p>";


    });
    newElement+="</div></div>";
    $("#"+appendTo).append(newElement);
    
    initAnnotator(docId,isReader);
    
  
  });
  
}




async function showInfoModal(index='poetica',id){
  const result = await client.get({
    index: index,
    id:id
  }, (err, result) => {
    console.log(result);
    if (err){ console.log(err); return}
    $("#scheda_informativa_body").html("");
      var infoElement = "<h4>Titolo: </h4> "+result._source.title+"<br>";
      infoElement+= "<h4>Autore</h4> "+result._source.author_name+" "+result._source.author_surname+"<br>";
      infoElement+= "<h4>Anno di pubblicazione</h4> "+result._source.year+"<br>";
      infoElement+= "<h4>Lingua</h4> "+result._source.language+"<br>";
      infoElement+= "<h4>Link testo</h4><a href='"+result._source.file_path+"' target='_blank'>Scarica</a>";
      $("#scheda_informativa_body").html(infoElement);
      $("#infoModal").modal("toggle");

  });
}
async function getDocumentsByMultiParam(index='poetica', params){

var meta = buildParams(params);

// promise API
const result = await client.search({
  index: index,
  body: {
    query: {
      match: meta
    }
  }
}, (err, result) => {
    console.log(result);
  if (err) console.log(err)
});
}

function buildParams(params){

    let par = {};
    params.forEach(element => {
        par[element.key] = element.value;
    });

   return par;
}


function makeid(length) {
  var result           = '';
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
    result += characters.charAt(Math.floor(Math.random() * 
charactersLength));
 }
 return result;
}


function hideOrShowAnnotation(i, id){

  if($("[data-annotation-id]").hasClass("annotator-hl")){
    $("[data-annotation-id]").removeClass("annotator-hl");
} else {
  $("[data-annotation-id]").addClass("annotator-hl");
} 
 /* debugger;
  if($("#value_"+i+"_"+id+" > [data-annotation-id]").hasClass("annotator-hl")){
      $("#value_"+i+"_"+id+" > [data-annotation-id]").removeClass("annotator-hl");
  } else {
    $("#value_"+i+"_"+id+" > [data-annotation-id]").addClass("annotator-hl");
  }   */
}
function initDrag() {
  $('#loaded_book').sortable({disabled: false, placeholder: "ui-state-highlight",helper:'clone'});
  $(".drag_stop").addClass(['drag_start','fa-circle']);
  $(".drag_start").removeClass(['drag_stop', 'fa-arrows-alt']);
  $(".dragbtn").attr("onclick","disableDrag()");
  //$('.draggable_container').draggable();
}

function disableDrag(){
  $("#loaded_book").sortable({
    disabled: true,
  });
  $(".drag_start").addClass(['drag_stop', 'fa-arrows-alt']);
  $(".drag_stop").removeClass(['drag_start','fa-circle']);
  $(".dragbtn").attr("onclick","initDrag()");
}

function saveAnnotation(indes='poetica', docId){
  alert("error on save");
}


async function lookIn(bookId){
  var elements = $(".draggable_container");
  for(var i = 0; i<elements.length; i++){
      if($(elements[i]).attr("id") != bookId){
          $(elements[i]).remove();
      }
  }
  $("#lookin").remove();
  
  const result = await client.get({
      index: 'poetica',
      id:bookId
    }, (err, result) => {
        
      debugger;
      
      let lookinAnnotation = result._source.annotations.rows;
      var html = "";
      for(var i = 0; i<lookinAnnotation.length; i++) {
        var lookinAnn = lookinAnnotation[i];
        colorStyle = "";
        tags = [];
        biblio = [];
        labelTags = "";
        labelBiblio = "";
        if(lookinAnn.color){
          colorStyle="style='background-color: "+lookinAnn.color+"'>";
        }
        if(lookinAnn.tags){
          tags = JSON.parse(lookinAnn.tags);
          
          for(var iTag = 0; iTag<tags.length; iTag++){
            labelTags+=tags[iTag].label+", ";
          }
        }
        if(lookinAnn.biblio){
          biblio = JSON.parse(lookinAnn.biblio);
          
          for(var iBiblio = 0; iBiblio<biblio.length; iBiblio++){
            labelBiblio+=biblio[iBiblio].title+", ";
          }
        }
        html+="<div class='looking_annotation' id='looking_"+lookinAnn.id+"' >";
        html+="<div "+colorStyle+" id='looking_"+lookinAnn.id+"_content' class='loking_annotation_content'>";
        html+="</div><i>Annotazione:</i><br>"+lookinAnn.text+"<br><i>Tags:</i><br>"+labelTags+"<br><i>Biblio:</i>"+labelBiblio;
        html+="</div>";
          
      }
      if(html != ""){
      $("#loaded_book").append("<style>.looking_annotation{margin-left:15px;margin-top:15px;}</style><div style='width:40%; margin-top:180px; border-left:1px solid black;' id='lookin'></div>");
      $("#lookin").append(html);
      } else {
        alert("Nessuna informazione disponibile");
        $("#lookin").remove();

      }
      
        
      if (err){ console.log(err); return}
    });
}