"use strict";

var KTDatatablesSearchOptionsAdvancedSearch_UserList = (function () {
  $.fn.dataTable.Api.register("column().title()", function () {
    return $(this.header()).text().trim();
  });

  var initTable1 = function () {
    // begin first table
    var table = $("#kt_datatable_userList").DataTable({
      responsive: true,
      // Pagination settings
      dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
      // read more: https://datatables.net/examples/basic_init/dom.html

      lengthMenu: [5, 10, 25, 50],

      pageLength: 10,

      language: {
        lengthMenu: "Display _MENU_",
      },

      searchDelay: 500,
      processing: true,
      serverSide: true,
      ajax: {
        url: BASE_URL + "/getDatatableUserList",
        type: "GET",
        data: {
          // parameters for custom backend script demo
          columnsDef: [
            "RecordID",
            "IndexID",
            "photo",
            "name",
            "email",
            "phone",           
            "status",
            "Actions",
          ],
        },
      },
      columns: [
        { data: "RecordID" },
        { data: "IndexID" },
        { data: "photo" },
        { data: "name" },
        { data: "email" },
        { data: "phone" },
       
        { data: "status" },
        { data: "Actions", responsivePriority: -1 },
      ],

      columnDefs: [
        {
          targets: [0],
          visible: !1,
        },
        {
          targets: -1,
          width: 150,
          title: "Actions",
          orderable: false,
          render: function (data, type, full, meta) {
            var EDIT_URL = BASE_URL + "/edit-user/" + full.RecordID;
            var VIEW_URL = BASE_URL + "/view-user/" + full.RecordID;

            return `<a href="${VIEW_URL}" class="btn btn-sm btn-clean btn-icon" title="View Details">\
							<i class="la la-eye"></i>
						</a>						  
					<a href="${EDIT_URL}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
						<i class="la la-edit"></i>\
					</a>\
					<a href="javascript::void(0)" onclick="deleteUser(${full.RecordID})"  class="btn btn-sm btn-clean btn-icon" title="Delete">\
						<i class="la la-trash"></i>\
					</a>\
						`;
          },
        },
        {
          targets: 2,
          width: 50,
          title: "Photo",
          orderable: false,
          render: function (a, t, e, n) {
            return `<div class="symbol symbol-circle symbol-lg-50">
            <img src="${e.photo}" alt="image">
          </div>`;
          },
        },
       
        {
          targets: 6,
          width: 50,
          title: "Status",
          orderable: false,
          render: function (a, t, e, n) {
            var i = {
              1: {
                title: "Active",
                class: "primary",
              },
              2: {
                title: "Deactive",
                class: "danger",
              },
            };
            //return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"
            return (
              '<span class="font-weight-bold text-' +
              i[a].class +
              '">' +
              i[a].title +
              "</span>"
            );
          },
        },
      ],
    });

    var filter = function () {
      var val = $.fn.dataTable.util.escapeRegex($(this).val());
      table
        .column($(this).data("col-index"))
        .search(val ? val : "", false, false)
        .draw();
    };

    var asdasd = function (value, index) {
      var val = $.fn.dataTable.util.escapeRegex(value);
      table.column(index).search(val ? val : "", false, true);
    };

    $("#kt_search").on("click", function (e) {
      e.preventDefault();
      var params = {};
      $(".datatable-input").each(function () {
        var i = $(this).data("col-index");
        if (params[i]) {
          params[i] += "|" + $(this).val();
        } else {
          params[i] = $(this).val();
        }
      });
      $.each(params, function (i, val) {
        // apply search params to datatable
        table.column(i).search(val ? val : "", false, false);
      });
      table.table().draw();
    });

    $("#kt_reset").on("click", function (e) {
      e.preventDefault();
      $(".datatable-input").each(function () {
        $(this).val("");
        table.column($(this).data("col-index")).search("", false, false);
      });
      table.table().draw();
    });

    $("#kt_datepicker").datepicker({
      todayHighlight: true,
      templates: {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>',
      },
    });
  };

  return {
    //main function to initiate the module
    init: function () {
      initTable1();
    },
  };
})();

jQuery(document).ready(function () {
  
  KTDatatablesSearchOptionsAdvancedSearch_UserList.init();
});




