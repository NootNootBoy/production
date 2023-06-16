<?php
session_start();

include '../db_connection.php';

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$username = $user['username'];

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

if (!file_exists($target_dir)) {
  mkdir($target_dir, 0755, true);
}


$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  $errorMessage = urlencode("Désolé, le fichier existe déjà");
  header('Location: settings.php?upload=failure&error=' . $errorMessage); // Redirigez vers settings.php avec le paramètre 'upload=failure' et le message d'erreur
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  $errorMessage = urlencode("Désolé, seuls les fichiers JPG, JPEG, PNG & GIF sont autorisés.");
  header('Location: settings.php?upload=failure&error=' . $errorMessage); // Redirigez vers settings.php avec le paramètre 'upload=failure' et le message d'erreur
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";

    $avatar_path = $target_file;
    $stmt = $pdo->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
    $stmt->execute(['avatar' => $avatar_path, 'id' => $user_id]);
    header('Location: settings.php?upload=success'); // Redirigez vers settings.php avec le paramètre 'upload=success'
  } else {
    header('Location: settings.php?upload=failure'); // Redirigez vers settings.php avec le paramètre 'upload=failure'
  }
}
?>