<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Annotations extends CI_Controller {


    function __construct() {
        parent::__construct();
header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
       
	$this->load->database();
        $this->load->library('ElasticSearch');
        $this->load->model('user_model', 'user', TRUE);
        $this->load->helper('url');
    }
	
	public function index()
	{
        header("Access-Control-Allow-Origin: *");
        if (!$this->session->userdata('currently_logged_in'))   
        {  
           
        $result['message']="";
        $this->template->set('title', 'Login');
        $this->template->load('login_layout', 'contents' , 'login/login', $result);
        }

	}

    private function generateRandomId($length){
      return  substr(md5(time()), 0, $length);
    }

    public function createannotation(){
        header("Access-Control-Allow-Origin: *");
        $json = file_get_contents('php://input');
        
        $json = json_decode($json,false, 512, JSON_UNESCAPED_UNICODE);
        $json->id = $this->generateRandomId(40);
        //update elastic
        $elastic = new ElasticSearch();
		$dataToUpdate = $elastic->get('_doc',$json->bookId);

        //aggiorno db per tag e bibliografia
        $tags = json_decode($json->tags);
        $biblio = json_decode($json->biblio);

        if(count($biblio)>0){
            for($jBi=0; $jBi<count($biblio); $jBi++){
                $data = array(  
                    'id_book'  => $json->bookId,  
                    'id_biblio'   => $biblio[$jBi]->id,  
                    'id_annotation' => $json->id
                    );  
                    //if (count($res->result())== 0) {
            
            
                        //insert data into database table.  
                    $this->db->insert('biblio_relationship',$data);  
                   // }
                }
        }
        for($i=0; $i<count($tags); $i++){
            if(count($biblio)>0){
            for($j=0; $j<count($biblio); $j++){
                $data = array(  
                    'id_tag'     => $tags[$i]->id,  
                    'id_book'  => $json->bookId,  
                    'id_biblio'   => $biblio[$j]->id,  
                    'id_annotation' => $json->id
                    );  
                    //if (count($res->result())== 0) {
            
            
                        //insert data into database table.  
                    $this->db->insert('tag_relationship',$data);  
                   // }
                }
        } else {
            
            $data = array(  
                'id_tag'     => $tags[$i]->id,  
                'id_book'  => $json->bookId,  
                'id_annotation' => $json->id
                );  
            $res = $this->db->query(' select * from tag_relationship
            where id_tag='.$tags[$i]->id.' and id_book='. $json->bookId.' and id_annotation="'.$json->id.'"');
             

        
            if (count($res->result())== 0) {
            
            
                //insert data into database table.  
            $this->db->insert('tag_relationship',$data); 

           
            }
        }
        }
        

        array_push($dataToUpdate["_source"]["annotations"]["rows"], $json);
            $elastic->updateAll($json->bookId, 'POST', $dataToUpdate["_source"]);
            echo json_encode($json);
       
    }

   
    public function createamultiplennotation(){
        header("Access-Control-Allow-Origin: *");
        $json = file_get_contents('php://input');
        $json = json_decode($json);
        $elastic = new ElasticSearch();
		
        
        foreach($json as $jsonBooks){
        $dataToUpdate = $elastic->get('_doc',$jsonBooks->bookId);
       
       foreach($jsonBooks->elements as $js){
       
        $js->id = $this->generateRandomId(40);
        //update elastic
        
        
        
        //aggiorno db per tag e bibliografia
        $tags = json_decode($js->tags);
        $biblio = json_decode($js->biblio);
        
        for($i=0; $i<count($tags); $i++){
            if(count($biblio)>0){
            for($j=0; $j<count($biblio); $j++){
                $data = array(  
                    'id_tag'     => $tags[$i]->id,  
                    'id_book'  => $js->bookId,  
                    'id_biblio'   => $biblio[$j]->id,  
                    'id_annotation' => $js->id
                    );  
                    //if (count($res->result())== 0) {
            
            
                        //insert data into database table.  
                    $this->db->insert('tag_relationship',$data);  
                   // }
                }
        } else {
            
            $data = array(  
                'id_tag'     => $tags[$i]->id,  
                'id_book'  => $js->bookId,  
                'id_annotation' => $js->id
                );  
            $res = $this->db->query(' select * from tag_relationship
            where id_tag='.$tags[$i]->id.' and id_book='. $js->bookId.' and id_annotation="'.$js->id.'"');
             

        
            if (count($res->result())== 0) {
                //insert data into database table.  
            $this->db->insert('tag_relationship',$data);  
           
            }
        }
        
        }
        
        array_push($dataToUpdate["_source"]["annotations"]["rows"], $js);
    }
    
    $elastic->updateAll($jsonBooks->bookId, 'POST', $dataToUpdate["_source"]);
    
}
            echo json_encode($json);
       
    }

    public function deleteannotation(){
        header("Access-Control-Allow-Origin: *");
        $json = file_get_contents('php://input');
        $json = json_decode($json);
        $elastic = new ElasticSearch();

        $dataToUpdate = $elastic->get('_doc',$json->bookId);

        //update elastic
        
       
       
        $annotations = $dataToUpdate["_source"]["annotations"]["rows"];
       $indexToRemove = -1;
        for($i=0; $i<count($annotations); $i++){
            if($annotations[$i]["id"] == $json->id){
                //remove
                $indexToRemove = $i;
                $i = count($annotations);
                
                
                
            }
        }
        unset($annotations[$indexToRemove]);
        $annotations = array_values($annotations);

        $dataToUpdate["_source"]["annotations"]["rows"] = $annotations;
       /* array_push($dataToUpdate["_source"]["annotations"]["rows"], $json);
        */
        $elastic->updateAll($json->bookId, 'POST', $dataToUpdate["_source"]);
        $query = "delete from tag_relationship where id_annotation = '".$json->id."'";
        $this->db->query($query);
        echo json_encode($json);
    }


    public function updateannotation(){
        header("Access-Control-Allow-Origin: *");
        $json = file_get_contents('php://input');
        $json = json_decode($json);
       
        //update elastic
        
        $elastic = new ElasticSearch();
 		$dataToUpdate = $elastic->get('_doc',$json->bookId);
       
        $annotations = $dataToUpdate["_source"]["annotations"]["rows"];
       
        for($i=0; $i<count($annotations); $i++){
            if($annotations[$i]["id"] == $json->id){
                //remove
                
                $annotations[$i] = $json;
                
            }
        }
        $dataToUpdate["_source"]["annotations"]["rows"] = $annotations;
       /* array_push($dataToUpdate["_source"]["annotations"]["rows"], $json);
        */
        $elastic->updateAll($json->bookId, 'POST', $dataToUpdate["_source"]);
        //aggiorno db per tag e bibliografia
        $tags = json_decode($json->tags);
        $biblio = json_decode($json->biblio);
        $query = "delete  from tag_relationship where id_annotation = '".$json->id."'";
        $this->db->query($query);
        for($i=0; $i<count($tags); $i++){
            if(count($biblio)>0){
            for($j=0; $j<count($biblio); $j++){
                $data = array(  
                    'id_tag'     => $tags[$i]->id,  
                    'id_book'  => $json->bookId,  
                    'id_biblio'   => $biblio[$j]->id,  
                    'id_annotation' => $json->id
                    );  
            
            
                        //insert data into database table.  
                    $this->db->insert('tag_relationship',$data);  
                    
                }
        } else {
            
            $data = array(  
                'id_tag'     => $tags[$i]->id,  
                'id_book'  => $json->bookId,  
                'id_annotation' => $json->id
                );  
            $res = $this->db->query(' select * from tag_relationship
            where id_tag='.$tags[$i]->id.' and id_book='. $json->bookId.' and id_annotation="'.$json->id.'"');
             

        
            if (count($res->result())== 0) {
            
            
                //insert data into database table.  
            $this->db->insert('tag_relationship',$data);  
            }
        }
        }
        echo json_encode($json);
    }


    public function loadAnnotations(){
        $bookId = $_GET['book_id'];
        $elastic = new ElasticSearch();
		$annotationList = $elastic->get('_doc',$bookId);
        $annotationsList = $annotationList["_source"]["annotations"]["rows"];
        $result = new stdClass();
        $result->total = count($annotationsList);
        $result->rows = $annotationsList;
        echo json_encode($result);
    }

    public function searchannotation(){
        header("Access-Control-Allow-Origin: *");
        
        echo json_encode(['id'=>1]);
    }

}

