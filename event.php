<?php
include 'config.php';
include 'includes/header.php';

?>

<!-- Page Header Start -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>Upcoming Events</h2>
            </div>
            <div class="col-12">
                <a href="">Home</a>
                <a href="">Events</a>
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->



<!-- Event Start -->
<div class="event">
    <div class="container">
        <div class="section-header text-center">
            <p>Upcoming Events</p>
            <h2>Be ready for our upcoming charity events</h2>
        </div>
        <div class="row">
            <?php
// get two upcming events
$twoevents = $conn->query("SELECT * FROM gecodevents ORDER BY recordid DESC");

while ($eventssoon = mysqli_fetch_array($twoevents)) {
    $eventtitle = $eventssoon['eventTitle'];
    $eventcontent = $eventssoon['eventInfo'];
    $eventdate = $eventssoon['eventDate'];
    $eventtimestart = $eventssoon['eventTimeStart'];
    $eventtimeend = $eventssoon['eventTimeEnd'];
    $eventlocation = $eventssoon['eventLocation'];
    $eventtimage = $eventssoon['eventImageLogo'];

                echo '<div class="col-lg-6">
                <div class="event-item">
                    <img src="img/events/'.$eventtimage.'" alt="Image">
                    <div class="event-content">
                        <div class="event-meta">
                            <p><i class="fa fa-calendar-alt"></i>'.$eventdate.'</p>
                            <p><i class="far fa-clock"></i>'.$eventtimestart.' - '.$eventtimeend.'</p>
                            <p><i class="fa fa-map-marker-alt"></i>'.$eventlocation.' Uganda</p>
                        </div>
                        <div class="event-text">
                            <h3>'.$eventtitle.'</h3>
                            <p>
                            '.$eventcontent.'
                            </p>
                            <a class="btn btn-custom" href="#">Join Now</a>
                            <a class="btn btn-custom" href="">Donate</a>
                        </div>
                    </div>
                </div>
            </div>';
}


?>


        </div>
    </div>
</div>
<!-- Event End -->


<?php
include 'includes/footer.php';
        ?>