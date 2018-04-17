<?php
    // look if there is a session or not
    session_start();
    if(isset($_SESSION['username'])) {
        $pagetitle = 'Dashboard';
        include '../layouts/init.php';
?>
<div class="col-lg-9">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Active Employees</div>
                    <div class="panel-body text-center">120</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active Employees</div>
                    <div class="panel-body">Panel Content</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active Employees</div>
                    <div class="panel-body">Panel Content</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active Employees</div>
                    <div class="panel-body">Panel Content</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active Employees</div>
                    <div class="panel-body">Panel Content</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Active Employees</div>
                    <div class="panel-body">Panel Content</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Last Add Employees</div>
                    <div class="panel-body text-center">120</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Notifications</div>
                    <div class="panel-body text-center">120</div>
                </div>
            </div>
        </div>
    </div>

</div>


    <!--Footer Section-->
<?php
    include $tpl . 'footer.php';
    } 
?>
