<?php
require "data/db.php";

// Çoklu silme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
    $ids = $_POST['ids']; // seçilen checkbox id'leri

    if (!empty($ids)) {
        // Kaç tane seçildiyse o kadar ? işareti koy
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = $pdo->prepare("DELETE FROM blog WHERE id IN ($placeholders)");
        $sql->execute($ids);
    }

    header("Location: blog.php");
    exit;
}

// Verileri çek
$sql = $pdo->query("SELECT * FROM blog ORDER BY id DESC");
$bloglar = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BLOG</title>
  <link rel="stylesheet" href="css/blog.css">
</head>
<body>
  <h2 style="text-align:center;">Blog Listesi</h2>

  <form method="POST" action="blog.php" onsubmit="return confirm('Seçilen kayıtları silmek istediğine emin misin?')">
    <table>
      <tr>
        <th>Seç</th>
        <th>ID</th>
        <th>Başlık</th>
        <th>Açıklama</th>
        <th>Kategori</th>
        <th>Görsel</th>
        <th>Oluşturulma</th>
      </tr>
      <?php if ($bloglar): ?>
        <?php foreach ($bloglar as $blog): ?>
          <tr>
            <td><input type="checkbox" name="ids[]" value="<?= $blog['id'] ?>"></td>
            <td><?= $blog['id'] ?></td>
            <td><?= htmlspecialchars($blog['title']) ?></td>
            <td><?= htmlspecialchars($blog['description']) ?></td>
            <td><?= htmlspecialchars($blog['category']) ?></td>
            <td>
              <?php if (!empty($blog['image_path'])): ?>
                <img src="<?= htmlspecialchars($blog['image_path']) ?>" alt="Resim">
              <?php else: ?>
                Yok
              <?php endif; ?>
            </td>
            <td><?= $blog['created_at'] ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="7">Hiç blog kaydı bulunamadı.</td>
        </tr>
      <?php endif; ?>
    </table>
    <div style="text-align:center;">
      <button type="submit">Seçilenleri Sil</button>
      <a href="admin.php" class="admin-btn">Admin Paneline Git</a>
    </div>
    
  </form>
</body>
</html>