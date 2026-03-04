<?php
// include 'config.php';
include 'sessionizr.php';
include 'includes/header.php';
include 'includes/sidebar.php' ;

?>
    
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="container-fluid mt-3">
                <div class="row">
                    <!-- team members card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-1">
                            <a href="Members.php">
                                <div class="card-body">
                                    <h3 class="card-title text-white">Team Members Update</h3>
                                    <div class="d-inline-block">
                                        <h2 class="text-white">8541</h2>
                                    </div>
                                    <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                     <!-- team members card end -->
                      <!-- Gecod Orphans card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-2">
                           <a href="benefeciaries.php">
                             <div class="card-body">
                            <h3 class="card-title text-white">Gecod Beneficiaries </h3>
                            <div class="d-inline-block">
                                <h2 class="text-white">8541</h2>
                            </div>
                            <span class="float-right display-5 opacity-5"><i class="fa fa-money"></i></span>
                        </div>
                    </a>
                        </div>
                    </div>
                     <!-- Gecod Orphans card end -->
                     <!-- Gecod road map card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-3">
                           <a href="roadMap.php">
                            <div class="card-body">
                                <h3 class="card-title text-white">Our Road Map</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">4565</h2>
                                    <p class="text-white mb-0">Jan - March 2019</p>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-users"></i></span>
                            </div>
                           </a>
                        </div>
                    </div>
                    <!-- Gecod road map card end -->
                    <!-- Gecod events card start -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="card gradient-4">
                           <a href="gecodevents.php">
                            <div class="card-body">
                                <h3 class="card-title text-white">Events </h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white">99%</h2>
                                </div>
                                <span class="float-right display-5 opacity-5"><i class="fa fa-heart"></i></span>
                            </div>
                           </a>
                        </div>
                    </div>
                    <!-- Gecod events card end -->
                </div>


              
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="../img/CEOGecod - Copy.png" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">Gordan Sabiiti</h5>
                                    <p class="m-0">Founder & CEO</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="../img/Nakacwa Leila - Copy.jpeg" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">Nakacwa Leila</h5>
                                    <p class="m-0">DEPUTY ED</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="./images/users/7.jpg" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">Dr. Mujibu Nkambo</h5>
                                    <p class="m-0">BOARD SECRETARY</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <a href="Members.php">
                            <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="./images/users/1.jpg" class="rounded-circle" alt="">
                                    <h5 class="mt-3 mb-1">View All Board </h5>
                                    <p class="m-0">Members</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>

                </div>

                <!-- <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="active-member">
                                    <div class="table-responsive">
                                        <table class="table table-xs mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Benef. ID</th>
                                                    <th>Benef. Names</th>
                                                    <th>Parent Names</th>
                                                    <th>Parent Contacts</th>
                                                    <th>Benef Image</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><img src="./images/avatar/1.jpg" class=" rounded-circle mr-3" alt="">Sarah Smith</td>
                                                    <td>iPhone X</td>
                                                    <td>
                                                        <span>United States</span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-success" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <span>Last Login</span>
                                                        <span class="m-0 pl-3">10 sec ago</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="./images/avatar/2.jpg" class=" rounded-circle mr-3" alt="">Walter R.</td>
                                                    <td>Pixel 2</td>
                                                    <td><span>Canada</span></td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-success" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <span>Last Login</span>
                                                        <span class="m-0 pl-3">50 sec ago</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="./images/avatar/3.jpg" class=" rounded-circle mr-3" alt="">Andrew D.</td>
                                                    <td>OnePlus</td>
                                                    <td><span>Germany</span></td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <span>Last Login</span>
                                                        <span class="m-0 pl-3">10 sec ago</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="./images/avatar/6.jpg" class=" rounded-circle mr-3" alt=""> Megan S.</td>
                                                    <td>Galaxy</td>
                                                    <td><span>Japan</span></td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-success" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <span>Last Login</span>
                                                        <span class="m-0 pl-3">10 sec ago</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="./images/avatar/4.jpg" class=" rounded-circle mr-3" alt=""> Doris R.</td>
                                                    <td>Moto Z2</td>
                                                    <td><span>England</span></td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-success" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <span>Last Login</span>
                                                        <span class="m-0 pl-3">10 sec ago</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><img src="./images/avatar/5.jpg" class=" rounded-circle mr-3" alt="">Elizabeth W.</td>
                                                    <td>Notebook Asus</td>
                                                    <td><span>China</span></td>
                                                    <td>
                                                        <div>
                                                            <div class="progress" style="height: 6px">
                                                                <div class="progress-bar bg-warning" style="width: 50%"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td>
                                                        <span>Last Login</span>
                                                        <span class="m-0 pl-3">10 sec ago</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div> -->

                

            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
       <?php
include 'includes/footer.php';
       ?>