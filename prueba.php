<?php
require('bootstrap.php');

include("menu.php");

$fch_hoy = date('Y')."-".date('m')."-".date('d');

$fecha_actual = strtotime(date("Y-m-d H:i:00",time()));
$fecha_entrada = strtotime($config['curso_inicio']." 00:00:00");
if($fecha_actual > $fecha_entrada){
        echo $fecha_actual." ".$fecha_entrada;
}else{
        echo "Aun falta algun tiempo";
}
exit;

  $fch = mysqli_query($db_con,"select * from control_acceso where fecha = '".$fch_hoy."'");

 // if (mysqli_num_rows($fch)>0) {} else{
    
  $prf = mysqli_query($db_con,"select distinct idea from departamentos");
  
  while ($prf_id = mysqli_fetch_array($prf)) {
  
  $idea_ac = $prf_id['idea'];

  $time = mysqli_query($db_con, "select fecha from reg_intranet where profesor = '".$idea_ac."' order by fecha desc limit 1");
  $last = mysqli_fetch_array($time);
            
  $t_r0 = explode(" ",$last[0]);
  $dia_hora = cambia_fecha($t_r0[0]);
  $ultima_vez =$t_r0[0];                        
                      
  $t_r1 = explode("-",$ultima_vez);
  $ini = "$t_r1[0]-$t_r1[1]-$t_r1[2]";
  $fin_hoy = date('Y')."-".date('m')."-".date('d');
  $timestamp1 = mktime(0,0,0,$t_r1[1],$t_r1[2],$t_r1[0]); 
  $timestamp2 = mktime(0,0,0,date('m'),date('d'),date('Y'));

  $segundos_diferencia = $timestamp2 - $timestamp1; 
  $dias_diferencia = ceil($segundos_diferencia / (60 * 60 * 24));
  
  if ($dias_diferencia>3) {

  $tel0 = mysqli_query($db_con, "select telefono from departamentos where idea = '$idea_ac'");
  $tel1 = mysqli_fetch_array($tel0);
  if(strlen($tel1[0]) == 9) {
  $mobile.=$tel1[0].","; 
      }
    }
  }
  
  $mobile=substr($mobile,0,strlen($mobile)-1);  

  $text = "Hace más de tres días que no compruebas el estado de tus tareas en la Intranet del Centro. Por favor, accede a la página y supervisa tus tareas.";

  // ENVIO DE SMS
  include_once(INTRANET_DIRECTORY . '/lib/trendoo/sendsms.php');
  $sms = new Trendoo_SMS();
  $sms->sms_type = SMSTYPE_GOLD_PLUS;
  
  $exp_moviles = explode(',', $mobile);
  
  foreach ($exp_moviles as $num_movil) {
    
    $num_movil = trim($num_movil);
    
    if(strlen($num_movil) == 9) {
      $sms->add_recipient('+34'.$num_movil);
    }
    else {
           $obs.= "No se pudo enviar el SMS al tfno. ".$num_movil."\n";
    }
  }
  
  $sms->message = $text;
  $sms->sender = $config['mod_sms_id'];
  $sms->set_immediate();
  if ($sms->validate()) $sms->send();
  
  mysqli_query($db_con,"insert into control_acceso VALUES ('', '$fch_hoy', '$obs')");

  //}
  ?>

