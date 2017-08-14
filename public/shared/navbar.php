<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <ul>
                <li><a class="navbar-brand" href=".">Profile Hub</a></li>
            </ul>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right " >
                <?php  if (isset($_SESSION['username'])) : ?>
                    <?php  if ($_SESSION['isAdmin'] == true) : ?>
                        <li><a href="clients.php"><button type="button" class="btn btn-primary btn-block ">View Clients</button></a></li>
                    <?php endif ?>
                     <li><a href="editProfile.php"><button type="button" class="btn btn-primary btn-block ">Edit Profile</button></a></li>
                    <li><a href="index.php?logout=1"><button type="button" class="btn btn-danger btn-block " >Log Out</button></a></li>
                
                <?php else : ?>
                    <li><a href="clientApplication.php"><button type="button" class="btn btn-danger btn-block ">Request API Access</button></a></li>
                    <li><a href="login.php"><button type="button" class="btn btn-success btn-block ">Log In</button></a></li>
                    <li><a href="signup.php"><button type="button" class="btn btn-primary btn-block ">Sign Up</button></a></li>
                <?php endif ?> 
            </ul>   
        </div>
    </div>
</nav>

