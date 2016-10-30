<?php
    session_start();
    $adminid = $_SESSION['AUTH_USER_ID'];
    if ($adminid == null) {
        $_SESSION['alert']['message_type'] = "alert-danger";
        $_SESSION['alert']['message_title'] = "Not logged in..";
        $_SESSION['alert']['message'] = " Please authenticate to regain access";
        header('Location: login.php');
        exit();
    }
    
    echo var_dump($_PARENT);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $_TITLE ?></title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="css/custom-table-styles.css" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.11.0/bootstrap-table.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php"><span>WPBTS</span>Admin</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="php/form-handler-logout.php"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>

		</div><!-- /.container-fluid -->
	</nav>

	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<ul class="nav menu">
                        <li class="<?php if(isset($_PARENT['events'])){ echo "active"; } ?>"><a href="events.php"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> Event Management</a></li>
			<li class="<?php if(isset($_PARENT['clinics'])){ echo "active"; } ?>"><a href="clinics.php"><svg class="glyph stroked clipboard-with-paper"><use xlink:href="#stroked-clipboard-with-paper"></use></svg> Clinic Management</a></li>
			<li class="<?php if(isset($_PARENT['users'])){ echo "active"; } ?>"><a href="users.php"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> User Management</a></li>
			<li class="<?php if(isset($_PARENT['alerts'])){ echo "active"; } ?>"><a href="alerts.php"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Alert Management</a></li>

			<li role="presentation" class="divider"></li>
			<li><a href="login.php"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
		</ul>

	</div><!--/.sidebar-->
		
	
