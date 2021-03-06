<!DOCTYPE html>
<html lang="en">

    <?php
    $title = "Admin | Announcement List";
    include 'include/head.php';
    include '../connectdatabase.php';
    ?>

    <?php
    session_start();
    $loggedIn = $_SESSION['loggedIn'];
    $account_type = $_SESSION['account_type'];
    if ($loggedIn == false)
        header("location: index.php");
    else if ($account_type != 'Admin')
        header("location: index.php");

    $account_sql = mysqli_query($con, "SELECT * FROM account ");
    $announcement = mysqli_query($con, "SELECT * FROM announcement ORDER BY 4 asc");

    ?>

    <body class="e4e8e9-bg">
        <?php 
            include 'include/admin-nav.php';
        ?>
        <div class="container-fluid">
            <div class="row">
                <?php
                include 'include/sidebar-navigation.php';
                ?>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Announcement List </h1> 
                    <div class="input-group announcement-post">
                        <?php
                            while($announcement_row = mysqli_fetch_array($announcement)){
                                //$date =  date('M-d-Y', strtotime($announcement_row['start_publish']));
                                echo '<div class="col-xs-12 col-md-8 col-md-offset-2">
                                    <div class="panel panel-notif panel-danger">
                                        <div class="panel-heading">'.date('M-d-Y', strtotime($announcement_row['start_publish'])).' to '
                                        .date('M-d-Y', strtotime($announcement_row['end_publish'])).
                                        '<a href="announcement_detail.php?id='.$announcement_row['announcement_id'].'" title="Edit"><i class="fa fa-edit edit-btn"></i></a>
                                        </div>
                                        <div class="panel-body">
                                            <div class="post-body">
                                                <p>Subject: ' . $announcement_row['subject'] . '</p><p>' . $announcement_row['announcement_details'] . '</p>
                                                <p>Posted to:   ' . strtoupper($announcement_row['send_to']) . '</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include 'include/scripts.php';
        ?>
    </body>
</html>
