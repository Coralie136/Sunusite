<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('pays_model', 'pays');
		$this->load->model('ages_model', 'age');
		$this->load->model('souscriptions_model', 'souscription');
		$this->load->model('assurables_model', 'assurable');
		$this->load->model('categories_model', 'categorie');
		$this->load->model('Client_contact_model', 'client_contact');

        //lien
        $this->load->model('reseau_table', 'reseau');

		//Librairies
		$this->lang->load('content');
		
		//menu
		$this->data['menu'] = $this->fonctions->menu;
		$this->data['menu']['accueil'] = 'active';
		
		//langue courante		
		$this->lg = $this->lang->lang();
		$this->data['lang'] = $this->lg;
		
		$this->data['titrePage'] = lang('monprofil');
		
		$this->load->model('pays_model', 'pays');
		$this->load->model('ages_model', 'age');
		$this->load->model('souscriptions_model', 'souscription');
		$this->load->model('assurables_model', 'assurable');
		$this->load->model('categories_model', 'categorie');
		$this->load->model('produits_model', 'produit');
		$this->load->model('clients_model', 'clients');
		$this->load->model('produits_type_model', 'type_produit');
		$this->load->model('souscriptions_categorie_model', 'souscription_categorie');

		// $this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		// var_dump($_POST); exit;
		if(isset($_POST) && !empty($_POST)){
			$nom = $this->input->post('nom');
			$prenoms = $this->input->post('prenoms');
			$telephone = $this->input->post('telephone');
			$email = $this->input->post('email');

			$id_pays = $this->input->post('id_pays');
			$id_categorie = $this->input->post('id_categorie');
			$id_age = $this->input->post('id_age');
			$id_souscription = $this->input->post('id_souscription');
			$id_assurable = $this->input->post('id_assurable');

			$this->data['name'] = $prenoms;
			$this->data['email'] = $email;
			$this->data['contacts'] = $this->type_produit->readProd('contact, nom_type_produit', array('id_pays' => $id_pays));
			$this->data['pays'] = $this->pays->read('nom_pays', array('id_pays' => $id_pays));

			//---------------------------------------------------------------------

				// Array of where conditions
				$where	= array(
					'categorie.id_categorie'	=> $id_categorie,
					// 'assurable.id_assurable'	=> $id_assurable,
					'pays_type_produit.id_pays'	=> $id_pays,
					'souscription_categorie_assurable_produit.id_souscription'	=> $id_souscription,
					'age.id_age' => $id_age,
				);

				$n = sizeof($id_assurable);
				$orwhere = array();
				$where['assurable.id_assurable'] = $id_assurable[0];
				if($n > 1):
					for ($i=1; $i < $n ; $i++) { 
						if($id_assurable[$i] != 0) $orwhere[] = $id_assurable[$i];
					}
				endif;

				if($this->lg == 'fr') $select = "produit.nom_produit, produit.texte, produit.priorite, produit.accroche";
				else $select = "produit.nom_produit_en as nom_produit, produit.texte_en as texte, produit.accroche_en as accroche";
				$sql = "SELECT DISTINCT (produit.id_produit), produit.image, produit.slide, produit.priorite, ".$select;
				$sql .= " FROM pays, pays_type_produit, produit, categorie_assurable, categorie_assurable_produit, souscription, age, type_produit, assurable, categorie, souscription_categorie_assurable_produit, age_souscription
				WHERE pays.id_pays = pays_type_produit.id_pays
				AND pays_type_produit.id_type_produit = type_produit.id_type_produit
				AND pays_type_produit.id_type_produit = produit.id_type_produit
				AND produit.id_produit = categorie_assurable_produit.id_produit
				AND categorie_assurable_produit.id_categorie_assurable  = categorie_assurable.id_categorie_assurable
				AND categorie_assurable.id_assurable = assurable.id_assurable
				AND categorie_assurable.id_categorie = categorie.id_categorie
				AND categorie_assurable_produit.id_categorie_assurable_produit = souscription_categorie_assurable_produit.id_categorie_assurable_produit
				AND souscription.id_souscription = souscription_categorie_assurable_produit.id_souscription
				AND souscription.id_souscription = age_souscription.id_souscription
				AND age_souscription.id_age = age.id_age 
				AND age.id_age = ".$id_age."
				AND souscription.id_souscription = ".$id_souscription."
				AND pays.id_pays = ".$id_pays;

				if(!empty($id_assurable)):
					$n = sizeof($id_assurable);
					$assure = array();
					$liste = '';
					for($i=0; $i < $n; $i++) {
						if($id_assurable[$i] != 0) {
							$assure[] = $id_assurable[$i];
							$liste .= $id_assurable[$i].'|';
						}
					}
                    /**
                     * Mis en commentaire par jmo
                     *
					$m = sizeof($assure);
					for($i=0; $i < $m; $i++) {
						if($i == 0) $sql .= " AND ( assurable.id_assurable = ".intval($assure[$i]);
						else $sql .= " OR assurable.id_assurable = ".intval($assure[$i]);
					}
					$sql .= ' ) ORDER BY produit.priorite ASC LIMIT 3';*/
					$m = sizeof($assure);
                    $plus_sql2 = " ";
					$data_assurable = [];
					for($i=0; $i < $m; $i++) {
						if($i == 0){
                            $sql .= " AND ( assurable.id_assurable = ".intval($assure[$i]);
                            $plus_sql2 .= " AND ( assurable.id_assurable = ".intval($assure[$i]);
							$data_assurable[$i] .= intval($assure[$i]);
                        }
						else {
						    $sql .= " OR assurable.id_assurable = ".intval($assure[$i]);
                            $plus_sql2 .= " OR assurable.id_assurable = ".intval($assure[$i]);
							$data_assurable[$i] .= intval($assure[$i]);
                        }
					}
                    $plus_sql2 .= " )";
					$sql .= ' ) ORDER BY produit.priorite ASC LIMIT 3';
				else:
					$sql .= ' ORDER BY produit.priorite ASC LIMIT 3';
					$liste = '';
				endif;

				$produits = $this->db->query($sql)->result();
				$this->data['produits'] = $produits;

				//enregistrement informations
				$req = array(
					'nom' => $nom,
					'prenoms' => $prenoms,
					'email'  => $email,
					'telephone' => $telephone,
					'id_pays' => $id_pays,
					'id_age' => $id_age,
					'id_souscription' => $id_souscription,
					'id_categorie' => $id_categorie,
					'assurables' => $liste
				);

                //creation du client
				//$this->data['id_client'] = $this->clients->create($req);
                 //var_dump($produits); exit;


                /*
                 * Ajouté le 12/03/2018
                 */
                $id_client = $this->data['id_client'] = $this->clients->create($req);
                //envoie de mail
                $nom = htmlentities(trim($nom));
                $id_pays = htmlentities(trim($id_pays));

			//var_dump($plus_sql2); die();
                $this->sendMailToContact($id_pays, $plus_sql2, $id_client, $data_assurable);

			//---------------------------------------------------------------------
		}
		else{
			$this->data['message'] = lang('fill_form');
		}

		$this->layout->pages('profil', $this->data);

	}


	function sendMail(){
		$id_client = $this->input->get('id_client');
		$client = $this->clients->read('*', array('id_client' => $id_client));
		if(!empty($client)){
			$query = "SELECT ";
			$sql = "SELECT DISTINCT (produit.id_produit), produit.nom_produit, produit.image, produit.texte, produit.slide, produit.priorite, produit.accroche
			FROM pays, pays_type_produit, produit, categorie_assurable, categorie_assurable_produit, souscription, age, type_produit, assurable, categorie, souscription_categorie_assurable_produit, age_souscription
			WHERE pays.id_pays = pays_type_produit.id_pays
			AND pays_type_produit.id_type_produit = type_produit.id_type_produit
			AND pays_type_produit.id_type_produit = produit.id_type_produit
			AND produit.id_produit = categorie_assurable_produit.id_produit
			AND categorie_assurable_produit.id_categorie_assurable  = categorie_assurable.id_categorie_assurable
			AND categorie_assurable.id_assurable = assurable.id_assurable
			AND categorie_assurable.id_categorie = categorie.id_categorie
			AND categorie_assurable_produit.id_categorie_assurable_produit = souscription_categorie_assurable_produit.id_categorie_assurable_produit
			AND souscription.id_souscription = souscription_categorie_assurable_produit.id_souscription
			AND souscription.id_souscription = age_souscription.id_souscription
			AND age_souscription.id_age = age.id_age 
			AND age.id_age = ".$client[0]->id_age."
			AND souscription.id_souscription = ".$client[0]->id_souscription."
			AND pays.id_pays = ".$client[0]->id_pays;

			$id_assurable = $client[0]->assurables;
			$n = sizeof($id_assurable);
			$assure = array();
			$liste = '';
			for($i=0; $i < $n; $i++) {
				if($id_assurable[$i] != 0) {
					$assure[] = $id_assurable[$i];
				}
			}

			$m = sizeof($assure);
			for($i=0; $i < $m; $i++) {
				if($i == 0) $sql .= " AND (assurable.id_assurable = ".intval($assure[$i]);
				else $sql .= " OR assurable.id_assurable = ".intval($assure[$i]);
			}
			$sql .= ') ORDER BY produit.priorite ASC LIMIT 3';

			$produits = $this->db->query($sql)->result();
			$this->data['produits'] = $produits;

			$this->data['name'] = $client[0]->prenoms;
			$this->data['email'] = $client[0]->email;
			$this->data['contacts'] = $this->type_produit->readProd('contact, nom_type_produit', array('id_pays' => $client[0]->id_pays));
			$this->data['pays'] = $this->pays->read('nom_pays', array('id_pays' => $client[0]->id_pays));

			header('Content-Type: Content-type: text/html');
			$html = $this->load->view('resume', $this->data, TRUE);	
			// echo $html; exit;
			header('Content-Type: Content-type: text/html');


			$ret = $this->fonctions->sendMail($client[0]->email, 'Vos informations', $html);
			echo 'ok';
		}
	}
	function sendMailToContact($id_contry, $plus_sql2, $id_client, $assures){
        /**
         * DATE : 09/03/2019
         * OBJECTIF : Envoyer mail au administrateur SUNU qui doivent s'occuper du client
         * Auteur : JMO
         */
		$assurable = "";
		//var_dump($assure); die();
		if(!empty($id_contry)){
			$sql = "SELECT contact.* FROM contact "
                    ."JOIN pays ON contact.id_pays = pays.id_pays "
                    ."JOIN assurable ON assurable.id_assurable = contact.id_assurable "
                    ." WHERE contact.id_pays LIKE '$id_contry' AND statut_contact != 3 ";

            $sql .= $plus_sql2;

			$sql_clients = "SELECT * FROM clients "
							." JOIN age ON clients.id_age = age.id_age "
							." JOIN souscription ON souscription.id_souscription = clients.id_souscription "
							." JOIN pays ON pays.id_pays = clients.id_pays "
							." WHERE clients.id_client LIKE '$id_client'";

			//ar_dump($sql_clients); die();
            define("__LOGO__", "http://sunu-group.com/assets/images/logo.png");
            $message = '<html>
                <head>
                    <title>Création de compte</title>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                </head>
                <body>
                    <table id="container" style="width: 100%;margin:auto;border-radius: 5px 5px 0px 0px;">
                        <tr>
                            <td>
                                <table id="table-container" style="width: 100%;margin: auto;border-collapse: collapse;border: 1px solid #c8234a;font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, tahoma ;">
                                    <thead>
                                        <tr id="row-header" align="center">
                                            <th colspan="2" class="td-row-header" id="td-content-row-header" style="height: 40px;border-radius: 5px 5px 0px 0px; border: 1px solid #c8234a;color: #ffffff;font-weight: bold;font-size: 20px;background-color: #c8234a;font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto ;padding:10px;">str_TITLE_MAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row-content-logo">
                                            <td class="td-row-content-logo" style="padding: 25px;">
                                                <!--<img src="LOGO_ECAP" alt="Logo ecap" height="50" width="50" style="max-width: 100px; max-height: 90px;"/>-->
                                            </td>
                                            <td class="td-row-content-logo" align="right" style="padding: 25px;">
                                                <!--<img src="LOGO_ECAP" alt="Logo ecap" height="50" width="50" style="max-width: 100px; max-height: 90px;"/>-->
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <img src="LOGO_SUNU" alt="Logo sunu" style="max-width: 100px; max-height: 90px;"/>
                                            </td>
                                        </tr>
                                        <tr id="row-content-body">
                                            <td colspan="2" class="td-row-content-body" style="padding: 10px;line-height: 35px;color: #444; font-size: 18px;">
                                                Bonjour<!--Mr/Mme/Mlle <span style="color: #c8234a">str_NAME</span>-->,<br />
                                                Le prospect <b><span style="color: #c8234a">str_NAME_PROSPECT</span></b> pourrait être interressé(e) par des offres en assurance avec les caractéristiques ci-après :<br/>
                                                <b>- Assurable(s)</b> : str_ASSURABLE <br/>
                                                <b>- Pays</b> : str_PAYS <br/>
                                                <b>- Catégorie(s)</b> : str_CATEGORIE <br/>
                                                <b>- Tranche d\'âge</b> : str_TRANCHE_AGE ans<br/>
                                                <b>- Montant à épargner</b> : str_MONTANT_SOUSCRIT <br/>
                                                <b><u>Contact du prospect :</u></b> <br/>
                                                <b>E-mail</b> : <b style="color: #c8234a">str_EMAIL</b> <br>
                                                <b>Téléphone</b> : <b style="color: #c8234a">str_TELEPHONE</b> <br> <br>
                                                <hr style="color:red">
                                                Veuillez cliquer sur ce <a href="__LINK__">lien</a> pour accéder à la plateforme.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>';
            $message = str_replace('LOGO_SUNU', __LOGO__, $message);
            $message = str_replace('str_TITLE_MAIL', "NOUVEAU CLIENT", $message);
            $message = str_replace('__LINK__', "http://www.sunu-group.com", $message);

			$query_clients = $this->db->query($sql_clients)->result();
			//var_dump($query_clients); die();
			foreach ($query_clients as $client){
				$message = str_replace('str_TRANCHE_AGE', $client->nom_age, $message);
				$message = str_replace('str_MONTANT_SOUSCRIT', $client->nom_souscription, $message);
				$message = str_replace('str_EMAIL', $client->email, $message);
				$message = str_replace('str_TELEPHONE', $client->telephone, $message);
				$message = str_replace('str_NAME_PROSPECT', strtoupper($client->nom.' '.$client->prenoms), $message);
				$message = str_replace('str_PAYS', strtoupper($client->nom_pays), $message);
			}
			//creation de la requete pour récuperer les assurable
			foreach($assures as $assure){
				$sql_assurable = "SELECT nom_categorie, nom_assurable FROM assurable, categorie, categorie_assurable "
								." WHERE assurable.id_assurable LIKE $assure"
									." AND categorie_assurable.id_assurable = assurable.id_assurable "
									."AND categorie_assurable.id_categorie = categorie.id_categorie LIMIT 1";

				$query_categorie_assurable = $this->db->query($sql_assurable)->result();

				$assurable .= $query_categorie_assurable[0]->nom_assurable.", ";
			}

			$message = str_replace('str_ASSURABLE', $assurable, $message);
			$message = str_replace('str_CATEGORIE', $query_categorie_assurable[0]->nom_categorie, $message);

			$query_contacts = $this->db->query($sql)->result();
			$administrateur_filiale = "";
			foreach ($query_contacts as $contact){
                $message = str_replace('str_NAME', $contact->nom_contact, $message);
                //envoie du mail au different administrateur filiale
                $this->fonctions->sendMail($contact->email_contact, 'INFORMATION CLIENT', $message);
                $req_client_contact = array(
                    'id_clients' => $id_client,
                    'id_contact' => $contact->id_contact
                );
               // var_dump($req_client_contact);die();
                //creation du client
                $this->client_contact->create($req_client_contact);
            }

		}
	}
}
