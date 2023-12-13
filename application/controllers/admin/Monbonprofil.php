<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monbonprofil extends CI_Controller{

    public function __construct(){

        parent::__construct();

        $this->load->model('clients_model', 'clients');
        $this->load->model('assurables_model', 'assurables');
        $this->load->model('pays_model', 'pays');
        $this->load->model('assurables_model', 'assurable');
        //ajouté par JMO le 23/04/2019 pour prendre en compte la demande de SUNU
        $this->load->model('categories_model', 'categorie');
        $this->load->model('ages_model', 'age');
        $this->load->model('souscriptions_model', 'souscription');
        // check if that user has a valid (active) session
        if ($this->session->userdata('logged_in') == ''){

            // redirect to the authentification form
            redirect('admin');

        }

        //-----------------------------------------------
        // SET AND GET ALL THE DATA ABOUT USER CONNEXION
        //-----------------------------------------------

        // get the user session data
        $logged_in = $this->session->userdata('logged_in');
        $this->data['logged_in'] = $logged_in;

        // set the title of the current page
        $this->data['page_title']       = 'Mon Bon Profil';
        $this->data['page_description'] = 'Mon Bon Profil';

        // get the class menu property
        $this->data['menu']             = $this->fonctions->menu;

        // set the active menu item
        $this->data['menu']['monbonprofil']   = 'active open';

        //-----------------------------------------------

        // get all chars arrays
        $this->data['signed_letters']   = unserialize(SIGNED_LETTERS);
        $this->data['signs']            = unserialize(SIGNS);
    }

    //-----------------------------------
    // DISPLAY ALL THE ARTICLES INSERTED
    //-----------------------------------
    public function index() {

        //------------------------------------------------------
        // SET ALL THE CSS AND JS REQUIRED FOR THE CURRENT PAGE
        //------------------------------------------------------
        $this->search();

    }

    //ajouté par jmo
    function search(){

        // all the js required
        $this->data['javascripts'] = array(
            'global/scripts/datatable.js',
            'global/plugins/datatables/datatables.min.js',
            'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js',
            'pages/scripts/table-datatables-managed.js',
            'global/plugins/select2/js/select2.full.min.js',
            'pages/scripts/components-select2.min.js',
            'pages/scripts/components-date-time-pickers.js',
            'global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js',
            'pages/scripts/custom.js',
            'pages/scripts/custom.js',
            'pages/scripts/mombonprofile.js',
        );
        // all the css required
        $this->data['css'] = array(
            'global/plugins/datatables/datatables.css',
            'global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css',
            'global/plugins/select2/css/select2.min.css',
            'global/plugins/select2/css/select2-bootstrap.min.css',
            'global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css',
        );

        /**Ajuter par JMO le 19/03/2019
         * Pour prise en compte de recherche parametré
         **/
        /*if($this->lg == 'fr') $select = "nom_pays, id_pays";
        else $select = "nom_pays_en as nom_pays, id_pays";*/
        $select = "nom_pays, id_pays";
        $this->data['payss'] = $this->pays->readOrder($select, array(), 'nom_pays ASC');

        /*if($this->lg == 'fr') $select = "nom_assurable, id_assurable";
        else $select = "nom_assurable_en as nom_assurable, id_assurable";*/
        $select = "nom_assurable, id_assurable";
        $this->data['assurables'] = $this->assurable->readOrder($select, array(), 'ordre ASC');

        $select = "nom_categorie, id_categorie";
        $this->data['categories'] = $this->categorie->readOrder($select, array(), 'id_categorie ASC');

        $select = "nom_souscription, id_souscription";
        $this->data['souscriptions'] = $this->souscription->readOrder($select, array(), 'id_souscription ASC');

        $select = "nom_age, id_age";
        $this->data['ages'] = $this->age->readOrder($select, array(), 'id_age ASC');
        $this->data['post'] = '';
        /**
         * FIN AJOUT
         **/

        //constitution de la close where de la requete
        if(!empty($_POST)){
            $this->data['post'] = 'post';
            $dt_date_debut = $this->input->post('dt_date_debut');
            $dt_date_fin = $this->input->post('dt_date_fin');
            $this->data['dt_post_date_debut'] = $dt_date_debut;
            $this->data['dt_post_date_fin'] = $dt_date_fin;

            $date=date_create($dt_date_debut);
            $dt_date_debuts= date_format($date,"Y/m/d H:i:s");

            $date=date_create($dt_date_fin);
            $dt_date_fins = date_format($date,"Y/m/d H:i:s");
            //echo $dt_date_fin; die();
            $aujourdhui = date("d-m-Y");
            $date=date_create($aujourdhui);
            $aujourdhui= date_format($date,"Y/m/d H:i:s");

            $id_pays = $this->input->post('id_pays');
            $this->data['id_post_pays'] = $id_pays;
            $id_assurable = $this->input->post('id_assurable[]');
            $this->data['id_post_assurable'] = $id_assurable;
            $exporter = $this->input->post('exporter');
            $this->data['post_exporter'] = $exporter;
            $str_CATEGORIE = $this->input->post('str_CATEGORIE');
            $this->data['post_CATEGORIE'] = $str_CATEGORIE;
            $str_AGE = $this->input->post('str_AGE');
            $this->data['post_AGE'] = $str_AGE;
            $int_MONTANT = $this->input->post('int_MONTANT');
            $this->data['post_MONTANT'] = $int_MONTANT;
            //var_dump($id_assurable);die();
            $where = "WHERE";
            $cpt = 0;
            if($dt_date_fins>$aujourdhui) $dt_date_fins = $aujourdhui;
            if($dt_date_debuts>$aujourdhui) $dt_date_debuts = $aujourdhui;

            if($dt_date_debuts>$dt_date_fins AND !empty($dt_date_fin))
            {
                $interm = $dt_date_fins;
                $dt_date_fins = $dt_date_debuts;
                $dt_date_debuts = $interm;
            }
            for($i=0; $i<sizeof([$id_assurable]); $i++){
                if($i==0)
                {
                    $where .= " assurables LIKE '%".$id_assurable[$i]."%'";
                }
                else{
                    $where .= " OR assurables LIKE '%".$id_assurable[$i]."%'";
                }
            }

            if(!empty($dt_date_debut) AND !empty($dt_date_fin) ){
                if(!empty($where) && $where != "WHERE") $where .= " AND ";
                if($dt_date_debuts==$dt_date_fins)
                {
                    $where .= " dates_inscription LIKE '".date("Y-m-d")."%'";
                }
                else{
                    $where .= " dates_inscription BETWEEN '".$dt_date_debuts."' AND '".$dt_date_fins."' ";
                }
            }
            elseif(!empty($dt_date_debut)){
                if(!empty($where) && $where != "WHERE") $where .= " AND ";
                $where .= " dates_inscription LIKE '".$dt_date_debuts."'";
            }


            if(!empty($id_pays)){
                if(!empty($where) && $where != "WHERE") $where .= " AND ";
                $where .= " pays.id_pays LIKE '$id_pays'";
            }
            if(!empty($str_CATEGORIE)){
                if(!empty($where) && $where != "WHERE") $where .= " AND ";
                $where .= " categorie.id_categorie LIKE '$str_CATEGORIE'";
            }
            if(!empty($str_AGE)){
                if(!empty($where) && $where != "WHERE") $where .= " AND ";
                $where .= " age.id_age LIKE '$str_AGE'";
            }
            if(!empty($int_MONTANT)){
                if(!empty($where) && $where != "WHERE") $where .= " AND ";
                $where .= " souscription.id_souscription LIKE '$int_MONTANT'";
            }

        }
        else{
            $dt_date_debut  = date("d-m-Y", strtotime(date('d-m-Y'). "- 1 year"));
            $dt_date_fin = date("d-m-Y", strtotime(date('d-m-Y'). "+ 1 day"));


            $date=date_create($dt_date_debut);
            $dt_date_debuts= date_format($date,"Y/m/d H:i:s");

            $date=date_create($dt_date_fin);
            $dt_date_fins = date_format($date,"Y/m/d H:i:s");

            $where = "";
            if(!empty($dt_date_debut) AND !empty($dt_date_fin) ){
                if(!empty($where) && $where != "WHERE") $where .= " AND ";
                if($dt_date_debuts==$dt_date_fins)
                {
                    $where .= " WHERE dates_inscription LIKE '".date("Y-m-d")."%'";
                }
                else{
                    $where .= " WHERE dates_inscription BETWEEN '".$dt_date_debuts."' AND '".$dt_date_fins."' ";
                }
            }
        }
        if($where == "WHERE") $where = "";
        //var_dump($where); die();

        $sql = "SELECT * FROM clients "
            ."JOIN pays ON pays.id_pays = clients.id_pays "
            ."JOIN souscription ON souscription.id_souscription = clients.id_souscription "
            ."JOIN categorie ON categorie.id_categorie = clients.id_categorie "
            ."JOIN age ON age.id_age = clients.id_age ".$where;

        //echo $dt_date_debut." ".$dt_date_fin;die();
        //echo $sql; die();
        $clients = $this->db->query($sql)->result();

        //fin constitution de la close where

        //$clients = $this->clients->readClients();
        //var_dump($clients); die();
        $n = sizeof($clients);
        for ($i=0; $i < $n; $i++) {
            $assurables = '';
            $list = explode('|', $clients[$i]->assurables);
            $p = sizeof($list);
            for ($j=0; $j < $p; $j++) {
                if($list[$j] != ''){
                    $assure = $this->assurables->read('nom_assurable', array('id_assurable' => $list[$j]));
                    $assurables .= $assure[0]->nom_assurable.'<br/>';
                }
            }
            $clients[$i]->assurables = $assurables;
        }

        if(!empty($dt_date_debut)) {
            $clients[$i-1]->dt_date_debut = $dt_date_debut;
            var_dump($dt_date_debut);
        } else {
            
            var_dump($clients[$i-1]->dt_date_debut);
        }

        if(!empty($dt_date_fin)) $clients[$i-1]->dt_date_fin = $dt_date_fin;
        if(!empty($id_pays)) $clients[$i-1]->id_pays = $id_pays;
        if(!empty($id_assurable)) $clients[$i-1]->id_assurable = $id_assurable;

        $this->data['clients'] = $clients;

        if(isset($exporter) && !empty($exporter)){

            $titre = "Liste Clients - MonBonProfil";
            $this->load->library('PHPExcel');
            //activate worksheet number 1
            $this->phpexcel->setActiveSheetIndex(0);

            $this->phpexcel->getProperties()->setCreator("SUNU - MonBonProfil")
                ->setLastModifiedBy("SUNU - MonBonProfil")
                ->setTitle($titre);
            // set default font
            $this->phpexcel->getDefaultStyle()->getFont()->setName('Arial');
            // set default font size
            $this->phpexcel->getDefaultStyle()->getFont()->setSize(10);

            //préserver les zéros en début de chaine
            $this->phpexcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $this->phpexcel->getActiveSheet()->setCellValue("A1", "Nom et prénoms");
            $this->phpexcel->getActiveSheet()->setCellValue("B1", "Téléphone");
            $this->phpexcel->getActiveSheet()->setCellValue("C1", "Email");
            $this->phpexcel->getActiveSheet()->setCellValue("D1", "Pays");
            $this->phpexcel->getActiveSheet()->setCellValue("E1", "Catégorie");
            $this->phpexcel->getActiveSheet()->setCellValue("F1", "Tranches d'âge");
            $this->phpexcel->getActiveSheet()->setCellValue("G1", "Souscription");
            $this->phpexcel->getActiveSheet()->setCellValue("H1", "Assurables");
            $this->phpexcel->getActiveSheet()->setCellValue("I1", "Date d'inscription");

            for ($i = 'A'; $i !=  $this->phpexcel->getActiveSheet()->getHighestColumn(); $i++) {
                $this->phpexcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
            }

            $j = 2;
            foreach($clients as $client):
                $this->phpexcel->getActiveSheet()->getStyle("B$j")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $this->phpexcel->getActiveSheet()->setCellValue("A$j", $client->nom.' '.$client->prenoms);
                $this->phpexcel->getActiveSheet()->setCellValue("B$j", $client->telephone);
                $this->phpexcel->getActiveSheet()->setCellValue("C$j", $client->email);
                $this->phpexcel->getActiveSheet()->setCellValue("D$j", $client->nom_pays);
                $this->phpexcel->getActiveSheet()->setCellValue("E$j", $client->nom_categorie);
                $this->phpexcel->getActiveSheet()->setCellValue("F$j", $client->nom_age);
                $this->phpexcel->getActiveSheet()->setCellValue("G$j", $client->nom_souscription);
                $this->phpexcel->getActiveSheet()->setCellValue("H$j", $client->assurables);
                $this->phpexcel->getActiveSheet()->setCellValue("I$j", $client->dates_inscription);
                $j++;
            endforeach;

            $this->phpexcel->getActiveSheet()->getStyle("A1:I1")->applyFromArray(
                array(
                    'font' => array(
                        'bold' => true
                    )
                )
            );

            $this->phpexcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

            // var_dump($this->phpexcel); exit;
            //Header excel
            $fileName = 'monbonprofil_'.date('dmYHis').'.xls';
            header('Content-type: application/vnd.ms-excel');
            // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.$fileName.'"');
            header('Cache-Control: max-age=0');
            $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
            //var_dump($this->phpexcel); die();
            $objWriter->save('php://output');
        }
        // include the view with all the data requested

        $this->data['menu']['filiale']['filiale']    = '';
        $this->data['menu']['contact']['contact']    = '';
        $this->data['menu']['group']['network']    = '';
        $this->data['menu']['group']['director']    = '';
        $this->data['menu']['group']['text']    = '';
        $this->data['menu']['image']['image']    = '';
        $this->data['menu']['image']['slider']    = '';
        $this->data['menu']['pays']['pays']    = '';
        $this->data['menu']['chiffre_cle']['chiffre_cle']    = '';

        $this->layer->pages('admin/monbonprofil', 'admin/include/menu', $this->data);
    }
    //ajoute par jmo

    function export(){
        $titre = "Liste Clients - MonBonProfil";

        //constitution de la close where de la requete

        $clients = $this->clients->readClients();
        $n = sizeof($clients);
        for ($i=0; $i < $n; $i++) {
            $assurables = '';
            $list = explode('|', $clients[$i]->assurables);
            $p = sizeof($list);
            for ($j=0; $j < $p; $j++) {
                if($list[$j] != ''){
                    $assure = $this->assurables->read('nom_assurable', array('id_assurable' => $list[$j]));
                    $assurables .= $assure[0]->nom_assurable.', ';
                }
            }
            $clients[$i]->assurables = $assurables;
        }
        $this->load->library('PHPExcel');
        //activate worksheet number 1
        $this->phpexcel->setActiveSheetIndex(0);

        $this->phpexcel->getProperties()->setCreator("SUNU - MonBonProfil")
            ->setLastModifiedBy("SUNU - MonBonProfil")
            ->setTitle($titre);
        // set default font
        $this->phpexcel->getDefaultStyle()->getFont()->setName('Arial');
        // set default font size
        $this->phpexcel->getDefaultStyle()->getFont()->setSize(10);

        //préserver les zéros en début de chaine
        $this->phpexcel->getActiveSheet()->getStyle('B1')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

        $this->phpexcel->getActiveSheet()->setCellValue("A1", "Nom et prénoms");
        $this->phpexcel->getActiveSheet()->setCellValue("B1", "Téléphone");
        $this->phpexcel->getActiveSheet()->setCellValue("C1", "Email");
        $this->phpexcel->getActiveSheet()->setCellValue("D1", "Pays");
        $this->phpexcel->getActiveSheet()->setCellValue("E1", "Catégorie");
        $this->phpexcel->getActiveSheet()->setCellValue("F1", "Tranches d'âge");
        $this->phpexcel->getActiveSheet()->setCellValue("G1", "Souscription");
        $this->phpexcel->getActiveSheet()->setCellValue("H1", "Assurables");
        $this->phpexcel->getActiveSheet()->setCellValue("I1", "Date d'inscription");

        for ($i = 'A'; $i !=  $this->phpexcel->getActiveSheet()->getHighestColumn(); $i++) {
            $this->phpexcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        $j = 2;
        foreach($clients as $client):
            $this->phpexcel->getActiveSheet()->getStyle("B$j")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $this->phpexcel->getActiveSheet()->setCellValue("A$j", $client->nom.' '.$client->prenoms);
            $this->phpexcel->getActiveSheet()->setCellValue("B$j", $client->telephone);
            $this->phpexcel->getActiveSheet()->setCellValue("C$j", $client->email);
            $this->phpexcel->getActiveSheet()->setCellValue("D$j", $client->nom_pays);
            $this->phpexcel->getActiveSheet()->setCellValue("E$j", $client->nom_categorie);
            $this->phpexcel->getActiveSheet()->setCellValue("F$j", $client->nom_age);
            $this->phpexcel->getActiveSheet()->setCellValue("G$j", $client->nom_souscription);
            $this->phpexcel->getActiveSheet()->setCellValue("H$j", $client->assurables);
            $this->phpexcel->getActiveSheet()->setCellValue("I$j", $client->dates_inscription);
            $j++;
        endforeach;

        $this->phpexcel->getActiveSheet()->getStyle("A1:I1")->applyFromArray(
            array(
                'font' => array(
                    'bold' => true
                )
            )
        );

        $this->phpexcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // var_dump($this->phpexcel); exit;
        //Header excel
        $fileName = 'monbonprofil_'.date('dmYHis').'.xls';
        header('Content-type: application/vnd.ms-excel');
        // header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpexcel, 'Excel5');
        $objWriter->save('php://output');
    }
}
?>