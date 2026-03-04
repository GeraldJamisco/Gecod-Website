<?php
include 'config.php';
if (isset($_GET['jobid'])) {
    $this_jobid = $conn->real_escape_string($_GET['jobid']);
    $this_student_profile_dtls = $conn->query("SELECT * FROM jobcareer WHERE recordid = '$this_jobid'");
    if (mysqli_num_rows($this_student_profile_dtls) == 0) {
        echo '
        <div style="margin: 10px; text-align:center;">
            <p style="background-color: #f1a804; padding:5px 7px; border-radius: 4px;"><i class="ri-alert-fill" style="margin-right: 5px;"></i> the job your looking for couldn\'t be found</p>
    </div>';
    }
    else {
     
include 'includes/header.php';
$thisjobdetails = $this_student_profile_dtls->fetch_assoc();
  

?>        
        <!-- Page Header Start -->
        <div class="publications_research">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Careers and Opportunities</h2>
                    </div>
                    <div class="col-12">
                             <a href=""><?php echo $thisjobdetails['job_title']; ?></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->


        <div class="single">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="single-content">
                            <img src="img/job_banner_images/<?php echo $thisjobdetails['imgBanner']; ?>" />
                         <h2>position Title</p><span style="font-weight: 200; font-size:28px;"><p><?php echo $thisjobdetails['job_title']; ?></span></h2>
                         <h2>Organisation Description</h2>
                         <p>Go Empower Communities for Development Initiative (GECOD INITIATIVE) is a youth, women and young people led Non-profit Community Based Organization founded in 2018 aiming at empowering the vulnerable communities and vulnerable groups of people to amplify their voices, build their capacity, empower them socio-economically and support them to achieve their goals, support each other and transform communities, live quality life, attain quality education and good health.</p>
                        <b>Position :</b><?php echo $thisjobdetails['position']; ?></p>
                        <b>location :</b><?php echo $thisjobdetails['location']; ?></p>

                        <h2>Job Description</h2>
                            <p>
                            <?php echo $thisjobdetails['JobDescription']; ?>
                               </p>

                               <b>Qualifications :</b> <p>  <?php echo $thisjobdetails['qualifications']; ?></p>
                               <b>Experience :</b> <p> <?php echo $thisjobdetails['experience']; ?> </p>
                               <b>how to Apply and where to send CV:</b> <p> <?php echo $thisjobdetails['contacts']; ?> </p>
                               <b>Deadline :</b> <p> <?php echo $thisjobdetails['deadlineDate']; ?> </p>
                        </div>
                       
                    </div>

                    <div class="col-lg-4">
                        <div class="sidebar">
                            <div class="sidebar-widget">
                                <h2 class="widget-title">Text Widget</h2>
                                <div class="text-widget">
                                    <b>Hiring Organisation</b> <p>GECOD INITIATIVE UGANDA</p>
                                    <b>Hiring Type</b> <p>  <?php echo $thisjobdetails['hiringType']; ?></p>
                                    <b>Job Location</b> <p><?php echo $thisjobdetails['location']; ?> UGANDA</p>
                                    <b>Working Hours</b> <p> <?php echo $thisjobdetails['workingHours']; ?> 8:00am - 5:00pm</p>
                                    <b>Date Posted</b> <p> <?php echo $thisjobdetails['uploadDate']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Single Post End-->   




























        
        <?php
        include 'includes/footer.php';
}
  }

        ?>


<a href="http://" target="_blank" rel="noopener noreferrer"></a>