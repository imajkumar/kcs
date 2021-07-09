




( "use strict" );
// Class definition

var KTDropzoneDemo = ( function ()
{
  // Private functions

  var aryaUploadDropZone = function ()
  {
    // set the dropzone container id
    var id = "#kt_dropzone_4_1";

    // set the preview element template
    var previewNode = $( id + " .dropzone-item" );
    previewNode.id = "";
    var previewTemplate = previewNode.parent( ".dropzone-items" ).html();
    previewNode.remove();

    var myDropzone4 = new Dropzone( id, {
      // Make the whole body a dropzone
      url: BASE_URL + "/uploadFile", // Set the url for your upload script location
      parallelUploads: 20,
      previewTemplate: previewTemplate,
      maxFiles: 1,
      acceptedFiles: ".png",
      maxFilesize: 1, // Max filesize in MB
      autoQueue: false, // Make sure the files arent queued until manually added
      previewsContainer: id + " .dropzone-items", // Define the container to display the previews
      clickable: id + " .dropzone-select", // Define the element that should be used as click trigger to select files.
    } );

    myDropzone4.on( "sending", function ( file, xhr, formData )
    {
      formData.append( "_token", $( 'meta[name="csrf-token"]' ).attr( "content" ) );
      formData.append( "txtSID", $( "#txtSID" ).val() );
      formData.append( "action", $( "#uploadFileAction" ).val() );

    } );
    myDropzone4.on( "addedfile", function ( file )
    {
      // Hookup the start button
      file.previewElement.querySelector( id + " .dropzone-start" ).onclick =
        function ()
        {
          myDropzone4.enqueueFile( file );
        };
      $( document )
        .find( id + " .dropzone-item" )
        .css( "display", "" );
      $( id + " .dropzone-upload, " + id + " .dropzone-remove-all" ).css(
        "display",
        "inline-block"
      );
    } );

    // Update the total progress bar
    myDropzone4.on( "totaluploadprogress", function ( progress )
    {
      $( this )
        .find( id + " .progress-bar" )
        .css( "width", progress + "%" );
    } );

    myDropzone4.on( "sending", function ( file )
    {
      // Show the total progress bar when upload starts
      $( id + " .progress-bar" ).css( "opacity", "1" );
      // And disable the start button
      file.previewElement
        .querySelector( id + " .dropzone-start" )
        .setAttribute( "disabled", "disabled" );
    } );

    // Hide the total progress bar when nothing uploading anymore
    myDropzone4.on( "complete", function ( progress )
    {
      var thisProgressBar = id + " .dz-complete";
      setTimeout( function ()
      {
        $(
          thisProgressBar +
          " .progress-bar, " +
          thisProgressBar +
          " .progress, " +
          thisProgressBar +
          " .dropzone-start"
        ).css( "opacity", "0" );
        Swal.fire( "Good job!", "Uploaded Successfully!", "success" );
        location.reload( 1 );
      }, 2000 );
    } );

    // Setup the buttons for all transfers
    document.querySelector( id + " .dropzone-upload" ).onclick = function ()
    {
      myDropzone4.enqueueFiles( myDropzone4.getFilesWithStatus( Dropzone.ADDED ) );
    };

    // Setup the button for remove all files
    document.querySelector( id + " .dropzone-remove-all" ).onclick = function ()
    {
      $( id + " .dropzone-upload, " + id + " .dropzone-remove-all" ).css(
        "display",
        "none"
      );
      myDropzone4.removeAllFiles( true );
    };

    // On all files completed upload
    myDropzone4.on( "queuecomplete", function ( progress )
    {
      $( id + " .dropzone-upload" ).css( "display", "none" );
    } );

    // On all files removed
    myDropzone4.on( "removedfile", function ( file )
    {
      if ( myDropzone4.files.length < 1 )
      {
        $( id + " .dropzone-upload, " + id + " .dropzone-remove-all" ).css(
          "display",
          "none"
        );
      }
    } );
  };








  return {
    // public functions
    init: function ()
    {


      aryaUploadDropZone();




    },
  };
} )();

KTUtil.ready( function ()
{
  KTDropzoneDemo.init();
} );



//myschool
$( "select.myschool" ).change( function ()
{
  var selectedSchool = $( this ).children( "option:selected" ).val();




  //ajax
  $.ajax( {
    url: BASE_URL + "/getSchoolCourse",
    type: "GET",
    data: {
      _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
      selectedSchool: selectedSchool,
      action: 1,


    },
    success: function ( resp )
    {


      $( "select.myschoolCourse" )
        .empty()
        .append( resp );


    },
  } );
  //ajax


} );

