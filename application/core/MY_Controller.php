<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	//Page info
	protected $data = array();
	protected $viws_dir = 'frontend';
	protected $template = "main";
	protected $skeleton = "skeleton";
	protected $header_view = "header";
	protected $footer_view = "footer";

	//Page contents
	protected $javascript = array();
	protected $css = array();
	protected $fonts = array();

	//Page Meta
	protected $title = FALSE;
	protected $description = FALSE;
	protected $keywords = FALSE;
	protected $author = FALSE;
	
    protected $controller_name = FALSE;
    protected $action_name = FALSE;
	
		
	function __construct()
	{	

		parent::__construct();
        //set the current controller and action name
        $this->controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
        $this->action_name = $this->router->fetch_method();		

        $this->title = $this->controller_name.'-'.$this->action_name;
		
		$this->load->helper(array('cms'));
		
	}
	 
	
	protected function _render($view = '',$renderData="FULLPAGE") {
    
	
        switch ($renderData) {
        case "AJAX"     :
            $this->load->view($view,$this->data);
        break;
        case "JSON"     :
            echo json_encode($this->data);
        break;
        case "FULLPAGE" :
        default         : 
		//static
		$toTpl["javascript"] = $this->javascript;
		$toTpl["css"] = $this->css;
		$toTpl["fonts"] = $this->fonts;
		
		//meta
		$toTpl["title"] = $this->title;
		$toTpl["description"] = $this->description;
		$toTpl["keywords"] = $this->keywords;
		$toTpl["author"] = $this->author;
	
		
		$path = $this->router->fetch_directory() ? $this->router->fetch_directory():'';

        if(empty($view)) {
		    $view_path = $path .'pages/'. ltrim($this->controller_name,$this->router->fetch_directory()).'_'. $this->action_name . '.php'; //set the path off the view
	      
	        if (is_file(APPPATH.'views/'.$view_path)) {
				
	           $view = $view_path;
	        } 
        }

        $toBody["content_body"] = $this->load->view($view,$this->data,true);        
			
		$toBody["header"] = $this->load->view("template/".$this->header_view,$toTpl,true);
		$toBody["footer"] = $this->load->view("template/".$this->footer_view,'',true);

		$toTpl["body"] = $this->load->view("template/".$this->template,$toBody,true);
		
		//render view
		$this->load->view("template/".$this->skeleton,$toTpl);
		 break;
    }
	
	}

}
