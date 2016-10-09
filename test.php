<?php
// create a PDO object
include('configuration.php');
$PDO = new \PDO( $config['mysql:host=localhost;dbname=db2016;charset=utf8'], $config['root'], $config[''] );
$PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

// execute a query using PDO
$stmt = $PDO->prepare("SELECT * FROM country where iso_code = ? ");
$myWriterUri = "BE";
$stmt->execute(array($myWriterUri));
$res = $stmt->fetchAll( \PDO::FETCH_ASSOC );

foreach($res as $row) {
  print $row['name'];
}
?>
