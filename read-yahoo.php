<?php
include 'env.php';
?>
<?php
$conn = db_connect();
$sql = "SELECT
  \"SchoolID\",
  \"id\", \"raw\" FROM \"public\".\"2sc_yahoo\"";
$result = pg_query($conn, $sql);
$bigArr = pg_fetch_all($result);

// print_r($arr);

foreach ($bigArr as $bigKey => $arr) {
  echo $bigKey."- ";
  // print_r($arr);
  $raws = json_decode($arr["raw"]);
  echo "$arr[SchoolID], $arr[id], ";
  if ($raws->query->count == 1) {
    // print_r($raws->query->results->place);
    $place = $raws->query->results->place;
    printData($place);
  } elseif ($raws->query->count > 1) {
    // print_r($raws->query->results->place);
    $place = $raws->query->results->place[0];
    printData($place);
  } else {
    echo ", , , , , , , , , , , , , ,";
  }

  echo "</br>";
}

function printData($place) {
  echo $place->placeTypeName->code.", ";
  echo $place->placeTypeName->content.", ";
  echo $place->name.", ";
  echo $place->country->code.", ";
  echo $place->country->type.", ";
  echo $place->country->content.", ";
  if ($place->admin1 != null) {
    echo $place->admin1->type.", ";
    echo $place->admin1->content.", ";
  } else {
    echo ", ";
  }
  if ($place->admin2 != null) {
    echo $place->admin2->type.", ";
    echo $place->admin2->content.", ";
  } else {
    echo ", ";
  }
  if ($place->locality1 != null) {
    echo $place->locality1->type.", ";
    echo $place->locality1->content.", ";
  } else {
    echo ", ";
  }
  if ($place->postal != null) {
    echo $place->postal->type.", ";
    echo $place->postal->content.", ";
  } else {
    echo ", ";
  }
  echo $place->centroid->latitude.", ";
  echo $place->centroid->longitude.", ";
}
?>
