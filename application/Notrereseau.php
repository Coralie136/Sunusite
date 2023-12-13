<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notrereseau extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('pays_model', 'pays');
        //lien
        $this->load->model('reseau_table', 'reseau');
        $this->load->model('filiale_table', 'filiale');
        $this->load->model('Imageautrepage_table', 'images'); // load the 'Imageautrepage_table' model as 'images'
		//Librairies
		$this->lang->load('content');
		
		//menu
		$this->data['menu'] = $this->fonctions->menu;
		$this->data['menu']['reseau'] = 'active';
		
		//langue courante		
		$this->lg = $this->lang->lang();
		$this->data['lang'] = $this->lg;
		
		$this->data['titrePage'] = lang('reseau');

		// $this->output->enable_profiler(TRUE);
	}

	public function index(){
		$this->data['description'] = "Sunu group est présent dans 14 pays d'Afrique subsaharienne et comptant une vingtaine de filiales & sociétés affiliées.";
		$this->data['keys'] = '';
		$this->data['acc'] = 'reseau';
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

        $where =  array("statut_image_site !=" => 3, "famille_image" => "notrereseau");
        $this->data['images'] = $this->images->read("fichier_image",$where);

		$this->layout->pages('reseau', $this->data);
	}
/***
 * Mis en copmmentaire par JMO pour permettre à l'administrateur de mettre à jours les filiales
 * 25/10/2019
 */
/*
	public function filiales($pays = 'bf'){
		$this->data['description'] = "Sunu group est présent dans 14 pays d'Afrique subsaharienne et comptant une vingtaine de filiales & sociétés affiliées.";
		$this->data['keys'] = '';
		$this->data['titrePage'] = lang('filiales');
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));

		if($this->lg == 'fr'){
			switch ($pays) {
				case 'bf':
					$vue = 'filiales_bf';
					$this->data['titrePage'] = 'Burkina Faso';
					break;
				case 'cm':
					$vue = 'filiales_cm';
					$this->data['titrePage'] = 'Cameroun';
					break;
				case 'cf':
					$vue = 'filiales_cf';
					$this->data['titrePage'] = 'Centrafrique';
					break;
				case 'ci':
					$vue = 'filiales_ci';
					$this->data['titrePage'] = 'Côte d\'Ivoire';
					break;
				case 'ga':
					$vue = 'filiales_ga';
					$this->data['titrePage'] = 'Gabon';
					break;
				case 'gn':
					$vue = 'filiales_gn';
					$this->data['titrePage'] = 'Guinée';
					break;
				case 'ml':
					$vue = 'filiales_ml';
					$this->data['titrePage'] = 'Mali';
					break;
				case 'ng':
					$vue = 'filiales_ng';
					$this->data['titrePage'] = 'Niger';
					break;
				case 'sn':
					$vue = 'filiales_sn';
					$this->data['titrePage'] = 'Sénégal';
					break;
				case 'tg':
					$vue = 'filiales_tg';
					$this->data['titrePage'] = 'Togo';
					break;
				default:
					redirect('notrereseau','refresh');
					break;
			}
			if(!file_exists(FCPATH."application/views/".$vue.".php")) $vue = 'filiales_bf';
		}
		else{
			switch ($pays) {
				case 'bf':
					$vue = 'filiales_bf_en';
					$this->data['titrePage'] = 'Burkina Faso';
					break;
				case 'cm':
					$vue = 'filiales_cm_en';
					$this->data['titrePage'] = 'Cameroun';
					break;
				case 'cf':
					$vue = 'filiales_cf_en';
					$this->data['titrePage'] = 'Centrafrique';
					break;
				case 'ci':
					$vue = 'filiales_ci_en';
					$this->data['titrePage'] = 'Côte d\'Ivoire';
					break;
				case 'ga':
					$vue = 'filiales_ga_en';
					$this->data['titrePage'] = 'Gabon';
					break;
				case 'gn':
					$vue = 'filiales_gn_en';
					$this->data['titrePage'] = 'Guinée';
					break;
				case 'ml':
					$vue = 'filiales_ml_en';
					$this->data['titrePage'] = 'Mali';
					break;
				case 'ng':
					$vue = 'filiales_ng_en';
					$this->data['titrePage'] = 'Niger';
					break;
				case 'sn':
					$vue = 'filiales_sn_en';
					$this->data['titrePage'] = 'Sénégal';
					break;
				case 'tg':
					$vue = 'filiales_tg_en';
					$this->data['titrePage'] = 'Togo';
					break;
				default:
					redirect('notrereseau','refresh');
					break;
			}
			if(!file_exists(FCPATH."application/views/".$vue.".php")) $vue = 'filiales_bf_en';
		}

		$this->layout->pages($vue, $this->data);
	}
*/
	public function filiales($pays = 'bf'){
        //$pays = htmlentities2(trim($pays));
        $this->data['menu'] = $pays;
	    //get country
        if($this->lg == 'fr') $select = "nom_pays, id_pays, lien_site, lien_mbp";
        else $select = "nom_pays_en as nom_pays, id_pays, lien_site, lien_mbp";
        $this->data['payss'] = $this->pays->readOrder($select, array("statut_pays !=" => 3), 'nom_pays ASC');
        //end get country
		$this->data['description'] = "Sunu group est présent dans 14 pays d'Afrique subsaharienne et comptant une vingtaine de filiales & sociétés affiliées.";
		$this->data['keys'] = '';
		$this->data['titrePage'] = lang('filiales');
        $this->data['network'] = $this->reseau->read("facebook, linkedin, sunu_sante", array("is_active" => 1));



		if($this->lg == 'fr'){
		    $vue = "filiale_center";
		    $this->data['labelbouton'] = "Visiter le site web";
            $where      = array(
                'description.statut_description != '     => '3',
                "lien_mbp" => strtolower($pays),
            );
            $filiales = $this->filiale->readFiliales("*", $where);
            if(!empty($filiales)){
                $this->data['filiales'] = $filiales;
                $this->data['titrePage'] = $filiales[0]->nom_pays;

                //var_dump($filiales); die();
            }
            else{
                redirect('notrereseau','refresh');
            }
		}
		else{
		    $vue = "filiale_center_en";
            $this->data['labelbouton'] = "Go to website";
            $where      = array(
                'description.statut_description != '     => '3',
                "lien_mbp" => strtolower($pays),
            );
            $filiales = $this->filiale->readFiliales("*", $where);
            if(!empty($filiales)){
                $this->data['filiales'] = $filiales;
                $this->data['titrePage'] = $filiales[0]->nom_pays_en;
            }
            else{
                redirect('notrereseau','refresh');
            }
		}

		//$this->layout->pages($vue, $this->data);
		$this->layout->pages($vue, $this->data);
	}
}