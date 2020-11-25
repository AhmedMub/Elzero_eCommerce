<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php"><?php echo lang('dashboard');?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#"><?php echo lang('Admin');?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="#"><?php echo lang('Categories');?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="#"><?php echo lang('ITEMS');?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="#"><?php echo lang('MEMBERS');?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="#"><?php echo lang('STATISTICS');?></a>
        </li>
        <li class="nav-item">
        <a class="nav-link" aria-current="page" href="#"><?php echo lang('LOGS');?></a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="true">
          <?php echo lang('admin_name');?>
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="members.php?do=Edit&userId=<?php echo $_SESSION['ID'];?>"><?php echo lang('nav_edit');?></a></li>
            <li><a class="dropdown-item" href="#"><?php echo lang('nav_settings');?></a></li>
            <li><a class="dropdown-item" href="logout.php"><?php echo lang('nav_logout');?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>