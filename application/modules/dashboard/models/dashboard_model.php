<?php

class Dashboard_model extends Base_Model {

    protected $_tbl_dashboard = "dashboard";
    public $search_term = "";
    public $sort_by = "";
    public $sort_order = ""; 

    function __construct()
    {
            parent::__construct();
    }

    /**
     * Function get_role_listing to fetch all records of roles
     */
    function get_record_listing()
    {
        if(isset($this->search_term) && $this->search_term != "")
        {
            $this->db->like("LOWER(R.name)", strtolower($this->search_term));
        }
        if(isset($this->sort_by) && $this->sort_by != "" && $this->sort_order != "")
        {             
            $this->db->order_by('R.'.$this->sort_by, $this->sort_order); 
        }
        if(isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
           $this->db->limit($this->record_per_page, $this->offset);
        }
        
        $this->db->select('R.*');
        $this->db->from($this->_tbl_dashboard.' AS R');
        $query  = $this->db->get();
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
     * Function get_record_by_id to fetch records by id
     * @param int $id default = 0
     */
    function get_record_by_id($id = 0)
    {
        //Type Casting 
        $id = intval($id);
        
        $this->db->select('*');
        $this->db->from($this->_tbl_dashboard);
        $this->db->where('id', $id);
        $result = $this->db->get();

        return $result->row_array();
    }

    /**
     * Function save_record to add/update record 
     * @param array $data 
     */
    public function save_record($data)
    {
        //Type Casting 
        $id = intval($data['id']);
        
        if ($id != 0 && $id != "")
        {
            $this->db->where('id', $id);
            $this->db->update($this->_tbl_dashboard, $data);
            $id = $id;
        } else
        {
            $this->db->insert($this->_tbl_dashboard, $data);
            $id = $this->db->insert_id();
        }
        return $id;
    }
    
    /**
     * Function delete_record to delete record 
     * @param int $id 
     */
    public function delete_record($id)
    {
        //Type Casting 
        $id = intval($id);
        
        $this->db->where('id', $id);
        return $this->db->delete($this->_tbl_dashboard);
    }
}
?>