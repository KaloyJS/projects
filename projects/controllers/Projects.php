<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter-HMVC-AdminLTE
 *
 * @package    CodeIgniter-HMVC-AdminLTE
 * @author     N3Cr0N (N3Cr0N@list.ru)
 * @copyright  2019 N3Cr0N
 * @license    https://opensource.org/licenses/MIT  MIT License
 * @link       <URI> (description)
 * @version    GIT: $Id$
 * @since      Version 0.0.1
 * @todo       (description)
 *
 */

class Projects extends BackendController
{
    //
    public $CI;
	// public $sbegn_u_name;
	// public $sbegn_role;
	// public $sbegn_account;
	// public $sbegn_badge;
	// public $sbegn_fname;
	// public $sbegn_lname;
	// public $sbegn_access;
    /**
     * An array of variables to be passed through to the
     * view, layouts, ....
     */
    protected $data = array();
	
    /**
     * [__construct description]
     *
     * @method __construct
     */
    public function __construct()
    {
        //
        parent::__construct();
        // This function returns the main CodeIgniter object.
        // Normally, to call any of the available CodeIgniter object or pre defined library classes then you need to declare.
	
        $CI =& get_instance();
		$this->load->model('Projects_model');
		$this->load->library('form_validation');
        //Load session library 
        $this->load->library('session');
		
		if($this->session->has_userdata(PORTAL_NAME.'portal')){
            $this->sbegn_u_name = $this->session->userdata(PORTAL_NAME.'uname');
            $this->sbegn_role = $this->session->userdata(PORTAL_NAME.'role');
            $this->sbegn_account = $this->session->userdata(PORTAL_NAME.'account');
            $this->sbegn_badge = $this->session->userdata(PORTAL_NAME.'badge');
            $this->sbegn_fname = $this->session->userdata(PORTAL_NAME.'fname');
            $this->sbegn_lname = $this->session->userdata(PORTAL_NAME.'lname');
            $this->sbegn_access = $this->session->userdata(PORTAL_NAME.'access');			
		}else{
			// If user not logged in create a url in the Session super global so after login in would			
			session_start();
			$_SESSION['url'] = $_SERVER['REQUEST_URI']; 			
            redirect('login', 'refresh'); 
		}
		
    }

    /**
     * [index description]
     *
     * @method index
     *
     * @return [type] [description]
     */
    public function index()
    {
		

		$this->data['projects']= $this->Projects_model->getProjects();
        $this->data['assigneeList'] = $this->Projects_model->getAssigneeList();
        $this->template2('projects/projects', $this->data, true, 'projects/projects/js');
        
    }

    public function overview($id){

    	$this->data['project'] = $this->Projects_model->get_project_by_id($id);
        $this->data['assigneeList'] = $this->Projects_model->getAssigneeList();
        $this->data['activities'] = $this->Projects_model->get_activities_by_pid($id);
        $this->template2('projects/overview', $this->data, true, 'projects/overview/js');

    }

