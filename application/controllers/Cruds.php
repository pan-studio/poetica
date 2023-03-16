<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cruds extends CI_Controller {

	public function __construct()
	{
		header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
        $this->load->library('ElasticSearch');
        
	}


    public function load_tags_list(){
        try{
			$crud = new grocery_CRUD();

			$crud->set_table('tags');
            $crud->display_as('tag','Tag');
            $crud->display_as('description','Descrizione');
            $crud->set_relation_n_n('rel_book', 'tag_relationship', 'book', 'id_tag','id_book', '{title} - {id_book}');
            $crud->set_relation_n_n('rel_biblio', 'tag_relationship', 'biblio', 'id_tag','id_biblio', '{title} - {id_biblio}');

            $crud->columns('tag','description','rel_book','rel_biblio');
            $crud->display_as('rel_book','Correlato a libro');
            $crud->display_as('rel_biblio','Correlato a bibliografia');
			$crud->callback_read_field('rel_book', function($value, $row) {
				$value = implode(", ", $value);
				
				$findId= explode("&nbsp;-&nbsp;", $value);
					

				$id = $findId[count($findId)-1];

                return "<a href='http://212.224.88.77/poetica/index.php/admin/book_managment/read/".$id."' target='blank'>$value</a>";
                });
			$crud->callback_read_field('rel_biblio', function($value, $row, $a, $b) {
	
					$value = implode(", ", $b->rel_biblio);
					
					$findId= explode("&nbsp;-&nbsp;", $value);
					

					$id = $findId[count($findId)-1];
                    return "<a href='http://212.224.88.77/poetica/index.php/cruds/load_biblio_list/read/". $id."' target='blank'>$value</a>";
    
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

    public function output($output = null, $path='admin/crud_admin')
	{
		
        if ($this->session->userdata('currently_logged_in'))  {
			
            $this->template->load('crud/empty_crud', 'contents' , $path, $output); 
        }
		
	}
}
