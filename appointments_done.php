<!DOCTYPE html>
<html lang="en">
    <?php
    $title = "Finished";
    include 'include/head.php';
    include 'connectdatabase.php';
    include 'include/scripts.php';
    //include 'include/scrolltop.php';
    ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".appo").click(function() {
                $("#appo_id").val($(this).data('id'));
                $("#doc_id").val($(this).data('doctor-id'));
            });
        });
    </script>
    <body>
        <div class="container">
            <?php
            session_start();
            if (isset($_SESSION['loggedIn']) && isset($_SESSION['account_type']) && isset($_SESSION['username'])) {
                $loggedIn = $_SESSION['loggedIn'];
                $account_type = $_SESSION['account_type'];
                $username = $_SESSION['username'];

                if ($loggedIn == false)
                    header("location: index.php");
                else if ($account_type != 'Patient')
                    header("location: index.php");
            }else {
                header("location: index.php");
                die();
            }
            $result = mysqli_query($con, "SELECT * FROM patient WHERE username LIKE '$username'");
            $row = mysqli_fetch_array($result);
            $patient_id = $row['patient_id'];
            $patient_n = $row['patient_name'];
            $date_today = date('Y-m-d');
     
            $count_result = mysqli_query($con, "SELECT COUNT(notification) AS count FROM notification WHERE patient_id LIKE '$patient_id' AND (indicator = 'doctor' OR indicator = 'admin')");
            $count_row = mysqli_fetch_array($count_result);
            $count_announcement = mysqli_query($con, "SELECT * FROM announcement WHERE start_publish <= '$date_today' AND end_publish >= '$date_today' AND (send_to = 'all' OR send_to = 'patient')");
            $notif_count = $count_row['count'];
            $announcement_count = mysqli_num_rows($count_announcement);
            $notif_count2 = $notif_count + $announcement_count;

            ?>
            <!-- navigation -->
            <?php
            include 'include/pt-nav-start.php';
            ?>
            <ul class="nav navbar-nav">
                <li class="dropdown tooltip-bottom" data-tooltip="Appointments">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-calendar fa-lg"></i>Appointments<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="appointment.php">Today</a></li>
                        <li><a href="appointment_tom.php">Tomorrow</a></li>
                        <li><a href="appointment_week.php">This Week</a></li>
                        <li><a href="appointment_month.php">This Month</a></li>
                        <li><a href="appointment_next.php">Next Month</a></li>
                    </ul>
                </li>
                <li class="tooltip-bottom" data-tooltip="Notifications">
                    <a href="notifications.php">
                        <i class="fa fa-bell fa-lg">
                            <?php
                            if ($notif_count2 == 0)
                                echo '<span class="badge hide">' . $notif_count2 . '</span>';
                            else
                                echo '<span class="badge">' . $notif_count2 . '</span>';
                            ?>
                        </i>Notifications
                    </a>
                </li>
                <li class="dropdown active tooltip-bottom" data-tooltip="History">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-history fa-lg"></i>History<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="appointments_done.php">Finished Appointments</a></li>
                        <li><a href="cancelled_appointments.php">Cancelled Appointments</a></li>
                    </ul>
                </li>
                <?php
                include 'include/pt-nav-end.php';
                ?>     
                <div class="container-fluid" id="appointments-user">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="text-center row-header-fff">&mdash; Finished Appointments &mdash;</h1>
                        </div>
                        <?php
                        $a_result = mysqli_query($con, "SELECT * FROM appointment WHERE patient_id LIKE '$patient_id' AND appointment_status = 'Completed' ORDER BY 5 DESC LIMIT 8") or die(mysqli_error());
                        if(mysqli_num_rows($a_result)>=1){
                            while ($d_row = mysqli_fetch_array($a_result)) {
                                $app_id = $d_row['appointment_id'];
                                $doctor = $d_row['doctor_id'];
                                $date = date("F j , Y",strtotime($d_row['appoint_date']));

                                $d_result = mysqli_query($con, "SELECT * FROM doctor WHERE doctor_id LIKE '$doctor'");
                                $doc = mysqli_fetch_array($d_result);
                                echo '<div class="col-xs-12 col-md-6 col-lg-3" id="' . $d_row['appointment_id'] . '">';
                                echo "<div class='panel panel-default' id='asd'><div class='panel-heading appointment-date' >";
                                echo $date;
                                echo '</div><div class="panel-body">';
                                echo '<p class="appointment-header">Dr. ' . $doc['doctor_name'] . '</p>';
                                echo '</div><div class="appmnt-pnl-btns">';
                                echo '<p class="appointment-specs">' . $doc['specialization'] . '</p></div></div>';
                                echo '</div>';
                            }
                        }else{
                            echo '<div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="alert alert-warning" role="alert">
                            <strong>You currently have no finished appointments.</strong></div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
                <?php
                include 'include/scrolltop.php';
                include 'include/edit-profile-modal.php';
                ?>  
                <script type="text/javascript" src="js/search.js"></script>
                <script type="text/javascript" src="js/scrolltop.js"></script>
        </div> <!-- /container -->
    </body>
</html>