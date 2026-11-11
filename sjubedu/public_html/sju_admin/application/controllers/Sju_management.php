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
	
	public function dashboard()
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
			
			$permission_array=array();
						$user_id = $user['n_id'];
						
						if($user_id==1){
									array_push($permission_array,'dashboard');
								    array_push($permission_array,'home');
									array_push($permission_array,'staff_registration_form');
									array_push($permission_array,'staff_view'); 
									array_push($permission_array,'add_slider');
									array_push($permission_array,'slider_view');
									array_push($permission_array,'add_news');
									array_push($permission_array,'news_view');
									array_push($permission_array,'add_event');
									array_push($permission_array,'events_view');
									array_push($permission_array,'add_book');
									array_push($permission_array,'books_view');
									array_push($permission_array,'add_announcement');
									array_push($permission_array,'announcements_view');
								 }
						else {
						$sql28= "SELECT permission from permission_master  where user_id=$user_id"; 
						$result28 = $this->Sju_management_model->get_results($sql28);
						if($result28){
							 foreach($result28 as $row28)
						  {
								array_push($permission_array,$row28->permission);
								array_push($permission_array,'dashboard');
								array_push($permission_array,'home');
								
						  }
						}
			
						}
			
			
			
			$newdata = array(
                   'userid'  => $user['n_id'],
				   'name'  => $user['c_name'],
                   'usertype'     =>$user['c_type'],
				   'permission_array'    =>$permission_array,
                   'sju_admin_logged_in' => TRUE
               );

            $this->session->set_userdata($newdata);
			
			redirect('/dashboard');
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
    $today = date('Y-m-d H:i:s');

    $response = [];

    $data = [
        'c_name'      => ucwords($this->input->post('c_name', TRUE)),
        'c_mobile'    => $this->input->post('c_mobile', TRUE),
        'c_email'     => $this->input->post('c_email', TRUE),
        'c_password'  => $this->input->post('c_password', TRUE),
        'd_date'      => $today
    ];

    // Basic required field check
    if (
        empty($data['c_name']) || empty($data['c_mobile']) ||
        empty($data['c_email']) || empty($data['c_password'])
    ) {
        echo json_encode([
            'status' => 'error',
            'msg'    => 'Please fill all the required fields'
        ]);
        return;
    }

    // Hash password
    $data['c_password'] = password_hash($data['c_password'], PASSWORD_BCRYPT);

    $result = $this->Sju_management_model->insert_staff($data);

    echo json_encode($result);
}


	
public function get_district()
{
    $state = $this->input->post('c_state', TRUE);

    if (empty($state)) {
        echo json_encode([]);
        return;
    }

    $result = $this->Sju_management_model->get_district_by_state($state);

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
    $response = [];

    $data = [
        'editid'      => $this->input->post('editid', TRUE),
        'c_name'      => ucwords($this->input->post('c_name', TRUE)),
        'c_mobile'    => $this->input->post('c_mobile', TRUE),
        'c_email'     => $this->input->post('c_email', TRUE),
        'c_password'  => $this->input->post('c_password', TRUE)
    ];

    // Required field check
    if (
        empty($data['editid']) || empty($data['c_name'])  ||
        empty($data['c_mobile'])
    ) {
        echo json_encode([
            'status' => 'error',
            'msg'    => 'Please fill all the required fields'
        ]);
        return;
    }

    $result = $this->Sju_management_model->update_staff($data);

    echo json_encode($result);
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
                $config['max_size']      = '10240';
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
    $today = date('Y-m-d H:i:s');

    $this->form_validation->set_rules('c_title', 'Title', 'required|trim|min_length[2]');
    $this->form_validation->set_rules('c_news', 'News', 'required|trim|min_length[2]');
	$this->form_validation->set_rules('c_type[]', 'Show in', 'required');
	$this->form_validation->set_rules('d_start_date','Date','required');
	$this->form_validation->set_rules('d_end_date','Expiry Date','required');

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'c_title' => form_error('c_title'),
                'c_news'  => form_error('c_news'),
				 'd_start_date' => form_error('d_start_date'),
				   'd_end_date' => form_error('d_end_date')
            ]
        ]);
        return;
    }

    $title = $this->input->post('c_title', TRUE);
	$c_type = $this->input->post('c_type', TRUE);
	$c_url = $this->input->post('c_url', TRUE);
	$c_file_type = $this->input->post('c_file_type', TRUE);
	$c_text = $this->input->post('c_text', TRUE);

    // Slug
    $slug = url_title($title, '-', TRUE);
    $slug = $this->Sju_management_model->unique_slug($slug);

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/news/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_news_image($upload_data);
    }


