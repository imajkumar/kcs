// ajax
var formData = {
    title: $("input[name=title]").val(),
    reg_no: $("input[name=reg_no]").val(),
    phone_code: $("input[name=phonecode]").val(),
    phone: $("input[name=phone]").val(),
    email: $("input[name=email]").val(),				
    password: $("input[name=password]").val(),
    admin_comm: $("input[name=admin_comm]").val(),
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