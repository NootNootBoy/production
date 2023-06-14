<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Clients List</title>

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
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/flatpickr/flatpickr.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

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

            <?php include 'components/menu.php'; ?>


            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                <?php include 'components/navbar.php'; ?>


                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">DataTables /</span> Basic</h4>

                        <div class="card">
                            <h5 class="card-header">Listes des sites : </h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Client</th>
                                            <th>Societé</th>
                                            <th>Gerant</th>
                                            <th>Commerciaux</th>
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
                        <!-- Modal to add new record -->
                        <div class="offcanvas offcanvas-end" id="add-new-record">
                            <div class="offcanvas-header border-bottom">
                                <h5 class="offcanvas-title" id="exampleModalLabel">New Record</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body flex-grow-1">
                                <form class="add-new-record pt-0 row g-2" id="form-add-new-record"
                                    onsubmit="return false">
                                    <div class="col-sm-12">
                                        <label class="form-label" for="basicFullname">Full Name</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basicFullname2" class="input-group-text"><i
                                                    class="bx bx-user"></i></span>
                                            <input type="text" id="basicFullname" class="form-control dt-full-name"
                                                name="basicFullname" placeholder="John Doe" aria-label="John Doe"
                                                aria-describedby="basicFullname2" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="basicPost">Post</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basicPost2" class="input-group-text"><i
                                                    class="bx bxs-briefcase"></i></span>
                                            <input type="text" id="basicPost" name="basicPost"
                                                class="form-control dt-post" placeholder="Web Developer"
                                                aria-label="Web Developer" aria-describedby="basicPost2" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="basicEmail">Email</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input type="text" id="basicEmail" name="basicEmail"
                                                class="form-control dt-email" placeholder="john.doe@example.com"
                                                aria-label="john.doe@example.com" />
                                        </div>
                                        <div class="form-text">You can use letters, numbers & periods</div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="basicDate">Joining Date</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basicDate2" class="input-group-text"><i
                                                    class="bx bx-calendar"></i></span>
                                            <input type="text" class="form-control dt-date" id="basicDate"
                                                name="basicDate" aria-describedby="basicDate2" placeholder="MM/DD/YYYY"
                                                aria-label="MM/DD/YYYY" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label" for="basicSalary">Salary</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basicSalary2" class="input-group-text"><i
                                                    class="bx bx-dollar"></i></span>
                                            <input type="number" id="basicSalary" name="basicSalary"
                                                class="form-control dt-salary" placeholder="12000" aria-label="12000"
                                                aria-describedby="basicSalary2" />
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit"
                                            class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
                                        <button type="reset" class="btn btn-outline-secondary"
                                            data-bs-dismiss="offcanvas">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!--/ DataTable with Buttons -->

                        <hr class="my-5" />
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
        <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
        <!-- Flat Picker -->
        <script src="../../assets/vendor/libs/moment/moment.js"></script>
        <script src="../../assets/vendor/libs/flatpickr/flatpickr.js"></script>
        <!-- Form Validation -->
        <script src="../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
        <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
        <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

        <!-- Main JS -->
        <script src="../../assets/js/main.js"></script>

        <!-- Page JS -->
        <script src="../../assets/js/tables-datatables-basic.js"></script>
</body>

</html>