// ==================== IMAGE OR PDF ====================
$pdf_file = null;

if (!empty($_FILES['c_pdf']['name']))
{
    $config2 = [];
    $config2['upload_path']   = './assets/admin/uploads/news/pdf/';
    $config2['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
    $config2['encrypt_name']  = TRUE;
    $config2['max_size']      = 10240;

    $this->upload->initialize($config2); // ? reinitialize

    if (!$this->upload->do_upload('c_pdf'))
    {
        echo json_encode([
            'status'  => false,
            'message' => $this->upload->display_errors('', '')
        ]);
        return;
    }

    $upload_data2 = $this->upload->data();
    $pdf_file     = $upload_data2['file_name'];

   
}


    /* ================= DB DATA ================= */
	$event_date_input = $this->input->post('d_start_date', TRUE);
    $d_start_date = date('Y-m-d', strtotime($event_date_input));
	$d__date_end_input = $this->input->post('d_end_date', TRUE);
    $d_end_date = date('Y-m-d', strtotime($d__date_end_input));
    $data = [
        'title'       => $title,
        'slug'        => $slug,
		'd_start_date' => $d_start_date,
		 'd_end_date' => $d_end_date,
        'description' => $this->input->post('c_news', TRUE),
        'c_image'       => $image_name,
		'c_file_type' => $c_file_type,
		'c_url' => $c_url,
		'c_pdf' => $pdf_file,
		'c_text' => $c_text,
        'created_at'  => $today,
        'added_by'    => $this->session->userdata('userid')
    ];

    $insert_id = $this->Sju_management_model->insert_news($data);

if($insert_id){
	
	
	foreach($c_type as $_department){
		$data_department = [
        'news_id'       => $insert_id,
        'c_department'        => $_department];
		$this->Sju_management_model->insert_news_department($data_department);
	}
}


if ($insert_id)
{
    echo json_encode([
        'status' => true,
        'msg'    => 'News added successfully',
        'slug'   => $slug
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

	private function _resize_news_image($upload_data)
{
    $this->load->library('image_lib');

    $sizes = [
        'large'  => [800, 800],
        'medium' => [400, 400],
        'thumb'  => [150, 150]
    ];

    foreach ($sizes as $folder => $size)
    {
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $upload_data['full_path'],
            'new_image'      => './assets/admin/uploads/news/'.$folder.'/'.$upload_data['file_name'],
            'maintain_ratio' => TRUE,
            'width'          => $size[0],
            'height'         => $size[1]
        ];

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
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
    $today = date('Y-m-d H:i:s');
	$editid = $this->input->post('editid', TRUE);
    $this->form_validation->set_rules('c_title', 'Title', 'required|trim|min_length[2]');
    $this->form_validation->set_rules('c_news', 'News', 'required|trim|min_length[2]');
	$this->form_validation->set_rules('c_type[]', 'Show in', 'required');
	$this->form_validation->set_rules('d_start_date','Date','required');
	$this->form_validation->set_rules('d_end_date','Expiry Date','required');
	

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'c_title' => form_error('c_title'),
                'c_news'  => form_error('c_news'),
				 'd_start_date' => form_error('d_start_date'),
				 'd_end_date' => form_error('d_end_date')
            ]
        ]);
        return;
    }

    $title = $this->input->post('c_title', TRUE);
	$c_type = $this->input->post('c_type', TRUE);
	$c_url = $this->input->post('c_url', TRUE);
	$c_file_type = $this->input->post('c_file_type', TRUE);
	$c_text = $this->input->post('c_text', TRUE);

    // Slug
    $slug = url_title($title, '-', TRUE);
    $slug = $this->Sju_management_model->unique_slug($slug);

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/news/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_news_image($upload_data);
    }


// ==================== IMAGE OR PDF ====================
$pdf_file = null;

