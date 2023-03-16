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

        
            function updateFieldTag(field, annotation) {
                var value = '';
                if (annotation.tags) {
                    value = stringifyTags(annotation.tags);
                }
                $('#tags_'+bookId).val(value);
            }
        
            function updateFieldBiblio(field, annotation) {
                var value = '';
                if (annotation.biblio) {
                    value = annotation.biblio;
                }
               
                $('#biblio_'+bookId).val(value);
            }
            function updateFieldColor(field, annotation) {
                var value = '';
                if (annotation.color) {
                    value = annotation.color;
                } else {
                    value = "#ffffff";
                }
               
                $('#color_'+bookId).val(value);
            }

            function setAnnotationBiblio(field, annotation) {
                annotation.biblio = $('#biblio_'+bookId).val();
            }
        
            function setAnnotationTag(field, annotation) {
                annotation.tags = $('#tags_'+bookId).val().split(",");
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
                label: 'Aggiungi tag separati da virgola',
                
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
            var htmlbiblio = $("#biblio_"+bookId).parent().html();
            $("#biblio_"+bookId).parent().html('<div id="suggesstion-biblio-box-'+bookId+'"></div>'+htmlbiblio);

            $("#biblio_"+bookId).addClass("form-control border-0 small")


            $("#biblio_"+bookId).on("keyup",function(){
                $("#biblio_"+bookId).css("background","#FFF url(loaderIcon.gif) no-repeat 165px");
               
                

                $.ajax({
                type: "GET",
                url: "http://212.224.88.77/poetica/index.php/books/get_all_biblio_by_keyword",
                data:'keyword='+$(this).val(),
                success: function(data){
                    
                    setTimeout(function() {
                        $("#suggesstion-biblio-box-"+bookId).show();
                        $("#suggesstion-biblio-box-"+bookId).html(data);
                        $("#biblio_"+bookId).css("background","#FFF");}
                        , 1000);
                }
                });
            });

            var colorbox = $("#color_"+bookId).parent().html();
            $("#color_"+bookId).parent().html('<div style="display:none; height:30px; width:100%;" id="suggesstion-color-box-'+bookId+'"></div>'+colorbox);
            $("#color_"+bookId).addClass("form-control border-0 small")
            $("#tags_"+bookId).addClass("form-control bg-light border-0 small search_book_field hidden");
            var htmltag = $("#tags_"+bookId).parent().html();
            $("#tags_"+bookId).parent().html('<div style="display:none; '
            +'height:50px; width:50%;" id="suggesstion-tag-box-'+bookId+'"></div>'
            +'<div style="display:none; height:50px; width:50%;" id="suggesstion-tag-box-list-'+bookId+'"></div>'+htmltag);
            $("#tags_"+bookId).on("keyup",function(){
                $("#tags_"+bookId).css("background","#FFF url(loaderIcon.gif) no-repeat 165px");
               
                

                $.ajax({
                type: "GET",
                url: "http://212.224.88.77/poetica/index.php/books/get_all_tags_by_keyword",
                data:'keyword='+$(this).val(),
                success: function(data){
                     setTimeout(function() {
                        $("#suggesstion-tag-box-"+bookId+" > ").empty();
                        $("#suggesstion-tag-box-"+bookId).show();
                        $("#suggesstion-tag-box-list-"+bookId).show();
                        var ul = document.createElement("ul");
                        data = JSON.parse(data);
                        data.forEach(element => {
                            debugger;
                            if($("#suggesstion-tag-box-"+bookId+" > ul ").find("[data_target_tag_value="+element.tag+"]").length <= 0
                            && $("#suggesstion-tag-box-list-"+bookId+" > ul ").find("[data_target_tag_value="+element.tag+"]").length <= 0){
                            var li = document.createElement("li");
                            li.setAttribute("data_target_id", element.id);
                            li.setAttribute("data_target_book_id", bookId);
                            li.setAttribute("data_target_tag_value", element.tag);
                            li.onclick = function(){
                                generateClickableList("suggesstion-tag-box-"+bookId, "suggesstion-tag-box-list-"+bookId, this);
                            };
                            li.innerHTML = element.tag;
                            ul.appendChild(li);
                            }

                        })
                       
                        $("#suggesstion-tag-box-"+bookId).append(ul);
                        $("#tags_"+bookId).css("background","#FFF");}
                        , 1000);
                }
                });
            });
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