var usernameInput = document.getElementById("username"),
  nameInput = document.getElementById("name"),
  passwordInput = document.getElementById("password"),
  confirmInput = document.getElementById("confirm_password"),
  emailInput = document.getElementById("email"),
  phoneInput = document.getElementById("phone"),
  passwordVisibilityIcon = document.getElementById("eye-icon"),
  removeImagePreviewIcon = document.getElementById("removeImagePreview"),
  fileInput = document.getElementById("profile_pic_input"),
  imgPreviewWrapper = document.getElementById("profile_preview_wrapper"),
  imgPreview = document.getElementById("profile_preview"),
  imgFileName = document.getElementById("profile-file-name"),
  imgFileNameError = document.getElementById("profile-file-name-error"),
  imgFileInputError = document.querySelector("#profile_img_error"),
  editButton = document.getElementById("edit_my_details");

document.addEventListener("DOMContentLoaded", function () {
  //username
  if (document.body.contains(usernameInput)) {
    usernameInput.addEventListener("keyup", function () {
      validateUserName(usernameInput.value);
    });
  }

  //name
  if (document.body.contains(nameInput)) {
    nameInput.addEventListener("keyup", function () {
      validateName(nameInput.value);
    });
  }

  // Password
  if (document.body.contains(passwordInput)) {
    passwordInput.addEventListener("keyup", function () {
      validatePassword(passwordInput.value);
    });
  }
  if (document.body.contains(confirmInput)) {
    confirmInput.addEventListener("keyup", function () {
      confirmPassword(passwordInput.value, confirmInput.value);
    });
  }

  //Email
  if (document.body.contains(emailInput)) {
    emailInput.addEventListener("keyup", function () {
      validateEmail(emailInput.value);
    });
  }

  //phone
  if (document.body.contains(phoneInput)) {
    phoneInput.addEventListener("input", function () {
      removeChars(phoneInput);
    });
  }

  //password visibility
  if (document.body.contains(passwordVisibilityIcon)) {
    passwordVisibilityIcon.addEventListener("click", function () {
      togglePasswordVisibility(passwordInput, passwordVisibilityIcon);
    });
  }

  //profile pic
  if (document.body.contains(fileInput)) {
    fileInput.addEventListener("change", function () {
      removeClassAndClearText();
      var file = fileInput.files[0],
        allowedTypes = ["image/jpeg", "image/png", "image/gif"],
        maxSizeInBytes = 2 * 1024 * 1024; // 2 MB

      if (file) {
        //check file type
        if (!allowedTypes.includes(file.type)) {
          imgFileInputError.innerText =
            "Please upload a valid image file (JPEG, PNG, or GIF).";
          imgFileName.classList.add("input_error");
          fileInput.value = "";
          imgPreviewWrapper.style.display = "none";
          imgFileNameError.innerText = "No file selected";
          return;
        }

        // Check file size
        if (file.size > maxSizeInBytes) {
          imgFileInputError.innerText = "File size exceeds the limit of 2 MB.";
          imgFileName.classList.add("input_error");
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
        imgFileInputError.innerText = "";
        imgFileName.classList.remove("input_error");
      } else {
        imgPreview.src = "#";
        imgPreviewWrapper.style.display = "none";
      }
    });
  }

  //image visibility
  if (document.body.contains(removeImagePreviewIcon)) {
    removeImagePreviewIcon.addEventListener("click", function () {
      removeImagePreview(
        fileInput,
        imgPreviewWrapper,
        imgPreview,
        imgFileName,
        imgFileNameError
      );
    });
  }

  //user edit form

  if (document.body.contains(editButton)) {
    editButton.addEventListener("click", function () {
      var editForm = document.getElementById("edit_user_form");
      editForm.style.display =
        editForm.style.display === "none" ? "block" : "none";
      editForm.scrollIntoView({
        behavior: "smooth",
      });
    });
  }

  if (window.location.pathname === "/users/user_list.php") {
    loadUserTable();
  }

  /*var allInputs = document.querySelectorAll("input.form_input");
  allInputs.forEach(function (input) {
    if (document.body.contains(input)) {
      input.addEventListener("keyup", function () {
        removeErrorClassAndClearErrorText();
      });
    }
  });*/
});

/*function removeErrorClassAndClearErrorText() {
  var elements = document.querySelectorAll(".form_input");

  elements.forEach(function (element) {
    element.classList.remove("input_error");
  });

  document.querySelector(".error_message").innerText = "";
}*/

function validateUserName(username) {
  var userNameValid = /^[A-Za-z0-9]+$/;

  if (!userNameValid.test(username)) {
    console.log("if");
    document.getElementById("username_error").innerText =
      "Username is not valid, should contain only alphabets and numbers";
    usernameInput.classList.add("input_error");
    return false;
  } else {
    document.querySelector("#username_error").innerText = "";
    usernameInput.classList.remove("input_error");
    return true;
  }
}

function validateName(name) {
  var nameValid = /^[A-Za-z\s]+$/;

  if (!nameValid.test(name)) {
    document.querySelector("#name_error").innerText =
      "Name is not valid, should contain only alphabets and space";
    nameInput.classList.add("input_error");
    return false;
  } else {
    document.querySelector("#name_error").innerText = "";
    nameInput.classList.remove("input_error");
    return true;
  }
}

function validatePassword(password) {
  var passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%()]).{6,}$/;

  // Password validation
  if (!passwordPattern.test(password)) {
    document.querySelector("#password_error").innerText =
      "Password does not match criteria";
    passwordInput.classList.add("input_error");
    return false;
  } else {
    document.querySelector("#password_error").innerText = "";
    passwordInput.classList.remove("input_error");
    return true;
  }
}

