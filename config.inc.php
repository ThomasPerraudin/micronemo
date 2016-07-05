<?php
  
  $config = array();
  
  //MicrOnemo App
  $config["DEFAULT_PAGE"] = "home"; //page to display at startup
  $config["HEADER_PAGE"] = "header"; //page for site header
  $config["FOOTER_PAGE"] = "footer"; //page for site footer
  $config["NOT_FOUND_PAGE"] = "404"; //page not found
  
  //MySQL
  $config["DB_SERVER"] = "_SERVER_";
  $config["DB_NAME"] = "_DBNAME_";
  $config["DB_USER"] = "_USERNAME_";
  $config["DB_PASSWORD"] = "_PASSWORD_";
  $config["DB_TABLES_PREFIX"] = "micronemo_";
  $config["DB_CHARSET"] = "utf8";
  
  include(__DIR__ ."/class.somysql.inc.php");
  $db = new somysql();
  
  function pageFilename($page){ return __DIR__ ."/php/". $page .".php"; }
  function isAjax(){ return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'); }
