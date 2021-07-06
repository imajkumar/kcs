"use strict";

// Class Definition
var KTLogin = (function () {
  var _login;

  var _showForm = function (form) {
    var cls = "login-" + form + "-on";
    var form = "kt_login_" + form + "_form";

    _login.removeClass("login-forgot-on");
    _login.removeClass("login-signin-on");
    _login.removeClass("login-signup-on");

    _login.addClass(cls);

    KTUtil.animateClass(
      KTUtil.getById(form),
      "animate__animated animate__backInUp"
    );
  };

  var _handleSignInForm = function () {
    var validation;

    // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
    validation = FormValidation.formValidation(
      KTUtil.getById("kt_login_signin_form"),
      {
        fields: {
          email: {
            validators: {
              notEmpty: {
                message: "Email address is required",
              },
              emailAddress: {
                message: "The value is not a valid email address",
              },
            },
          },
          password: {
            validators: {
              notEmpty: {
                message: "Password is required",
              },
            },
          },
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          submitButton: new FormValidation.plugins.SubmitButton(),
          //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
          bootstrap: new FormValidation.plugins.Bootstrap(),
        },
      }
    );

    $("#kt_login_signin_submit").on("click", function (e) {
      e.preventDefault();
      var formID = $("input[name=txtFormID]").val();
     
      if (formID == 1) {
        //login
        // ajax
        var formData = {
          email: $("input[name=email]").val(),
          password: $("input[name=password]").val(),
          _token: $('meta[name="csrf-token"]').attr("content"),
        };
        $.ajax({
          url: BASE_URL + "/customLogin",
          type: "POST",
          data: formData,
          success: function (res) {
            if (res.status == 1) {
              swal
                .fire({
                  text: "Logged Successfully ",
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
                    location.reload();
                  }, 500);
                });
            } else {
              swal
                .fire({
                  text: "Invalid Login credentials, please try again.",
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
        //login
      }

      if (formID == 2) {
        //forget email send
		 // ajax
		 var formData = {
			email: $("input[name=email]").val(),			
			_token: $('meta[name="csrf-token"]').attr("content"),
		  };
		  $.ajax({
			url: BASE_URL + "/postEmail",
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
					  location.reload();
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
        //forget email send
      }
      if (formID == 3) {
        //forget password set send
        // ajax
		 var formData = {
			password: $("input[name=password]").val(),	
      token: $("input[name=token]").val(),	
      password_confirmation: $("input[name=password_confirmation]").val(),			
			_token: $('meta[name="csrf-token"]').attr("content"),
		  };
		  $.ajax({
			url: BASE_URL + "/updatePassword",
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
					  
            window.location.href = BASE_URL;

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

        //forget password set send
      }
    });

    // Handle forgot button
    
  };

  

  // Public Functions
  return {
    // public functions
    init: function () {
      _login = $("#kt_login");

      _handleSignInForm();
      _
    },
  };
})();

// Class Initialization
jQuery(document).ready(function () {
  KTLogin.init();
});