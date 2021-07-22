// Class definition
var KTFormControls = function () {
	// Private functions
	var _initDemo1 = function () {

		FormValidation.formValidation(
            document.getElementById( "kt_form_add_user_data" ), {
            fields: {
              firstname: {
                validators: {
                  notEmpty: {
                    message: "Please First Name",
                  },
                },
              },
              lastname: {
                validators: {
                  notEmpty: {
                    message: "Please First Name",
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
              user_position: {
                validators: {
                  notEmpty: {
                    message: "Please Enter Position",
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
              //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),  dd
            },
          }
          ).on( "core.form.valid", function ()
          {
            var _redirect = $( "#kt_form_add_user_data" ).attr( "data-redirect" );
          
            var txtAction =$( "input[name=txtAction]" ).val();
            if(txtAction=="__edit"){
              var URLLINK= BASE_URL + "/saveUserEdit";
            }else{
              
              var URLLINK= BASE_URL + "/saveUserData";
            }

          
            
          
          
            var formData = {
              firstname: $( "input[name=firstname]" ).val(),
              txtSID: $( "input[name=txtSID]" ).val(),
              lastname: $( "input[name=lastname]" ).val(),
              phone: $( "input[name=phone]" ).val(),
              email: $( "input[name=email]" ).val(),
              user_address: $( "input[name=user_address]" ).val(),
              user_position: $( "input[name=user_position]" ).val(),
              gender: $('select[name="gender"]').val(),
              user_position: $( "input[name=user_position]" ).val(),
          
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
	}

	var _initDemo2 = function () {
		FormValidation.formValidation(
            document.getElementById( "kt_form_Edit_user_data" ), {
            fields: {
              firstname: {
                validators: {
                  notEmpty: {
                    message: "Please First Name5",
                  },
                },
              },
              lastname: {
                validators: {
                  notEmpty: {
                    message: "Please First Name",
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
              user_position: {
                validators: {
                  notEmpty: {
                    message: "Please Enter Position",
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
            var _redirect = $( "#kt_form_Edit_user_data" ).attr( "data-redirect" );
          
          
          
            var formData = {
              firstname: $( "input[name=firstname]" ).val(),
              lastname: $( "input[name=lastname]" ).val(),
              phone: $( "input[name=phone]" ).val(),
              email: $( "input[name=email]" ).val(),
              user_position: $( "input[name=user_position]" ).val(),
              gender: $('select[name="gender"]').val(),
              user_position: $( "input[name=user_position]" ).val(),
          
              _token: $( 'meta[name="csrf-token"]' ).attr( "content" ),
            };
          
            $.ajax( {
              url: BASE_URL + "/saveUserEdit",
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
	}
    var _initDemo3 = function () {
		FormValidation.formValidation(
            document.getElementById( "kt_form_add_course_data" ), {
            fields: {
              name: {
                validators: {
                  notEmpty: {
                    message: "Please Course Name",
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
            var _redirect = $( "#kt_form_add_course_data" ).attr( "data-redirect" );
          
            var txtAction =$( "input[name=txtAction]" ).val();
            if(txtAction=="__edit"){
            var URLLINK= BASE_URL + "/saveCourseEdit";
            }else{
              var URLLINK= BASE_URL + "/saveCourseData";
            }
          
            
          
          
            var formData = {
              name: $( "input[name=name]" ).val(),
              txtID: $( "input[name=txtID]" ).val(),
             
          
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
          
	}
    var _initDemo4 = function () {
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
	}

	return {
		// public functions
		init: function() {
			_initDemo1();
			_initDemo2();
			//_initDemo3();
			//_initDemo4();
		}
	};
}();

jQuery(document).ready(function() {
	KTFormControls.init();

 


});



 //addded course 
 FormValidation.formValidation(
  
  document.getElementById( "kt_form_add_user_dataCouser" ), {
  fields: {
    user_id: {
      validators: {
        notEmpty: {
          message: "Please First Name",
        },
      },
    },
    course_id: {
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
    //defaultSubmit: new FormValidation.plugins.DefaultSubmit(),  dd
  },
}
).on( "core.form.valid", function ()
{
  var _redirect = $( "#kt_form_add_user_dataCouser" ).attr( "data-redirect" );

  var txtAction =$( "input[name=txtAction]" ).val();
  if(txtAction=="__edit"){
    var URLLINK= BASE_URL + "/saveUserCouserEdit";
  }else{
    
    var URLLINK= BASE_URL + "/saveUserCouser";
  }


  
  

  var formData = {
   
    user_id: $( "select[name=user_id]" ).val(),
    course_id: $( "select[name=course_id]" ).val(),    

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
            confirmButtonText: "Submited Successfully!",
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

//addded course 