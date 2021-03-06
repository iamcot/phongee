function addloadgif(eid) {
    if (eid == null || eid == "") eid = "#loadstatus";
    //alert(eid);
    $(eid).html("<img src='"+$("#base_url").val()+"src/ajax-loader.gif' name='ajaxload'>");
}
function addsavegif(eid) {
    if (eid == null || eid == "") eid = "#loadstatus";
    $(eid).html("<img src='"+$("#base_url").val()+"src/save.gif' name='ajaxload'>");
}
function removeloadgif(eid) {
    if (eid == null || eid == "") eid = "#loadstatus";
    $(eid + " img").fadeOut(500);
}
function toggleinfo(id){
    $(id).toggle();
}
/**
 * Get lat and lng from google map geocode
 * http://maps.googleapis.com/maps/api/geocode/json?address=a,+b,c&sensor=false
 * return location[lat,lng]
 *
 *
 */
function loadmap() {
    var province = $("select[name=daprovince_id]  option:selected").text();
    var province_id = $("select[name=daprovince_id]").val();
    var district = $("select[name=dadistrict_id]  option:selected").text();
    var district_id = $("select[name=dadistrict_id]").val();
    var ward = $("select[name=daward_id]  option:selected").text();
    var ward_id = $("select[name=daward_id]").val();
    var street = $("select[name=dastreet_id]  option:selected").text();
    var street_id = $("select[name=dastreet_id]").val();

    var addr = $("input[name=daaddr]").val();

    var straddr = "http://maps.googleapis.com/maps/api/geocode/json?address=";
    if (province == "" || province_id == 0) province = "";
    if (district == "" || district_id == 0) district = "";
    if (ward == "" || ward_id == 0) ward = "";
    if (street == "" || street_id == 0) street = "";
    console.log(province+">"+district+">"+ward+">"+street);

    straddr += addr + ((addr != "") ? "," : "") + street + ((street != "") ? "," : "") + ward + ((ward != "") ? "," : "") + district + ((district != "") ? "," : "") + province + ", viet nam&sensor=false";
    console.log(straddr);
    $.ajax({
        type: "get",
        url: straddr,
        success: function (msg) {
            var geocode = eval(msg);
            if (geocode.status == "OK") {
                var result = geocode.results[0];
                var location = result.geometry.location;
                console.log(location.lat + " @ " + location.lng);
                $("input[name=maplat]").val(location.lat);
                $("input[name=maplng]").val(location.lng);

                reloadmap();
            }
            else alert("Không lấy được dữ liệu bản đồ từ địa chỉ trên.");
            console.log(geocode);
        }
    });
}
function getmaplongname(p, d, w, s) {
    var province = "";
    var province_id = "";
    var district = "";
    var district_id = "";
    var ward = "";
    var ward_id = "";
    var street = "";
    var street_id = "";

    if (p == 1) {
        province = $("select[name=daprovince_id]  option:selected").text();
        province_id = $("select[name=daprovince_id]").val();
    }
    else if (p == 0) {
        province = $("input[name=dalong_name]").val();
    }
    if (d == 1) {
        district = $("select[name=dadistrict_id]  option:selected").text();
        district_id = $("select[name=dadistrict_id]").val();
    }
    else if (d == 0) {
        district = $("input[name=dalong_name]").val();
    }
    if (w == 1) {
        ward = $("select[name=daward_id]  option:selected").text();
        ward_id = $("select[name=daward_id]").val();
    }
    else if (w == 0) {
        ward = $("input[name=dalong_name]").val();
    }
    if (s == 0) {
        street = $("input[name=dalong_name]").val();
    }

    var straddr = "http://maps.googleapis.com/maps/api/geocode/json?address=";
    if (province == "" || (province_id == 0 && p==1)) province = "";
    if (district == "" || (district_id == 0 && d==1)) district = "";
    if (ward == "" || (ward_id == 0 && w==1)) ward = "";
    console.log(province+">"+district+">"+ward+">"+street);
    straddr += street + ((street != "") ? "," : "") + ward + ((ward != "") ? "," : "") + district + ((district != "") ? "," : "") + province + "&sensor=false";
    console.log(straddr);
    $.ajax({
        type: "get",
        url: straddr,
        success: function (msg) {
            var geocode = eval(msg);
            if (geocode.status == "OK") {
                var result = geocode.results[0];
                var location = result.geometry.location;
                console.log(location.lat + " @ " + location.lng);
                $("input[name=maplat]").val(location.lat);
                $("input[name=maplng]").val(location.lng);

                reloadmap();
            }
            else alert("Không lấy được dữ liệu bản đồ từ địa chỉ trên.");
            console.log(geocode);
        }
    });
}
/**
 * reload image map from options input
 * Get image map from
 * http://maps.google.com/maps/api/staticmap?center=10.7986532,106.6512361&zoom=16&size=400x400&maptype=roadmap&sensor=false&language=&markers=color:red|label:none|10.7986532,106.6512361
 */