if (!empty($_FILES['c_pdf']['name']))
{
    $config2 = [];
    $config2['upload_path']   = './assets/admin/uploads/news/pdf/';
    $config2['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
    $config2['encrypt_name']  = TRUE;
    $config2['max_size']      = 10240;
  $this->load->library('upload');   // <-- ADD THIS
    $this->upload->initialize($config2); // ? reinitialize

    if (!$this->upload->do_upload('c_pdf'))
    {
        echo json_encode([
            'status'  => false,
            'message' => $this->upload->display_errors('', '')
        ]);
        return;
    }

    $upload_data2 = $this->upload->data();
    $pdf_file     = $upload_data2['file_name'];

   
}
    /* ================= DB DATA ================= */
	$event_date_input = $this->input->post('d_start_date', TRUE);
    $d_start_date = date('Y-m-d', strtotime($event_date_input));
	$d_end_date_input = $this->input->post('d_end_date', TRUE);
    $d_end_date = date('Y-m-d', strtotime($d_end_date_input));
   
 $data = [
    'title'       => $title,
    'description' => $this->input->post('c_news', TRUE),
	 'd_start_date' => $d_start_date,
	 'd_end_date' => $d_end_date,
	 'c_file_type' => $c_file_type,
    'edited_at'   => $today,
    'edited_by'   => $this->session->userdata('userid')
];

if (!empty($image_name)) {
    $data['c_image'] = $image_name;
}

if (!empty($image_name)) {
		$data['c_image'] = $image_name;
	}
	
	if($c_file_type=="File"){
		$data['c_url'] = '';
		$data['c_text'] = '';
		if (!empty($pdf_file)) {
		$data['c_pdf'] = $pdf_file;
		$data['c_url'] = '';
		$data['c_text'] = '';
		}
	}
	else if($c_file_type=="URL"){
if (!empty($c_url)) {
		$data['c_url'] = $c_url;
		$data['c_pdf'] = '';
		$data['c_text'] = '';
	}
	}
	else {
if (!empty($c_text)) {
		$data['c_text'] = $c_text;
		$data['c_pdf'] = '';
		$data['c_url'] = '';
	}
	}

 if ($this->Sju_management_model->update_news($editid, $data))
    {
		
			$this->Sju_management_model->delete_news_department($editid);
		
		foreach($c_type as $_department){
		$data_department = [
        'news_id'       => $editid,
        'c_department'        => $_department];
		$this->Sju_management_model->insert_news_department($data_department);
	}
		
		
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
    }}

	
	
	
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

    $this->form_validation->set_rules('event_name', 'Event name', 'required|trim|min_length[2]');
    $this->form_validation->set_rules('description', 'Description', 'required|trim|min_length[2]');
	$this->form_validation->set_rules('c_type[]', 'Show in', 'required');
	$this->form_validation->set_rules('d_start_date','Event Start Date','required');
	$this->form_validation->set_rules('d_end_date','Event End Date','required');
    $this->form_validation->set_rules( 'c_url','URL','trim|valid_url');    
  
    

        
    

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'event_name' => form_error('event_name'),
                'description'  => form_error('description'),
				  'd_start_date' => form_error('d_start_date'),
				   'd_end_date' => form_error('d_end_date')
            ]
        ]);
        return;
    }

    $event_name = $this->input->post('event_name', TRUE);
	$c_type = $this->input->post('c_type', TRUE);
	$c_url = $this->input->post('c_url', TRUE);
	$c_file_type = $this->input->post('c_file_type', TRUE);
	$c_text = $this->input->post('c_text', TRUE);
	$c_registration = $this->input->post('c_registration', TRUE);
	$c_registration_link = $this->input->post('c_registration_link', TRUE);
	$c_venue = $this->input->post('c_venue', TRUE);
	$c_phone = $this->input->post('c_phone', TRUE);
	$c_email = $this->input->post('c_email', TRUE);
    // Slug
    $slug = url_title($event_name, '-', TRUE);
    $slug = $this->Sju_management_model->unique_event_slug($slug);

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/events/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_event_image($upload_data);
    }



// ==================== IMAGE OR PDF ====================
$pdf_file = null;

