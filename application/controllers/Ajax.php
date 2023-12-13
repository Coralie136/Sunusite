<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('pays_model', 'pays');
		$this->load->model('ages_model', 'age');
		$this->load->model('souscriptions_model', 'souscription');
		$this->load->model('assurables_model', 'assurable');
		$this->load->model('categories_model', 'categorie');
		
		//langue courante		
		$this->lg = $this->lang->lang();
		$this->data['lang'] = $this->lg;

		// $this->output->enable_profiler(TRUE);
	}

	public function assurable(){
		$id = $this->input->post('id');
		$this->lg = $this->lang->lang();
		// var_dump($this->lg); exit;
		if($this->lg == 'fr') $select = "nom_assurable, assurable.id_assurable";
		else $select = "nom_assurable_en as nom_assurable, assurable.id_assurable";
		
		$this->data['assurables'] = $this->assurable->readAssurable($select, array('id_categorie' => $id));
		// var_dump($this->data['assurables']); exit;
		$this->load->view('assures', $this->data);
	}
}