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
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td> </td>";
        echo "<td><button onclick=\"javascript:reqAll('$row[SchoolName]', '$row[SubDistrict]', '$row[District]', '$row[Province]', '$row[PostCode]')\">Req</button></td>";
        echo "</tr>";

        $row_number++;
      }
      ?>
    </table>

    <script type="text/javascript">
      function reqAll(schoolName, subDistrict, district, province, postCode) {
        console.log(schoolName, subDistrict, district, province, postCode);
      }

      function reqGoogle() {

      }

      function reqBing() {

      }

      function reqYahoo() {

      }

      function reqMapQuest() {

      }

      function reqOpenCage() {

      }
    </script>

  </body>
</html>
