<?php 
$host = '176.31.132.185';
$db   = 'vesqbc_producti_db';
$user = 'vesqbc_producti_db';
$pass = '7f-yp!QZWOg6_%49';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
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
  
      <title>Dashboard - Mindset</title>
  
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
        <h5 class="card-header">Listes des sites : </h5>
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
                <?php
                  $url = 'https://cabinet-mindset-marketing.com/wp-json/mindsetapi/v1/site-info';
                  $response = file_get_contents($url);
                  $site_info = json_decode($response, true);
                  include 'project_row.php';
                  // $url = 'https://cabinet-mindset-marketing.com/wp-json/mindsetapi/v1/site-info';
                  // $response = file_get_contents($url);
                  // $site_info = json_decode($response, true); // Utilisez directement $response_data
                  
                  // if (file_exists('project_row.php')) {
                  //     include 'project_row.php';
                  // } else {
                  //     echo "Le fichier 'project_row.php' n'existe pas.";
                  //     exit;
                  // }
                  
                  ?>
            </tbody>
          </table>
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