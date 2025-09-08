<?php
include 'data/db.php';

// Sadece kategori "SPOR" olan haberleri çek
$sql = $pdo->prepare("SELECT * FROM blog WHERE category = ? ORDER BY created_at DESC");
$sql->execute(['SPOR']); // Burada kategori SPOR
$haberler = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YB Haber - Spor</title>
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

 <h1 style="padding-left: 65%;">SPOR</h1>

  <div class="container">
    <?php if($haberler): ?>
      <?php foreach($haberler as $haber): ?>
        <a href="haber.php?id=<?= $haber['id'] ?>" class="card">
          <?php if(!empty($haber['image_path'])): ?>
            <img src="<?= htmlspecialchars($haber['image_path']) ?>" alt="Haber Görseli">
          <?php else: ?>
            <img src="placeholder.jpg" alt="Haber Görseli">
          <?php endif; ?>
          <div class="card-content">
            <h2><?= htmlspecialchars($haber['title']) ?></h2>
            <p class="desc"><?= htmlspecialchars($haber['description']) ?></p>
            <div class="meta">
              <span class="cat"><?= htmlspecialchars($haber['category']) ?></span>
              <span class="date"><?= date('d.m.Y', strtotime($haber['created_at'])) ?></span>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="text-align:center; font-size:18px; margin-top:30px;">Bu kategoride haber bulunamadı.</p>
    <?php endif; ?>
  </div>
</body>
</html>

