<?php

/**
 *  Modulebuilder Controller
 *
 *  To generate new module
 * 
 * @package CIDemoApplication
 * @subpackage Modules
 * @copyright	(c) 2013, TatvaSoft
 * @author panks
 */
class Modulebuilder_admin extends Base_Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        //Logic
        $this->access_control($this->access_rules());

        $this->load->library('form_validation');
        $this->breadcrumb->add(lang('module-management'), base_url() .get_current_section($this). '/modulebuilder/generate_module');
    }

    /**
     * Function for set permission
     * @return array
     */
    private function access_rules()
    {
        return array(
            array(
                'actions' => array('index', 'add', 'delete', 'save', 'generate_module'),
                'users' => array('@'),
            )
        );
    }

    /**
     * Function index to view listing of modules
     */
    public function index()
    {
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->modulebuilder_model->record_per_page = $this->record_per_page;
        $this->modulebuilder_model->offset = $offset;

        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data['search_term']))
            {
                $this->modulebuilder_model->search_term = $data['search_term'];
            }
            if (isset($data['sort_by']) && $data['sort_order'])
            {
                $this->modulebuilder_model->sort_by = $data['sort_by'];
                $this->modulebuilder_model->sort_order = $data['sort_order'];
            }
            if (isset($data['type']) && $data['type'] == 'delete')
            {
                $this->modulebuilder_model->delete_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active')
            {
                $this->modulebuilder_model->active_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'inactive')
            {
                $this->modulebuilder_model->inactive_records($data['ids']);
            }
            if (isset($data['type']) && $data['type'] == 'active_all')
            {
                $this->modulebuilder_model->active_all_records();
            }
            if (isset($data['type']) && $data['type'] == 'inactive_all')
            {
                $this->modulebuilder_model->inactive_all_records();
            }
        }

        //Get module listing data
        $modules = $this->modulebuilder_model->get_module_listing();
        $this->modulebuilder_model->_record_count = true;
        $total_records = $this->modulebuilder_model->get_module_listing();
        // Pass data to view file  
        $data['modules'] = $modules;
        $data['page_number'] = $this->page_number;
        $data['total_records'] = $total_records;
        $data['search_term'] = $this->modulebuilder_model->search_term;
        $data['sort_by'] = $this->modulebuilder_model->sort_by;
        $data['sort_order'] = $this->modulebuilder_model->sort_order;

        //Create page-title
        $this->theme->set('page_title', lang('module-management'));

        //Render view
        $this->theme->view($data);
    }

    /**
     * Function generate_module to select field number
     * @param integer $id default = 0
     */
    public function generate_module()
    {
        if (($this->input->post('count')))
        {
            $count = intval($this->input->post('count'));
            if($count == 0)
            {
                $count = 3;
            }
            redirect(get_current_section($this).'/modulebuilder/add/' . $count);
            exit;
        }

        //Variable Assignment   
        $data['count'] = '';

        //create breadcrumbs & page-title
        $this->theme->set('page_title', lang('generate-module'));
        $this->breadcrumb->add(lang('generate-module'));

        //Render view
        $this->theme->view($data);
    }

    /**
     * Function add to add new module
     * @param integer $count default = 3
     */
    public function add($count = 3)
    {
        //Type Casting 
        $count = intval($count);
        custom_filter_input('integer', $count);

        //Variable Assignment   
        $module_name = (($this->input->post('module_name')) ? $this->input->post('module_name') : '');
        $controller_name = (($this->input->post('controller_name')) ? $this->input->post('controller_name') : '');
        $model_name = (($this->input->post('model_name')) ? $this->input->post('model_name') : '');
        $table_name = (($this->input->post('table_name')) ? $this->input->post('table_name') : '');

        // Pass data to view file 
        $data['module_name'] = trim($module_name);
        $data['controller_name'] = trim($controller_name);
        $data['model_name'] = trim($model_name);
        $data['table_name'] = trim($table_name);
        $data['count'] = $count;
        $data['field_number'] = array($count => $count);


        if ($this->input->post('mysubmit'))
        {
            //Validation rules for URL 
            $this->form_validation->set_rules("module_name", lang('module-name'), 'required|xss_clean|alpha');
            $this->form_validation->set_rules("controller_name", lang('controller-name'), 'required|xss_clean|alpha');
            $this->form_validation->set_rules("model_name", lang('model-name'), 'required|xss_clean|alpha');
            $this->form_validation->set_rules("table_name", lang('table-name'), 'required|xss_clean|alpha');

            for ($i = 1; $i <= $count; $i++)
            {
                $data["field_label{$i}"] = (($this->input->post("field_label{$i}")) ? $this->input->post("field_label{$i}") : '');
                $data["field_name{$i}"] = (($this->input->post("field_name{$i}")) ? $this->input->post("field_name{$i}") : '');
                $data["field_type{$i}"] = (($this->input->post("field_type{$i}")) ? $this->input->post("field_type{$i}") : '');

                //Validation rules for URL 
                $this->form_validation->set_rules("field_label{$i}", lang('label'), 'required|xss_clean');
                $this->form_validation->set_rules("field_name{$i}", lang('name'), 'required|xss_clean');
                $this->form_validation->set_rules("field_type{$i}", lang('type'), 'required|xss_clean');
                $this->form_validation->set_rules("db_length_value{$i}", lang('length-value'), 'required|xss_clean');
            }

            if ($this->form_validation->run())
            {
                $this->module = $module_name;
                $this->controller_name = $controller_name;
                $this->model_name = $model_name;
                $this->table_name = $table_name;

                if (!is_dir(APPPATH . 'modules/' . $this->module))
                {
                    mkdir(APPPATH . 'modules/' . $this->module, 0777);
                    mkdir(APPPATH . 'modules/' . $this->module . '/controllers', 0777);
                    mkdir(APPPATH . 'modules/' . $this->module . '/models', 0777);
                    mkdir(APPPATH . 'modules/' . $this->module . '/views', 0777);
                    mkdir(APPPATH . 'modules/' . $this->module . '/language', 0777);
                    mkdir(APPPATH . 'modules/' . $this->module . '/config', 0777);
                    mkdir(APPPATH . 'modules/' . $this->module . '/language/english', 0777);

                    $model_content = $this->build_model($count);
                    $controller_content = $this->build_controller($count);
                    $language_content = $this->build_language($count);
                    $sql_content = $this->build_sql($count);
                    $view_content = $this->build_view($count);
                    $config_content = $this->build_config($count);
                    $this->modulebuilder_model->create_table($sql_content);
                    
                    $model_file = APPPATH . 'modules/' . $this->module . '/models/' . $this->model_name . '_model.php';
                    $file = fopen($model_file, "w");
                    file_put_contents($model_file, $model_content);
                    fclose($file);
                    
                    $controller_file = APPPATH . 'modules/' . $this->module . '/controllers/' . $this->controller_name . '_admin.php';
                    $file = fopen($controller_file, "w");
                    file_put_contents($controller_file, $controller_content);
                    fclose($file);
                    
                    $view_file = APPPATH . 'modules/' . $this->module . '/views/admin_index.php';
                    $file = fopen($view_file, "w");
                    file_put_contents($view_file, $view_content['index']);
                    fclose($file);
                    
                    $view_file = APPPATH . 'modules/' . $this->module . '/views/admin_add.php';
                    $file = fopen($view_file, "w");
                    file_put_contents($view_file, $view_content['add']);
                    fclose($file);
                    
                    $language_file = APPPATH . 'modules/' . $this->module . '/language/english/' . $this->controller_name . '_lang.php';
                    $file = fopen($language_file, "w");
                    file_put_contents($language_file, $language_content);
                    fclose($file);
                    
                    $config_file = APPPATH . 'modules/' . $this->module . '/config/config.php';
                    $file = fopen($config_file, "w");
                    file_put_contents($config_file, $config_content);
                    fclose($file);
                    
                    $this->theme->set_message(lang('module-add-success'), 'success');
                    redirect(get_current_section($this).'/modulebuilder/add/');
                    exit;
                }
                else
                {
                    $this->theme->set_message(lang('module-already-generated'), 'error');
                    redirect(get_current_section($this).'/modulebuilder/add/');
                    exit;
                }
                exit;
            }
        }
        //create breadcrumbs & page-title
        $this->theme->set('page_title', lang('generate-module'));
        $this->breadcrumb->add(lang('generate-module'));

        //Render view
        $this->theme->view($data, 'admin_add');
    }
    
    /**
     * function build_controller()
     *
     * @access private
     * @param $field_total - integar
     * @return string
     *
     */
    private function build_controller($field_total = NULL)
    {
        if ($field_total == NULL)
        {
            return FALSE;
        }

        $controller = '<?php

class ' . ucfirst($this->controller_name) . '_admin extends Base_Admin_Controller {
               
    function __construct()
    {
        parent::__construct();
                
        //Logic
        $this->access_control($this->access_rules());
        
        $this->load->library(\'form_validation\');
        $this->load->model(\'' . $this->model_name . '_model\');
    }	
    
    /**
     * Function for set permission
     * @return array
     */
    private function access_rules()
    {
        return array(
            array(
                \'actions\' => array(\'index\', \'action\', \'delete\', \'save\', \'view_data\'),
                \'users\' => array(\'@\'),
            )
        );
    }
    
    /**
     * Function index for listing
     * @return array
     */
    function index()
    {
        //Paging parameters
        $offset = get_offset($this->page_number, $this->record_per_page);
        $this->'.$this->model_name.'_model->record_per_page = $this->record_per_page;
        $this->'.$this->model_name.'_model->offset = $offset;
            
        //set sort/search parameters in pagging
        if ($this->input->post())
        {
            $data = $this->input->post();
            if (isset($data[\'search_term\']))
            {
                $this->'.$this->model_name.'_model->search_term = $data[\'search_term\'];
            }
            if (isset($data[\'sort_by\']) && $data[\'sort_order\'])
            {
                $this->'.$this->model_name.'_model->sort_by = $data[\'sort_by\'];
                $this->'.$this->model_name.'_model->sort_order = $data[\'sort_order\'];
            }
        }
        
        //Get role listing data
        $records = $this->'.$this->model_name.'_model->get_record_listing();
        $this->'.$this->model_name.'_model->_record_count = true;
        $total_records = $this->'.$this->model_name.'_model->get_record_listing();
            
        // Pass data to view file  
        $data[\'records\'] = $records;
        $data[\'page_number\'] = $this->page_number;
        $data[\'total_records\'] = $total_records;
        $data[\'search_term\'] = $this->'.$this->model_name.'_model->search_term;
        $data[\'sort_by\'] = $this->'.$this->model_name.'_model->sort_by;
        $data[\'sort_order\'] = $this->'.$this->model_name.'_model->sort_order;
            
        //Render view
        $this->theme->set("page_title", "'.$this->model_name.' List");
        $this->theme->view($data);
            
    }
    
    /**
     * Function action to perform insert & update by action parameter
     * @param string $action default = \'add\'  
     * @param integer $id default = 0
     */
    public function action($action = "add", $id = 0)
    {
        //Type Casting 
        $id = intval($id);
        $action = trim(strip_tags($action));
        custom_filter_input(\'integer\', $id);  
        
        //Variable Assignment';
        // loop to set form validation rules
        $last_field = 0;
        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            // only build on fields that have data entered. 
            //Due to the requiredif rule if the first field is set the the others must be

            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }
            // we set this variable as it will be used to place the comma after the last item to build the insert db array
            $last_field = $counter;

            $controller .= '	
        $'.set_value("field_name{$counter}").' = "";';
        }

        $controller .= '
            
        //Logic
        switch ($action)
        {
            case \'add\':
                break;
            case \'edit\':
                $result = $this->'.$this->model_name.'_model->get_record_by_id($id);
                if (!empty($result))
                {
                    //Variable assignment for edit view';

        // loop to build form data array
        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            //Due to the requiredif rule if the first field is set the the others must be
            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }

            $controller .= '
                    $'.set_value("field_name{$counter}").' = $result[\''.set_value("field_name{$counter}").'\'];';
        }

        $controller .= '
                }
                else
                {
                    redirect(\''.get_current_section($this).'/'.$this->controller_name.'\');
                }
                break;
            default :
                $this->theme->set_message(lang(\'action-not-allowed\'), \'error\');
                redirect(\''.get_current_section($this).'/'.$this->controller_name.'\');
                break;
        }
        
        // Pass data to view file 
        
        $data[\'id\'] = $id;';
        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            //Due to the requiredif rule if the first field is set the the others must be
            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }

            $controller .= '
        $data[\''.set_value("field_name{$counter}").'\'] = $'.set_value("field_name{$counter}").';';
        }


        $controller .= '
					
        //Render view
        $this->theme->set("page_title", "Manage ' .$this->model_name.'");
        $this->theme->view($data, \'admin_add\');
    }
    
    /**
     * Function action to perform insert & update by action parameter
     * @param string $action default = \'add\'  
     * @param integer $id default = 0
     */
    public function save()
    {
        if ($this->input->post(\'mysubmit\'))
        {
            $data = $this->input->post();

            //Type Casting 
            $id = intval($data[\'id\']);

            //Variable Assignment   ';
        
        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            //Due to the requiredif rule if the first field is set the the others must be
            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }
            
            if(set_value("field_type{$counter}") != 'checkbox')
            {
                $controller .= '
            $'.set_value("field_name{$counter}").' = trim($data[\''.set_value("field_name{$counter}").'\']);';
            }
            else
            {
                $controller .= '
            $'.set_value("field_name{$counter}").' = $data[\''.set_value("field_name{$counter}").'\'];';
            }
        }
        
        // loop to set form validation rules
        $last_field = 0;
        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            // only build on fields that have data entered. 
            //Due to the requiredif rule if the first field is set the the others must be

            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }
            // we set this variable as it will be used to place the comma after the last item to build the insert db array
            $last_field = $counter;

            $controller .= '			
            $this->form_validation->set_rules(\'' . set_value("field_name{$counter}") . '\', \'' . set_value("field_label{$counter}") . '\', \'';

            // set a friendly variable name
            $validation_rules = NULL;

            if (isset($_POST["validation_rules{$counter}"]))
            {
                $validation_rules = $_POST["validation_rules{$counter}"];
            }
            
            // rules have been selected for this fieldset
            $rule_counter = 0;

            if (is_array($validation_rules))
            {
                // add rules such as trim|required|xss_clean
                foreach ($validation_rules as $key => $value)
                {
                    if ($rule_counter > 0)
                    {
                        $controller .= '|';
                    }

                    $controller .= $value;
                    $rule_counter++;
                }
            }

            if (set_value("db_length_value{$counter}") != NULL)
            {
                if ($rule_counter > 0)
                {
                    $controller .= '|';
                }

                $controller .= 'max_length[' . set_value("db_length_value{$counter}") . ']';
            }

            $controller .= "');";
        }

        $controller .= '
			
            if ($this->form_validation->run())
            {
                $data_array = array(
                \'id\' => $id,';

        // loop to build form data array
        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            //Due to the requiredif rule if the first field is set the the others must be
            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }

            $controller .= '
                    \'' . set_value("field_name{$counter}") . '\' => $'.set_value("field_name{$counter}").'';

            if ($counter != $last_field)
            {
                // add the comma in
                $controller .= ',';
            }
        }

        $controller .= '
                    );';

        $controller .= '
					
                // run insert model to write data to db
                $lastId = $this->' . $this->model_name . '_model->save_record($data_array);

                if ($id == 0)
                {
                    $this->theme->set_message(lang(\'record-add-success\'), \'success\');
                }
                else
                {
                    $this->theme->set_message(lang(\'record-edit-success\'), \'success\');
                }

                redirect(\''.get_current_section($this).'/'.$this->controller_name.'\');
                exit;
            }
        }
        else
        {';
        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            //Due to the requiredif rule if the first field is set the the others must be
            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }

            $controller .= '
            $'.set_value("field_name{$counter}").' = "";';
        }
    $controller .= '
        }
    
        // Pass data to view file';  
    for ($counter = 1; $field_total >= $counter; $counter++)
    {
        //Due to the requiredif rule if the first field is set the the others must be
        if (set_value("field_label{$counter}") == NULL)
        {
            continue;  // move onto next iteration of the loop
        }

        $controller .= '
        $data[\''.set_value("field_name{$counter}").'\'] = $'.set_value("field_name{$counter}").';';
    }

    $controller .= 
        '
        
        //create breadcrumbs & page-title
        if ($id == \'\')
        {
            $this->theme->set(\'page_title\', lang(\'add-record\'));
            $this->breadcrumb->add(lang(\'add-record\'));
        }
        else
        {
            $this->theme->set(\'page_title\', lang(\'edit-record\'));
            $this->breadcrumb->add(lang(\'edit-record\'));
        }
        
        //Render view
        $this->theme->view($data, \'admin_add\');
    }
    
    /**
     * Function delete to Role (Ajax-Post)
     */
    function delete()
    {
        $data = $this->input->post();
        $id = intval($data[\'id\']);

        $result = $this->'.$this->model_name.'_model->get_record_by_id($id);
        if (!empty($result))
        {
            $res = $this->'.$this->model_name.'_model->delete_record($id);
            if ($res)
            {
                $message = $this->theme->message(lang(\'record-delete-success\'), \'success\');
            }
        }
        else
        {
            $message = $this->theme->message(lang(\'invalid-id-msg\'), \'error\');
        }

        //message
        echo $message;
    }
}
?>';
        return $controller;
    }

    /**
     * Function build_model to generate model file
     * @access private
     * @param integer $field_total default = NULL
     */
    private function build_model($field_total = NULL)
    {
        if ($field_total == NULL)
        {
            return FALSE;
        }
        $model = '<?php

class ' . ucfirst($this->model_name) . '_model extends Base_Model {

    protected $_tbl_' . $this->table_name . ' = "'.$this->table_name.'";
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
            $this->db->like("LOWER(R.'.set_value("field_name1").')", strtolower($this->search_term));
        }
        if(isset($this->sort_by) && $this->sort_by != "" && $this->sort_order != "")
        {             
            $this->db->order_by(\'R.\'.$this->sort_by, $this->sort_order); 
        }
        if(isset($this->record_per_page) && isset($this->offset) && !isset($this->_record_count) && $this->_record_count != true)
        {
           $this->db->limit($this->record_per_page, $this->offset);
        }
        
        $this->db->select(\'R.*\');
        $this->db->from($this->_tbl_'.$this->table_name.'.\' AS R\');
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
        
        $this->db->select(\'*\');
        $this->db->from($this->_tbl_'.$this->table_name.');
        $this->db->where(\'id\', $id);
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
        $id = intval($data[\'id\']);
        
        if ($id != 0 && $id != "")
        {
            $this->db->where(\'id\', $id);
            $this->db->update($this->_tbl_'.$this->table_name.', $data);
            $id = $id;
        } else
        {
            $this->db->insert($this->_tbl_'.$this->table_name.', $data);
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
        
        $this->db->where(\'id\', $id);
        return $this->db->delete($this->_tbl_'.$this->table_name.');
    }
}
?>';
        return $model;
    }
    

    /**
     * function build_view to generate view file
     * @access private
     * @param $field_total - integar
     * @return string
     *
     */
        private function build_view($field_total = NULL) {
        if ($field_total == NULL) {
            return FALSE;
        }

        $view['index'] = '<div class="contentpanel">
    <div class="panel panel-default form-panel">
        <div class="panel-body">  
                <div class="row row-pad-5"> 
                    <div class="col-lg-3 col-md-3">
                        <?php
                    $input_data = array(
                        \'name\' => \'search_term\',
                        \'id\' => \'search_term\',
                        \'value\' => set_value(\'search_term\', urldecode($search_term)),
                        \'placeholder\' => \'Search\',
                        \'class\' => \'form-control\'
                    );
                    echo form_input($input_data);
                    ?>
                    </div>               
                    <div class="col-lg-3 col-md-3">
                        <?php
                    $search_button = array(
                        \'content\' => "<i class=\'fa fa-search\'></i> &nbsp;".lang(\'btn-search\'),
                        \'title\' => lang(\'btn-search\'),
                        \'class\' => \'btn btn-primary\',
                        \'onclick\' => "submit_search()",
                    );
                    echo form_button($search_button);
                    ?>
                        <?php
                    $reset_button = array(
                        \'content\' => "<i class=\'fa fa-refresh\'></i> &nbsp;".lang(\'btn-reset\'),
                        \'title\' => lang(\'btn-reset\'),
                        \'class\' => \'btn btn-default btn-reset\',
                        \'onclick\' => "reset_data()",
                    );
                    echo form_button($reset_button);
                    ?>
                        
                    </div>
                </div>  
        </div>
    </div>
    <div class="row">        
        <div class="col-md-12">
            <div class="panel-header clearfix">
                <span style="float: left;"><?php echo add_image(array(\'active.png\')) . " " . lang(\'active\') . " &nbsp;&nbsp;&nbsp; " . add_image(array(\'inactive.png\')) . " " . lang(\'inactive\') . ""; ?></span>
                
                <?php echo anchor(site_url() . \'' . get_current_section($this) . '/' . $this->controller_name . '/action/add\', lang(\'add-record\'), \'title="Add Record" class="add-link" \'); ?>

            </div>
            <div class="panel table-panel">
                <div class="panel-body">
                    <?php
                            $querystr = $this->_ci->security->get_csrf_token_name() . \'=\' . urlencode($this->_ci->security->get_csrf_hash()) . \'&search_term=\' . urlencode($search_term) . \'&sort_by=\' . $sort_by . \'&sort_order=\' . $sort_order . \'\';
                    ?>
                       <?php
                    if (!empty($records)) {
                        ?>
                        <div class="table-responsive">          		
                            <table class="table table-hover gradienttable">
                                <thead>
                                    <tr>
                                        <th>
                                <div class="ckbox ckbox-default">
                                    <input type="checkbox" name="check_all" id="check_all" value="0" />
                                    <label for="check_all"></label>
                                </div>
                                </th>
                                <th><?php echo lang(\'no\') ?></th>';

        for ($counter = 1; $field_total >= $counter; $counter++) {
            $view['index'].= '<th>
                                <?php
                                $field_sort_order = \'asc\';
                                $sort_image = \'<i class="fa fa-chevron-down" style="color: #FFF"></i>\';
                                if ($sort_by == \'' . set_value("field_name{$counter}") . '\' && $sort_order == \'asc\')
                                {
                                    $sort_image = \'<i class="fa fa-chevron-up" style="color: #FFF"></i>\';
                                    $field_sort_order = \'desc\';
                                }
                                ?>
                                <a href="javascript:;" class="wht-fnt" onclick="sort_data(\'' . set_value("field_name{$counter}") . '\', \'<?php echo $field_sort_order; ?>\');" >
                                    ' . set_value("field_label{$counter}") . '
                                    <?php
                                    if ($sort_by == \'' . set_value("field_name{$counter}") . '\')
                                    {
                                        echo "&nbsp;&nbsp;".$sort_image;
                                    }
                                    ?>
                                </a>     
                            </th>';
        }
        $view['index'].= '
                            <th><?php echo lang(\'actions\') ?></th>
                        </tr>
                    </thead> 
                    
                        <tbody>

                                    <?php
                                    if ($page_number > 1) {
                                        $i = ($this->_ci->session->userdata[get_section($this->_ci)][\'record_per_page\'] * ($page_number - 1)) + 1;
                                    }
                                    else
                                    {
                                        $i = 1;
                                    }

                                    foreach ($records as $record) {?>


                                        <tr>
                                            <td>
                                                <div class = "ckbox ckbox-default">
                                                        <input type="checkbox" id="<?php echo $record[\'R\'][\'id\']; ?>" name="check_box[]" class="check_box" value="<?php echo $record[\'R\'][\'id\']; ?>">
                                                        <label for="<?php echo $record[\'R\'][\'id\']; ?>"></label>            
                                                </div>                                      
                                            </td>
                                            
                                            <td><?php echo $i; ?></td>';

        for ($counter = 1; $field_total >= $counter; $counter++) {
            $view['index'].= '<td><?php echo $record[\'R\'][\'' . set_value("field_name{$counter}") . '\']; ?></td>';
        }
        $view['index'].= '
                                <td>
                                    <?php $record_id = $record[\'R\'][\'id\']; ?>
                                    <a class="mr5" href="<?php echo site_url(); ?>' . get_current_section($this) . '/' . $this->controller_name . '/action/edit/<?php echo $record_id ?>" title="<?php echo lang(\'edit\') ?>"><i class="fa fa-pencil"></i></a>
                                        
                                    <a class="delete-row" href="javascript:;" onclick=\'delete_record("<?php echo $record_id ?>")\' title=\'Delete\'><i class="fa fa-trash-o"></i></a>                                                                                             
                                </td>
                            </tr>
                        <?php
                        $i++;
                        }
                        
                        echo form_hidden(\'search_text\', (isset($search_text)) ? $search_text : \'\' );
                        echo form_hidden(\'page_number\', "", "page_number");
                        echo form_hidden(\'per_page_result\', "", "per_page_result");
                       
                        ?>

</tbody>


</table>
</div>
<?php
} else {
echo lang(\'no-records\');
                            }
                        
        
        $options = array(
            \'total_records\' => $total_records,
            \'page_number\' => $page_number,
            \'isAjaxRequest\' => 1,
            \'base_url\' => base_url() . "' . get_current_section($this) . '/' . $this->controller_name . '/index",
            \'params\' => $querystr,
            \'element\' => \'ajax_table\'
        );

        widget(\'custom_pagination\', $options);  
        ?>
    
                </div>
            </div>
        </div>
    </div>
</div>
        

<script type="text/javascript">	    
    //remove dynamically populate error
    $("#search_term").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                submit_search();
            }
    });
    function attach_error_event(){
        $(\'div.formError\').bind(\'click\',function(){
            $(this).fadeOut(1000, removeError); 
        });
    }    
    function removeError() 
    {
        jQuery(this).remove();
    }
    
    $(function () {
        $("#check_all").click(function () {
            if ($("#check_all").is(\':checked\')) {
                $(".check_box").prop("checked", true);
            } else {
                $(".check_box").prop("checked", false);
            }
        });
        $(".check_box").click(function(){

            if($(".check_box").length == $(".check_box:checked").length) {
                $("#check_all").prop("checked", true);
                $(".check_box").attr("checked", "checked");
            } else {
                $("#check_all").removeAttr("checked");
            }

        });
    });
    
    

    function delete_record(id){        
        res = confirm(\'<?php echo lang(\'delete-alert\') ?>\');    
        if(res){
            $.ajax({
                type:\'POST\',
                url:\'<?php echo base_url(); ?>' . get_current_section($this) . '/' . $this->controller_name . '/delete\',
                data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:\'<?php echo $this->_ci->security->get_csrf_hash(); ?>\',id:id},
                success: function(data) {
                    //for managing same state while record delete
                    if($(\'.rows\') && $(\'.rows\').length > 1){
                        pageno = "&page_number=<?php echo $page_number; ?>";                        
                    }else{
                        pageno = "&page_number=<?php echo $page_number - 1; ?>";                        
                    }                    
                    ajaxLink(\'<?php echo base_url(); ?>' . get_current_section($this) . '/' . $this->controller_name . '/index\',\'ajax_table\',\'<?php echo $querystr; ?>\'+pageno);
                    
                    //set responce message                    
                    $("#messages").show();
                    $("#messages").html(data);                                                
                }
            });              
            
        }else{
            return false;
        }
    }
    
    function submit_search()
    {            
        $(\'#error_msg\').fadeOut(1000); //hide error message it shown up while search
        if($(\'#search_term\').val() == \'\'){
            $(\'#search_term\').validationEngine(\'showPrompt\', \'<?php echo lang(\'msg-search-req\'); ?>\', \'error\');
            attach_error_event(); //for remove dynamically populate popup
            return false;
        }        
        blockUI();
        $.ajax({
            type:\'POST\',
            url:\'<?php echo base_url(); ?>' . get_current_section($this) . '/' . $this->controller_name . '/index\',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:\'<?php echo $this->_ci->security->get_csrf_hash(); ?>\',search_term:encodeURIComponent($(\'#search_term\').val())},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();  
            }
        }); 
             
    }
    
    function sort_data(sort_by,sort_order)
    {
        $(\'#error_msg\').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type:\'POST\',
            url:\'<?php echo base_url(); ?>' . get_current_section($this) . '/' . $this->controller_name . '/index\',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:\'<?php echo $this->_ci->security->get_csrf_hash(); ?>\',search_term:encodeURIComponent($(\'#search_term\').val()),sort_by:sort_by,sort_order:sort_order},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        }); 
        
    }
    function reset_data()
    {
        $(\'#error_msg\').fadeOut(1000); //hide error message it shown up while search
        blockUI();
        $.ajax({
            type:\'POST\',
            url:\'<?php echo base_url(); ?>' . get_current_section($this) . '/' . $this->controller_name . '/index\',
            data:{<?php echo $this->_ci->security->get_csrf_token_name(); ?>:\'<?php echo $this->_ci->security->get_csrf_hash(); ?>\',search_term:""},
            success: function(data) {
                $("#ajax_table").html(data);
                unblockUI();
            }
        });         
    }
    
</script>
';




// Add / Edit Template File ........................             



        $view['add'] = '<div class="contentpanel">
      
    <div class="panel-header clearfix">
    
        <?php echo anchor(site_url() . \'' . get_current_section($this) . '/' . $this->controller_name . '\', lang(\'view-all-records\'), \'title="View All Records" class="add-link" \'); ?>

    </div>
    
      <div class="panel panel-default">    
            <div class="panel-heading">  <h4 class="panel-title"><?php echo lang(\'add-edit-record\') ?></h4></div>
            
            <?php echo form_open_multipart(\'' . get_current_section($this) . '/' . $this->controller_name . '/save\', array(\'id\' => \'saveform\', \'name\' => \'saveform\', \'class\' => \'form-horizontal form-bordered\')); ?>
            
            <div class="panel-body panel-body-nopadding">
            <?php
                    $id = ((isset($id)) ? $id : 0); ?>';
        for ($counter = 1; $field_total >= $counter; $counter++) {
            $field_label = set_value("field_label{$counter}");
            $field_name = set_value("field_name{$counter}");
            $field_type = set_value("field_type{$counter}");

            $validation_rules = '';
            $span = '';
            if (in_array("required", $_POST["validation_rules{$counter}"])) {
                // $validation_rules = "validate[required]";
                $validation_rules = "";
                $span = '<span class="asterisk">&nbsp;*</span>';
            }

            switch ($field_type) {
                case('input'):
                    $view['add'].= '<?php $' . $field_name . '_data = array(
                                                \'name\' => \'' . $field_name . '\',
                                                \'id\' => \'' . $field_name . '\',
                                                \'value\' => set_value(\'' . $field_name . '\', ((isset($' . $field_name . ')) ? $' . $field_name . ' : \'\')),
                                                \'class\' => \'form-control ' . $validation_rules . '\'
                                            );?>';

                    $view['add'].= '<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo form_label(\'' . $field_label . '\', \'' . $field_name . '\'); ?>  ' . $span . '</label>
                <div class="col-sm-6">
                    
                    <?php echo form_input($' . $field_name . '_data); ?>
                    <span class="validation_error"><?php echo form_error(\'' . $field_name . '\'); ?></span>
                    </div>
                </div>';
                    break;

                case('textarea'):
                    $view['add'].= '<?php $' . $field_name . '_data = array(
                                                \'name\' => \'' . $field_name . '\',
                                                \'id\' => \'' . $field_name . '\',
                                                \'value\' => set_value(\'' . $field_name . '\', ((isset($' . $field_name . ')) ? $' . $field_name . ' : \'\')),
                                                \'class\' => \'form-control ' . $validation_rules . '\'
                                            );?>';

                    $view['add'].= '<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo form_label(\'' . $field_label . '\', \'' . $field_name . '\'); ?>  ' . $span . '</label>
                <div class="col-sm-6">
                    
                    <?php echo form_textarea($' . $field_name . '_data); ?>
                    <span class="validation_error"><?php echo form_error(\'' . $field_name . '\'); ?></span>
                    </div>
                </div>';
                    break;

                case('select'):
                    $view['add'].= '<?php $' . $field_name . '_data = array(
                                            \'\' => \'Select\'
                                            );?>';

                    $view['add'].= '<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo form_label(\'' . $field_label . '\', \'' . $field_name . '\'); ?>  ' . $span . '</label>
                <div class="col-sm-6">
                    
                    <?php echo form_dropdown(\'' . $field_name . '\',$' . $field_name . '_data, $' . $field_name . ',\'class="form-control ' . $validation_rules . '"\'); ?>
                    <span class="validation_error"><?php echo form_error(\'' . $field_name . '\'); ?></span>
                    </div>
                </div>';
                    break;

                case('radio'):
                    $view['add'].= '<?php $selected = \'\';
                                    $' . $field_name . ' = ((isset($' . $field_name . ')) ? $' . $field_name . ' : \'0\');
                                    if ($' . $field_name . ' != \'0\')
                                    {
                                        $selected = \'checked="checked"\';
                                    }
                                    ?>';

                    $view['add'].= '<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo form_label(\'' . $field_label . '\', \'' . $field_name . '\'); ?>  ' . $span . '</label>
                <div class="col-sm-6">
                    
                    <?php echo form_radio(\'' . $field_name . '\', \'1\', $selected); ?>
                    <label for="M">' . $field_label . '</label>
                    <span class="validation_error"><?php echo form_error(\'' . $field_name . '\'); ?></span>
                    </div>
                </div>';
                    break;

                case('checkbox'):
                    $view['add'].= '<?php $selected = FALSE;
                                    $' . $field_name . ' = ((isset($' . $field_name . ')) ? $' . $field_name . ' : \'\');
                                    if ($' . $field_name . ' != \'\')
                                    {
                                        $selected = TRUE;
                                    }
                                    ?>';

                    $view['add'].= '<div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo form_label(\'' . $field_label . '\', \'' . $field_name . '\'); ?>  ' . $span . '</label>
                <div class="col-sm-6">
                    
                    <?php echo form_checkbox(\'' . $field_name . '\', \'1\',$selected,\'class="' . $validation_rules . '"\'); ?> <label>' . $field_label . '</label>
                    <span class="validation_error"><?php echo form_error(\'' . $field_name . '\'); ?></span>
                    </div>
                </div>';
                    break;
            }
        }
        $view['add'] .= '</div>
            
            <div class="panel-footer" style="display: block;">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <?php
                    $submit_button = array(
                        \'name\' => \'mysubmit\',
                        \'id\' => \'mysubmit\',
                        \'value\' => lang(\'btn-save\'),
                        \'title\' => lang(\'btn-save\'),
                        \'class\' => \'btn btn-primary\',
                        \'type\' => \'submit\',
                        \'content\' => \'<i class="fa fa-save"></i> &nbsp; Save\'
                    );
                    echo form_button($submit_button);
                    ?>
                    &nbsp;
                    <?php
                    $cancel_button = array(
                        \'name\' => \'cancel\',
                        \'content\' => \'<i class="fa fa-hand-o-left"></i> &nbsp; Cancel\',
                        \'value\' => lang(\'btn-cancel\'),
                        \'title\' => lang(\'btn-cancel\'),
                        \'class\' => \'btn btn-default\',
                        \'onclick\' => "location.href=\'" . site_url(\'' . get_current_section($this) . '/' . $this->controller_name . '\') . "\'",
                    );
                    echo "&nbsp;";
                    echo form_button($cancel_button);
                    ?>
                    
                </div>
            </div>
        </div>
        
        <?php
            echo form_hidden(\'id\', (isset($id)) ? $id : \'0\' );
            echo form_close();
        ?>

      </div>
      
 </div>
<script type="text/javascript">
    $(document).ready(function() {
        $(\'#saveform\').bootstrapValidator({
            fields: {';
            
            for ($counter = 1; $field_total >= $counter; $counter++) {
                if (in_array("required", $_POST["validation_rules{$counter}"])) {
                $field_label = set_value("field_label{$counter}");
                $field_name = set_value("field_name{$counter}");
                ?>
                <?php $view['add'] .= $field_name. ': {
                    message: \'The '.$field_label.' field is required.\',
                    validators: {
                        notEmpty: {
                            message: \'The '. $field_label.' field is required.\'
                        }
                    }
                },';
		}
            }
            
            $view['add'] .= '}
        });
    });
</script>';
        return $view;
    }
    
    /**
     * Function build_language to generate language file
     * @access private 
     */
    private function build_language()
    {
        $language = '<?php
if ( ! defined(\'BASEPATH\')) exit(\'No direct script access allowed\');

$lang[\'btn-search\'] = \'Search\';
$lang[\'btn-reset\'] = \'Reset\';
$lang[\'btn-save\'] = \'Save\';
$lang[\'btn-cancel\'] = \'Cancel\';
$lang[\'no\'] = \'No\';
$lang[\'action-not-allowed\'] = \'This action is not allowed.\';
$lang[\'record-add-success\'] = \'Record has been added successfully.\';
$lang[\'record-edit-success\'] = \'Record has been updated successfully.\';
$lang[\'record-delete-success\'] = \'Record has been deleted successfully.\';
$lang[\'add-record\'] = \'Add Record\';
$lang[\'edit-record\'] = \'Edit Record\';
$lang[\'invalid-id-msg\'] = \'Invalid id provided\';
$lang[\'active\'] = \'Active\';
$lang[\'inactive\'] = \'Inactive\';
$lang[\'actions\'] = \'Actions\';
$lang[\'no-records\'] = \'No Records Found\';
$lang[\'delete-alert\'] = \'Do you really want to delete this Record?.\';
$lang[\'add-edit-record\'] = \'Add/Edit Record\';
$lang[\'view-all-records\'] = \'View All Records\';
?>';
        return $language;
    }
    
    /**
     * Function build_config to generate config file for module
     * @access private 
     */
    private function build_config()
    {
        $config = '<?php
define(\'TBL_'.strtoupper($this->table_name).'\', \''.$this->table_name.'\');
?>';
        return $config;
    }
    
    /**
     * function build_sql()
     *
     * @access private
     * @param $field_total - integar
     * @return string
     */
    private function build_sql($field_total = NULL)
    {
        if ($field_total == NULL)
        {
            return FALSE;
        }

        $sql = 'CREATE TABLE IF NOT EXISTS  `' . $this->table_name . '` (
 id int(11) NOT NULL auto_increment,';

        for ($counter = 1; $field_total >= $counter; $counter++)
        {
            //Due to the requiredif rule if the first field is set the the others must be
            if (set_value("field_label{$counter}") == NULL)
            {
                continue;  // move onto next iteration of the loop
            }
            $sql .= '
 ' . set_value("field_name{$counter}") . ' ' . $this->input->post("db_type{$counter}");

            if (!in_array($this->input->post("db_type{$counter}"), array('TEXT', 'DATETIME'))) // There are no doubt more types where a value/length isn't possible - needs investigating
            {
                $sql .= '(' . set_value("db_length_value{$counter}") . ')';
            }
            
            $sql .= ' NOT NULL,';
        }

        $sql .= '
 PRIMARY KEY (id)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
        
        return $sql;
    }

}