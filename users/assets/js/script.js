document.addEventListener("DOMContentLoaded", function() {

    var passwordInput = document.getElementById("password");
    var confirmInput = document.getElementById("confirm_password");
    var emailInput = document.getElementById("email");
    var phoneInput = document.getElementById('phone');
    var passwordVisibilityIcon = document.getElementById("eye-icon");
    var removeImagePreviewIcon = document.getElementById("removeImagePreview");

    // Password
    if (document.body.contains(passwordInput)){
        passwordInput.addEventListener("keyup", function() {
            validatePassword(passwordInput.value);
        });
    }
    if(document.body.contains(confirmInput)){
        confirmInput.addEventListener("keyup", function() {
            confirmPassword(passwordInput.value, confirmInput.value);
        });
    }

     //Email
    if(document.body.contains(emailInput)){
        emailInput.addEventListener("keyup", function() {
            validateEmail(emailInput.value);
        });
    }

    //phone
    if(document.body.contains(phoneInput)){
        phoneInput.addEventListener('input', function() {
            removeChars(phoneInput);
        });  
    }

    //password visibility
    if(document.body.contains(passwordVisibilityIcon)){
        passwordVisibilityIcon.addEventListener('click', function() {
            togglePasswordVisibility(passwordInput, passwordVisibilityIcon);
        });    
    }

    //profile pic
    var fileInput = document.getElementById("profile_pic_input");
    var imgPreviewWrapper = document.getElementById("profile_preview_wrapper");
    var imgPreview = document.getElementById("profile_preview");
    var imgFileName = document.getElementById("profile-file-name");
    var imgFileNameError = document.getElementById("profile-file-name-error");

    if(document.body.contains(fileInput)){
    
    fileInput.addEventListener("change", function () {
        var file = fileInput.files[0];
        var allowedTypes = ["image/jpeg", "image/png", "image/gif"];
        var maxSizeInBytes = 2 * 1024 * 1024; // 2 MB

        if (file) {
            //check file type
            if (!allowedTypes.includes(file.type)) {
                document.querySelector("#profile_img_error").innerText = "Please upload a valid image file (JPEG, PNG, or GIF).";
                fileInput.value = "";
                imgPreviewWrapper.style.display = "none";
                imgFileNameError.innerText = "No file selected";
                return;
            }

            // Check file size
            if (file.size > maxSizeInBytes) {
                document.querySelector("#profile_img_error").innerText = "File size exceeds the limit of 2 MB.";
                fileInput.value = "";
                imgPreviewWrapper.style.display = "none";
                imgFileNameError.innerText = "No file selected";
                return;
            }
    
            // Display the image preview
            var reader = new FileReader();
            reader.addEventListener("load", function () {
                imgPreview.src = reader.result;
                imgPreviewWrapper.style.display = "block";
            });
            reader.readAsDataURL(file);
            imgFileName.innerText = file.name;
            imgFileNameError.innerText = "";
        } else {
            imgPreview.src = "#";
            imgPreviewWrapper.style.display = "none";
        }
    });
    }
     //image visibility
     if(document.body.contains(removeImagePreviewIcon)){
        removeImagePreviewIcon.addEventListener('click', function() {
            removeImagePreview(fileInput,imgPreviewWrapper,imgPreview,imgFileName,imgFileNameError);
        }); 
     }
});

function validatePassword(password) {
    var passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%()]).{6,}$/;

    // Password validation
    if (!passwordPattern.test(password)) {
        document.querySelector("#password_error").innerText = "Password does not match criteria";
        return false;
    } else {
        document.querySelector("#password_error").innerText = "";
        return true;
    }
}

function confirmPassword(password, confirm_password) {
    // Password confirmation validation
    if (password !== confirm_password) {
        document.querySelector("#confirm_password_error").innerText = "Passwords do not match.";
        return false;
    } else {
        document.querySelector("#confirm_password_error").innerText = "";
        return true;
    }
}

function togglePasswordVisibility(passwordInput,passwordVisibility) {
    
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        passwordVisibility.classList.add("fa-eye-slash");
        passwordVisibility.classList.remove("fa-eye");
    } else {
        passwordInput.type = "password";
        passwordVisibility.classList.add("fa-eye");
        passwordVisibility.classList.remove("fa-eye-slash");
    }
}

