<?php
session_start();
if (isset($_SESSION['username'])) {
    // L'utilisateur est déjà connecté, redirigez-le vers le tableau de bord
    header('Location: dashboard.php');
    exit;
}

$user = "ohetkg_dashboar_db";
$pass = "3-t2_UfA1s*Q0Iu!";
$pdo = new PDO('mysql:host=176.31.132.185;dbname=ohetkg_dashboar_db', $user, $pass);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'];


    // Vérifier si le jeton est dans la base de données
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        // Le jeton est valide, afficher le formulaire de réinitialisation du mot de passe
        echo '
        <!DOCTYPE html>

        <html
          lang="en"
          class="light-style customizer-hide"
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
        
            <title>Mot de passe oublié</title>
        
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
        
            <!-- Page CSS -->
            <!-- Page -->
            <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
            <!-- Helpers -->
            <script src="../assets/vendor/js/helpers.js"></script>
        
            <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
            <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
            <script src="../assets/js/config.js"></script>
          </head>
        
          <body>
            <!-- Content -->
        
            <div class="container-xxl">
                    <div class="authentication-wrapper authentication-basic container-p-y">
                        <div class="authentication-inner py-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="app-brand justify-content-center">
                                        <a href="../index.php" class="app-brand-link gap-2">
                                            <span class="app-brand-logo demo">
                                                <div class="d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                                    <img src="assets/img/favicon/logo--mindset_black.png" class="img-thumbnail" alt="...">
                                                </div>
                                            </span>
                                        </a>
                                    </div>
                                    <h4 class="mb-2">Changer de mot de passe</h4>
                                    <form id="formChangePassword" class="mb-3" action="reset_password.php" method="POST">
                                    <input type="hidden" name="token" value="' . $token . '">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Nouveau mot de passe</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your new password" />
                                        </div>
                                            </div>
                                            <div id="passwordError" style="display: none; color: red;">Les mots de passe ne correspondent pas.</div>
                                            <button type="submit" class="btn btn-primary d-grid w-100">Changer le mot de passe</button>
                                        </form>
                                        <div class="text-center">
                                            <a href="../index.php" class="d-flex align-items-center justify-content-center">
                                                <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                                                Page de connexion
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
            <!-- Core JS -->
            <!-- build:js assets/vendor/js/core.js -->
            <script src="../assets/vendor/libs/jquery/jquery.js"></script>
            <script src="../assets/vendor/libs/popper/popper.js"></script>
            <script src="../assets/vendor/js/bootstrap.js"></script>
            <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        
            <script src="../assets/vendor/js/menu.js"></script>
            <!-- endbuild -->
        
            <!-- Vendors JS -->
        
            <!-- Main JS -->
            <script src="../assets/js/main.js"></script>
        
            <!-- Page JS -->
        
            <!-- Place this tag in your head or just before your close body tag. -->
            <script async defer src="https://buttons.github.io/buttons.js"></script>
          </body>
          
        </html>        
        ';
    } else {
        // Le jeton n'est pas valide ou a expiré
        echo 'Le lien de réinitialisation du mot de passe n\'est pas valide ou a expiré.';
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Récupérer l'adresse e-mail à partir du jeton
    $stmt = $pdo->prepare('SELECT * FROM password_resets WHERE token = ?');
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        $email = $reset['email'];

        // Mettre à jour le mot de passe de l'utilisateur
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->execute([$password, $email]);

        // Supprimer le jeton de réinitialisation du mot de passe
        $stmt = $pdo->prepare('DELETE FROM password_resets WHERE token = ?');
        $stmt->execute([$token]);

        // Envoyer un email de confirmation de réinitialisation de mot de passe
        $to = $email;
        $subject = 'Votre mot de passe a été réinitialisé';
        $message = 'Votre mot de passe a été réinitialisé avec succès. Si vous n\'avez pas demandé cette réinitialisation, veuillez nous contacter immédiatement.';
        mail($to, $subject, $message);

        echo 'Votre mot de passe a été réinitialisé avec succès.';

    } else {
        // Le jeton n'est pas valide ou a expiré
        echo 'Le lien de réinitialisation du mot de passe n\'est pas valide ou a expiré.';
    }
}
?>
