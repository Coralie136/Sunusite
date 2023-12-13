<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {
    /**
     * Index Page for this controller.
     *
     */
    public function index(){
    	//langue courante		
		$this->lg = $this->lang->lang();
		$data['lang'] = $this->lg;

    	$this->load->model('article_table', 'article');
        $data['items'] = $this->article->readOrder('*', array('statut_article !=' => '3'), 'article.dateCreated_article');

        $this->load->view('sitemap', $data);
    }
}