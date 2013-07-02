<?php  
class Acl {

    private $url_model;
    private $url_method;
    private $CI;
 
    function Acl()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');

        $this->url_model = $this->CI->uri->segment(1);
        $this->url_method = $this->CI->uri->segment(2);
    }
 
    function auth()
    {
        $user = $this->CI->session->userdata('user');		
        if(empty($user))
        {
           $rank = "4";
		}
		else
		{
			$rank=$user[0]->rank;
			
		}
        $this->CI->load->config('acl');       		
		$AUTH = $this->CI->config->item('AUTH');
		
		
		if(empty($this->url_model))
		{
			$this->url_model="login";
		}
			
        if(in_array($rank, array_keys($AUTH)))
        {	        	
           	if(in_array($this->url_model,array_keys($AUTH[$rank])))
            {               
                if(!empty($this->url_method) && !in_array($this->url_method, $AUTH[$rank][$this->url_model]))
                {
                    $this->back_to_login();                 
                }
            }
            else
            {
               $this->back_to_login();
            } 
        }
        else
        {
        	$this->back_to_login();
		} 
	    
    }
	function back_to_login()
	{
		$this->CI->config->load('config');
		$base_url=$this->CI->config->item('base_url');		
        header("Location: ".$base_url."login");
	}

}