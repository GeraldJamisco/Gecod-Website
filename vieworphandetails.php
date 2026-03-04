<?php
include 'config.php';
include 'includes/header.php';

if (isset($_GET['orphanid'])) {
    # code...
    $orphanid = $_GET['orphanid'];

// get information from the database and display it here in the page
$orphandetails = $conn->query("SELECT * FROM gecodorphans WHERE orphanid='$orphanid'");
$want = mysqli_num_rows($orphandetails);

$mydetails = $orphandetails->fetch_assoc();
?>

<div class="page-header-orphans">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Beneficiaries</h2>
            </div>
            <div class="col-12">
                <a href="#">Give one of the beneficiary a gift of schooling</a>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Page Header End -->
        <!-- Single Post Start-->
        <div class="single">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="single-content">
                            <img src="img/beneficiaries/<?php echo $mydetails['orphanImage']; ?>" />
                            <h2>About </b> <?php echo $mydetails['orphanNames']; ?></h2>
                            <p>
                            <?php echo $mydetails['orphanInfo']; ?>
                        </p>
                       
                        </div>
                    
                    </div>

                    <div class="col-md-6">
                        <div class="sidebar">
                            <div class="sidebar-widget">
                                <h2 class="widget-title">About Names</h2>
                                <div class="text-widget">
                                    <p>
                                        <br>
                                        <b>Names: </b> <?php echo $mydetails['orphanNames']; ?>
                                        <br>
                                        <b>Date of Birth: </b> <?php echo $mydetails['orphanBirthday']; ?>
                                        <br>
                                        <b>Gender:</b> <?php echo $mydetails['orphanGender']; ?>
                                        <br>
                                        <b> Location:</b> Lyantonde Uganda
                                        <br>
                                    Abisai is desirously waiting for a sponsor. needs your support of $38/month to have new opportunities to learn and grow physically, mentally and spiritually.                                    </p>
                                </div>
                            </div>
                            <button class="btn btn-success btn-lg" type="submit">Sponsor </b> <?php echo $mydetails['orphanNames']; ?></button>
                        </div>
                    </div>
                    <!-- all other kids waiting -->

                    <?php

                    ?>
                <div class="col-lg-12">
                    <div class="single-related">
                            <h2>Other Waiting Kids</h2>
                            <div class="owl-carousel related-slider">
                                <?php 
$orphandetailswaiting = $conn->query("SELECT * FROM gecodorphans");
                                    while ($rows = mysqli_fetch_array($orphandetailswaiting)) {
                                        $orphanNames = $rows['orphanNames'];
                                        $ophanImage = $rows['orphanImage'];
                                        $ophangender = $rows['orphanGender'];
                                        $ophanId = $rows['orphanid'];

                                        echo '<div class="post-item">
                                        <a href="vieworphandetails.php?orphanid='.$ophanId.'"> 
                                        <div class="post-img">
                                            <img src="img/beneficiaries/'.$ophanImage.'" />
                                        </div>
                                        <div class="post-text">
                                            <a href="">'.$orphanNames.'</a>
                                            <div class="post-meta">
                                                <p><a href="#">'.$ophangender.'</a></p>
                                                <p>Uganda, <a href="#">Lyantonde</a></p>
                                            </div>
                                        </div>
                                        </a>
                                    </div>';
                                    }
                                ?>
                               
                               
                               
                               
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Single Post End-->   




        <?php
        }else {
            echo "<script type='text/javascript'> window.location.href='Orphans.php'</script>";

        }

include 'includes/footer.php';

?>