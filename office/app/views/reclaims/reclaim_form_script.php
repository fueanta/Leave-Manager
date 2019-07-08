<script>

$(document).ready(function() {
  var from = $("#from");
  var days = $("#days");

  var hidden_from = $("#hidden_from");
  var hidden_days = $("#hidden_days");

  if(hidden_from.length && hidden_days.length) {
    hidden_from.val(from.val());
    hidden_days.val(days.val());
  }
  
  $(from).on('change', function() {
    if(hidden_from.length) {
      hidden_from.val(from.val());
    }
  });

  $(days).on('change', function() {
    if(hidden_days.length) {
      hidden_days.val(days.val());
    }
  });
});

function validate_reclaim_form(form) {
  event.preventDefault();
  Swal.fire({
    title: '<h3>Are you sure about reclaiming days?</h3>',
    type: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, I am!'
  }).then((result) => {
    if (result.value) {
      sendingMail('the supervisor');
      sleep(1000).then(() => {
        form.submit();
      });
    }
  });
}

// sleep time expects milliseconds
function sleep (time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}

function sendingMail(sendTo) {
  if(navigator.onLine){
    Swal.fire({
      type: 'success',
      title: '<h3>A mail is being sent to ' + sendTo + '.</h3>',
      showConfirmButton: false,
      timer: 3000
    });
  }
}

</script>