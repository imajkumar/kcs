// Class definition
var KTFormControls = (function () {
  // Private functions
  var _initDemo1 = function () {
    FormValidation.formValidation(
      document.getElementById("ayra_kt_form_add_school"), {
        fields: {
          title: {
            validators: {
              notEmpty: {
                message: "Title is required",
              },
            },
          },
          regno: {
            validators: {
              notEmpty: {
                message: "Registration No. is required",
              },
            },
          },
          country: {
            validators: {
              notEmpty: {
                message: "Country is required",
              },
            },
          },
          state: {
            validators: {
              notEmpty: {
                message: "State is required",
              },
            },
          },
          city: {
            validators: {
              notEmpty: {
                message: "City is required",
              },
            },
          },
          email: {
            validators: {
              notEmpty: {
                message: "Email is required",
              },
              emailAddress: {
                message: "The value is not a valid email address",
              },
            },
          },

          website: {
            validators: {
              notEmpty: {
                message: "Website URL is required",
              },
              uri: {
                message: "The website address is not valid",
              },
            },
          },

          digits: {
            validators: {
              notEmpty: {
                message: "Digits is required",
              },
              digits: {
                message: "The velue is not a valid digits",
              },
            },
          },

          creditcard: {
            validators: {
              notEmpty: {
                message: "Credit card number is required",
              },
              creditCard: {
                message: "The credit card number is not valid",
              },
            },
          },

          phone: {
            validators: {
              notEmpty: {
                message: "Phone number is required",
              },
            },
          },

          option: {
            validators: {
              notEmpty: {
                message: "Please select an option",
              },
            },
          },

          options: {
            validators: {
              choice: {
                min: 2,
                max: 5,
                message: "Please select at least 2 and maximum 5 options",
              },
            },
          },

          memo: {
            validators: {
              notEmpty: {
                message: "Please enter memo text",
              },
              stringLength: {
                min: 50,
                max: 100,
                message: "Please enter a menu within text length range 50 and 100",
              },
            },
          },

          checkbox: {
            validators: {
              choice: {
                min: 1,
                message: "Please kindly check this",
              },
            },
          },

          checkboxes: {
            validators: {
              choice: {
                min: 2,
                max: 5,
                message: "Please check at least 1 and maximum 2 options",
              },
            },
          },

          radios: {
            validators: {
              choice: {
                min: 1,
                message: "Please kindly check this",
              },
            },
          },
        },

        plugins: {
          //Learn more: https://formvalidation.io/guide/plugins
          trigger: new FormValidation.plugins.Trigger(),
          // Bootstrap Framework Integration
          bootstrap: new FormValidation.plugins.Bootstrap(),
          // Validate fields when clicking the Submit button
          submitButton: new FormValidation.plugins.SubmitButton(),
          // Submit the form when all fields are valid
          //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        },
      }
    ).on("core.form.valid", function () {
      // Send the form data to back-end
      // You need to grab the form data and create an Ajax request to send them
      var _redirect = $("#ayra_kt_form_add_school").attr("data-redirect");

      // ajax
      var formData = {
        title: $("input[name=title]").val(),
        regno: $("input[name=regno]").val(),
        txtSID: $("input[name=txtSID]").val(),
        txtAction: $("input[name=txtAction]").val(),
        country: $("#kt_select2_1").val(),
        state: $("#kt_select2_2").val(),
        city: $("#kt_select2_3").val(),
        reg_no: $("input[name=reg_no]").val(),
        phone_code: $("#txtPhoneCode").val(),
        website: $("#website").val(),
        phone: $("input[name=phone]").val(),
        email: $("input[name=email]").val(),
        password: $("input[name=password]").val(),
        admin_comm: $("input[name=admin_comm]").val(),
        facebook: $("input[name=facebook]").val(),
        twitter: $("input[name=twitter]").val(),
        linkedin: $("input[name=linkedin]").val(),
        about: $("#kt-ckeditor-1").html(),
        _token: $('meta[name="csrf-token"]').attr("content"),
      };
      $.ajax({
        url: BASE_URL + "/saveSchool",
        type: "POST",
        data: formData,
        success: function (res) {
          if (res.status == 1) {
            swal
              .fire({
                text: res.msg,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              })
              .then(function () {
                setTimeout(function () {
                  //KTUtil.scrollTop();
                  // location.reload();
                  location.assign(_redirect);
                }, 500);
              });
          } else {
            swal
              .fire({
                text: res.msg,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              })
              .then(function () {
                KTUtil.scrollTop();
              });
          }
        },
      });
      // ajax
    });
  };

  return {
    // public functions
    init: function () {
     
      // https://ckeditor.com/docs/ckeditor5/latest/features/toolbar/toolbar.html

      var myEditor;
      DecoupledEditor.create(document.querySelector("#kt-ckeditor-1"),{
        toolbar: [ 'bold', 'italic', 'link', 'undo', 'redo', 'numberedList', 'bulletedList' ]
    } )
        .then((editor) => {
          const toolbarContainer = document.querySelector(
            "#kt-ckeditor-1-toolbar"
          );
          myEditor = editor;
          toolbarContainer.appendChild(editor.ui.view.toolbar.element);
          
        })
        .catch((error) => {
          console.error(error);
        });

      _initDemo1();
    },
  };
})();

jQuery(document).ready(function () {
  $(".country").change(function () {
    var country_id = $(this).val();
    $("#kt_select2_2").html("");
    $("#kt_select2_3").html("");
    //alert(444);
    // ajax
    var formData = {
      country_id: country_id,
      _token: $('meta[name="csrf-token"]').attr("content"),
    };
    $.ajax({
      url: BASE_URL + "/getStateByCountryID",
      type: "GET",
      data: formData,
      success: function (res) {
        $("#kt_select2_2").append(
          `<option  value="">-Select State-</option>`
        );
        $.each(res.stateData, function (key, val) {
          //alert(key + val);

          $("#kt_select2_2").append(
            `<option  value="${val.id}">${val.name}</option>`
          );
        });
        $("#txtPhoneCode").val(res.countryData.phonecode);
        $(".txtPhoneCode").html(res.countryData.emoji);
      },
    });
    //ajax
  });
  $(".stateID").change(function () {
    var state_id = $(this).val();
    var country_id = $(".country").val();
    $("#kt_select2_3").html("");
    // ajax
    var formData = {
      state_id: state_id,
      country_id: country_id,
      _token: $('meta[name="csrf-token"]').attr("content"),
    };
    $.ajax({
      url: BASE_URL + "/getCityByStateID",
      type: "GET",
      data: formData,
      success: function (res) {
        $.each(res, function (key, val) {
          //alert(key + val);

          $("#kt_select2_3").append(
            `<option  value="${val.id}">${val.name}</option>`
          );
        });
      },
    });
    //ajax
  });

  KTFormControls.init();
});

var KTCkeditorDocument = (function () {
  // Private functions
  var demos = function () {};

  return {
    // public functions
    init: function () {
      demos();
    },
  };
})();

// Initialization
jQuery(document).ready(function () {
  KTCkeditorDocument.init();
});

("use strict");
// Class definition

var KTDropzoneDemo = (function () {
  // Private functions

  var demo2AyraUpload = function () {
    // set the dropzone container id
    var id = "#kt_dropzone_4";


    // set the preview element template
    var previewNode = $(id + " .dropzone-item");
    previewNode.id = "";
    var previewTemplate = previewNode.parent(".dropzone-items").html();
    previewNode.remove();

    var myDropzone4 = new Dropzone(id, {
      // Make the whole body a dropzone
      url: BASE_URL + "/uploadSchoolDoc", // Set the url for your upload script location
      parallelUploads: 20,

      previewTemplate: previewTemplate,
      maxFilesize: 1, // Max filesize in MB

      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: id + " .dropzone-items", // Define the container to display the previews
      clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
    });

    myDropzone4.on("sending", function (file, xhr, formData) {

    if($("#txtDocInfo").val()==""){
      Swal.fire("Document Information Required", "Alert", "warning");
      return false;
     }else{
      formData.append("action_upload", '_upload_Avatar');
      formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
      formData.append("doc_info", $("#txtDocInfo").val());
      formData.append("txtSID", $("#txtSID").val());
      
     }

      
    });
    myDropzone4.on("addedfile", function (file) {
      // Hookup the start button
      file.previewElement.querySelector(id + " .dropzone-start").onclick =
        function () {
          myDropzone4.enqueueFile(file);
        };
      $(document)
        .find(id + " .dropzone-item")
        .css("display", "");
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "inline-block"
      );
    });

    // Update the total progress bar
    myDropzone4.on("totaluploadprogress", function (progress) {
      $(this)
        .find(id + " .progress-bar")
        .css("width", progress + "%");
    });

    myDropzone4.on("sending", function (file) {
      // Show the total progress bar when upload starts
      $(id + " .progress-bar").css("opacity", "1");
      // And disable the start button
      file.previewElement
        .querySelector(id + " .dropzone-start")
        .setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone4.on("complete", function (progress) {
      var thisProgressBar = id + " .dz-complete";
      setTimeout(function () {
        $(
          thisProgressBar +
          " .progress-bar, " +
          thisProgressBar +
          " .progress, " +
          thisProgressBar +
          " .dropzone-start"
        ).css("opacity", "0");
        Swal.fire("Good job!", "Uploaded Successfully!", "success");
        //location.reload(1);
      }, 2000);
    });

    // Setup the buttons for all transfers
    document.querySelector(id + " .dropzone-upload").onclick = function () {
      if($("#txtDocInfo").val()==""){
        Swal.fire("Document Information Required", "Alert", "warning");
        return false;
      }else{
        myDropzone4.enqueueFiles(myDropzone4.getFilesWithStatus(Dropzone.ADDED));
      }
      
    };

    // Setup the button for remove all files
    document.querySelector(id + " .dropzone-remove-all").onclick = function () {
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "none"
      );
      myDropzone4.removeAllFiles(true);
    };

    // On all files completed upload
    myDropzone4.on("queuecomplete", function (progress) {
      $(id + " .dropzone-upload").css("display", "none");
    });

    // On all files removed
    myDropzone4.on("removedfile", function (file) {
      if (myDropzone4.files.length < 1) {
        $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
          "display",
          "none"
        );
      }
    });
  };
 

  var demo2AyraUploadA = function () {
    // set the dropzone container id
    var id = "#kt_dropzone_4_1";

    // set the preview element template
    var previewNode = $(id + " .dropzone-item");
    previewNode.id = "";
    var previewTemplate = previewNode.parent(".dropzone-items").html();
    previewNode.remove();

    var myDropzone4 = new Dropzone(id, {
      // Make the whole body a dropzone
      url: BASE_URL + "/uploadSchoolLogo", // Set the url for your upload script location
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      maxFiles: 1,
      acceptedFiles: ".png",
      maxFilesize: 1, // Max filesize in MB
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: id + " .dropzone-items", // Define the container to display the previews
      clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
    });

    myDropzone4.on("sending", function (file, xhr, formData) {
      formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
      formData.append("txtSID", $("#txtSID").val());
      formData.append("action", $("#uploadAvatarPhoto").val());

    });
    myDropzone4.on("addedfile", function (file) {
      // Hookup the start button
      file.previewElement.querySelector(id + " .dropzone-start").onclick =
        function () {
          myDropzone4.enqueueFile(file);
        };
      $(document)
        .find(id + " .dropzone-item")
        .css("display", "");
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "inline-block"
      );
    });

    // Update the total progress bar
    myDropzone4.on("totaluploadprogress", function (progress) {
      $(this)
        .find(id + " .progress-bar")
        .css("width", progress + "%");
    });

    myDropzone4.on("sending", function (file) {
      // Show the total progress bar when upload starts
      $(id + " .progress-bar").css("opacity", "1");
      // And disable the start button
      file.previewElement
        .querySelector(id + " .dropzone-start")
        .setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone4.on("complete", function (progress) {
      var thisProgressBar = id + " .dz-complete";
      setTimeout(function () {
        $(
          thisProgressBar +
          " .progress-bar, " +
          thisProgressBar +
          " .progress, " +
          thisProgressBar +
          " .dropzone-start"
        ).css("opacity", "0");
        Swal.fire("Good job!", "Uploaded Successfully!", "success");
        location.reload(1);
      }, 2000);
    });

    // Setup the buttons for all transfers
    document.querySelector(id + " .dropzone-upload").onclick = function () {
      myDropzone4.enqueueFiles(myDropzone4.getFilesWithStatus(Dropzone.ADDED));
    };

    // Setup the button for remove all files
    document.querySelector(id + " .dropzone-remove-all").onclick = function () {
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "none"
      );
      myDropzone4.removeAllFiles(true);
    };

    // On all files completed upload
    myDropzone4.on("queuecomplete", function (progress) {
      $(id + " .dropzone-upload").css("display", "none");
    });

    // On all files removed
    myDropzone4.on("removedfile", function (file) {
      if (myDropzone4.files.length < 1) {
        $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
          "display",
          "none"
        );
      }
    });
  };
  var demo2AyraUploadA_IM = function () {
    // set the dropzone container id
    var id = "#kt_dropzone_4_3";

    // set the preview element template
    var previewNode = $(id + " .dropzone-item");
    previewNode.id = "";
    var previewTemplate = previewNode.parent(".dropzone-items").html();
    previewNode.remove();

    var myDropzone4 = new Dropzone(id, {
      // Make the whole body a dropzone
      url: BASE_URL + "/uploadSchoolSlider", // Set the url for your upload script location
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      maxFiles: 5,
      acceptedFiles: ".png",
      maxFilesize: 1, // Max filesize in MB
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: id + " .dropzone-items", // Define the container to display the previews
      clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
    });

    myDropzone4.on("sending", function (file, xhr, formData) {
      formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
      formData.append("txtSID", $("#txtSID").val());
    });
    myDropzone4.on("addedfile", function (file) {
      // Hookup the start button
      file.previewElement.querySelector(id + " .dropzone-start").onclick =
        function () {
          myDropzone4.enqueueFile(file);
        };
      $(document)
        .find(id + " .dropzone-item")
        .css("display", "");
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "inline-block"
      );
    });

    // Update the total progress bar
    myDropzone4.on("totaluploadprogress", function (progress) {
      $(this)
        .find(id + " .progress-bar")
        .css("width", progress + "%");
    });

    myDropzone4.on("sending", function (file) {
      // Show the total progress bar when upload starts
      $(id + " .progress-bar").css("opacity", "1");
      // And disable the start button
      file.previewElement
        .querySelector(id + " .dropzone-start")
        .setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone4.on("complete", function (progress) {
      var thisProgressBar = id + " .dz-complete";
      setTimeout(function () {
        $(
          thisProgressBar +
          " .progress-bar, " +
          thisProgressBar +
          " .progress, " +
          thisProgressBar +
          " .dropzone-start"
        ).css("opacity", "0");
        Swal.fire("Good job!", "Uploaded Successfully!", "success");
        location.reload(1);
      }, 2000);
    });

    // Setup the buttons for all transfers
    document.querySelector(id + " .dropzone-upload").onclick = function () {
      myDropzone4.enqueueFiles(myDropzone4.getFilesWithStatus(Dropzone.ADDED));
    };

    // Setup the button for remove all files
    document.querySelector(id + " .dropzone-remove-all").onclick = function () {
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "none"
      );
      myDropzone4.removeAllFiles(true);
    };

    // On all files completed upload
    myDropzone4.on("queuecomplete", function (progress) {
      $(id + " .dropzone-upload").css("display", "none");
    });

    // On all files removed
    myDropzone4.on("removedfile", function (file) {
      if (myDropzone4.files.length < 1) {
        $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
          "display",
          "none"
        );
      }
    });
  };

  var demo2AyraUploadAX = function () {
    // set the dropzone container id
    var id = "#kt_dropzone_4_6";

    // set the preview element template
    var previewNode = $(id + " .dropzone-item");
    previewNode.id = "";
    var previewTemplate = previewNode.parent(".dropzone-items").html();
    previewNode.remove();

    var myDropzone4 = new Dropzone(id, {
      // Make the whole body a dropzone
      url: BASE_URL + "/uploadUserPhoto", // Set the url for your upload script location
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      maxFiles: 1,
      acceptedFiles: ".png",
      maxFilesize: 1, // Max filesize in MB
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: id + " .dropzone-items", // Define the container to display the previews
      clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
    });

    myDropzone4.on("sending", function (file, xhr, formData) {
      formData.append("_token", $('meta[name="csrf-token"]').attr("content"));
      formData.append("txtSID", $("#txtSID").val());
    });
    myDropzone4.on("addedfile", function (file) {
      // Hookup the start button
      file.previewElement.querySelector(id + " .dropzone-start").onclick =
        function () {
          myDropzone4.enqueueFile(file);
        };
      $(document)
        .find(id + " .dropzone-item")
        .css("display", "");
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "inline-block"
      );
    });

    // Update the total progress bar
    myDropzone4.on("totaluploadprogress", function (progress) {
      $(this)
        .find(id + " .progress-bar")
        .css("width", progress + "%");
    });

    myDropzone4.on("sending", function (file) {
      // Show the total progress bar when upload starts
      $(id + " .progress-bar").css("opacity", "1");
      // And disable the start button
      file.previewElement
        .querySelector(id + " .dropzone-start")
        .setAttribute("disabled", "disabled");
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone4.on("complete", function (progress) {
      var thisProgressBar = id + " .dz-complete";
      setTimeout(function () {
        $(
          thisProgressBar +
          " .progress-bar, " +
          thisProgressBar +
          " .progress, " +
          thisProgressBar +
          " .dropzone-start"
        ).css("opacity", "0");
        Swal.fire("Good job!", "Uploaded Successfully!", "success");
       // location.reload(1);
      }, 2000);
    });

    // Setup the buttons for all transfers
    document.querySelector(id + " .dropzone-upload").onclick = function () {
      myDropzone4.enqueueFiles(myDropzone4.getFilesWithStatus(Dropzone.ADDED));
    };

    // Setup the button for remove all files
    document.querySelector(id + " .dropzone-remove-all").onclick = function () {
      $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
        "display",
        "none"
      );
      myDropzone4.removeAllFiles(true);
    };

    // On all files completed upload
    myDropzone4.on("queuecomplete", function (progress) {
      $(id + " .dropzone-upload").css("display", "none");
    });

    // On all files removed
    myDropzone4.on("removedfile", function (file) {
      if (myDropzone4.files.length < 1) {
        $(id + " .dropzone-upload, " + id + " .dropzone-remove-all").css(
          "display",
          "none"
        );
      }
    });
  };


  

  
  return {
    // public functions
    init: function () {
     
      
      demo2AyraUpload();
      demo2AyraUploadA();
      demo2AyraUploadA_IM();
      demo2AyraUploadAX();
      
      
      
    },
  };
})();

