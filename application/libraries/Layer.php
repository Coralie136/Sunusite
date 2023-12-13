<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	class Layer {
		private $CI;
		private $contentView  = '';
		private $menu         = '';
		
		//Constructeur
		public function __construct(){
			$this->CI =& get_instance();
		}
		
		public function pages($name, $menu, $data = array()) {
            $this->contentView  .= $this->CI->load->view($name, $data, true);
            $this->menu         .= $this->CI->load->view($menu, $data, true);
            $this->CI->load->view('admin/layer', array('content' => $this->contentView, 'menu' => $this->menu));
		}

	}

/* End of file layer.php */
/* Location: ./application/libraries/layer.php */
?>