<?php include 'setting/system.php'; ?>
<?php include 'theme/head.php';

if (isset($_SESSION['USER_ID']) && isset($_SESSION['USER_NAME']) && isset($_SESSION['USER_EMAIL'])) {
  ?>
  <script>
    window.location.href = "index.php?page=product"
  </script>
  <?php 
}else if(isset($_SESSION['id']) && isset($_SESSION['name']) && isset($_SESSION['user'])){
  ?>
  <script>
    window.location.href = "dashboard.php"
  </script>
  <?php 
}
// echo password_hash("chadrhino@@@2024", PASSWORD_DEFAULT);
?>

<div class="container">
	<div class="row" style="margin-top: 10%">

		<h1 class="text-center"><?php echo NAME_X; ?></h1><br>
   <div class="col-md-2 col-md-offset-2">
     <img src="img/pig.png" class="img img-responsive">
   </div>
		<div class="col-md-4">
			<form method="post" autocomplete="off">
				<div class="form-group">
				   <label class="control-label">Email</label>
				   <input type="email" name="username" class="form-control input-sm" required>
			    </div>

			    <div class="form-group" >
				   <label class="control-label">Password</label>
				   <div style="position: relative;">
           <input type="password" name="password" class="form-control input-sm" required>
           <i class="fa fa-eye" id="showPass" style="position: absolute; top: 7px; right:10px;cursor: pointer;"></i>
           </div>
			    </div>
                
			    <div style="display: flex; gap: 20px; justify-content: space-between; align-items: center;">
          <button name="submit" type="submit" class="btn btn-md btn-dark">Log in</button>
          <a href="forgot.php">Forgot Password</a>
          </div>

          <p style="margin-top: 20px;">Don't have an account? <a href="signup.php">Sign Up</a></p>
			</form>

			<?php
              if (isset($_POST['submit'])) {
              	$username = htmlspecialchars(stripslashes(trim($_POST['username'])));
              	$password = htmlspecialchars(stripslashes(trim($_POST['password'])));

              	// $hash = sha1($password);
                
                $get_admin = $db->prepare("SELECT * FROM admin WHERE username = :uname");
                $get_admin->bindParam(':uname', $username, PDO::PARAM_STR);
                $get_admin->execute();

                if ($get_admin->rowCount() > 0) {
                  $row = $get_admin->fetch(PDO::FETCH_OBJ);
                  if (password_verify($password, $row->password)) {
                    $user_id = $row->id;
                     $user_name = $row->name;
                     $user = $row->username;

                     $_SESSION['id'] = $user_id;
                     $_SESSION['name'] = $user_name;
                     $_SESSION['user'] = $user;
                     ?>
                                <script>
                                    const Toast = Swal.mixin({
                                        toast: true,
                                        position: "top-end",
                                        showConfirmButton: false,
                                        timer: 1500,
                                        timerProgressBar: true,
                                        didOpen: (toast) => {
                                            toast.onmouseenter = Swal.stopTimer;
                                            toast.onmouseleave = Swal.resumeTimer;
                                        }
                                    });

                                    Toast.fire({
                                        icon: "success",
                                        title: "Account signed in successfully"
                                    }).then(()=>{
                                      window.location.href = "dashboard.php"
                                    });
                                </script>
                            <?php
                  }
                }else{
                  $get_user = $db->prepare("SELECT * FROM users WHERE email = :email");
                  $get_user->bindParam(':email', $username, PDO::PARAM_STR);
                  $get_user->execute();
                  
                  if ($get_user->rowCount() > 0) {
                    $row = $get_user->fetch(PDO::FETCH_OBJ);
                    if (password_verify($password, $row->password)) {
                      $user_id = $row->id;
                       $user_name = $row->name;
                       $user = $row->email;
  
                       $_SESSION['USER_ID'] = $user_id;
                       $_SESSION['USER_NAME'] = $user_name;
                       $_SESSION['USER_EMAIL'] = $user;
                       ?>
                                  <script>
                                      const Toast = Swal.mixin({
                                          toast: true,
                                          position: "top-end",
                                          showConfirmButton: false,
                                          timer: 1500,
                                          timerProgressBar: true,
                                          didOpen: (toast) => {
                                              toast.onmouseenter = Swal.stopTimer;
                                              toast.onmouseleave = Swal.resumeTimer;
                                          }
                                      });
  
                                      Toast.fire({
                                          icon: "success",
                                          title: "Account signed in successfully"
                                      }).then(()=>{
                                        window.location.href = "index.php?page=product"
                                      });
                                  </script>
                              <?php
                    }else{
                      ?>
                                  <script>
                                      const Toast = Swal.mixin({
                                          toast: true,
                                          position: "top-end",
                                          showConfirmButton: false,
                                          timer: 1500,
                                          timerProgressBar: true,
                                          didOpen: (toast) => {
                                              toast.onmouseenter = Swal.stopTimer;
                                              toast.onmouseleave = Swal.resumeTimer;
                                          }
                                      });
  
                                      Toast.fire({
                                          icon: "error",
                                          title: "Incorrect email or password"
                                      });
                                  </script>
                              <?php
                    }
                  }

                }
                

              }


            if(isset($error)){ ?>
            <br><br>
               <div class="alert alert-danger alert-dismissable">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong><?php echo $error; ?>.</strong>
              </div>
            <?php }
			?>


		</div>
	</div>
</div>

<script>
  let password = document.querySelector("input[name='password']")
  let showPass = document.getElementById("showPass")

  showPass.onclick = () =>{
    if (password.getAttribute("type") == 'password') {
      password.setAttribute("type", "text")
      showPass.classList.replace("fa-eye", "fa-eye-slash")
    }else{
      password.setAttribute("type", "password")
      showPass.classList.replace("fa-eye-slash","fa-eye")
    }
  }

</script>


<?php include 'theme/foot.php'; ?>