if (!empty($_FILES['c_pdf']['name']))
{
    $config2 = [];
    $config2['upload_path']   = './assets/admin/uploads/events/pdf/';
    $config2['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
    $config2['encrypt_name']  = TRUE;
    $config2['max_size']      = 10240;

    $this->upload->initialize($config2); // ? reinitialize

    if (!$this->upload->do_upload('c_pdf'))
    {
        echo json_encode([
            'status'  => false,
            'message' => $this->upload->display_errors('', '')
        ]);
        return;
    }

    $upload_data2 = $this->upload->data();
    $pdf_file     = $upload_data2['file_name'];

   
}

    /* ================= DB DATA ================= */
	$event_date_input = $this->input->post('d_start_date', TRUE);
    $d_start_date = date('Y-m-d', strtotime($event_date_input));
	$d_date_end_input = $this->input->post('d_end_date', TRUE);
    $d_end_date = date('Y-m-d', strtotime($d_date_end_input));
    $data = [
        'event_name'       => $event_name,
        'slug'        => $slug,
        'description' => $this->input->post('description', TRUE),
        'c_image'       => $image_name,
		'd_start_date' => $d_start_date,
		'd_end_date' => $d_end_date,
		'c_file_type' => $c_file_type,
		'c_url' => $c_url,
		'c_pdf' => $pdf_file,
		'c_text' => $c_text,
		'c_registration' => $c_registration,
		'c_registration_link' => $c_registration_link,
		'c_venue' => $c_venue,
		'c_phone' => $c_phone,
		'c_email' => $c_email,
        'created_at'  => $today,
        'created_by'    => $this->session->userdata('userid')
    ];
	
	
	
	$insert_id = $this->Sju_management_model->insert_event($data);

if($insert_id){
	
	
	foreach($c_type as $_department){
		$data_department = [
        'events_id'       => $insert_id,
        'c_department'        => $_department];
		$this->Sju_management_model->insert_events_department($data_department);
	}
}


if ($insert_id)
{
    echo json_encode([
        'status' => true,
        'msg'    => 'Event added successfully',
        'slug'   => $slug
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

	private function _resize_event_image($upload_data)
{
    $this->load->library('image_lib');

    $sizes = [
        'large'  => [800, 800],
        'medium' => [400, 400],
        'thumb'  => [150, 150]
    ];

    foreach ($sizes as $folder => $size)
    {
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $upload_data['full_path'],
            'new_image'      => './assets/admin/uploads/events/'.$folder.'/'.$upload_data['file_name'],
            'maintain_ratio' => TRUE,
            'width'          => $size[0],
            'height'         => $size[1]
        ];

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
}
	
	
	////////
	
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



public function events_view_loadss()
{
    $search = $this->input->post('searchcontent', TRUE);
    $page   = (int) $this->input->post('page');

    if ($page < 1) $page = 1;

    $data = $this->Sju_management_model->get_events_paginated($search, $page, 10);

    $this->load->view('admin/event_list_ajax', $data);
}

public function event_list_ajax()
{
    $search = $this->input->post('searchcontent', TRUE);
    $page   = (int) $this->input->post('page');

    if ($page < 1) $page = 1;

    $per_page = 10;

    $data = $this->Sju_management_model->get_events_paginated($search, $page, $per_page);

    $this->load->view('admin/event_list_ajax', $data);
}
public function edit_event()
	{
		 $data = $this->input->post(NULL,TRUE);
		 $this->load->view('admin/edit_event',$data);
	}
	
	
	public function update_event()
{
	
	
    $this->output->set_content_type('application/json');
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');
$editid = $this->input->post('editid', TRUE);
    $this->form_validation->set_rules('event_name', 'Event name', 'required|trim|min_length[2]');
    $this->form_validation->set_rules('description', 'Description', 'required|trim|min_length[2]');
	$this->form_validation->set_rules('c_type[]', 'Show in', 'required');
	$this->form_validation->set_rules('d_start_date','Event Start Date','required');
	$this->form_validation->set_rules('d_end_date','Event End Date','required');

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'event_name' => form_error('event_name'),
                'description'  => form_error('description'),
				  'd_start_date' => form_error('d_start_date'),
				  'c_type' => form_error('c_type'),
				  'd_end_date' => form_error('d_end_date')
            ]
        ]);
        return;
    }

    $event_name = $this->input->post('event_name', TRUE);
	$c_type = $this->input->post('c_type', TRUE);
   	$c_url = $this->input->post('c_url', TRUE);
	$c_file_type = $this->input->post('c_file_type', TRUE);
	$c_text = $this->input->post('c_text', TRUE);
	$c_registration = $this->input->post('c_registration', TRUE);
	$c_registration_link = $this->input->post('c_registration_link', TRUE);
	$c_venue = $this->input->post('c_venue', TRUE);
	$c_phone = $this->input->post('c_phone', TRUE);
	$c_email = $this->input->post('c_email', TRUE);

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/events/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_event_image($upload_data);
    }
// ==================== IMAGE OR PDF ====================
$pdf_file = null;

