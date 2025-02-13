<?php
    if(isset($_SESSION['message'])) :
?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert"></div>
    <strong>Hey!</strong> <?= $_SESSION['message']; ?>
      <a href="index.php">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </a>
    </div>

<?php 
    unset($_SESSION['message']);
    endif;
?>