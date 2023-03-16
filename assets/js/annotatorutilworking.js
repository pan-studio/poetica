var currentBookSelectedText = 0;
document.addEventListener('selectionchange', (e) => {
    let id = document.getSelection().anchorNode.parentElement.parentElement.id;
    if(!isNaN(id) && id != ''){
        currentBookSelectedText = document.getSelection().anchorNode.parentElement.parentElement.id;
        
       
    }
    
});

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
            function updateFieldTag(field, annotation) {
                var value = '';
                $("#parent_tags_"+bookId).empty();
                $('input[name="id_to_append_element_tags"]').remove();

                if (annotation.tags) {
                    
                    var jsonVal = JSON.parse(annotation.tags);
                    for(var i = 0; i<jsonVal.length; i++){
                        debugger;
                        value+=jsonVal[i].label+",";
                        $("#parent_tags_"+bookId).append('<input '
                        +'type="hidden" name="id_to_append_element_tags" data-type="tags" label-val="'
                        +jsonVal[i].label+'" value="'+jsonVal[i].id+'"></input>');
                    }
                    
                    
                }
                debugger;
                $("#tags_"+bookId).val(value);
                initGroceryFields(fieldsToInit[0]);
            }
        
            function updateFieldBiblio(field, annotation) {
                var value = '';
                var value = '';
                $("#parent_biblio_"+bookId).empty();
                $('input[name="id_to_append_element_biblio"]').remove();

                if (annotation.biblio) {                   
                     var jsonVal = JSON.parse(annotation.biblio);
                    for(var i = 0; i<jsonVal.length; i++){
                        value+=jsonVal[i].label+",";
                        $("#parent_biblio_"+bookId).html($("#parent_biblio_"+bookId).html("")+'<input '
                        +'type="hidden" name="id_to_append_element_biblio" data-type="biblio" label-val="'
                        +jsonVal[i].label+'" value="'+jsonVal[i].id+'"></input>');
                    }
                }
                    $("#biblio_"+bookId).val(value);
                    
                    initGroceryFields(fieldsToInit[1]);
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
                var biblioIds = document.getElementsByName('id_to_append_element_biblio');
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
                var tagIds = document.getElementsByName('id_to_append_element_tags');
               
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
                id:"biblio_"+bookId,
                label: 'Seleziona bibliografia',
                load: updateFieldBiblio,
                submit: setAnnotationBiblio
            }));
        
            field.push(e.addField({
                type:'input',
                id:"tags_"+bookId,
                label: 'Aggiungi tag',
                
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
            
            initGroceryFields(fieldsToInit[0]);
            initGroceryFields(fieldsToInit[1]);

            

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
   
    function initGroceryFields(grField){
        
            $("#"+grField.id).click(function(obj){
                $("#groceryModalTitle").html(grField.title);
                $("#groceryModalBody").html('<iframe id="grocery_frame" src="'+grField.url+'"  width="100%" height="100%" frameborder="0"></iframe>');
                $("#groceryModal").modal("toggle");
            });
        
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
       var id_to_append =$("#id_to_append").val();
       var type =$("#type").val();
       var book_id =$("#book_id").val();
       var label_value = $("#label_value").val().trimStart();
       label_value = label_value.trimEnd()+",";
       debugger;
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


    }