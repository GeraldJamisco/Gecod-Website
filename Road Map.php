<?php
include 'config.php';
include 'includes/header.php';

?>

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Popular Causes</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Causes</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Service Start -->
<div class="service">
    <div class="container">
        <div class="section-header text-center">
            <p>What We Do?</p>
            <h2>We believe that we can save more lives with you</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-diet"></i>
                    </div>
                    <div class="service-text">
                        <h3>Healthy Food</h3>
                        <p>From Donations from the local people we move to homes that really have no access to food in
                            slums of Lyantonde and floody areas</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-water"></i>
                    </div>
                    <div class="service-text">
                        <h3>Pure Water</h3>
                        <p>As water is the source of life we provide pure waters to people who have no access to it and
                            teach them how to get it, with a fresh and safe places</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-healthcare"></i>
                    </div>
                    <div class="service-text">
                        <h3>Health Care</h3>
                        <p>With the little funds from the local Area people we have managed to offer primary health care
                            support to local people who suffer from Malaria, fevers, and first Aid problems</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-education"></i>
                    </div>
                    <div class="service-text">
                        <h3>Primary Education</h3>
                        <p>Supporting and creating a few seminars for iliterates who haven't had any access to schools
                            is one of the little things we can do to the community</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-home"></i>
                    </div>
                    <div class="service-text">
                        <h3>Residence Facilities</h3>
                        <p>Afew homes from the charity givers, have been reserved for those that have lost their homes
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <i class="flaticon-social-care"></i>
                    </div>
                    <div class="service-text">
                        <h3>Social Care</h3>
                        <p>With a little help from other non government organisations, we have tried socialisng and
                            comforting depresing fellows</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service End -->


<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p>Popular Causes</p>
            <h2>Let's know about charity causes around the world</h2>
        </div>
        <div class="row">

        <?php
                    // gett the road map images and there abouts
                    $roadmap = $conn->query("SELECT * FROM gecodroadmap ORDER BY uploadDate DESC");

                    while ($rows = mysqli_fetch_array($roadmap)) {
                        $title = $rows['Title'];
                        $content = $rows['content'];
                        $img = $rows['image'];

                        echo '<div class="col-lg-4">
                        <div class="blog-item">
                            <div class="blog-img">
                                <img src="img/'.$img.'" alt="Image">
                            </div>
                            <div class="blog-text">
                                <h3>'.$title.'</h3>
                                <p>'.$content.'
                                </p>
                            </div>
                        </div>
                    </div>';
                    }
                    ?>
            
            
        </div>
    </div>
</div>










<?php
include 'includes/footer.php';
        ?>