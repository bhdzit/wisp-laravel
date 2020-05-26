const mapmarck='<svg xmlns="http://www.w3.org/2000/svg"  width="100" height="100" > <circle cx="50" cy="50" r="40" stroke="green" stroke-width="4" fill="yellow" /> </svg>';
var circlesvg='<svg width="10" height="10"  aria-hidden="true" focusable="false" data-prefix="far" data-icon="circle" class="svg-inline--fa fa-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z"></path></svg>';

var marker;
var map;

function showQR(client){
  console.log(client);
  Swal.fire({
    title: 'Mostrar Qr',
    html: '<div id="qrcode" style=" height:300px; margin-top:15px;"></div>',
    width:'25%',
    showClass: {
      popup: 'animated fadeInDown faster'
    },
    hideClass: {
      popup: 'animated fadeOutUp faster'
    }
    });
    var qrcode = new QRCode(document.getElementById("qrcode"), {
    	width : 300,
    	height : 300
    });
	qrcode.makeCode(client);
}




function showTowerPosition(lng,lat){
        Swal.fire({
        title: 'Ubicacion de Torre',
        html: '<div style="width: 100%; height: 380px" id="mapContainer"></div>',
        width:'80%',
        showClass: {
          popup: 'animated fadeInDown faster'
        },
        hideClass: {
          popup: 'animated fadeOutUp faster'
        }
      });

setMap();
addMarck({lat:lat,lng:lng});
}
function setMap(){

 var platform = new H.service.Platform({
   'apikey': 'SEI-1bn-6vSC9G7pEalClDrOHK1w38l5IUSl_XrE5s0'
   });

    // Obtain the default map types from the platform object
    var defaultLayers = platform.createDefaultLayers();

    //Step 2: initialize a map - this map is centered over Europe
    map = new H.Map(document.getElementById('mapContainer'),
      defaultLayers.vector.normal.map,{
      center: { lat:20.297461, lng:-99.186517},
      zoom: 14,
      pixelRatio: window.devicePixelRatio || 1
    });
      // add a resize listener to make sure that the map occupies the whole container
  window.addEventListener('resize', () => map.getViewPort().resize());

  //Step 3: make the map interactive
  // MapEvents enables the event system
  // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
  var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

  // Create the default UI components
  var ui = H.ui.UI.createDefault(map, defaultLayers);


}
function getCords(evt){
    var coord = map.screenToGeo(evt.currentPointer.viewportX,
            evt.currentPointer.viewportY);

    addMarck({lat:coord.lat,lng:coord.lng});
      $("#torrePoint").val(coord.lat+","+coord.lng);
  //    map.removeEventListener("tap",getCords);
}
function addMarck(cords){
  var svgMarkup = '<svg width="100" height="100" ' +
      'xmlns="http://www.w3.org/2000/svg">' +
    '<circle cx="50" cy="50" r="40" stroke="green" stroke-width="4" fill="yellow" /></svg>';


  var icon = new H.map.Icon("/adminlte/dist/img/zona1.png");
  marker = new H.map.Marker(cords, {icon: icon});
  map.addObject(marker);

}