KTUtil.ready(function () {
  KTDropzoneDemo.init();
});



//myschool
$("select.myschool").change(function(){
  var selectedSchool = $(this).children("option:selected").val();
  
  


    //ajax
    $.ajax({
      url: BASE_URL + "/getSchoolCourse",
      type: "GET",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        selectedSchool: selectedSchool,
        action: 1,
       

      },
      success: function (resp) {
      

          $("select.myschoolCourse")
    .empty()
    .append(resp);

         
      },
    });
    //ajax


});

$("select.getWeelDataNext").change(function(){
  var  optN = $(this).children("option:selected").val();
  var payOPT=$("input[name=paymentStatusRadio]").val();
  
 
    //ajax
    $.ajax({
      url: BASE_URL + "/getCousePaymentByFilterThisWeek",
      type: "GET",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        optN: optN,
        action: 3,  
        payOPT:payOPT     

      },
      success: function (resp) {
        console.log(resp);
        $('.showdata').html(resp);
      }
    });
    
});
//myschool
$("input[name=paymentStatusRadio3]").click(function(){
  var optN=$(this).val();
  $('.showdata').html('');
 
    //ajax
    $.ajax({
      url: BASE_URL + "/getCousePaymentByFilter",
      type: "GET",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        optN: optN,
        action: 2,       

      },
      success: function (resp) {
        console.log(resp);
        $('.showdata').html(resp);
      }
    });

});

