/*
 * File Name: scripts.js
 * Authors: Timothy Roush & Jeff Pratt
 * Date Created: 5/27/17
 * Assignment: Final Budget App
 * Description:  All custom external JavaScripts for this site
 */

$(document).ready(function() {
  // Check if new email is already registered
  //$('#email').blur(validateNewEmail);
});

/*
// Validates that new email is acceptable and not already in use
function validateNewEmail() {
  var email = $('#email').val();
  $.post('model/ajax.php', {action: 'emailExists', email: email }, function(data) {
    if (data == 'true') {
      $('#email').parent().toggleClass("has-error", true);
      $('#email').next().text('Email has already been registered');
    } else {
      $('#email').parent().toggleClass("has-error", false);
      $('#email').next().text('');
    }
  });
}


function isValidEmail(email) {
  var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  alert(regex.test(email));
  return regex.test(email);
}
*/