function setSectorTowerAndAntennasEvents(json){

    var object;
//      const json=JSON.parse(res);

      var selectedTower=document.getElementById("wsct_tower");


      $("#wsct_tower").change(function(evt){
          console.log();
         var lat=json[selectedTower.selectedIndex-1]["wt_lat"], lng=json[selectedTower.selectedIndex-1]["wt_lng"];
        if(object!=null){
          map.removeObject(object);
          map.removeObject(marker);
          }
          object= ($("#wsct_antennatype").val()==1) ? object=dreawSectoralAntenna(lat,lng,$("#wsct_dist").val()):object=dreawOmniAntenna(lat,lng,800);
          addMarck({lat:lat ,lng:lng});
          map.addObject(object);
      });

      $("#wsct_antennatype").change(function(evt){
        if(evt.target.value==1){
          $("#apperdiv").removeClass("hide");
        }
        else{
            $("#apperdiv").addClass("hide");
        }



        var antennatype=$("#wsct_antennatype").val();
        if(object!=null){
          map.removeObject(object);
          map.removeObject(marker);
          }
        if(antennatype!=0 && $("#wsct_tower").val()!=0){

        var lat=json[selectedTower.selectedIndex-1]["wt_lat"], lng=json[selectedTower.selectedIndex-1]["wt_lng"];
          object= (antennatype==1) ? object=dreawSectoralAntenna(lat,lng,$("#wsct_dist").val()):object=dreawOmniAntenna(lat,lng,800);
          addMarck({lat:lat ,lng:lng});
          map.addObject(object);
        }
      });

      $("#wsct_dist").change(function(evt){

        if(antennatype!=0 && $("#wsct_tower").val()!=0){

          if($("#wsct_antennatype").val()==2){

          object.getObjects()[0].setRadius($("#wsct_dist").val());
          // use circle's updated geometry for outline polyline
          var outlineLinestring = object.getObjects()[0].getGeometry().getExterior();

          // extract first point of the outline LineString and push it to the end, so the outline has a closed geometry
          outlineLinestring.pushPoint(outlineLinestring.extractPoint(0));
          object.getObjects()[1].setGeometry(outlineLinestring);
        }
        if($("#wsct_antennatype").val()==1){

          var lat=json[$("#wsct_tower").val()]["wt_ST_Y"], lng=json[$("#wsct_tower").val()]["wt_ST_X"];

          map.removeObject(object);
          object=dreawSectoralAntenna(lat,lng,$("#wsct_dist").val());
          map.addObject(object);

        }
        }
      });
      $("#apper").change(function(){
        var lat=json[selectedTower.selectedIndex-1]["wt_lat"], lng=json[selectedTower.selectedIndex-1]["wt_lng"];

        map.removeObject(object);
        object=dreawSectoralAntenna(lat,lng,$("#wsct_dist").val());
        map.addObject(object);
      });




}

