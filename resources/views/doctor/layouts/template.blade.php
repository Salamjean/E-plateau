
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="shortcut icon" href="{{asset('assets/assets/img/logo pla.jpeg')}}" />
  <title>Doctor - Dashboard</title>
  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="{{asset("assetsHopital/vendors/iconic-fonts/font-awesome/css/all.min.css")}}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset("assetsHopital/vendors/iconic-fonts/flat-icons/flaticon.css") }}">
  <link rel="stylesheet" href="{{ asset("assetsHopital/vendors/iconic-fonts/cryptocoins/cryptocoins.css") }}">
  <link rel="stylesheet" href="{{ asset("assetsHopital/vendors/iconic-fonts/cryptocoins/cryptocoins-colors.css") }}">
  <!-- Bootstrap core CSS -->
  <link href="{{ asset("assetsHopital/assets/css/bootstrap.min.css") }}" rel="stylesheet">
  <!-- jQuery UI -->
  <link href="{{ asset("assetsHopital/assets/css/jquery-ui.min.css") }}" rel="stylesheet">
  <!-- Page Specific CSS (Slick Slider.css) -->
  <link href="{{ asset("assetsHopital/assets/css/slick.css") }}" rel="stylesheet">
  <!-- medjestic styles -->
  <link href="{{ asset("assetsHopital/assets/css/style.css") }}" rel="stylesheet">
  <!-- Page Specific CSS (Morris Charts.css) -->
  <link href="{{ asset("assetsHopital/assets/css/morris.css") }}" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/png" sizes="32x32" href="favicon.ico">
</head>

<body class="ms-body ms-aside-left-open ms-primary-theme ms-has-quickbar">
  <!-- Setting Panel -->
  <div class="ms-toggler ms-settings-toggle ms-d-block-lg">
    <i class="flaticon-gear"></i>
  </div>
  <div class="ms-settings-panel ms-d-block-lg" >
    <div class="row" >
      <div class="col-xl-4 col-md-4">
        <h4 class="section-title">Customize</h4>
        <div>
          <label class="ms-switch">
            <input type="checkbox" id="dark-mode">
            <span class="ms-switch-slider round"></span>
          </label>
          <span> Dark Mode </span>
        </div>

      </div>
      <div class="col-xl-4 col-md-4">
        
      </div>
    </div>
  </div>
  <!-- Overlays -->
  <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
  <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>
  <!-- Sidebar Navigation Left -->
  @include('doctor.layouts.sidebar')
    <!-- Navigation Bar -->
    @include('doctor.layouts.topbar')
    <!-- Body Content Wrapper -->
    @yield('content')
  </main>
  <!-- MODALS -->
  <!-- Modal -->
  <div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ms-modal-dialog-width">
      <div class="modal-content ms-modal-content-width">
        <div class="modal-header  ms-modal-header-radius-0">
          <h4 class="modal-title text-white">Make An Appointment</h4>
          <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">x</button>

        </div>
        <div class="modal-body p-0 text-left">
          <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-panel-bshadow-none">
              <div class="ms-panel-header">
                <h6>Patient Information</h6>
              </div>
              <div class="ms-panel-body">
                <form class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom01">Patient Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Enter Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom02">Date Of Birth</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom02" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom03">Disease</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom03" placeholder="Disease" required>

                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-4 mb-2">
                      <label for="validationCustom04">Address</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom04" placeholder="Add Address" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom05">Phone no.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom05" placeholder="Enter Phone No." required>

                      </div>

                    </div>

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom06">Department Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom06" placeholder="Enter Department Name" required>

                      </div>
                    </div>
                  </div>



                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom07">Appointment With</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom07" placeholder="Enter Doctor Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom08">Appointment Date</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom08" placeholder="Enter Appointment Date" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label>Sex</label>
                      <ul class="ms-list d-flex">
                        <li class="ms-list-item pl-0">
                          <label class="ms-checkbox-wrap">
                            <input type="radio" name="radioExample" value="">
                            <i class="ms-checkbox-check"></i>
                          </label>
                          <span> Male </span>
                        </li>
                        <li class="ms-list-item">
                          <label class="ms-checkbox-wrap">
                            <input type="radio" name="radioExample" value="" checked="">
                            <i class="ms-checkbox-check"></i>
                          </label>
                          <span> Female </span>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <button class="btn btn-warning mt-4 d-inline w-20" type="submit">Reset</button>
                  <button class="btn btn-primary mt-4 d-inline w-20" type="submit">Add Appointment</button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="prescription" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ms-modal-dialog-width">
      <div class="modal-content ms-modal-content-width">
        <div class="modal-header  ms-modal-header-radius-0">
          <h4 class="modal-title text-white">Make a prescription</h4>
          <button type="button" class="close  text-white" data-dismiss="modal" aria-hidden="true">x</button>

        </div>
        <div class="modal-body p-0 text-left">
          <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-panel-bshadow-none">
              <div class="ms-panel-header">
                <h6>Patient Information</h6>
              </div>
              <div class="ms-panel-body">
                <form class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom09">Patient Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom09" placeholder="Enter Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom10">Date Of Birth</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom10" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label for="validationCustom11">Address</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom11" placeholder="Add Address" required>

                      </div>
                    </div>

                  </div>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom12">Phone no.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom12" placeholder="Enter Phone No." required>

                      </div>

                    </div>

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom13">Medication</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom13" placeholder="Acetaminophen" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom14">Period Of medication</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom14" placeholder="" required>

                      </div>
                    </div>
                  </div>



                  <div class="form-row">

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom15">Appointment With</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom15" placeholder="Enter Doctor Name" required>

                      </div>
                    </div>

                  </div>
                  <button class="btn btn-warning mt-4 d-inline w-20" type="submit">Save Prescription</button>
                  <button class="btn btn-primary mt-4 d-inline w-20" type="submit">Save & Print</button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="report1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog ms-modal-dialog-width">
      <div class="modal-content ms-modal-content-width">
        <div class="modal-header  ms-modal-header-radius-0">
          <h4 class="modal-title text-white">Generate report</h4>
          <button type="button" class="close  text-white" data-dismiss="modal" aria-hidden="true">x</button>

        </div>
        <div class="modal-body p-0 text-left">
          <div class="col-xl-12 col-md-12">
            <div class="ms-panel ms-panel-bshadow-none">
              <div class="ms-panel-header">
                <h6>Patient Information</h6>
              </div>
              <div class="ms-panel-body">
                <form class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom16">Patient Name</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom16" placeholder="Enter Name" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom17">Date Of Birth</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom17" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <label for="validationCustom22">Address</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom22" placeholder="Add Address" required>

                      </div>
                    </div>

                  </div>
                  <div class="form-row">
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom18">Phone no.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom18" placeholder="Enter Phone No." required>

                      </div>

                    </div>

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom19">Report Type</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom19" placeholder="Diseases Report" required>

                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                      <label for="validationCustom23">Report Period</label>
                      <div class="input-group">
                        <input type="number" class="form-control" id="validationCustom23" placeholder="" required>

                      </div>
                    </div>
                  </div>



                  <div class="form-row">

                    <div class="col-md-4 mb-3">
                      <label for="validationCustom20">Appointment With</label>
                      <div class="input-group">
                        <input type="text" class="form-control" id="validationCustom20" placeholder="Enter Doctor Name" required>

                      </div>
                    </div>

                  </div>
                  <button class="btn btn-warning mt-4 d-inline w-20" type="submit">Generate Report</button>
                  <button class="btn btn-primary mt-4 d-inline w-20" type="submit">Generate & Print</button>
                </form>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <!-- Global Required Scripts Start -->
  <script src="{{ asset("assetsHopital/assets/js/jquery-3.3.1.min.js") }}"></script>
  <script src="{{ asset("assetsHopital/assets/js/popper.min.js") }}"></script>
  <script src="{{ asset("assetsHopital/assets/js/bootstrap.min.js") }}"></script>
  <script src="{{ asset("assetsHopital/assets/js/perfect-scrollbar.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/jquery-ui.min.js") }}"> </script>
  <!-- Global Required Scripts End -->
  <script src="{{ asset("assetsHopital/assets/js/d3.v3.min.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/topojson.v1.min.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/datamaps.all.min.js") }}"> </script>
  <!-- Page Specific Scripts Start -->
  <script src="{{ asset("assetsHopital/assets/js/slick.min.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/moment.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/jquery.webticker.min.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/Chart.bundle.min.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/Chart.Financial.js") }}"> </script>
  <script src="{{ asset("assetsHopital/assets/js/index-chart.js") }}"> </script>

  <!-- Page Specific Scripts Finish -->
  <script src="{{ asset("assetsHopital/assets/js/calendar.js") }}"></script>
  <!-- medjestic core JavaScript -->
  <script src="{{ asset("assetsHopital/assets/js/framework.js") }}"></script>
  <!-- Settings -->
  <script src="{{ asset("assetsHopital/assets/js/settings.js") }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script>
    // Animation multi-étapes (exemple commun pour multi-step form)
    $(".next").click(function() { ... });
    $(".previous").click(function() { ... });
</script>
</body>

</html>
