<!DOCTYPE html>
<html lang="en">
    <?php
    $title = "Queue This Month";
    include 'include/head.php';
    include 'connectdatabase.php';
    include 'include/scripts.php';
    include 'include/scrolltop.php';
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".appo").click(function() {
                $("#appo_id").val($(this).data('id'));
                $("#pat_id").val($(this).data('patient-id'));
                $("#app_id").val($(this).data('a-id'));
                $("#pats_id").val($(this).data('p-id'));
            });
            $('#hideshow').on('click', function() {
                $('#clinics').show();
            });
            $('#showsec').on('click', function() {
                $('#secretary').show();
            });
            $(".walk").click(function() {
                $("#doc_id").val($(this).data('doc-id'));
                $("#cli_id").val($(this).data('cli-id'));
            });
        });
    </script>
    <?php
    session_start();
    $loggedIn = $_SESSION['loggedIn'];
    $account_type = $_SESSION['account_type'];
    if ($loggedIn == false)
        header("location: admin/index.php");
    else if ($account_type != 'Secretary')
        header("location: admin/index.php");

    $start = date("Y-m-1");
    $end = date("Y-m-t");
    $date = date("Y-m-d");
    $username = $_SESSION['username'];

    $result = mysqli_query($con, "SELECT * FROM secretary WHERE username LIKE '$username'") or die(mysqli_error());
    $row = mysqli_fetch_array($result);
    $secretary = $row['secretary_name'];
    $secretary_id = $row['secretary_id'];

    $email = $row['email'];
    $doctor_id = $row['doctor_id'];

    $doctor = mysqli_query($con, "SELECT * FROM doctor WHERE doctor_id LIKE '$doctor_id'") or die(mysqli_error());
    $doctor_row = mysqli_fetch_array($doctor);

    $c_result = mysqli_query($con, "SELECT * FROM clinic NATURAL JOIN clinic_sec WHERE secretary_id LIKE '$secretary_id'") or die(mysqli_error());
    $c_row = mysqli_fetch_array($c_result);
    $clinic_id = $c_row['clinic_id'];
    $a_result = mysqli_query($con, "SELECT * FROM appointment NATURAL JOIN queue_notif WHERE doctor_id = '$doctor_id' AND clinic_id = '$clinic_id' AND (appointment_status = 'inqueue' OR appointment_status = 'Referred') AND (appoint_date >= '$start' AND appoint_date <= '$end') ORDER BY 2 ASC, 8 ASC");
    $sqls = mysqli_query($con, "SELECT * FROM doctor WHERE doctor_id <> '$doctor_id' ORDER BY specialization") or die(mysqli_error());

    $count_result = mysqli_query($con, "SELECT COUNT(notification) AS count FROM notification WHERE doctor_id LIKE '$doctor_id' AND indicator = 'Patient'");
    $count_row = mysqli_fetch_array($count_result);
    $notif_count = $count_row['count'];
    ?>
    <body class="secretary-bg">
        <div class="container">        
            <?php
            include 'include/st-nav-start.php';
            ?>
            <ul class="nav navbar-nav">
                <li class="active dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-clock-o fa-lg"></i>Schedules <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="st-schedules.php">Today</a></li>
                        <li><a href="st-schedules_tom.php">Tomorrow</a></li>
                        <li><a href="st-schedules_week.php">This Week</a></li>
                        <li><a href="st-schedules_month.php">This Month</a></li>
                        <li><a href="st-schedules_next.php">Next Month</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-history fa-lg"></i>History<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="st-completed.php">Finished Appointments</a></li>
                        <li><a href="st-removed.php">Cancelled  Appointments</a></li>
                    </ul>
                </li>
                <?php
                include 'include/st-nav-end.php';
                ?>
                <div class="container-fluid" id="user-md-frw">
                    <div class="row">
                        <?php
                        include 'include/st-user-md.php';
                        include 'include/st-inqueue_served.php';
                        ?>
                    </div>
                </div>
                <div class="container-fluid" id="schedules-md">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="text-center row-header">&mdash; This Month &mdash;</h2>
                        </div>
                        <?php
                        include 'include/st-schedules-panel.php';
                        ?>
                    </div>
                </div>
                <?php
                include 'include/remarks-modal.php';
                include 'include/st-edit-profile-modal.php';
                include 'include/refer-modal.php';
                include 'include/add_to_queue.php';
                ?>
                <script type="text/javascript" src="js/search.js"></script>
                <script type="text/javascript" src="js/scrolltop.js"></script>
        </div>
    </body>
</html>