if (!empty($_FILES['c_pdf']['name']))
{
    $config2 = [];
    $config2['upload_path']   = './assets/admin/uploads/events/pdf/';
    $config2['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
    $config2['encrypt_name']  = TRUE;
    $config2['max_size']      = 10240;
  $this->load->library('upload');   // <-- ADD THIS
    $this->upload->initialize($config2); // ? reinitialize

    if (!$this->upload->do_upload('c_pdf'))
    {
        echo json_encode([
            'status'  => false,
            'message' => $this->upload->display_errors('', '')
        ]);
        return;
    }

    $upload_data2 = $this->upload->data();
    $pdf_file     = $upload_data2['file_name'];

   
}
    /* ================= DB DATA ================= */
	$event_date_input = $this->input->post('d_start_date', TRUE);
    $d_start_date = date('Y-m-d', strtotime($event_date_input));
	$d_end_date_input = $this->input->post('d_end_date', TRUE);
    $d_end_date = date('Y-m-d', strtotime($d_end_date_input));
    $data = [
        'event_name'       => $event_name,
        'description' => $this->input->post('description', TRUE),
		 'd_start_date' => $d_start_date,
		 'd_end_date' => $d_end_date,
		'c_file_type' => $c_file_type,
		'c_registration' => $c_registration,
		'c_registration_link' => $c_registration_link,
		'c_venue' => $c_venue,
		'c_phone' => $c_phone,
		'c_email' => $c_email,
        'edited_at'  => $today,
        'edited_by'    => $this->session->userdata('userid')
    ];
if (!empty($image_name)) {
		$data['c_image'] = $image_name;
	}
	
	if($c_file_type=="File"){
		$data['c_url'] = '';
		$data['c_text'] = '';
		if (!empty($pdf_file)) {
		$data['c_pdf'] = $pdf_file;
		$data['c_url'] = '';
		$data['c_text'] = '';
		}
	}
	else if($c_file_type=="URL"){
if (!empty($c_url)) {
		$data['c_url'] = $c_url;
		$data['c_pdf'] = '';
		$data['c_text'] = '';
	}
	}
	else {
if (!empty($c_text)) {
		$data['c_text'] = $c_text;
		$data['c_pdf'] = '';
		$data['c_url'] = '';
	}
	}
if (!empty('$c_registration_link')) {
		$data['c_registration_link'] = $c_registration_link;
	}

      if ($this->Sju_management_model->update_event($editid, $data))
    {
		
		$this->Sju_management_model->delete_events_department($editid);
		
		foreach($c_type as $_department){
		$data_department = [
        'events_id'       => $editid,
        'c_department'        => $_department];
		$this->Sju_management_model->insert_events_department($data_department);
	}
		
		
		
        echo json_encode([
            'status' => true,
            'msg'    => 'Event updated successfully'
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
	
	

//BOOKS SECTION

public function add_book()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/add_book');
	}
	


	
	public function save_book()
{
    $this->output->set_content_type('application/json');
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');

    $this->form_validation->set_rules('c_title', 'Title', 'required|trim|min_length[2]');
    //$this->form_validation->set_rules('c_url', 'Url', 'required|trim|min_length[2]');

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'c_title' => form_error('c_title')
            ]
        ]);
        return;
    }

    $title = $this->input->post('c_title', TRUE);

    // Slug
    $slug = url_title($title, '-', TRUE);
    $slug = $this->Sju_management_model->unique_slug_book($slug);

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/books/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_book_image($upload_data);
    }

    /* ================= DB DATA ================= */

    $data = [
        'title'       => $title,
        'slug'        => $slug,
        'c_url' => $this->input->post('c_url', TRUE),
        'c_image'       => $image_name,
        'created_at'  => $today,
        'added_by'    => $this->session->userdata('userid')
    ];

    if ($this->Sju_management_model->insert_book($data))
    {
        echo json_encode([
            'status' => true,
            'msg'    => 'Book added successfully',
            'slug'   => $slug
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

	private function _resize_book_image($upload_data)
{
    $this->load->library('image_lib');

    $sizes = [
        'large'  => [800, 800],
        'medium' => [400, 400],
        'thumb'  => [150, 150]
    ];

    foreach ($sizes as $folder => $size)
    {
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $upload_data['full_path'],
            'new_image'      => './assets/admin/uploads/books/'.$folder.'/'.$upload_data['file_name'],
            'maintain_ratio' => TRUE,
            'width'          => $size[0],
            'height'         => $size[1]
        ];

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
}

	
	
	public function books_view()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/books_view');
	}
	public function books_view_load()
	{
	
		$data = $this->input->post(NULL,TRUE);
		$this->load->view('admin/books_view_load',$data);
	}
	
	public function update_book_status()
{
    $data = $this->input->post(NULL, TRUE);

    $cid = (int) $data['cnid'];
    $ust = $data['ust'];

    if ($this->Sju_management_model->update_book_status($cid, $ust)) {
        echo 'ok';
    }
}
	public function edit_book()
	{
		 $data = $this->input->post(NULL,TRUE);
		 $this->load->view('admin/edit_book',$data);
	}
	
	
	public function update_book()
{
    $this->output->set_content_type('application/json');
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');
	$editid = $this->input->post('editid', TRUE);
    $this->form_validation->set_rules('c_title', 'Title', 'required|trim|min_length[2]');

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'c_title' => form_error('c_title')
            ]
        ]);
        return;
    }

    $title = $this->input->post('c_title', TRUE);

  

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/books/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,

                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_book_image($upload_data);
    }

    /* ================= DB DATA ================= */

   
 $data = [
    'title'       => $title,
        'c_url' => $this->input->post('c_url', TRUE),
    'edited_at'   => $today,
    'edited_by'   => $this->session->userdata('userid')
];

