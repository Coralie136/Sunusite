<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('pays_model', 'pays');
		$this->load->model('ages_model', 'age');
		$this->load->model('souscriptions_model', 'souscription');
		$this->load->model('assurables_model', 'assurable');
		$this->load->model('categories_model', 'categorie');
		$this->load->model('article_table', 'article');
		$this->load->model('reseau_table', 'reseau');
		$this->load->model('Image_site_table', 'slider');

		//Librairies
		$this->lang->load('content');
		
		//menu
		$this->data['menu'] = $this->fonctions->menu;
		$this->data['menu']['accueil'] = 'active';
		
		//langue courante		
		$this->lg = $this->lang->lang();
		$this->data['lang'] = $this->lg;
		
		$this->data['titrePage'] = lang('monprofil');

        $this->load->model('reseau_table', 'reseau');
		// $this->output->enable_profiler(TRUE);
	}

	public function index(){
	    //var_dump("home"); die();
		$this->data['description'] = "SUNU GROUP est présent dans plus de 14 pays d'Afrique subsaharienne et compte une vingtaine de filiales & sociétés affiliées. A chaque profil son assurance, Découvrez le votre";
		$this->data['keys'] = '';
		$this->data['acc'] = 'ok';

		if($this->lg == 'fr') $select = "nom_pays, id_pays";
		else $select = "nom_pays_en as nom_pays, id_pays";
		$this->data['payss'] = $this->pays->readOrder($select, array("statut_pays !=" => 3), 'nom_pays ASC');

		if($this->lg == 'fr') $select = "nom_assurable, id_assurable";
		else $select = "nom_assurable_en as nom_assurable, id_assurable";
		$this->data['assurables'] = $this->assurable->readOrder($select, array(), 'ordre ASC');

		if($this->lg == 'fr') $select = "nom_souscription, id_souscription";
		else $select = "nom_souscription_en as nom_souscription, id_souscription";
		$this->data['souscriptions'] = $this->souscription->readOrder($select, array(), 'id_souscription ASC');

		//Actualités
		if($this->lg == 'fr') $select = "texte_article, titre_article, id_article, fichier_article, statut_article";
		else $select = "texte_article_en as texte_article, titre_article_en as titre_article, id_article, fichier_article, statut_article";
		$where = array('statut_article !=' => '3');
		$this->data['actus'] = $this->article->readLimit($select, $where, 4, 'dateCreated_article DESC');

		if($this->lg == 'fr') $select = "nom_categorie, id_categorie";
		else $select = "nom_categorie_en as nom_categorie, id_categorie";
		$this->data['categories'] = $this->categorie->readOrder($select, array(), 'nom_categorie ASC');

		if($this->lg == 'fr') $select = "nom_age, id_age";
		else $select = "nom_age_en as nom_age, id_age";
		$this->data['ages'] = $this->age->readOrder($select, array(), 'id_age ASC');

        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

        $where = array(
            "famille_image" => 'slider',
            "statut_image_site !=" => 3,
        );
        $order = array(
            "id_image_site" => 'DESC'
        );
        $this->data['sliders'] = $this->slider->read("fichier_image", $where, $order);
		//var_dump("ok"); die();
		$this->layout->pages('home_new', $this->data);
	}
}