$( "select.getWeelDataNext" ).change( function ()
{
  var optN = $( this ).children( "option:selected" ).val();
  var payOPT = $( "input[name=paymentStatusRadio]" ).val();


  //ajax
  $.ajax( {
    url: BASE_URL + "/getCousePaymentByFilterThisWeek",
    type: "GET",
    data: {
      _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
      optN: optN,
      action: 3,
      payOPT: payOPT

    },
    success: function ( resp )
    {
      console.log( resp );
      $( '.showdata' ).html( resp );
    }
  } );

} );
//myschool
$( "input[name=paymentStatusRadio]" ).click( function ()
{
  var optN = $( this ).val();
  $( '.showdata' ).html( '' );

  //ajax
  $.ajax( {
    url: BASE_URL + "/getCousePaymentByFilter",
    type: "GET",
    data: {
      _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
      optN: optN,
      action: 2,

    },
    success: function ( resp )
    {
      console.log( resp );
      $( '.showdata' ).html( resp );
    }
  } );

} );


//deleteMeStatic

//btnPasswordReset
$( '#btnPasswordReset' ).click( function ()
{
  var curr_pass = $( '#current' ).val();
  var new_pass = $( '#password' ).val();
  var confirm_pass = $( '#confirmed' ).val();
  if ( curr_pass == "" )
  {

    Swal.fire( "Password Reset", "Enter Current Password", "error" );
    return false;
  }
  if ( new_pass == "" )
  {

    Swal.fire( "Password Reset", "Enter New Password", "error" );

    return false;
  }
  if ( confirm_pass == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Confirm Password', 'Password Reset' );
    return false;
  }
  if ( confirm_pass != new_pass )
  {

    Swal.fire( "Password Reset", "Password Mismatched", "error" );
    return false;
  }
  var formData = {
    'current': curr_pass,
    'password': new_pass,
    'confirmed': confirm_pass,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'user_id': $( 'meta[name="UUID"]' ).attr( 'content' ),

  };
  $.ajax( {
    url: BASE_URL + '/UserResetPassword',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {

        Swal.fire( "Password Reset", "Password successfully changed", "success" );
        setTimeout( function ()
        {
          //KTUtil.scrollTop();
          // location.reload();
          var redirect = BASE_URL;
          location.assign( redirect );
        }, 500 );
      }
      if ( res.status == 2 )
      {


        Swal.fire( "Password Reset", "Your current password does not matches with the password you provided", "error" );
        return false;
      }
      if ( res.status == 3 )
      {

        Swal.fire( "Password Reset", "New Password cannot be same as your current password. Please choose a different password..", "error" );

      }

    }

  } );




} );
//btnPasswordReset

//deleteCouseCat
function deleteCouseCat( rowID )
{
  Swal.fire( {
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  } ).then( function ( result )
  {
    if ( result.value )
    {
      //ajax
      $.ajax( {
        url: BASE_URL + "/deleteCouseCat",
        type: "POST",
        data: {
          _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          rowid: rowID,
        },
        success: function ( resp )
        {
          if ( resp.status == 1 )
          {
            Swal.fire( "Deleted!", "Your file has been deleted.", "success" );
            setTimeout( function ()
            {
              // window.location.href = BASE_URL+'/orders'
              location.reload( 1 );
            }, 500 );
          } else
          {
            Swal.fire( "Deleted Alert!", "Cann't not delete", "error" );
          }
        },
      } );
      //ajax
    }
  } );
}

//deleteCouseCat

//deleteCouse
function deleteCouse( rowID )
{
  Swal.fire( {
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  } ).then( function ( result )
  {
    if ( result.value )
    {
      //ajax
      $.ajax( {
        url: BASE_URL + "/deleteCouse",
        type: "POST",
        data: {
          _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          rowid: rowID,
        },
        success: function ( resp )
        {
          if ( resp.status == 1 )
          {
            Swal.fire( "Deleted!", "Your file has been deleted.", "success" );
            setTimeout( function ()
            {
              // window.location.href = BASE_URL+'/orders'
              location.reload( 1 );
            }, 500 );
          } else
          {
            Swal.fire( "Deleted Alert!", "Cann't not delete", "error" );
          }
        },
      } );
      //ajax
    }
  } );
}

//deleteCouse