if (!empty($image_name)) {
    $data['c_image'] = $image_name;
}



 if ($this->Sju_management_model->update_books($editid, $data))
    {
        echo json_encode([
            'status' => 'success',
            'msg'    => 'Book details updated successfully'
        ]);
    }
    else
    {
        echo json_encode([
            'status'  => false,
            'message' => 'Database error. Try again.'
        ]);
    }}


//SLIDERS


public function add_slider()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/add_slider');
	}
	


	
	public function save_slider()
{
    $this->output->set_content_type('application/json');
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');
$this->form_validation->set_rules(
    'c_image',
    'Image',
    'callback_image_check'
);

  if ($this->form_validation->run() === FALSE)
{
    echo json_encode([
        'status' => false,
        'errors' => [
            'c_image' => form_error('c_image') // ðŸ'ˆ image callback error
        ]
    ]);
    return;
}



    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/sliders/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_slider_image($upload_data);
    }

    /* ================= DB DATA ================= */
	$c_title = $this->input->post('c_title', TRUE);	
    $data = [
        'c_image'       => $image_name,
		'c_title'       => $c_title,
        'created_at'  => $today,
        'created_by'    => $this->session->userdata('userid')
    ];

    if ($this->Sju_management_model->insert_slider($data))
    {
        echo json_encode([
            'status' => true,
            'msg'    => 'Slider image added successfully'
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

public function image_check()
{
    if (empty($_FILES['c_image']['name'])) {
        $this->form_validation->set_message(
            'image_check',
            'Please upload an image'
        );
        return FALSE;
    }

    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    $file_ext = strtolower(pathinfo($_FILES['c_image']['name'], PATHINFO_EXTENSION));
    $file_size = $_FILES['c_image']['size']; // bytes

    // Extension check
    if (!in_array($file_ext, $allowed_ext)) {
        $this->form_validation->set_message(
            'image_check',
            'Only JPG, JPEG, PNG or WEBP images are allowed'
        );
        return FALSE;
    }

    // Size check (3MB)
    if ($file_size > (3 * 1024 * 1024)) {
        $this->form_validation->set_message(
            'image_check',
            'Image size must be less than 3MB'
        );
        return FALSE;
    }

    return TRUE;
}


	private function _resize_slider_image($upload_data)
{
    $this->load->library('image_lib');

    $sizes = [
        'large'  => [800, 800],
        'medium' => [400, 400],
        'thumb'  => [150, 150]
    ];

    foreach ($sizes as $folder => $size)
    {
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $upload_data['full_path'],
            'new_image'      => './assets/admin/uploads/sliders/'.$folder.'/'.$upload_data['file_name'],
            'maintain_ratio' => TRUE,
            'width'          => $size[0],
            'height'         => $size[1]
        ];

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
}

	
	
	public function slider_view()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/slider_view');
	}
	public function sliders_view_load()
	{
	
		$data = $this->input->post(NULL,TRUE);
		$this->load->view('admin/sliders_view_load',$data);
	}
	
	public function update_slider_status()
{
    $data = $this->input->post(NULL, TRUE);

    $cid = (int) $data['cnid'];
    $ust = $data['ust'];

    if ($this->Sju_management_model->update_slider_status($cid, $ust)) {
        echo 'ok';
    }
}

public function set_staff_permission()

	{
			 $data = $this->input->post(NULL,TRUE);

		     $this->load->view('admin/set_staff_permission',$data);

	}
	
	public function save_staff_permission()
{
    $editid       = $this->input->post('editid');
    $c_permission = $this->input->post('c_permission');


    $result = $this->Sju_management_model
                   ->save_staff_permission($editid, $c_permission);

    echo json_encode([
        'status' => $result ? 'success' : 'error'
    ]);
}
	




//ANNOUNCEMNENT SECTION

	public function add_announcement()
	{
		
		$this->load->view('admin/header');
		$this->load->view('admin/add_announcement');
	}
	


	
	public function save_announcement()
{
    $this->output->set_content_type('application/json');
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');

    $this->form_validation->set_rules('c_title', 'Title', 'required|trim|min_length[2]');
    $this->form_validation->set_rules('c_news', 'Description', 'required|trim|min_length[2]');
	$this->form_validation->set_rules('c_type[]', 'Show in', 'required');
	$this->form_validation->set_rules('d_start_date','Date','required');
	$this->form_validation->set_rules('d_end_date','Expiry Date','required');

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'c_title' => form_error('c_title'),
                'c_news'  => form_error('c_news'),
				 'd_start_date' => form_error('d_start_date'),
				   'd_end_date' => form_error('d_end_date')
            ]
        ]);
        return;
    }

    $title = $this->input->post('c_title', TRUE);
	$c_type = $this->input->post('c_type', TRUE);
	$c_url = $this->input->post('c_url', TRUE);
	$c_file_type = $this->input->post('c_file_type', TRUE);
	$c_text = $this->input->post('c_text', TRUE);
    // Slug
    $slug = url_title($title, '-', TRUE);
    $slug = $this->Sju_management_model->unique_slug_announcement($slug);

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/announcement/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_news_image($upload_data);
    }



