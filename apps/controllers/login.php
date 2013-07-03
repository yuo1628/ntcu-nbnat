<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginController extends MY_Controller {

	/**
	 * Index Page for Login controller.
	 */
	public function index($mes="")
	{
				
		if($this->session->userdata("user")){
			$state["state"]=$this->userMeta();	
		}
		else
		{
			$state["state"]=$this->loginView($mes);	
		}
				
		$this->layout->setLayout('layout/login');		
		$this->layout->view('view/login/default',$state);
	}
	private function loginView($mes) {
		if($mes=="error")
		{
			$mes="帳號或密碼錯誤";
		}	
		return $this->load->view('view/login/login',array("mes"=>$mes),TRUE);		
	}
	private function userMeta() {		
		return $this->load->view('view/userMeta',"",TRUE);		
	}
	public function setSessionValue() {
		/*$value = $this->input->post("value");
		$key = $this->input->post("key");
		
		$this->session->set_userdata($key, $value);
		echo $this->session->userdata($key);
		 * 
		 */
		
	}
	
	public function getSessionValue() {
		/*$key = $this->input->post("key");
		if($this->session->userdata($key))
		{
			echo $this->session->userdata($key);
		}
		else 
		{
			echo '0';
		}*/
		$user=$this->session->userdata("user");
		echo $user[0]->rank;
	}
	
	public function login() 
	{
		$username=$this->input->post("username");
		$password=$this->input->post("password");
		
		$this -> load -> model('member_model', 'member');			
		$userMeta	=	$this -> member -> get(array(
													"username"=>$username,
													"password"=>$password));
		if(count($userMeta)>0)
		{
			$this->session->set_userdata("user", $userMeta);
			echo "success";
		}
		else
		{
			//$this->index("error");
			echo "error";
		}
	}
	public function logout() 
	{		
		$this->session->unset_userdata("user");
		$this->index();
	}
}
