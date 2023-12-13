<?php
//if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fonctions{
    //Constructeur
    public function __construct(){
        $this->CI =& get_instance();
    }
    //Interface PUBLIC
    public $menu = array('accueil' => '', 'groupe' => '', 'actualites' => '', 'reseau' => '', 'monbonprofil' => '', 'article' => array('article'   => '',),'post'=> array('post'=> '',),'group' => array('history' => '', 'text' => '', 'director' => '', 'team' => '', ),);
    public $menu2 = array('historique' => '', 'publications' => '', 'chiffres' => '', 'gouv' => '');

    //envoi de mail
    public function sendMail($to, $sujet, $message){

        // var_dump($config); exit;
        $this->CI->load->library('email');
        $this->CI->email->from('profil@monbonprofil.com', 'SUNU - MonBonProfil');
        $this->CI->email->reply_to('profil@monbonprofil.com', 'profil@monbonprofil.com');
        $this->CI->email->to($to);
        $this->CI->email->subject('SUNU - MonBonProfil - '.$sujet);
        $this->CI->email->message($message);

        $this->CI->email->send();
        $this->CI->email->clear();

        // return $this->CI->email->print_debugger();
    }
    
    public function truncate($text, $length = 100, $ending = '...', $exact = true, $considerHtml = false){
        if (is_array($ending)){
            extract($ending);
        }
        if ($considerHtml){
            if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
                return $text;
            }
            $totalLength = mb_strlen($ending);
            $openTags = array();
            $truncate = '';
            preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
            foreach ($tags as $tag) {
                if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                    if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                        array_unshift($openTags, $tag[2]);
                    } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                        $pos = array_search($closeTag[1], $openTags);
                        if ($pos !== false) {
                            array_splice($openTags, $pos, 1);
                        }
                    }
                }
                $truncate .= $tag[1];
     
                $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
                if ($contentLength + $totalLength > $length) {
                    $left = $length - $totalLength;
                    $entitiesLength = 0;
                    if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                        foreach ($entities[0] as $entity) {
                            if ($entity[1] + 1 - $entitiesLength <= $left) {
                                $left--;
                                $entitiesLength += mb_strlen($entity[0]);
                            } else {
                                break;
                            }
                        }
                    }
                    
                    $truncate .= mb_substr($tag[3], 0 , $left + $entitiesLength);
                    break;
                } else {
                    $truncate .= $tag[3];
                    $totalLength += $contentLength;
                }
                if ($totalLength >= $length) {
                    break;
                }
            }
        }else {
            if (mb_strlen($text) <= $length) {
                return $text;
            } else {
                $truncate = mb_substr($text, 0, $length - strlen($ending));
            }
        }
        if (!$exact) {
            $spacepos = mb_strrpos($truncate, ' ');
            if (isset($spacepos)) {
                if ($considerHtml) {
                    $bits = mb_substr($truncate, $spacepos);
                    preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                    if (!empty($droppedTags)) {
                        foreach ($droppedTags as $closingTag) {
                            if (!in_array($closingTag[1], $openTags)) {
                                array_unshift($openTags, $closingTag[1]);
                            }
                        }
                    }
                }
                $truncate = mb_substr($truncate, 0, $spacepos);
            }
        }
     
        $truncate .= $ending;
     
        if ($considerHtml) {
            foreach ($openTags as $tag) {
                $truncate .= '</'.$tag.'>';
            }
        }
     
        return $truncate;
    }

    public function ConvertIntoUrl($str, $charset='utf-8'){
        // Remove all accents.
        /*
        $convertedCharacters = array(
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
        'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
        'Ç' => 'C', 'ç' => 'c',
        'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
        'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
        'ÿ' => 'y',
        'Ñ' => 'N', 'ñ' => 'n'
        );
        
        $str = strtr($str, $convertedCharacters);
        */
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|caron|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
        //$str = wd_remove_accents($str, $charset);
        
        // Put the text in lowercase.
        $str = mb_strtolower($str, 'utf-8');
        
        // Remove all special characters.
        $str = preg_replace('#[^a-z0-9-]#', '-', $str);
        
        // Remove two consecutive dashes (that's not very pretty).
        $str = preg_replace('/--/U', '-', $str);
        
        // Remove words containing less than 2 characters (non significant for the meaning) ??? sisqo
        $return = array();
        $str = explode('-', $str);
        
        foreach($str as $word){
            //if(mb_strlen($word, 'iso-8859-1') <= 2) continue; // ??? sisqo
            $return[] = $word;
        }
        
        $str = trim(implode(' ', $return));
        $str = str_replace(' ', '-', $str);
        $str = str_replace('--', '-', $str);
        // ??? sisqo
        
        return $str;
    }


    function duration($cDate) {
        
        //-----------------
        // DATE PROCESSING
        //-----------------
                                                                                
        $now        = new DateTime('now');
        $cDate      = new DateTime($cDate);
        $duration   = $cDate->diff($now);
        
        $dy = $duration->format('%y');                                                           
        if (empty($dy)) {
            $dm = $duration->format('%m');
            if (empty($dm)) {
                $dd = $duration->format('%d');
                if (empty($dd)) {
                    $dh = $duration->format('%h');
                    if (empty($dh)) {
                        $di = $duration->format('%i');
                        if (empty($di)) {
                            $cDuration  = 'à l\'instant';
                        } else {
                            $cDuration  = ($duration->format('%i') > 1) ? $duration->format('%i').' minutes' : $duration->format('%i').' minute';
                        }
                    } else {
                        $cDuration  = ($duration->format('%h') > 1) ? $duration->format('%h').' heures' : $duration->format('%h').' heure';
                    }
                } else {
                    $cDuration  = ($duration->format('%d') > 1) ? $duration->format('%d').' jours' : $duration->format('%d').' jour';
                }
            } else {
                $cDuration  = ($duration->format('%m') > 1) ? $duration->format('%m').' mois' : $duration->format('%m').' mois';
            }
        } else {
            $cDuration  = ($duration->format('%y') > 1) ? $duration->format('%y').' ans' : $duration->format('%y').' an';
        }
                                                                                
        //-----------------
        
        // return the duration since created date to now
        return 'depuis '.$cDuration;
        
    }
    
    function iDuration($cDate) {
        
        //-----------------
        // DATE PROCESSING
        //-----------------
                                                                                
        $now        = new DateTime('now');
        $cDate      = new DateTime($cDate);
        $duration   = $now->diff($cDate);
                                                                                
        $dy = $duration->format('%y');                                                           
        if (empty($dy)) {
            $dm = $duration->format('%m');
            if (empty($dm)) {
                $dd = $duration->format('%d');
                if (empty($dd)) {
                    $dh = $duration->format('%h');
                    if (empty($dh)) {
                        $di = $duration->format('%i');
                        if (empty($di)) {
                            $cDuration  = 'quelques secondes';
                        } else {
                            $cDuration  = ($duration->format('%i') > 1) ? $duration->format('%i').' minutes' : $duration->format('%i').' minute';
                        }
                    } else {
                        $cDuration  = ($duration->format('%h') > 1) ? $duration->format('%h').' heures' : $duration->format('%h').' heure';
                    }
                } else {
                    $cDuration  = ($duration->format('%d') > 1) ? $duration->format('%d').' jours' : $duration->format('%d').' jour';
                }
            } else {
                $cDuration  = ($duration->format('%m') > 1) ? $duration->format('%m').' mois' : $duration->format('%m').' mois';
            }
        } else {
            $cDuration  = ($duration->format('%y') > 1) ? $duration->format('%y').' ans' : $duration->format('%y').' an';
        }
                                                                                
        //-----------------
        
        // return the duration since created date to now
        return $cDuration;
        
    }
    
    function dDisplay($cDate) {
        
        //-----------------
        // DATE PROCESSING
        //-----------------
        
        $dDate      = DateTime::createFromFormat('Y-m-d', $cDate);
        $dDate      = $dDate->format('d/m/Y');
        
        // return the date displayed in a customed format
        return $dDate;
    }
    
    function dtDisplay($cDate) {
        
        //-----------------
        // DATE PROCESSING
        //-----------------
        
        $cDate      = new DateTime($cDate);
        $months     = array(null, 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        
        $cYear      = $cDate->format('Y');
        $cMonth     = $months[(int)$cDate->format('m')];
        $cDay       = $cDate->format('d');
        $cTime      = $cDate->format('H:i');
        
        $dDate      = 'le '.$cDay.' '.$cMonth.' '.$cYear.' à '.$cTime;
        
        //-----------------
        
        // return the date displayed in a customed format
        return $dDate;
    }
    
    function percentage($value, $total) {
        
        //------------------
        // VALUE PROCESSING
        //------------------
        
        $percent    = ($value * 100) / $total;
        
        //------------------
        
        // return the percentage of the value in the total
        return round($percent, 1);
    }
    
    function expired($date) { // expired = 1, valid = 0
        
        // set a new object datetime from the expire date 
        $eDate  = new DateTime($date);
        
        // set a new object datetime from current date 
        $now    = new DateTime('now');
        
        // test dates and return status, expired or valid
        if ($eDate < $now) {
            
            // define new status expired
            $status = array(
                'expired'   => true,
                'days'      => '0'
                );
            
            // return the status of the date
            return $status;
            
        }
        
        // define 'expired' or 'still valid' 
        $status = array(
            'expired'   => false,
            'days'      => $this->iDuration($date)
            );
        
        // return the status of the date
        return $status;
        
    }
    
    //----------------------------------------
    // CHECK USER'S ACCESS TO A SPECIFIC DATA
    //----------------------------------------
        function grantedAccess ($data) {
            
            // Check if there is a value to check
            if (!empty($data)) {
                
                // Set up value to return
                $granted    = false;
                
                // Set up the new data format
                $data   = 'access'.$data;
                
                // Get the data list
                $access = $this->CI->session->userdata('access');
//                var_dump($data); exit;
                // Check if the sent value corresponds to any data
                if (array_key_exists($data, $access)) {
                    
                    $granted    = str_split($access[$data]);
                    
                }
                
            }
            
            return $granted;
            
        }
    //----------------------------------------    
}
/* End of file fonctions.php */
/* Location: ./application/libraries/fonctions.php */
?>