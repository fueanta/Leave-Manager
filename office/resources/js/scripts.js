function confirmDelete(deleteBtn, deletedItemName) {
  event.preventDefault();
  Swal.fire({
    title: '<h3>Are you sure about deleting?</h3>',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    // confirmButtonColor: '#3085d6',
    // cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {
      Swal.fire({
        type: 'success',
        title: '<h3>Your ' + deletedItemName + ' is being deleted.</h3>',
        showConfirmButton: false,
        timer: 1500
      })

      sleep(1700).then(() => {
        // Do something after the sleep!
        deleteBtn.closest("form").submit();
      });
    }
  });
}

function confirmAction(btn, sendMailTo = '') {
  event.preventDefault();
  Swal.fire({
    title: '<h3>Are you sure about this?</h3>',
    type: 'question',
    showCancelButton: true,
    // confirmButtonColor: '#3085d6',
    // cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, I am!'
  }).then((result) => {
    if (result.value) {
      if (sendMailTo !== '') {
        sendingMail(sendMailTo);
        sleep(500).then(() => {
          // Do something after the sleep!
          btn.closest("form").submit();
        });
      } else {
        sleep(500).then(() => {
          // Do something after the sleep!
          btn.closest("form").submit();
        });
      }
    }
  });
}

// sleep time expects milliseconds
function sleep(time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}

function sendingMail(sendTo) {
  if (navigator.onLine) {
    Swal.fire({
      type: 'success',
      title: '<h3>A mail is being sent to ' + sendTo + '.</h3>',
      showConfirmButton: false,
      timer: 2800
    });
  }
}