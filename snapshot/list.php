<?php
require_once("../db/database.php");
require_once("../db/classes.php");
$address = -1;
if (isset($_GET["address"])) {
    $address =intval($_GET["address"]);
}
//database connect
$pdo = connectDatabase();
// sql set
$sql = "select * from hotels where pref like ?";
//sql run
$pstmt = $pdo->prepare($sql);

$pstmt->bindValue(1,'"%.$address.%"');

$pstmt->execute();
//結果
$rs = $pstmt->fetchAll();
disconnectDatabase($pdo);
//list
$hotels = [];
foreach ($rs as $record){
    $id = intval($record["id"]);
    $name = $record["name"];
    $price = intval($record["price"]);
    $pref = $record["pref"];
    $city = $record["city"];
    $address = $record["address"];
    $memo = $record["memo"];
    $image = $record["image"];
    $hotel = new Hotel($id,$name,$price,$pref,$city,$address,$memo,$image);
    $hotels[] = $hotel;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
	<meta charset="UTF-8">
	<title>ホテル検索結果一覧</title>
	<link rel="stylesheet" href="../assets/css/style.css" />
	<link rel="stylesheet" href="../assets/css/hotels.css" />
</head>

<body>
	<header>
		<h1>ホテル検索結果一覧</h1>
		<p><a href="./entry.php">検索ページに戻る</a></p>
	</header>
	<main>
		<article>
			<table>
				<tr>
					<td>
						<img src="../images/1.png" width="100" />
					</td>
					<td>
						<table class="detail">
						    <?php foreach ($hotels as $ht) { ?>
							<tr>
								<td><?= $ht->getName ?><br /></td>
							</tr>
							<tr>
								<td>東京都品川区大井 11-11-11</td>
							</tr>
							<tr>
								<td>宿泊料：&yen;7,000</td>
							</tr>
							<tr>
								<td></td>
							</tr>
							<?php } ?>
						</table>
					</td>
				</tr>
			</table>
		</article>
	</main>
	<footer>
		<div id="copyright">(C) 2019 The Web System Development Course</div>
	</footer>
</body>

</html>