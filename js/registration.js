/*
 * File Name: registration.js
 * Authors: Timothy Roush
 * Date Created: 5/27/17
 * Assignment: Final Budget App
 * Description:  JavaScripts for validation of the new user registration form
 */


var isError = false;                        // Global error toggle


$(document).ready(function() {              // Auto event handlers
  $('#email').blur(validateNewEmail);
  $('input[type=password]').blur(validateVerify);
  $('#registration').on('submit', validateRegistration);

});


// Full Validation for all fields before submitting
function validateRegistration(event) {
  clearErrors();                            // Remove previous errors
  validateVerify();                         // Ensure password and verify match
  if (validateEmail()) validateNewEmail();  // If valid email, make sure unique
  validateRequired();                       // Ensure required fields filled

  if (isError) event.preventDefault();      // If errors, prevent submit
}


// Validates that new email is acceptable and not already in use
function validateNewEmail() {
  var email = $('#email').val();
  
  // AJAX call to check database for email
  $.post('model/ajax.php', {action: 'emailExists', email: email }, function(data) {
    if (data == 'true') {
      postError( $('#email'), 'Email has already been registered' );
    } else {
      clearError( $('#email') );
      isError = false;
    }
  });
}


// Make sure all required fields have values
function validateRequired() {
  $('input').each( function() {
    if ( $(this).val() == null || $(this).val() == "" ) {
      postError( $(this), 'This is a required field' );
    }
  })
}

// Validate email format against a regex
function validateEmail() {
  var email = $('#email');
  var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;

  if (!regex.test(email.val())) {
    postError(email, 'This is not a valid email format');
    return false;
  }
  return true;
}

// Make sure password and verify values match
function validateVerify() {
  var password = $('#password').val();
  var verify = $('#verify').val();

  if (password.length > 0 && verify.length > 0) {
    if (password != verify) {
      postError($('input[type=password]'), 'Password and Verify values must match');
    } else {
      clearError($('input[type=password]'));
    }
  }
}

// Post error status to form groups
function postError(field, error) {
  field.parent().toggleClass("has-error", true);
  field.next().text(error);
  isError = true;
}

// Clear a single error
function clearError(field) {
  field.parent().toggleClass("has-error", false);
  field.next().text('');
}

// Clear all input field errors for "clean slate"
function clearErrors() {
  $('input[type=text],input[type=password]').each( function() {
    clearError( $(this) );
    isError = false;
  });
}