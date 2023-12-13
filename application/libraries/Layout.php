<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Layout{
		private $CI;
		private $output = '';
		
		//Constructeur
		public function __construct(){
			$this->CI =& get_instance();
		}
		
		public function pages($name, $data = array()){
			$this->output .= $this->CI->load->view($name, $data,true);
			$this->CI->load->view('default', array('output'	=> $this->output));
		}
	}

/* End of file layout.php */
/* Location: ./application/libraries/layout.php */
?>