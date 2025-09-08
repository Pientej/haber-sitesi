<?php
include 'data/db.php';

// Verileri çek
$sql = $pdo->query("SELECT * FROM blog ORDER BY created_at DESC");
$haberler = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YB Haber</title>
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

  <div class="container">
    <?php if ($haberler): ?>
      <?php foreach ($haberler as $haber): ?>
        <a href="haber.php?id=<?= $haber['id'] ?>" class="card">
          <?php if (!empty($haber['image_path'])): ?>
            <img src="<?= htmlspecialchars($haber['image_path']) ?>" alt="Haber Görseli">
          <?php else: ?>
            <img src="default.jpg" alt="Varsayılan Görsel">
          <?php endif; ?>

          <div class="card-content">
            <h2><?= htmlspecialchars($haber['title']) ?></h2>
            <p class="desc"><?= mb_strimwidth(htmlspecialchars($haber['description']), 0, 120, "...") ?></p>
            <div class="meta">
              <span class="cat"><?= htmlspecialchars($haber['category']) ?></span>
              <span class="date"><?= date("d.m.Y H:i", strtotime($haber['created_at'])) ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center; margin-top:20px;">Henüz haber bulunmamaktadır.</p>
    <?php endif; ?>
  </div>
</body>
</html>
