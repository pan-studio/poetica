<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class User_model extends CI_Model {  
  
    public function login() {  
  
        $result = [];
        
        
        $this->db->where('mail', $this->input->post('username'));  
        $this->db->where('password', $this->input->post('password'));  

        $query = $this->db->get('users');  
  
        if ($query->num_rows() == 1)  
        {  
            $res = $query->result_array(); 
            $result["user"]=$res[0]; 
            return $result;
         } else {  
            return null;  
        }  
  
    }  
  
    public function get_languages_and_date_info() {  
  
        $resultLanguages = [];

        $queryLanguages = $this->db->query("select * from languages");  
        
        $resultLanguages = $queryLanguages->result_array(); 

        $resultDate = [];

        $queryDate = $this->db->query("select distinct book.year, ((book.year div 100) + 1) as century from languages, book where book.language_id = languages.id");  
        
        $resultDate = $queryDate->result_array();

        $result = ["languages"=>$resultLanguages, "date"=>$resultDate];
        return $result;
  
    } 
      
}  
?>  