function confirmPassword(password, confirm_password) {
  // Password confirmation validation
  if (password !== confirm_password) {
    document.querySelector("#confirm_password_error").innerText =
      "Passwords do not match.";
    confirmInput.classList.add("input_error");
    return false;
  } else {
    document.querySelector("#confirm_password_error").innerText = "";
    confirmInput.classList.remove("input_error");
    return true;
  }
}

function togglePasswordVisibility(passwordInput, passwordVisibility) {
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
    emailInput.classList.add("input_error");
    return false;
  } else {
    document.querySelector("#email_error").innerText = "";
    emailInput.classList.remove("input_error");
    return true;
  }
}

function removeChars(phoneInput) {
  phoneInput.value = phoneInput.value.replace(/[^0-9]/g, "");
}

function validateForm() {
  var username = usernameInput.value,
    name = nameInput.value,
    email = emailInput.value,
    password = passwordInput.value,
    confirm_password = confirmInput.value;

  if (username === "") {
    var userNameError = document.getElementById("username_error");
    userNameError.innerText = "Please enter username";
    usernameInput.classList.add("input_error");
    return false;
  } else if (username) {
    var isUserNameValid = validateUserName(username);
    if (!isUserNameValid) {
      return false;
    }
  }

  if (name === "") {
    var nameError = document.getElementById("name_error");
    nameError.innerText = "please enter name";
    nameInput.classList.add("input_error");
    return false;
  } else if (name) {
    var isNameValid = validateName(name);
    if (!isNameValid) {
      return false;
    }
  }

  if (email === "") {
    var emailError = document.getElementById("email_error");
    emailError.innerText = "Please enter email id";
    emailInput.classList.add("input_error");
    return false;
  } else if (email) {
    var isEmailValid = validateEmail(email);
    if (!isEmailValid) {
      return false;
    }
  }

  if (password === "") {
    var passwordError = document.getElementById("password_error");
    passwordError.innerText = "Please enter password";
    passwordInput.classList.add("input_error");
    return false;
  } else if (password) {
    var isPasswordValid = validatePassword(password);
    if (!isPasswordValid) {
      return false;
    }
  }

  if (confirm_password === "") {
    var confirmPasswordError = document.getElementById(
      "confirm_password_error"
    );
    confirmPasswordError.innerText = "Please enter confirm password";
    confirmInput.classList.add("input_error");
    return false;
  } else if (confirm_password) {
    var isPasswordSame = confirmPassword(password, confirm_password);
    if (!isPasswordSame) {
      return false;
    }
  }

  document.querySelector(".error_message").innerText = "";
  return true;
}

function validateLoginForm() {
  var username = usernameInput.value,
    email = emailInput.value,
    password = passwordInput.value;

  if (username === "" && email === "") {
    var userNameError = document.querySelector(
      ".username_email_wrapper .error_message"
    );
    userNameError.innerText = "Please enter usernmae or email id";
    usernameInput.classList.add("input_error");
    emailInput.classList.add("input_error");
    return false;
  } else if (username) {
    var isUserNameValid = validateUserName(username);
    if (!isUserNameValid) {
      return false;
    }
  } else if (email) {
    var isEmailValid = validateEmail(email);
    if (!isEmailValid) {
      return false;
    }
  }

  if (password === "") {
    var passwordError = document.querySelector("#password_error");
    passwordError.innerText = "Please enter password";
    passwordInput.classList.add("input_error");
    return false;
  } else if (password) {
    var isPasswordValid = validatePassword(password);
    if (!isPasswordValid) {
      return false;
    }
  }

  document.querySelector(".error_message").innerText = "";
  return true;
}

function validateFormEdit() {
  var name = nameInput.value,
    email = emailInput.value,
    password = passwordInput.value,
    confirm_password = confirmInput.value;

  if (name === "") {
    var nameError = document.getElementById("#name_error");
    nameError.innerText = "please enter name";
    nameInput.classList.add("input_error");
    return false;
  } else if (name) {
    var isNameValid = validateName(name);
    if (!isNameValid) {
      return false;
    }
  }

  if (email === "") {
    var emailError = document.querySelector("#email_error");
    emailError.innerText = "Please enter email id";
    emailInput.classList.add("input_error");
    return false;
  } else if (email) {
    var isEmailValid = validateEmail(email);
    if (!isEmailValid) {
      return false;
    }
  }

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

  document.querySelector(".error_message").innerText = "";
  return true;
}

function removeImagePreview(
  fileInput,
  imgPreviewWrapper,
  imgPreview,
  imgFileName,
  imgFileNameError
) {
  fileInput.value = "";
  imgPreview.src = "#";
  imgPreviewWrapper.style.display = "none";
  imgFileName.innerText = "Choose Profile Picture";
  imgFileNameError.innerText = "No file selected";
}

document.addEventListener("click", function (event) {
  var target = event.target;

  if (target.matches("#edit, #add")) {
    var btntext = target.id;

    if (btntext === "add") {
      window.location.href = "add_edit_user.php?action=add";
    }

    if (btntext === "edit") {
      var userId = target.dataset.id;
      window.location.href = "add_edit_user.php?action=edit&uid=" + userId;
    }
  }
});

function loadUserTable() {
  fetch("get_users.php")
    .then((response) => response.json())
    .then((data) => {
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

      data.forEach((row) => {
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
                  <a href="delete.php?id=${row.id}" id="delete" data-id="${row.id}">Delete</a>
                </td>
              </tr>`;
      });

      tableHTML += `</tbody></table>`;
      document.getElementById("users_list").innerHTML = tableHTML;
    })
    .catch((error) => {
      console.error("Error loading user table:", error);
    });
}
