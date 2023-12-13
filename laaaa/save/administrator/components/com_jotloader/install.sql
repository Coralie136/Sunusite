-- version $Id: install.sql,v 1.4 2008/12/13 14:42:01 Vlado Exp $
-- package JotLoader
-- copyright (C) 2008 Vladimir Kanich
-- license http://www.gnu.org/copyleft/gpl.html GNU/GPL

CREATE TABLE IF NOT EXISTS `#__jotloader_bugs` (
`bug_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`file_id` INT NOT NULL,
`bug_title` VARCHAR( 255 ) NOT NULL ,
`bug_desc` TEXT NOT NULL ,
`bug_status` TINYINT NOT NULL,
`bug_dadded` DATETIME NOT NULL
);
CREATE TABLE IF NOT EXISTS `#__jotloader_stats` (
`stat_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`file_id` INT NOT NULL,
`stat_address` VARCHAR( 50 ) NOT NULL ,
`stat_host` VARCHAR( 255 ) NOT NULL ,
`stat_dadded` DATETIME NOT NULL
);
CREATE TABLE IF NOT EXISTS `#__jotloader_config` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`setting_name` varchar(64) NOT NULL default '',
`setting_value` text NOT NULL,
PRIMARY KEY  (`id`)
);
CREATE TABLE IF NOT EXISTS `#__jotloader_cats` (
`cat_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`parent_id` INT NOT NULL ,
`cat_title` VARCHAR( 255 ) NOT NULL,
`cat_description` TEXT NOT NULL,
`ordering` smallint(4) NOT NULL default '0',
`published` tinyint(1) NOT NULL default '0',
`checked_out` int(11) NOT NULL default '0',
`checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
`mark` varchar(50) default NULL,
`cat_subdir` varchar(255) NOT NULL,
`cat_subdir_default` tinyint(1) NOT NULL
);
CREATE TABLE IF NOT EXISTS `#__jotloader_files` (
`file_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
`file_title` varchar(255) NOT NULL default '',
`file_path` varchar(255) NOT NULL default '',
`version` varchar(255) NOT NULL default '',
`license_type` varchar(255) NOT NULL default '',
`cat_id` int(11) NOT NULL default '0',
`size` varchar(255) NOT NULL default '',
`date_added` varchar(255) NOT NULL default '',
`date_added2` datetime NOT NULL default '0000-00-00 00:00:00',
`url_download` varchar(255) NOT NULL default '',
`url_home` varchar(255) NOT NULL default '',
`author` varchar(255) NOT NULL default '',
`url_author` varchar(255) NOT NULL default '',
`downloads` int(11) NOT NULL default '0',
`ordering` smallint(4) NOT NULL default '0',
`published` tinyint(1) NOT NULL default '0',
`checked_out` int(11) NOT NULL default '0',
`checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
`description` text,
`mark` varchar(50) default NULL,
`not_valid` tinyint(1) NOT NULL default '0'
);
CREATE TABLE IF NOT EXISTS `#__jotloader_comments` (
`comment_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`rel_id` INT NOT NULL,
`comment_title` VARCHAR( 255 ) NOT NULL ,
`comment_desc` TEXT NOT NULL ,
`comment_type` VARCHAR( 10 ) NOT NULL ,
`comment_dadded` DATETIME NOT NULL
);
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (1, 'files.uploaddir', 'download');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (2, 'templates.cats.cat',  '<h2>{cat_title}</h2>\r\n <p>{cat_description}</p> {files} <hr/>');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (3, 'templates.files.file', '<table width="100%" border="0" cellpadding="2" cellspacing="5" style="background:#F8F8F8;border-bottom:1px solid #cccccc;">\r\n	<tr><td colspan="7"><em>{file_description}</em></td></tr>\r\n	<tr><td width="23%"><b>{file_title}</b></td>\r\n	<td width="5%">{version}</td>\r\n	<td width="8%">{license_type}</td>\r\n	<td width="7%">{size}</td>\r\n	<td width="15%">{date_added}</td>\r\n	<td width="10%"><a href="{url_download}" target="_blank">Download</a></td>\r\n	<td width="5%">{downloads}</td></tr><tr>\r\n	<td width="12%"><a href="{url_bugs}">Bug Tracker</a></td><td colspan="6"> </td></tr>\r\n</table>\r\n');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (4, 'global.datetime', 'M d, Y H:i');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (5, 'files.autodetect', '1');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (6, 'templates.files.header', '<table width="100%" border="0" cellpadding="2" cellspacing="5" style="background:#F8F8F8;border-bottom:1px solid #cccccc;">\r\n	<tr><td width="22%"><b>File</b></td>\r\n	<td width="4%">Version</td>\r\n	<td width="7%">Licence</td>\r\n	<td width="8%">Size</td>\r\n	<td width="15%">Added</td>\r\n	<td width="10%"> </td>\r\n	<td width="5%">Hits</td></tr>\r\n</table>\r\n');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (7, 'statistics.on', '1');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (8, 'advanced.on', '0'); 
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (9, 'files.uploadpath', '');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (10, 'files.autopublish', '0');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (11, 'newdir.defaultcat', '0'); 
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (12, 'newcat.order', '0'); 
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (13, 'scan.frontend', '60_0');
INSERT IGNORE INTO `#__jotloader_config` (`id`, `setting_name`, `setting_value`) VALUES (14, 'cat.default', '0');
  
