/*
 * File Name: registration.js
 * Authors: Timothy Roush
 * Date Created: 5/27/17
 * Assignment: Final Budget App
 * Description:  JavaScripts for validation of the new user registration form
 */


var isError = false;

$(document).ready(function() {
  // AJAX: Check if new email is already registered
  $('#email').blur(validateNewEmail);
  $('input[type=password]').blur(validateVerify);
  //$('#submit').click(validateRequired);
});


// Validate all fields before submitting
function validateRegistration() {
  clearErrors();
  validateVerify();
  if (validateEmail()) {
    validateNewEmail();
  }
  validateRequired();

  if (!isError) {
    return true;
  } else {
    return false;
  }
  
}

// Validates that new email is acceptable and not already in use
function validateNewEmail() {
  var email = $('#email').val();
  $.post('model/ajax.php', {action: 'emailExists', email: email }, function(data) {
    if (data == 'true') {
      $('#email').parent().toggleClass("has-error", true);
      $('#email').next().text('Email has already been registered');
      isError = true;
    } else {
      $('#email').parent().toggleClass("has-error", false);
      $('#email').next().text('');
      isError = false;
    }
  });
}


function validateRequired() {
  var required = ["userName", "password", "verify", "email"];
  
  for (field in required) {
    var input = $("#" + required[field]);

    if (input.val() == null || input.val() == "") {
      input.parent().toggleClass("has-error", true);
      input.next().text('This is a required field');
      isError = true;
    }
  }
}


function validateEmail() {
  var email = $('#email');
  var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  if (!regex.test(email.val())) {
    email.parent().toggleClass("has-error", true);
    email.next().text('This is not a valid email format');
    isError = true;
    return false;
  }
  return true;
}

function validateVerify() {
  var password = $('#password').val();
  var verify = $('#verify').val();

  if (password.length > 0 && verify.length > 0) {
    if (password != verify) {
      $('input[type=password]').parent().toggleClass("has-error", true);
      $('input[type=password]').next().text('Password and Verify values must match');
      isError = true;
    }
  }
}

function clearErrors() {
  $('input[type=text],input[type=password]').each( function() {
    $(this).parent().toggleClass("has-error", false);
    $(this).next().text('');
    isError = false;
  });
}