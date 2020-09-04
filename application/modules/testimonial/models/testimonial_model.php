<?php

class Testimonial_model extends Base_Model {

    protected $_tbl_testimonial = "testimonial";
    protected $_tbl_categories = TBL_CATEGORIES;
    protected $_tbl_category_modules = TBL_CATEGORY_MODULES;
    protected $_tbl_users = TBL_USERS;
    public $search_term = "";
    public $search_type = "";
    public $sort_by = "";
    public $sort_order = ""; 
    public $category_id = "";
    public $search_category = "";
    public $search_status = "";
    public $date_from="";
    public $date_to=""; 
    function __construct()
    {
            parent::__construct();
    }

    /**
     * Function get_role_listing to fetch all records of roles
     */
    function get_record_listing($language_id)
    {     
       
        
        if($this->search_type == 'person_name'){
             $this->db->like('CONCAT(U.firstname," ",U.lastname)', $this->search_term);
            // $this->db->or_like('U.lastname',strtolower($this->search_term));
        }
        else if($this->search_type == 'company_name'){
             $this->db->like('R.company_name', strtolower($this->search_term));     
        }
        else if($this->search_type == 'testimonial_name'){
             $this->db->like('R.testimonial_name', strtolower($this->search_term));
            
        }
        else if($this->search_type == 'testimonial_slug'){
             $this->db->like('R.testimonial_slug', strtolower($this->search_term));
            
        }
        else if($this->search_type == 'created_on')
        {    
            if($this->date_from!='' && $this->date_to=='')
            {             
                $this->db->where('R.created_on >=',$this->date_from);
                
            }
            if($this->date_from ==''  && $this->date_to!='')
            {             
                $this->db->where('R.created_on <=',$this->date_to);
            }
            if($this->date_from!='' && $this->date_to!='')
            {             
                $this->db->where('R.created_on >=',$this->date_from);
                $this->db->where('R.created_on <=',$this->date_to);
                
            }
        }
        if(isset($this->sort_by) && $this->sort_by != "" && $this->sort_order != "")
        {     
            if($this->sort_by == 'firstname')
            {
                $this->db->order_by('U.'.$this->sort_by, $this->sort_order);  
            }
             elseif($this->sort_by == 'category_name')
            {
                $this->db->order_by('C.title', $this->sort_order);  
            }
            else
            {    
                $this->db->order_by('R.'.$this->sort_by, $this->sort_order); 
            }
        }
        if(isset($this->search_status) && $this->search_status != "")
        {
             $this->db->like("R.is_published", strtolower($this->search_status));   
        }
        if(isset($this->search_category) && $this->search_category != "" && $this->search_category != 0)
        {
             $this->db->like("R.category_id", strtolower($this->search_category));   
        }
        if(isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
           $this->db->limit($this->record_per_page, $this->offset);
        }
        
        $this->db->select('R.*,C.title,l.*,U.*',FALSE);
        $this->db->from($this->_tbl_testimonial.' AS R');
        $this->db->join($this->_tbl_categories . ' as C', 'R.category_id = C.category_id', 'left');
        $this->db->join($this->_tbl_users . ' as U', 'R.created_by = U.id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'R.lang_id = l.id', 'left');
        $this->db->where('C.module_id', '9');
        $this->db->order_by('R.created_on', 'desc');         
        if ($language_id != '') 
        {
            $this->db->where("C.lang_id", $language_id);
            $this->db->where("R.lang_id", $language_id);
        }
        $this->db->where('R.deleted !=','1');    
       
        if ($this->category_id != "") 
        {
            $category_id = explode(",", $this->category_id);
            $this->db->where_in('R.category_id', $category_id);
        }
        if(get_current_section($this) == 'front')
         {
          $this->db->where('R.is_published =','1'); 
         }
        $query  = $this->db->get();              
      // echo $this->db->last_query();
    
        if(isset($this->_record_count) && $this->_record_count == true)
        {
            return count($this->db->custom_result($query));
        }
        else
        {
           return $this->db->custom_result($query);
        }
       
        return $result;
    }
    
    /**
     * Function get_record_by_id to fetch records by testimonial_id
     * @param int $id default = 0
     */
    function get_record_by_id($testimonial_id = 0, $language_id = 1)
    {
       
        $this->db->select('R.*,C.title,l.*,U.*');
        $this->db->from($this->_tbl_testimonial.' AS R');
        $this->db->join($this->_tbl_categories . ' as C', 'R.category_id = C.category_id', 'left');
        $this->db->join($this->_tbl_users . ' as U', 'R.created_by = U.id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'R.lang_id = l.id', 'left');
        $this->db->where('C.module_id', '9');
        
        if ($language_id != '') 
        {
            $this->db->where("C.lang_id", $language_id);
            $this->db->where("R.lang_id", $language_id);
        }
        
        if ($this->category_id != "") 
        {
            $category_id = explode(",", $this->category_id);
            $this->db->where_in('R.category_id', $category_id);
        }
        $this->db->where('R.testimonial_id', $testimonial_id); 
        $this->db->where('R.deleted !=','1');    
         $query  = $this->db->get();              
        //echo $this->db->last_query();
         return $query->row_array();
        
    }
/**
     * Function record_exist check that record avalibale or not
     * @param int $id default = 0
     */
    function record_exist($id = 0, $language_id = 0)
    {
        //Type Casting 
        $id = intval($id);
        
        $this->db->select('*');
        $this->db->from($this->_tbl_testimonial.' AS R');
        $this->db->where('R.testimonial_id  ', $id);
        $this->db->where('R.lang_id', $language_id);
        $result = $this->db->get();
       
        return $result->row_array();
    }
    /**
     * Function save_record to add/update record 
     * @param array $data 
     */
    public function save_record($data_array)
    {
        //Type Casting 
     
        $data['testimonial_id']= $data_array['testimonial_id'];       
        $data['lang_id']= $data_array['language_id'];
        $data['user_id']=$data_array['user_id'];
     
        
        if(isset( $data_array['category_id']) )
        {
            $data['category_id'] = $data_array['category_id'];
        }
        if(isset( $data_array['testimonial_name']) )
        {
            $data['testimonial_name'] = $data_array['testimonial_name'];
        }
        if(isset($data_array['testimonial_slug']) )
        {
            $data['testimonial_slug'] = $data_array['testimonial_slug'];
        }
        if(isset($data_array['testimonial_description']) )
        {
            $data['testimonial_description'] = $data_array['testimonial_description'];
        }
        if(isset( $data_array['testimonial_date']) )
        {
            $data['testimonial_date'] = $data_array['testimonial_date'];
        }
        if(isset($data_array['logo']) )
        {
            $data['logo'] = $data_array['logo'];
        }
        if(isset( $data_array['company_name']) )
        {
            $data['company_name'] = $data_array['company_name'];
        }
        if(isset($data_array['website']) )
        {
            $data['website'] = $data_array['website'];
        }
        if(isset($data_array['position']) )
        {
            $data['position'] = $data_array['position'];
        }
        if(isset( $data_array['video_type']) )
        {
            $data['video_type'] = $data_array['video_type'];
        }
        if(isset($data_array['video_src']) )
        {
            $data['video_src'] = $data_array['video_src'];
        }
        if(isset($data_array['is_published']) )
        {
            $data['is_published'] = $data_array['is_published'];
        }             
        if ($data['testimonial_id'] != 0 &&  $data['testimonial_id']!= "")
        {                            
            if(count($this->record_exist($data['testimonial_id'], $data['lang_id']))>0)
            {           
                   $data['modified_on']=GetCurrentDateTime();
                   $data['modified_by']=$this->session->userdata[get_current_section($this,true)]['user_id'];
                   $this->db->where('lang_id', $data['lang_id']);
                   $this->db->where('testimonial_id', $data['testimonial_id']);
                   $this->db->update($this->_tbl_testimonial, $data);
                  
            }                                    
         else
            {      
                    $data['created_on']=GetCurrentDateTime();
                    $data['created_by']=$this->session->userdata[get_current_section($this,true)]['user_id'];
                    $this->db->insert($this->_tbl_testimonial, $data);
                    $id = $this->db->insert_id();
                    return $id;
            }
    
        
        }
         else
            {         
                    $data['created_on']=GetCurrentDateTime();
                    $data['created_by']=$this->session->userdata[get_current_section($this,true)]['user_id'];
                    $this->db->insert($this->_tbl_testimonial, $data);
                    $id = $this->db->insert_id();
                    return $id;
             }
           
    }
    
    /**
     * Function delete_record to delete record 
     * @param int $id 
     */
    public function delete_record($id)
    {
        //Type Casting 
        $id = intval($id);
        
        $data_array = array('r.deleted'=>'1');
        $this->db->where('r.id', $id);       
        $this->db->set($data_array);
        $this->db->update($this->_tbl_testimonial. ' as r');
        return true;
     
      
    }
    
     /**
     * Function get_last_eve_id to get last testimonial id 
     */
    function get_last_test_id()
    {
        $this->db->select_max('testimonial_id')
                 ->from($this->_tbl_testimonial);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            return $result['testimonial_id'];
        } else
        {
            return 0;
        }
    }
    
     function get_random_record_listing($language_id)
    {
        
        $this->db->select('R.*,C.title,l.*,U.*');
        $this->db->from($this->_tbl_testimonial.' AS R');
        $this->db->join($this->_tbl_categories . ' as C', 'R.category_id = C.category_id', 'left');
        $this->db->join($this->_tbl_users . ' as U', 'R.created_by = U.id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'R.lang_id = l.id', 'left');
        $this->db->where('C.module_id', '9');
        if ($language_id != '') 
        {
            $this->db->where("C.lang_id", $language_id);
            $this->db->where("R.lang_id", $language_id);
        }
        $this->db->where('R.deleted !=','1');
        $this->db->where('R.is_published =','1');
        $this->db->order_by('R.id','RANDOM');
        if ($this->category_id != "") 
        {
            $category_id = explode(",", $this->category_id);
            $this->db->where_in('R.category_id', $category_id);
        }
        $query  = $this->db->get();              
      
        return $this->db->custom_result($query);
    }

     /**
     * Function inactive_records to inactive records
     * @param array $id
     */
    public function inactive_records($id = array())
    {
        $this->db->set('is_published', 0);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_testimonial);

       // return $id;
        return true;
    }

    /**
     * Function inactive_all_records to inactive all records without deleted records
     */
    public function inactive_all_records($language_id)
    {
        $this->db->set('is_published', 0);
        $this->db->where('is_published !=', 0);
        $this->db->where('lang_id',$language_id);
        $this->db->update($this->_tbl_testimonial);

        return true;
    }

    /**
     * Function active_records to active records
     * @param array $id
     */
    public function active_records($id = array())
    {
        $this->db->set('is_published', 1);
        $this->db->where_in('id', $id);
        $this->db->update($this->_tbl_testimonial);
        return $id;
    }

    /**
     * Function active_all_records to active all records without deleted records
     */
    public function active_all_records($language_id)
    {
        $this->db->set('is_published', 1);
        $this->db->where('is_published !=', 1);
        $this->db->where('lang_id',$language_id);
        $this->db->update($this->_tbl_testimonial);

        return true;
    }

    /**
     * Function delete_records to delete URL
     * @param integer $id
     */
    public function delete_records($id = array())
    {
        $this->db->where_in('id', $id);
        $this->db->set('deleted', '1');
        return $this->db->update($this->_tbl_testimonial);
    } 
    
    /**
     * Function send_mail to send approval mail
     */
    
     public function send_email($data_array)
    {
        $this->load->library('email');

        $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => SMTP_HOST_TEST,
                    'smtp_port' => SMTP_PORT_TEST,
                    'smtp_user' => SMTP_USERNAME_TEST,
                    'smtp_pass' => SMTP_PASSWORD_TEST,
                    'mailtype' => "html"

                );
                
         	$this->email->initialize($config);
		$data_array['username']=$this->session->userdata['front']['firstname']." ".$this->session->userdata['front']['lastname'];
        	$this->email->from($this->session->userdata['front']['email'],$data_array['username']);
                $data_array['created_on']=GetCurrentDateTime();
        $this->email->to('preksha.shah@sparsh.com');
        $this->email->subject('Testimonial');

        $this->email->message($this->load->view("email_template",$data_array,true));
        $this->email->send();
        return true;

    }
    
