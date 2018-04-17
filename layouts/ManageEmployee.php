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
    /*Start Manage Page*/
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
    <!-- //Start Manage Page Content -->
    <div class="col-lg-9">

        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-md-3">
                            <h2>Manage <b>Employees</b></h2>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Search" id="searchbox"/>
                        </div>
                        <div class="col-md-2">
                            <a href="?Action=ShowDetails" class="btn btn-success btn-block btn-lg"><span class="glyphicon glyphicon-export"></span> Export To Excel</a>
                        </div>
                        <div class="col-md-2">
                            <a href="?Action=Add" class="btn btn-success btn-block btn-lg"><span class="glyphicon glyphicon-plus"></span> Add New Employee</a>
                        </div>
                    </div>
                </div>
                <!--Employee Data Table-->
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll"></label>
                        </span>
                        </th>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name (EN)</th>
                        <th>Name (AR)</th>
                        <th>Job</th>
                        <th>Branch</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tablebody">
                    <?php
                    foreach($rows as $row) {
                        echo "<tr style='cursor: pointer'>"; ?>
                        <td>
                        <span class="custom-checkbox">
                            <input type="checkbox" id="checkbox1" name="options[]" value="1">
                            <label for="checkbox1"></label>
                        </span>
                        </td>
                        <?php
                        echo "<td> <a href='ManageEmployee.php?Action=ShowDetails'>" . $row['em_id'] . "</a>" . "</td>";
                        echo "<td> <a href='ManageEmployee.php?Action=ShowDetails'>" . $row['em_code'] . "</a>" . "</td>";
                        echo "<td>". $row['first_en'] . " " . $row['second_en'] ." " .$row['third_en'] ." " .$row['fourth_en'] ." " .$row['last_en'] . "</td>";
                        echo "<td>". $row['first_ar'] . " " . $row['second_ar'] ." " .$row['third_ar'] ." " .$row['fourth_ar'] ." " .$row['last_ar'] . "</td>";
                        echo "<td>". $row['job_name'] . "</td>";
                        echo "<td>". $row['branch_name'] . "</td>";
                        echo "<td>
                        <a href='?Action=Edit&em_id=$row[em_id]' class='btn btn-xs'><span class='glyphicon glyphicon-pencil' style='color: #985f0d'></span></a>
                        <a href='#deleteEmployeeModal' class='delete' data-toggle='modal' class='btn btn-xs'><span class='glyphicon glyphicon-trash' style='color: red'></span></a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End Employees table/cards -->
    </div>

    <!--Delete Employee Modal-->
    <div id="deleteEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Employee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p style="font-weight: bold">Are you sure you want to delete these Employee?</p>
                        <p> Code : <?php echo "<td>". $row['em_code'] . "</td>"; ?></p>
                        <p> Name : <?php echo "<td>". $row['first_en'] . " " . $row['second_en'] ." " .$row['third_en'] ." " .$row['fourth_en'] ." " .$row['last_en'] . "</td>"; ?></p>
                        <p class="text-warning"><small>This action cannot be undone.</small></p>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <input type="submit" class="btn btn-danger" value="Delete">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Manage Page-->

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
                                    <input class="form-control input-sm" type="text" placeholder="First">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Second">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Third">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Fourth">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Last">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="container">
                            <label control-label">Name (Arabic)</label>
                            <div class="row">
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="First">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Second">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Third">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Fourth">
                                </div>
                                <div class="col-md-2">
                                    <input class="form-control input-sm" type="text" placeholder="Last">
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
                                        <?php
                                        $stmt = $con->prepare("SELECT job_id,job_name FROM jobs_tbl");
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll();
                                        foreach($rows as $row) {
                                        ?>
                                        <option><?php echo $row['job_id'] . "  " . $row['job_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input class="form-control input-sm" id="focusedInput" type="date">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control input-sm">
                                        <?php
                                        $stmt = $con->prepare("SELECT branch_id,branch_name FROM branches_tbl ");
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll();
                                        foreach($rows as $row) {
                                            ?>
                                            <option><?php echo $row['branch_id'] . " " . $row['branch_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control input-sm">
                                        <?php
                                        $stmt = $con->prepare("SELECT department_id,department_name FROM departments_tbl ");
                                        $stmt->execute();
                                        $rows = $stmt->fetchAll();
                                        foreach($rows as $row) {
                                            ?>
                                            <option><?php echo $row['department_id'] . " " . $row['department_name'] ?></option>
                                        <?php } ?>
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
    /*Show Employee Details Page*/
    elseif ($Action == 'ShowDetails')
    {
        ?>
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
        <?php
    }
    /*Edit Employee Page*/
    elseif ($Action == 'Edit')
    {
        $em_id=$_GET['em_id'];        // Collecting data from query string
        if(!is_numeric($em_id)){ // Checking data it is a number or not
            echo "Data Error";
            exit;
        }

        $stmt= $con->prepare("SELECT 
        em_codes.em_id,
        em_code,
        em_status,
        first_en,second_en,third_en,fourth_en,last_en,
        first_ar,second_ar,third_ar,fourth_ar,last_ar,
        gender,
        nation,
        social_status,
        birthdate,
        
        jobs_tbl.job_name,
        em_job_data.hiredate,
        branches_tbl.branch_name,
        departments_tbl.department_name,
        
        payroll_data_tbl.pay_period,
        payroll_data_tbl.salary_period,
    
        passport_info.passport_number,
        passport_info.release_date,
        passport_info.expirt_date,
        passport_info.passport_type,
        passport_info.place_of_birth,
        
        work_permission.Residency_number,
        work_permission.ojob_id,
        work_permission.civil_id,
        work_permission.osalary,
        work_permission.owner,
        work_permission.permission_start,
        work_permission.duration,
        work_permission.permission_end,
        work_permission.entry_date,
        work_permission.reference_number,
        work_permission.osocial_status,
        work_permission.qualification,
        work_permission.obranch_id,
        
        em_contact_info.phone1,
        em_contact_info.phone2,
        em_contact_info.email,
        em_contact_info.address,
        em_contact_info.contact_person,
        em_contact_info.cp_phone,
        
        bank_id,
        payment_type,
        ac_number,
        iban,
        
        healthcard_exd,
        dl_type,
        dl_exd
        
        FROM em_codes
        
        LEFT JOIN     em_job_data      ON em_codes.em_id            = em_job_data.em_id
        LEFT JOIN     jobs_tbl         ON em_job_data.job_id        = jobs_tbl.job_id
        LEFT JOIN     branches_tbl     ON em_job_data.branch_id     = branches_tbl.branch_id
        LEFT JOIN     departments_tbl  ON em_job_data.departmentid  = departments_tbl.department_id
        LEFT JOIN     work_permission  ON jobs_tbl.job_id           = work_permission.ojob_id
        LEFT JOIN     payroll_data_tbl ON em_codes.em_id            = payroll_data_tbl.em_id
        LEFT JOIN     passport_info    ON em_codes.em_id            = passport_info.em_id
        LEFT JOIN     em_contact_info  ON em_codes.em_id            = em_contact_info.em_id
        LEFT JOIN     bank_data        ON em_codes.em_id            = bank_data.em_id
        LEFT JOIN     em_other_data    ON em_codes.em_id            = em_other_data.em_id        WHERE em_codes.em_id=?");

        $stmt->execute(array($em_id));
        $row = $stmt->fetch();
        $count = $stmt->rowcount();
        ?>
        <div class="col-lg-9">
            <form class="form-horizontal" action="?Action=Update" method="POST">
                <div class="container">
                    <!--Main information-->
                    <div class="row">
                        <div class="col-md-10">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-1">
                                        <div>
                                            <label control-label">ID</label>
                                            <input class="form-control input-sm" type="hidden" name="emid" type="text" value="<?php echo $em_id ?>" hidden="hidden">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div>
                                            <label control-label">Code</label>
                                            <input class="form-control input-sm" name="em_code" type="text" value="<?php echo $row['em_code'] ?>">
                                        </div>
                                    </div><div class="col-md-3">
                                        <div>
                                            <label control-label">Status</label>
                                            <select class="form-control input-sm" name="em_status">
                                                <option><?php echo $row['em_status'] ?></option>
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
                                        <input class="form-control input-sm" name="first_en" type="text" placeholder="First" value="<?php echo $row['first_en'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="second_en" type="text" placeholder="Second" value="<?php echo $row['second_en'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="third_en" type="text" placeholder="Third" value="<?php echo $row['third_en'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="fourth_en" type="text" placeholder="Fourth" value="<?php echo $row['fourth_en'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="last_en" type="text" placeholder="Last" value="<?php echo $row['last_en'] ?>">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="container">
                                <label control-label">Name (Arabic)</label>
                                <div class="row">
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="first_ar" type="text" placeholder="First" value="<?php echo $row['first_ar'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="second_ar" type="text" placeholder="Second" value="<?php echo $row['second_ar'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="third_ar" type="text" placeholder="Third" value="<?php echo $row['third_ar'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="fourth_ar" type="text" placeholder="Fourth" value="<?php echo $row['fourth_ar'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="last_ar" type="text" placeholder="Last" value="<?php echo $row['last_ar'] ?>">
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
                                        <select class="form-control input-sm" name="gender">
                                            <option><?php echo $row['gender'] ?></option>
                                            <option>Male</option>
                                            <option>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="nation" type="text"  value="<?php echo $row['nation'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm" name="social_status">
                                            <option><?php echo $row['social_status'] ?></option>
                                            <option>Single</option>
                                            <option>Married</option>
                                            <option>Divorced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="birthdate" type="date" value="<?php echo $row['birthdate'] ?>">
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
                                        <select class="form-control input-sm" name="job_id">
                                            <option><?php echo $row['job_name'] ?></option>
                                            <?php
                                            $stmt = $con->prepare("SELECT job_id,job_name FROM jobs_tbl");
                                            $stmt->execute();
                                            $rows = $stmt->fetchAll();
                                            foreach($rows as $row1) {
                                                ?>
                                                <option><?php echo $row1['job_id'] . "  " . $row1['job_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="hiredate" type="date"  value="<?php echo $row1['hiredate'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control input-sm" name="branch_id">
                                            <option><?php echo $row['branch_name'] ?></option>
                                            <?php
                                            $stmt = $con->prepare("SELECT branch_id,branch_name FROM branches_tbl ");
                                            $stmt->execute();
                                            $rows = $stmt->fetchAll();
                                            foreach($rows as $row2) {
                                                ?>
                                                <option><?php echo $row2['branch_id'] . " " . $row2['branch_name'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control input-sm" name="departmentid">
                                            <option><?php echo $row['department_name'] ?></option>
                                            <?php
                                            $stmt = $con->prepare("SELECT department_id,department_name FROM departments_tbl ");
                                            $stmt->execute();
                                            $rows = $stmt->fetchAll();
                                            foreach($rows as $row3) {
                                                ?>
                                                <option><?php echo $row3['department_id'] . " " . $row3['department_name'] ?></option>
                                            <?php } ?>
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
                                        <select class="form-control input-sm" name="pay_period">
                                            <option><?php echo $row['pay_period'] ?></option>
                                            <option>Monthly</option>
                                            <option>Weekly</option>
                                            <option>Daily</option>
                                            <option>Hourly</option>
                                        </select>
                                    </div>
                                    <?php
                                    $salary = $row['salary_period'];
                                    $day = $salary/26;
                                    $hour = $day/8;
                                    $year = $day * 26;
                                    ?>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="salary_period" type="number" value="<?php echo $row['salary_period'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="" type="number" disabled="" value="<?php echo number_format($hour,3 )?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="" type="number" disabled="" value="<?php echo number_format($day,3 )?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="" type="number" disabled="" value="<?php echo number_format($year,3 )?>">
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
                                        <select class="form-control input-sm" name="Residency_number">
                                            <option><?php echo $row['Residency_number'] ?></option>
                                            <option>18</option>
                                            <option>20</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="ojob_id" type="text" value="<?php echo $row['ojob_id'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="civil_id" type="number" value="<?php echo $row['civil_id'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="osalary" type="number" value="<?php echo $row['osalary'] ?>">
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
                                        <label control-label">Duration</label>
                                    </div>
                                    <div class="col-md-3">
                                        <label control-label">End of use</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="owner" type="text" value="<?php echo $row['owner'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="permission_start" type="date" value="<?php echo $row['permission_start'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="duration" type="number" value="<?php echo $row['duration'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="permission_end" type="date" value="<?php echo $row['permission_end'] ?>">
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
                                        <input class="form-control input-sm" name="entry_date" type="date" value="<?php echo $row['entry_date'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="reference_number" type="number" value="<?php echo $row['reference_number'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm" name="osocial_status">
                                            <option><?php echo $row['osocial_status'] ?></option>
                                            <option>Single</option>
                                            <option>Married</option>
                                            <option>Divorced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="qualification" type="text" value="<?php echo $row['qualification'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control input-sm" name="obranch_id">
                                            <option><?php echo $row['obranch_id'] ?></option>
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
                                        <input class="form-control input-sm" name="phone1" type="number" value="<?php echo $row['phone1'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="phone2" type="number" value="<?php echo $row['phone2'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="email" type="email" value="<?php echo $row['email'] ?>">
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
                                        <input class="form-control input-sm" name="address" type="text" value="<?php echo $row['address'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="contact_person" type="text" value="<?php echo $row['contact_person'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="cp_phone" type="number" value="<?php echo $row['cp_phone'] ?>">
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
                                        <input class="form-control input-sm" name="passport_number" type="text" value="<?php echo $row['passport_number'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="release_date" type="date" value="<?php echo $row['release_date'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="expirt_date" type="date" value="<?php echo $row['expirt_date'] ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <input class="form-control input-sm" name="passport_type" type="text" value="<?php echo $row['passport_type'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="place_of_birth" type="text" value="<?php echo $row['place_of_birth'] ?>">
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
                                        <select class="form-control input-sm" name="payment_type">
                                            <option><?php echo $row['payment_type'] ?></option>
                                            <option>Cash</option>
                                            <option>Bank Transfer</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control input-sm" name="bank_id">
                                            <option><?php echo $row['bank_id'] ?></option>
                                            <option>CBK</option>
                                            <option>NBK</option>
                                            <option>KFH</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="ac_number" type="number" value="<?php echo $row['ac_number'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="iban" type="text" value="<?php echo $row['iban'] ?>">
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
                                        <input class="form-control input-sm" name="healthcard_exd" type="date" value="<?php echo $row['healthcard_exd'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="dl_type" type="text" value="<?php echo $row['dl_type'] ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control input-sm" name="dl_exd" type="date" value="<?php echo $row['dl_exd'] ?>">
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <!--Update or Cancel Buttons-->
                    <hr>
                    <div class="row form-group">
                        <div class="col-md-5">
                            <input type="submit" class="btn btn-block btn-success"><span class="glyphicon glyphicon-save"></span>Update</input>
                        </div>
                        <div class="col-md-6">
                            <a class="btn btn-block btn-warning"><span class="glyphicon glyphicon-remove-sign"></span>Cancel</a>
                        </div>
                    </div>
                    <br>
                </div>
            </form>
        </div>
        <?php
    }

    /*Update Employee Page*/
    elseif ($Action == 'Update')
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $em_id                  = $_POST['emid'];
            $em_code                = $_POST['em_code'];
            $em_status              = $_POST['em_status'];
            $first_en               = $_POST['first_en'];
            $second_en              = $_POST['second_en'];
            $third_en               = $_POST['third_en'];
            $fourth_en              = $_POST['fourth_en'];
            $last_en                = $_POST['last_en'];
            $first_ar               = $_POST['first_ar'];
            $second_ar              = $_POST['second_ar'];
            $third_ar               = $_POST['third_ar'];
            $fourth_ar              = $_POST['fourth_ar'];
            $last_ar                = $_POST['last_ar'];
            $gender                 = $_POST['gender'];
            $nation                 = $_POST['nation'];
            $social_status          = $_POST['social_status'];
            $birthdate              = $_POST['birthdate'];
            $job_id                 = $_POST['job_id'];
            $branch_id              = $_POST['branch_id'];
            $hiredate               = $_POST['hiredate'];
            $branch_id              = $_POST['branch_id'];
            $departmentid           = $_POST['departmentid'];
            $pay_period             = $_POST['pay_period'];
            $salary_period          = $_POST['salary_period'];
            $passport_number        = $_POST['passport_number'];
            $release_date           = $_POST['release_date'];
            $expirt_date            = $_POST['expirt_date'];
            $passport_type          = $_POST['passport_type'];
            $place_of_birth         = $_POST['place_of_birth'];
            $Residency_number       = $_POST['Residency_number'];
            $ojob_id                = $_POST['ojob_id'];
            $civil_id               = $_POST['civil_id'];
            $osalary                = $_POST['osalary'];
            $owner                  = $_POST['owner'];
            $permission_start       = $_POST['permission_start'];
            $duration               = $_POST['duration'];
            $permission_end         = $_POST['permission_end'];
            $entry_date             = $_POST['entry_date'];
            $reference_number       = $_POST['reference_number'];
            $osocial_status         = $_POST['osocial_status'];
            $qualification          = $_POST['qualification'];
            $obranch_id             = $_POST['obranch_id'];
            $phone1                 = $_POST['phone1'];
            $phone2                 = $_POST['phone2'];
            $email                  = $_POST['email'];
            $address                = $_POST['address'];
            $contact_person         = $_POST['contact_person'];
            $cp_phone               = $_POST['cp_phone'];
            $bank_id                = $_POST['bank_id'];
            $payment_type           = $_POST['payment_type'];
            $ac_number              = $_POST['ac_number'];
            $iban                   = $_POST['iban'];
            $healthcard_exd         = $_POST['healthcard_exd'];
            $dl_type                = $_POST['dl_type'];
            $dl_exd                  = $_POST['dl_exd'];


            /*Update database*/
            $stmt = $con->prepare("UPDATE em_codes,em_job_data,payroll_data_tbl,passport_info,work_permission,em_contact_info,bank_data,em_other_data SET 
                                                    em_code = ? ,
                                                    em_status = ?,
                                                    first_en = ?,
                                                    second_en = ?,
                                                    third_en = ?,
                                                    fourth_en = ?,
                                                    last_en = ?,
                                                    first_ar = ?,
                                                    second_ar = ?,
                                                    third_ar = ?,
                                                    fourth_ar = ?,
                                                    last_ar = ?,
                                                    gender = ?,
                                                    nation = ?,
                                                    social_status = ?,
                                                    birthdate = ?,
                                                    em_job_data.job_id = ?,
                                                    em_job_data.branch_id = ?,
                                                    em_job_data.hiredate = ?,
                                                    em_job_data.branch_id = ?,
                                                    em_job_data.departmentid = ?,
                                                    payroll_data_tbl.pay_period = ?,
                                                    payroll_data_tbl.salary_period = ?,
                                                    passport_info.passport_number = ?,
                                                    passport_info.release_date = ?,
                                                    passport_info.expirt_date = ?,
                                                    passport_info.passport_type = ?,
                                                    passport_info.place_of_birth = ?,
                                                    work_permission.Residency_number = ?,
                                                    work_permission.ojob_id = ?,
                                                    work_permission.civil_id = ?,
                                                    work_permission.osalary = ?,
                                                    work_permission.owner = ?,
                                                    work_permission.permission_start = ?,
                                                    work_permission.duration = ?,
                                                    work_permission.permission_end = ?,
                                                    work_permission.entry_date = ?,
                                                    work_permission.reference_number = ?,
                                                    work_permission.osocial_status = ?,
                                                    work_permission.qualification = ?,
                                                    work_permission.obranch_id = ?,
                                                    em_contact_info.phone1 = ?,
                                                    em_contact_info.phone2 = ?,
                                                    em_contact_info.email = ?,
                                                    em_contact_info.address = ?,
                                                    em_contact_info.contact_person = ?,
                                                    em_contact_info.cp_phone = ?,
                                                    bank_data.bank_id = ?,
                                                    bank_data.payment_type = ?,
                                                    bank_data.ac_number = ?,
                                                    bank_data.iban = ?,
                                                    em_other_data.healthcard_exd = ?,
                                                    em_other_data.dl_type = ?,
                                                    em_other_data.dl_exd = ?                   
                                                    WHERE em_codes.em_id = ?");
            $stmt->execute(array($em_code ,
                                $em_status,
                                $first_en,
                                $second_en,
                                $third_en,
                                $fourth_en,
                                $last_en,
                                $first_ar,
                                $second_ar,
                                $third_ar,
                                $fourth_ar,
                                $last_ar,
                                $gender,
                                $nation,
                                $social_status,
                                $birthdate,
                                $job_id,
                                $branch_id,
                                $hiredate,
                                $branch_id,
                                $departmentid,
                                $pay_period,
                                $salary_period,
                                $passport_number,
                                $release_date,
                                $expirt_date,
                                $passport_type,
                                $place_of_birth,
                                $Residency_number,
                                $ojob_id,
                                $civil_id,
                                $osalary,
                                $owner,
                                $permission_start,
                                $duration,
                                $permission_end,
                                $entry_date,
                                $reference_number,
                                $osocial_status,
                                $qualification,
                                $obranch_id,
                                $phone1,
                                $phone2,
                                $email,
                                $address,
                                $contact_person,
                                $cp_phone,
                                $bank_id,
                                $payment_type,
                                $ac_number,
                                $iban,
                                $healthcard_exd,
                                $dl_type,
                                $dl_exd,
                $em_id));
            echo $stmt->rowCount() . 'record updates';

        } else {
            echo 'Wrong Page';
        }
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