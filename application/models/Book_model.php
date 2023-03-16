<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class Book_model extends CI_Model {  
  
    public function find_books($query) {  
  
        $result = [];

        $query = $this->db->query($query);  
        
        $biblio = $this->db->query("select * from biblio"); 
        $result = ["book"=>$query->result_array(),
        "biblio"=>$biblio];
        return $result;
  
    }  

    public function get_all_biblio_by_keyword($keywords){
        $queryBiblio = $this->db->query("select * from biblio where title like '%".$keywords."%'"); 
       
        return $queryBiblio->result_array();
    }

    public function get_all_tags_by_keyword($keywords){
        $queryTags = $this->db->query("select * from tags where tag like '%".$keywords."%'"); 
       
        return $queryTags->result_array();
        
    }

    public function get_all_color(){
         $queryColor = $this->db->query("select * from colors "); 
        $result = [
        "color" => $queryColor->result_array()];
        return $result;
    }

     
    public function get_all_tags_by_query($query){
        //tagexpression è un array formato da keyword da ricercare (in titolo o descrizione)
        // espressione (and/or), frase esatta (true o false)
        $queryTags = $this->db->query($query); 
       
        return $queryTags->result_array();
    }

    public function get_all_biblio_by_query($query){
        //tagexpression è un array formato da keyword da ricercare (in titolo o descrizione)
        // espressione (and/or), frase esatta (true o false)
        $queryBiblio = $this->db->query($query); 
        return $queryBiblio->result_array();
    }

    public function update_annotation($bookid, $annotation){
        
    }
  
      
}  
?>  