//btnRejectionSchool
$('#btnRejectionSchool').click(function(){

  var txtSID=$('#txtSID').val();
  var txtRejectionNote=$('#txtRejectionNote').val();

    //ajax
    $.ajax({
      url: BASE_URL + "/schoolAcceptedRejectAction",
      type: "POST",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        rowid: txtSID,
        action: 2,
        msg: txtRejectionNote,

      },
      success: function (resp) {
        if (resp.status == 1) {
          Swal.fire("School!", "Has been Rejected.", "success");
          setTimeout(function () {
             //window.location.href = BASE_URL+'/school-request-list'
            location.reload(1);
          }, 1000);
        } else {
          Swal.fire("School !", "Oops", "error");
        }
      },
    });
    //ajax
    

});
//btnRejectionSchool

//schoolApprovalAction
function schoolApprovalAction(action, rowID) {
  if(action==2){
    $('#txtSID').val(rowID);
    $('#exampleModalSizeSm').modal('show');
  }else{
      //accpeted
      Swal.fire({
        title: "Are you sure?",
        text: "You want to accept this school",
        icon: "primary",
        showCancelButton: true,
        confirmButtonText: "Yes, Accept it",
      }).then(function (result) {
        if (result.value) {
          //ajax
          $.ajax({
            url: BASE_URL + "/schoolAcceptedRejectAction",
            type: "POST",
            data: {
              _token: $('meta[name="csrf-token"]').attr("content"),
              rowid: rowID,
              action: action,
    
            },
            success: function (resp) {
              if (resp.status == 1) {
                Swal.fire("School!", "Has been Accepted.", "success");
                setTimeout(function () {
                   window.location.href = BASE_URL+'/school-request-list'
                  //location.reload(1);
                }, 1000);
              } else {
                Swal.fire("School !", "Oops", "error");
              }
            },
          });
          //ajax
        }
      });
       
      //accepted
  }
  
}
//schoolApprovalAction
//deleteMeStatic
function deleteMeStatic(action, rowID) {
  Swal.fire({
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.value) {
      //ajax
      $.ajax({
        url: BASE_URL + "/deletebyAction",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          rowid: rowID,
          action: action,

        },
        success: function (resp) {
          if (resp.status == 1) {
            Swal.fire("Deleted!", "Has been deleted.", "success");
            setTimeout(function () {
              // window.location.href = BASE_URL+'/orders'
              location.reload(1);
            }, 500);
          } else {
            Swal.fire("Deleted Alert!", "Cann't not delete", "error");
          }
        },
      });
      //ajax
    }
  });
}

