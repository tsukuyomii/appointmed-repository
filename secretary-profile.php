<!DOCTYPE html>
<html lang="en">
    <?php
        $title = "Secretary Profile";
        include 'include/head.php';
        include 'connectdatabase.php';
        include 'include/scripts.php';
        include 'include/scrolltop.php';
    ?>


    <?php 
        session_start();
        $loggedIn = $_SESSION['loggedIn'];
        $account_type = $_SESSION['account_type'];
        if($loggedIn == false)
            header("location: admin/index.php");
        else if($account_type != 'Secretary')
            header("location: admin/index.php");
        
        $username = $_SESSION['username'];
        $result = mysqli_query($con, "SELECT * FROM secretary WHERE username LIKE '$username'") or die(mysqli_error());
        $row = mysqli_fetch_array($result);
        $secretary = $row['secretary_name'];
        $secretary_id = $row['secretary_id'];

        $email = $row['email'];
        $doctor_id = $row['doctor_id'];

        $doctor = mysqli_query($con, "SELECT * FROM doctor WHERE doctor_id LIKE '$doctor_id'") or die(mysqli_error());
        $doctor_row = mysqli_fetch_array($doctor);
        
        $count_result = mysqli_query($con, "SELECT COUNT(notification) AS count FROM notification WHERE doctor_id LIKE '$doctor_id' AND indicator = 'Patient'");
        $count_row = mysqli_fetch_array($count_result);
        $notif_count = $count_row['count'];
    ?>
<body class="e4e8e9-bg">
    <div class="container">        
    <?php 
        include 'include/st-nav-start.php';
    ?>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Schedules <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="st-schedules.php">Today</a></li>
                            <li><a href="st-schedules_tom.php">Tomorrow</a></li>
                            <li><a href="st-schedules_week.php">This Week</a></li>
                            <li><a href="st-schedules_month.php">This Month</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">dropdown <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="completed.php">Completed</a></li>
                            <li><a href="removed.php">Removed</a></li>
                        </ul>
                    </li>
    <?php 
        include 'include/st-nav-end.php';
    ?>    
        <!-- /navigation -->
        <div class="container-fluid" id="doctor-info">
            <div class="row">
                <div class="col-xs-12 col-md-2 col-md-offset-3 d-pic">
                      <img class="img-responsive" src="img/profile/<?php 
                            $file = "img/profile/".$secretary_id.".jpg";
                            if(file_exists($file)){
                                echo $secretary_id;
                            }else{
                                echo 'profile';
                            } ?>.jpg">
                </div>
                <div class="col-xs-12 col-md-4 col-md-offset-1">
                    <div class="d-info">
                        <ul class="profile-info">
                            <li><i class="fa fa-user-md"></i><?php echo strtoupper($row['secretary_name']); ?></li>
                            <li><i class="fa fa-medkit"></i>Dr. <?php echo $doctor_row['doctor_name']; ?></li>
                            <br>
                            <li><i class="fa fa-h-square"></i>Benguet Laboratory Incorporated</li>
                            <li><i class="fa fa-angle-double-right"></i><?php echo $email; ?></li>
                        </ul>
                    </div>
                </div>          
            </div>

        </div>
        <div class="container-fluid">
            <div class="row">
                <?php 
                    $count = 0;
 /*                   while($c_row = mysqli_fetch_array($c_result)){
              
                        $count++;
                        echo '<div class="col-xs-12 col-md-3">';
                        echo '<div class="clinic-box dc-profile-sched-panel">';
                        echo '<h2>' . $c_row['clinic_name'] . '<span>' .$count. '</span></h2>';
                        echo '<p><i class="fa fa-location-arrow"></i>'. $c_row['clinic_location']. '</p>' ;
                        echo '<p><i class="fa fa-phone"></i>'. $c_row['clinic_contact'] .'</p>';
                                               echo '</div>';
                        echo '</div>';
                        $clinic = $c_row['clinic_id'];
                    }*/
                ?>
            </div>
        </div>
    <?php 
        include 'include/st-edit-profile-modal.php';
        include 'include/refer-modal.php';

    ?>
        <script type="text/javascript" src="js/scrolltop.js"></script>
    </div>
  </body>
</html>