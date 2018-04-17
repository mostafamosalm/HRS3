    <?php
    // look if there is a session or not
    session_start();
    if(isset($_SESSION['username'])) {
        $pagetitle = 'Employees';
        include '../layouts/init.php';
    ?>

    <?php
    $Action = '';
    if (isset($_GET['Action'])) {
        $Action = $_GET['Action'];
    } else {
        $Action = 'Manage';
    }
    ?>

    <?php
        /*Manage Page*/
    if ($Action == 'Manage') {
        $stmt = $con->prepare("SELECT 
    em_codes.em_id,
    em_code,
    first_en,second_en,third_en,fourth_en,last_en,
    first_ar,second_ar,third_ar,fourth_ar,last_ar,
    payroll_data_tbl.salary_period,
    jobs_tbl.job_name,
    branches_tbl.branch_name,
    work_permission.permission_start
    FROM em_codes
    
    LEFT JOIN em_job_data ON em_codes.em_id=em_job_data.em_id
    LEFT JOIN jobs_tbl ON em_job_data.job_id=jobs_tbl.job_id
    LEFT JOIN branches_tbl ON em_job_data.branch_id=branches_tbl.branch_id
    LEFT JOIN work_permission ON em_codes.em_id=work_permission.em_id   
    LEFT JOIN payroll_data_tbl ON em_codes.em_id=payroll_data_tbl.em_id");
        $stmt->execute();
        $rows = $stmt->fetchAll();
    ?>
        <!-- //Start Page Content -->
        <div class="col-lg-9">
            <!-- Employees Nav Bar-->
            <div class="navbar navbar-default container-fluid" role="navigation">
                <!--Left buttons-->
                <div class="btn-group navbar-form navbar-left">
                    <a href="?Action=Add" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New Employee</a>
                </div>
                <!--Right buttons-->
                <ul class=" nav navbar-nav navbar-right">
                    <li>
                        <form class="navbar-form navbar-left" style="text-align: right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" style="width: auto" id="searchbox"/>
                                <span class="input-group-btn">
                        <button  class="btn btn-primary" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                            </div>
                        </form>
                    </li>
                    <li class="navbar-form navbar-left btn-group">
                        <button class="btn btn-default">
                            <i class="glyphicon glyphicon-refresh icon-refresh"></i>
                        </button>

                        <div class="keep-open btn-group" title="Columns">
                            <button type="button" aria-label="columns" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-th icon-th"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">PDF</a></li>
                                <li><a href="#">EXCEL</a></li>
                                <li><a href="#">WORD</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="navbar-form navbar-left btn-group">
                        <button href="#" class="btn btn-default">
                    <span class="glyphicon glyphicon-th-large">
                    </span>
                        </button>
                        <button href="#" class="btn btn-default">
                    <span class="glyphicon glyphicon-th-list">
                    </span>
                        </button>
                    </li>
                </ul>
            </div>        <!-- Start Employees table/cards -->
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Job</th>
                    <th>Salary</th>
                    <th>Job</th>
                    <th>Branch</th>
                    <th>Permission</th>
                </tr>
                </thead>
                <tbody id="tablebody">
                <?php
                foreach($rows as $row) {
                    echo "<tr>";
                    echo "<td>". $row['em_id'] . "</td>";
                    echo "<td>". $row['em_code'] . "</td>";
                    echo "<td>". $row['first_en'] . " " . $row['second_en'] ." " .$row['third_en'] ." " .$row['fourth_en'] ." " .$row['last_en'] .
                        "<br>"
                        .$row['first_ar'] ." " . $row['second_ar'] ." " .$row['third_ar'] ." " .$row['fourth_ar'] ." " .$row['last_ar'] . "</td>";
                    echo "<td>". $row['salary_period'] . "</td>";
                    echo "<td>". $row['job_name'] .  "</td>";
                    echo "<td>". $row['branch_name'] . "</td>";
                    echo "<td>". $row['permission_start'] . "</td>";
                    echo "<td>
                    <a class='btn btn-xs btn-primary' type='button' id='myButton' data-toggle='modal' data-target='#myModal' data-backdrop='static'><span class='glyphicon glyphicon-list-alt'></span>&nbsp;Details</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
            <!-- End Employees table/cards -->
        </div>
        <!--Modal-->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <button href="#" class="btn btn-warning">
            <span class="glyphicon glyphicon-edit">
            </span>&nbsp; Edit
                        </button>
                        <button href="#" class="btn btn-danger">
            <span class="glyphicon glyphicon-trash">
            </span>&nbsp; Delete
                        </button>
                        <div class="btn-group navbar-form navbar-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="background:firebrick;color: white">
                                    <span class="glyphicon glyphicon-adjust"></span>
                                    &nbsp; Actions
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Vacation Request</a></li>
                                    <li><a href="#">On account</a></li>
                                    <li><a href="#">Form actions</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="background:darkgoldenrod;color:white">
                                    <span class="glyphicon glyphicon-stats"></span>
                                    &nbsp; Reports
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Salary Certifcate</a></li>
                                    <li><a href="#">Payslip</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <!-- ****************************** Main information ********************************* -->
                        <div class="container">
                            <div class="row">
                                <div class="col-md-5">
                                    <table class="table">
                                        <tr>
                                            <th>ID</th>
                                            <th><?PHP echo "<td>". $row['em_id'] . "</td>"; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Code</th>
                                            <th><?PHP echo "<td>". $row['em_code'] . "</td>"; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th><?PHP echo "<td>". $row['name'] . "<br>" . $row["arabicname"] . "</td>" ?></th>
                                        </tr>
                                        <tr>
                                            <th>Job</th>
                                            <th><?PHP echo "<td>". $row['job_name'] . "</td>"; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Civil ID</th>
                                            <th><?PHP echo "<td>". $row['branch_name'] . "</td>"; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Salary</th>
                                            <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-3">
                                    <img src="../layouts/img/employee.png" width="100%" style="border: 3px;border-style:ridge;margin-bottom: 20px">
                                    <div>
                                        <button type="button" class="btn btn-success" style="width: 45%"><span class="glyphicon glyphicon-plus"></span>&nbsp;Insert</button>
                                        <button type="button" class="btn btn-danger pull-right" style="width: 45%"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ****************************** Modal tabs *************************************** -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#Job_Info">Job Info</a></li>
                            <li><a data-toggle="tab" href="#Official_Info">Official Info</a></li>
                            <li><a data-toggle="tab" href="#Contact_Info">Contact Info</a></li>
                            <li><a data-toggle="tab" href="#Payroll">Payroll</a></li>
                            <li><a data-toggle="tab" href="#Official_Paper">Official Papers</a></li>
                            <li><a data-toggle="tab" href="#menu3">Documents</a></li>
                            <li><a data-toggle="tab" href="#Notes_Reminder">Notes&amp;Reminder</a></li>
                        </ul>
                        <!-- ****************************** Modal tabs Contents ****************************** -->
                        <div class="tab-content">
                            <!-- ****************************** Job information tab ****************************** -->
                            <div id="Job_Info" class="tab-pane fade in active">
                                <h3>Job Information</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table">
                                                <tr>
                                                    <th>Job ID</th>
                                                    <th><?PHP echo "<td>". $row['empolyee_id'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Job Name</th>
                                                    <th><?PHP echo "<td>". $row['code'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Hire Date</th>
                                                    <th><?PHP echo "<td>". $row['job_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Branch</th>
                                                    <th><?PHP echo "<td>". $row['job_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <th><?PHP echo "<td>". $row['branch_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Salary</th>
                                                    <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ****************************** Official information tab ************************* -->
                            <div id="Official_Info" class="tab-pane fade">
                                <h3>Official Information</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table">
                                                <tr>
                                                    <th>Civi ID</th>
                                                    <th><?PHP echo "<td>". $row['empolyee_id'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Resdency Number</th>
                                                    <th><?PHP echo "<td>". $row['code'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Job</th>
                                                    <th><?PHP echo "<td>". $row['branch_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Entry Date</th>
                                                    <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>The Start Date</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class='col-md-1'></div>
                                        <div class="col-md-4">
                                            <table class="table">
                                                <tr>
                                                    <th>Salary</th>
                                                    <th><?PHP echo "<td>". $row['job_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Facility Name</th>
                                                    <th><?PHP echo "<td>". $row['job_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Qualification</th>
                                                    <th><?PHP echo "<td>". $row['job_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Duration of use</th>
                                                    <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>Social Status</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ****************************** Official information tab ************************* -->
                            <div id="Contact_Info" class="tab-pane fade">
                                <h3>Contact Information</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table">
                                                <tr>
                                                    <th>Phone 1</th>
                                                    <th><?PHP echo "<td>". $row['empolyee_id'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Phone 2</th>
                                                    <th><?PHP echo "<td>". $row['code'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <th><?PHP echo "<td>". $row['branch_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>Contact Person</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>CP Phone</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class='col-md-1'></div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ****************************** Payroll tabs ************************************* -->
                            <div id="Payroll" class="tab-pane fade">
                                <h3>Contact Information</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table">
                                                <tr>
                                                    <th>Phone 1</th>
                                                    <th><?PHP echo "<td>". $row['empolyee_id'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Phone 2</th>
                                                    <th><?PHP echo "<td>". $row['code'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <th><?PHP echo "<td>". $row['branch_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>Contact Person</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>CP Phone</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class='col-md-1'></div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ****************************** Official Papers tab ****************************** -->
                            <div id="Official_Paper" class="tab-pane fade">
                                <h3>Contact Information</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table">
                                                <tr>
                                                    <th>Phone 1</th>
                                                    <th><?PHP echo "<td>". $row['empolyee_id'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Phone 2</th>
                                                    <th><?PHP echo "<td>". $row['code'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <th><?PHP echo "<td>". $row['branch_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>Contact Person</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>CP Phone</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class='col-md-1'></div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ****************************** Documents tab ************************************ -->
                            <div id="Notes_Reminder" class="tab-pane fade">
                                <h3>Contact Information</h3>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table class="table">
                                                <tr>
                                                    <th>Phone 1</th>
                                                    <th><?PHP echo "<td>". $row['empolyee_id'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Phone 2</th>
                                                    <th><?PHP echo "<td>". $row['code'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <th><?PHP echo "<td>". $row['branch_name'] . "</td>"; ?></th>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>Contact Person</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                                <th>CP Phone</th>
                                                <th><?PHP echo "<td>". $row['salary'] . "</td>"; ?></th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class='col-md-1'></div>
                                        <div class="col-md-4">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>  <!--close tabs content-->
                    </div> <!--close modal body-->
                    <!-- ****************************** Modal footer ************************************** -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    /*Add New Employee Page*/
    elseif ($Action == 'Add')
    {
    ?>
    <div class="col-lg-9">
                <div class="container">
                    <!--Main information-->
                    <div class="row">
                        <div class="col-md-10">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label control-label">ID</label>
                                            <input class="form-control input-sm" id="focusedInput" type="text" disabled="">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label control-label">Code</label>
                                            <input class="form-control input-sm" id="focusedInput" type="text">
                                        </div>
                                    </div><div class="col-md-3">
                                        <div class="form-group">
                                            <label control-label">Status</label>
                                            <select class="form-control input-sm">
                                                <option>Active</option>
                                                <option>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <label control-label">Name (English)</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="First">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Second">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Third">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Fourth">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Last">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="container">
                                <label control-label">Name (Arabic)</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="First">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Second">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Third">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Fourth">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text" placeholder="Last">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="control-label">Gender</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Nation</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Social Status</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Birth Date</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <select class="form-control input-sm">
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm">
                                            <option>Single</option>
                                            <option>Married</option>
                                            <option>Divorced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <img src="../layouts/img/employee.png" width="100%" style="border: 3px;border-style:ridge;margin-bottom: 20px">
                            <div>
                                <button type="button" class="btn btn-success" style="width: 45%"><span class="glyphicon glyphicon-plus"></span>&nbsp;Insert</button>
                                <button type="button" class="btn btn-danger pull-right" style="width: 45%"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Delete</button>
                            </div>
                            <br>
                            <br>
                            <label class="control-label" style="color: gray">Created by</label><br>
                            <label class="control-label" style="color: gray">Created Date</label>
                        </div>
                    </div>
                    <br>
                    <!--Job Information Panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" href="#collapse1">Job Information</a>
                            </h3>
                        </div>
                        <div id="collapse1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Job</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Hire Date</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Branch</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Department</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control input-sm">
                                            <option>Job 1</option>
                                            <option>Job 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control input-sm">
                                            <option>Branch 1</option>
                                            <option>Branch 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control input-sm">
                                            <option>Department 1</option>
                                            <option>Department 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Payroll Panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" href="#collapse7">Payroll</a>
                            </h3>
                        </div>
                        <div id="collapse7" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Pay Period</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Salary Per Period</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Salary Per Hour</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Salary Per Day</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Annul Salary</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control input-sm">
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Daily</option>
                                            <option>Hourly</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="number" disabled="">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Allowance</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <label class="checkbox-inline"><input type="checkbox" value="">Car</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="checkbox-inline"><input type="checkbox" value="">House</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="checkbox-inline"><input type="checkbox" value="">Food</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="checkbox-inline"><input type="checkbox" value="">Mobile</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="checkbox-inline"><input type="checkbox" value="">Transport</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="checkbox-inline"><input type="checkbox" value="">Transport</label>
                                    </div>
                                    <div class="col-md-1">
                                        <label class="checkbox-inline"><input type="checkbox" value="">Other</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Totals</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-1">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-1">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control" id="focusedInput" type="number" disabled="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Work Permission Panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" href="#collapse2">Official Information</a>
                            </h3>
                        </div>
                        <div id="collapse2" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Resdency Number</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Job</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Civil ID</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Salary</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control input-sm">
                                            <option>18</option>
                                            <option>20</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Facility Name</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">The Start Date</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">End of use</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="date" disabled="">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Entry Date</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Reference Number</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Social Status</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Qualification</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Branch</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm">
                                            <option>Single</option>
                                            <option>Married</option>
                                            <option>Divorced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm">
                                            <option>Branch 1</option>
                                            <option>Branch 2</option>
                                            <option>Branch 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Contact Information Panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" href="#collapse3">Contact Information</a>
                            </h3>
                        </div>
                        <div id="collapse3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Phone 1</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Phone 2</label>
                                    </div>
                                    <div class="col-md-6">
                                        <label control-label">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="email">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label control-label">Address</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Contact Person</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">CP Phone</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Passport Information Panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" href="#collapse4">Passport Information</a>
                            </h3>
                        </div>
                        <div id="collapse4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Passport Number</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Release Date</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Expiry Date</label>
                                    </div>
                                    <div class="col-md-2">
                                        <label control-label">Type</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Place of Birth</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Bank Panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" href="#collapse5">Bank Data</a>
                            </h3>
                        </div>
                        <div id="collapse5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Payment Type</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Bank Name</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Account Number</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">IBAN</label>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <select class="form-control input-sm">
                                            <option>Cash</option>
                                            <option>Bank Transfer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control input-sm">
                                            <option>CBK</option>
                                            <option>NBK</option>
                                            <option>KFH</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="number">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <!--Other Information Panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <a data-toggle="collapse" href="#collapse6">Other Information</a>
                            </h3>
                        </div>
                        <div id="collapse6" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label control-label">Health card ExD</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Driving Licence Type</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">Licence ExD</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="text">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" id="focusedInput" type="date">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <!--Save or Cancel Buttons-->
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <a href="#" class="btn btn-block btn-success"><span class="glyphicon glyphicon-save"></span> Save</a>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-5">
                            <a href="#" class="btn btn-block btn-warning"><span class="glyphicon glyphicon-remove-sign"></span> Cancel</a>
                        </div>
                    </div>
                    <br>
                </div>

            </div>
    <?php
    }
    /*Edit Employee Page*/
    elseif ($Action == 'Add')
    {
    ?>
    <?php
    }
    /*Redirect If Action is wrong*/
    else {
        echo 'wrong page';
    }
    ?>

    <!--Page Footer-->
    <?php
    include $tpl . 'footer.php';
        }  else {
            header('Location: index.php');
            exit();
        }
    ?>