//deleteMeStatic

//btnPasswordReset
$('#btnPasswordReset').click(function(){
  var curr_pass=$('#current').val();
  var new_pass=$('#password').val();
  var confirm_pass=$('#confirmed').val();
  if(curr_pass==""){
   
    Swal.fire("Password Reset", "Enter Current Password", "error");
    return false;
  }
  if(new_pass==""){
    
    Swal.fire("Password Reset", "Enter New Password", "error");
    
    return false;
  }
  if(confirm_pass==""){
    toasterOptions();
    toastr.error('Enter Confirm Password', 'Password Reset');
    return false;
  }
  if(confirm_pass!=new_pass){
    
    Swal.fire("Password Reset", "Password Mismatched", "error");
    return false;
  }
  var formData = {
    'current':curr_pass,
    'password':new_pass,
    'confirmed':confirm_pass,
    '_token':$('meta[name="csrf-token"]').attr('content'),
    'user_id':$('meta[name="UUID"]').attr('content'),

  };
  $.ajax({
    url: BASE_URL+'/UserResetPassword',
    type: 'POST',
    data: formData,
    success: function(res) {
     if(res.status==1){
     
      Swal.fire("Password Reset", "Password successfully changed", "success");
      setTimeout(function () {
        //KTUtil.scrollTop();
        // location.reload();
        var redirect = BASE_URL;
        location.assign(redirect);
      }, 500);
     }
     if(res.status==2){
      
      
      Swal.fire("Password Reset", "Your current password does not matches with the password you provided", "error");
      return false;
     }
     if(res.status==3){     
      
      Swal.fire("Password Reset", "New Password cannot be same as your current password. Please choose a different password..", "error");

     }

    }

  });




});
//btnPasswordReset


