<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sju_management_model extends CI_Model { 

	public function get_results($sql)
	{
		$query = $this->db->query($sql);
		if($query -> num_rows() >0)
		{
			return $query->result();
		}
		else
		{
			return false;
		}

	}

	
	
		public function get_staff_by_mobile($username)
{
    return $this->db
        ->select('n_id, c_name, c_type, c_password')
        ->from('staff_master')
        ->where('c_mobile', $username)
        ->where('c_status', 'Y')
        ->get()
        ->row_array();
}
	

	public function get_staff_name($id)
	{
		$c_name="";
		if($id){
		$sql2= "SELECT c_name from staff_master where n_id='$id' ";
		$query = $this->db->query($sql2);
			 $rslt=$query->result_array();
			 if($rslt){
				 $c_name = $rslt[0]['c_name'];
			 }
		}
			 return $c_name;
	}
	public function get_staff_count() 
	{  
		$cnt="";
		$sql2= "SELECT count(*) as cnt from staff_master where c_status='Y' and n_id>1";
		
		$query = $this->db->query($sql2);
			 $rslt=$query->result_array();
			 if($rslt){
				 $cnt = $rslt[0]['cnt'];
			 }
		
			 return $cnt;
	}
	

	public function get_state($id)
	{
		$name="";
		if($id){
		$sql2= "SELECT name from country_states where code='$id' ";
		$query = $this->db->query($sql2);
			 $rslt=$query->result_array();
			 if($rslt){
				 $name = $rslt[0]['name'];
			 }
		}
			 return $name;
	}
	public function get_district($state,$district)
	{
		$c_district="";
		if($state && $district){
		$sql2= "SELECT c_district from district where  n_state ='$state' and n_dist_id='$district' ";
		$query = $this->db->query($sql2);
			 $rslt=$query->result_array();
			 if($rslt){
				 $c_district = $rslt[0]['c_district'];
			 }
		}
			 return $c_district;
	}
	public function get_constituency($state,$district,$const)
	{
		$constituencies="";
		if($state && $district && $const){
		$sql2= "SELECT constituencies from constituencies where  state ='$state' and district='$district' and cid='$const' ";
		$query = $this->db->query($sql2);
			 $rslt=$query->result_array();
			 if($rslt){
				 $constituencies = $rslt[0]['constituencies'];
			 }
		}
			 return $constituencies;
	}

public function get_tech_profile_pic()
	{
		 $userid = $this->session->userdata('userid');
		 $sql2= "SELECT c_image from staff_master   where  n_id='$userid'";
			
			$c_image=$profile_photo="";		
						$result2 = $this->Sju_management_model->get_results($sql2);
						if($result2){
							 foreach($result2 as $row)
						  {
								
								$c_image = $row->c_image;
								if(strlen($c_image)==0){
								 	    $profile_photo='user_male.png';
									} else {
										$profile_photo=$c_image;
									}
						        }
						}
		return $profile_photo;
	}
	
	 public function insert_newssss($data)
    {
        return $this->db->insert('news', $data);
    }



public function insert_news($data)
{
    $this->db->insert('news', $data);
	if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();   // return last insert id
    } else {
        return false;
    }
}
public function insert_news_department($data)
{
    $this->db->insert('news_departments', $data);
	if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();   // return last insert id
    } else {
        return false;
    }
}
    // Recursive unique slug generator
    public function unique_slug($slug, $count = 0)
    {
        $new_slug = ($count > 0) ? $slug . '-' . $count : $slug;

        $exists = $this->db
            ->where('slug', $new_slug)
            ->count_all_results('news');

        if ($exists > 0)
        {
            return $this->unique_slug($slug, $count + 1);
        }

        return $new_slug;
    }
	
	public function update_news($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('news', $data);
}

public function update_news_status($id, $status)
{
    $this->db->where('id', $id);
    return $this->db->update('news', [
        'c_status' => $status
    ]);
}

//EVENTS
public function insert_event($data)
{
    $this->db->insert('events', $data);
	if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();   // return last insert id
    } else {
        return false;
    }
}
public function insert_events_department($data)
{
    $this->db->insert('event_departments', $data);
	if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();   // return last insert id
    } else {
        return false;
    }
}



public function update_event_status($id, $status)
{
    $this->db->where('id', $id);
    return $this->db->update('events', [
        'c_status' => $status
    ]);
}

public function update_staff_status($id, $status)
{
    $this->db->where('n_id', $id);
    return $this->db->update('staff_master', [
        'c_status' => $status
    ]);
}


public function insert_staff($data)
{
    // Check mobile exists
    $exists = $this->db->where('c_mobile', $data['c_mobile'])
                       ->count_all_results('staff_master');

    if ($exists > 0) {
        return [
            'status' => 'error',
            'msg'    => 'Entered mobile number is already registered with us'
        ];
    }

    $this->db->trans_begin();

    $insert = $this->db->insert('staff_master', $data);

    if ($this->db->trans_status() === FALSE || !$insert) {
        $this->db->trans_rollback();
        return [
            'status' => 'error',
            'msg'    => 'Please try after sometime'
        ];
    }

    $this->db->trans_commit();

    return [
        'status' => 'success',
        'msg'    => 'Staff details added succesfully'
    ];
}

