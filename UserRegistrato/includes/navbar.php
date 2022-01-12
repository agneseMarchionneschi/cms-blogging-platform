
<header>
  <nav class="navbar navbar-expand-lg navbar-dark   bg-dark">  
	  <a class="navbar-brand" href="dashboard.php">Onblog - Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
      
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
	 <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="dashboard.php">Home<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item px-2">
        <a class="nav-link"href="all_blogs.php">Blog</a>
      </li>
      <li class="nav-item px-2">
        <a class="nav-link" href="all_post.php">Posts</a>
      </li>
    <?php if(isset($_SESSION['user']['id'])): ?> 
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['user']['username']; ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item"  href="my_blogs.php">myBlogs</a>
          <a class="dropdown-item"  href="user.php">Account</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php" class="logout-btn">Logout</a>
          </div>
      </li>
      </div>


    <?php else : ?> 
      <li><a href="<?php echo BASE_URL . "/register.php" ?>">Sign Up</a></li>
      <li><a href="<?php echo BASE_URL . "/login.php" ?>">Login</a></li>
    <?php endif; ?>
  </ul>

</header>




