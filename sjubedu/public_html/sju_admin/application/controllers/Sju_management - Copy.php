<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sju_management extends CI_Controller {
	function __construct()
		{
			parent::__construct();
			$this->load->library('session');	
			$this->load->helper('date');
			$this->load->library('email');
			$this->load->helper('url');
            $this->load->model('Sju_management_model');
			$this->load->library('form_validation');	
			
		}	 
	
	public function login_true()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/body');
		//$this->load->view('admin/footer');
		
	}
	public function index()
	{
		
		
		$data['msg'] = $this->session->flashdata('msg');
	//	$this->load->view('admin/login', $data);
	print_r($dat);
		
	}
	public function member_login()
	{
		$this->load->view('admin/login');
		
	}
	public function side_menu()
	{
		$this->load->view('admin/sidemenu');
		
	}
	public function crumb()
	{
		$this->load->view('admin/crumb');
		
	}
	public function logout()
	{
	
	  $this->session->sess_destroy();
	  redirect(base_url());
	}
	
	
	public function login_check()
	{
		
		 $data = $this->input->post(NULL,TRUE);
		 $username = $data['loginusername'];
		 $password = $data['loginpassword'];
		 $user =  $this->Sju_management_model->get_staff_by_mobile($username);
		
		if ($user && password_verify($password, $user['c_password'])) {
			
			$newdata = array(
                   'userid'  => $user['n_id'],
				   'name'  => $user['c_name'],
                   'usertype'     =>$user['c_type'],
                   'sju_admin_logged_in' => TRUE
               );

            $this->session->set_userdata($newdata);
			
			redirect('/login_true');
		}
		else {
			
			$this->session->set_flashdata('msg', 'Invalid Mobile no. or password');
		   redirect(base_url());
		   
		   
		   
		}
			
				
	}
	
	
	
	public function staff_registration_form()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/staff_registration_form');
	}
	
	public function save_staff()
	{
	 	
				date_default_timezone_set('Asia/Kolkata');
				$today= date('Y-m-d H:i:s');
				$response_array=array();
				$c_name	=	ucwords($this->input->post('c_name'));	
				$c_address	=	$this->input->post('c_address');	
				$c_state		=	$this->input->post('c_state');
				$n_district		=	$this->input->post('n_district');
				$c_mobile	=	$this->input->post('c_mobile');
				$c_email	=	$this->input->post('c_email');	
				$n_pincode	=	$this->input->post('n_pincode');	
			
				$c_password	=	$this->input->post('c_password');	
				
				
				 // Hash password
            $hashed_password = password_hash($c_password, PASSWORD_BCRYPT);
				
				if($c_name && $c_address && $c_state && $n_district  && $c_mobile && $n_pincode && $c_password){
					$count=0;
					$sql1= "SELECT count(*) as cnt from staff_master where c_mobile ='$c_mobile'";		
						$result1 = $this->Sju_management_model->get_results($sql1);
						if($result1){
							 foreach($result1 as $row)
						  {
						  		$count=$row->cnt;
						  }
						}
					if($count<1){
					
					
				$this->db->trans_begin();
				
				 			$regdata = array(
								   'c_name'         => $c_name,
								   'c_address'      => $c_address,
								   'c_state'  	    => $c_state,
								   'n_district'     => $n_district,
								   'c_mobile'	    => $c_mobile,
								   'c_email'        => $c_email,
								   'n_pincode'      => $n_pincode,
								   'c_password'     => $hashed_password,
								   'd_date'         =>$today
							   );
					$rs=$this->db->insert('staff_master', $regdata);
					
					if ($this->db->trans_status() === FALSE)
							{
									$this->db->trans_rollback();
									$response_array['status'] = 'error';
									$response_array['msg'] = 'Please try after sometime';
							}
							else
							{
									$this->db->trans_commit();
									$response_array['status'] = 'success';
									$response_array['msg'] = 'Staff details added succesfully';
							}
					} else {
							$response_array['status'] = 'error';
							$response_array['msg'] = 'Entered mobile number is already registered with us';
							
						}
					} else {
							$response_array['status'] = 'error';
							$response_array['msg'] = 'Please fill all the required fields';
					}
						echo json_encode($response_array);		 
				
	}
	
	
	

	
	
	public function get_district()
	{
		 $result = array();
		 $c_state = $_REQUEST['c_state'];
		  $sql1= "SELECT n_dist_id,c_district from district where n_state ='$c_state' order by c_district";		
						$result1 = $this->Sju_management_model->get_results($sql1);
						if($result1){
							 foreach($result1 as $row)
						  {
								$result[] = array(
							  'id' => $row->n_dist_id,
							  'name' => $row->c_district,
							);
						  }
						}
						echo json_encode($result);
	}
	public function get_constituency()
	{
		 $result = array();
		 $c_state = $_REQUEST['c_state'];
		 $n_district = $_REQUEST['c_district'];
		  $sql1= "SELECT cid,constituencies from  constituencies where  state ='$c_state' and district='$n_district' order by constituencies";		
						$result1 = $this->Sju_management_model->get_results($sql1);
						if($result1){
							 foreach($result1 as $row)
						  {
								$result[] = array(
							  'id' => $row->cid,
							  'name' => $row->constituencies,
							);
						  }
						}
						echo json_encode($result);
	}
	
	
	public function mobile_number_check()

	{
		$count=0;
		   $c_mobile = $_GET['c_mobile'];
			if($c_mobile){
						$sql1= "SELECT count(*) as cnt from staff_master where c_mobile ='$c_mobile'";		
						$result1 = $this->Sju_management_model->get_results($sql1);
						if($result1){
							 foreach($result1 as $row)
						  {
						  		$count=$row->cnt;
						  }
						}
				}

		if($count>0) {echo 'false';} else { echo 'true';}		

	}
	
	public function staff_view()
	{
		
		
		$this->load->view('admin/header');
		$this->load->view('admin/staff_view');
	}
	public function staff_view_load()
	{
	
		$data = $this->input->post(NULL,TRUE);
		$this->load->view('admin/staff_view_load',$data);
	}
	public function edit_staff()
	{
		 $data = $this->input->post(NULL,TRUE);
		 $this->load->view('admin/edit_staff',$data);
	}
	

	public function update_staff()
	{
		
			$editid					=	$this->input->post('editid');
			$c_name 				=	$this->input->post('c_name');
			$c_mobile 				=	$this->input->post('c_mobile');	
			$c_email				=	$this->input->post('c_email');	
			$n_pincode				=	$this->input->post('n_pincode');
			$c_state				=	$this->input->post('c_state');
			$n_district				=	$this->input->post('n_district');
			//$n_constituency			=	$this->input->post('n_constituency');
			$c_address				=	$this->input->post('c_address');
			$c_password				=	$this->input->post('c_password');
		
					
		if($c_name && $c_address && $c_state && $n_district  && $c_mobile && $n_pincode){
		 
		 	
	
			$this->db->trans_begin();
								$regdata = array(
						'c_name'      => $c_name,
						'c_address'   => $c_address,
						'c_state'     => $c_state,
						'n_district'  => $n_district,
						'c_mobile'    => $c_mobile,
						'c_email'     => $c_email,
						'n_pincode'   => $n_pincode
					);
					
					// update password ONLY if provided
					if (!empty($c_password)) {
						$regdata['c_password'] = password_hash($c_password, PASSWORD_BCRYPT);
					}
					
					$this->db->where('n_id', $editid);
					$this->db->update('staff_master', $regdata);
								
			if ($this->db->trans_status() === FALSE)
							{
									$this->db->trans_rollback();
									$response_array['status'] = 'error';
									$response_array['msg'] = 'Please try after sometime';
							}
							else
							{
									$this->db->trans_commit();
									$response_array['status'] = 'success';
									$response_array['msg'] = 'Staff details updated succesfully';
							}
					} else {
							$response_array['status'] = 'error';
							$response_array['msg'] = 'Please fill all the required fields';
					}
					
			echo json_encode($response_array);
	
	}

	
	public function update_staff_status()
{
    $data = $this->input->post(NULL, TRUE);

    $cid = (int) $data['cnid'];
    $ust = $data['ust'];

    if ($this->Sju_management_model->update_staff_status($cid, $ust)) {
        echo 'ok';
    }
}

	
	
	public function profile_form()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/profile_form');
	}

	public function update_profile_pic()
	{
			$userid = $this->session->userdata('userid');
			$json=array();
			if(isset($_FILES["profilepic"]['name'])){
		
				$config['upload_path']          = './user_profile_pic/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|JPG|JPEG|PNG|GIF';
                $config['max_size']      = '5120';
				$config['encrypt_name'] = TRUE;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('profilepic'))
                {
                        $error = array('error' => $this->upload->display_errors());
						$json[] = array('result' =>'error','resulttext' => $error['error']);
                }
                else
                {
                        
						$data = array('upload_data' => $this->upload->data());
						$filename=$data['upload_data']['file_name'];
						$update  = "update staff_master set c_image = '$filename' where n_id = '$userid'";
						$success=$this->db->query($update);
						
						$json[] = array('result' =>'success','resulttext' => $filename);
                }
			}
			else
			{
				$json[] = array('result' =>'error','resulttext' => 'Please select a file to upload');
				
			}
			
			header('Content-type: application/json');
			echo json_encode($json);
	} 

	
	//NEWS SECTION
	public function add_news()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/add_news');
	}
	

 public function save_news()
    {
        $this->output->set_content_type('application/json');
		
		date_default_timezone_set('Asia/Kolkata');
				$today= date('Y-m-d H:i:s');

        $this->form_validation->set_rules(
            'c_title',
            'Title',
            'required|trim|min_length[2]'
        );

        $this->form_validation->set_rules(
            'c_news',
            'News',
            'required|trim|min_length[2]'
        );

        if ($this->form_validation->run() === FALSE)
        {
            echo json_encode([
                'status' => false,
                'errors' => [
                    'c_title' => form_error('c_title'),
                    'c_news'  => form_error('c_news')
                ]
            ]);
            return;
        }

        $title = $this->input->post('c_title', TRUE);

        // Generate slug
        $slug = url_title($title, '-', TRUE);

        // Ensure unique slug
        $slug = $this->Sju_management_model->unique_slug($slug);

        $data = [
            'title'       => $title,
            'slug'        => $slug,
            'description' => $this->input->post('c_news', TRUE),
            'created_at'  => $today,
            'added_by'    => $this->session->userdata('userid')
        ];

        if ($this->Sju_management_model->insert_news($data))
        {
            echo json_encode([
                'status'  => 'success',
                'msg' => 'News added successfully',
                'slug'    => $slug
            ]);
        }
        else
        {
            echo json_encode([
                'status'  => false,
                'message' => 'Database error. Try again.'
            ]);
        }
    }
	
	public function news_view()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/news_view');
	}
	public function news_view_load()
	{
	
		$data = $this->input->post(NULL,TRUE);
		$this->load->view('admin/news_view_load',$data);
	}
	
	public function update_news_status()
{
    $data = $this->input->post(NULL, TRUE);

    $cid = (int) $data['cnid'];
    $ust = $data['ust'];

    if ($this->Sju_management_model->update_news_status($cid, $ust)) {
        echo 'ok';
    }
}
	public function edit_news()
	{
		 $data = $this->input->post(NULL,TRUE);
		 $this->load->view('admin/edit_news',$data);
	}
	
	public function update_news()
    {
        $this->output->set_content_type('application/json');
		
		
		date_default_timezone_set('Asia/Kolkata');
				$today= date('Y-m-d H:i:s');
		$editid = $this->input->post('editid', TRUE);
        $this->form_validation->set_rules(
            'c_title',
            'Title',
            'required|trim|min_length[2]'
        );

        $this->form_validation->set_rules(
            'c_news',
            'News',
            'required|trim|min_length[2]'
        );

        if ($this->form_validation->run() === FALSE)
        {
            echo json_encode([
                'status' => false,
                'errors' => [
                    'c_title' => form_error('c_title'),
                    'c_news'  => form_error('c_news')
                ]
            ]);
            return;
        }

        $title = $this->input->post('c_title', TRUE);



        $data = [
            'title'       => $title,
            'description' => $this->input->post('c_news', TRUE),
            'edited_at'  => $today,
            'edited_by'    => $this->session->userdata('userid')
        ];

      
	  
	  if ($this->Sju_management_model->update_news($editid, $data))
    {
        echo json_encode([
            'status' => 'success',
            'msg'    => 'News updated successfully'
        ]);
    }
    else
    {
        echo json_encode([
            'status'  => false,
            'message' => 'Database error. Try again.'
        ]);
    }
	  
	  
    }
	
	
	//EVENTS SECTION
	
	public function add_event()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/add_event');
	}
	public function save_event()
{
    $this->output->set_content_type('application/json');

    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');

    $this->form_validation->set_rules(
        'event_name',
        'Event Name',
        'required|trim|min_length[2]'
    );

    $this->form_validation->set_rules(
        'description',
        'Description',
        'required|trim|min_length[2]'
    );

    $this->form_validation->set_rules(
        'd_event',
        'Event Date',
        'required'
    );

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'event_name' => form_error('event_name'),
                'description'=> form_error('description'),
                'd_event' => form_error('d_event')
            ]
        ]);
        return;
    } 
	
	$event_date_input = $this->input->post('d_event', TRUE);
    $event_date = date('Y-m-d', strtotime($event_date_input));

    $data = [
        'event_name' => $this->input->post('event_name', TRUE),
        'description'=> $this->input->post('description', TRUE),
        'event_date' => $event_date,
        'created_at' => $today,
        'created_by' => $this->session->userdata('userid')
    ];

    if ($this->Sju_management_model->insert_event($data))
    {
        echo json_encode([
            'status' => 'success',
            'msg'    => 'Event created successfully'
        ]);
    }
    else
    {
        echo json_encode([
            'status'  => false,
            'message'=> 'Database error. Try again.'
        ]);
    }
}
	public function events_view()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/events_view');
	}
	public function events_view_load()
	{
	
		$data = $this->input->post(NULL,TRUE);
		$this->load->view('admin/events_view_load',$data);
	}
	public function update_event_status()
{
    $data = $this->input->post(NULL, TRUE);

    $cid = (int) $data['cnid'];
    $ust = $data['ust'];

    if ($this->Sju_management_model->update_event_status($cid, $ust)) {
        echo 'ok';
    }
}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */