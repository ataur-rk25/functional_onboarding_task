<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("location:login.php");
} else {
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        if (isset($_GET["action"])) {
            $action = $_GET["action"];
        }
        if (isset($_GET["uid"])) {
            $uid = $_GET["uid"];
        }

        if ($action == "add") {
            $title = 'Add User';
        }
        if ($action == "edit") {
            $title = 'Edit User';
            include('db.php');

            $stmt = $mysqli->prepare("SELECT* FROM users WHERE id = ?");
            $stmt->bind_param("s", $uid);
            $stmt->execute();
            $result = $stmt->get_result();
            $usersList = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            $mysqli->close();
            foreach ($usersList as $user) {
                $userdetails = $user;
            }

            $profile_pic = $userdetails['profile_pic_path'];
            if (!empty($profile_pic)) :
                $imageFileName = basename($profile_pic);
            endif;
            //print_r($userdetails);
        }
        include('header.php');
?>
        <div class="container">
            <div class="row">
                <h2 class="pagetitle"><?php echo $title; ?></h2>
                <p style="text-align:right"><a href="user_list.php"><i class="fa fa-chevron-left"></i> Back to User List</a>
            </div>
            <div class="row">
                <?php
                if (isset($_SESSION['success_message'])) {
                    if ($action == 'add') {
                        echo '<p style="color: green;">User added successfully</p>';
                        unset($_SESSION['success_message']);
                    } else if ($action == 'edit') {
                        echo '<p style="color: green;">User updated successfully</p>';
                        unset($_SESSION['success_message']);
                    } else {
                        echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
                        unset($_SESSION['success_message']);
                    }
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                    unset($_SESSION['error_message']);
                }
                ?>
                <?php if ($action == "add") { ?>
                    <form id="register_form" action="register_process.php" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
                    <?php } ?>
                    <?php if ($action == "edit") { ?>
                        <form id="edit_user_form" action="edit_process.php" method="post" enctype="multipart/form-data" onsubmit=" return validateFormEdit();">
                            <small>Note: Username cannot be changed</small>
                        <?php } ?>
                        <div class="form-group-row d-flex">
                            <div class="form-group flex-50">
                                <input class="form_input" type="text" name="username" id="username" placeholder="Username*" value="<?php if (!empty($userdetails['username'])) : echo $userdetails['username'];
                                                                                                                                    endif; ?>" <?php if ($action == "edit") {
                                                                                                                                                    echo 'disabled';
                                                                                                                                                } ?>>

                                <p class="error_message" id="username_error" style="color: red;"></p>
                            </div>
                            <div class="form-group flex-50">
                                <input class="form_input" type="text" name="name" id="name" placeholder="Name*" value="<?php if (!empty($userdetails['name'])) : echo $userdetails['name'];
                                                                                                                        endif; ?>">
                                <p class="error_message" id="name_error" style="color: red;"></p>
                            </div>
                        </div>
                        <div class="form-group-row d-flex">
                            <div class="form-group flex-50">
                                <input class="form_input" type="email" name="email" id="email" placeholder="Email*" pattern="/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/" value="<?php if (!empty($userdetails['email'])) : echo $userdetails['email'];
                                                                                                                                                                                        endif; ?>">
                                <p class="error_message" id="email_error" style="color: red;"></p>
                            </div>
                            <div class="form-group flex-50">
                                <input class="form_input" type="tel" name="phone" id="phone" placeholder="Phone" maxlength="20" value="<?php if (!empty($userdetails['phone'])) : echo $userdetails['phone'];
                                                                                                                                        endif; ?>">
                                <p class="error_message" id="phone_error" style="color: red;"></p>
                            </div>
                        </div>
                        <div class="form-group-row d-flex">
                            <div class="form-group flex-50">
                                <div class="password-wrapper">
                                    <input class="form_input" type="password" name="password" id="password" <?php if ($action == "add") {
                                                                                                                echo 'placeholder="password*"';
                                                                                                            }
                                                                                                            if ($action == "edit") {
                                                                                                                echo 'placeholder="******"';
                                                                                                            } ?>>
                                    <?php if ($action == "add") {
                                        echo '<i class="fa fa-eye input_icons" id="eye-icon"></i>';
                                    } ?>
                                </div>
                                <p class="error_message" id="password_error" style="color: red;"></p>
                            </div>
                            <div class="form-group flex-50">
                                <input class="form_input" type="text" name="confirm_password" id="confirm_password" <?php if ($action == "add") {
                                                                                                                        echo 'placeholder="Confirm password*"';
                                                                                                                    } ?> <?php if ($action == "edit") {
                                                                                                                                echo 'placeholder="******"';
                                                                                                                            } ?>>
                                <p class="error_message" id="confirm_password_error" style="color: red;"></p>
                            </div>
                        </div>
                        <div class="form-group-row d-flex">
                            <div class="form-group flex-50">
                                <select name="user_role" id="user_role" class="user_role">
                                    <option value="subscriber" <?php if (!empty($userdetails['user_role'])) :
                                                                    echo ($userdetails['user_role'] === 'subscriber') ? 'selected' : '';
                                                                endif; ?>>Subscriber</option>
                                    <option value="admin" <?php if (!empty($userdetails['user_role'])) :
                                                                echo ($userdetails['user_role'] === 'admin') ? 'selected' : '';
                                                            endif; ?>>Admin</option>
                                </select>
                                <p class="error_message" id="email_error" style="color: red;"></p>
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
                                <input type="submit" value="<?php echo $title; ?>" class="form-btn">
                            </div>
                        </div>
                        <?php if ($action == "edit") { ?>
                            <input type="hidden" value="<?php echo $uid; ?>" name="user_id">
                        <?php } ?>
                        </form>
            </div>
        </div>
        <?php
        include('footer.php');
        ?>
<?php
    } else {
        header("Location: user_profile.php");
        exit();
    }
}