// ==================== IMAGE OR PDF ====================
$pdf_file = null;

if (!empty($_FILES['c_pdf']['name']))
{
    $config2 = [];
    $config2['upload_path']   = './assets/admin/uploads/announcement/pdf/';
    $config2['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
    $config2['encrypt_name']  = TRUE;
    $config2['max_size']      = 10240;

    $this->upload->initialize($config2); // ? reinitialize

    if (!$this->upload->do_upload('c_pdf'))
    {
        echo json_encode([
            'status'  => false,
            'message' => $this->upload->display_errors('', '')
        ]);
        return;
    }

    $upload_data2 = $this->upload->data();
    $pdf_file     = $upload_data2['file_name'];

   
}

    /* ================= DB DATA ================= */
	$event_date_input = $this->input->post('d_start_date', TRUE);
    $d_start_date = date('Y-m-d', strtotime($event_date_input));
	$d__date_end_input = $this->input->post('d_end_date', TRUE);
    $d_end_date = date('Y-m-d', strtotime($d__date_end_input));
    $data = [
        'title'       => $title,
        'slug'        => $slug,
		'c_file_type' => $c_file_type,
		'c_url' => $c_url,
		'c_pdf' => $pdf_file,
		'd_start_date' => $d_start_date,
		 'd_end_date' => $d_end_date,
        'description' => $this->input->post('c_news', TRUE),
        'c_image'       => $image_name,
        'created_at'  => $today,
        'added_by'    => $this->session->userdata('userid')
    ];

   $insert_id = $this->Sju_management_model->insert_announcement($data);

if($insert_id){
	
	
	foreach($c_type as $_department){
		$data_department = [
        'announcement_id'       => $insert_id,
        'c_department'        => $_department];
		$this->Sju_management_model->insert_announcement_department($data_department);
	}
}


if ($insert_id)
{
    echo json_encode([
        'status' => true,
        'msg'    => 'Announcement added successfully',
        'slug'   => $slug
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

	private function _resize_announcement_image($upload_data)
{
    $this->load->library('image_lib');

    $sizes = [
        'large'  => [800, 800],
        'medium' => [400, 400],
        'thumb'  => [150, 150]
    ];

    foreach ($sizes as $folder => $size)
    {
        $config = [
            'image_library'  => 'gd2',
            'source_image'   => $upload_data['full_path'],
            'new_image'      => './assets/admin/uploads/announcement/'.$folder.'/'.$upload_data['file_name'],
            'maintain_ratio' => TRUE,
            'width'          => $size[0],
            'height'         => $size[1]
        ];

        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
    }
}

	
	
	public function announcements_view()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/announcements_view');
	}
	public function announcements_view_load()
	{
	
		$data = $this->input->post(NULL,TRUE);
		$this->load->view('admin/announcements_view_load',$data);
	}
	
	public function update_announcement_status()
{
    $data = $this->input->post(NULL, TRUE);

    $cid = (int) $data['cnid'];
    $ust = $data['ust'];

    if ($this->Sju_management_model->update_announcement_status($cid, $ust)) {
        echo 'ok';
    }
}
	public function edit_announcement()
	{
		 $data = $this->input->post(NULL,TRUE);
		 $this->load->view('admin/edit_announcement',$data);
	}
	
	
	public function update_announcement()
{
    $this->output->set_content_type('application/json');
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');
	$editid = $this->input->post('editid', TRUE);
    $this->form_validation->set_rules('c_title', 'Title', 'required|trim|min_length[2]');
    $this->form_validation->set_rules('c_news', 'Description', 'required|trim|min_length[2]');
	$this->form_validation->set_rules('c_type[]', 'Show in', 'required');
	$this->form_validation->set_rules('d_start_date','Start Date','required');
	$this->form_validation->set_rules('d_end_date','End Date','required');
	

    if ($this->form_validation->run() === FALSE)
    {
        echo json_encode([
            'status' => false,
            'errors' => [
                'c_title' => form_error('c_title'),
                'c_news'  => form_error('c_news'),
				 'd_start_date' => form_error('d_start_date'),
				 'd_end_date' => form_error('d_end_date')
            ]
        ]);
        return;
    }

    $title = $this->input->post('c_title', TRUE);
	$c_type = $this->input->post('c_type', TRUE);
	$c_url = $this->input->post('c_url', TRUE);
	$c_file_type = $this->input->post('c_file_type', TRUE);
	$c_text = $this->input->post('c_text', TRUE);
    // Slug
    //$slug = url_title($title, '-', TRUE);
    //$slug = $this->Sju_management_model->unique_slug($slug);

    /* ================= IMAGE UPLOAD ================= */

    $image_name = null;

    if (!empty($_FILES['c_image']['name']))
    {
        $config['upload_path']   = './assets/admin/uploads/announcement/original/';
        $config['allowed_types'] = 'jpg|jpeg|png|webp';
        $config['encrypt_name']  = TRUE;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('c_image'))
        {
            echo json_encode([
                'status'  => false,
                'message' => $this->upload->display_errors('', '')
            ]);
            return;
        }

        $upload_data = $this->upload->data();
        $image_name  = $upload_data['file_name'];

        // Resize images
        $this->_resize_announcement_image($upload_data);
    }


// ==================== IMAGE OR PDF ====================
$pdf_file = null;

if (!empty($_FILES['c_pdf']['name']))
{
    $config2 = [];
    $config2['upload_path']   = './assets/admin/uploads/announcement/pdf/';
    $config2['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
    $config2['encrypt_name']  = TRUE;
    $config2['max_size']      = 10240;
  $this->load->library('upload');   // <-- ADD THIS
    $this->upload->initialize($config2); // ? reinitialize

    if (!$this->upload->do_upload('c_pdf'))
    {
        echo json_encode([
            'status'  => false,
            'message' => $this->upload->display_errors('', '')
        ]);
        return;
    }

    $upload_data2 = $this->upload->data();
    $pdf_file     = $upload_data2['file_name'];

   
}

    /* ================= DB DATA ================= */
$event_date_input = $this->input->post('d_start_date', TRUE);
    $d_start_date = date('Y-m-d', strtotime($event_date_input));
	$d_end_date_input = $this->input->post('d_end_date', TRUE);
    $d_end_date = date('Y-m-d', strtotime($d_end_date_input));
   
 $data = [
    'title'       => $title,
    'description' => $this->input->post('c_news', TRUE),
	 'd_start_date' => $d_start_date,
	 'd_end_date' => $d_end_date,
	  'c_file_type' => $c_file_type,
    'edited_at'   => $today,
    'edited_by'   => $this->session->userdata('userid')
];

if (!empty($image_name)) {
		$data['c_image'] = $image_name;
	}
	
	if($c_file_type=="File"){
		$data['c_url'] = '';
		$data['c_text'] = '';
		if (!empty($pdf_file)) {
		$data['c_pdf'] = $pdf_file;
		$data['c_url'] = '';
		$data['c_text'] = '';
		}
	}
	else if($c_file_type=="URL"){
if (!empty($c_url)) {
		$data['c_url'] = $c_url;
		$data['c_pdf'] = '';
		$data['c_text'] = '';
	}
	}
	else {
if (!empty($c_text)) {
		$data['c_text'] = $c_text;
		$data['c_pdf'] = '';
		$data['c_url'] = '';
	}
	}


 if ($this->Sju_management_model->update_announcement($editid, $data))
    {
		
		
		$this->Sju_management_model->delete_announcement_department($editid);
		
		foreach($c_type as $_department){
		$data_department = [
        'announcement_id'       => $editid,
        'c_department'        => $_department];
		$this->Sju_management_model->insert_announcement_department($data_department);
	}
		
		
        echo json_encode([
            'status' => 'success',
            'msg'    => 'Announcement details updated successfully'
        ]);
    }
    else
    {
        echo json_encode([
            'status'  => false,
            'message' => 'Database error. Try again.'
        ]);
    }}

	


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */