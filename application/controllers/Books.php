<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {


    function __construct() {
        parent::__construct();
	header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");


	$this->load->model('user_model', 'user', TRUE);

        $this->load->model('book_model', 'book', TRUE);
        $this->load->library('ElasticSearch');

    }
	

    public function super_unique($array,$key)
    {
       $temp_array = [];
       foreach ($array as &$v) {
           if (!isset($temp_array[$v[$key]]))
           $temp_array[$v[$key]] =& $v;
       }
       $array = array_values($temp_array);
       return $array;

    }
    public function update_book(){
        header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            $bookId = $_POST['book_id'];

        }
    }

    public function get_all_biblio_by_keyword(){
        header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            echo json_encode($this->book->get_all_biblio_by_keyword($_GET['keyword']));


        }
    }

    public function get_all_color(){
        header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            echo json_encode($this->book->get_all_color());


        }
    }

    public function get_all_tags_by_keyword(){
        header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            echo json_encode($this->book->get_all_tags_by_keyword($_GET['keyword']));


        }
    }

    public function get_all_book_with_tag(){
        header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            echo json_encode($this->book->get_all_books_with_tag($_GET['keyword']));


        }
    }

    public function advanced_search(){

        //header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            $query = "";
            $queryTag = "";
            $queryBiblio = "";
            $searchInDb = false;
            
            $foundSearchForTestoNellaTraduzione = false;
            $foundSearchForAnnotazione = false;
            $foundSearchForTag = false;
            $foundSearchForBiblio= false;
            $biblioIds = [];
            $elasticFields = [];
            $elasticValue = "";
            $foundSearchForLanguage = false;
            $annotationFields = [];
            $annotationValue = "";
            
            for($i=0; $i<count($_POST['cerca_per']); $i++){
                if($_POST['cerca_per'][$i] == 'tag')
                    $foundSearchForTag = true;
                    if($_POST['cerca_per'][$i] == 'lingua')
                    $foundSearchForLanguage = true;
                if($_POST['cerca_per'][$i] == 'testo_nella_traduzione'){
                    $foundSearchForTestoNellaTraduzione = true;
                    array_push($elasticFields, "content");
                }
                if($_POST['cerca_per'][$i] == 'annotazione'){
                    $foundSearchForAnnotazione = true;
                    array_push($annotationFields, "annotations.rows.text");

                    array_push($elasticFields, "annotations.rows.text");
                }
                
            }
            if(count($elasticFields) > 0)
                $elasticFields = array_unique($elasticFields);
             $queryIniziale = "select *, book.id as bid from book, author ";
             
             $query = " where book.author_id = author.id and ";

            // if($foundSearchForLanguage == true)
            // $query = "select *, book.id as bid from book, languages, author where book.author_id = author.id and ";

            if($foundSearchForTag == true){
                $query = "select  author.name, author.surname, book.title, book.file_path, book.id as bid from book, tag_relationship, tags, author where book.author_id = author.id and tag_relationship.id_book = book.id and tag_relationship.id_tag = tags.id and  ";
                $queryTags = "select * from tag_relationship, tags where tag_relationship.id_tag = tags.id and ";
                $queryBiblio = "select * from biblio_relationship, biblio where biblio_relationship.biblio_id = biblio.id and ";

            }

            


            

            for($i=0; $i<count($_POST['cerca_per']); $i++){
                if($_POST['cerca_per'][$i] == 'traduttore'){
                    $searchInDb = true;
                    if($_POST['tipologia'][$i] == 'contiene'){
                    $query.= " (author.name like '%".$_POST["keyword"][$i]."%'
                    or author.surname like '%".$_POST["keyword"][$i]."%') "; 
                    } else {
                        $query.= " (author.name = '".$_POST["keyword"][$i]."'
                    or author.surname = '".$_POST["keyword"][$i]."') "; 
                    }
                    
                }

                if($_POST['cerca_per'][$i] == 'lingua'){
                    $searchInDb = true;
                    $queryIniziale.= ", languages ";
                    if($_POST['tipologia'][$i] == 'contiene'){
                    $query.= " ( book.language_id = languages.id && languages.language like '%".$_POST["keyword"][$i]."%') "; 
                    } else {
                        $query.= " ( book.language_id = languages.id && languages.language = '".$_POST["keyword"][$i]."') "; 
                    }
                    
                }


                if($_POST['cerca_per'][$i] == 'data'){
                    $searchInDb = true;
                    $query.= " book.year = ".$_POST["keyword"][$i];
                }
                if($_POST['cerca_per'][$i] == 'secolo'){
                    $searchInDb = true;
                    $query.= " ((book.year div 100) + 1) = ".$_POST["keyword"][$i]." ";

                }
                if($_POST['cerca_per'][$i] == 'testo_nella_traduzione'
                || $_POST['cerca_per'][$i] == 'annotazione'){
                    $elasticValue.=" ".$_POST['keyword'][$i];

                    if($foundSearchForAnnotazione == true && $_POST['cerca_per'][$i] == 'annotazione'){
                        $annotationValue.=" ".$_POST['keyword'][$i];

                    }
                }
                
                if($_POST['cerca_per'][$i] == 'tag'){
                    $searchInDb = true;
                    if($_POST['tipologia'][$i] == 'contiene'){
                        $query.= " (tags.tag like '%".$_POST["keyword"][$i]."%'
                        or tags.description like '%".$_POST["keyword"][$i]."%') "; 
                        $queryTags.= " (tags.tag like '%".$_POST["keyword"][$i]."%'
                        or tags.description like '%".$_POST["keyword"][$i]."%') "; 
                        } else {
                            $query.= " (tags.tag = '".$_POST["keyword"][$i]."'
                        or tags.description = '".$_POST["keyword"][$i]."') "; 
                        $queryTags.= " (tags.tag = '".$_POST["keyword"][$i]."'
                        or tags.description = '".$_POST["keyword"][$i]."') "; 
                        }
                }
                
                if($i<count($_POST['cerca_per'])-1){
                        $query.=" ".$_POST['andor'][$i]." ";
                    if(count($elasticFields) > 1){
                        $elasticValue.=" ".$_POST['andor'][$i]." ";
                    }
                    if(count($annotationFields) > 1){
                        $annotationValue.=" ".$_POST['andor'][$i]." ";
                    }
                }
            }
            $query.=" group by(bid)";
           
            $query = $queryIniziale." ".$query;
            $role = $this->session->userdata('user_info')['role'];
           

            //vedo se devo interrogare elastic
            $elasticResult = [];
            if(count($elasticFields) > 0){
                $elasticQuery = new stdClass();
                $elasticQuery->query = new stdClass();
                $elasticQuery->query->query_string = new stdClass();
                $elasticQuery->query->query_string->query = "*".ltrim($elasticValue)."*";
                for($if=0; $if<count($elasticFields); $if++){
                    $elasticFields[$if]=$elasticFields[$if].".*";
                }
                $elasticQuery->query->query_string->fields = $elasticFields;
                $elastic = new ElasticSearch();
               
                $res = $elastic->queryCurl('POST', $elasticQuery);
                foreach($res->hits->hits as $elasticBook){
                    

                    $bookResult = new stdClass();
                    $bookResult->id = $elasticBook->_id;
                    $bookResult->title = $elasticBook->_source->title;
                    $bookResult->author_id = $elasticBook->_source->author_id;
                    $bookResult->file_path = $elasticBook->_source->file_path;
                    $bookResult->language_id = $elasticBook->_source->language_id;
                    $bookResult->year = $elasticBook->_source->year;
                    $bookResult->processed_book = basename($elasticBook->_source->file_path);
                    $bookResult->name = $elasticBook->_source->author_name;
                    $bookResult->surname = $elasticBook->_source->author_surname;
                    $bookResult->bid = $elasticBook->_id;
                    $bookResult->info = "";
                    $bookResult->annotations = $elasticBook->_source->annotations;

                   array_push($elasticResult, $bookResult);
                }
            }
           
            $result['tags_mysql_result'] = [];
            if($searchInDb == true){

            $result['book_mysql_result'] = $this->book->find_books($query);
            
            if($foundSearchForTag == true){
                $result['tags_mysql_result'] = $this->book->get_all_tags_by_query($queryTags);
            } else {
                //prendo i tag dei libri
                $books = $result['book_mysql_result']["book"];
                $queryTags = "select * from tag_relationship, tags where tag_relationship.id_tag = tags.id and ";
                if(count($books) > 0){
                foreach($books as $book){
                    $queryTags.=" tag_relationship.id_book = ".$book["bid"]." OR";
                }
                $queryTags = explode( " ", $queryTags );
                array_splice( $queryTags, -1 );
                
                $queryTags= implode( " ", $queryTags );
                
                $result['tags_mysql_result'] = $this->book->get_all_tags_by_query($queryTags);
            }
            }

            
                //prendo le biblio dei libri
                $books = $result['book_mysql_result']["book"];
                $queryBiblio = "select * from biblio_relationship, biblio where biblio_relationship.id_biblio = biblio.id and ";
                if(count($books) > 0){
                foreach($books as $book){
                    $queryBiblio.=" biblio_relationship.id_book = ".$book["bid"]." OR";
                }
                $queryBiblio = explode( " ", $queryBiblio );
                array_splice( $queryBiblio, -1 );
                
                $queryBiblio= implode( " ", $queryBiblio );
                
                $result['biblio_mysql_result'] = $this->book->get_all_biblio_by_query($queryTags);
            }
            
 
            foreach($elasticResult as $elasticBook){
                $addElasticToMysql = true;

                foreach($result['book_mysql_result']->book as $book){
                
                        if($elasticBook->id == $book->id)
                            $addElasticToMysql  = false; 
                    }

                    if($addElasticToMysql == true)
                    array_push($result['book_mysql_result']->book,$elasticBook );

                }
                
            } else {
                $jsonSql = [];
                $jsonSql["book"] = [];
                $queryTags = "select * from tag_relationship, tags where tag_relationship.id_tag = tags.id and ";
                $tagsId = [];
                

                foreach($elasticResult as $elRes){
                    array_push($jsonSql["book"], json_decode(json_encode($elRes), true));
                    foreach($elRes->annotations as $annotation){
                       
                            foreach($annotation as $ann){
                                $tags = json_decode($ann->tags);
                               
                                foreach($tags as $tag){
                                    array_push($tagsId, $tag->id);
                                }
                               
                                
                            
                        }
                    }
                }
                $result['book_mysql_result'] = $jsonSql;
                if(count($tagsId) > 0){
                    $tagsId = array_unique($tagsId);
                    for($i=0; $i<count($tagsId); $i++){
                        $queryTags.= " tags.id = ".$tagsId[$i]." OR";
                    }
                    $queryTags = explode( " ", $queryTags );
                array_splice( $queryTags, -1 );
                
                $queryTags= implode( " ", $queryTags );
                
                $result['tags_mysql_result'] = $this->book->get_all_tags_by_query($queryTags);

                }
                
            }

            //cerco bibliografia in base ai libri
           
            for($i=0; $i<count($result['book_mysql_result']['book'] ); $i++ ){
                        array_push($biblioIds,$result['book_mysql_result']['book'][$i]['bid']);
                    
            }
           
            if(count($biblioIds)>0){
            $queryBiblio = "select biblio.* from biblio, biblio_relationship where biblio_relationship.id_biblio=biblio.id and ";
                foreach($biblioIds as $biblioId){
                    $queryBiblio.=" biblio_relationship.id_book=".$biblioId." OR";
                }
                $queryBiblio = explode( " ", $queryBiblio );
                array_splice( $queryBiblio, -1 );
                
                $queryBiblio= implode( " ", $queryBiblio );
 
                $result['biblio_mysql_result'] = $this->book->get_all_biblio_by_query($queryBiblio);
            } else {
                $result['biblio_mysql_result'] = [];
            }
            
           
             
            $result['book_mysql_result']['book'] = $this->super_unique($result['book_mysql_result']['book'],"id");
            $result['tags_mysql_result'] = $this->super_unique($result['tags_mysql_result'],"id");
            $result['biblio_mysql_result'] = $this->super_unique($result['biblio_mysql_result'],"id");

           // $result['tags_mysql_result'] = array_unique($result['tags_mysql_result']);

            $this->template->load($role.'_layout', 'contents' , 'book/book_advanced', $result); 
           /* for($i=0; $i<count($_POST['keyword']); $i++){
                if($_POST['cerca_per'][$i] == )
            }

            for($i=0; $i<count($_POST['tipologia']); $i++){
                switch
            }

            for($i=0; $i<count($_POST['andor'])-1; $i++){
                switch
            }*/
        }
    }

    public function find_advanced_books(){
       // header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            $role = $this->session->userdata('user_info')['role'];
            $query = "select *, book.id as bid from book left join author on book.author_id = author.id  where book.author_id = author.id and ";

            if(isset($_POST['bookIds'])){
            $booksIds = $_POST['bookIds'];
            foreach ($booksIds as $id){
                $query=$query. " book.id=".$id." OR";
            }

            $query = explode( " ", $query );
                array_splice( $query, -1 );
                
                $query= implode( " ", $query );
      
        $result['book_mysql_result'] = $this->book->find_books($query);
             $this->template->load($role.'_layout', 'contents' , 'book/book_mysql', $result); 
        }
    }
    }
	public function find_books()
	{
        header("Access-Control-Allow-Origin: *");
        if ($this->session->userdata('currently_logged_in'))   
        {  
            $role = $this->session->userdata('user_info')['role'];
            $query = "select *, book.id as bid from book left join author on book.author_id = author.id  where book.author_id = author.id and ";

           
            for($i=0; $i<count($_POST["randomId"]); $i++){
                $randomIndex = $_POST["randomId"];
                $randId = $randomIndex[$i];
              
                if(isset($_POST["author_".$randId])){
                    $query.= " (author.name like '%".$_POST["author_".$randId]."%'
                    or author.surname like '%".$_POST["author_".$randId]."%') "; 
                    
                }

                if(isset($_POST["century_from_".$randId]) && isset($_POST["century_to_".$randId])){
                    $query.= " ((book.year div 100) + 1) >= ".$_POST["century_from_".$randId]." ";
                    $query.= " and ((book.year div 100) + 1) <= ".$_POST["century_to_".$randId]." ";
                    
                }

                if(isset($_POST["year_from_".$randId]) && isset($_POST["year_to_".$randId])){
                    $query.= " ((book.year div 100) + 1) >= ".$_POST["year_from_".$randId]." ";
                    $query.= " and ((book.year div 100) + 1) <= ".$_POST["year_to_".$randId]." ";
                    
                }

                if(isset($_POST["operator_language_".$randId])){
                    if(isset($_POST["operator_".$randId])){
                    $query.= " ".$_POST["operator_".$randId]." book.language_id = ".$_POST["language_".$randId]." "; 
                    $query.= " ".$_POST["operator_language_".$randId]; 
                } else {
                    $query.= " book.language_id = ".$_POST["language_".$randId]." ".$_POST["operator_language_".$randId]; 
                }
            
            } else {
                $query.= " ".$_POST["operator_".$randId];
            }
        }
        $query = preg_replace('/\W\w+\s*(\W*)$/', '$1', $query);

            
           /*$keyword = $_POST['keyword'];
           
            if($_POST['searchfor'] == 'author'){
                $query.= " and (author.name like '%".$keyword."%'
                or author.surname like '%".$keyword."%') and author.id = book.author_id";
                
            }
            if($_POST['searchfor'] == 'year'){
                $query.= " and year = ".$keyword." and author.id = book.author_id";
               
            }

            if($_POST['searchfor'] == 'century'){
                $query.= " and ".$keyword." = CAST((year / 100) +1) as integer and author.id = book.author_id";
                
            }

            if($_POST['language'] != -1)
                $query.=' and language_id = '.$_POST['language'];

                */
            $result['book_mysql_result'] = $this->book->find_books($query);
             
            $this->template->load($role.'_layout', 'contents' , 'book/book_mysql', $result); 
        }
        }

	}