function deleteMe(action, rowID) {
  Swal.fire({
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.value) {
      //ajax
      $.ajax({
        url: BASE_URL + "/deleteSportInterst",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          rowid: rowID,
          action: action,

        },
        success: function (resp) {
          if (resp.status == 1) {
            Swal.fire("Deleted!", "Has been deleted.", "success");
            setTimeout(function () {
              // window.location.href = BASE_URL+'/orders'
              location.reload(1);
            }, 500);
          } else {
            Swal.fire("Deleted Alert!", "Cann't not delete", "error");
          }
        },
      });
      //ajax
    }
  });
}

//deleteUser
function deleteUser(rowID) {
  Swal.fire({
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.value) {
      //ajax
      $.ajax({
        url: BASE_URL + "/deleteUser",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          rowid: rowID,
        },
        success: function (resp) {
          if (resp.status == 1) {
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
            setTimeout(function () {
              // window.location.href = BASE_URL+'/orders'
              location.reload(1);
            }, 500);
          } else {
            Swal.fire("Deleted Alert!", "Cann't not delete", "error");
          }
        },
      });
      //ajax
    }
  });
}
//deleteUser

function deleteSchool(rowID) {
  Swal.fire({
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.value) {
      //ajax
      $.ajax({
        url: BASE_URL + "/deleteSchool",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          rowid: rowID,
        },
        success: function (resp) {
          if (resp.status == 1) {
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
            setTimeout(function () {
              // window.location.href = BASE_URL+'/orders'
              location.reload(1);
            }, 500);
          } else {
            Swal.fire("Deleted Alert!", "Cann't not delete", "error");
          }
        },
      });
      //ajax
    }
  });
}

