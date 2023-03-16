var currentBookSelectedText = 0;
document.addEventListener('selectionchange', (e) => {
    let id = document.getSelection().anchorNode.parentElement.parentElement.id;
    if(!isNaN(id) && id != ''){
        currentBookSelectedText = document.getSelection().anchorNode.parentElement.parentElement.id;
        
       
    }
    
});

function removeElementFromAnnotation(id){
    $("#"+id).remove();
    $("#row_"+id).remove();

}
    let annotatorApp = [];
    const pageUri = function () {
        return {
            beforeAnnotationCreated: function (ann) {
            
            ann.uri = window.location.href;
            ann.bookId = currentBookSelectedText;
           
            },
           
            beforeAnnotationDeleted: function (ann) {
               
            ann.uri = window.location.href;
           // ann.bookId = currentBookSelectedText;
            
            },
            beforeAnnotationUpdated: function (ann) {
               
            ann.uri = window.location.href;
            //ann.bookId = currentBookSelectedText;
           
            },
            annotationCreated: function (ann){
                
                $("[data-annotation-id="+ann.id+"]")[0].style.background = ann.color;
            },
            annotationUpdated: function (ann){
                $("[data-annotation-id="+ann.id+"]")[0].style.background = ann.color;
            }
        };
    };



    function initAnnotator(bookId, isReader=false){

debugger;
        if(!annotatorApp[bookId]){
           
    
          //register the authorization and the viewer doesn't show any editing ability
        const elem = document.getElementById(bookId);
        const app = new annotator.App();
        if(isReader==true){
            var authorization = {
                //return a true or false here based on whatever...
                permits: function(){ return false;},
               
          };
        app.registry.registerUtility(authorization, 'authorizationPolicy');
        }
   
    app.include(annotator.ui.main, {element: elem,
        
        editorExtensions: [function biblioExtension(e) {
            // The input element added to the Annotator.Editor wrapped in jQuery.
            // Cached to save having to recreate it everytime the editor is displayed.
            var field = [];
            var inputBiblio = null;
            var inputTag = null;
            var fieldsToInit = [
                {
                    id:"tags_"+bookId,
                    url:"http://212.224.88.77/poetica/index.php/cruds/load_tags_list?add_to_book="+bookId+"&type=tags",
                    title: "Gestione tag"
                },
                {
                    id:"biblio_"+bookId,
                    url:"http://212.224.88.77/poetica/index.php/cruds/load_biblio_list?add_to_book="+bookId+"&type=biblio",
                    title: "Gestione bibliografia"
                }
            ]
            function updateFieldTag(currentField, annotation) {
                var value = '';
                debugger;
                $(currentField).attr("id","parent_tags_"+annotation.id);
                
                $("#parent_tags_"+annotation.id).empty();
                $('input[name="id_to_append_element_tags_'+annotation+'"]').remove();
                let ttags = '<table><tbody id="row_to_append_tags_'+annotation.id+'">';
                if (annotation.tags) {                   
                     var jsonVal = JSON.parse(annotation.tags);
                    for(var i = 0; i<jsonVal.length; i++){
                        let detailLink = 'initGroceryFields("'+fieldsToInit[0].title+'","http://212.224.88.77/poetica/index.php/cruds/load_tags_list/read/'+jsonVal[i].id+'","'+annotation.id+'", "id_to_append_element_tags_'+annotation.id+'", "parent_tags_'+annotation.id+'", "tags","row_to_append_tags_'+annotation.id+'")';
                        value+=jsonVal[i].label+",";
                        let hiddenFieldId = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 8);
                        $("#parent_tags_"+annotation.id).html('<input '
                        +'type="hidden" id="'+hiddenFieldId+'" name="id_to_append_element_tags_'+annotation.id+'" data-type="tags" label-val="'
                        +jsonVal[i].label+'" annotation_id="'+annotation.id+'" value="'+jsonVal[i].id+'"></input>');
                        ttags+='<tr class="customEditorList"  onclick=\''+detailLink+'\' tagId="'+jsonVal.id+'" id="row_'+hiddenFieldId+'"><td class="customEditorList">'+jsonVal[i].label+'</td><td><div class="customEditorListDelete" onclick="removeElementFromAnnotation(\''+hiddenFieldId+'\')">X</div></td></tr>';
                    }
                    ttags+='</tbody></table>';
                }
                    $("#tags_"+annotation.id).val(value);
                    $("#btn_tags_"+annotation.id).remove();
                    let clickLink = 'initGroceryFields("'+fieldsToInit[0].title+'","'+fieldsToInit[0].url+'","'+annotation.id+'", "id_to_append_element_tags_'+annotation.id+'", "parent_tags_'+annotation.id+'", "tags","row_to_append_tags_'+annotation.id+'")';
                    $("#tags_"+bookId).hide();
                    $(currentField).append("<div class='add-custom-button-editor' id='btn_tags_"+annotation.id+"'  onclick='"+clickLink+"'>Aggiungi Tags</div>")
                   
                    $(currentField).append(ttags);
                    //initGroceryFields(annotation.id, fieldsToInit[1].title, fieldsToInit[1].url);
                
            }

            
        
            function updateFieldBiblio(currentField, annotation) {
                var value = '';
                $(currentField).attr("id","parent_biblio_"+annotation.id);
                
                $("#parent_biblio_"+annotation.id).empty();
                $('input[name="id_to_append_element_biblio_'+annotation+'"]').remove();
                let tBiblio = '<table><tbody id="row_to_append_biblio_'+annotation.id+'">';
                if (annotation.biblio) {                   
                     var jsonVal = JSON.parse(annotation.biblio);
                    for(var i = 0; i<jsonVal.length; i++){
                        value+=jsonVal[i].label+",";
                        let detailLink = 'initGroceryFields("'+fieldsToInit[0].title+'","http://212.224.88.77/poetica/index.php/cruds/load_biblio_list/read/'+jsonVal[i].id+'","'+annotation.id+'", "id_to_append_element_tags_'+annotation.id+'", "parent_tags_'+annotation.id+'", "tags","row_to_append_tags_'+annotation.id+'")';
                        let hiddenFieldId = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 8);
                        $("#parent_biblio_"+annotation.id).html('<input '
                        +'type="hidden" id="'+hiddenFieldId+'" name="id_to_append_element_biblio_'+annotation.id+'" data-type="biblio" label-val="'
                        +jsonVal[i].label+'" annotation_id="'+annotation.id+'" value="'+jsonVal[i].id+'"></input>');
                        tBiblio+='<tr class="customEditorList" biblioId="'+jsonVal.id+'" onclick=\''+detailLink+'\' id="row_'+hiddenFieldId+'"><td class="customEditorList">'+jsonVal[i].label+'</td><td><div class="customEditorListDelete" onclick="removeElementFromAnnotation(\''+hiddenFieldId+'\')">X</div></td></tr>';
                    }
                    tBiblio+='</tbody></table>';
                }
                    $("#biblio_"+annotation.id).val(value);
                    $("#btn_biblio_"+annotation.id).remove();
                    let clickLink = 'initGroceryFields("'+fieldsToInit[1].title+'","'+fieldsToInit[1].url+'","'+annotation.id+'", "id_to_append_element_biblio_'+annotation.id+'", "parent_biblio_'+annotation.id+'", "biblio","row_to_append_biblio_'+annotation.id+'")';
                    $("#biblio_"+bookId).hide();
                    $(currentField).append("<div class='add-custom-button-editor' id='btn_biblio_"+annotation.id+"'  onclick='"+clickLink+"'>Aggiungi bibliografie</div>")
                   
                    $(currentField).append(tBiblio);
                    //initGroceryFields(annotation.id, fieldsToInit[1].title, fieldsToInit[1].url);
                }
            function updateFieldColor(field, annotation) {
                var value = '';
                if (annotation.color) {
                    value = annotation.color;
                } else {
                    value = "#ca095c4d";
                }
               
                $('#color_'+bookId).val(value);
            }

           
            function setAnnotationBiblio(field, annotation) {
                
                var biblioIds = document.getElementsByName('id_to_append_element_biblio_'+annotation.id);
                var biblios = [];
                for(var i = 0; i<biblioIds.length; i++) {
                    biblios.push({
                        id: biblioIds[i].value,
                        label: biblioIds[i].getAttribute('label-val').trimStart().trimRight()
                    })
                }
                annotation.biblio = JSON.stringify(biblios);
            }
        
            function setAnnotationTag(field, annotation) {
                
                //annotation.tags = $('#tags_'+bookId).val().split(",");
                var tagIds = document.getElementsByName('id_to_append_element_tags_'+annotation.id);
               
                var tags = [];
                for(var i = 0; i<tagIds.length; i++) {
                    tags.push({
                        id: tagIds[i].value,
                        label: tagIds[i].getAttribute('label-val').trimStart().trimRight()
                    })
                }
                annotation.tags = JSON.stringify(tags);
            }
        
            function setAnnotationColor(field, annotation) {
                annotation.color = $('#color_'+bookId).val();
            }
        

            function parseTags(value){
                return "";
            }

            function stringifyTags(value){
                return value.join(",");
            }
           
            field.push(e.addField({
                type:'input',
                label: 'Seleziona bibliografia',
                id:"bibliotxt",
                load: updateFieldBiblio,
                submit: setAnnotationBiblio
            }));
        
            field.push(e.addField({
                type:'input',
                label: 'Aggiungi tag',
                id:"tagtxt",
                load: updateFieldTag,
                submit: setAnnotationTag
            }));

            field.push(e.addField({
                type:'select',
                id:"color_"+bookId,
                label: 'Seleziona un colore',
                load: updateFieldColor,
                submit: setAnnotationColor
            }));

            inputTag = $("#tags_"+bookId);
            inputBiblio = $("#biblio_"+bookId);
            inputColor= $("#color_"+bookId);

            $("#biblio_"+bookId).addClass("form-control border-0 small")
            
           // initGroceryFields(fieldsToInit[0].id, fieldsToInit[0].title, fieldsToInit[0].url);
          //  initGroceryFields(fieldsToInit[1].id, fieldsToInit[1].title, fieldsToInit[1].url);

            

            var colorbox = $("#color_"+bookId).parent().html();
            $("#color_"+bookId).parent().html('<div style="display:none; height:30px; width:100%;" id="suggesstion-color-box-'+bookId+'"></div>'+colorbox);
            $("#color_"+bookId).addClass("form-control border-0 small")
            
                
               
               
            fetch('http://212.224.88.77/poetica/index.php/books/get_all_color')
                .then(response => response.json())
                .then(data => {
                    
                    data.color.forEach(element => {
                        $('#color_'+bookId).append($('<option>',
                     {
                        value: element.color,
                        text : element.description
                    })
                    
                    );
                });
                $("#color_"+bookId).change( function(obj){
                    $("#suggesstion-color-box-"+bookId).show();
                        $("#suggesstion-color-box-"+bookId).css("background-color", obj.currentTarget.value);
                })
                });
                    
                    
        }]
       });
    app.include(annotator.storage.debug);
    app.include(annotator.storage.http, {prefix: 'http://212.224.88.77',
        urls: {
        create:  '/poetica/index.php/annotations/createannotation',
        update:  '/poetica/index.php/annotations/updateannotation',
        destroy: '/poetica/index.php/annotations/deleteannotation',
        search:  '/poetica/index.php/annotations/loadAnnotations',
        
    }});
    app.include(pageUri);
   

        annotatorApp[bookId] = app;
        
        annotatorApp[bookId].modules[6].annotationCreated = function (annotationElement) {
            
           var  newAnnotationArray = [];
         
            for(var annAppArrayIndex = 0; annAppArrayIndex<annotatorApp.length; annAppArrayIndex++){
                if(annotatorApp[annAppArrayIndex]){
                  newAnnotationArrayElement = {
                        bookId: annAppArrayIndex,
                        elements:[]
                    };
                    elements = [];
                    counterIndex = 0;
                offSetsAnn = findTextInElementByClassName('p_'+annAppArrayIndex,annotationElement.quote);
            
            for(var indexOffSett = 0; indexOffSett<offSetsAnn.length; indexOffSett++) {
               
               
              /* if(offSetsAnn[i].pDiv != annotationElement.ranges[0].start || 
                    (offSetsAnn[i].pDiv == annotationElement.ranges[0].start
                    && */
                    if(annotationElement.ranges[0].startOffset != offSetsAnn[indexOffSett].start && 
                        annotationElement.ranges[0].endOffset != offSetsAnn[indexOffSett].end){
                     const newAnnotation = {};
                     newAnnotation.biblio = annotationElement.biblio;
                     newAnnotation.bookId = annAppArrayIndex;
                     newAnnotation.color = annotationElement.color;
                     newAnnotation.ranges = [];

                     newAnnotation.id = makeid(32).toLowerCase();
                     newAnnotation.ranges[0] = {};
                    newAnnotation.ranges[0].start = offSetsAnn[indexOffSett].pDiv;
                    newAnnotation.ranges[0].end = offSetsAnn[indexOffSett].pDiv;
                    newAnnotation.ranges[0].startOffset = offSetsAnn[indexOffSett].start;
                     newAnnotation.ranges[0].endOffset = offSetsAnn[indexOffSett].end;
                     newAnnotation.bookId = annAppArrayIndex;
                     newAnnotation.tags = annotationElement.tags;
                     newAnnotation.text = annotationElement.text;
                     newAnnotation.uri = annotationElement.uri;
                     newAnnotation.user = annotationElement.user;
                     newAnnotation._local = annotationElement._local;
                     
                     //const savedAnnotation = Object.assign(annotationElement,newAnnotation);
                     elements[counterIndex]=newAnnotation;
                     console.log('index', annAppArrayIndex);
                     console.log('newAnnotation',newAnnotation);
                     counterIndex++;
                   
                }
                
            }
          
            newAnnotationArrayElement.elements = elements;
            newAnnotationArray.push(newAnnotationArrayElement);
            console.log("array",newAnnotationArray);
            }
        }
           
            $.post( "http://212.224.88.77/poetica/index.php/annotations/createamultiplennotation", JSON.stringify(newAnnotationArray))
            .then(res=>{
               const resp = JSON.parse(res);
                resp.forEach(function(response){
                    annotatorApp[response.bookId].annotations.load({book_id: response.bookId});
                })
               // annotatorApp[annAppArrayIndex].annotations.load({book_id: annAppArrayIndex});
            });
        
                    
            
            
            
          };
        annotatorApp[bookId].start().then(function () {
            
        annotatorApp[bookId].annotations.load({book_id: bookId});
        annotatorApp[bookId].annotations.query({book_id: bookId}).then(res=>{
            res.results.forEach(element => {
                
                if(element.color){
                    
                    $("[data-annotation-id="+element.id+"]")[0].style.background = element.color;
                }
            });
        });
         });
        }
    }
   
    function initGroceryFields(title, url,annotation_id, hidden_name, parent_hidden_id,  data_type, id_to_append_result_hidden){
        
        
           // $("#"+id).click(function(obj){
                $("#groceryModalTitle").html(title);
                $("#groceryModalBody").html('<iframe id="grocery_frame" src="'+url+'"  width="100%" height="100%" frameborder="0"></iframe>');
                $("#groceryModal").attr("hidden_name", hidden_name);
                $("#groceryModal").attr("annotation_id", annotation_id)
                $("#groceryModal").attr("parent_hidden_id", parent_hidden_id)
                $("#groceryModal").attr("data_type", data_type)
                $("#groceryModal").attr("id_to_append_result_hidden", id_to_append_result_hidden)



                $("#groceryModal").modal("toggle");
           // });
        
    }
    

    function generateClickableList(box, target, object){

        object.onclick = function(){
            removeFromClickableList(target, box,  object);
        };
        $("#"+target).append(object);
        $("#"+box).remove(object);
    }

    function removeFromClickableList(box, target, object){
        object.onclick = function(){
            generateClickableList(box, target,  object);
        };

        $("#"+target).append(object);
        $("#"+box).remove(object);
    }


    function saveGroceryData(){
        /*var iframe = parent.document.getElementById("grocery_frame");

        $(iframe.contentDocument).find("#groceryModalSelectedElement").html();
        */
       
       $("#groceryModal").attr("toggle");

        var data_type = $("#groceryModal").attr("data_type")
        var parent_hidden_id = $("#groceryModal").attr("parent_hidden_id")
        var annotation_id = $("#groceryModal").attr("annotation_id")
        var hidden_name = $("#groceryModal").attr("hidden_name")
        var elementsValue = document.getElementsByName('element_id');
        var hiddenFieldId = Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 8);
        var id_to_append_result_hidden = $("#groceryModal").attr("id_to_append_result_hidden");
        for(var i = 0; i<elementsValue.length; i++){
            
            
            
             
          let detailLink = 'initGroceryFields(\"'+$(elementsValue[i]).attr('label-val')+'\",\"http://212.224.88.77/poetica/index.php/cruds/load_'+data_type+'_list/read/'+elementsValue[i].value+'\",\"'+annotation_id+'\", \"id_to_append_element_tags_'+annotation_id+'\", \"parent_tags_'+annotation_id+'\", \"'+data_type+'\",\"row_to_append_'+data_type+'_'+annotation_id+'\")';
           let resultValue = '<input type="hidden" id="'+hiddenFieldId+'" name="'+hidden_name+'" data-type="'+data_type+'" label-val="'
                        +$(elementsValue[i]).attr('label-val')+'" annotation_id="'+annotation_id+'" value="'+elementsValue[i].value+'"></input>';

            let elementList='<tr class="customEditorList" onclick="'+detailLink+'" id="row_'+hiddenFieldId+'"><td class="customEditorList">'+$(elementsValue[i]).attr('label-val')+'</td><td><div  onclick="removeElementFromAnnotation(\''+hiddenFieldId+'\')">X</div></td></tr>';
            $("#"+parent_hidden_id).append(resultValue);
            $("#"+id_to_append_result_hidden).append(elementList);

           }


       /*var id_to_append =$("#id_to_append").val();
       var type =$("#type").val();
       var book_id =$("#book_id").val();
       var label_value = $("#label_value").val().trimStart();
       label_value = label_value.trimEnd()+",";
       
       var elementsValue = document.getElementsByName('element_id');
       var parent_hidden = $("#"+id_to_append).parent();
       var parent_html = $(parent_hidden).html();
       $(parent_hidden).html("<div style='display:none;' id='parent_"+id_to_append+"'>");
       for(var i = 0; i<elementsValue.length; i++){
        $(parent_hidden).html($(parent_hidden).html()+'<input type="hidden" name="id_to_append_element_'+type+'" data-type="'
        +type+'" label-val="'+$(elementsValue[i]).attr('label-val')+'" value="'+elementsValue[i].value+'">');
       }
       $(parent_hidden).html($(parent_hidden).html()+parent_html+"</div>");

       $("#"+id_to_append).val(label_value);

       */
    }