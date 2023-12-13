<?php
	class User extends MY_Model {
		
		protected $ma_table = 'user';
		
//		public function getLiveAccount($user = array()){
//            if (!empty($user)) {
//                return $this->db->select('account_user')
//                             ->from($this->ma_table)
//                             ->where($user)
//                             ->get()
//                             ->result();
//            }
//		}
		
		public function getUser($select = '*', $where = array()){
			return $this->db->select($select)
						 ->from($this->ma_table)
						 ->where($where)
						 ->get()
						 ->result();
		}

//		public function apiAuth($apiKey){
//	        return $query = $this->db->select('apiKey_user, account_user, id_user, status_user')
//	            		  ->from($this->ma_table)
//	            		  ->where(array('apiKey_user' => $apiKey))
//	            		  ->get()
//	            		  ->result();
//		}

	    //générer les Unique ID
	    public function get_unused_id(){
	        // Create a random user id between 1200 and 4294967295
	        $random_unique_int = 2147483648 + mt_rand( -2147482448, 2147483647 );

	        // Make sure the random user_id isn't already in use
	        $query = $this->db->select('id_user' )
	            		  ->from( $this->ma_table )
	            		  ->where(array('id_user' => $random_unique_int))
	            		  ->get()
	            		  ->result();

	        if( !empty($query) ){

	            // If the random user_id is already in use, try again
	            return $this->get_unused_id();
	        }

	        return $random_unique_int;
	    }

	    public function random_salt(){
	        return md5( mt_rand() );
	    }

	    public function hash_passwd( $password, $random_salt ){
	        /**
	         * bcrypt is the preferred hashing for passwords, but
	         * is only available for PHP 5.3+. Even in a PHP 5.3+ 
	         * environment, we have the option to use PBKDF2; just 
	         * set the PHP52_COMPATIBLE_PASSWORDS constant located 
	         * in config/constants.php to 1.
	         */
	        if( CRYPT_BLOWFISH == 1 && PHP52_COMPATIBLE_PASSWORDS === 0 )
	        {
	            return crypt($password . config_item('encryption_key'), '$2a$09$' . $random_salt . '$' );
	        } else {
				var_dump("BCRYPT N EST PAS DISPO");
			}

	        // Fallback to PBKDF2 if bcrypt not available
	        $this->load->helper('pbkdf2'); // constant file

	        /**
	         * Key length (param #5) set at 30 so that pbkdf2() 
	         * returns a string which has a length that matches 
	         * the length of the `user_pass` field (60 chars).
	         */
	        return pbkdf2( 'sha256', $password . config_item('encryption_key'), $random_salt, 4096, 30, FALSE );
	    }

		function get_password($longueur=6) { // par défaut, on affiche un mot de passe de 6 caractères
		    // chaine de caractères qui sera mise dans le désordre:
		    $Chaine = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // 62 caractères au total
		    // on mélange la chaine avec la fonction str_shuffle(), propre à PHP
		    $Chaine = str_shuffle($Chaine);
		    // ensuite on coupe à la longueur voulue avec la fonction substr(), propre à PHP aussi
		    $Chaine = substr($Chaine,0,$longueur);
		    // ensuite on retourne notre chaine aléatoire de "longueur" caractères:
		    return $Chaine;
		}


	}
?>