<?php
include 'config.php';
include 'includes/header.php';

?>

<div class="page-header-orphans">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Beneficiaries</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Orphans or Beneficiaries</a>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Page Header End -->


<!-- Blog Start -->
<div class="blog">
    <div class="container">
        <div class="section-header text-center">
            <p>Meet Beneficiaries</p>
            <h2>Here are the Vulnerable Children who need to be Supported to live a Quality life </h2>
        </div>
        <div class="row">



            <?php
                            // get all board members and display them 

                            $bodmembers = $conn->query("SELECT * FROM gecodorphans");
                            while ($rows = mysqli_fetch_array($bodmembers)) {
                                $ophanid = $rows['orphanid'];
                                $names = $rows['orphanNames'];
                                $info = $rows['orphanInfo'];
                                $img = $rows['orphanImage']; 

                                echo ' <div class="col-lg-4">
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <img src="img/beneficiaries/'.$img.'" alt="Image">
                                    </div>
                                    <div class="blog-text">
                                        <h3>Names: <span style="font-weight: 300; font-size:medium;">'.$names.'</span></h3>
                                        <h5 class="align-center" hidden>Birthday: <span style="font-weight: 300; font-size:medium;"> 26/07/2022</span>
                                        </h5>
                                        <h5 class="align-center">Location:  <span style="font-weight: 300; font-size:medium;">Uganda</span></h5>
                                        <p hidden>
                                          '.$info.'
                                        </p>
                                    </div>
                                    <div class="blog-meta" style="align-items: center;">
                                             <button type="submit" class="btn btn-custom"><a href="vieworphandetails.php?orphanid='.$ophanid.'">Choose Me</a></button>
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