    public function actions()
    {

        if(!$this->session->has_userdata(PORTAL_NAME.'portal')) {
            session_start();
            $_SESSION['url'] = $_SERVER['REQUEST_URI'];             
            redirect('login', 'refresh'); 
        } else {

            $date_today = date("Y/m/d");    
            $time_today = date("h:i:s");
            $userName = $this->session->userdata(PORTAL_NAME.'uname');

            if(isset($_POST['addNewProject'])){
                $this->form_validation->set_rules('project_name', 'Project Name', 'required');
                $this->form_validation->set_rules('assignee', 'Assignee', 'required');
                $this->form_validation->set_rules('start_date', 'Projected Start Date', 'required');
                $this->form_validation->set_rules('deadline', 'Projected Deadline', 'required');
                $this->form_validation->set_rules('scope', 'Scope', 'required');
                $this->form_validation->set_rules('priority', 'Priority', 'required');

                if ($this->form_validation->run() == FALSE) {
                    $std = validation_errors(); //just uncomment this part, this should work            
                    //$std =  preg_split('/\r\n|\r|\n/', $std);
                    
                    $this->session->set_flashdata('error', $std);
                    redirect(base_url('projects'));               
                 } else {
                    // Gathering post data into data array 
                    $insert_data = [];
                    $keys = array_keys($_POST);
                    for($i = 0;$i < count($keys);$i++) {
                        if($keys[$i] != 'addNewProject'){ // AddnewProject is a button Name
                            $insert_data[strtoupper($keys[$i])] = $_POST[$keys[$i]];
                        }
                    }
                    // Generates Project ID private key
                    $insert_data['PROJECT_ID'] = str_pad($this->Projects_model->get_next_seq("SBE_PROJECTS_SEQ"), 6, "0", STR_PAD_LEFT);
                    $insert_data['PROGRESS'] = 0;
                    $insert_data['CREATED_BY'] = $userName;
                    $insert_data['STATUS'] = 'created';
                    // Save data in db
                    if($this->Projects_model->insertData($insert_data)) {
                        sendMsg("Project Created", "success", "projects");
                    } else {
                        sendMsg("Something went wrong", "failure", "projects");
                    }

                 }

            }

            if(isset($_POST['updateProject'])){

                $update_data = []; // Array to be updated
                $keys = array_keys($_POST);
                for ($i=0; $i < count($keys); $i++) { 
                    if($keys[$i] != 'updateProject'){
                        if($keys[$i] == 'project_id'){
                           $project_id = trim($_POST[$keys[$i]]);
                        } else {
                           $update_data[$keys[$i]] = trim($_POST[$keys[$i]]);  
                        }
                        
                    }
                }
                $update_data['UPDATED_ON'] = 'sysdate';
                $update_data['UPDATED_BY'] = $userName;
                $tableName = "SBE_PROJECTS";
                $identifier = "PROJECT_ID";
                // Generates Update Query
                $query = generateUpdateQuery($tableName, $update_data, $identifier, $project_id); 
                
                if($this->Projects_model->executeQuery($query)){
                    sendMsg("Update Successfull", "success", base_url()."projects/overview/{$project_id}");
                }
            }


            if(isset($_POST['addNewActivity'])) {
                // Prepare data for insertion
                $insert_data = [];
                $keys = array_keys($_POST);
                for ($i=0; $i < count($keys); $i++) { 
                    if ($keys[$i] != 'addNewActivity') {
                       $insert_data[$keys[$i]] = trim($_POST[$keys[$i]]);
                    }
                }
                $insert_data['status'] = 'to do';
                $insert_data['created_by'] = $userName;
                $insert_data['activity_id'] = str_pad($this->Projects_model->get_next_seq("SBE_ACTIVITY_SEQ"), 6, "0", STR_PAD_LEFT); 

                $query = generateInsertQuery("SBE_PROJECTS_ACTIVITY", $insert_data);
                // Save data in db

                if($this->Projects_model->executeQuery($query)) {
                    sendMsg("Activity added successfully", "success",  base_url()."projects/overview/{$insert_data['project_id']}");
                } else {
                    sendMsg("Something went wrong", "failure",  base_url()."projects/overview/{$insert_data['project_id']}");
                }
            }

            if (isset($_POST['updateActivity'])) {
                $id = $_POST['activity_id'];
                $project_id = $_POST['project_id'];
                $update_data['STATUS']  = $_POST['status'];
                $update_data['UPDATED_ON'] = 'sysdate';
                $update_data['UPDATED_BY'] = $userName;
                $tableName = "SBE_PROJECTS_ACTIVITY";
                $identifier = "ACTIVITY_ID";
                // Generates Update Query
                $query = generateUpdateQuery($tableName, $update_data, $identifier, $id);
                // Save data in db

                if($this->Projects_model->executeQuery($query)) {
                    sendMsg("Activity updated successfully", "success",  base_url()."projects/overview/{$project_id}");
                } else {
                    sendMsg("Something went wrong", "failure",  base_url()."projects/overview/{$project_id}");
                }
            }

            if (isset($_POST['deleteProjects'])) {
                $idsToDelete = explode(",", $_POST['ids']); // Separates id's to delete
                $deleted_by = $userName;
                for ($i=0; $i < count($idsToDelete); $i++) { 
                    $query = "UPDATE SBE_PROJECTS SET 
                              DELETED = '1',
                              DELETED_ON = sysdate,
                              DELETED_BY = '{$deleted_by}'
                              WHERE PROJECT_ID = '{$idsToDelete[$i]}'";
                    $this->Projects_model->executeQuery($query);                
                }
                echo "deleted";
            }

            if(isset($_POST['closeProject'])){
                $id = $_POST['id'];

                $query = "UPDATE SBE_PROJECTS SET
                          STATUS = 'closed',
                          UPDATED_ON = sysdate,
                          UPDATED_BY = '{$userName}'
                          WHERE PROJECT_ID = '{$id}'";
                if($this->Projects_model->executeQuery($query)) {
                    echo "closed";
                }
                         
            }

            if (isset($_POST['deleteActivities'])) {
                $idsToDelete = explode(",", $_POST['ids']); // Separates id's to delete
                $deleted_by = $userName;
                for ($i=0; $i < count($idsToDelete); $i++) { 
                    $query = "UPDATE SBE_PROJECTS_ACTIVITY SET 
                              DELETED = '1',
                              DELETED_ON = sysdate,
                              DELETED_BY = '{$deleted_by}'
                              WHERE PROJECT_ID = '{$idsToDelete[$i]}'";
                    $this->Projects_model->executeQuery($query);                
                }
                echo "deleted";
            }

        }      
    }
	
	
	
	


   
    /**
     * [error_500 description]
     *
     * @method error_500
     *
     * @return [type]    [description]
     */
    public function error_500()
    {
        // Display page with the template function from MY_Controller
        $this->template('examples/error_500', $this->data, true);
    }

    /**
     * [register description]
     *
     * @method register
     *
     * @return [type]   [description]
     */
  

    /**
     * [blank description]
     *
     * @method blank
     *
     * @return [type] [description]
     */
    public function blank()
    {
        // Display page with the template function from MY_Controller
        $this->template('examples/blank', $this->data, true);
    }
}
