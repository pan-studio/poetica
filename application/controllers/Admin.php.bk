<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		$this->load->database();
		$this->load->helper('url');
        $this->load->library('ElasticSearch');
        
	}

	public function output($output = null, $path='admin/crud_admin')
	{
		
        if ($this->session->userdata('currently_logged_in'))  {
			
            $this->template->load($this->session->userdata('user_info')['role'].'_layout', 'contents' , $path, $output); 
        }
		
	}

    public function tag_menagment(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('tags');
            $crud->display_as('tag','Tag');
            $crud->display_as('description','Descrizione');
            $crud->set_relation_n_n('rel_book', 'tag_relationship', 'book', 'id_tag','id_book', 'title');
            $crud->set_relation_n_n('rel_biblio', 'tag_relationship', 'biblio', 'id_tag','id_biblio', 'title');
            
            $crud->columns('tag','description','rel_book','rel_biblio');
            $crud->display_as('rel_book','Correlato a libro');
            $crud->display_as('rel_biblio','Correlato a bibliografia');
            $crud->callback_read_field('rel_book', function($value, $row) {
                $value = implode(", ", $value);

                return "<a href='http://212.224.88.77/poetica/index.php/admin/book_managment/read/34' target='blank'>$value</a>";

                });
            $crud->callback_read_field('rel_biblio', function($value, $row) {
                $value = implode(", ", $value);

                    return "<a href='http://212.224.88.77/poetica/index.php/cruds/load_biblio_list/read/". $row."' target='blank'>$value</a>";
    
                    });
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

    public function load_tags_list(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('tags');
            $crud->display_as('tag','Tag');
            $crud->display_as('description','Descrizione');
            $crud->set_relation_n_n('rel_book', 'tag_relationship', 'book', 'id_tag','id_book', 'title');
            $crud->set_relation_n_n('rel_biblio', 'tag_relationship', 'biblio', 'id_tag','id_biblio', 'title');

            $crud->columns('tag','description','rel_book','rel_biblio');
            $crud->display_as('rel_book','Correlato a libro');
            $crud->display_as('rel_biblio','Correlato a bibliografia');
            $crud->callback_read_field('rel_book', function($value, $row) {
                $value = implode(", ", $value);

                return "<a href='http://212.224.88.77/poetica/index.php/admin/book_managment/read/34' target='blank'>$value</a>";
                });
            $crud->callback_read_field('rel_biblio', function($value, $row) {
                $value = implode(", ", $value);

                    return "<a href='http://212.224.88.77/poetica/index.php/cruds/load_biblio_list/read/". $row."' target='blank'>$value</a>";
    
                    });
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

    public function load_biblio_list(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('biblio');
            
            $crud->display_as('title','Titolo');
            $crud->display_as('author_id','Traduttore');
            $crud->display_as('year','Anno');
            $crud->display_as('language_id','Lingua');
            $crud->display_as('file','File PDF');
            $crud->display_as('link','Link Dropbox');
            $crud->display_as('biblio_typo_id','Tipologia');

            $crud->set_field_upload('file','assets/uploads/biblio_book');

            $crud->set_relation('language_id','languages','{language} - {code}');
            $crud->set_relation('biblio_typo_id','biblio_typo','{title}');
            /*$crud->callback_read_field('author_id', function($value, $row) {
                
                $query   = $this->db->query('SELECT name, surname FROM author WHERE id='.$value);
                $results = $query->result();
                $output = "";
                foreach($results as $res){
                    $output.= $res->name." ".$res->surname;
                }
                return "<a href='http://212.224.88.77/poetica/index.php/admin/author_managment/read/". $value ."' target='blank'>$output</a>";

                });*/
            $crud->required_fields('title','author_id','language_id');

            $crud->columns('title','author_id','year','language_id', 'file','link','biblio_typo_id');

            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

    public function load_author_list(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('author');
            
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }


public function test_autore(){
    try{
        $crud = new grocery_CRUD();

        $crud->set_table('author');
        $crud->display_as('name','Nome');
        $crud->display_as('surname','Cognome');
       
        $crud->display_as('storiaIntellettuale','Storia intellettuale');
        $crud->display_as('language_id','Lingua');
        $crud->display_as('nazionalita_id','Nazionalità');
        $crud->columns('name','surname','language_id','nazionalita_id','biografia','storiaintellettuale','note');
        $crud->required_fields('name','surname','language_id','nazionalita_id');

        $crud->set_relation('language_id','languages','{language} - {code}');
        $crud->set_relation('nazionalita_id','nazionalita','{nome_stati}');


        
        $output = $crud->render();

        $this->output($output);

    }catch(Exception $e){
        show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
    
}


    public function multi_upload(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('multi_upload');
            $crud->set_field_upload('file_path','assets/uploads/multi_upload');
            $crud->columns('file_path');
            $crud->display_as('file_path','file');
            $crud->field_type('type', 'hidden', 'author');
            $crud->field_type('insertedDate', 'hidden', date("Y-m-d h:i:s"));
            $crud->callback_after_insert(array($this, 'import_uploaded_file'));
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }


    public function import_uploaded_file($data, $primary_key){
        $file_to_process = getcwd()."/assets/uploads/multi_upload/".$data['file_path'];
        $fileMimes = array(
            'text/x-comma-separated-values',
            'text/comma-separated-values',
            'application/octet-stream',
            'application/vnd.ms-excel',
            'application/x-csv',
            'text/x-csv',
            'text/csv',
            'application/csv',
            'application/excel',
            'application/vnd.msexcel',
            'text/plain'
        );
     
        // Validate whether selected file is a CSV file
        //if (!empty($_FILES['file_path']['name']) && in_array($_FILES['file_path']['type'], $fileMimes))
        if(true)
        {
     
                // Open uploaded CSV file with read-only mode
                $csvFile = fopen($file_to_process, 'r');
     
                // Skip the first line
                fgetcsv($csvFile);
     
                // Parse data from CSV file line by line
                 // Parse data from CSV file line by line
                 
                while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
                {
                    // Get row data
                    $name = $getData[0];
                    $surname = $getData[1];
                    $bornDate = $getData[2];
                    $deathDate = $getData[3];
                    $nazionalita = 0;
                    $language = 0;
                    $biografia = $getData[6];
                    $storia = $getData[7];
                    $note = $getData[8];
                    $this->db->where('nome_stati', $getData[4]);  
                    $query = $this->db->get('nazionalita');  
                    if ($query->num_rows() == 1)  
                    {  
                        $res = $query->result_array();  
                        $nazionalita= $res[0];
                        

                    } 

                    $this->db->where('language', $getData[5]);  
                    $query = $this->db->get('languages');  
                    if ($query->num_rows() == 1)  
                    {  
                        $res = $query->result_array();  
                        $language= $res[0];
                        

                    } 

                    $dataValue = array(  
                        'name'     => $name,  
                        'surname'  => $surname,  
                        'bornDate'   => $bornDate,  
                        'deathDate' => $deathDate,
                        'nazionalita_id'=>$nazionalita,
                        'language_id'=>$language,
                        'biografia'=>$biografia,
                        'storiaIntellettuale'=>$storia,
                        'note'=>$note
                        );  
                         
                        $this->db->insert($data['type'],$dataValue);  
                    
                }
     
                // Close opened CSV file
                fclose($csvFile);
     
                header("Location: index.php");
             
        }
        else
        {
            echo "Please select valid file";
        }

    }
    public function author_managment(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('author');
            $crud->display_as('name','Nome');
            $crud->display_as('surname','Cognome');
            $crud->display_as('bornDate','Data di Nascita');
            $crud->display_as('deathDate','Data di Morte');
            $crud->display_as('storiaIntellettuale','Storia intellettuale');
            $crud->display_as('language_id','Lingua');
            $crud->display_as('nazionalita_id','Nazionalità');
            $crud->columns('name','surname','bornDate','deathDate','language_id','nazionalita_id','biografia','storiaintellettuale','note');
            $crud->required_fields('name','surname','language_id','nazionalita_id');

            $crud->set_relation('language_id','languages','{language} - {code}');
            $crud->set_relation('nazionalita_id','nazionalita','{nome_stati}');


            
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

    public function get_tags_for_book(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('author');
            $crud->display_as('name','Nome');
            $crud->display_as('surname','Cognome');
            $crud->set_subject('Traduttore');
            $crud->columns('name','surname','info');
            $crud->required_fields('name','surname');

            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

    public function color_managment(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('colors');
            $crud->display_as('color','Colore');
            $crud->display_as('description','Descrizione (usato per...)');
            
            $crud->required_fields('color','description');

            $crud->columns('color','description');
            $crud->callback_add_field('color',function () {
                return '<div id="basic" class="popup-parent" style="top:45%;left:1em; cursor:pointer;">
                Scegli il colore!
            </div><input type="hidden" id="color" name="color" value="#ca095c4d">
            
<script type="text/javascript" src="'.base_url().'/assets/js/xcolorpicker/xncolorpicker.min.js" ></script>
<script>
 var parentBasic = document.querySelector("#basic");
 var popupBasic = new Picker(parentBasic);
        popupBasic.onDone = function(color) {
            parentBasic.style.background = color.rgbaString;
            document.getElementById("color").value = color.hex;
        };
        popupBasic.openHandler();
</script>';
            });
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }


    public function language_admin(){

        try{
			$crud = new grocery_CRUD();

			$crud->set_table('languages');
            $crud->display_as('language','Lingua');
            $crud->display_as('code','Codice');
            $crud->required_fields('language','code');

            $crud->columns('language','code');
            $output = $crud->render();

			$this->output($output);
        } catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

    public function biblio_managment(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('biblio');
            $crud->display_as('title','Titolo');
            $crud->display_as('author_id','Traduttore');
            $crud->display_as('year','Anno');
            $crud->display_as('language_id','Lingua');
            $crud->display_as('file','File PDF');
            $crud->display_as('link','File');

            $crud->display_as('biblio_typo_id','Tipologia');

            $crud->set_relation('language_id','languages','{language} - {code}');
            $crud->set_field_upload('file','assets/uploads/biblio_book');

            $crud->set_relation('biblio_typo_id','biblio_typo','{title}');
            /*$crud->callback_read_field('author_id', function($value, $row) {
                
                $query   = $this->db->query('SELECT name, surname FROM author WHERE id='.$value);
                $results = $query->result();
                $output = "";
                foreach($results as $res){
                    $output.= $res->name." ".$res->surname;
                }
                return "<a href='http://212.224.88.77/poetica/index.php/admin/author_managment/read/". $value ."' target='blank'>$output</a>";

                });*/
            $crud->required_fields('title','author_id','language_id');

            $crud->columns('title','author_id','year','language_id', 'file', 'link','biblio_typo_id');
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }

    public function user_managment(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('users');
            $crud->display_as('name','Nome');
            $crud->display_as('surname','Cognome');
            $crud->display_as('mail','mail/username');
            $crud->display_as('password','Password');

            $crud->display_as('address','Indirizzo');
            $crud->display_as('phone','Telefono');
            $crud->display_as('role','Ruolo');
            $crud->set_relation('role','user_role','{title}');

            $crud->required_fields('name','surname','mail','password','role');

            $crud->columns('name','surname','mail','password', 'address','phone','role');
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }


    public function book_managment(){
        try{
           
			$crud = new grocery_CRUD();

			$crud->set_table('book');
            $crud->display_as('id','Id');
            $crud->display_as('title','Titolo');
            $crud->display_as('author_id','Traduttore');
            $crud->display_as('language_id','Lingua');
            $crud->display_as('year','Anno di pubblicazione');
            $crud->display_as('file_path','File PDF Originale');
            $crud->display_as('processed_book','File da analizzare (JSON)');
            $crud->set_field_upload('file_path','assets/uploads/pdf_book');
            $crud->set_field_upload('processed_book','assets/uploads/processed_book');
            $crud->required_fields('processed_book','year','title','author_id','language_id');

            $crud->set_relation('author_id','author','{name} {surname}');
            $crud->callback_read_field('author_id', function($value, $row) {
                
                $query   = $this->db->query('SELECT name, surname FROM author WHERE id='.$value);
                $results = $query->result();
                $output = "";
                foreach($results as $res){
                    $output.= $res->name." ".$res->surname;
                }
                return "<a href='http://212.224.88.77/poetica/index.php/admin/author_managment/read/". $value ."' target='blank'>$output</a>";

                });
            $crud->set_relation('language_id','languages','{language} - {code}');

           
            $crud->columns('id','title','author_id','language_id','year', 'file_path','processed_book');
            $crud->callback_after_upload(array($this,'check_json_book_to_process'));
            $crud->callback_after_insert(array($this, 'insert_book_on_elastic'));
            $crud->callback_after_update(array($this, 'update_book_on_elastic'));
            $crud->callback_after_delete(array($this, 'delete_book_on_elastic'));
          //  $crud->callback_before_insert(array($this, 'before_insert_book_on_elastic'));
          //  $crud->callback_before_update(array($this, 'before_update_book_on_elastic'));
          //  $crud->callback_before_delete(array($this, 'before_delete_book_on_elastic'));
           // $crud->callback_after_upload(array($this,'callback_after_upload'));
          
            $output = $crud->render();

			$this->output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
    }


   /* public function callback_after_upload($data, $type){
        var_dump($data);
      
    }*/


   public function find_book_on_elastic() {
        var_dump('a');die();
   }

        
   public function check_json_book_to_process($uploader_response,$field_info, $files_to_upload){
       // setlocale(LC_ALL, 'it_IT.UTF-8');
            if($files_to_upload[$field_info->encrypted_field_name]["type"] == "application/json"){
            $content = file_get_contents(getcwd()."/".$field_info->upload_path."/".$uploader_response[0]->name);


            // Convert the codepoints to entities
            $content = preg_replace("/\\\\u([0-9a-fA-F]{4})/", "&#x\\1;", $content);
            // Convert the entities to a UTF-8 string
            $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
            $content = str_replace("\n", ' ', $content);
            $content = str_replace("\\n", ' ', $content);

            $content = stripslashes($content);
            // Convert the UTF-8 string to an ISO-8859-1 string
            //$content = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $content);
            if(((is_string($content) &&
            (is_object(json_decode($content)) ||
            is_array(json_decode($content)))))){
                if(json_decode($content !== null))
                    return true;
                return false;
            } else {
                return false;
            }
        }
        return true;
           // die();
   }

    public function insert_book_on_elastic($data, $primary_key){
       
        $esJson = new stdClass();
        $esJson->title = $data['title'];
        $esJson->year = $data['year'];
        $esJson->file_path =   base_url()."assets/assets/uploads/pdf_book/".$data['file_path'];
        $esJson-> language_id= $data['language_id'];
        $esJson-> author_id= $data['author_id'];
		$esJson->annotations = new stdClass();
		$esJson->annotations->rows = [];
        $esJson-> content = $this->process_book(getcwd()."/assets/uploads/processed_book/".$data['processed_book']);
        $this->db->where('id', $data['author_id']);  
        $query = $this->db->get('author');  
        $author = "";
        if ($query->num_rows() == 1)  
        {  
            $res = $query->result_array();  
            $author= $res[0];
            $esJson-> author_name = $author["name"];
            $esJson-> author_surname= $author["surname"];
            $esJson-> author_born_date= $author["bornDate"];
            $esJson-> author_death_date= $author["deathDate"];
            
        }   else {
            $esJson-> author_name = "";
            $esJson-> author_surname= "";
            $esJson-> author_born_date= "0000-00-00";
            $esJson-> author_death_date= "0000-00-00";
        }
       
        $this->db->where('id', $data['language_id']);  
        $query = $this->db->get('languages');  
        $author = "";
        if ($query->num_rows() == 1)  
        {  
            $res = $query->result_array();  
            $language= $res[0];
            $esJson-> language= $language["language"]." - (".$language["code"].")";
        }  else {
            $esJson-> language="";
        }
      
        $this->db->where('id_stati', $data['nazionalita_id']);  
        $query = $this->db->get('nazionalita');  
        if ($query->num_rows() == 1)  
        {  
            $res = $query->result_array();  
            $nazionalita= $res[0];
            $esJson-> nazionalita_id= $nazionalita["id_stati"];
            $esJson-> nazionalita= $nazionalita["nome_stati"];

        }  else {
            $esJson-> nazionalita_id= -1;
            $esJson-> nazionalita= "";
        }

        $elastic = new ElasticSearch();


        
		//$content = preg_replace("/\\\\u([0-9a-fA-F]{4})/", "&#x\\1;", $esJson->content);
            // Convert the entities to a UTF-8 string
           // $content = html_entity_decode($esJson->content, ENT_QUOTES, 'UTF-8');
            
            /*$content = str_replace("\n", ' ', $content);
            $content = str_replace("\\n", ' ', $content);
            $content = stripslashes($content);
            $content = utf8_encode($content);
            $content = iconv('UTF-8', 'ASCII//TRANSLIT', $content);
            */
            
            $content = stripslashes($esJson->content);
            
            $esJson->content = json_decode($content);
            
                       

            $esJson->content = $esJson->content->content;
            
            $result = $elastic->add("_doc", $primary_key, $esJson,'POST');
            if(isset($result["error"])){
                $this->db->query("delete from book where id=".$primary_key);
               
                echo json_encode(array('success' => false,'error_message' => $result["error"]["caused_by"]["type"]." ".$result["error"]["caused_by"]["reason"]));
                return false;
                

            }
            return true;
    }


    public function delete_book_on_elastic($data, $primary_key){
        $elastic = new ElasticSearch();
        $elastic->delete("_doc", $primary_key);
    }

        public function update_book_on_elastic($data, $primary_key){
            $elastic = new ElasticSearch();
            $elastic->delete("_doc", $primary_key);
            $this->insert_book_on_elastic($data, $primary_key);
        }

 

    private function process_book($book_to_process){

        $path_info = pathinfo($book_to_process);
       $extension = $path_info['extension']; 
       

        switch ($extension) {
            case "txt":
                $content = file_get_contents($book_to_process, true);
               
                $esJson = new stdClass();
                $esJson->content = [];
                $lines = preg_split("/\r\n|\n|\r/", $content);

                for($frag = 0; $frag< count(FRAMMENTI); $frag++){
                    $found = false;
                    for($i=0; $i<count($lines); $i++){
                     
                        if (trim($lines[$i]) == '' && $i<count($lines)) {
                            $keyFrag= trim($lines[$i+1]);
                            $valueFrag = trim($lines[$i+2]);
                            if($keyFrag == FRAMMENTI[$frag]){
                                
                                $arrObject = new stdClass();
                                $arrObject->key = $keyFrag;
                                $arrObject->value = $valueFrag;
                                array_push($esJson->content, $arrObject);
                                $found = true;
                            }
                        }
                   
                    }
                    if(!$found){
                        $arrObject = new stdClass();
                        $arrObject->key = FRAMMENTI[$frag];
                        $arrObject->value = "NON TROVATO";
                        array_push($esJson->content, $arrObject);
                    }
                }
                return json_encode($esJson);
               
                break;
            case "json":
                $content = file_get_contents($book_to_process, false);

                // Convert the codepoints to entities
               
               
               
               
               /*
                $content = preg_replace("/\\\\u([0-9a-fA-F]{4})/", "&#x\\1;", $content);
                // Convert the entities to a UTF-8 string
                $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
                $content = str_replace("\n", ' ', $content);
                $content = str_replace("\\n", ' ', $content);
    
               
                
                */
                $content = stripslashes($content);
                $data = json_decode($content,false, 512, JSON_UNESCAPED_UNICODE);
                $esJson = new stdClass();
                $esJson->content = new stdClass();
                for($frag = 0; $frag< count(FRAMMENTI); $frag++){
                    $found = false;
                    for($i=0; $i<count($data->poetica); $i++){
                     
                        $keyFrag= trim($data->poetica[$i]->frammento);
                        $valueFrag = $data->poetica[$i]->testo;
                            if($keyFrag == FRAMMENTI[$frag]){
                                
                                /*$arrObject = new stdClass();
                                $arrObject->key = $keyFrag;
                                $arrObject->value = $valueFrag;
                                //$esJson->content->$keyFrag = $valueFrag;
                                */
                                $esJson->content->$keyFrag = $valueFrag;
                                $found = true;
                            
                        }
                   
                    }
                    if(!$found){
                        /*$arrObject = new stdClass();
                        $arrObject->key = FRAMMENTI[$frag];
                        $arrObject->value = "NON TROVATO";
                        array_push($esJson->content, $arrObject);*/
                        //$esJson->content->FRAMMENTI[$frag] = "NON TROVATO";
                        $keyFrag = FRAMMENTI[$frag];
                        $esJson->content->$keyFrag = "NON TROVATO";
                    }
                }
                //return $esJson;
                return json_encode($esJson, JSON_UNESCAPED_UNICODE);
                break;
            
        
        return "";
       }

    }
    
}