//deleteUserPoint
function deleteUserPoint( rowID )
{
  Swal.fire( {
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  } ).then( function ( result )
  {
    if ( result.value )
    {
      //ajax
      $.ajax( {
        url: BASE_URL + "/deleteUserPoint",
        type: "POST",
        data: {
          _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          rowid: rowID,
        },
        success: function ( resp )
        {
          if ( resp.status == 1 )
          {
            Swal.fire( "Deleted!", "Your file has been deleted.", "success" );
            setTimeout( function ()
            {
              // window.location.href = BASE_URL+'/orders'
              location.reload( 1 );
            }, 500 );
          } else
          {
            Swal.fire( "Deleted Alert!", "Cann't not delete", "error" );
          }
        },
      } );
      //ajax
    }
  } );
}

//deleteUserPoint


//deleteUser
function deleteUser( rowID )
{
  Swal.fire( {
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  } ).then( function ( result )
  {
    if ( result.value )
    {
      //ajax
      $.ajax( {
        url: BASE_URL + "/deleteUser",
        type: "POST",
        data: {
          _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          rowid: rowID,
        },
        success: function ( resp )
        {
          if ( resp.status == 1 )
          {
            Swal.fire( "Deleted!", "Your file has been deleted.", "success" );
            setTimeout( function ()
            {
              // window.location.href = BASE_URL+'/orders'
              location.reload( 1 );
            }, 500 );
          } else
          {
            Swal.fire( "Deleted Alert!", "Cann't not delete", "error" );
          }
        },
      } );
      //ajax
    }
  } );
}
//deleteUser







//frmsaveAdminProfile
$( "#frmsaveAdminProfile" ).submit( function ( e )
{
  e.preventDefault(); // avoid to execute the actual submit of the form.

  var form = $( this );
  var url = form.attr( "action" );

  $.ajax( {
    type: "POST",
    url: url,
    data: form.serialize(), // serializes the form's elements.
    success: function ( data )
    {
      //Swal.fire("Good job!", "Saved Successfully!", "success");
      //location.reload(1);
      Swal.fire( "Good job!", "Saved Successfully!", "success" );
      setTimeout( function ()
      {
        //KTUtil.scrollTop();


        location.reload();
      }, 1000 );


    },
  } );
} );
//frmsaveAdminProfile

//frmUserInterest










//form submit

// Class definition


jQuery( document ).ready( function ()
{

  //userActiveActionUser
  $( "#userActiveActionUser" ).change( function ()
  {
    if ( $( this ).prop( "checked" ) == true )
    {
      //run code
      statusAction = 1;
      Swal.fire( {
        title: "Are you sure?",
        text: "You want to active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, active it!",
      } ).then( function ( result )
      {
        if ( result.value )
        {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $( "input[name=txtSID]" ).val(),
            statusAction: statusAction,
            _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          };

          $.ajax( {
            url: BASE_URL + "/useractionUserIsActive",
            type: "POST",
            data: formData,
            success: function ( res )
            {
              if ( res.status == 1 )
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              }
            },
          } );

          //ajax call
          //ayra ajax
        }
      } );
    } else
    {
      //run code
      statusAction = 2;
      Swal.fire( {
        title: "Are you sure?",
        text: "You want to De-Active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, deactive it!",
      } ).then( function ( result )
      {
        if ( result.value )
        {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $( "input[name=txtSID]" ).val(),
            statusAction: statusAction,
            _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          };

          $.ajax( {
            url: BASE_URL + "/useractionUserIsActive",
            type: "POST",
            data: formData,
            success: function ( res )
            {
              if ( res.status == 1 )
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              } else
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              }
            },
          } );

          //ajax call
          //ayra ajax
        }
      } );
    }
  } );

  //userActiveActionUser

  $( "#userActiveAction" ).change( function ()
  {
    if ( $( this ).prop( "checked" ) == true )
    {
      //run code
      statusAction = 1;
      Swal.fire( {
        title: "Are you sure?",
        text: "You want to active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, active it!",
      } ).then( function ( result )
      {
        if ( result.value )
        {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $( "input[name=txtSID]" ).val(),
            statusAction: statusAction,
            _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          };

          $.ajax( {
            url: BASE_URL + "/useractionSchoolAccount",
            type: "POST",
            data: formData,
            success: function ( res )
            {
              if ( res.status == 1 )
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              }
            },
          } );

          //ajax call
          //ayra ajax
        }
      } );
    } else
    {
      //run code
      statusAction = 2;
      Swal.fire( {
        title: "Are you sure?",
        text: "You want to De-Active Account",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, deactive it!",
      } ).then( function ( result )
      {
        if ( result.value )
        {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $( "input[name=txtSID]" ).val(),
            statusAction: statusAction,
            _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          };

          $.ajax( {
            url: BASE_URL + "/useractionSchoolAccount",
            type: "POST",
            data: formData,
            success: function ( res )
            {
              if ( res.status == 1 )
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              } else
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              }
            },
          } );

          //ajax call
          //ayra ajax
        }
      } );
    }
  } );
  $( '#kt_resetA' ).click( function ()
  {
    location.reload( 1 );
  } );

  $( "#loginCredentialSend" ).change( function ()
  {
    if ( $( this ).prop( "checked" ) == true )
    {
      //run code
      statusAction = 1;
      Swal.fire( {
        title: "Are you sure?",
        text: "You want to created or send credentials",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, sent it!",
      } ).then( function ( result )
      {
        if ( result.value )
        {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $( "input[name=txtSID]" ).val(),
            statusAction: statusAction,
            _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          };

          $.ajax( {
            url: BASE_URL + "/createOrSentSchoolAccount",
            type: "POST",
            data: formData,
            success: function ( res ) { },
          } );

          //ajax call
          //ayra ajax
        }
      } );
    } else
    {
      //run code
      statusAction = 2;
      Swal.fire( {
        title: "Are you sure?",
        text: "You want to created or send credentials",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, sent it!",
      } ).then( function ( result )
      {
        if ( result.value )
        {
          // ajax ayra

          //ajax call
          var formData = {
            txtSID: $( "input[name=txtSID]" ).val(),
            statusAction: statusAction,
            _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          };

          $.ajax( {
            url: BASE_URL + "/createOrSentSchoolAccount",
            type: "POST",
            data: formData,
            success: function ( res )
            {
              if ( res.status == 1 )
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              } else
              {
                swal
                  .fire( {
                    text: res.msg,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                      confirmButton: "btn font-weight-bold btn-light-primary",
                    },
                  } )
                  .then( function ()
                  {
                    KTUtil.scrollTop();
                  } );
              }
            },
          } );

          //ajax call
          //ayra ajax
        }
      } );
    }
  } );

  KTFormControlsFormSubmit.init();


  //sssssssssssssss

  //sssssssssssssssss
} );

