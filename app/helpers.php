<?php
function setActive($route){
  if(request()->segments()){
  return request()->segments()[0]==$route ? 'active' :'no';
  }
}
function setSmall($request){
  if($request->wps_monto=="0.00" and $request->wct_id==null){
  echo '<span class="label label-success pull-right">Gratis</span>';
  }
  if($request->wct_id)
  echo '<span class="label label-warning pull-right">Credito</span>';
  if($request->wd_banc)
  echo '<span class="label label-primary pull-right">'.$request->wd_banc.'</span>';
  if($request->wdp_pay){
      echo '<span class="label label-danger pull-right">Cancelado</span>';
  }
}
function getPkg($id){
  return App\Paquetes::find($id)->wp_name;
}
function getAvailableIP($sectores,$services){


foreach ($sectores as $sector) {
#    $seg_ip=explode(".",$servis->ip);
$iplistlength=0;
  echo '\'<datalist  id="ipdisponiblesec'.$sector->wsct_id.'">';
  $i=1;
    $seg_ip=explode(".",$sector->ws_ip);
  while ($iplistlength<10) {

          #      echo '<option id="1" value="'.$sector->wsct_address.'"';
          $isIpOnServerList=false;
          foreach($services as $servis){
            $newip=''.$seg_ip[0].'.'.$seg_ip[1].'.'.$seg_ip[2].'.'.$i;
          #    echo '<option id="1" value="'.$servis->ws_ip.'">';

            if($servis->ws_ip==ip2long($newip)){
              $isIpOnServerList=true;
            }
          }
          if(!$isIpOnServerList){
           echo '<option id="1" value="'.$seg_ip[0].'.'.$seg_ip[1].'.'.$seg_ip[2].'.'.$i.'">';
           $iplistlength++;
          }
          $i++;
      }
  echo '    </datalist>\'+';
  }

 


}
function setMonths($i)
{
$months=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
return $months[$i];
}
?>
