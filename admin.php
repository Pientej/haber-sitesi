<?php
include 'data/db.php'; // PDO bağlantısı

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $category = $_POST['category'] ?? null;

    if (!$title || !$description || !$category) {
        $message = "❌ Lütfen tüm alanları doldurun.";
    } elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== 0) {
        $message = "❌ Fotoğraf seçilmedi veya bir hata oluştu.";
    } else {
        $image_name = $_FILES['photo']['name'];
        $image_tmp = $_FILES['photo']['tmp_name'];

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed_extensions)) {
            $message = "❌ Geçersiz dosya türü. Yalnızca jpg, png, gif, webp kabul edilir.";
        } else {
            $upload_dir = 'uploads/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $unique_name = time() . '_' . uniqid() . '.' . $ext;
            $image_path = $upload_dir . $unique_name;

            if (move_uploaded_file($image_tmp, $image_path)) {
                $query = "INSERT INTO blog (title, description, category, image_path)
                          VALUES (:title, :description, :category, :image_path)";
                $stmt = $pdo->prepare($query);
                $stmt->execute([
                    'title' => $title,
                    'description' => $description,
                    'category' => $category,
                    'image_path' => $image_path
                ]);

                $message = "✅ Blog başarıyla yüklendi.";
            } else {
                $message = "❌ Fotoğraf yüklenemedi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Panel</title>
  <link rel="stylesheet" href="css/admin.css" />
</head>
<body>

  <?php if ($message): ?>
    <div class="message <?= strpos($message, '✅') === 0 ? 'success' : 'error' ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <form action="admin.php" method="POST" enctype="multipart/form-data">
    <h2>Fotoğraf Yükle</h2>

    <label for="photo">Fotoğraf Seç:</label>
    <input type="file" id="photo" name="photo" accept="image/*" required />

    <label for="title">Başlık:</label>
    <input type="text" id="title" name="title" placeholder="Başlık giriniz" required />

    <label for="description">Açıklama:</label>
    <textarea id="description" name="description" rows="4" placeholder="Açıklama giriniz..." required></textarea>

    <label for="category">Kategori Seç:</label>
    <select id="category" name="category" required>
      <option value="">-- Kategori Seçin --</option>
      <option value="siyaset">Siyaset</option>
      <option value="spor">Spor</option>
      <option value="ekonomi">Ekonomi</option>
      <option value="teknoloji">Teknoloji</option>
    </select>

    <button type="submit">Yükle</button>
    <a href="blog.php" class="admin-btn">Blogları Görmek için Git</a>
  </form>

</body>
</html>