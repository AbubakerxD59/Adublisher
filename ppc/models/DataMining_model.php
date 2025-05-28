<?php
class DataMining_model extends CI_Model

  {

    public function data_indexing(){
        ini_set('memory_limit', '-1');
       
       /*$query = $this->db->query("SELECT count(cpid) as clicks, user , cpid , property_id , country , round(sum(earn),4) as earning FROM `click` WHERE date < DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) group BY `cpid` , country , user");*/
      
        //$query = $this->db->query("SELECT id as user_id , count(cpid) as clicks, user , cpid , country , round(sum(earn),4) as earn FROM `click`  INNER JOIN
        //    user ON  click.user = user.username  WHERE   date < DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) group BY `cpid` , country , user");
       $query = $this->db->query("SELECT user.id as user_id , count(click.cpid) as clicks, click.user , click.cpid , click.country , round(sum(click.earn),4) as earn FROM `click` INNER JOIN user ON click.user = user.username WHERE date < DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) group BY click.`cpid` , click.country , click.user");
  
        foreach ($query->result_array() as $value)
        {

			$this->db->select('*');
			$this->db->from('revenue');
			$this->db->where('campaign_id',$value['cpid']);
			$this->db->where('country',$value['country']);
			$this->db->where('user_id',$value['user_id']); 
			$is_exist = $this->db->get()->num_rows();
			if($is_exist){
				//update 
				$this->db->set('earning', 'earning+'.$value['earn'], FALSE);
				$this->db->set('total_click', 'total_click+'.$value['clicks'], FALSE);
				$this->db->where('campaign_id',$value['cpid']);
                $this->db->where('country',$value['country']);
                $this->db->where('user_id',$value['user_id']);
				$this->db->update('revenue');

			}else{
				//insert
				$this->db->set('campaign_id', $value['cpid']);
				$this->db->set('user_id', $value['user_id']);
				$this->db->set('country', $value['country']);
				$this->db->set('earning',$value['earn']);
				$this->db->set('total_click',$value['clicks']);
				$this->db->insert('revenue');

			}			
        }
        echo "gourping done<br>";
       
        
        // dumping data into backup table
       
        /*$this->db->select('*');
		$this->db->from('click');
		$this->db->where('date < ', 'DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)', FALSE);
       
		$result = $this->db->get()->result_array();
		foreach($result as $value){
            
                $this->db->set('date', $value['date']);
				$this->db->set('time', $value['time']);
				$this->db->set('user', $value['user']);
				$this->db->set('cpid',$value['cpid']);
				$this->db->set('property_id',$value['property_id']);
				$this->db->set('country',$value['country']);
				$this->db->set('earn',$value['earn']);
				$this->db->set('adv',$value['adv']);
				$this->db->set('referer',$value['referer']);
				$this->db->set('device',$value['device']);
				$this->db->set('dateHourMinute',$value['dateHourMinute']);
				$this->db->insert('clicksbackup');
            
        }
        echo "dumping into clicksbackup<br>";
       */
       
        $this->db->where('date < ', 'DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)', FALSE);
		$this->db->delete('click');
         echo "delete 7 days back records<br";
    }
	public function revenue_fetch()
    {
		$this->db->select('*');
		$this->db->from('click');
		$this->db->where('date < ', 'DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)', FALSE);
        
		$result = $this->db->get()->result_array();

		foreach($result as $value){

			$this->db->select('id');
			$this->db->from('user');
			$this->db->where('username', $value['user']);
			$user_id = $this->db->get()->row_array()['id'];
			
			$this->db->select('id');
			$this->db->from('country');
			$this->db->where('name', $value['country']);
			$country_id = $this->db->get()->row_array()['id'];

			$campaign_id = $value['cpid'];
			$earning = $value['earn'];
			
			$this->db->select('*');
			$this->db->from('revenue');
			$this->db->where('campaign_id',$campaign_id);
			$this->db->where('country_id',$country_id);
			$is_exist = $this->db->get()->num_rows();
			if($is_exist){
				//update 
				$this->db->set('earning', 'earning+'.$earning, FALSE);
				$this->db->set('total_click', 'total_click+1', FALSE);
				$this->db->where('campaign_id',$campaign_id);
				$this->db->where('country_id',$country_id);
				$this->db->update('revenue');

			}else{
				//insert
				$this->db->set('campaign_id', $campaign_id);
				$this->db->set('user_id', $user_id);
				$this->db->set('country_id', $country_id);
				$this->db->set('earning',$earning);
				$this->db->set('total_click',1);
				$this->db->insert('revenue');

			}			
		}
	}
    
	public function revenue_delete()
    {
		$this->db->where('date < ', 'DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)', FALSE);
		$this->db->delete('click');
	}	
	
  }
