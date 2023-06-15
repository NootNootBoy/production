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
                        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Clients</h4>
                        <div class="card">
                            <h5 class="card-header">Listes des clients : </h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Societé</th>
                                            <th>Gerant</th>
                                            <th>Telephone</th>
                                            <th>Vendeur</th>
                                            <th>Fin du contrat</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        <?php
                                           $stmt = $pdo->query('SELECT * FROM clients');
                                           while ($client = $stmt->fetch()) {
                                               include 'components/client_row.php';
                                           }
                                            ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Modal to add new record -->
                        <!--  Edit User -->
                        <div class="col-12 col-sm-6 col-lg-4 mb-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="mb-3 bx bx-md bx-user"></i>
                                    <h5>Edit User</h5>
                                    <p>Easily update the user data on the go, built in form validation and custom
                                        controls.</p>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editUser">
                                        Show
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!--/  Edit User -->


                        <!--/ DataTable with Buttons -->
                        <hr class="my-5" />
                        <!-- / Content -->
                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-simple modal-edit-user">
                                <div class="modal-content p-3 p-md-5">
                                    <div class="modal-body">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="text-center mb-4">
                                            <h3>Edit User Information</h3>
                                            <p>Updating user details will receive a privacy audit.</p>
                                        </div>
                                        <form id="editUserForm" class="row g-3" onsubmit="return false">
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditUserFirstName">First
                                                    Name</label>
                                                <input type="text" id="modalEditUserFirstName"
                                                    name="modalEditUserFirstName" class="form-control"
                                                    placeholder="John" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditUserLastName">Last Name</label>
                                                <input type="text" id="modalEditUserLastName"
                                                    name="modalEditUserLastName" class="form-control"
                                                    placeholder="Doe" />
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label" for="modalEditUserName">Username</label>
                                                <input type="text" id="modalEditUserName" name="modalEditUserName"
                                                    class="form-control" placeholder="john.doe.007" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditUserEmail">Email</label>
                                                <input type="text" id="modalEditUserEmail" name="modalEditUserEmail"
                                                    class="form-control" placeholder="example@domain.com" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditUserStatus">Status</label>
                                                <select id="modalEditUserStatus" name="modalEditUserStatus"
                                                    class="form-select" aria-label="Default select example">
                                                    <option selected>Status</option>
                                                    <option value="1">Active</option>
                                                    <option value="2">Inactive</option>
                                                    <option value="3">Suspended</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditTaxID">Tax ID</label>
                                                <input type="text" id="modalEditTaxID" name="modalEditTaxID"
                                                    class="form-control modal-edit-tax-id" placeholder="123 456 7890" />
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditUserPhone">Phone Number</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text">+1</span>
                                                    <input type="text" id="modalEditUserPhone" name="modalEditUserPhone"
                                                        class="form-control phone-number-mask"
                                                        placeholder="202 555 0111" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditUserLanguage">Language</label>
                                                <select id="modalEditUserLanguage" name="modalEditUserLanguage"
                                                    class="select2 form-select" multiple>
                                                    <option value="">Select</option>
                                                    <option value="english" selected>English</option>
                                                    <option value="spanish">Spanish</option>
                                                    <option value="french">French</option>
                                                    <option value="german">German</option>
                                                    <option value="dutch">Dutch</option>
                                                    <option value="hebrew">Hebrew</option>
                                                    <option value="sanskrit">Sanskrit</option>
                                                    <option value="hindi">Hindi</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="form-label" for="modalEditUserCountry">Country</label>
                                                <select id="modalEditUserCountry" name="modalEditUserCountry"
                                                    class="select2 form-select" data-allow-clear="true">
                                                    <option value="">Select</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="China">China</option>
                                                    <option value="France">France</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Korea">Korea, Republic of</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Russia">Russian Federation</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="switch">
                                                    <input type="checkbox" class="switch-input" />
                                                    <span class="switch-toggle-slider">
                                                        <span class="switch-on"></span>
                                                        <span class="switch-off"></span>
                                                    </span>
                                                    <span class="switch-label">Use as a billing address?</span>
                                                </label>
                                            </div>
                                            <div class="col-12 text-center">
                                                <button type="submit"
                                                    class="btn btn-primary me-sm-3 me-1">Submit</button>
                                                <button type="reset" class="btn btn-label-secondary"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Edit User Modal -->
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