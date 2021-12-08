<?php
class Projects_model extends MY_Model {

        public $title;
        public $content;
        public $date;


        public function getProjects(){        	
            $qry = "SELECT TO_CHAR(created_on, 'YYYY/MM/DD') as created_on, project_id, project_name, assignee, status, progress, priority, scope FROM SBE_PROJECTS
                WHERE DELETED IS NULL
                ORDER BY STATUS DESC, CREATED_ON DESC";
            $query = $this->db->query($qry);        	
            return $query->result_array();
        }

        public function getQuery(){                
            $query = $this->db->get_compiled_select('SBE_PROJECTS');
            $this->db->order_by(date_ins, 'DESC');
            return $query;
        }

        public function getAssigneeList(){
            $qry = "SELECT distinct badge, first_name, last_name from dir_indir where date_ins in (select max(date_ins) from dir_indir)";
            $stmt = $this->db->query($qry);
            return $stmt->result_array();
        }


        public function get_project_by_id($id){
            $qry = "SELECT TO_CHAR(created_on, 'YYYY/MM/DD') as created_on,
            project_id, project_name, assignee, status, progress, priority, scope, start_date, created_by, deadline, days_needed 
            FROM SBE_PROJECTS 
            where project_id = '$id' 
            ORDER BY STATUS DESC";        	
	    $query = $this->db->query($qry);        	
	    return $query->result();
        }

        public function get_activities_by_pid($id){
            $qry = "SELECT ACTIVITY_ID, NAME, DETAILS, STATUS FROM SBE_PROJECTS_ACTIVITY
                    WHERE PROJECT_ID = '{$id}' and DELETED IS NULL
                    ORDER BY CREATED_ON";
            $query = $this->db->query($qry);            
            return $query->result();
        }

        public function get_next_seq($seqname){        
            $qry = "SELECT ".$seqname.".NEXTVAL  FROM DUAL";
            $query = $this->db->query($qry);
            $nextValArray = $query->row();
            return $nextValArray->NEXTVAL;
        }
		
	public function insertData($data){
            return $this->db->insert('SBE_PROJECTS', $data);
        }	
		
        public function executeQuery($qry){             
            return $this->db->query($qry);
        }

	
}
?>
