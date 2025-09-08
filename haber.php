<?php
include 'data/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Geçersiz haber ID");
}

$id = (int)$_GET['id'];
$sql = $pdo->prepare("SELECT * FROM blog WHERE id = ?");
$sql->execute([$id]);
$haber = $sql->fetch(PDO::FETCH_ASSOC);

if (!$haber) {
    die("Haber bulunamadı!");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($haber['title']) ?> - YB Haber</title>
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <div class="nav">
    <h1>YB HABER</h1>
    <div>
      <button class="btn" onclick="location.href='index.php'">ANA SAYFA</button>
      <button class="btn" onclick="location.href='ekonami.php'">EKONOMİ</button>
      <button class="btn" onclick="location.href='futbol.php'">SPOR</button>
      <button class="btn" onclick="location.href='siyaset.php'">SİYASET</button>
       <button class="btn" onclick="location.href='teknoloji.php'">TEKNOLOJİ</button>
    </div>
  </div>

  <div class="haber-detay">
    <h2><?= htmlspecialchars($haber['title']) ?></h2>
    <div class="meta">
      <span class="cat"><?= htmlspecialchars($haber['category']) ?></span> | 
      <span class="date"><?= date("d.m.Y H:i", strtotime($haber['created_at'])) ?></span>
    </div>
    
    <?php if (!empty($haber['image_path'])): ?>
      <img class="haber-gorsel" src="<?= htmlspecialchars($haber['image_path']) ?>" alt="Haber Görseli">
    <?php endif; ?>

    <p class="desc"><?= nl2br(htmlspecialchars($haber['description'])) ?></p>
  </div>
</body>
</html>
