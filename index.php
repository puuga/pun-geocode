<?php
include 'env.php';
?>
<?php
$conn = db_connect();
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page-1)*50;
$row_number = $offset+1;
$total_row = 5003;
// $result = pg_query($conn, "select count(*) from school2"); // 5003
$result = pg_query($conn, "select * from school2 LIMIT 50 OFFSET $offset");
// var_dump(pg_fetch_all($result));
// exit();
$arr = pg_fetch_all($result);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  </head>
  <body>
    <p>
      page:
      <?php
        for ($i=1; $i<=101 ; $i++) {
          echo "<a href='index.php?page=$i'>$i</a> ";
        }
      ?>
    </p>
    <table border='1'>
      <tr>
        <td>SchoolID</td>
        <td>Google</td>
        <td>Bing</td>
        <td>Yahoo</td>
        <td>MapQuest</td>
        <td>OpenCage</td>
        <td>All</td>
      </tr>
      <?php
      foreach ($arr as $row) {
        echo "<tr>";
        echo "<td>$row_number, $row[SchoolID], $row[SchoolName]</td>";
        echo "<td><span id=\"google$row[SchoolID]\"> </span></td>";
        echo "<td><span id=\"bing$row[SchoolID]\"> </span></td>";
        echo "<td><span id=\"yahoo$row[SchoolID]\"> </span></td>";
        echo "<td><span id=\"mapQuest$row[SchoolID]\"> </span></td>";
        echo "<td><span id=\"openCage$row[SchoolID]\"> </span></td>";
        echo "<td><button onclick=\"javascript:reqAll('$row[SchoolID]' ,'$row[SchoolName]', '$row[SubDistrict]', '$row[District]', '$row[Province]', '$row[PostCode]')\">Req</button></td>";
        echo "</tr>";

        $row_number++;
      }
      ?>
    </table>

    <script type="text/javascript">
      function reqAll(schoolID, schoolName, subDistrict, district, province, postCode) {
        console.log(schoolID, schoolName, subDistrict, district, province, postCode);

        reqGoogle(schoolID, schoolName, subDistrict, district, province, postCode);
        // reqBing(schoolID, schoolName, subDistrict, district, province, postCode);
        reqYahoo(schoolID, schoolName, subDistrict, district, province, postCode);
        reqMapQuest(schoolID, schoolName, subDistrict, district, province, postCode);
        reqOpenCage(schoolID, schoolName, subDistrict, district, province, postCode)
      }

      function reqGoogle(schoolID, schoolName, subDistrict, district, province, postCode) {
        let google = "AIzaSyAPnpndStKXOKX4CKGPhMc-e9YcfVWjvyg";
        // https://maps.googleapis.com/maps/api/geocode/json?address=วิทยาลัยเทคนิคมีนบุรี+มีนบุรี+เขตมีนบุรี+กรุงเทพมหานคร+TH&key=AIzaSyAPnpndStKXOKX4CKGPhMc-e9YcfVWjvyg
        let url = "https://maps.googleapis.com/maps/api/geocode/json?address=";
        url += schoolName + "+" + subDistrict + "+" + district + "+" + province + "+" + postCode;
        url += "+TH&key=" + google;

        // make request to service
        $.ajax({
          url: url
        })
        .done(function(json) {
          console.log("google - url: ", url);
          console.log(JSON.stringify(json));
          $("#google"+schoolID).html("done");
        })
        .fail(function(error) {
          console.log("google - url: ", url);
          console.log("error", error);
          $("#google"+schoolID).html("error");
        });
      }

      function reqBing(schoolID, schoolName, subDistrict, district, province, postCode) {
        let bing1 = "Ar5HnTh4NYVtUAXC3bPMleEnKNFK3CJfWPCoQmiKujbTevcJUWcPmDLFKZp4ZXa2";
        let bing2 = "AovMCAdqu0Cc0a1AyDiSixbC0raz7HZdHwkAvR_jtDXh-_DiME4OiopQzZbGoST3";
        let bing3 = "AoQgczvoi-oxwpJemTTu48SbwX7bqy-9Dpo93lz6jzqShxXQ4BGOy1AyQoQP6-_0";
        let bing4 = "AsmTWpR0PhrehWaallNd_PN-yvUIwrvhuDYB5mio6fp-iMGxmasfrMhA2Hzg08AA";
        let bing5 = "AtM2AxU0OD81AZx4trabJ7b0K7crzwzOGZzjv1YfYKUkXmuu7haAsZgZXM8Ca9L5";
        // http://dev.virtualearth.net/REST/v1/Locations/524 เจริญสุข  ในเมือง เมืองกำแพงเพชร 62000?c=th&key=Ar5HnTh4NYVtUAXC3bPMleEnKNFK3CJfWPCoQmiKujbTevcJUWcPmDLFKZp4ZXa2

        let url = "https://dev.virtualearth.net/REST/v1/Locations/";
        url += schoolName + " " + subDistrict + " " + district + " " + province + " " + postCode;
        url += "?o=json&c=th&key=" + bing1;

        // make request to service
        $.ajax({
          url: url,
          dataType: 'jsonp',
          crossDomain: true,
          converters: {
            '* jsonp': function(result) {
              // Do Stuff
              return result;
            }
          }
        })
        .done(function(parsedResponse,statusText,jqXhr) {
          console.log("bing - url: ", url);
          console.log(JSON.stringify(jqXhr));
          $("#bing"+schoolID).html("done");
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
          console.log("bing - url: ", url);
          if (jqXHR.status == 200) {
            console.log("body", jqXHR);
            console.log("body", textStatus);
            console.log("body", errorThrown);
            $("#bing"+schoolID).html("error");
          } else {
            console.log("error", textStatus);
            $("#bing"+schoolID).html("error");
          }
        });

      }

      function reqYahoo(schoolID, schoolName, subDistrict, district, province, postCode) {
        let yahoo = "dj0yJmk9Z1NlMkljejg2SDNhJmQ9WVdrOVFteGxTV05xTjJFbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD02Mg--";
        // http://query.yahooapis.com/v1/public/yql?q=select * from geo.places where text=" 70, 4, หาดกรวด, เมือง, อุตรดิตถ์, 53000"&format=xml

        let url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20geo.places%20where%20text=\"";
        url += schoolName + ", " + subDistrict + ", " + district + ", " + province + ", " + postCode;
        url += "\"&format=json";

        // make request to service
        $.ajax({
          url: url
        })
        .done(function(json) {
          console.log("yahoo - url: ", url);
          console.log(JSON.stringify(json));
          $("#yahoo"+schoolID).html("done");
        })
        .fail(function(error) {
          console.log("yahoo - url: ", url);
          console.log("error", error);
          $("#yahoo"+schoolID).html("error");
        });
      }

      function reqMapQuest(schoolID, schoolName, subDistrict, district, province, postCode) {
        let mapQuest = "L2glLMn9wYIpao9fTXQMHjlyH3kGRo3d";
        // http://www.mapquestapi.com/geocoding/v1/address?key=L2glLMn9wYIpao9fTXQMHjlyH3kGRo3d&location=มหาวิทยาลัยราชภัฎเชียงราย,บ้านดู่,เมือง,เชียงราย
        let url = "http://www.mapquestapi.com/geocoding/v1/address?key=" + mapQuest;
        url += "&location=" + schoolName + "," + subDistrict + "," + district + "," + province + "," + postCode;

        // make request to service
        $.ajax({
          url: url
        })
        .done(function(json) {
          console.log("mapQuest - url: ", url);
          console.log(JSON.stringify(json));
          $("#mapQuest"+schoolID).html("done");
        })
        .fail(function(error) {
          console.log("mapQuest - url: ", url);
          console.log("error", error);
          $("#mapQuest"+schoolID).html("error");
        });
      }

      function reqOpenCage(schoolID, schoolName, subDistrict, district, province, postCode) {
        let openCage = "079756be0355e9362177f64a2c216d23";
        // http://api.opencagedata.com/geocode/v1/xml?q=113, 16, บ้านดู่, เมือง, เชียงราย, 57100&key=079756be0355e9362177f64a2c216d23&limit=1&no_annotations=1

        let url = "http://api.opencagedata.com/geocode/v1/xml?q=";
        url += schoolName + "," + subDistrict + "," + district + "," + province + "," + postCode;
        url += "&key=" + openCage + "&limit=1&no_annotations=1";

        // make request to service
        $.ajax({
          url: url
        })
        .done(function(json) {
          console.log("openCage - url: ", url);
          console.log(JSON.stringify(json));
          $("#openCage"+schoolID).html("done");
        })
        .fail(function(error) {
          console.log("openCage - url: ", url);
          console.log("error", error);
          $("#openCage"+schoolID).html("error");
        });
      }
    </script>

  </body>
</html>
