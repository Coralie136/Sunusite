<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legroupe extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('post_table', 'publication'); 
        $this->load->library('Ajax_pagination');
        $this->perPage = 8;

        //models    
        $this->load->model('experience_table', 'experience'); // load the 'experience_table' model as 'experience'
        $this->load->model('history_table', 'historique'); // load the 'history_table' model as 'historique'
        $this->load->model('log', 'log_file'); // load the log model as 'log_file'
        $this->load->model('team_table', 'equipe'); // load the 'team_table' model as 'equipe'
        $this->load->model('text_table', 'texte'); // load the 'text_table' model as 'texte'
        $this->load->model('text_type', 'typeTexte'); // load the 'text_type' model as 'typeTexte'
        $this->load->model('text_type', 'typeTexte'); // load the 'text_type' model as 'typeTexte'
        $this->load->model('Imageautrepage_table', 'images'); // load the 'Imageautrepage_table' model as 'images'

        //chiffres clé moyen
        $this->load->model('Chiffre_cle_table', 'chiffrecle'); // load the 'chiffreclemoyen_table' model as 'chiffreclemoyen'

        //lien
        $this->load->model('reseau_table', 'reseau');
		//Librairies
		$this->lang->load('content');
		
		//menu
		$this->data['menu'] = $this->fonctions->menu;
		$this->data['menu2'] = $this->fonctions->menu2;
		$this->data['menu']['groupe'] = 'active';
		
		//langue courante		
		$this->lg = $this->lang->lang();
		$this->data['lang'] = $this->lg;
		
		$this->data['titrePage'] = lang('groupe');

		// $this->output->enable_profiler(TRUE);
	}

	public function index(){
		$this->data['description'] = "Sunu Group est leader de l'assurance Vie sur toute la zone de la Conférence Interafricaine des Marchés d'Assurances depuis cinq ans. Qui sommes-nous ?";
		$this->data['keys'] = '';
		$this->data['titrePage'] = lang('groupe');
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

		if($this->lg == 'fr') $select = "contenu_texte, statut_texte, id_type_texte";
		else $select = "contenu_texte_en as contenu_texte, statut_texte, id_type_texte";

		//Qui Sommes-nous?
		$where = array('statut_texte !=' => '3', 'id_type_texte' => 3);
		$this->data['qui'] = $this->texte->read($select, $where);

		//Filiales
		$where = array('statut_texte !=' => '3', 'id_type_texte' => 4);
		$this->data['filiales'] = $this->texte->read($select, $where);

		//ambitions
		$where = array('statut_texte !=' => '3', 'id_type_texte' => 5);
		$this->data['ambitions'] = $this->texte->read($select, $where);

        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

        $where =  array("statut_image_site !=" => 3, "famille_image" => "legroupe");

        $this->data['images'] = $this->images->read("fichier_image",$where);

		$this->layout->pages('quisommesnous', $this->data);

	}

	public function chiffrescles(){

		$this->data['description'] = '';
		$this->data['keys'] = '';
		$this->data['titrePage'] = lang('chiffres');
		$this->data['menu2']['chiffres'] = 'photo-gris';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));
        $this->data['chiffrecle'] = $this->chiffrecle->getLastChiffre( 'dateCreated_chiffre_cle IS NOT NULL', array("statut_chiffre_cle" => 1), "*"); //1 is active | 0 is desabled
        //var_dump($this->data['chiffrecle']); die();
        //var_dump($this->data['moyens']); die();

        $where =  array("statut_image_site !=" => 3, "famille_image" => "chiffrescles");
        $this->data['images'] = $this->images->read("fichier_image",$where);

		if($this->lg == 'fr') $page = 'chiffrescles.php';
		else $page = 'chiffrescles_en.php';
		$this->layout->pages($page, $this->data);
	}

	public function historique(){
		$this->data['description'] = '';
		$this->data['keys'] = '';
		$this->data['titrePage'] = lang('history');
		$this->data['menu2']['historique'] = 'photo-gris';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));
        $this->perPage = 6;

		if($this->lg == 'fr') $select = "annee_historique, mois_historique, texte_historique";
		else $select = "annee_historique, mois_historique, texte_historique_en as texte_historique";

        // execute the query and return all the required rows
        $where = array('statut_historique !=' => '3');
        $annees = $this->historique->getHistory(array('limit'=>$this->perPage), $where);
        $totalRec = count($annees);

        //pagination configuration
        $config['target']      = '#hists';
        $config['base_url']    = site_url().$this->lg.'/legroupe/ajaxPaginationDataHistory/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);
        $annees = $this->historique->getHistory(array('limit'=>$this->perPage), $where);

		$n = sizeof($annees);
		for ($i=0; $i < $n; $i++) { 
			$dates = $this->historique->readOrder($select, array('statut_historique !=' => '3', 'annee_historique' => $annees[$i]->annee_historique), 'annee_historique DESC');
			$annees[$i]->dates = $dates;
		}
		// var_dump($annees[15]); exit;

        $where =  array("statut_image_site !=" => 3, "famille_image" => "historique");
        $this->data['images'] = $this->images->read("fichier_image",$where);

		$this->data['annees'] = $annees;
		$this->layout->pages('historique', $this->data);
	}

    function ajaxPaginationDataHistory(){
    	// var_dump($_POST); exit;
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        $this->perPage = 6;

		if($this->lg == 'fr') $select = "annee_historique, mois_historique, texte_historique";
		else $select = "annee_historique, mois_historique, texte_historique_en as texte_historique";

        // execute the query and return all the required rows
        $where = array('statut_historique !=' => '3');
        $annees = $this->historique->getHistory(array('limit'=>$this->perPage), $where);
        $totalRec = count($annees);

        //pagination configuration
        $config['target']      = '#hists';
        $config['base_url']    = site_url().$this->lg.'/legroupe/ajaxPaginationDataHistory/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);
        $annees = $this->historique->getHistory(array('start'=>$offset,'limit'=>$this->perPage), $where);

		$n = sizeof($annees);
		for ($i=0; $i < $n; $i++){
			$dates = $this->historique->readOrder($select, array('statut_historique !=' => '3', 'annee_historique' => $annees[$i]->annee_historique), 'annee_historique DESC');
			$annees[$i]->dates = $dates;
		}
		// var_dump($annees[15]); exit;

		$this->data['annees'] = $annees;
        //load the view
        // $this->layout->pages('det_photos', $this->data);
        $this->load->view('ajax-pagination-data-history', $this->data, false);
    }

	public function gouvernance(){
		$this->data['description'] = "SUNU Participations Holding SA est administrée par un Conseil d’Administration composé de quatre (04) membres nommés par l’Assemblée Générale des actionnaires.";
		$this->data['keys'] = '';
		$this->data['titrePage'] = lang('gouvernance');
		$this->data['menu2']['gouv'] = 'photo-gris';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

		if($this->lg == 'fr') $select = "contenu_texte, statut_texte, id_type_texte";
		else $select = "contenu_texte_en as contenu_texte, statut_texte, id_type_texte";

		//administration
		$this->data['administration'] = $this->texte->read($select, array('id_type_texte' => 1, 'statut_texte !=' => '3'));

		//direction
		$this->data['direction'] = $this->texte->read($select, array('id_type_texte' => 2, 'statut_texte !=' => '3'));

		//directeurs
		if($this->lg == 'fr') $select = "nom_equipe, prenom_equipe, fonction_equipe, biographie_equipe, fichier_equipe, id_equipe";
		else $select = "nom_equipe, prenom_equipe, fonction_equipe_en as fonction_equipe, biographie_equipe_en as biographie_equipe, fichier_equipe, id_equipe";

		$this->data['directeur'] = $this->equipe->read($select, array('directeur_equipe' => 1, 'statut_equipe !=' => '3'));

		//expérience directeur
		if(!empty($this->data['directeur'])){
			if($this->lg == 'fr') $sel1 = "periode_experience, texte_experience";
			else $sel1 = "periode_experience, texte_experience_en as texte_experience";
			$this->data['experiences'] = $this->experience->read($sel1, array('id_equipe' => $this->data['directeur'][0]->id_equipe, 'statut_experience !=' => '3'));
		}

		$this->data['equipes'] = $this->equipe->readOrder($select, array('directeur_equipe !=' => 1, 'statut_equipe !=' => '3'), 'id_equipe DESC');

		$where =  array("statut_image_site !=" => 3, "famille_image" => "gouvernance");
        $this->data['images'] = $this->images->read("fichier_image",$where);

		$this->layout->pages('gouvernance', $this->data);
	}

	public function publications(){
		$this->data['description'] = '';
		$this->data['keys'] = '';
		$this->data['titrePage'] = lang('publications');
		$this->data['menu2']['publications'] = 'photo-gris';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

		if($this->lg == 'fr') $select = "titre_publication, texte_publication, fichier_publication";
		else $select = "titre_publication_en as titre_publication, texte_publication_en as texte_publication, fichier_publication_en as fichier_publication";

        // execute the query and return all the required rows
        $where = array('statut_publication !=' => '3');
        $publications = $this->publication->getPubli(array(), $where, $select);
        $totalRec = count($publications);

        //pagination configuration
        $config['target']      = '#pubs';
        $config['base_url']    = site_url().$this->lg.'/legroupe/ajaxPaginationDataPublication/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);
        $this->data['publications'] = $this->publication->getPubli(array('limit'=>$this->perPage), $where, $select);

        $where =  array("statut_image_site !=" => 3, "famille_image" => "publications");
        $this->data['images'] = $this->images->read("fichier_image",$where);

		$this->layout->pages('publications', $this->data);
	}

    function ajaxPaginationDataPublication(){
    	// var_dump($_POST); exit;
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

		if($this->lg == 'fr') $select = "titre_publication, texte_publication, fichier_publication";
		else $select = "titre_publication_en as titre_publication, texte_publication_en as texte_publication, fichier_publication_en as fichier_publication";
        
        //total rows count
        $where = array('statut_publication !=' => '3');
		$publications = $this->publication->getPubli(array(), $where, $select);
        $totalRec = count($publications);
        
        //pagination configuration
        $config['target']      = '#pubs';
        $config['base_url']    = site_url().$this->lg.'/legroupe/ajaxPaginationDataPublication/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);
		$this->data['publications'] = $this->publication->getPubli(array('start'=>$offset,'limit'=>$this->perPage), $where, $select);
        
        //load the view
        // $this->layout->pages('det_photos', $this->data);
        $this->load->view('ajax-pagination-data-publication', $this->data, false);
    }
}