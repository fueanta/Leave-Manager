<script>

var fileSizeLimit = 2; // 2MB
var allowed_extensions = new Array("jpg", "jpeg", "png", "pdf", "doc", "docx");
var fileQuantityLimit = 5;

var uploadBtnText = '';

$(document).ready(function() {
    uploadBtnText = $('#upload-msg').text();

    uploadFunctionality();

    $("#todate").attr({"min" : $("#fromdate").val()});

    $("#leave").on('change', function() {
        uploadFunctionality();
    });

    $("#fromdate").on('change', function() {
        uploadFunctionality();

        $("#todate").attr({"min" : $(this).val()});

        var start = $('#fromdate').val();
        var end = $('#todate').val();
        var days = getDaysBetween(start, end);

        if(days < 0) {
            $("#todate").val($(this).val());
        }
    });

    $("#todate").on('change', function() {
        uploadFunctionality();
    });

    $("#files").change(function() {
        var i;

        var fileQuantity = this.files.length;

        if(fileQuantity <= fileQuantityLimit) {
            var fileSizeViolated = false;
            var fileTypeViolated = false;
            for (i = 0; i < fileQuantity; i++) {
                var fileSize = this.files[i].size/1024/1024;
                if (fileSize > fileSizeLimit) {
                    fileSizeViolated = true;
                }
    
                var fileName = this.files[i].name;
                var fileExtension = fileName.split('.').pop().toLowerCase();
                if(jQuery.inArray(fileExtension, allowed_extensions) < 0) {
                    fileTypeViolated = true;
                }
            }
    
            if(!fileSizeViolated) {
                if(!fileTypeViolated) {
                    if (fileQuantity == 0) {
                        $('#upload-msg').text(uploadBtnText);
                    } else {
                        $('#upload-msg').text(fileQuantity + (fileQuantity > 1 ? ' files' : ' file'));
                    }
                } else {
                    resetItem($("#files"));
                    $("#upload-msg").text(uploadBtnText);
    
                    Swal.fire({
                      type: 'error',
                      title: 'Unsupported Type!!',
                      html: '<small>Supported document formats: .jpg, .jpeg, .png, .pdf, .doc<small>',
                      // showCloseButton: true,
                      // confirmButtonColor: '#f27474'
                    });
                }
            } else {
                resetItem($("#files"));
                $("#upload-msg").text(uploadBtnText);
    
                Swal.fire({
                  type: 'error',
                  title: 'Too Big!!',
                  html: '<small>Maximum file size: ' + fileSizeLimit + 'MB (each)<small>',
                  // showCloseButton: true,
                  // confirmButtonColor: '#f27474'
                });
            }
        } else {
            resetItem($("#files"));
            $("#upload-msg").text(uploadBtnText);

            Swal.fire({
              type: 'error',
              title: 'Too Many!!',
              html: '<small>Do not upload more than ' + fileQuantityLimit + ' documents.<small>',
              // showCloseButton: true,
              // confirmButtonColor: '#f27474'
            });
        }
    });
});

function validate_application_form() {
    var documentRequiredAfter = $("#leave").children("option:selected").data('document_required_after');
    var numberOfFiles = $("#files")[0].files.length;
    var documentUploadNature = $("#upload-msg").data('upload-nature');

    var start = $('#fromdate').val();
    var end = $('#todate').val();
    var days = getDaysBetween(start, end);

    // console.log(days + ' ' + documentRequiredAfter + ' ' + numberOfFiles + ' ' + documentUploadNature);

    if(documentRequiredAfter !== 0 && days >= documentRequiredAfter && numberOfFiles === 0 && documentUploadNature === "upload") {
        // alert('Document is required!!');
        Swal.fire({
          type: 'warning',
          title: 'Document Required!!',
          html: '<small>Supporting documents are required to apply for such leave.<small>',
          // showCloseButton: true,
          // confirmButtonColor: '#f8bb86'
        });
        return false;
    }

    var submitType = document.getElementById("submit_type").value;

    if(submitType == "post") {
        sendingMail('the delegate');
    }

    return true;
}

function sendingMail(sendTo) {
  if(navigator.onLine){
    Swal.fire({
      type: 'success',
      title: '<h3>A mail is being sent to ' + sendTo + '.</h3>',
      showConfirmButton: false,
      timer: 2800
    });
  }
}

function resetItem(input) {
    input.replaceWith(input.val('').clone(true));
}

function uploadFunctionality() {
    var start = $('#fromdate').val();
    var end = $('#todate').val();
    var days = getDaysBetween(start, end);

    var documentRequiredAfter = $("#leave").children("option:selected").data('document_required_after');

    $('#document_required_after').val(documentRequiredAfter);

    if(documentRequiredAfter !== 0 && days >= documentRequiredAfter) {
        $('.upload-btn-container').fadeIn('fast');
    }
    else {
        $('.upload-btn-container').fadeOut('fast');

        resetItem($("#files"));
        $("#upload-msg").text(uploadBtnText);
    }
}

function getDaysBetween( from, to ) {
    var start = from;
    var end = to;

    var startDay = new Date(start);
    var endDay = new Date(end);
    var millisecondsPerDay = 1000 * 60 * 60 * 24;

    var millisBetween = endDay.getTime() - startDay.getTime();
    var days = millisBetween / millisecondsPerDay;

    return Math.floor(days);
}

</script>