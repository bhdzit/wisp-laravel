const mapmarck = '<svg width="20" height="20"  aria-hidden="true" focusable="false" data-prefix="fas" data-icon="laptop-house" class="svg-inline--fa fa-laptop-house fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M272,288H208a16,16,0,0,1-16-16V208a16,16,0,0,1,16-16h64a16,16,0,0,1,16,16v37.12C299.11,232.24,315,224,332.8,224H469.74l6.65-7.53A16.51,16.51,0,0,0,480,207a16.31,16.31,0,0,0-4.75-10.61L416,144V48a16,16,0,0,0-16-16H368a16,16,0,0,0-16,16V87.3L263.5,8.92C258,4,247.45,0,240.05,0s-17.93,4-23.47,8.92L4.78,196.42A16.15,16.15,0,0,0,0,207a16.4,16.4,0,0,0,3.55,9.39L22.34,237.7A16.22,16.22,0,0,0,33,242.48,16.51,16.51,0,0,0,42.34,239L64,219.88V384a32,32,0,0,0,32,32H272ZM629.33,448H592V288c0-17.67-12.89-32-28.8-32H332.8c-15.91,0-28.8,14.33-28.8,32V448H266.67A10.67,10.67,0,0,0,256,458.67v10.66A42.82,42.82,0,0,0,298.6,512H597.4A42.82,42.82,0,0,0,640,469.33V458.67A10.67,10.67,0,0,0,629.33,448ZM544,448H352V304H544Z"></path></svg>'
var circlesvg = '<svg width="10" height="10"  aria-hidden="true" focusable="false" data-prefix="far" data-icon="circle" class="svg-inline--fa fa-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm0 448c-110.5 0-200-89.5-200-200S145.5 56 256 56s200 89.5 200 200-89.5 200-200 200z"></path></svg>';
var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octrubre", "Noviembre", "Diciembre"];
var marker;
var map;
var NUMERO_CREDITOS=0;
var NUMERO_DEPOSITOS = 0;
const SUSPEND_TABLE = 5;
const DEP_MONTH = 5;
const CUTS_OF_MONTH = 5;

