<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotFound extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		//Librairies
		$this->lang->load('content');
		//lien
        $this->load->model('reseau_table', 'reseau');
		
		//menu
		$this->data['menu'] = $this->fonctions->menu;
		$this->data['menu2'] = $this->fonctions->menu2;
		
		//langue courante		
		$this->lg = $this->lang->lang();
		$this->data['lang'] = $this->lg;
		
		$this->data['titrePage'] = lang('groupe');
	}
	
	public function index(){
		$this->data['description'] = '';
		$this->data['keys'] = '';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));
		
		$this->layout->pages('notfound', $this->data);
	}
}