function validateEmail(email) {
    var emailValid = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!emailValid.test(email)) {
        document.querySelector("#email_error").innerText = "Email ID is not valid";
        return false;
    } else {
        document.querySelector("#email_error").innerText = "";
    }
    return true;
}

function removeChars(phoneInput){
    phoneInput.value = phoneInput.value.replace(/[^0-9]/g, '');
}


function validateForm() {
    var username = document.getElementById("username").value;
    var name = document.getElementById("name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;

    if (username === "" || name === "" || email === "") {        
        document.querySelectorAll("#username_error,#name_error,#email_error").forEach(function(element) {
            element.innerText = "All fields are required.";        
        });
        return false;        
    }

    var isPasswordValid = validatePassword(password, confirm_password);
    if (!isPasswordValid) {
        return false;
    }

    var isPasswordSame = confirmPassword(password, confirm_password);
    if (!isPasswordSame) {
        return false;
    }
    
    var isEmailValid = validateEmail(email);    
    if (!isEmailValid) {
        return false;
    }

    // Clear the error message if everything is valid
    document.querySelector(".error_message").innerText = "";
    return true; // If all validations pass, the form can be submitted
}

function validateFormEdit() {
    // Fetch only the necessary fields for edit form validation
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var email = document.getElementById("email").value;

    // Perform validation only if the fields contain values
    if (password) {
        var isPasswordValid = validatePassword(password, confirm_password);
        if (!isPasswordValid) {
            return false;
        }
    }

    if (confirm_password) {
        var isPasswordSame = confirmPassword(password, confirm_password);
        if (!isPasswordSame) {
            return false;
        }
    }

    if (email) {
        var isEmailValid = validateEmail(email);
        if (!isEmailValid) {
            return false;
        }
    }

    // Clear the error message if everything is valid
    document.querySelector(".error_message").innerText = "";
    return true; // If all validations pass, the form can be submitted
}

function removeImagePreview(fileInput,imgPreviewWrapper,imgPreview,imgFileName,imgFileNameError) {
    fileInput.value = ""; 
    imgPreview.src = "#"; 
    imgPreviewWrapper.style.display = "none";
    imgFileName.innerText = "Choose Profile Picture";
    imgFileNameError.innerText = "No file selected"; 
}

        

        jQuery(document).on("click", "#edit_my_details", function() {
            jQuery('#edit_user_form').toggle();
            var editFormOffset = jQuery("#edit_user_form").offset().top;
            jQuery("html, body").animate({ scrollTop: editFormOffset }, 1000);
        });


        function loadUserTable() {
            $.ajax({
                url: "get_users.php",
                method: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    let tableHTML = `
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <tbody>`;
                    data.forEach(row => {
                        tableHTML += `
                        <tr>
                            <td>${row.id}</td>
                            <td>${row.username}</td>
                            <td>${row.name}</td>
                            <td>${row.email}</td>
                            <td>${row.phone}</td>
                            <td>${row.user_role}</td>
                            <td>
                                <a href="#" id="edit" data-id="${row.id}">Edit</a>&nbsp;&nbsp;
                                <a href="javascript:void(0)" id="delete" data-id="${row.id}">Delete</a>
                            </td>
                        </tr>`;
                    });
                    tableHTML += `</tbody></table>`;
                    $("#users_list").html(tableHTML);
                }
            });
        }

        jQuery(document).on("click", "#delete", function() {
            var userId = $(this).data("id");
            $.ajax({
                url: "delete.php?id=" + userId,
                method: "GET",
                success: function(response) {
                    console.log(response);
                    jQuery('#action_message').text(response);
                    window.location.href = 'user_list.php';
                    loadUserTable();
                }
            });
        });

        jQuery(document).on("click", "#edit,#add", function() {
            var btntext = $(this).attr('id');
            if(btntext == "add"){
                window.location.href = "add_edit_user.php?action=add";
            }
            if(btntext == "edit"){
                var userId = $(this).data("id");
                window.location.href = `add_edit_user.php?action=edit&uid=${userId}`;
            }
        });
    
