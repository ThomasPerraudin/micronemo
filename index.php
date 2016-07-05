<?php
include(__DIR__ ."/config.inc.php");

if(isset($_REQUEST['action'])){ //action=filename.method
  list($filename,$method) = explode(".",$_REQUEST['action']);
  include(__DIR__ ."/php/ax".$filename.".php"); //ajax scripts must be prefifexed with 'ax'.
  $method();
  exit(0);
}

$page = isset($_REQUEST['page'])?$_REQUEST['page']:$config["DEFAULT_PAGE"];
if(!is_file(pageFilename($page))) $page = $config["NOT_FOUND_PAGE"];

if(!isAjax()) include(pageFilename($config["HEADER_PAGE"]));
include(pageFilename($page));
if(!isAjax()){
  echo "<!-- Rendered with MicrOnemo -->";
  include(pageFilename($config["FOOTER_PAGE"]));
}