function reloadmap() {
    var stringmap = "http://maps.google.com/maps/api/staticmap?center=";
    if ($("input[name=maplat]").val() == "" || $("input[name=maplng]").val() == "") {
        alert("Chưa có thóng số lat hoặc lng");
        return;
    }
    stringmap += $("input[name=maplat]").val() + "," + $("input[name=maplng]").val() +
        "&zoom=" + $("input[name=mapz]").val() + "&size=" + $("input[name=mapw]").val() +
        "x" + $("input[name=maph]").val() + "&maptype=roadmap&sensor=false&language=&markers=color:red|label:none|" +
        $("input[name=maplat]").val() + "," + $("input[name=maplng]").val();
    var map = "<img src=" + stringmap  + ">";
        $("textarea[name=damap]").val(map);
    $("#damapdemo").html(map);

}
function checkexitsseourl(table,catname,catval,url){
    $.ajax({
        type:"post",
        url: $("input[name=base_url]").val()+"admin/checkexitsseourl",
        data: "table="+table+"&catname="+catname+"&url="+url+"&catval="+catval,
        success: function(msg){
            if(msg==1) return true;
            else return false;
        }
    })
}
function myformatdate(timestamp){
    var dt = new Date(timestamp*1000);

    var day = dt.getDate();
    var month = dt.getMonth()+1;
    var year = dt.getFullYear();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (day < 10)
        day = '0' + day;

    if (month < 10)
        month = '0' + month;


    return  day+'/'+month+'/'+year;

}
function mygetdate(){
    var dt = new Date();

    var day = dt.getDate();
    var month = dt.getMonth()+1;
    var year = dt.getFullYear();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (day < 10)
        day = '0' + day;

    if (month < 10)
        month = '0' + month;


    return year + "/" + month + "/" + day;

}
function mygettime(){
    var dt = new Date();

    var h = dt.getHours();
    var i = dt.getMinutes();
    var s = dt.getSeconds();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (h < 10)
        h = '0' + h;

    if (i < 10)
        i = '0' + i;
    if (s < 10)
        s = '0' + s;


    return h+":"+i+":"+s;

}
var formatTime = function(unixTimestamp) {
    var dt = new Date(unixTimestamp * 1000);

    var hours = dt.getHours();
    var minutes = dt.getMinutes();
    var seconds = dt.getSeconds();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (hours < 10)
        hours = '0' + hours;

    if (minutes < 10)
        minutes = '0' + minutes;

    if (seconds < 10)
        seconds = '0' + seconds;

    return hours + ":" + minutes + ":" + seconds;
}
var formatDate = function(unixTimestamp) {
    var dt = new Date(unixTimestamp * 1000);

    var day = dt.getDate();
    var month = dt.getMonth()+1;
    var year = dt.getFullYear();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (day < 10)
        day = '0' + day;

    if (month < 10)
        month = '0' + month;


    return year + "/" + month + "/" + day;
}