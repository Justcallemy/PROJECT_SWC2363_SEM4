<?php
include 'config.php';
session_start();
$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `admin` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_account.php');
}

$search_value = "";
if(isset($_POST['search'])){
   $search_value = $_POST['search_value'];
   $query = "SELECT * FROM `admin` WHERE name LIKE '%$search_value%' OR email LIKE '%$search_value%'";
} else {
   $query = "SELECT * FROM `admin`";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="users">

   <h1 class="title"> admin accounts </h1>

   <div class="search-box">
   <form method="POST" class="search-form">
      <input type="text" name="search_value" placeholder="Search..." value="<?php echo $search_value; ?>">
      <button type="submit" name="search"><i class="fas fa-search"></i></button>
   </form>
   </div>

   <div class="show-all">
   <a href="admin_account.php" class="show-all-btn">Display all admin accounts</a>
   </div>

   <div class="box-container">
      
      <?php
         $select_admins = mysqli_query($conn, $query) or die('query failed');
         while($fetch_admins = mysqli_fetch_assoc($select_admins)){
      ?>
      <div class="box">
         <div class="icon-user"><i class="fa-solid fa-user-tie"></i></div>
         <p> admin id : <span><?php echo $fetch_admins['id']; ?></span> </p>
         <p> username : <span><?php echo $fetch_admins['name']; ?></span> </p>
         <p> email : <span><?php echo $fetch_admins['email']; ?></span> </p>
         <a href="admin_users.php?delete=<?php echo $fetch_admins['id']; ?>" onclick="return confirm('delete this admin?');" class="delete-btn">delete admin</a>
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
