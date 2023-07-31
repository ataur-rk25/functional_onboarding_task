<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("location:login.php");
} else {
  include('db.php');

  if (isset($_SESSION['user_id'])) {
    $user_id  = $_SESSION['user_id'];
  }
  if (isset($_SESSION['user_email'])) {
    $user_email  = $_SESSION['user_email'];
  }

  // Prepare and execute the SQL query
  $stmt = $mysqli->prepare("SELECT name, email, username, phone, user_role, profile_pic_path FROM users WHERE id = ? OR email = ?");
  $stmt->bind_param("ss", $user_id, $user_email);
  $stmt->execute();
  $stmt->bind_result($name, $email, $username, $phone, $user_role, $profile_pic);
  $stmt->fetch();
  $stmt->close();
  $mysqli->close();

  if (!empty($profile_pic)) :
    $imageFileName = basename($profile_pic);
  endif;

  $title = 'My Profile';
  include('header.php');
?>
  <div class="container">
    <div class="row">
      <p style="text-align:right">
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') { ?>
          <a href="user_list.php"><i class="fa fa-user"></i>&nbsp;&nbsp;User List</a>&nbsp;&nbsp;&nbsp;
        <?php } ?>
        <a href="logout.php"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Logout</a>
      </p>
      <h2 class="pagetitle"><?php echo $title; ?></h2>
      <?php if (!empty($profile_pic)) : ?>
        <div class="profile_pic">
          <img class="profile_preview" src="<?php echo $profile_pic; ?>" alt="Profile Preview" />
        </div>
        <br>
      <?php endif; ?>
      <table>
        <tbody>
          <tr>
            <td>Username:</td>
            <td><?php if (!empty($username)) : echo $username;
                endif; ?></td>
          </tr>
          <tr>
            <td>Name:</td>
            <td><?php if (!empty($name)) : echo $name;
                endif; ?></td>
          </tr>
          <tr>
            <td>Email:</td>
            <td><?php if (!empty($email)) : echo $email;
                endif; ?></td>
          </tr>
          <tr>
            <td>Phone:</td>
            <td><?php if (!empty($phone)) : echo $phone;
                endif; ?></td>
          </tr>
          <tr>
            <td>Role:</td>
            <td><?php if (!empty($user_role)) : echo $user_role;
                endif; ?></td>
          </tr>
        </tbody>
      </table>
      <br>
      <a class="form-btn" id="edit_my_details" href="javascript:void(0)">Edit</a>
    </div>
    <div class="row">
      <?php
      if (isset($_SESSION['success_message'])) {
        echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
        unset($_SESSION['success_message']);
      }
      if (isset($_SESSION['error_message'])) {
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        unset($_SESSION['error_message']);
      }
      ?>
      <form id="edit_user_form" action="edit_process.php" method="post" style="display:none" onsubmit=" return validateFormEdit()" enctype="multipart/form-data">
        <small>Note: Username cannot be changed</small>
        <div class="form-group-row d-flex">
          <div class="form-group flex-50">
            <input class="form_input" type="text" name="username" id="username" placeholder="Username*" value="<?php if (!empty($username)) : echo $username;
                                                                                                                endif; ?>" disabled>
            <p class="error_message" id="username_error" style="color: red;"></p>
          </div>
          <div class="form-group flex-50">
            <input class="form_input" type="text" name="name" id="name" placeholder="Name*" value="<?php if (!empty($name)) : echo $name;
                                                                                                    endif; ?>">
            <p class="error_message" id="name_error" style="color: red;"></p>
          </div>
        </div>
        <div class="form-group-row d-flex">
          <div class="form-group flex-50">
            <input class="form_input" type="email" name="email" id="email" placeholder="Email*" pattern="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/" value="<?php if (!empty($email)) : echo $email;
                                                                                                                                                                    endif; ?>">
            <p class="error_message" id="email_error" style="color: red;"></p>
          </div>
          <div class="form-group flex-50">
            <input class="form_input" type="tel" name="phone" id="phone" placeholder="Phone" maxlength="20" value="<?php if (!empty($phone)) : echo $phone;
                                                                                                                    endif; ?>">
            <p class="error_message" id="phone_error" style="color: red;"></p>
          </div>
        </div>
        <div class="form-group-row d-flex">
          <div class="form-group flex-50">
            <div class="password-wrapper">
              <input class="form_input" type="password" name="password" id="password" placeholder="******">
            </div>
            <p class="error_message" id="password_error" style="color: red;"></p>
          </div>
          <div class="form-group flex-50">
            <input class="form_input" type="text" name="confirm_password" id="confirm_password" placeholder="******">
            <p class="error_message" id="confirm_password_error" style="color: red;"></p>
          </div>
        </div>
        <div class="form-group-row d-flex">
          <div class="form-group flex-50">
            <div class="file-upload-container">
              <label for="profile_pic_input" class="file-upload-label" id="profile-file-name">
                <?php if (!empty($profile_pic)) : echo $imageFileName; ?>
                <?php else : ?>
                  Choose Profile Picture
                <?php endif; ?>
              </label>
              <input class="form_input" type="file" id="profile_pic_input" name="profile_pic_input" accept="image/*">
              <i class="fa fa-upload input_icons"></i>
            </div>

            <div id="profile-file-name-error">
              <?php if (empty($profile_pic)) : echo 'No File Selected';
              endif; ?>
            </div>
            <p class="error_message" id="profile_img_error" style="color: red;"></p>

            <div id="profile_preview_wrapper" <?php if (!empty($profile_pic)) : echo 'style="display:block;"';
                                              endif; ?>>
              <span class="profile-remove-icon"><i id="removeImagePreview" class="fa fa-close"></i></span>
              <div id="profile_pic" class="profile_pic">
                <img id="profile_preview" class="profile_preview" src="<?php if (!empty($profile_pic)) : echo $profile_pic;
                                                                        endif; ?>" alt="Profile Preview" />
              </div>
            </div>
          </div>
          <div class="form-group flex-50">

          </div>
        </div>
        <div class="form-group-row d-flex">
          <div class="form-group flex-50">
            <input type="submit" value="update" class="form-btn">
          </div>
        </div>
        <input type="hidden" value="<?php echo $user_id; ?>" name="user_id">
      </form>
    </div>
  </div>
  <?php
  include('footer.php');
  ?>
<?php
}
