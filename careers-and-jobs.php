<?php
include 'config.php';
include 'includes/header.php';

?>        
        <!-- Page Header Start -->
        <div class="jobs_publications">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Careers and Jobs</h2>
                    </div>
                    <div class="col-12">
                        <a href="">Home</a>
                        <a href="">About Us</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->

        
        
<!-- Blog Start -->
<div class="blog">
            <div class="container">
                <div class="section-header text-center">
                    <p>Our jobs and Careers for you</p>
                    <h2>Latest news & jobs directly from our website</h2>
                </div>
                <div class="row">
                    
<?php
// here we are fetching all jobs from the database and diplay them here so that we view them.

$jobfirstview = $conn->query("SELECT * FROM jobcareer ORDER BY uploadDate DESC");
$num = mysqli_num_rows($jobfirstview);

while ($rows = mysqli_fetch_array($jobfirstview)) {
    $jobTitle = $rows['job_title'];
    $jobDescript = $rows['JobDescription'];
    $jobBanner = $rows['imgBanner'];
    $jobRecordId = $rows['recordid'];

    echo ' <div class="col-lg-4">
    <div class="blog-item">
        <div class="blog-img">
            <img src="img/job_banner_images/'.$jobBanner.'" alt="Image">
        </div>
        <div class="blog-text">
            <h3><a href="viewjob.php?jobid='.$jobRecordId.'">'.$jobTitle.'</a></h3>
            <p>'.$jobDescript.'</p>
        </div>
        
    </div>
</div>';
}

?>
                   
                   
                    
                   
                   
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul> 
                    </div>
                </div> -->
            </div>
        </div>
        <!-- job Blog End -->

















        
        <?php
include 'includes/footer.php';
        ?>


<a href="http://" target="_blank" rel="noopener noreferrer"></a>