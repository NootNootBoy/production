<?php
session_start();
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


$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['user_id'])) {
    die('User ID not set in session');
}

// Récupération des rangs
$stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'rang'");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$matches = array();
preg_match("/^enum\(\'(.*)\'\)$/", $result["Type"], $matches);
$rangs = explode("','", $matches[1]);

// Récupération des agences
$stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'agence'");
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$matches = array();
preg_match("/^enum\(\'(.*)\'\)$/", $result["Type"], $matches);
$agences = explode("','", $matches[1]);
?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default-dark"
    data-assets-path="../../assets/" data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Account settings - Account | Sneat - Bootstrap 5 HTML Admin Template - Pro</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core-dark.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default-dark.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include '../../php/components/menu.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include '../../php/components/navbar.php'; ?>
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profil /</span>
                            Paremètres</h4>

                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="javascript:void(0);"><i
                                                class="bx bx-user me-1"></i> Mes informations</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/php/auth-forgot-password-basic.php"><i
                                                class="bx bx-lock-alt me-1"></i> Changer de mot de passe</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                                class="bx bx-bell me-1"></i> Notifications</a>
                                    </li>
                                </ul>
                                <div class="card mb-4">
                                    <h5 class="card-header">Vos informations</h5>
                                    <!-- Account -->
                                    <!-- <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                                            <img src="../../assets/img/avatars/1.png" alt="user-avatar"
                                                class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                    <span class="d-none d-sm-block">Ajouter une nouvelle photo</span>
                                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                                    <input type="file" id="upload" class="account-file-input" hidden
                                                        accept="image/png, image/jpeg" />
                                                </label>

                                                <p class="text-muted mb-0">JPG, GIF ou PNG autorisés. Taille maximale de
                                                    5Mo</p>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="card-body">
                                        <div class="d-flex align-items-start align-items-sm-center gap-4">

                                            <img src="<?php echo isset($user['avatar']) ? $user['avatar'] : '../../assets/img/avatars/feron.jpg'; ?>"
                                                alt="user-avatar" class="d-block rounded" height="100" width="100"
                                                id="uploadedAvatar" />
                                            <div class="button-wrapper">
                                                <form action="upload_avatar.php" method="post"
                                                    enctype="multipart/form-data">
                                                    <label for="fileToUpload" class="btn btn-primary me-2 mb-4"
                                                        tabindex="0">
                                                        <span class="d-none d-sm-block">Ajouter une nouvelle
                                                            photo</span>
                                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                                        <input type="file" id="fileToUpload" name="fileToUpload"
                                                            class="account-file-input" hidden
                                                            accept="image/png, image/jpeg" />
                                                    </label>
                                                    <button type="submit" class="btn btn-dark">
                                                        <span class="tf-icons bx bx-upload"></span>Upload
                                                    </button>
                                                    <!-- <input type="submit" name="submit" class="btn btn-primary">
                                                    <span class="tf-icons bx bx-upload">Téléverser</span>
                                                    </input> -->
                                                    <p class="text-muted mb-0">JPG, GIF ou PNG autorisés. Taille
                                                        maximale de 5Mo</p>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <form class="mb-3" action="modify_profile.php" method="POST">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">Utilisateur</label>
                                                <input type="text" class="form-control" id="username" name="username"
                                                    placeholder="Entrer votre nom d'utilisateur"
                                                    value="<?php echo $users['username']; ?>" autofocus />
                                            </div>
                                            <div class="mb-3">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" class="form-control" id="nom" name="nom"
                                                    placeholder="Entrer votre nom "
                                                    value="<?php echo htmlspecialchars($users['nom']); ?>" autofocus />
                                            </div>
                                            <div class="mb-3">
                                                <label for="prenom" class="form-label">Prenom</label>
                                                <input type="text" class="form-control" id="prenom" name="prenom"
                                                    placeholder="Entrer votre prenom"
                                                    value="<?php echo $users['prenom']; ?>" autofocus />
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Entrer votre email"
                                                    value="<?php echo $users['email']; ?>" />
                                            </div>
                                            <?php if ($_SESSION['rang'] == 'administrateur'): ?>
                                            <div class="form-group">
                                                <label for="rang">Rang:</label>
                                                <select name="rang" id="rang" class="form-control" required>
                                                    <?php foreach ($rangs as $rang): ?>
                                                    <option value="<?php echo $rang; ?>"
                                                        <?php echo $users['rang'] == $rang ? 'selected' : ''; ?>>
                                                        <?php echo ucfirst($rang); ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <?php elseif ($_SESSION['rang'] !== 'administrateur'): ?>
                                            <div class="form-group">
                                                <label for="rang">Rang:</label>
                                                <input type="text" id="rang" name="rang" class="form-control"
                                                    value="<?php echo ucfirst($user['rang']); ?>" readonly>
                                                    value="<?php echo ucfirst($users['rang']); ?>" readonly>
                                            </div>
                                            <?php endif; ?>

                                            <div class="form-group">
                                                <label for="agence">Agence:</label>
                                                <select name="agence" id="agence" class="form-control" required>
                                                    <?php foreach ($agences as $agence): ?>
                                                    <option value="<?php echo $agence; ?>"
                                                        <?php echo $users['agence'] == $agence ? 'selected' : ''; ?>>
                                                        <?php echo ucfirst($agence); ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>


                                            <div class="mb-3">
                                            </div>
                                            <button class="btn btn-primary d-grid w-100">Modifier mes
                                                informations</button>
                                        </form>
                                    </div>
                                    <!-- /Account -->
                                </div>
                                <div class="card">
                                    <?php if ($_SESSION['rang'] == 'administrateur'): ?>
                                    <h5 class="card-header">Supprimer votre compte</h5>
                                    <div class="card-body">
                                        <div class="mb-3 col-12 mb-0">
                                            <div class="alert alert-warning">
                                                <h6 class="alert-heading fw-bold mb-1">Êtes-vous sûr de vouloir
                                                    supprimer votre compte ?</h6>
                                                <p class="mb-0">Une fois que vous avez supprimé votre compte, il n'y a
                                                    plus de retour en arrière.
                                                    Soyez certain.</p>
                                            </div>
                                        </div>
                                        <form id="formAccountDeactivation" onsubmit="return false">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="accountActivation"
                                                    id="accountActivation" />
                                                <label class="form-check-label" for="accountActivation">Je confirme
                                                    cette action</label>
                                            </div>
                                            <button type="submit" class="btn btn-danger deactivate-account">Desactiver
                                                le compte</button>
                                        </form>
                                    </div>
                                    <?php elseif ($_SESSION['rang'] !== 'administrateur'): ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal pour le succès du téléchargement -->
                    <div class="modal fade" id="uploadSuccessModal" tabindex="-1" role="dialog"
                        aria-labelledby="uploadSuccessModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadSuccessModalLabel">Succès du téléchargement</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Votre image a été téléchargée avec succès.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal pour l'échec du téléchargement -->
                    <div class="modal fade" id="uploadFailureModal" tabindex="-1" role="dialog"
                        aria-labelledby="uploadFailureModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadFailureModalLabel">Échec du téléchargement</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Une erreur s'est produite lors du téléchargement de votre image.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/select2/select2.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
    <script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>
    <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-account-settings-account.js"></script>
    <script>
    $(document).ready(function() {
        // Obtenez les paramètres 'upload' et 'error' de l'URL
        var urlParams = new URLSearchParams(window.location.search);
        var upload = urlParams.get('upload');
        var error = urlParams.get('error');

        // Ouvrez le modal approprié en fonction de la valeur du paramètre
        if (upload === 'success') {
            $('#uploadSuccessModal').modal('show');
        } else if (upload === 'failure') {
            // Décodez le message d'erreur et affichez-le dans le modal
            var errorMessage = decodeURIComponent(error);
            $('#uploadFailureModal .modal-body').text(errorMessage);
            $('#uploadFailureModal').modal('show');
        }
    });
    </script>
</body>

</html>