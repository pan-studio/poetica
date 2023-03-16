<html lang="en">
<?php ini_set('display_errors', 1); ?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>
   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/elasticsearch/16.7.1/elasticsearch.min.js" integrity="sha512-uOHi3cdmRQ3IG8rOX4WwxQbhiHGvElsXZt0cy/2ttb3qE4N7YSb24qYVlB494GVzxJnmU2YC3b8WSJUjgqzEyg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    Custom fonts for this template-->
    <script src="<?php echo base_url()?>assets/js/elasticsearch.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <link href="<?php echo base_url()?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url()?>assets/css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/tipped.css">
    <script src="<?php echo base_url()?>assets/js/utility.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Poetica <sup>1.0</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard (demo data)</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Ricerca
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="/poetica/index.php/ricerca?showSearchNavBar=false" >
                    <i class="fa fa-search"></i>
                    <span>Ricerca avanzata</span>
                </a>
                
            </li>
            <!-- Heading -->
            <div class="sidebar-heading">
                Libri
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa fa-book"></i>
                    <span>Gestione libri</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Carica libri:</h6>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/book_managment">Carica da file</a>
                        <a class="collapse-item" href="#">Inserisci manualmente</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAuthor"
                    aria-expanded="true" aria-controls="collapseAuthor">
                    <i class="fa fa-pen"></i>
                    <span>Traduttori</span>
                </a>
                <div id="collapseAuthor" class="collapse" aria-labelledby="headingColors"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestione traduttori</h6>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/author_managment">Ricerca traduttore</a>
                        <a class="collapse-item"  href="<?php echo base_url()?>index.php/admin/author_managment/add">Carica traduttore</a>
                        <a class="collapse-item"  href="<?php echo base_url()?>index.php/admin/multi_upload">Caricamento multiplo</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBiblio"
                    aria-expanded="true" aria-controls="collapseBiblio">
                    <i class="fa fa-clipboard"></i>
                    <span>Bibliografia</span>
                </a>
                <div id="collapseBiblio" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestione bibliografia</h6>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/biblio_managment">Lista bibliografia</a>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/biblio_managment/add">Carica bibliografia</a>
                    </div>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLanguage"
                    aria-expanded="true" aria-controls="collapseLanguage">
                    <i class="fa fa-flag"></i>
                    <span>Lingue</span>
                </a>
                <div id="collapseLanguage" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestione Lingue</h6>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/language_admin">Lista Lingue</a>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/language_admin/add">Aggiungi Lingua</a>
                    </div>
                </div>
            </li>
            <div class="sidebar-heading">
                Utenti
            </div>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-user"></i>
                    <span>Utenti</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestione utenti</h6>
                        <a class="collapse-item"  href="<?php echo base_url()?>index.php/admin/user_managment">Ricerca utenti</a>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/user_managment/add">Inserisci utente</a>
                    </div>
                </div>
            </li>
            <div class="sidebar-heading">
                Colori e tags
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseColors"
                    aria-expanded="true" aria-controls="collapseColors">
                    <i class="fa fa-eye-dropper"></i>
                    <span>Colori</span>
                </a>
                <div id="collapseColors" class="collapse" aria-labelledby="headingColors"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestione colori</h6>
                        <a class="collapse-item"  href="<?php echo base_url()?>index.php/admin/color_managment">Gestisci colori</a>
                    </div>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTags"
                    aria-expanded="true" aria-controls="collapseTags">
                    <i class="fa fa-tag"></i>
                    <span>Tags</span>
                </a>
                <div id="collapseTags" class="collapse" aria-labelledby="headingTags"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestione colori</h6>
                        <a class="collapse-item"  href="<?php echo base_url()?>index.php/admin/tag_menagment">Gestisci tag</a>
                    </div>
                </div>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="<?php echo base_url()?>assets/img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>Progetto di ricerca</strong> A cura dell' università di Trento, facoltà di XXYYZZ!</p>
                <a class="btn btn-success btn-sm" href="https://unitn.it">Vai all' università!</a>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            
           
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <?php if(!isset($_GET['showSearchNavBar'])){ ?>

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <?php 
                       
                        $resultLanguages = [];

                           $queryLanguages = $this->db->query("select * from languages");  
                           
                           $resultLanguages = $queryLanguages->result_array(); 
                   
                           $resultDateYear = [];
                   
                           $queryDateYear = $this->db->query("select distinct book.year  from book");  
                           
                           $resultDateYear = $queryDateYear->result_array();

                           $resultDateCentury = [];
                   
                           $queryDateCentury = $this->db->query("select distinct (( book.year div 100 )  + 1) as century from  book  ");  
                           
                           $resultDateCentury = $queryDateCentury->result_array();

                  
                           
                           ?>








                    <?php  $this->template->load('search_bar_layout', 'contents' , 'layouts/search_page', []);?>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?php echo base_url()?>assets/img/undraw_profile_1.svg"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?php echo base_url()?>assets/img/undraw_profile_2.svg"
                                            alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="<?php echo base_url()?>assets/img/undraw_profile_3.svg"
                                            alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="<?php echo base_url()?>assets/img-profile rounded-circle"
                                    src="<?php echo base_url()?>assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="user_menu_name"><?php echo $this->session->userdata('user_info')['name']." ".$this->session->userdata('user_info')['surname'];?>
                            </div><a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profilo
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Impostazioni
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                     Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=base_url()?>index.php/login/logout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>
                <?php }?>
                </nav>
                <div id="filter_bar">
                    <?php echo form_open(base_url().'index.php/books/find_books', 'method="post" id="searchform"'); ?> 
                    <?php echo form_close();?>
                </div>
                <div class="container-fluid annotator_content" id="annotator_content">
                
                
                <?php echo $contents; ?>

                                
                <!-- PAGE CONTENT ENDS -->
