<?php
function save(){
  $date = date("Y-m-d H:i:s");
  $ip = $_SERVER['REMOTE_ADDR'];
  $res = false;
  try{
    $res = $GLOBALS['db']->query("INSERT INTO
              __coupon
            SET
              name='". $GLOBALS['db']->escape_string($_POST['name']) ."',
              phone='". $GLOBALS['db']->escape_string($_POST['phone']) ."',
              morning='". $GLOBALS['db']->escape_string($_POST['morning']) ."',
              afternoon='". $GLOBALS['db']->escape_string($_POST['afternoon']) ."',
              evening='". $GLOBALS['db']->escape_string($_POST['evening']) ."',
              date='". $date ."',
              ip='". $ip ."'");
  }catch(Exception $e){
    $error = $e->getMessage();
  }
  
  $headers   = array();
  $headers[] = "MIME-Version: 1.0";
  $headers[] = "Content-type: text/html; charset=utf8";
  $headers[] = "From: Coupon <noreply@micronemo.com>";
  $headers[] = "To: Admin <admin@micronemo.com>";
  $headers[] = "X-Mailer: PHP/".phpversion();
  $headers = implode("\r\n", $headers);
  
  if($res){
    $message = "
      <style>
        tr:nth-child(odd) {
          background: #ccf;
        }
        td{
          padding: 4px;
        }
      </style>
      <table>
        <tr><td>Name</td><td>". $_POST['name'] ."</td></tr>
        <tr><td>Phone</td><td>". $_POST['phone'] ."</td></tr>
        <tr><td>Morning</td><td>". YesNo($_POST['morning']) ."</td></tr>
        <tr><td>Afternoon</td><td>". YesNo($_POST['afternoon']) ."</td></tr>
        <tr><td>Evening</td><td>". YesNo($_POST['evening']) ."</td></tr>
        <tr><td>Date</td><td>". $date ."</td></tr>
        <tr><td>IP</td><td>". $ip ."</td></tr>
      </table>";
    @mail("admin@micronemo.com", "Event - Coupon", $message, $headers);
    if($_POST['morning']=="N" && $_POST['afternoon']=="N" && $_POST['evening']=="N"){
      echo "ok-no";
    }else{
      echo "ok";
    }
  }else{
    @mail("admin@micronemo.com", "Event - Coupon : error", $error, $headers);
    echo $error;
  }
}

function YesNo($value){
  return ($value=="O"?"&#10004; Yes":($value=="N"?"No":$value));
}