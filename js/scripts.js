/*
 * File Name: scripts.js
 * Authors: Timothy Roush
 * Date Created: 5/27/17
 * Assignment: Final Budget App
 * Description:  All custom external JavaScripts for this site
 */

$(document).ready(function() {
  $('#transactions').DataTable();
  $('#month, #year').change(function() {
    var month = $('#month').val();
    var year = $('#year').val();
    console.log("Path: " + window.location.pathname);
    console.log("Protocol: " + window.location.protocol);
    console.log("Host: " + window.location.host);
    console.log("Location: " + window.location);
    window.location = "/328/budgetapp/userHome/" + year + "/" + month;
  });
});