//frmUserInterest
$("#frmUserInterest").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $(this);
  var url = form.attr("action");

  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      Swal.fire("Good job!", "Saved Successfully!", "success");
      //location.reload(1);
     
      
    },
  });
});

$("#frmUserSport").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $(this);
  var url = form.attr("action");

  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      Swal.fire("Good job!", "Saved Successfully!", "success");
      //location.reload(1);
     

    },
  });
});

//frmsaveAdminProfile
$("#frmsaveAdminProfile").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $(this);
  var url = form.attr("action");

  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      //Swal.fire("Good job!", "Saved Successfully!", "success");
      //location.reload(1);
      Swal.fire("Good job!", "Saved Successfully!", "success");
      setTimeout(function () {
        //KTUtil.scrollTop();
       
       
        location.reload();
      }, 1000);
     

    },
  });
});
//frmsaveAdminProfile

//frmUserInterest

$("#frmSchoollHistroy").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $(this);
  var url = form.attr("action");

  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      Swal.fire("Good job!", "Saved Successfully!", "success");
      //location.reload(1);
    },
  });
});

$("#frmSchoolInstructor").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $(this);
  var url = form.attr("action");

  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      Swal.fire("Good job!", "Saved Successfully!", "success");
      //location.reload(1);
    },
  });
});

$("#kt_form_2_frmSport").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $(this);
  var url = form.attr("action");

  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      setTimeout(function () {
        //KTUtil.scrollTop();
       
        Swal.fire("Good job!", "Saved Successfully!", "success");
        location.reload();
      }, 500);

     
      //location.reload(1);
    },
  });
});

