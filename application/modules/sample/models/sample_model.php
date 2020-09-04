<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sample_model extends Base_Model
{

    protected $table = TBL_SAMPLES;
    public $_record_count;
    
    public function get_sample_detail_by_id()
    {
        $type_check = custom_filter_input('integer', $this->id);
        $query = $this->db->get_where($this->table, array('id' => $this->id));
        return $query->row_array();
    }

    public function get_base_model_variable_val()
    {
        return $this->base_model_val();
    }

    public function get_all_data()
    {

       
        if(isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
           $this->db->limit($this->record_per_page, $this->offset);
        }  
        $this->db->select('u.*');
        $this->db->from($this->table . ' AS u');
        $query = $this->db->get();
        if(isset($this->_record_count) && $this->_record_count == true)
        {
            return count($this->db->custom_result($query));
        }
        else
        {
            return $this->db->custom_result($query);
        }   
        
    }

   

    public function get_grid_data($request_data)
    {
        try
        {
            if(!isset($request_data['page']) || $request_data['page'] == '')
            {
                $request_data['page'] = 1;
            }
            if(!isset($request_data['rows']) || $request_data['rows'] == '')
            {
                $request_data['rows'] = 5;
            }
            
            $page = $request_data['page']; // get the requested page
            $limit = $request_data['rows']; // get how many rows we want to have into the grid
            
            $totalrows = isset($request_data['totalrows']) ? $request_data['totalrows'] : false;
            if ($totalrows)
            {
                $limit = $totalrows;
            }

            $this->db->select("*", false);
            $this->db->from(TBL_SAMPLES.' s');
            $total_rows = $this->db->get()->result();

            $count = count($total_rows);
            $response = new stdClass();
            if ($count > 0)
            {
                $total_pages = ceil($count / $limit);
            }
            else
            {
                $total_pages = 0;
            }
            if ($page > $total_pages)
            {
                $page = $total_pages;
            }
            if ($limit <= 0)
            {
                $limit = 0;
            }
            $start = $limit * $page - $limit;
            if ($start <= 0)
            {
                $start = 0;
            }
            $response->page = $page;
            $response->total = $total_pages;
            $response->records = $count;
            $response->start = $start;
            $response->limit = $limit;

            $eligible_rows = array_slice($total_rows, $start, $limit);

            $i = 0;
            foreach ($eligible_rows as $row)
            {
                $response->rows[$i]['id'] = $row->id;
                $response->rows[$i++]['cell'] = array($row->id, $row->title, $row->description);
            }
            return $response;
        }
        catch (Exception $e)
        {
            $this->handle_exception($e);
        }
    }

}