<?php
function setActive($route){
  return request()->routeIs($route) ? 'active' :'' ;
}
function setSmall($request){
  if($request->wps_monto=="0.00" and $request->wct_id==null){
  echo '<span class="label label-success pull-right">Gratis</span>';
  }
  if($request->wct_id)
  echo '<span class="label label-warning pull-right">Credito</span>';
  if($request->wd_banc)
  echo '<span class="label label-primary pull-right">'.$request->wd_banc.'</span>';
}
?>