$("#kt_form_2_frmSport_intrest").submit(function (e) {
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $(this);
  var url = form.attr("action");

  $.ajax({
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function (data) {
      setTimeout(function () {
        //KTUtil.scrollTop();
        
        Swal.fire("Good job!", "Saved Successfully!", "success");
        location.reload();

      }, 500);
    },
  });
});


//form submit

// Class definition
var KTFormControlsFormSubmit = (function () {
  // Private functions
  var _initAddStaticContent = function () {
    FormValidation.formValidation(
      document.getElementById("kt_form_add_static_content"), {
        fields: {
          title: {
            validators: {
              notEmpty: {
                message: "Please Enter Title",
              },
            },
          },
          status: {
            validators: {
              notEmpty: {
                message: "Please Enter Title",
              },
            },
          },
        },

        plugins: {
          //Learn more: https://formvalidation.io/guide/plugins
          trigger: new FormValidation.plugins.Trigger(),
          // Bootstrap Framework Integration
          bootstrap: new FormValidation.plugins.Bootstrap(),
          // Validate fields when clicking the Submit button
          submitButton: new FormValidation.plugins.SubmitButton(),
          // Submit the form when all fields are valid
          //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        },
      }
    ).on("core.form.valid", function () {
      var _redirect = $("#kt_form_add_static_content").attr("data-redirect");

      var formData = {
        title: $("input[name=title]").val(),
        txtStaticID: $("input[name=txtStaticID]").val(),
        isactive: $("#isactive").val(),
        content: $("#kt-ckeditor-1").html(),
        staticAction: $("input[name=staticAction]").val(),
        _token: $('meta[name="csrf-token"]').attr("content"),
      };

      $.ajax({
        url: BASE_URL + "/saveStaticContent",
        type: "POST",
        data: formData,
        success: function (res) {
          if (res.status == 1) {
            swal
              .fire({
                text: res.msg,
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              })
              .then(function () {
                setTimeout(function () {
                  //KTUtil.scrollTop();
                  // location.reload();
                  var redirect = BASE_URL + "/" + _redirect;
                  location.assign(redirect);
                }, 500);
              });
          } else {
            swal
              .fire({
                text: res.msg,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                customClass: {
                  confirmButton: "btn font-weight-bold btn-light-primary",
                },
              })
              .then(function () {
                KTUtil.scrollTop();
              });
          }
        },
      });
    });
  };

  return {
    // public functions
    init: function () {
      _initAddStaticContent();
      

    },
  };
})();


jQuery(document).ready(function () {
  
  //userActiveActionUser
  $("#userActiveActionUser").change(function () {
    if ($(this).prop("checked") == true) {
      //run code
      statusAction = 1;
      Swal.fire({
        title: "Are you sure?",
        text: "You want to active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, active it!",
      }).then(function (result) {
        if (result.value) {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $("input[name=txtSID]").val(),
            statusAction: statusAction,
            _token: $('meta[name="csrf-token"]').attr("content"),
          };

          $.ajax({
            url: BASE_URL + "/useractionUserIsActive",
            type: "POST",
            data: formData,
            success: function (res) {
              if (res.status == 1) {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              }
            },
          });

          //ajax call
          //ayra ajax
        }
      });
    } else {
      //run code
      statusAction = 2;
      Swal.fire({
        title: "Are you sure?",
        text: "You want to De-Active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, deactive it!",
      }).then(function (result) {
        if (result.value) {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $("input[name=txtSID]").val(),
            statusAction: statusAction,
            _token: $('meta[name="csrf-token"]').attr("content"),
          };

          $.ajax({
            url: BASE_URL + "/useractionUserIsActive",
            type: "POST",
            data: formData,
            success: function (res) {
              if (res.status == 1) {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              } else {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              }
            },
          });

          //ajax call
          //ayra ajax
        }
      });
    }
  });

  //userActiveActionUser

  $("#userActiveAction").change(function () {
    if ($(this).prop("checked") == true) {
      //run code
      statusAction = 1;
      Swal.fire({
        title: "Are you sure?",
        text: "You want to active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, active it!",
      }).then(function (result) {
        if (result.value) {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $("input[name=txtSID]").val(),
            statusAction: statusAction,
            _token: $('meta[name="csrf-token"]').attr("content"),
          };

          $.ajax({
            url: BASE_URL + "/useractionSchoolAccount",
            type: "POST",
            data: formData,
            success: function (res) {
              if (res.status == 1) {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              }
            },
          });

          //ajax call
          //ayra ajax
        }
      });
    } else {
      //run code
      statusAction = 2;
      Swal.fire({
        title: "Are you sure?",
        text: "You want to De-Active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, deactive it!",
      }).then(function (result) {
        if (result.value) {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $("input[name=txtSID]").val(),
            statusAction: statusAction,
            _token: $('meta[name="csrf-token"]').attr("content"),
          };

          $.ajax({
            url: BASE_URL + "/useractionSchoolAccount",
            type: "POST",
            data: formData,
            success: function (res) {
              if (res.status == 1) {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              } else {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              }
            },
          });

          //ajax call
          //ayra ajax
        }
      });
    }
  });
