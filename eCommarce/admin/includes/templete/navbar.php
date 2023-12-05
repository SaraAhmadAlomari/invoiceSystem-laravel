<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link " aria-current="page" href="dashboard.php"> <?php echo lang('HOME_ADMIN') ?> </a></li>
        <li class="nav-item"><a class="nav-link " aria-current="page" href="categories.php"> <?php echo lang('CATEGORIES') ?> </a></li>
        <li class="nav-item"><a class="nav-link " aria-current="page" href="items.php"> <?php echo lang('ITEMS') ?> </a></li>
        <li class="nav-item"><a class="nav-link " aria-current="page" href="members.php"> <?php echo lang('MEMBERS') ?> </a></li>
        <li class="nav-item"><a class="nav-link " aria-current="page" href="comments.php"> <?php echo lang('COMMENTS') ?> </a></li>
       </ul>

       <ul class="navbar-nav me-5 mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Sarah
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['ID'] ?>">Edit Profile</a></li>
            <li><a class="dropdown-item" href="#">Setting</a></li>
            <li><a class="dropdown-item" href="../index.php">Vist Shop</a></li>
            <li><a class="dropdown-item" href="logout.php">logout</a></li>
          </ul>
        </li>
      
        </ul>
      
    </div>
  </div>
</nav>