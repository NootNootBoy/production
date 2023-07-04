<?php
session_start();
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
include 'db_connection.php';
include './notifications/notifications.php';

$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]); // Remplacez $username par la valeur appropriée
$user = $stmt->fetch();
$userId = $user['id']; // Changez $user_id en $userId

if (!isset($_SESSION['username'])) {
    // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
    header('Location: ../index.php');
    exit;
} else {
    // L'utilisateur est connecté, affichez son nom d'utilisateur dans la console du navigateur
    echo "<script>console.log('Connecté en tant que : " . $_SESSION['username'] . "');</script>";
}

    // Préparation et exécution de la requête pour le CA en prévision des 28 derniers jours
    $stmt = $pdo->prepare('
        SELECT SUM(offres.prix_mensuel * clients.temps_engagement) AS CA_prevision_28_days
        FROM users
        JOIN clients ON users.id = clients.commercial_id
        JOIN offres ON clients.offre_id = offres.id
        WHERE clients.code_assurance IS NULL AND users.id = :userId
            AND clients.created_at >= DATE_SUB(CURDATE(), INTERVAL 28 DAY)
    ');
    $stmt->execute(['userId' => $userId]);
    $CA_prevision_28_days = $stmt->fetch(PDO::FETCH_ASSOC)['CA_prevision_28_days'];

    // Préparation et exécution de la requête pour le CA en prévision des 3 derniers mois
    $stmt = $pdo->prepare('
        SELECT SUM(offres.prix_mensuel * clients.temps_engagement) AS CA_prevision_3_months
        FROM users
        JOIN clients ON users.id = clients.commercial_id
        JOIN offres ON clients.offre_id = offres.id
        WHERE clients.code_assurance IS NULL AND users.id = :userId
            AND clients.created_at >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
    ');
    $stmt->execute(['userId' => $userId]);
    $CA_prevision_3_months = $stmt->fetch(PDO::FETCH_ASSOC)['CA_prevision_3_months'];

    // Préparation et exécution de la requête pour le CA en prévision depuis le début
    $stmt = $pdo->prepare('
        SELECT SUM(offres.prix_mensuel * clients.temps_engagement) AS CA_prevision_total
        FROM users
        JOIN clients ON users.id = clients.commercial_id
        JOIN offres ON clients.offre_id = offres.id
        WHERE clients.code_assurance IS NULL AND users.id = :userId
    ');
    $stmt->execute(['userId' => $userId]);
    $CA_prevision_total = $stmt->fetch(PDO::FETCH_ASSOC)['CA_prevision_total'];

        // Préparation et exécution de la requête pour le CA réalisé
        $stmt = $pdo->prepare('
        SELECT SUM(offres.prix_mensuel * clients.temps_engagement) AS CA_realise
        FROM users
        JOIN clients ON users.id = clients.commercial_id
        JOIN offres ON clients.offre_id = offres.id
        WHERE clients.code_assurance IS NOT NULL AND users.id = :userId
    ');
    $stmt->execute(['userId' => $userId]);
    $CA_realise = $stmt->fetch(PDO::FETCH_ASSOC)['CA_realise'];

    $months = [];
for ($i = 5; $i >= 0; $i--) {
    $months[] = strftime('%b', strtotime("-$i month"));
}
$months_json = json_encode($months);

?>

<!DOCTYPE html>

<html lang="en" class="dark-style layout-menu-fixed" dir="ltr" data-theme="theme-default-dark"
    data-assets-path="../assets/">

<html lang="en" class="dark-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default-dark"
    data-assets-path="../../assets/" data-template="vertical-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/rtl/core-dark.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/rtl/theme-default-dark.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="../assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
</head>
88

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <?php include './components/menu.php'; ?>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <?php include './components/navbar.php'; ?>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <div class="col-lg-8 mb-4 order-0">
                                <div class="card">
                                    <div class="d-flex align-items-end row">
                                        <div class="col-sm-7">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">Bienvenue sur le tableau de bord !
                                                    🎉</h5>
                                                <p class="mb-4">
                                                    You have done <span class="fw-bold">100%</span> more sales today.
                                                    Check your new badge in
                                                    your profile.
                                                </p>

                                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">lorem</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 text-center text-sm-left">
                                            <div class="card-body pb-0 px-0 px-md-4">
                                                <img src="../assets/img/illustrations/man-with-laptop-light.png"
                                                    height="140" alt="View Badge User"
                                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($_SESSION['user_id']) && $_SESSION['rang'] == 'commercial') {?>

                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h5 class="card-title m-0 me-2">Votre chiffre d'affaire</h5>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="performanceId"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end"
                                                aria-labelledby="performanceId">
                                                <a class="dropdown-item" href="javascript:void(0);">28 derniers
                                                    jours</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Dernier mois</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Derniere année</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <small>CA en prévision: <span
                                                        class="fw-semibold"><?php echo $CA_prevision_28_days; ?></span></small>
                                            </div>
                                            <div class="col-6">
                                                <small>CA réalisé: <span
                                                        class="fw-semibold"><?php echo $CA_realise; ?></span></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="performanceChart"></div>
                                </div>
                            </div>
                            <!--/ Performance -->
                            <?php
                        }?>
                            <div class="row">

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
        </div>
        <!-- / Layout wrapper -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
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
        <script>
        let cardColor, headingColor, labelColor, shadeColor, borderColor, heatMap1, heatMap2, heatMap3, heatMap4;


        cardColor = config.colors_dark.cardColor;
        headingColor = config.colors_dark.headingColor;
        labelColor = config.colors_dark.textMuted;
        borderColor = config.colors_dark.borderColor;
        shadeColor = 'dark';
        heatMap1 = '#4f51c0';
        heatMap2 = '#595cd9';
        heatMap3 = '#8789ff';
        heatMap4 = '#c3c4ff';
        // Performance - Radar Chart
        // --------------------------------------------------------------------
        const performanceChartEl = document.querySelector('#performanceChart'),
            performanceChartConfig = {
                series: [{
                        name: 'C.A prévision',
                        data: [26, 29, 31, 30, 30, 30]
                    },
                    {
                        name: 'C.A réalisé',
                        data: [26, 29, 31, 30, 30, 30]
                    }
                ],
                chart: {
                    height: 270,
                    type: 'radar',
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        enabledOnSeries: undefined,
                        top: 6,
                        left: 0,
                        blur: 6,
                        color: '#000',
                        opacity: 0.14
                    }
                },
                plotOptions: {
                    radar: {
                        polygons: {
                            strokeColors: borderColor,
                            connectorColors: borderColor
                        }
                    }
                },
                stroke: {
                    show: false,
                    width: 0
                },
                legend: {
                    show: true,
                    fontSize: '13px',
                    position: 'bottom',
                    labels: {
                        colors: '#aab3bf',
                        useSeriesColors: false
                    },
                    markers: {
                        height: 10,
                        width: 10,
                        offsetX: -3
                    },
                    itemMargin: {
                        horizontal: 10
                    },
                    onItemHover: {
                        highlightDataSeries: false
                    }
                },
                colors: [config.colors.primary, config.colors.info],
                fill: {
                    opacity: [1, 0.85]
                },
                markers: {
                    size: 0
                },
                grid: {
                    show: false,
                    padding: {
                        top: -8,
                        bottom: -5
                    }
                },
                xaxis: {
                    categories: <?php echo $months_json; ?>,
                    labels: {
                        show: true,
                        style: {
                            colors: [labelColor, labelColor, labelColor, labelColor, labelColor, labelColor],
                            fontSize: '13px',
                            fontFamily: 'Public Sans'
                        }
                    }
                },
                yaxis: {
                    show: false,
                    min: 0,
                    max: 100,
                    tickAmount: 4
                }
            };
        if (typeof performanceChartEl !== undefined && performanceChartEl !== null) {
            const performanceChart = new ApexCharts(performanceChartEl, performanceChartConfig);
            performanceChart.render();
        }
        </script>
        <!-- Place this tag in your head or just before your close body tag. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>