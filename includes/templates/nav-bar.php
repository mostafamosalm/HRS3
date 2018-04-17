<div class="navbar navbar-default">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell" aria-hidden="true"></i>&nbsp;Notification&nbsp;<span class="label label-danger pull-right">42</span>
            </a>
                <ul class="dropdown-menu">
                    <li><a href="#"><span class="label label-warning">7:00 AM</span>Hi :)</a></li>
                    <li><a href="#"><span class="label label-warning">8:00 AM</span>How are you?</a></li>
                    <li><a href="#"><span class="label label-warning">9:00 AM</span>What are you doing?</a></li>
                    <li class="divider"></li>
                    <li><a href="#" class="text-center">View All</a></li>
                </ul>
            </li>
            <li class="dropdown" style="margin-right: 10px"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $_SESSION['username'] ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span>&nbsp;Logout</a></li>
                </ul>
            </li>
        </ul>

        <!--Date and time func-->
        <ul>
            <?php
            echo date("F d, Y h:i A") . "<br>";
            ?>
        </ul>
    </div>
</div>
<div class="container-fluid" style="padding: 0px;margin-left: 0px">
    <div class="row">
