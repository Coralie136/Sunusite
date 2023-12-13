<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Actualites extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('article_table', 'article');
        $this->load->model('photo_table', 'photo');
        $this->load->model('Imageautrepage_table', 'images'); // load the 'Imageautrepage_table' model as 'images'
        //lien
        $this->load->model('reseau_table', 'reseau');
        $this->load->library('Ajax_pagination');
        $this->perPage = 3;

		//Librairies
		$this->lang->load('content');
		
		//menu
		$this->data['menu'] = $this->fonctions->menu;
		$this->data['menu']['actualites'] = 'active';
		
		//langue courante		
		$this->lg = $this->lang->lang();
		$this->data['lang'] = $this->lg;
		
		$this->data['titrePage'] = lang('actualites');

		// $this->output->enable_profiler(TRUE);
	}

    public function index(){
        $this->data['description'] = '';
        $this->data['keys'] = '';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

        if($this->lg == 'fr') $select = "titre_article, texte_article, fichier_article, id_article";
        else $select = "titre_article_en as titre_article, texte_article_en as texte_article, fichier_article, id_article";

        // execute the query and return all the required rows
        $where = array('statut_article !=' => '3');
        $articles = $this->article->getActus(array(), $where, $select);
        $totalRec = count($articles);

        //pagination configuration
        $config['target']      = '#actus';
        $config['base_url']    = site_url().$this->lg.'/actualites/ajaxPaginationData/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);

        $this->data['articles'] = $this->article->getActus(array('limit'=>$this->perPage), $where, $select);

        $where =  array("statut_image_site !=" => 3, "famille_image" => "actualites");
        $this->data['images'] = $this->images->read("fichier_image",$where);

        $this->layout->pages('actualites', $this->data);
    }

	public function detail($lien){
		$this->data['description'] = '';
		$this->data['keys'] = '';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

        if($this->lg == 'fr') $select = "titre_article, texte_article, fichier_article, id_article";
        else $select = "titre_article_en as titre_article, texte_article_en as texte_article, id_article, fichier_article";

        $where =  array("statut_image_site !=" => 3, "famille_image" => "actualites");
        $this->data['images'] = $this->images->read("fichier_image",$where);

        if(!isset($lien) || $lien == ''){
            redirect('actualites');
        }
        else{
            $t = explode('-', $lien);
            $id = $t[0];
            $actualite = $this->article->read($select, array('id_article' => $id, 'statut_article !=' => '3'));
            if(empty($actualite)) redirect('actualites');
            else{
                $where = array('statut_article !=' => '3', 'id_article !=' => $id);
                $this->data['actus'] = $this->article->readLimit($select, $where, 5, 'dateCreated_article DESC');
                $this->data['photos'] = $this->photo->read('*', array('id_article' => $id, 'statut_photo' => '1'));
                $this->data['actualite'] = $actualite;

                $this->layout->pages('det_actualites', $this->data);
            }
        }
	}
    
    function ajaxPaginationData(){
    	// var_dump($_POST); exit;
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        if($this->lg == 'fr') $select = "titre_article, texte_article, fichier_article, id_article";
        else $select = "titre_article_en as titre_article, texte_article_en as texte_article, fichier_article, id_article";
        
        //total rows count
        $where = array('statut_article !=' => '3');
		$articles = $this->article->getActus(array(), $where, $select);
        $totalRec = count($articles);
        
        //pagination configuration
        $config['target']      = '#actus';
        $config['base_url']    = site_url().$this->lg.'/actualites/ajaxPaginationData/';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        
        $this->ajax_pagination->initialize($config);
		$this->data['articles'] = $this->article->getActus(array('start'=>$offset,'limit'=>$this->perPage), $where, $select);
        
        //load the view
        // $this->layout->pages('det_photos', $this->data);
        $this->load->view('ajax-pagination-data', $this->data, false);
    }
}