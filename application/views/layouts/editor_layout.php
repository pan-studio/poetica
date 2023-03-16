<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/elasticsearch/16.7.1/elasticsearch.min.js" integrity="sha512-uOHi3cdmRQ3IG8rOX4WwxQbhiHGvElsXZt0cy/2ttb3qE4N7YSb24qYVlB494GVzxJnmU2YC3b8WSJUjgqzEyg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <!-- Custom fonts for this template-->
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

            <!-- Heading -->
            <div class="sidebar-heading">
                Libri
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
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
                    <i class="fas fa-user"></i>
                    <span>Autori</span>
                </a>
                <div id="collapseAuthor" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestione autori</h6>
                        <a class="collapse-item" href="<?php echo base_url()?>index.php/admin/author_managment">Ricerca autori</a>
                        <a class="collapse-item"  href="<?php echo base_url()?>index.php/admin/author_managment/add">Carica autore</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBiblio"
                    aria-expanded="true" aria-controls="collapseBiblio">
                    <i class="fas fa-user"></i>
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

                    <!-- Topbar Search -->
                    <div style="width:100%;" 
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-12 my-2 my-md-0  navbar-search">
                        
                        <div class="input-group">
                            <input  type="text" id="free_keyword_author" name="free_keyword_author" class="form-control bg-light border-0 small search_book_field hidden" placeholder="Cerca per..."
                                aria-label="Filtro" style="display:none;" >
                            <input type="text" id="free_keyword_text" name="free_keyword_text" class="form-control bg-light border-0 small search_book_field hidden" placeholder="Cerca per..."
                                aria-label="Filtro" style="display:none;">
                            <input type="text" id="free_keyword_annotation" name="free_keyword_annotation" class="form-control bg-light border-0 small search_book_field hidden" placeholder="Cerca per..."
                                aria-label="Filtro" style="display:none;" >
                       <div class="form-check">
                       <select id="year_from" name="year_from" class="form-control border-0 small search_book_field hidden"
                       style="display:none;">
                       <option value="-1">Anno da </option>
                       <?php 
                                 foreach ($resultDateYear as $dateFrom) { 
                                 echo    '<option value="'.$dateFrom["year"].'">'.$dateFrom["year"].'</option>';
                                }?>
                      </select>
                      <select id="year_to" name="year_to" class="form-control border-0 small search_book_field hidden"
                      style="display:none;">
                      <option value="-1">Anno a </option>
                       <?php 
                                 foreach ($resultDateYear as $dateTo) { 
                                 echo    '<option value="'.$dateTo["year"].'">'.$dateTo["year"].'</option>';
                                }?>
                      </select>
                      <select id="century_from" name="century_from" class="form-control border-0 small search_book_field hidden"
                      style="display:none;">
                      <option value="-1">Secolo da </option>
                       <?php 
                                 foreach ($resultDateCentury as $centuryFrom) { 
                                 echo    '<option value="'.$centuryFrom["century"].'">'.$centuryFrom["century"].'</option>';
                                }?>
                      </select>
                      </select>
                      <select id="century_to" name="century_to" class="form-control border-0 small search_book_field hidden"
                      style="display:none;">
                      <option value="-1">Secolo a </option>
                       <?php 
                                 foreach ($resultDateCentury as $centuryTo) { 
                                 echo    '<option value="'.$centuryTo["century"].'">'.$centuryTo["century"].'</option>';
                                }?>
                      </select>
                      </select>

                       <select onchange="showSearchField(this, 'search_book_field')" id="searchfor" name="searchfor" class="form-control border-0 small">
                                <option value="-1">Seleziona filtro</option>
                                <option label_value="traduttore" value="free_keyword_author">Traduttore</option>
                                <option label_value="anno" value="year_from,year_to">Anno</option>
                                <option label_value="secolo"  value="century_from,century_to">Secolo</option>
                                <option label_value="nel testo" value="free_keyword_text">Nei testi</option>
                                <option label_value="nelle annotazioni" value="free_keyword_annotation">Nelle annotazioni</option>
                                
                            </select>
                             <!--   <input name="authorcheck" class="form-check-input" type="checkbox" id="authorcheck" >
                                <label class="form-check-label" for="authorcheck">
                                    Autore 
                                </label>
                                <input name="contentcheck" class="form-check-input" type="checkbox"  id="contentcheck" >
                                <label class="form-check-label" for="contentcheck">
                                    Parola 
                                </label>
                                <input name="yearcheck" class="form-check-input" type="checkbox" id="yearcheck" >
                                <label class="form-check-label" for="yearcheck">
                                    Anno
                                </label>
                                <input name="centurycheck" class="form-check-input"  type="checkbox" id="centurycheck" >
                                <label class="form-check-label" for="centurycheck">
                                    Secolo
                                </label>
                                 -->
                            </div>
                           
                            <select id="language" name="language" class="form-control border-0 small">
                                <option value="-1">Seleziona lingua (nessuna selezione per tutte)</option>
                                <?php 
                                
                                
                                foreach ($resultLanguages as $lang) { 
                                 echo    '<option label_value="'.$lang["language"].' ('.$lang["code"].')" value="'.$lang["id"].'">'.$lang["language"].' ('.$lang["code"].')</option>';
                                }?>
                               
                            </select>
                            
                             

                            <div class="input-group-append">
                            <div  class="btn btn-primary" onClick="addToFilter()" type="button">
                                    <i class="fas fa-plus fa-sm"></i>
                            </div>
                                <div  class="btn btn-primary" onClick="searchBook()" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                            </div>
                            </div>
                        </div>
                        
                    </div>
                    
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $this->session->userdata('user_info')['name']." ".$this->session->userdata('user_info')['surname'];?></span>
                                <img class="<?php echo base_url()?>assets/img-profile rounded-circle"
                                    src="<?php echo base_url()?>assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
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
                                <a class="dropdown-item" href="<?=base_url()?>index.php/login/logout" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <div id="filter_bar">
                    <?php echo form_open('/books/find_books', 'method="post" id="searchform"'); ?> 
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
strpos($url,'color_managment') == true) {
    echo '';
} else { ?> 
    <script src="<?php echo base_url()?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<?php } ?>

<script>

function searchBook(){
    var form = document.getElementById('searchform');
    form.submit();
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