public function update_staff($data)
{
    $editid = $data['editid'];

    unset($data['editid']); // remove ID from update array

    // Update password ONLY if provided
    if (!empty($data['c_password'])) {
        $data['c_password'] = password_hash($data['c_password'], PASSWORD_BCRYPT);
    } else {
        unset($data['c_password']);
    }

    $this->db->trans_begin();

    $this->db->where('n_id', $editid);
    $this->db->update('staff_master', $data);

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return [
            'status' => 'error',
            'msg'    => 'Please try after sometime'
        ];
    }

    $this->db->trans_commit();

    return [
        'status' => 'success',
        'msg'    => 'Staff details updated succesfully'
    ];
}

public function get_district_by_state($state)
{
    $query = $this->db
                  ->select('n_dist_id, c_district')
                  ->where('n_state', $state)
                  ->order_by('c_district', 'ASC')
                  ->get('district')
                  ->result();

    $result = [];

    foreach ($query as $row) {
        $result[] = [
            'id'   => $row->n_dist_id,
            'name' => $row->c_district
        ];
    }

    return $result;
}



public function get_events_paginated($search, $page, $per_page)
{
    // ---------- COUNT ----------
    $this->db->from('events');
    $this->db->where_in('c_status', ['Y','N']);

    if (!empty($search)) {
        $this->db->group_start()
                 ->like('event_name', $search)
                 ->or_like('description', $search)
                 ->group_end();
    }

    $count = $this->db->count_all_results();

    // ---------- DATA ----------
    $start = ($page - 1) * $per_page;

    $this->db->select('id,event_name,description,c_status,created_at,event_date');
    $this->db->from('events');
    $this->db->where_in('c_status', ['Y','N']);

    if (!empty($search)) {
        $this->db->group_start()
                 ->like('event_name', $search)
                 ->or_like('description', $search)
                 ->group_end();
    }

    $events = $this->db->order_by('id','DESC')
                       ->limit($per_page, $start)
                       ->get()
                       ->result();

    return [
        'events'   => $events,
        'count'    => $count,
        'page'     => $page,
        'per_page' => $per_page
    ];
}
public function update_event($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('events', $data);
}

 public function unique_event_slug($slug, $count = 0)
    {
        $new_slug = ($count > 0) ? $slug . '-' . $count : $slug;

        $exists = $this->db
            ->where('slug', $new_slug)
            ->count_all_results('events');

        if ($exists > 0)
        {
            return $this->unique_slug($slug, $count + 1);
        }

        return $new_slug;
    }
	
	 public function insert_book($data)
    {
        return $this->db->insert('books', $data);
    }

    // Recursive unique slug generator
    public function unique_slug_book($slug, $count = 0)
    {
        $new_slug = ($count > 0) ? $slug . '-' . $count : $slug;

        $exists = $this->db
            ->where('slug', $new_slug)
            ->count_all_results('books');

        if ($exists > 0)
        {
            return $this->unique_slug($slug, $count + 1);
        }

        return $new_slug;
    }
	public function update_books($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('books', $data);
}
public function update_book_status($id, $status)
{
    $this->db->where('id', $id);
    return $this->db->update('books', [
        'c_status' => $status
    ]);
}
 public function insert_slider($data)
    {
        return $this->db->insert('sliders', $data);
    }
	public function update_slider_status($id, $status)
{
    $this->db->where('id', $id);
    return $this->db->update('sliders', [
        'c_status' => $status
    ]);
}

public function save_staff_permission($editid, $c_permission)
    {
        date_default_timezone_set('Asia/Kolkata');
        $todaydatetime = date('Y-m-d H:i:s');

        $this->db->trans_begin();

        if (is_array($c_permission) && count($c_permission) > 0 && $editid) {

            // delete old permissions
            $this->db->where('user_id', $editid)
                     ->delete('permission_master');

            // insert new permissions
            foreach ($c_permission as $permission) {

                $data = [
                    'user_id'       => $editid,
                    'permission' => $permission,
                    'd_date'     => $todaydatetime
                ];

                $this->db->insert('permission_master', $data);
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();
        return true;
    }

//ANNOUNCEMENT

 public function insert_announcementddd($data)
    {
        return $this->db->insert('announcements', $data);
    }

    // Recursive unique slug generator
    public function unique_slug_announcement($slug, $count = 0)
    {
        $new_slug = ($count > 0) ? $slug . '-' . $count : $slug;

        $exists = $this->db
            ->where('slug', $new_slug)
            ->count_all_results('announcements');

        if ($exists > 0)
        {
            return $this->unique_slug_($slug, $count + 1);
        }

        return $new_slug;
    }
	
	public function update_announcement($id, $data)
{
    $this->db->where('id', $id);
    return $this->db->update('announcements', $data);
}

public function update_announcement_status($id, $status)
{
    $this->db->where('id', $id);
    return $this->db->update('announcements', [
        'c_status' => $status
    ]);
}


public function delete_events_department($events_id)
{
    $this->db->where('events_id', $events_id);
    return $this->db->delete('event_departments');
}

public function delete_news_department($events_id)
{
    $this->db->where('news_id', $events_id);
    return $this->db->delete('news_departments');
}


public function insert_announcement($data)
{
    $this->db->insert('announcements', $data);
	if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();   // return last insert id
    } else {
        return false;
    }
}
public function insert_announcement_department($data)
{
    $this->db->insert('announcement_departments', $data);
	if ($this->db->affected_rows() > 0) {
        return $this->db->insert_id();   // return last insert id
    } else {
        return false;
    }
}
public function delete_announcement_department($events_id)
{
    $this->db->where('announcement_id', $events_id);
    return $this->db->delete('announcement_departments');
}
}