function showQR(client) {
  console.log(client);
  Swal.fire({
    title: 'Mostrar Qr',
    html: '<div id="qrcode" style=" height:300px; margin-top:15px;"></div>',
    width: '25%',
    showClass: {
      popup: 'animated fadeInDown faster'
    },
    hideClass: {
      popup: 'animated fadeOutUp faster'
    }
  });
  var qrcode = new QRCode(document.getElementById("qrcode"), {
    width: 300,
    height: 300
  });
  qrcode.makeCode(client);
}
function showTowerPosition(lng, lat) {
  Swal.fire({
    title: 'Ubicacion de Torre',
    html: '<div style="width: 100%; height: 380px" id="mapContainer"></div>',
    width: '80%',
    showClass: {
      popup: 'animated fadeInDown faster'
    },
    hideClass: {
      popup: 'animated fadeOutUp faster'
    }
  });

  setMap();
  addMarck({ lat: lat, lng: lng });
}
function setMap() {

  var platform = new H.service.Platform({
    'apikey': 'SEI-1bn-6vSC9G7pEalClDrOHK1w38l5IUSl_XrE5s0'
  });

  // Obtain the default map types from the platform object
  var defaultLayers = platform.createDefaultLayers();

  //Step 2: initialize a map - this map is centered over Europe
  map = new H.Map(document.getElementById('mapContainer'),
    defaultLayers.vector.normal.map, {
    center: { lat: 20.297461, lng: -99.186517 },
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
function getCords(evt) {
  var coord = map.screenToGeo(evt.currentPointer.viewportX,
    evt.currentPointer.viewportY);

  addMarck({ lat: coord.lat, lng: coord.lng });
  $("#torrePoint").val(coord.lat + "," + coord.lng);
  //    map.removeEventListener("tap",getCords);
}
function addMarck(cords) {


  var icon = new H.map.Icon("/adminlte/dist/img/zona2.png");
  marker = new H.map.Marker(cords, { icon: icon });
  map.addObject(marker);

}
function setSectorTowerAndAntennasEvents(json) {

  var object;
  //      const json=JSON.parse(res);

  var selectedTower = document.getElementById("wsct_tower");


  $("#wsct_tower").change(function (evt) {

    var lat = json[selectedTower.selectedIndex - 1]["wt_lat"], lng = json[selectedTower.selectedIndex - 1]["wt_lng"];
    if (object != null) {
      map.removeObject(object);
      map.removeObject(marker);
    }
    object = ($("#wsct_antennatype").val() == 1) ? object = dreawSectoralAntenna(lat, lng, $("#wsct_dist").val()) : object = dreawOmniAntenna(lat, lng, 800);
    addMarck({ lat: lat, lng: lng });
    map.addObject(object);
  });

  $("#wsct_antennatype").change(function (evt) {
    if (evt.target.value == 1) {
      $("#apperdiv").removeClass("hide");
    }
    else {
      $("#apperdiv").addClass("hide");
    }



    var antennatype = $("#wsct_antennatype").val();
    if (object != null) {
      map.removeObject(object);
      map.removeObject(marker);
    }
    if (antennatype != 0 && $("#wsct_tower").val() != 0) {

      var lat = json[selectedTower.selectedIndex - 1]["wt_lat"], lng = json[selectedTower.selectedIndex - 1]["wt_lng"];
      object = (antennatype == 1) ? object = dreawSectoralAntenna(lat, lng, $("#wsct_dist").val()) : object = dreawOmniAntenna(lat, lng, 800);
      addMarck({ lat: lat, lng: lng });
      map.addObject(object);
    }
  });

  $("#wsct_dist").change(function (evt) {

    if (antennatype != 0 && $("#wsct_tower").val() != 0) {

      if ($("#wsct_antennatype").val() == 2) {

        object.getObjects()[0].setRadius($("#wsct_dist").val());
        // use circle's updated geometry for outline polyline
        var outlineLinestring = object.getObjects()[0].getGeometry().getExterior();

        // extract first point of the outline LineString and push it to the end, so the outline has a closed geometry
        outlineLinestring.pushPoint(outlineLinestring.extractPoint(0));
        object.getObjects()[1].setGeometry(outlineLinestring);
      }
      if ($("#wsct_antennatype").val() == 1) {

        var lat = json[$("#wsct_tower").val()]["wt_ST_Y"], lng = json[$("#wsct_tower").val()]["wt_ST_X"];

        map.removeObject(object);
        object = dreawSectoralAntenna(lat, lng, $("#wsct_dist").val());
        map.addObject(object);

      }
    }
  });
  $("#apper").change(function () {
    var lat = json[selectedTower.selectedIndex - 1]["wt_lat"], lng = json[selectedTower.selectedIndex - 1]["wt_lng"];

    map.removeObject(object);
    object = dreawSectoralAntenna(lat, lng, $("#wsct_dist").val());
    map.addObject(object);
  });


  $('#wsct_color').change(function (evt) {
    currentColor = hex2rgba_convert($('#wsct_color').val(), 50);
    alert(currentColor);
    map.getObjects()[1].getObjects()[0].setStyle({ fillColor: $('#wsct_color').val(), strokeColor: currentColor })
  });

}
function hex2rgba_convert(hex, opacity) {
  if (hex == "#0") {
    hex = "#000000"
  }
  hex = hex.replace('#', '');
  r = parseInt(hex.substring(0, hex.length / 3), 16);
  g = parseInt(hex.substring(hex.length / 3, 2 * hex.length / 3), 16);
  b = parseInt(hex.substring(2 * hex.length / 3, 3 * hex.length / 3), 16);
  result = 'rgba(' + r + ',' + g + ',' + b + ',' + opacity / 100 + ')';
  return result;
}
function getSectorialAntennaData(id) {
  return $.ajax({
    url: "./controller/sectorController.php",
    data: { "acction": "getData", "id": id },
    type: "POST"
  }).done(function (res) {
    res = JSON.parse(res);
    $("#apper").val(res["wsec_rank"]);
    $("#deg").val(res["wsec_deg"]);

  });


}
function dreawOmniAntenna(lat, lng, dist, color) {


  if (color == null) {
    color = $('#wsct_color').val();

  }

  var currentColor = hex2rgba_convert(color, 50);

  var circle = new H.map.Circle({ lat: lat, lng: lng }, dist,
    {
      style: { fillColor: currentColor, lineWidth: 0 }
    }
  ),
    circleOutline = new H.map.Polyline(
      circle.getGeometry().getExterior(),
      {
        style: { lineWidth: 8, strokeColor: 'rgba(255, 0, 0, 0)' }
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
  circleGroup.addEventListener('pointerenter', function (evt) {
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
  circleGroup.addEventListener('pointerleave', function (evt) {
    var currentStyle = circleOutline.getStyle(),
      newStyle = currentStyle.getCopy({
        strokeColor: 'rgba(255, 0, 0, 0)'
      }),
      timeout = (evt.currentPointer.type == 'touch') ? 1000 : 0;

    circleTimeout = setTimeout(function () {
      circleOutline.setStyle(newStyle);
    }, timeout);
    document.body.style.cursor = 'default';
  }, true);

  // event listener for circle group to change the cursor if mouse position is over the outline polyline (resizing is allowed)
  circleGroup.addEventListener('pointermove', function (evt) {
    if (evt.target instanceof H.map.Polyline) {
      document.body.style.cursor = 'pointer';
    } else {
      document.body.style.cursor = 'default'
    }
  }, true);

  // event listener for circle group to resize the geo circle object if dragging over outline polyline
  circleGroup.addEventListener('drag', function (evt) {
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
      $("#wsct_dist").val(parseInt(circle.getRadius(), 10));
      evt.stopPropagation();
    }
  }, true);
  return circleGroup;
  //  alert(circle.getGeometry());

}
function dreawSectoralAntenna(lat, lng, d, color, apertura, deg) {
  var lineString = new H.geo.LineString();
  lineString.pushPoint({ lat: lat, lng: lng });
  if (apertura == null) {
    apertura = $("#apper").val() / 2;
    deg = $("#deg").val();
  }


  //i=(-88-(45))=-133
  //-88+45=-43
  //-133<-44
  var limit = ((deg * 1) + apertura);

  var i = (deg - apertura) * 1;
  //console.dir(typeof i+"<"+ typeof limit+"||"+deg+","+apertura);
  for (i; i < limit; i++) {
    //   console.log((deg-apertura)+"<"+limit+"||"+deg+","+apertura);
    var point = getLatLng(toRad(lat), d, i, toRad(lng));

    lineString.pushPoint({ lat: point.lat, lng: point.lng });
    //i++;
  };
  lineString.pushPoint({ lat: lat, lng: lng });
  if (color == null) {
    color = $('#wsct_color').val();
  }
  if (color = "#0") {
    color = "#000"
  }

  var svgCircle = '',
    polyline = new H.map.Polyline(
      lineString,
      {
        style: { lineWidth: 3, strokeColor: color, fillColor: '#FFFFCC' }
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
  polyline.getGeometry().eachLatLngAlt(function (lat, lng, alt, index) {
    if (index == (polyline.getGeometry().getPointCount() / 2)) {
      var vertice = new H.map.Marker(
        { lat, lng },
        {
          icon: new H.map.Icon(circlesvg)
        }
      );
      vertice.draggable = true;
      vertice.setData({ 'verticeIndex': index })
      verticeGroup.addObject(vertice);
    }
  });

  // add group with polyline and it's vertices (markers) on the map
  map.addObject(mainGroup);

  // event listener for main group to show markers if moved in with mouse (or touched on touch devices)
  mainGroup.addEventListener('pointerenter', function (evt) {
    if (polylineTimeout) {
      clearTimeout(polylineTimeout);
      polylineTimeout = null;
    }

    // show vertice markers
    verticeGroup.setVisibility(true);
  }, true);

  // event listener for main group to hide vertice markers if moved out with mouse (or released finger on touch devices)
  // the vertice markers are hidden on touch devices after specific timeout
  mainGroup.addEventListener('pointerleave', function (evt) {
    var timeout = (evt.currentPointer.type == 'touch') ? 1000 : 0;

    // hide vertice markers
    polylineTimeout = setTimeout(function () {
      verticeGroup.setVisibility(false);
    }, timeout);
  }, true);

  // event listener for vertice markers group to change the cursor to pointer if mouse position enters this group
  verticeGroup.addEventListener('pointerenter', function (evt) {
    document.body.style.cursor = 'pointer';
  }, true);

  // event listener for vertice markers group to change the cursor to default if mouse leaves this group
  verticeGroup.addEventListener('pointerleave', function (evt) {
    document.body.style.cursor = 'default';
  }, true);

  // event listener for vertice markers group to resize the geo polyline object if dragging over markers
  verticeGroup.addEventListener('drag', function (evt) {
    var pointer = evt.currentPointer,
      geoLineString = polyline.getGeometry(),
      geoPoint = map.screenToGeo(pointer.viewportX, pointer.viewportY);

    // set new position for vertice marker
    evt.target.setGeometry(geoPoint);

    // set new position for polyline's vertice
    //  console.log(geoPoint);
    //    map.removeObject(mainGroup);
    var origen = new H.math.Point(lat, lng);

    //  console.log(geoPoint.distance({lat:lat,lng:lng}));

    var λ1 = lng, λ2 = geoPoint.lng;
    var φ1 = lat, φ2 = geoPoint.lat;
    var y = Math.sin(λ2 - λ1) * Math.cos(φ2);
    var x = Math.cos(φ1) * Math.sin(φ2) -
      Math.sin(φ1) * Math.cos(φ2) * Math.cos(λ2 - λ1);
    var brng = toDeg(Math.atan2(y, x));


    $("#wsct_dist").val(parseInt(geoPoint.distance({ lat: lat, lng: lng }), 10));
    $("#deg").val(parseInt(brng));
    var line = new H.geo.LineString();
    line.pushPoint({ lat: lat, lng: lng });
    var apertura = apertura / 2;
    for (var i = brng - apertura; i < brng + apertura;) {
      var point = getLatLng(toRad(lat), geoPoint.distance({ lat: lat, lng: lng }), i, toRad(lng));
      line.pushPoint({ lat: point.lat, lng: point.lng });
      i++;
    };
    line.pushPoint({ lat: lat, lng: lng });
    polyline.setGeometry(line);

    // stop propagating the drag event, so the map doesn't move
    evt.stopPropagation();
  }, true);


  return mainGroup;
}
function getLatLng(lat1, dist, brng, lon1) {
  // dist = typeof(dist)=='number' ? dist : typeof(dist)=='string' && dist.trim()!='' ? +dist : NaN;
  dist = dist / 6371000;  // convert dist to angular distance in radians
  brng = toRad(brng);  //
  //  var lat1 = this._lat.toRad(), lon1 = this._lon.toRad();

  var lat2 = Math.asin(Math.sin(lat1) * Math.cos(dist) +
    Math.cos(lat1) * Math.sin(dist) * Math.cos(brng));
  var lon2 = lon1 + Math.atan2(Math.sin(brng) * Math.sin(dist) * Math.cos(lat1),
    Math.cos(dist) - Math.sin(lat1) * Math.sin(lat2));
  lon2 = (lon2 + 3 * Math.PI) % (2 * Math.PI) - Math.PI;  // normalise to -180..+180º
  //console.log(dist);
  return ({ lat: toDeg(lat2), lng: toDeg(lon2) });
}
function toRad(Value) {
  /** Converts numeric degrees to radians */
  return Value * Math.PI / 180;
}
function toDeg(Value) {
  /** Converts numeric degrees to radians */
  return Value * 180 / Math.PI;
}
function addPayRow() {
  var date = new Date();
  if (month == 13) {
    month = 1;
  }

  var a = $(getClientPays());

  if (pkg == null || serv == null) {
    pkg = document.getElementById('pkgClient').value;
    serv = document.getElementById('serviceId').value;
  }

  var row = document.getElementById('payOptions');
  var d = document.createDocumentFragment();

  d.appendChild(a[0]);
  d.getElementById('pkgClient').value = pkg;
  d.getElementById('pkgClient').name = "pkgClient" + index;
  d.getElementById('payMonth').name = "payMonth" + index;
  d.getElementById('payMethod').name = "payMethod" + index;
  d.getElementById('payMonth').value = month;
  d.getElementById('payMoney').value = getPrices()[pkg].wp_price;
  d.getElementById('payMoney').name = "pay" + index;
  d.getElementById('serviceId').value = serv;
  d.getElementById('eliminar').addEventListener("click", function (evt) {
    $(this).closest('tr').remove();
    month = evt.path[2].children[1].children[0].value;
    setTotal();
  });
  d.getElementById('pkgClient').addEventListener("change", function (evt) {
    evt.path[2].children[4].children[0].children[0].value = getPrices()[evt.target.value].wp_price;
    setTotal();
  });

  $('#payTable').append(d);
  setTotal();
  index++;
  month++;
}
function creditRow(data) {
  var fecha = data.wps_mes.split("-");
  fecha = meses[fecha[1] - 1] + " - " + fecha[0];
  NUMERO_CREDITOS++;
  return '<tr class="creditRow" id="payOptions">'
    + '<td style="width: 30px"  >'
    + '<input name="creditPayCheckbox' +NUMERO_CREDITOS+ '" type="checkbox" onchange="setTotal()" checked>'
    + '<input name="creditPay' + NUMERO_CREDITOS + '" type="hidden"  value="' + data.wps_id + '">'
    + '</td>'
    + ' <td colspan="2">'
    + '     <input placeholder="Desscripcion" class="form-control" value="Servicio del mes ' + fecha + '" readonly>'
    + '  </td>'
    + '  <td><select class="form-control"  id="payMethod" onchange="payMethodChange(this)">'
    + '       <option value="1">Efectivo</option>'
    + '       <option value="2">Deposito</option></select></td>'
    + '   <td><b>$<input name="payMoney' + data.wsc_id + '" style="border: 0;width: 50px;" id="payMoney" type="text" readonly value="' + getPrices()[1].wp_price + '"></b></td>'
    + '</tr>';
}
function payMethodChange(evt) {
  var value_select = evt.value;
  if (value_select == 2) {
    NUMERO_DEPOSITOS++;
  } else {
    NUMERO_DEPOSITOS--;
  }
  if (NUMERO_DEPOSITOS > 0) {

   $("#depositRow").removeAttr("hidden");
   $("#depositDate").attr("required",true);
  
  }
  else {
    $("#depositRow").attr("hidden",true);
    $("#depositDate").removeAttr("required");
  }
  console.log(value_select + "," + evt.value);
}
function setTotal() {
  var pays = document.getElementsByClassName('pkgClient');
  var price = 0;
  for (var i = 0; i < pays.length; i++) {

    price += getPrices()[pays[i].value].wp_price * 1;
    //console.log(price);
  }
  var extras = document.getElementsByClassName('extrasClient');
  for (var i = 0; i < extras.length; i++) {
    price += extras[i].value * 1;
  }
  var credit = document.getElementsByClassName("creditRow");
  for (var i = 0; i < credit.length; i++) {
    var precio = credit[i].children[3].children[0].children[0].value;
    var creditCheckbox = credit[i].children[0].children[0];

    if (creditCheckbox.checked) {
      price += precio * 1;
    }


  }

  document.getElementById('totalPay').innerHTML = '$ ' + price;
}
function setSmall(res) {

  var text = "";

  if (res.wps_monto == "0.00" && res.wsc_id == null) {
    text += '<span class="label label-success pull-right">Gratis</span>';
  }
  if (res.wsc_id) {
    text += '<span class="label label-warning pull-right">Credito</span>';
  }
  if (res.wd_banc) {
    text += '<span class="label label-primary pull-right">' + res.wd_banc + '</span>';
  }
  if (res.wdp_pay) {
    text += '<span class="label label-danger pull-right">Cancelado</span>'
  }
  return text;
}
function showCharingbar() {
  $("#charging-row").removeAttr("hidden");
  $("#paysTable").hide();
  $("#paysTable").css('width', 'inherit');
  $("#filter-row").attr("hidden", true);

}

function hideCharingBar() {
  $("#charging-row").attr("hidden", true);
  if ($('#filter').val() != SUSPEND_TABLE) {
  $("#paysTable").show();
  }
  $("#paysTable").css('width', 'inherit');
  $("#filter-row").removeAttr("hidden");
}

$("#reportFrom").submit(function (e) {
  e.preventDefault();
  var html = "";
  table.destroy();
  $.ajax({
    url: $(this).attr("action"),
    type: $(this).attr("method"),
    data: $(this).serialize()
  }).done(function (res) {
   // console.log(res);
    html = '';


    if ($('#filter').val() == SUSPEND_TABLE) {
      $('#thAllPays').attr('hidden', true);
      $('#paysTable').attr('hidden', true);
      $("#suspendTable").removeAttr('hidden');
      //$("#depositTBody").html(html);
      table = $("#suspendTable").DataTable();
     
    }
    else {
      $('#thAllPays').removeAttr('hidden');
      $('#thDeposit').attr('hidden', true);
      if ($('#filter').val() == DEP_MONTH) {
        $('#thAllPays').attr('hidden', true);
        $('#thDeposit').removeAttr('hidden');
      }

      $('#suspendTable').attr('hidden', true);
      $('#paysTable').removeAttr('hidden');
      var total = 0, efectivo = 0, depo = 0;
      for (var i in res) {
        //                console.log(res[i]);
        if (!res[i].wdp_pay) {
          total += (res[i].wps_monto * 1);

          if (res[i].wps_pay_type == "Efectivo") efectivo += (res[i].wps_monto * 1);
          else depo += (res[i].wps_monto * 1);
        }
        html += '<tr><form action="#"><td>' + (i * 1 + 1) + '</td>' +
          '<td>' + res[i].wc_name + ' ' + res[i].wc_last_name + '</td>' +
          '<td>' + res[i].wp_name + '</td>' +
          '<td>' + res[i].wps_pay_type + setSmall(res[i]) + '</td>' +
          '<td>' + res[i].wps_mes + '</td>' +
          '<td>' + res[i].wps_date + '</td>' +
          '<td><button type="submit" class="btn btn-primary pull-right"><i class="fas fa-print " aria-hidden="true"></i></button></td>' +
          '<td>' +
          '  <form action="" method="POST">' +
          '   <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>' +
          '  </form></td>' +
          '</tr>';
      }
      $('#totalDep').html('$' + depo);
      $('#totalPay').html('$' + total);
      $('#totalCash').html('$' + efectivo)

      $("#PaysTableBody").html(html);
      table = $("#paysTable").DataTable({
        "language": {
          "search": "Buscar:",
          "lengthMenu": "Mostrar : _MENU_ ",
          "info": "Pago _START_ al _END_ de _TOTAL_ Pagos",
          "paginate": {
            "first": "Primera",
            "last": "Ultima",
            "next": "Siguiente",
            "previous": "Anterior"
          },
        }
      });
    }
    hideCharingBar();
  })
});

var clietnSupendRow = document.getElementsByClassName("clietnSupendRow");
var clietnSupendAction = document.getElementsByClassName("clietnSupendAction");
for (var i = 0; i < clietnSupendRow.length; i++) {
  clietnSupendRow[i].children[2].children[1].addEventListener('change', function (evt) {
    var monthSelect = evt.path[2].children[2].children[2];
    if (this.value == 3) {
      monthSelect.style.display = ""
    }
    else {
      monthSelect.style.display = "none"
    }

  });
  $(clietnSupendRow[i].children[3].children[0]).submit(function (e) {
    e.preventDefault();
    var id = e.originalEvent.path[2].children[2].children[0].value;
    var suspendAction = e.originalEvent.path[2].children[2].children[1].value;
    var creditMonths = e.originalEvent.path[2].children[2].children[2].value;
    var pkg = e.originalEvent.path[2].children[2].children[3].value;
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    Swal.fire({
      title: 'Loading cars from data base',
      allowOutsideClick: false,
      timerProgressBar: true,
    });
    swal.showLoading();
    const Toast = Swal.mixin({
      toast: true,
      position: 'bottom-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })




    $.ajax({
      url: $(this).attr("action"),
      type: $(this).attr("method"),
      data: { "action": suspendAction, "ws_id": id, "credit": creditMonths, "pkg": pkg }

    }).done(function (res) {
      Toast.fire({
        icon: 'success',
        title: 'Operacion Relaizada'
      })
      table.row(':eq(0)').remove().draw();
    }).fail(function () {
      Toast.fire({
        icon: 'error',
        title: 'Error al Realizar la Operacion'
      })
    })

  });


}

var index = 1;
var month = 1;
var payTable = null;
var ultimomespagado = 1;
var pkg = null, serv = null;
$('#clientInput').change(function (evt) {

  if ($("#clientInput").val().length != 0) showCharingbar();;

  $('#clientName').val($('#clientInput').val());

  index = 1;

  var opt = $('option[value="' + $(this).val() + '"]');
  //  console.log(opt.attr('id'));
  if (opt.attr('id') != undefined) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      url: "agregarpago/" + opt.attr('id'),
    }).done(function (res) {

      var date = new Date();
      pkg = res[0].ws_pkg;
      if (res[0].last_month_pay) {
        ultimomespagado = (res[0].last_month_pay.split("-")[1] * 1) + 1;
      }
      else {
        ultimomespagado = new Date().getMonth() + 1;
      }
      if (ultimomespagado == 13) ultimomespagado = 1;
      month = ultimomespagado;
      var a = $(getClientPays());
      var d = document.createDocumentFragment();
      var creditos = res[0].credit;

      d.appendChild(a[0]);
      d.getElementById('pkgClient').value = pkg;
      d.getElementById('payMonth').value = ultimomespagado;
      d.getElementById('payMoney').value = getPrices()[pkg].wp_price;
      d.getElementById('serviceId').value = res[0].ws_id;
      serv = res[0].ws_id;
      d.getElementById('pkgClient').name = "pkgClient" + index;
      d.getElementById('payMonth').name = "payMonth" + index;
      d.getElementById('payMethod').name = "payMethod" + index;

      d.getElementById('payMoney').name = "pay" + index;
      d.getElementById('pkgClient').addEventListener("change", function (evt) {

        evt.path[2].children[4].children[0].children[0].value = getPrices()[evt.target.value].wp_price;
        setTotal();
      });
      $('#creditosTable').html("");
      var hasCredit = false;
      for (var i = 0; i < creditos.length; i++) {
        if (creditos[i].wsc_id != null&&creditos[i]=='0.00') {
          $('#creditosTable').append(creditRow(creditos[i]));
          hasCredit = true;
        }
      }
      if (hasCredit) {
        d.getElementById('eliminar').addEventListener("click", function (evt) {
          $(this).closest('tr').remove();
          month = ultimomespagado;
          setTotal();
        });
      }

      if (payTable != null) {
        payTable.destroy()
      };
      $('#payTable').html(d);
      setTotal();
      index++;
      var pagosAnteriores = res[0].pays;
      $('#recentPays').html('');
      for (var i = 0; i < pagosAnteriores.length; i++) {
        $('#recentPays').append('<tr><td>' + (i + 1) + '</td><td>' + pagosAnteriores[i].fecha + '</td><td>' + pagosAnteriores[i].wp_name + '</td><td><button type="submit" class="btn btn-primary"><i class="fas fa-print"></i></button></td></tr>');
      }
      payTable = $('#recentPaysTable').DataTable();
      $('table').removeClass('hidden');
      month++;
    });
  }
  hideCharingBar();
});