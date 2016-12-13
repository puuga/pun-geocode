<?php
include 'env.php';
?>
<?php
$raw = $_POST['result'];
$desc = $_POST['desc'];
$school_id = $_POST['school_id'];
$conn = db_connect();

header('Content-Type: application/json');

switch ($desc) {
  case 'google':
    $sql = "INSERT INTO \"public\".\"sc_google\" (\"id\",\"raw\",\"SchoolID\") ";
    $sql .= "VALUES (nextval('sc_google_id_seq'::regclass),'$raw','$school_id')";
    echo json_encode(
      [
        "desc"=>"google",
        "result"=>insertRawData($conn, $sql)
      ]);
    break;

  case 'bing':
    $sql = "INSERT INTO \"public\".\"sc_bing\" (\"id\",\"raw\",\"SchoolID\") ";
    $sql .= "VALUES (nextval('sc_google_id_seq'::regclass),'$raw','$school_id')";
    echo json_encode(
      [
        "desc"=>"bing",
        "result"=>insertRawData($conn, $sql)
      ]);
    break;

  case 'yahoo':
    $sql = "INSERT INTO \"public\".\"sc_yahoo\" (\"id\",\"raw\",\"SchoolID\") ";
    $sql .= "VALUES (nextval('sc_google_id_seq'::regclass),'$raw','$school_id')";
    echo json_encode(
      [
        "desc"=>"yahoo",
        "result"=>insertRawData($conn, $sql)
      ]);
    break;

  case 'mapQuest':
    $sql = "INSERT INTO \"public\".\"sc_mapquest\" (\"id\",\"raw\",\"SchoolID\") ";
    $sql .= "VALUES (nextval('sc_google_id_seq'::regclass),'$raw','$school_id')";
    echo json_encode(
      [
        "desc"=>"mapQuest",
        "result"=>insertRawData($conn, $sql)
      ]);
    break;

  case 'openCage':
    $sql = "INSERT INTO \"public\".\"sc_opencage\" (\"id\",\"raw\",\"SchoolID\") ";
    $sql .= "VALUES (nextval('sc_google_id_seq'::regclass),'$raw','$school_id')";
    echo json_encode(
      [
        "desc"=>"openCage",
        "result"=>insertRawData($conn, $sql)
      ]);
    break;

  default:
    # code...
    break;
}

function insertRawData($conn, $sql) {
  // INSERT INTO "public"."sc_google" ("id","raw") VALUES (nextval('sc_google_id_seq'::regclass),'{"i":"i"}')
  $result = pg_query($conn, $sql);
  if (!$result) {
    return false;
  }
  return true;
}
?>
