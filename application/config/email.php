<?php
    $config['useragent']    = 'PHPMailer';
    $config['protocol']     = 'smtp';
    $config['smtp_host']    = 'server143.web-hosting.com';
    $config['smtp_port']    = 465;
    $config['smtp_user']    = 'profil@monbonprofil.com';
    $config['smtp_pass']    = 'Sunu@Profil';
    $config['smtp_crypto']  = 'ssl';
    $config['charset']      = 'utf-8';
    $config['mailtype']     = 'html';
    $config['newline']      = "\r\n";

    $config['mailpath']         = '/usr/sbin/sendmail';
    $config['smtp_timeout']     = 30;
    $config['smtp_debug']       = 0;

    $config['smtp_auto_tls']    = false;

    //$config['smtp_conn_options'] = array();
    $config['smtp_conn_options'] = array(
        'ssl' => 
        array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false,
        ),
    );

    $config['wordwrap']         = true;
    $config['wrapchars']        = 76;

    $config['validate']         = true;
    $config['priority']         = 3;                        

    $config['crlf']             = "\n";                     // "\r\n" or "\n" or "\r"
    $config['newline']          = "\r\n";                     // "\r\n" or "\n" or "\r"
    $config['bcc_batch_mode']   = false;
    $config['bcc_batch_size']   = 200;
    $config['encoding']         = '8bit';
?>