$Id: readme.txt,v 1.2 2008/12/09 14:02:28 Vlado Exp $
README for JotLoader ver.1.3.1

* @package JotLoader
* @copyright (C) 2007-2008 Vladimir Kanich
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Originally based on doQment 1.0.0beta (www.pimpmyjoomla.com) - fully reworked

Introduction
------------
JotLoader allows to present files exposed on the Joomla site for download in well-arranged layout. Download files can be grouped in categories with own description and customized layout. To each download file can be assigned Bug Tracker listing with the possibility for registred users to add new problem descriptions and comments. Site administrator can edit/add/delete any text message as well as change the problem status (pending/closed) from site front-end.
Simple statistics of downloads is provided for better administrator overview.

JotLoader component is native Joomla 1.5 solution running on web site without "legacy mode".
More informations on http://www.kanich.net/radio/cms/webprog.

Installation
------------
Upload and install the JotLoader component via Joomla Administrator using the normal procedure (Extensions->Install/Uninstall->Browse/Upload File & Install).
Set up your preferencies and settings for this component (Components->JotLoader->Settings).
Then select in Joomla Administrator proper menu set to which you like to assign the JotLoader content (usually is selected Menu->mainmenu). Pressing of  'New' button and then after selecting 'Select Menu Item Type'->JotLoader on 'New Menu Item' page we can click on JotLoader link. On the coming 'Menu Item :: JotLoader' page we assign name for new menu item and appropriate parameters.

Upgrade from old version
------------------------
Uninstall the old version in Extensions->Install/Uninstall selecting tab "Components" and JotLoader radio button "ON", then press Uninstall button in the toolbar. Database tables of JotLoader will remain intact with the last saved content.
Install new version of JotLoader as described above.

Language setting
------------------------
JotLoader has possibility for selecting two basic language sets - English (en-GB) or German (de-DE). For using German language set is necessary to have German installation of Joomla (e.g. http://www.joomla-grundlagen.de/downloads-joomla-1.5.x-versionen/joomla-v.1.5.2-komplett-deutsch.html) before installation of JotLoader. After the installation you can select language sets in Administrator Extensions->Language Manager which you like to prefere as default (take care for Site/Administrator tabs to select which part of Joomla presentation you like to change). With described change is automatically changed also language set for JotLoader component.

For site front-end you can use any possible language set (included in UTF-8 coding) for your presentation of download files with proper JotLoader settings in Administrator - only Bug Tracker functions & buttons shall remain in basic language set (easy to omit Bug Tracker when you like).

Version history
---------------
2.0   - New features :

*Settings
-advanced settings for download path
-autopublish function
-default category for autopublish

For advanced settings check Advanced checkbox and press Apply on toolbar

*Security
-coded download links
-possibility to move the download root outside Joomla
-security audit for client requests

*Download files management
- changes for easier administration (autopublish, move and new delete functions for group of files, download files sorting and reordering by file title, number of downloads, category, file release date and file name)

*Other changes
- programmed strictly for MVC paradigm
- reworked file autodetect routine
- templated file description in file and menu settings
- search routine for list pages improved

1.3.1 - solved XML parsing problem when creating menu item which includes non-english special characters in download files header
      - missing language translations added
1.3   - multiple assignments of all categories/one selected category to the different menu items with its own layout in the front-end presentation
      - formatting of the category description including of image embedding according the HTML standarts possible
      - reworked and expanded help files
      - French translations for site and administrator pages by Vibby
1.2.2 - security Blind SQL Injection Exploit attack problem solved
      - legacy mode added for Joomla 1.5.x usage
      - changed path recognition of site URL for front-end pages
      - corrections for PHP short_open_tag = Off
1.2.1 - multi-language part / second language set GERMAN (de-DE) added for site/administration/help - thanks Frank Braun
      - changed install/uninstall process (now all tables remains intact after uninstallation incl. settings)

1.2.0 - basic solution for Joomla 1.5.x framework, against ver.1.0.1 (only for Joomla 1.0.x) here is implemented download statistics with selecting filters for file category and file name search.