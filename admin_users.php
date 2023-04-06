<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

$search_value = "";
if(isset($_POST['search'])){
   $search_value = $_POST['search_value'];
   $query = "SELECT * FROM `users` WHERE name LIKE '%$search_value%' OR email LIKE '%$search_value%'";
} else {
   $query = "SELECT * FROM `users`";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> user accounts </h1>

   <div class="search-box">
   <form method="POST" class="search-form">
      <input type="text" name="search_value" placeholder="Search..." value="<?php echo $search_value; ?>">
      <button type="submit" name="search"><i class="fas fa-search"></i></button>
   </form>
   </div>

   <div class="show-all">
   <a href="admin_users.php" class="show-all-btn">Display all user accounts</a>
   </div>

   <div class="box-container">
      <?php
         $select_users = mysqli_query($conn, $query) or die('query failed');
         while($fetch_users = mysqli_fetch_assoc($select_users)){
      ?>
      <div class="box">
         <div class="icon-user"><i class="fa-solid fa-user"></i></div>
         <p> user id : <span><?php echo $fetch_users['id']; ?></span> </p>
         <p> username : <span><?php echo $fetch_users['name']; ?></span> </p>
         <p> email : <span><?php echo $fetch_users['email']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('delete this user?');" class="delete-btn">delete user</a>
      </div>
      <?php
         };
      ?>
   </div>

</section>

<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>
