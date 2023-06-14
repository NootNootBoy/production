<?php
// Votre code pour se connecter à la base de données ici
$host = '176.31.132.185';
$db   = 'ohetkg_dashboar_db';
$user = 'ohetkg_dashboar_db';
$pass = '3-t2_UfA1s*Q0Iu!';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);

$stmt = $pdo->prepare('SELECT * FROM options');
$stmt->execute();
$options = $stmt->fetchAll();

$stmt = $pdo->prepare('SELECT * FROM users WHERE rang = "commercial"');
$stmt->execute();
$commerciaux = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
    <html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
  >
    <head>
      <meta charset="utf-8" />
      <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
      />
  
      <title>Clients- Mindset</title>
  
      <meta name="description" content="" />
  
      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  
      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
      />
  
      <!-- Icons. Uncomment required icon fonts -->
      <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  
      <!-- Core CSS -->
      <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
      <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="../assets/css/demo.css" />
  
      <!-- Vendors CSS -->
      <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  
      <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
  
      <!-- Page CSS -->
  
      <!-- Helpers -->
      <script src="../assets/vendor/js/helpers.js"></script>
  
      <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
      <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
      <script src="../assets/js/config.js"></script>
    </head>
<body>

    <div class="card">
        <h5 class="card-header">Listes des clients : </h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Site</th>
                <th>Description</th>
                <th>utilisateur</th>
                <th>Version</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            </tbody>
          </table>
          <form action="./php/add_client.php" method="post">
              <label for="nom">Nom:</label><br>
              <input type="text" id="nom" name="nom"><br>
              <label for="prenom">Prénom:</label><br>
              <input type="text" id="prenom" name="prenom"><br>
              <label for="societe">Société:</label><br>
              <input type="text" id="societe" name="societe"><br>
              <label for="siret">SIRET:</label><br>
              <input type="text" id="siret" name="siret"><br>
              <label for="email">Email:</label><br>
              <input type="email" id="email" name="email"><br>
              <label for="temps_engagement">Temps d'engagement:</label><br>
              <input type="number" id="temps_engagement" name="temps_engagement"><br>
              <label for="date_signature">Date de signature:</label><br>
              <input type="date" id="date_signature" name="date_signature"><br>
              <label for="adresse">Adresse:</label><br>
              <input type="text" id="adresse" name="adresse"><br>
              <label for="ville">Ville:</label><br>
              <input type="text" id="ville" name="ville"><br>
              <label for="code_postal">Code Postal:</label><br>
              <input type="text" id="code_postal" name="code_postal"><br>
              <label for="pays">Pays:</label><br>
              <input type="text" id="pays" name="pays"><br>
              
              <?php foreach ($options as $option): ?>
                <div>
                  <input type="checkbox" id="option<?php echo $option['id']; ?>" name="options[]" value="<?php echo $option['id']; ?>">
                  <label for="option<?php echo $option['id']; ?>"><?php echo $option['nom']; ?></label>
                </div>
              <?php endforeach; ?>

              <label for="commercial_id">Commercial:</label><br>
              <select id="commercial_id" name="commercial_id">
                <?php foreach ($commerciaux as $commercial): ?>
                  <option value="<?php echo $commercial['id']; ?>">
                    <?php echo $commercial['prenom'] . ' ' . $commercial['nom']; ?>
                  </option>
                <?php endforeach; ?>
              </select><br>
              <!-- Votre code pour les options et le commercial va ici -->

              <input type="submit" value="Ajouter le Client">
            </form>
        </div>
      </div>
      <script src="../assets/vendor/libs/jquery/jquery.js"></script>
      <script src="../assets/vendor/libs/popper/popper.js"></script>
      <script src="../assets/vendor/js/bootstrap.js"></script>
      <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  
      <script src="../assets/vendor/js/menu.js"></script>
      <!-- endbuild -->
  
      <!-- Vendors JS -->
      <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>
  
      <!-- Main JS -->
      <script src="../assets/js/main.js"></script>
  
      <!-- Page JS -->
      <script src="../assets/js/dashboards-analytics.js"></script>
  
      <!-- Place this tag in your head or just before your close body tag. -->
      <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>