function getSectorialAntennaData(id){
  return $.ajax({
      url:"./controller/sectorController.php",
      data:{"acction":"getData", "id":id},
      type:"POST"
    }).done(function(res){
      res=JSON.parse(res);
      $("#apper").val(res["wsec_rank"]);
      $("#deg").val(res["wsec_deg"]);

    });


}
function dreawOmniAntenna(lat,lng,dist){


  var circle = new H.map.Circle({lat:lat,lng:lng},dist,
        {
          style: {fillColor: 'rgba(250, 250, 0, 0.7)', lineWidth: 0}
        }
      ),
      circleOutline = new H.map.Polyline(
        circle.getGeometry().getExterior(),
        {
          style: {lineWidth: 8, strokeColor: 'rgba(255, 0, 0, 0)'}
        }
      ),
      circleGroup = new H.map.Group({
        volatility: true, // mark the group as volatile for smooth dragging of all it's objects
        objects: [circle, circleOutline]
      }),
      circleTimeout;

  // ensure that the objects can receive drag events
  circle.draggable = true;
  circleOutline.draggable = true;

  // extract first point of the circle outline polyline's LineString and
  // push it to the end, so the outline has a closed geometry
  circleOutline.getGeometry().pushPoint(circleOutline.getGeometry().extractPoint(0));

  // add group with circle and it's outline (polyline)
//  map.addObject(circleGroup);

  // event listener for circle group to show outline (polyline) if moved in with mouse (or touched on touch devices)
  circleGroup.addEventListener('pointerenter', function(evt) {
    var currentStyle = circleOutline.getStyle(),
        newStyle = currentStyle.getCopy({
          strokeColor: 'rgb(255, 0, 0)'
        });

    if (circleTimeout) {
      clearTimeout(circleTimeout);
      circleTimeout = null;
    }
    // show outline
    circleOutline.setStyle(newStyle);
  }, true);

  // event listener for circle group to hide outline if moved out with mouse (or released finger on touch devices)
  // the outline is hidden on touch devices after specific timeout
  circleGroup.addEventListener('pointerleave', function(evt) {
    var currentStyle = circleOutline.getStyle(),
        newStyle = currentStyle.getCopy({
          strokeColor: 'rgba(255, 0, 0, 0)'
        }),
        timeout = (evt.currentPointer.type == 'touch') ? 1000 : 0;

    circleTimeout = setTimeout(function() {
      circleOutline.setStyle(newStyle);
    }, timeout);
    document.body.style.cursor = 'default';
  }, true);

  // event listener for circle group to change the cursor if mouse position is over the outline polyline (resizing is allowed)
  circleGroup.addEventListener('pointermove', function(evt) {
    if (evt.target instanceof H.map.Polyline) {
      document.body.style.cursor = 'pointer';
    } else {
      document.body.style.cursor = 'default'
    }
  }, true);

  // event listener for circle group to resize the geo circle object if dragging over outline polyline
  circleGroup.addEventListener('drag', function(evt) {
    var pointer = evt.currentPointer,
        distanceFromCenterInMeters = circle.getCenter().distance(map.screenToGeo(pointer.viewportX, pointer.viewportY));

    // if resizing is alloved, set the circle's radius
    if (evt.target instanceof H.map.Polyline) {
      circle.setRadius(distanceFromCenterInMeters);

      // use circle's updated geometry for outline polyline
      var outlineLinestring = circle.getGeometry().getExterior();

      // extract first point of the outline LineString and push it to the end, so the outline has a closed geometry
      outlineLinestring.pushPoint(outlineLinestring.extractPoint(0));
      circleOutline.setGeometry(outlineLinestring);

      // prevent event from bubling, so map doesn't receive this event and doesn't pan
      $("#wsct_dist").val(parseInt(circle.getRadius(),10));
      evt.stopPropagation();
    }
  }, true);
 return circleGroup;
//  alert(circle.getGeometry());

}
function dreawSectoralAntenna(lat,lng,d){
  var lineString = new H.geo.LineString();
  lineString.pushPoint({lat:lat,lng:lng});
  var apertura=$("#apper").val()/2,deg=$("#deg").val();

  //i=(-88-(45))=-133
  //-88+45=-43
  //-133<-44
var limit=((deg*1)+apertura);

var i=(deg-apertura)*1;
    //console.dir(typeof i+"<"+ typeof limit+"||"+deg+","+apertura);
   for(i;i<limit;i++){
      //   console.log((deg-apertura)+"<"+limit+"||"+deg+","+apertura);
       var point=getLatLng(toRad(lat),d,i,toRad(lng));

        lineString.pushPoint({lat:point.lat, lng:point.lng});
//i++;
     };
lineString.pushPoint({lat:lat,lng:lng});
     var svgCircle = '',
      polyline = new H.map.Polyline(
        lineString,
        {
          style: {fillColor: 'rgba(150, 100, 0, .8)', lineWidth: 10}
        }
      ),
      verticeGroup = new H.map.Group({
        visibility: false
      }),
      mainGroup = new H.map.Group({
        volatility: true, // mark the group as volatile for smooth dragging of all it's objects
        objects: [polyline, verticeGroup]
      }),
      polylineTimeout;

  // ensure that the polyline can receive drag events
  polyline.draggable = true;

  // create markers for each polyline's vertice which will be used for dragging
  //  console.log(polyline.getGeometry().getPointCount());
  polyline.getGeometry().eachLatLngAlt(function(lat, lng, alt, index) {
    if(index==(polyline.getGeometry().getPointCount()/2)){
    var vertice = new H.map.Marker(
      {lat, lng},
      {
        icon: new H.map.Icon(circlesvg)
      }
    );
    vertice.draggable = true;
    vertice.setData({'verticeIndex': index})
    verticeGroup.addObject(vertice);
  }
  });

  // add group with polyline and it's vertices (markers) on the map
  map.addObject(mainGroup);

  // event listener for main group to show markers if moved in with mouse (or touched on touch devices)
  mainGroup.addEventListener('pointerenter', function(evt) {
    if (polylineTimeout) {
      clearTimeout(polylineTimeout);
      polylineTimeout = null;
    }

    // show vertice markers
    verticeGroup.setVisibility(true);
  }, true);

  // event listener for main group to hide vertice markers if moved out with mouse (or released finger on touch devices)
  // the vertice markers are hidden on touch devices after specific timeout
  mainGroup.addEventListener('pointerleave', function(evt) {
    var timeout = (evt.currentPointer.type == 'touch') ? 1000 : 0;

    // hide vertice markers
    polylineTimeout = setTimeout(function() {
      verticeGroup.setVisibility(false);
    }, timeout);
  }, true);

  // event listener for vertice markers group to change the cursor to pointer if mouse position enters this group
  verticeGroup.addEventListener('pointerenter', function(evt) {
    document.body.style.cursor = 'pointer';
  }, true);

  // event listener for vertice markers group to change the cursor to default if mouse leaves this group
  verticeGroup.addEventListener('pointerleave', function(evt) {
    document.body.style.cursor = 'default';
  }, true);

  // event listener for vertice markers group to resize the geo polyline object if dragging over markers
  verticeGroup.addEventListener('drag', function(evt) {
    var pointer = evt.currentPointer,
        geoLineString = polyline.getGeometry(),
        geoPoint = map.screenToGeo(pointer.viewportX, pointer.viewportY);

    // set new position for vertice marker
    evt.target.setGeometry(geoPoint);

    // set new position for polyline's vertice
  //  console.log(geoPoint);
//    map.removeObject(mainGroup);
var origen=new H.math.Point (lat,lng);

//  console.log(geoPoint.distance({lat:lat,lng:lng}));

var λ1=lng,λ2=geoPoint.lng;
var φ1=lat,φ2=geoPoint.lat;
  var y = Math.sin(λ2-λ1) * Math.cos(φ2);
var x = Math.cos(φ1)*Math.sin(φ2) -
        Math.sin(φ1)*Math.cos(φ2)*Math.cos(λ2-λ1);
var brng = toDeg(Math.atan2(y, x));


$("#wsct_dist").val(parseInt(geoPoint.distance({lat:lat,lng:lng}),10));
$("#deg").val(parseInt(brng));
  var line = new H.geo.LineString();
  line.pushPoint({lat:lat,lng:lng});
    var apertura=$("#apper").val()/2;
     for(var i=brng-apertura;i<brng+apertura;){
        var point=getLatLng(toRad(lat),geoPoint.distance({lat:lat,lng:lng}),i,toRad(lng));
        line.pushPoint({lat:point.lat, lng:point.lng});
        i++;
     };
     line.pushPoint({lat:lat,lng:lng});
     polyline.setGeometry(line);

    // stop propagating the drag event, so the map doesn't move
    evt.stopPropagation();
  }, true);


return mainGroup;
}
function getLatLng(lat1,dist,brng,lon1){
// dist = typeof(dist)=='number' ? dist : typeof(dist)=='string' && dist.trim()!='' ? +dist : NaN;
  dist = dist/6371000;  // convert dist to angular distance in radians
  brng = toRad(brng);  //
//  var lat1 = this._lat.toRad(), lon1 = this._lon.toRad();

  var lat2 = Math.asin( Math.sin(lat1)*Math.cos(dist) +
                        Math.cos(lat1)*Math.sin(dist)*Math.cos(brng) );
  var lon2 = lon1 + Math.atan2(Math.sin(brng)*Math.sin(dist)*Math.cos(lat1),
                               Math.cos(dist)-Math.sin(lat1)*Math.sin(lat2));
  lon2 = (lon2+3*Math.PI) % (2*Math.PI) - Math.PI;  // normalise to -180..+180º
//console.log(dist);
  return ({lat:toDeg(lat2), lng:toDeg(lon2)});
}
function toRad(Value) {
    /** Converts numeric degrees to radians */
    return Value * Math.PI / 180;
}
function toDeg(Value) {
    /** Converts numeric degrees to radians */
    return Value *  180/Math.PI;
}
var index=1;
var payTable=null;
$('#clientInput').change(function(evt){
  console.log($('#clientInput').val());
  $('#clientName').val($('#clientInput').val());
      index=1;
   var opt = $('option[value="'+$(this).val()+'"]');
//  console.log(opt.attr('id'));
  if(opt.attr('id')!=undefined){
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
            $.ajax({
                url:"agregarpago/"+opt.attr('id'),


              }).done(function(res){

                var date=new Date();
                  var pkg=res[0].ws_pkg;
                  var a=$(getClientPays());
                  var d = document.createDocumentFragment();
                  d.appendChild(a[0]);
                  d.getElementById('pkgClient').value=pkg;
                  d.getElementById('payMonth').value=date.getMonth()+1;
                  d.getElementById('payMoney').value=getPrices()[pkg].wp_price;
                  d.getElementById('serviceId').value=res[0].ws_id;
                  d.getElementById('pkgClient').name="pkgClient"+index;
                  d.getElementById('payMonth').name="payMonth"+index;
                  d.getElementById('payMethod').name="payMethod"+index;
                  d.getElementById('payMoney').name="pay"+index;
                  d.getElementById('pkgClient').addEventListener("change",function(evt){
                  //  console.log(evt.path[2].children[3].children[0].children[0]);
                    evt.path[2].children[3].children[0].children[0].value=getPrices()[evt.target.value].wp_price;
                    //  setTotal();
                  });
                  if(payTable!=null){
                    payTable.destroy()
                  };
                  $('#payTable').html(d);
                setTotal();
                index++;
                var pagosAnteriores=res[0].pays;
                  $('#recentPays').html('');
                for(var i=0;i<pagosAnteriores.length;i++){
                  $('#recentPays').append('<tr><td>'+(i+1)+'</td><td>'+pagosAnteriores[i].fecha+'</td><td>'+pagosAnteriores[i].wp_name+'</td><td><button type="submit" class="btn btn-primary"><i class="fas fa-print"></i></button></td></tr>');
                }
                payTable=$('#recentPaysTable').DataTable();
              });
  }
});