$('#kt_resetA').click(function(){
  location.reload(1);
});

  $("#loginCredentialSend").change(function () {
    if ($(this).prop("checked") == true) {
      //run code
      statusAction = 1;
      Swal.fire({
        title: "Are you sure?",
        text: "You want to created or send credentials",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, sent it!",
      }).then(function (result) {
        if (result.value) {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $("input[name=txtSID]").val(),
            statusAction: statusAction,
            _token: $('meta[name="csrf-token"]').attr("content"),
          };

          $.ajax({
            url: BASE_URL + "/createOrSentSchoolAccount",
            type: "POST",
            data: formData,
            success: function (res) {},
          });

          //ajax call
          //ayra ajax
        }
      });
    } else {
      //run code
      statusAction = 2;
      Swal.fire({
        title: "Are you sure?",
        text: "You want to created or send credentials",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, sent it!",
      }).then(function (result) {
        if (result.value) {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $("input[name=txtSID]").val(),
            statusAction: statusAction,
            _token: $('meta[name="csrf-token"]').attr("content"),
          };

          $.ajax({
            url: BASE_URL + "/createOrSentSchoolAccount",
            type: "POST",
            data: formData,
            success: function (res) {
              if (res.status == 1) {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              } else {
                swal
                  .fire({
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  })
                  .then(function () {
                    KTUtil.scrollTop();
                  });
              }
            },
          });

          //ajax call
          //ayra ajax
        }
      });
    }
  });

  KTFormControlsFormSubmit.init();
  

  //sssssssssssssss

  //sssssssssssssssss
});

//form submit

function removeImage(action, rowID) {
  Swal.fire({
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  }).then(function (result) {
    if (result.value) {
      //ajax
      $.ajax({
        url: BASE_URL + "/deletImage",
        type: "POST",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          action: action,
          rowid: rowID,
        },
        success: function (resp) {
          if (resp.status == 1) {
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
            setTimeout(function () {
              // window.location.href = BASE_URL+'/orders'
              location.reload(1);
            }, 500);
          } else {
            Swal.fire("Deleted Alert!", "Cann't not delete", "error");
          }
        },
      });
      //ajax
    }
  });
}

//superadmin


// save user edit 

  FormValidation.formValidation(
    document.getElementById("kt_form_add_user_data"), {
      fields: {
        name: {
          validators: {
            notEmpty: {
              message: "Please Enter Name",
            },
          },
        },
        phone: {
          validators: {
            notEmpty: {
              message: "Please Enter Phone",
            },
          },
        },
        email: {
          validators: {
            notEmpty: {
              message: "Email is required",
            },
            emailAddress: {
              message: "The value is not a valid email address",
            },
          },
        },
        location: {
          validators: {
            notEmpty: {
              message: "Please Enter Location",
            },
          },
        },
        
      },

      plugins: {
        //Learn more: https://formvalidation.io/guide/plugins
        trigger: new FormValidation.plugins.Trigger(),
        // Bootstrap Framework Integration
        bootstrap: new FormValidation.plugins.Bootstrap(),
        // Validate fields when clicking the Submit button
        submitButton: new FormValidation.plugins.SubmitButton(),
        // Submit the form when all fields are valid
        //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
      },
    }
  ).on("core.form.valid", function () {
    var _redirect = $("#kt_form_add_user_data").attr("data-redirect");

    

    var formData = {
      name: $("input[name=name]").val(),
      phone: $("input[name=phone]").val(),
      gender: $("input[name='gender']:checked").val(),
      txtSID: $("input[name=txtSID]").val(),     
      location: $("input[name=location]").val(),
      _token: $('meta[name="csrf-token"]').attr("content"),
    };

    $.ajax({
      url: BASE_URL + "/saveUserEdit",
      type: "POST",
      data: formData,
      success: function (res) {
        if (res.status == 1) {
          swal
            .fire({
              text: res.msg,
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary",
              },
            })
            .then(function () {
              setTimeout(function () {
                //KTUtil.scrollTop();
                // location.reload();
                var redirect = BASE_URL + "/" + _redirect;
                location.assign(redirect);
              }, 500);
            });
        } else {
          swal
            .fire({
              text: res.msg,
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, got it!",
              customClass: {
                confirmButton: "btn font-weight-bold btn-light-primary",
              },
            })
            .then(function () {
              KTUtil.scrollTop();
            });
        }
      },
    });
  });


//save user edit



//paymentStatusRadio

 //paymentStatusRadio