    // send email for confirmation of testimonial
    
      public function send_confirm_email($data_array)
    {
        $this->load->library('email');
       
        $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => SMTP_HOST_TEST,
                    'smtp_port' => SMTP_PORT_TEST,
                    'smtp_user' => SMTP_USERNAME_TEST,
                    'smtp_pass' => SMTP_PASSWORD_TEST,
                    'mailtype' => "html"

                );
               
         	$this->email->initialize($config);
		$data_array['username']=$this->session->userdata[get_current_section($this,true)]['firstname']." ".$this->session->userdata[get_current_section($this,true)]['lastname'];
        	$this->email->from($this->session->userdata[get_current_section($this,true)]['email'],$data_array['username']);
                $data_array['created_on']=GetCurrentDateTime();
                $this->email->to('khyati.govani@sparsh.com');           
                $this->email->subject('Testimonial');                       
                $this->email->message($this->load->view("confirm_email_template",$data_array,true));
                $this->email->send();
                return true;

    }
    
    
    /**
     * Function get_record_from_id to fetch records by id
     * @param int $id default = 0
     */
    function get_record_from_id($id = 0, $language_id = 1)
    {
       
        $this->db->select('R.*,C.title,l.*,U.*');
        $this->db->from($this->_tbl_testimonial.' AS R');
        $this->db->join($this->_tbl_categories . ' as C', 'R.category_id = C.category_id', 'left');
        $this->db->join($this->_tbl_users . ' as U', 'R.created_by = U.id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'R.lang_id = l.id', 'left');
        $this->db->where('C.module_id', '9');
        
        if ($language_id != '') 
        {
            $this->db->where("C.lang_id", $language_id);
            $this->db->where("R.lang_id", $language_id);
        }
        
        if ($this->category_id != "") 
        {
            $category_id = explode(",", $this->category_id);
            $this->db->where_in('R.category_id', $category_id);
        }
        $this->db->where('R.id', $id); 
        $this->db->where('R.deleted !=','1');    
         $query  = $this->db->get();              
        //echo $this->db->last_query();
         return $query->row_array();
        
    }
       /**
     * Function get_record_by_slug to fetch records by testimonial_id
     * @param string $slug default = 0
     */
    function get_record_by_slug($slug, $language_id)
    {
       
        $this->db->select('R.*,C.title,l.*,U.*');
        $this->db->from($this->_tbl_testimonial.' AS R');
        $this->db->join($this->_tbl_categories . ' as C', 'R.category_id = C.category_id', 'left');
        $this->db->join($this->_tbl_users . ' as U', 'R.created_by = U.id', 'left');
        $this->db->join(TBL_LANGUAGES . ' as l', 'R.lang_id = l.id', 'left');
        $this->db->where('C.module_id', '9');
        
//       
        
        if ($this->category_id != "") 
        {
            $category_id = explode(",", $this->category_id);
            $this->db->where_in('R.category_id', $category_id);
        }
        $this->db->where('R.testimonial_slug', $slug); 
        $this->db->where('R.lang_id', $language_id);         
        $this->db->where('R.deleted !=','1');    
         $query  = $this->db->get();              
        //echo $this->db->last_query();
         return $query->row_array();
        
    }
    
    /**
     * Function get_product_detail_by_slug to fetch detail of records by slug
     */
    public function get_testimonial_detail_by_slug($slug_url)
    {   
        $slug_url = trim(strip_tags($slug_url));
        
        $this->db->select('*')
                ->from($this->_tbl_testimonial)
                ->where(array('testimonial_slug' => $slug_url))
                ->where('deleted !=', 1);

        $query = $this->db->get();

        return $this->db->custom_result($query);
    }
    
    public function check_unique_slug($slug_url, $id ="") {                         
        //Type Casting 
        $slug_url = trim(strip_tags($slug_url));
        $id = intval($id);
        
        $this->db->select('*')
                ->from($this->_tbl_testimonial)
                ->where('testimonial_slug', $slug_url."")
                ->where('deleted !=', 1);
        
        if($id != '0' && $id != '')
        {
            $this->db->where('id !=', $id);
        }
        
        
        $result = $this->db->get();           
        return $this->db->custom_result($result);        
    }

}
?>