function addPayRow(){
var date=new Date();
  var a=$(getClientPays());
  var pkg=document.getElementById('pkgClient').value;
  var serv=document.getElementById('serviceId').value;
  var row=document.getElementById('payOptions');
  var d = document.createDocumentFragment();
  d.appendChild(a[0]);
  d.getElementById('pkgClient').value=pkg;
  d.getElementById('pkgClient').name="pkgClient"+index;
  d.getElementById('payMonth').name="payMonth"+index;
  d.getElementById('payMethod').name="payMethod"+index;
  d.getElementById('payMonth').value=date.getMonth()+index;
  d.getElementById('payMoney').value=getPrices()[pkg].wp_price;
  d.getElementById('payMoney').name="pay"+index;
  d.getElementById('serviceId').value=serv;
  d.getElementById('eliminar').addEventListener("click",function(evt){
     $(this).closest('tr').remove();
  });
  d.getElementById('pkgClient').addEventListener("change",function(evt){
      evt.path[2].children[3].children[0].children[0].value=getPrices()[evt.target.value].wp_price;
    setTotal();
  });

  $('#payTable').append(d);
  setTotal();
  index++;
}
function setTotal(){
  var pays=document.getElementsByClassName('pkgClient');
  var price=0;
  for(var i=0;i<pays.length;i++){

            price+=getPrices()[pays[i].value].wp_price*1;
            console.log(price);
    }
    document.getElementById('totalPay').innerHTML='$ '+price;
}

