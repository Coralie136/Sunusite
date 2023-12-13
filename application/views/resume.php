<?php
    if(isset($produits)){
        if(!empty($produits)):
            if($produits[0]->slide != '') $slide = $produits[0]->slide;
            else $slide = 'mixte.jpg';
            $accroche = $produits[0]->accroche;
        else:
            $slide = 'mixte.jpg';
            $accroche = '';
        endif;
    }
    else{
        $slide = 'mixte.jpg';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html xmlns="http://www.w3.ord/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>

<body class="perks " style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; line-height: 18px; margin: 0 0 20px; padding: 0; width: 100% !important">
  <style type="text/css">
    body {
      width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 0; margin-bottom: 20px; line-height: 18px;
      }
      .ExternalClass {
      width: 100%;
      }
  </style>
<table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse">
    </tr>
        <td valign="top" align="center" style="border-collapse: collapse">
            <img src="<?php echo site_url(); ?>assets/images/logo.png" width="92" height="65">
        </td>
    </tr>
    <tr>
        <td valign="top" align="center" style="border-collapse: collapse">
            <table height="100%" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse">
                <tr>
                    <td align="center" valign="middle" style="border-collapse: collapse;"><h2 style="color: #7b7776;">AVEC SUNU ASSURANCES</h2></td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="border-collapse: collapse;"><h3><span style="color:#C6183D;"><?php echo $name; ?></span>, <?php echo $accroche; ?></h3></td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="border-collapse: collapse;"><h3 style="color:#C6183D;"><strong>PRODUITS</strong></h3></td>
                </tr>
                <tr>
                    <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="middle">
        <?php 
            $n = sizeof($produits);
            if($n == 3 ) { $p = '750'; }
            elseif($n == 2 ) {$p = '500';}
            else {$p = '250';}
        ?>

            <table width="<?php echo $p; ?>" height="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse">
                <tr>
                    <?php foreach($produits as $produit): ?>
                    <td width="250" align="center" valign="middle" style="border-collapse: collapse;"><img style="border-radius:200px" src="<?php echo site_url('assets/images/'.$produit->image); ?>" width="200" height="198"></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach($produits as $produit): ?>
                    <td>&nbsp;</td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach($produits as $produit): ?>
                    <td align="center" valign="middle" style="border-collapse: collapse;"><h3><strong><?php echo $produit->nom_produit; ?></strong></h3></td>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach($produits as $produit): ?>
                    <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
                     <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach($produits as $produit): ?>
                    <td align="center" valign="middle" style="border-collapse: collapse;"><p style="color: #777; padding:10px"><?php echo $produit->texte; ?></p></td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="middle"><h3 style="color:#C6183D;" style="border-collapse: collapse;"><?php echo $pays[0]->nom_pays; ?>:</h3></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="border-collapse: collapse;">
        <?php 
            $n = sizeof($contacts);
            if($n == 1) $p = '300';
            else $p = 700;
        ?>
            <table width="<?php echo $p ?>" height="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse">
                <tr>
                    <?php foreach($contacts as $contact): ?>
                    <td width="350" style="border-collapse: collapse;">
                        <table width="90%" align="center" height="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-collapse: collapse">
                          <tr>
                            <td height="35" align="center" valign="middle" bgcolor="#e6e3e4" style="border-collapse: collapse;"><h4 style="color:#C6183D;">SUNU SUNU ASSURANCES <?php echo $contact->nom_type_produit; ?></h4></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle" bgcolor="#e6e3e4" style="border-collapse: collapse;"><p style="color: #000;"><?php echo $contact->contact; ?></p></td>
                          </tr>
                        </table>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="border-collapse: collapse;">&nbsp;</td>
    </tr>
</table>
</body>
</html>
