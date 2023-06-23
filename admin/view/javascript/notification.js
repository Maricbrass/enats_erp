var notificationSent = false; // Flag to keep track of whether the notification has been sent or not.

$(document).ready(function() {
setInterval(function(){ showNotification(); }, 200); // Call the showNotification() function every 2000000 milliseconds.
});

function showNotification() { 
if (!Notification) {
  $('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
  return;
}

if (Notification.permission !== "granted") {    
  Notification.requestPermission();
} else {    
  $.ajax({
    url : "index.php?route=catalog/notification&token=<?php echo $token; ?>",
    type: "POST",
    success: function(data, textStatus, jqXHR) {
      alert("working");
      var response = JSON.parse(data);
      if (response.result && !notificationSent) { // Check if the notification has not been sent already.
        var notifications = response.notif;
        for (var i = 0; i < notifications.length; i++) {
          var notification = notifications[i];
          var subject = notification.subject;
          var task = notification.task;
          var url = notification.url;
          var message = notification.task;
          var theurl = url;
          var notifikasi = new Notification(subject, {
            body: message,
          });
          // alert(notifikasi.title);
          notifikasi.onclick = function () {
            window.open(theurl); 
            notifikasi.close();     
          };
          setTimeout(function(){
            notifikasi.close();
          }, 5000);
        };
        notificationSent = true; // Set the flag to true to indicate that the notification has been sent.
      } else {
        // alert("Not working");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      // handle the case where the AJAX call encountered an error
    }
  }); 
}
};