$("#reportFrom").submit(function(e){
  e.preventDefault();
  var html="";
  table.destroy();
  $.ajax({
      url:$(this).attr("action"),
    			type:$(this).attr("method"),
    			data:$(this).serialize()
    }).done(function(res){
    // console.log(res);
    html='';


      if($('#filter').val()==4){
          $("#suspendTable").DataTable();
          $('#paysTable').attr('hidden',true);
          $("#suspendTable").removeAttr('hidden');
        //$("#depositTBody").html(html);
        table=$("#deposiTable").DataTable();
    }
    else{
//      alert('adad');
          $('#suspendTable').attr('hidden',true);
          $('#paysTable').removeAttr('hidden');
          for(var i in res){
                html+='<tr><form action="#"><td>'+(i*1+1)+'</td>'+
                '<td>'+res[i].wc_name+' '+res[i].wc_last_name+'</td>'+
                '<td>'+res[i].wp_name+'</td>'+
                '<td>'+res[i].wps_pay_type+'</td>'+
                '<td>'+res[i].wps_mes+'</td>'+
                '<td>'+res[i].wps_date+'</td>'+
                '<td><button type="submit" class="btn btn-primary pull-right"><i class="fas fa-print " aria-hidden="true"></i></button></td>'+
                '<td>'+
                '  <form action="" method="POST">'+
                '   <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>'+
                '  </form></td>'+
                '</tr>';
              }
          $("#PaysTableBody").html(html);
          table=$("#paysTable").DataTable();
    }

    })
});


var clietnSupendRow= document.getElementsByClassName("clietnSupendRow");
var clietnSupendAction= document.getElementsByClassName("clietnSupendAction");
for(var i=0;i<clietnSupendRow.length;i++){
    clietnSupendRow[i].children[2].children[1].addEventListener('change',function(evt){
    var monthSelect=evt.path[2].children[2].children[2];
    if(this.value==3){
        monthSelect.style.display=""
    }
    else{
        monthSelect.style.display="none"
    }

  });
$(clietnSupendRow[i].children[3].children[0]).submit(function(e){
  e.preventDefault();
  var id=e.originalEvent.path[2].children[2].children[0].value;
  var suspendAction=e.originalEvent.path[2].children[2].children[1].value;
  var creditMonths=e.originalEvent.path[2].children[2].children[2].value;
  var pkg=e.originalEvent.path[2].children[2].children[3].value;
  $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
 });
  $.ajax({
      url:$(this).attr("action"),
          type:$(this).attr("method"),
          data:{"action":suspendAction,"ws_id":id,"credit":creditMonths,"pkg":pkg}

    }).done(function(res){
      console.log(res);
    })

});
}