</div>
    </div>
    <!-- PAGE CONTENT START -->


</div>
  

<a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Scheda Informativa</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div id="scheda_informativa_body" class="modal-body">
                    
                 </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>


    <div  class="modal fade" id="groceryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div  style="max-width:80%;" class="modal-dialog" role="document">
            <div   class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="groceryModalTitle"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div style="height:70vh;" id="groceryModalBody" class="modal-body">
                    
                
                 </div>
                <div style="display:none;" id="groceryModalSelectedElement">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" onclick="saveGroceryData()" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</body>
<div class="footer">


<div class="footer-inner">


<div class="footer-content">
<span class="bigger-120">
Copyright © università degli studi di Trento - Andrea Panetta All rights reserved.
</span>
</div>


</div>


</div>

<?php
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];


if (strpos($url,'book_managment') == true ||
strpos($url,'user_managment') == true ||
strpos($url,'biblio_managment') == true  ||
strpos($url,'author_managment') == true  ||
strpos($url,'color_managment') == true  ||
strpos($url,'tag_menagment') == true  ||
strpos($url,'multi_upload') == true) 

{
    echo '';
} else { ?> 
    <script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<?php } ?>

<script>

function searchBook(){
    var form = document.getElementById('searchform');
    
    
    if(form.elements.length <=0){
        alert('non puoi cercare nulla senza filtri');
    } else {
       form.submit();
       /*form = $("#searchform");
        var url = form.attr('action');
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {
                      
                    // Ajax call completed successfully
                    alert("Form Submited Successfully");
                },
                error: function(data) {
                      
                    // Some error in ajax call
                    alert("some Error");
                }
            });*/
    
    }
}

</script>

<link rel="stylesheet" href="<?php echo base_url()?>assets/css/annotator.min.css">

   
    <script src="<?php echo base_url()?>assets/vendor/annotator.js"></script>
   
   
   
   
   <!-- <script src="<?php echo base_url()?>assets/vendor/annotatordev.js"></script> -->

    <!-- Bootstrap core JavaScript-->
     <script src="<?php echo base_url()?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
 
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url()?>assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?php echo base_url()?>assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts 
    <script src="<?php echo base_url()?>assets/js/demo/chart-area-demo.js"></script>
    <script src="<?php echo base_url()?>assets/js/demo/chart-pie-demo.js"></script>
    

-->
<script src="<?php echo base_url()?>assets/js/elasticclient.js"></script>


<link href="<?php echo base_url()?>assets/css/custom.css" rel="stylesheet">
 
     <script src="<?php echo base_url()?>assets/js/tipped.js"></script>
<!-- /.main-container -->

<script src="<?php echo base_url()?>assets/js/annotatorutil.js"></script>

<script type="text/javascript" src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="<?=site_url()?>/../assets/vendor/datatables/jquery.dataTables.min.js"></script>

    <script src="<?=site_url()?>/../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