//form submit

function removeImage( action, rowID )
{
  Swal.fire( {
    title: "Are you sure?",
    text: "You wont be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
  } ).then( function ( result )
  {
    if ( result.value )
    {
      //ajax
      $.ajax( {
        url: BASE_URL + "/deletImage",
        type: "POST",
        data: {
          _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
          action: action,
          rowid: rowID,
        },
        success: function ( resp )
        {
          if ( resp.status == 1 )
          {
            Swal.fire( "Deleted!", "Your file has been deleted.", "success" );
            setTimeout( function ()
            {
              // window.location.href = BASE_URL+'/orders'
              location.reload( 1 );
            }, 500 );
          } else
          {
            Swal.fire( "Deleted Alert!", "Cann't not delete", "error" );
          }
        },
      } );
      //ajax
    }
  } );
}

//superadmin

//kt_form_add_courseCar_data
FormValidation.formValidation(
  document.getElementById( "kt_form_add_courseCar_data" ), {
  fields: {
    name_cat: {
      validators: {
        notEmpty: {
          message: "Please First Name",
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
).on( "core.form.valid", function ()
{
  var _redirect = $( "#kt_form_add_courseCar_data" ).attr( "data-redirect" );

  var txtAction =$( "input[name=txtAction]" ).val();
  if(txtAction=="__edit"){
  var URLLINK= BASE_URL + "/saveCourseCATEdit";
  }else{
    var URLLINK= BASE_URL + "/saveCourseCATData";
  }

  


  var formData = {
    name_cat: $( "input[name=name_cat]" ).val(),
    txtID: $( "input[name=txtID]" ).val(),
    course_id: $( "#course_id option:selected" ).val(),
   

    _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
  };

  $.ajax( {
    url: URLLINK,
    type: "POST",
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        swal
          .fire( {
            text: res.msg,
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: "Save Successfully!",
            customClass: {
              confirmButton: "btn font-weight-bold btn-light-primary",
            },
          } )
          .then( function ()
          {
            setTimeout( function ()
            {
              //KTUtil.scrollTop();
              // location.reload();
              var redirect = BASE_URL + "/" + _redirect;
              location.assign( redirect );
            }, 500 );
          } );
      } else
      {
        swal
          .fire( {
            text: res.msg,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            customClass: {
              confirmButton: "btn font-weight-bold btn-light-primary",
            },
          } )
          .then( function ()
          {
            KTUtil.scrollTop();
          } );
      }
    },
  } );
} );

//kt_form_add_courseCar_data


//kt_form_add_course_data


//kt_form_add_course_data

// save user edit 




//save user edit


//kt_form_Edit_user_data



//kt_form_Edit_user_data


//paymentStatusRadio

 //paymentStatusRadio