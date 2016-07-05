<?php

class somysql{
  var $db;
  
  function __construct(){
    $this->db = new \mysqli($GLOBALS['config']['DB_SERVER'],$GLOBALS['config']['DB_USER'],$GLOBALS['config']['DB_PASSWORD'],$GLOBALS['config']['DB_NAME']);
    if($this->db->connect_error) die("Connect Error (". $this->db->connect_errno .") ". $this->db->connect_error);
    $this->db->set_charset($GLOBALS['config']['DB_CHARSET']); //latin1 is default, use utf8 for full strings comparison (db, table and fields must be utf8_general_ci)
  }
  
  public function query($sql, $asAssocArray=false, $firstLine=false){
    $sql = $this->addPrefixToTables($sql);
    $res = $this->db->query($sql);
    if(!$res){
      throw new Exception($this->db->error . "\n". $sql);
    }
    if($asAssocArray){
      if($firstLine) return $res->fetch_array(MYSQLI_ASSOC);
      while(($assocArray[] = $res->fetch_array(MYSQLI_ASSOC)) || array_pop($assocArray));
      return $assocArray;
    }
    return $res;
  }
  
  public function escape_string($str){
    return $this->db->escape_string($str);
  }
  
  public function insert_id(){
    return $this->db->insert_id;
  }
  
  private function addPrefixToTables($sql){
    return preg_replace("/(__)/", $GLOBALS['config']['DB_TABLES_PREFIX'], $sql);
  }
  
}