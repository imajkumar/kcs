"use strict";
var KTDatatablesSearchOptionsAdvancedSearch = (function () {
  $.fn.dataTable.Api.register("column().title()", function () {
    return $(this.header()).text().trim();
  });

  var initTable1 = function () {
    // begin first table
    var schoolListFrom = $("#schoolListFrom").val();

    var table = $("#kt_datatable_schoolList").DataTable({
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
        url: BASE_URL + "/getDatatableSchoolList",
        type: "GET",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          schoolListFrom: schoolListFrom,

          // parameters for custom backend script demo
          columnsDef: [
            "RecordID",
            "school_title",
            "IndexID",
            "rating",
            "city",
            "email",
            "status",
            "profile_status",
            "Actions",
          ],
        },
      },
      columns: [
        { data: "RecordID" },
        { data: "IndexID" },
        { data: "school_title" },
        { data: "rating" },
        { data: "city" },
        { data: "email" },
        { data: "status" },
        { data: "profile_status" },
        { data: "Actions", responsivePriority: -1 },
      ],

      initComplete: function () {
        this.api()
          .columns()
          .every(function () {
            var column = this;

            switch (column.title()) {
              case "Country":
                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    $('.datatable-input[data-col-index="2"]').append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
                break;

              case "Status":
                var status = {
                  1: { title: "Pending", class: "label-light-primary" },
                  2: { title: "Delivered", class: " label-light-danger" },
                  3: { title: "Canceled", class: " label-light-primary" },
                  4: { title: "Success", class: " label-light-success" },
                  5: { title: "Info", class: " label-light-info" },
                  6: { title: "Danger", class: " label-light-danger" },
                  7: { title: "Warning", class: " label-light-warning" },
                };
                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    $('.datatable-input[data-col-index="6"]').append(
                      '<option value="' +
                        d +
                        '">' +
                        status[d].title +
                        "</option>"
                    );
                  });
                break;

              case "Type":
                var status = {
                  1: { title: "Online", state: "danger" },
                  2: { title: "Retail", state: "primary" },
                  3: { title: "Direct", state: "success" },
                };
                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    $('.datatable-input[data-col-index="7"]').append(
                      '<option value="' +
                        d +
                        '">' +
                        status[d].title +
                        "</option>"
                    );
                  });
                break;
            }
          });
      },

      columnDefs: [
        {
          targets: [0],
          visible: !1,
        },
        {
          targets: -1,

          title: "Actions",
          orderable: false,
          render: function (data, type, full, meta) {
            var EDIT_URL = BASE_URL + "/edit-school/" + full.RecordID;
            var VIEW_URL = BASE_URL + "/view-school/" + full.RecordID;

            return `<a href="${VIEW_URL}" class="btn btn-sm btn-clean btn-icon" title="View Details">\
        <i class="la la-eye"></i>
      </a>						  
    <a href="${EDIT_URL}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
      <i class="la la-edit"></i>
    </a>
    <a href="javascript::void(0)" onclick="deleteSchool(${full.RecordID})"  class="btn btn-sm btn-clean btn-icon" title="Delete">\
      <i class="la la-trash"></i>
    </a>
    <a class="btn btn-sm btn-icon btn-bg-light btn-icon-warning btn-hover-warning" href="#" data-toggle="modal" data-target="#kt_chat_modal">
       <i class="flaticon2-chat-1"></i>
   </a>
      `;
          },
        },
        {
          targets: 3,
          width: 175,
          render: function (data, type, full, meta) {
            var strRating = "";
            switch (parseFloat(data)) {
              case 1:
                strRating = `
                                <i class="icon-xl la la-star text-warning" ></i>
                                <i class="icon-xl la la-star " ></i>                                
                                <i class="icon-xl la la-star " ></i>
                                <i class="icon-xl la la-star " ></i>
                                <i class="icon-xl la la-star" ></i>
                               
                               
                                `;
                break;
              case 1.5:
                strRating = `
                                    <i class="icon-xl la la-star text-warning" ></i>
                                    <i class="icon-xl la la-star-half-alt text-warning"></i>                             
                                    <i class="icon-xl la la-star " ></i>
                                    <i class="icon-xl la la-star " ></i>
                                    <i class="icon-xl la la-star" ></i>
                                   
                                   
                                    `;
                break;
              case 2:
                strRating = `
                                        <i class="icon-xl la la-star text-warning" ></i>
                                        <i class="icon-xl la la-star text-warning" ></i>                        
                                        <i class="icon-xl la la-star " ></i>
                                        <i class="icon-xl la la-star " ></i>
                                        <i class="icon-xl la la-star" ></i>
                                       
                                       
                                        `;
                break;
              case 2.5:
                strRating = `
                                            <i class="icon-xl la la-star text-warning" ></i>
                                            <i class="icon-xl la la-star text-warning" ></i>                        
                                            <i class="icon-xl la la-star-half-alt text-warning"></i>
                                            <i class="icon-xl la la-star " ></i>
                                            <i class="icon-xl la la-star" ></i>
                                           
                                           
                                            `;
                break;
              case 3:
                strRating = `
                                            <i class="icon-xl la la-star text-warning" ></i>
                                            <i class="icon-xl la la-star text-warning" ></i>                        
                                            <i class="icon-xl la la-star text-warning" ></i> 
                                            <i class="icon-xl la la-star " ></i>
                                            <i class="icon-xl la la-star" ></i>
                                           
                                           
                                            `;
                break;

              case 3.5:
                strRating = `
                                            <i class="icon-xl la la-star text-warning" ></i>
                                            <i class="icon-xl la la-star text-warning" ></i>                        
                                            <i class="icon-xl la la-star text-warning" ></i> 
                                            <i class="icon-xl la la-star-half-alt text-warning"></i>
                                            <i class="icon-xl la la-star" ></i>
                                           
                                           
                                            `;
                break;
              case 4:
                strRating = `
                                                <i class="icon-xl la la-star text-warning" ></i>
                                                <i class="icon-xl la la-star text-warning" ></i>                        
                                                <i class="icon-xl la la-star text-warning" ></i> 
                                                <i class="icon-xl la la-star text-warning" ></i> 
                                                <i class="icon-xl la la-star" ></i>
                                               
                                               
                                                `;
                break;
              case 4.5:
                strRating = `
                                    <i class="icon-xl la la-star text-warning" ></i>
                                    <i class="icon-xl la la-star text-warning" ></i>                                
                                    <i class="icon-xl la la-star text-warning" ></i>
                                    <i class="icon-xl la la-star text-warning" ></i>                                
                                    <i class="icon-xl la la-star-half-alt text-warning"></i>
                                   
                                    `;
                break;
              case 5:
                strRating = `
                                    <i class="icon-xl la la-star text-warning" ></i>
                                    <i class="icon-xl la la-star text-warning" ></i>                                
                                    <i class="icon-xl la la-star text-warning" ></i>
                                    <i class="icon-xl la la-star text-warning" ></i>                                
                                    <i class="icon-xl la la-star text-warning" ></i>        
                                   
                                    `;
                break;

              default:
                strRating = `NA`;
                break;
            }
            return "(" + data + "/5)<br>" + strRating;
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
        {
          targets: 7,
          width: 50,
          title: "Status",
          orderable: false,
          render: function (a, t, e, n) {
            var i = {
              1: {
                title: "Completed",
                class: "primary",
              },
              2: {
                title: "Incomplete",
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
  var initTable22 = function () {
    // begin first table
    var schoolListFrom = $("#schoolListFrom").val();

    var table = $("#kt_datatable_schoolListREQ").DataTable({
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
        url: BASE_URL + "/getDatatableSchoolListData",
        type: "GET",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          schoolListFrom: schoolListFrom,

          // parameters for custom backend script demo
          columnsDef: [
            "RecordID",
            "is_approved",
            "school_title",
            "IndexID",
            "rating",
            "city",
            "email",
            "status",
            "profile_status",
            "Actions",
          ],
        },
      },
      columns: [
        { data: "RecordID" },
        { data: "IndexID" },
        { data: "school_title" },
        { data: "city" },
        { data: "email" },
        { data: "is_approved" },
        { data: "Actions", responsivePriority: -1 },
      ],

      initComplete: function () {
        this.api()
          .columns()
          .every(function () {
            var column = this;

            switch (column.title()) {
              case "Country":
                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    $('.datatable-input[data-col-index="2"]').append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
                break;

              case "Status":
                var status = {
                  1: { title: "Pending", class: "label-light-primary" },
                  2: { title: "Delivered", class: " label-light-danger" },
                  3: { title: "Canceled", class: " label-light-primary" },
                  4: { title: "Success", class: " label-light-success" },
                  5: { title: "Info", class: " label-light-info" },
                  6: { title: "Danger", class: " label-light-danger" },
                  7: { title: "Warning", class: " label-light-warning" },
                };
                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    $('.datatable-input[data-col-index="6"]').append(
                      '<option value="' +
                        d +
                        '">' +
                        status[d].title +
                        "</option>"
                    );
                  });
                break;

              case "Type":
                var status = {
                  1: { title: "Online", state: "danger" },
                  2: { title: "Retail", state: "primary" },
                  3: { title: "Direct", state: "success" },
                };
                column
                  .data()
                  .unique()
                  .sort()
                  .each(function (d, j) {
                    $('.datatable-input[data-col-index="7"]').append(
                      '<option value="' +
                        d +
                        '">' +
                        status[d].title +
                        "</option>"
                    );
                  });
                break;
            }
          });
      },

      columnDefs: [
        {
          targets: [0],
          visible: !1,
        },
        {
          targets: -1,

          title: "Actions",
          orderable: false,
          render: function (data, type, full, meta) {
            var EDIT_URL = BASE_URL + "/edit-school/" + full.RecordID;
            var VIEW_URL = BASE_URL + "/view-school-requested/" + full.RecordID;

            

            var HTML =`<a href="${VIEW_URL}" class="btn btn-sm btn-clean btn-icon" title="View Details">\
							<i class="la la-eye"></i>
						</a>						  
				
					<a href="javascript::void(0)" onclick="deleteSchool(${full.RecordID})"  class="btn btn-sm btn-clean btn-icon" title="Delete">\
						<i class="la la-trash"></i>
					</a>`;
        
          if(full.is_approved!=2){
           
          }
          if(full.is_approved===0){
          
    
    
          HTML +=`<a style="margin:1px" class="btn btn-sm btn-icon btn-bg-light btn-icon" href="javascript:void(0)" onclick="schoolApprovalAction(1,${full.RecordID})" >
          
          <i class="icon-1x text-green-50 flaticon2-check-mark" style="color:green"></i>

      </a>`;

      HTML +=`<a style="margin:1px" class="btn btn-sm btn-icon btn-bg-light btn-icon-primary" href="javascript:void(0)" onclick="schoolApprovalAction(2,${full.RecordID})" >
      <i class="icon-1x text-red-50 flaticon2-cancel-music" style="color:red"></i>
           </a>`;

          }else{

          }
         
         

 
         
						return HTML;
          },
        },

        {
          targets: 5,
          width: 50,
          title: "Approval Status",
          orderable: false,
          render: function (a, t, e, n) {
            var i = {
              0: {
                title: "Pending",
                class: "primary",
              },
              1: {
                title: "Approved",
                class: "primary",
              },
              2: {
                title: "Rejected",
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
//
//kt_datatable_schoolCertificate
var initTableA2 = function() {
  // begin first table
 
  var table = $('#kt_datatable_schoolPerformance').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolPerformance',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID', 'school_title', 'avg_rating', 'rating',
          'country_name','Actions',],
      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},
      {data: 'school_title'},
      {data: 'rating'},
      {data: 'avg_rating'},
      {data: 'country_name'},  
      {data: 'Actions', responsivePriority: -1},
    ],

   

    columnDefs: [
      {
        targets: [0],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
              <i class="la la-eye"></i>
            </a>
            
          `;
        },
      },
      {
        targets: 2,
        title: 'School',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="" title="">\
             ${full.school_title}
            </a>
            
          `;
        },
      },
      {
        targets: 4,
        width: 175,
        render: function (data, type, full, meta) {
          var strRating = "";
          switch (parseFloat(data)) {
            case 1:
              strRating = `
                              <i class="icon-xl la la-star text-warning" ></i>
                              <i class="icon-xl la la-star " ></i>                                
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star" ></i>
                             
                             
                              `;
              break;
            case 1.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>                             
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star" ></i>
                                 
                                 
                                  `;
              break;
            case 2:
              strRating = `
                                      <i class="icon-xl la la-star text-warning" ></i>
                                      <i class="icon-xl la la-star text-warning" ></i>                        
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star" ></i>
                                     
                                     
                                      `;
              break;
            case 2.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 3:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;

            case 3.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 4:
              strRating = `
                                              <i class="icon-xl la la-star text-warning" ></i>
                                              <i class="icon-xl la la-star text-warning" ></i>                        
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star" ></i>
                                             
                                             
                                              `;
              break;
            case 4.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>
                                 
                                  `;
              break;
            case 5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>        
                                 
                                  `;
              break;

            default:
              strRating = `NA`;
              break;
          }
          return "(" + data + "/5)<br>" + strRating;
        },
      },
     
    ],
  });

  var filter = function() {
    var val = $.fn.dataTable.util.escapeRegex($(this).val());
    table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
  };

  var asdasd = function(value, index) {
    var val = $.fn.dataTable.util.escapeRegex(value);
    table.column(index).search(val ? val : '', false, true);
  };

  $('#kt_search').on('click', function(e) {
    e.preventDefault();
    var params = {};
    $('.datatable-input').each(function() {
      var i = $(this).data('col-index');
      if (params[i]) {
        params[i] += '|' + $(this).val();
      }
      else {
        params[i] = $(this).val();
      }
    });
    $.each(params, function(i, val) {
      // apply search params to datatable
      table.column(i).search(val ? val : '', false, false);
    });
    table.table().draw();
  });

  $('#kt_reset').on('click', function(e) {
    e.preventDefault();
    $('.datatable-input').each(function() {
      $(this).val('');
      table.column($(this).data('col-index')).search('', false, false);
    });
    table.table().draw();
  });

  $('#kt_datepicker').datepicker({
    todayHighlight: true,
    templates: {
      leftArrow: '<i class="la la-angle-left"></i>',
      rightArrow: '<i class="la la-angle-right"></i>',
    },
  });

};

var initTableA3 = function() {
  // begin first table
 var sid=$('#txtSID').val();
  var table = $('#kt_datatable_schoolRatingComment').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolRatingComments',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID', 'user_id','school_title', 'rating', 'user_name','created_at','comment',
          'user_pic','Actions',],
          sid:sid
      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},    
      {data: 'user_pic'},
      {data: 'rating'},
      {data: 'comment'},  
      {data: 'created_at'},  
      {data: 'Actions', responsivePriority: -1},
    ],

   

    columnDefs: [
      {
        targets: [0,-1],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            
            
          `;
        },
      },
      {
        targets: 2,
        width: 150,
        title: "Photo",
        orderable: false,
        render: function (a, t, e, n) {
         var  userLINK=BASE_URL+"/view-user/"+e.user_id;
          return `<a href="${userLINK}"><div class="symbol symbol-circle symbol-lg-25">
          <img src="${e.user_pic}" alt="image">
        </div>  <span style="margin-top: 2px;
        position: absolute;
        margin-left: 8px;
        text-transform: capitalize;">${e.user_name} </span></a>`;
        },
      },
      {
        targets: 3,
        width: 175,
        render: function (data, type, full, meta) {
          var strRating = "";
          switch (parseFloat(data)) {
            case 1:
              strRating = `
                              <i class="icon-xl la la-star text-warning" ></i>
                              <i class="icon-xl la la-star " ></i>                                
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star" ></i>
                             
                             
                              `;
              break;
            case 1.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>                             
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star" ></i>
                                 
                                 
                                  `;
              break;
            case 2:
              strRating = `
                                      <i class="icon-xl la la-star text-warning" ></i>
                                      <i class="icon-xl la la-star text-warning" ></i>                        
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star" ></i>
                                     
                                     
                                      `;
              break;
            case 2.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 3:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;

            case 3.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 4:
              strRating = `
                                              <i class="icon-xl la la-star text-warning" ></i>
                                              <i class="icon-xl la la-star text-warning" ></i>                        
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star" ></i>
                                             
                                             
                                              `;
              break;
            case 4.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>
                                 
                                  `;
              break;
            case 5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>        
                                 
                                  `;
              break;

            default:
              strRating = `NA`;
              break;
          }
          return "(" + data + "/5)<br>" + strRating;
        },
      },
      {
        targets: 4,
        width: 400,
        title: "Comments",
        orderable: false,
        render: function (a, t, e, n) {
          return e.comment;
        }
      }
    ],
  });

  var filter = function() {
    var val = $.fn.dataTable.util.escapeRegex($(this).val());
    table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
  };

  var asdasd = function(value, index) {
    var val = $.fn.dataTable.util.escapeRegex(value);
    table.column(index).search(val ? val : '', false, true);
  };

  $('#kt_search').on('click', function(e) {
    e.preventDefault();
    var params = {};
    $('.datatable-input').each(function() {
      var i = $(this).data('col-index');
      if (params[i]) {
        params[i] += '|' + $(this).val();
      }
      else {
        params[i] = $(this).val();
      }
    });
    $.each(params, function(i, val) {
      // apply search params to datatable
      table.column(i).search(val ? val : '', false, false);
    });
    table.table().draw();
  });

  $('#kt_reset').on('click', function(e) {
    e.preventDefault();
    $('.datatable-input').each(function() {
      $(this).val('');
      table.column($(this).data('col-index')).search('', false, false);
    });
    table.table().draw();
  });

  $('#kt_datepicker').datepicker({
    todayHighlight: true,
    templates: {
      leftArrow: '<i class="la la-angle-left"></i>',
      rightArrow: '<i class="la la-angle-right"></i>',
    },
  });

};

var initTableA1 = function() {
  // begin first table
 
  var table = $('#kt_datatable_schoolCertificate').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolCertificates',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID', 'school_title', 'certificate_title', 'total_student',
          'course_date','Actions',],
      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},
      {data: 'school_title'},
      {data: 'certificate_title'},
      {data: 'total_student'},
      {data: 'course_date'},     
     
      {data: 'Actions', responsivePriority: -1},
    ],

    initComplete: function() {
      this.api().columns().every(function() {
        var column = this;

        switch (column.title()) {
          case 'Country':
            column.data().unique().sort().each(function(d, j) {
              $('.datatable-input[data-col-index="2"]').append('<option value="' + d + '">' + d + '</option>');
            });
            break;

          case 'Status':
            var status = {
              1: {'title': 'Pending', 'class': 'label-light-primary'},
              2: {'title': 'Delivered', 'class': ' label-light-danger'},
              3: {'title': 'Canceled', 'class': ' label-light-primary'},
              4: {'title': 'Success', 'class': ' label-light-success'},
              5: {'title': 'Info', 'class': ' label-light-info'},
              6: {'title': 'Danger', 'class': ' label-light-danger'},
              7: {'title': 'Warning', 'class': ' label-light-warning'},
            };
            column.data().unique().sort().each(function(d, j) {
              $('.datatable-input[data-col-index="6"]').append('<option value="' + d + '">' + status[d].title + '</option>');
            });
            break;

          case 'Type':
            var status = {
              1: {'title': 'Online', 'state': 'danger'},
              2: {'title': 'Retail', 'state': 'primary'},
              3: {'title': 'Direct', 'state': 'success'},
            };
            column.data().unique().sort().each(function(d, j) {
              $('.datatable-input[data-col-index="7"]').append('<option value="' + d + '">' + status[d].title + '</option>');
            });
            break;
        }
      });
    },

    columnDefs: [
      {
        targets: [0],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var schoolCerDetail=BASE_URL+"/getEnrollSchool/"+full.RecordID;
          return `
            
            <a href="${schoolCerDetail}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
              <i class="la la-eye"></i>
            </a>
            
          `;
        },
      },
     
    ],
  });

  var filter = function() {
    var val = $.fn.dataTable.util.escapeRegex($(this).val());
    table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
  };

  var asdasd = function(value, index) {
    var val = $.fn.dataTable.util.escapeRegex(value);
    table.column(index).search(val ? val : '', false, true);
  };

  $('#kt_search').on('click', function(e) {
    e.preventDefault();
    var params = {};
    $('.datatable-input').each(function() {
      var i = $(this).data('col-index');
      if (params[i]) {
        params[i] += '|' + $(this).val();
      }
      else {
        params[i] = $(this).val();
      }
    });
    $.each(params, function(i, val) {
      // apply search params to datatable
      table.column(i).search(val ? val : '', false, false);
    });
    table.table().draw();
  });

  $('#kt_reset').on('click', function(e) {
    e.preventDefault();
    $('.datatable-input').each(function() {
      $(this).val('');
      table.column($(this).data('col-index')).search('', false, false);
    });
    table.table().draw();
  });

  $('#kt_datepicker').datepicker({
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
      initTable22();
      initTableA1();
      initTableA2();
      initTableA3();

    },
  };
})();

//function 
//btnDateRenage
$('#btnDateRenage').click(function(){
  var startDate=$('#startDate').val();
  var endDate=$('#endDate').val();
  var sid =$( ".myschool option:selected" ).val();
  var course =$( ".myschoolCourse option:selected" ).val();
  var getWeelData =$( ".getWeelData option:selected" ).val();
  

  $( "#kt_datatable_schoolCertificate" ).dataTable().fnDestroy();

  var table = $('#kt_datatable_schoolCertificate').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolCertificatesBYFilter',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID', 'school_title', 'certificate_title', 'total_student',
          'course_date','Actions',],
          startDate:startDate,
          endDate:endDate,
          sid:sid,
          course:course        




      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},
      {data: 'school_title'},
      {data: 'certificate_title'},
      {data: 'total_student'},
      {data: 'course_date'},     
     
      {data: 'Actions', responsivePriority: -1},
    ],

    initComplete: function() {
      this.api().columns().every(function() {
        var column = this;

        switch (column.title()) {
          case 'Country':
            column.data().unique().sort().each(function(d, j) {
              $('.datatable-input[data-col-index="2"]').append('<option value="' + d + '">' + d + '</option>');
            });
            break;

          case 'Status':
            var status = {
              1: {'title': 'Pending', 'class': 'label-light-primary'},
              2: {'title': 'Delivered', 'class': ' label-light-danger'},
              3: {'title': 'Canceled', 'class': ' label-light-primary'},
              4: {'title': 'Success', 'class': ' label-light-success'},
              5: {'title': 'Info', 'class': ' label-light-info'},
              6: {'title': 'Danger', 'class': ' label-light-danger'},
              7: {'title': 'Warning', 'class': ' label-light-warning'},
            };
            column.data().unique().sort().each(function(d, j) {
              $('.datatable-input[data-col-index="6"]').append('<option value="' + d + '">' + status[d].title + '</option>');
            });
            break;

          case 'Type':
            var status = {
              1: {'title': 'Online', 'state': 'danger'},
              2: {'title': 'Retail', 'state': 'primary'},
              3: {'title': 'Direct', 'state': 'success'},
            };
            column.data().unique().sort().each(function(d, j) {
              $('.datatable-input[data-col-index="7"]').append('<option value="' + d + '">' + status[d].title + '</option>');
            });
            break;
        }
      });
    },

    columnDefs: [
      {
        targets: [0],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var schoolCerDetail=BASE_URL+"/getEnrollSchool/"+full.RecordID;
          return `
            
            <a href="${schoolCerDetail}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
              <i class="la la-eye"></i>
            </a>
            
          `;
        },
      },
     
    ],
  });


  


 


  
  
  //start 
 

  //start 
});
//btnDateRenage
//starRadioTOP
$("input[name=starRadioTOP]").click(function(){
 

  //var countryID = $(this).children("option:selected").val(); 
  //var countryID =$('.ajcountry option:selected').val('id');
 var countryID =$( "#myselect option:selected" ).val();


  var starRadioVal=$('input[name="starRadio"]:checked').val();
  var starRadioTOPVal=$('input[name="starRadioTOP"]:checked').val();
    
  $( "#kt_datatable_schoolPerformance" ).dataTable().fnDestroy();
  var table = $('#kt_datatable_schoolPerformance').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolPerformanceFilterCountry',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID', 'school_title', 'avg_rating', 'rating',
          'country_name','Actions',],
          countryID:countryID,
          starRadioVal:starRadioVal,
          starRadioTOPVal:starRadioTOPVal

      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},
      {data: 'school_title'},
      {data: 'rating'},
      {data: 'avg_rating'},
      {data: 'country_name'},  
      {data: 'Actions', responsivePriority: -1},
    ],

   

    columnDefs: [
      {
        targets: [0],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="" title="">\
              <i class="la la-eye"></i>
            </a>
            
          `;
        },
      },
      {
        targets: 2,
        title: 'School',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="" title="Edit details">\
             ${full.school_title}
            </a>
            
          `;
        },
      },
      {
        targets: 4,
        width: 175,
        render: function (data, type, full, meta) {
          var strRating = "";
          switch (parseFloat(data)) {
            case 1:
              strRating = `
                              <i class="icon-xl la la-star text-warning" ></i>
                              <i class="icon-xl la la-star " ></i>                                
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star" ></i>
                             
                             
                              `;
              break;
            case 1.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>                             
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star" ></i>
                                 
                                 
                                  `;
              break;
            case 2:
              strRating = `
                                      <i class="icon-xl la la-star text-warning" ></i>
                                      <i class="icon-xl la la-star text-warning" ></i>                        
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star" ></i>
                                     
                                     
                                      `;
              break;
            case 2.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 3:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;

            case 3.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 4:
              strRating = `
                                              <i class="icon-xl la la-star text-warning" ></i>
                                              <i class="icon-xl la la-star text-warning" ></i>                        
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star" ></i>
                                             
                                             
                                              `;
              break;
            case 4.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>
                                 
                                  `;
              break;
            case 5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>        
                                 
                                  `;
              break;

            default:
              strRating = `NA`;
              break;
          }
          return "(" + data + "/5)<br>" + strRating;
        },
      },
     
    ],
  });


 

  
})

//starRadioTOP

//ajcountry

$("select.ajcountry").change(function(){
  var countryID = $(this).children("option:selected").val();  
  var starRadioVal=$('input[name="starRadio"]:checked').val();
  var starRadioTOPVal=$('input[name="starRadioTOP"]:checked').val();
    
  $( "#kt_datatable_schoolPerformance" ).dataTable().fnDestroy();
  var table = $('#kt_datatable_schoolPerformance').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolPerformanceFilterCountry',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID', 'school_title', 'avg_rating', 'rating',
          'country_name','Actions',],
          countryID:countryID,
          starRadioVal:starRadioVal,
          starRadioTOPVal:starRadioTOPVal

      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},
      {data: 'school_title'},
      {data: 'rating'},
      {data: 'avg_rating'},
      {data: 'country_name'},  
      {data: 'Actions', responsivePriority: -1},
    ],

   

    columnDefs: [
      {
        targets: [0],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="" title="">\
              <i class="la la-eye"></i>
            </a>
            
          `;
        },
      },
      {
        targets: 2,
        title: 'School',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="" title="Edit details">\
             ${full.school_title}
            </a>
            
          `;
        },
      },
      {
        targets: 4,
        width: 175,
        render: function (data, type, full, meta) {
          var strRating = "";
          switch (parseFloat(data)) {
            case 1:
              strRating = `
                              <i class="icon-xl la la-star text-warning" ></i>
                              <i class="icon-xl la la-star " ></i>                                
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star" ></i>
                             
                             
                              `;
              break;
            case 1.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>                             
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star" ></i>
                                 
                                 
                                  `;
              break;
            case 2:
              strRating = `
                                      <i class="icon-xl la la-star text-warning" ></i>
                                      <i class="icon-xl la la-star text-warning" ></i>                        
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star" ></i>
                                     
                                     
                                      `;
              break;
            case 2.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 3:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;

            case 3.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 4:
              strRating = `
                                              <i class="icon-xl la la-star text-warning" ></i>
                                              <i class="icon-xl la la-star text-warning" ></i>                        
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star" ></i>
                                             
                                             
                                              `;
              break;
            case 4.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>
                                 
                                  `;
              break;
            case 5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>        
                                 
                                  `;
              break;

            default:
              strRating = `NA`;
              break;
          }
          return "(" + data + "/5)<br>" + strRating;
        },
      },
     
    ],
  });


});
//ajcountry
//starRadioComment
$("input[name=starRadioComment]").click(function(){
  var starRadioVal=$(this).val();
  var sid=$('#txtSID').val();

  $( "#kt_datatable_schoolRatingComment" ).dataTable().fnDestroy()
 
var table = $('#kt_datatable_schoolRatingComment').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolRatingCommentsBySchool',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID','user_id', 'school_title', 'rating', 'user_name','created_at','comment',
          'user_pic','Actions',],
          sid:sid,
          starRadioVal:starRadioVal,
      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},    
      {data: 'user_pic'},
      {data: 'rating'},
      {data: 'comment'},  
      {data: 'created_at'},  
      {data: 'Actions', responsivePriority: -1},
    ],

   

    columnDefs: [
      {
        targets: [0,-1],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            
            
          `;
        },
      },
      {
        targets: 2,
        width: 150,
        title: "Photo",
        orderable: false,
        render: function (a, t, e, n) {
          var  userLINK=BASE_URL+"/view-user/"+e.user_id;
           return `<a href="${userLINK}"><div class="symbol symbol-circle symbol-lg-25">
           <img src="${e.user_pic}" alt="image">
         </div>  <span style="margin-top: 2px;
         position: absolute;
         margin-left: 8px;
         text-transform: capitalize;">${e.user_name} </span></a>`;
         },
      },
      {
        targets: 3,
        width: 175,
        render: function (data, type, full, meta) {
          var strRating = "";
          switch (parseFloat(data)) {
            case 1:
              strRating = `
                              <i class="icon-xl la la-star text-warning" ></i>
                              <i class="icon-xl la la-star " ></i>                                
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star" ></i>
                             
                             
                              `;
              break;
            case 1.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>                             
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star" ></i>
                                 
                                 
                                  `;
              break;
            case 2:
              strRating = `
                                      <i class="icon-xl la la-star text-warning" ></i>
                                      <i class="icon-xl la la-star text-warning" ></i>                        
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star" ></i>
                                     
                                     
                                      `;
              break;
            case 2.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 3:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;

            case 3.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 4:
              strRating = `
                                              <i class="icon-xl la la-star text-warning" ></i>
                                              <i class="icon-xl la la-star text-warning" ></i>                        
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star" ></i>
                                             
                                             
                                              `;
              break;
            case 4.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>
                                 
                                  `;
              break;
            case 5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>        
                                 
                                  `;
              break;

            default:
              strRating = `NA`;
              break;
          }
          return "(" + data + "/5)<br>" + strRating;
        },
      },
      {
        targets: 4,
        width: 350,
        title: "Comments",
        orderable: false,
        render: function (a, t, e, n) {
          return e.comment;
        }
      }
    ],
  });

  
})

//starRadioComment

//starRadio
$("input[name=starRadio]").click(function(){
  var countryID =$( "#myselect option:selected" ).val();


  var starRadioVal=$('input[name="starRadio"]:checked').val();
  var starRadioTOPVal=$('input[name="starRadioTOP"]:checked').val();
    
  $( "#kt_datatable_schoolPerformance" ).dataTable().fnDestroy();
  var table = $('#kt_datatable_schoolPerformance').DataTable({
    responsive: true,
    // Pagination settings
    dom: `<'row'<'col-sm-12'tr>>
    <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
    // read more: https://datatables.net/examples/basic_init/dom.html

    lengthMenu: [5, 10, 25, 50],

    pageLength: 10,

    language: {
      'lengthMenu': 'Display _MENU_',
    },
    
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
      url: BASE_URL + '/getSchoolPerformanceFilterCountry',
      type: 'GET',
      data: {
        // parameters for custom backend script demo
        columnsDef: [
          'RecordID', 'IndexID', 'school_title', 'avg_rating', 'rating',
          'country_name','Actions',],
          countryID:countryID,
          starRadioVal:starRadioVal,
          starRadioTOPVal:starRadioTOPVal

      },
    },
    columns: [
      {data: 'RecordID'},
      {data: 'IndexID'},
      {data: 'school_title'},
      {data: 'rating'},
      {data: 'avg_rating'},
      {data: 'country_name'},  
      {data: 'Actions', responsivePriority: -1},
    ],

   

    columnDefs: [
      {
        targets: [0],
        visible: !1,
      },
      {
        targets: -1,
        title: 'Actions',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="" title="">\
              <i class="la la-eye"></i>
            </a>
            
          `;
        },
      },
      {
        targets: 2,
        title: 'School',
        orderable: false,
        render: function(data, type, full, meta) {
          var ViewSchooRating=BASE_URL+"/view-school-ratings/"+full.RecordID;
          return `
            
            <a href="${ViewSchooRating}" class="" title="Edit details">\
             ${full.school_title}
            </a>
            
          `;
        },
      },
      {
        targets: 4,
        width: 175,
        render: function (data, type, full, meta) {
          var strRating = "";
          switch (parseFloat(data)) {
            case 1:
              strRating = `
                              <i class="icon-xl la la-star text-warning" ></i>
                              <i class="icon-xl la la-star " ></i>                                
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star " ></i>
                              <i class="icon-xl la la-star" ></i>
                             
                             
                              `;
              break;
            case 1.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>                             
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star " ></i>
                                  <i class="icon-xl la la-star" ></i>
                                 
                                 
                                  `;
              break;
            case 2:
              strRating = `
                                      <i class="icon-xl la la-star text-warning" ></i>
                                      <i class="icon-xl la la-star text-warning" ></i>                        
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star " ></i>
                                      <i class="icon-xl la la-star" ></i>
                                     
                                     
                                      `;
              break;
            case 2.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 3:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star " ></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;

            case 3.5:
              strRating = `
                                          <i class="icon-xl la la-star text-warning" ></i>
                                          <i class="icon-xl la la-star text-warning" ></i>                        
                                          <i class="icon-xl la la-star text-warning" ></i> 
                                          <i class="icon-xl la la-star-half-alt text-warning"></i>
                                          <i class="icon-xl la la-star" ></i>
                                         
                                         
                                          `;
              break;
            case 4:
              strRating = `
                                              <i class="icon-xl la la-star text-warning" ></i>
                                              <i class="icon-xl la la-star text-warning" ></i>                        
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star text-warning" ></i> 
                                              <i class="icon-xl la la-star" ></i>
                                             
                                             
                                              `;
              break;
            case 4.5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star-half-alt text-warning"></i>
                                 
                                  `;
              break;
            case 5:
              strRating = `
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>
                                  <i class="icon-xl la la-star text-warning" ></i>                                
                                  <i class="icon-xl la la-star text-warning" ></i>        
                                 
                                  `;
              break;

            default:
              strRating = `NA`;
              break;
          }
          return "(" + data + "/5)<br>" + strRating;
        },
      },
     
    ],
  });


  
})
//starRadio




$("select.getWeelData").change(function(){
  var selectedVal = $(this).children("option:selected").val();
    //ajax
   
    if(selectedVal==4){
      $("#startDate").prop('disabled', false);
      $("#endDate").prop('disabled', false);
    }else{
      $.ajax({
        url: BASE_URL + "/getSchoolCertificatesByWeek",
        type: "GET",
        data: {
          _token: $('meta[name="csrf-token"]').attr("content"),
          selectedVal: selectedVal             
  
        },
        success: function (resp) {
          console.log(resp);
         $('#startDate').val(resp.data.start_date);
         $('#endDate').val(resp.data.end_date);
         $('#startDate').attr('readonly', 'true');
         $('#endDate').attr('readonly', 'true');
        
         $("#startDate").prop('disabled', true);
         $("#endDate").prop('disabled', true);
  
  
        },
        dataType: "json"
      });
    }
   
 //ajax
  

  


});

//function 

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
  // kt_datatable_courseList
  var initTable12= function () {
    // begin first table
    var table = $("#kt_datatable_courseList").DataTable({
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
        url: BASE_URL + "/getDatatableCourseList",
        type: "GET",
        data: {
          // parameters for custom backend script demo
          columnsDef: [
            "RecordID",
            "IndexID",          
            "name",
            "created_by",
            "created_at",           
            "status",
            "Actions",
          ],
        },
      },
      columns: [
        { data: "RecordID" },
        { data: "IndexID" },
        { data: "name" },
        { data: "created_by" },
        { data: "created_at" },
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
            var EDIT_URL = BASE_URL + "/edit-course/" + full.RecordID;


            return `					  
					<a href="${EDIT_URL}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
						<i class="la la-edit"></i>\
					</a>\
					<a href="javascript::void(0)" onclick="deleteCouse(${full.RecordID})"  class="btn btn-sm btn-clean btn-icon" title="Delete">\
						<i class="la la-trash"></i>\
					</a>\
						`;
          },
        },
        
       
        {
          targets: 5,
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
  // kt_datatable_courseCatList
  var initTable13= function () {
    // begin first table
    var table = $("#kt_datatable_courseCatList").DataTable({
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
        url: BASE_URL + "/getDatatableCourseCatList",
        type: "GET",
        data: {
          // parameters for custom backend script demo
          columnsDef: [
            "RecordID",
            "IndexID",          
            "name",
            "cat_name",
            "created_by",
            "created_at",           
            "status",
            "Actions",
          ],
        },
      },
      columns: [
        { data: "RecordID" },
        { data: "IndexID" },
        { data: "name" },
        { data: "cat_name" },
        { data: "created_by" },
        { data: "created_at" },
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
            var EDIT_URL = BASE_URL + "/edit-course-cat/" + full.RecordID;


            return `					  
					<a href="${EDIT_URL}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
						<i class="la la-edit"></i>\
					</a>\
					<a href="javascript::void(0)" onclick="deleteCouseCat(${full.RecordID})"  class="btn btn-sm btn-clean btn-icon" title="Delete">\
						<i class="la la-trash"></i>\
					</a>\
						`;
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
  //kt_datatable_userprogressList
  var initTable4 = function () {
    // begin first table
    var table = $("#kt_datatable_userprogressList").DataTable({
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
        url: BASE_URL + "/getDatatableUserProgressList",
        type: "GET",
        data: {
          // parameters for custom backend script demo
          columnsDef: [
            "RecordID",
            "IndexID",           
            "name",
            "course",
            "point",
            "created_at",
            "created_by",
            "Actions",
          ],
        },
      },
      columns: [
        { data: "RecordID" },
        { data: "IndexID" },
        { data: "name" },
        { data: "course" },
        { data: "point" },
        { data: "created_at" },
        { data: "created_by" },       
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

            return `
					<a href="javascript::void(0)" onclick="deleteUserPoint(${full.RecordID})"  class="btn btn-sm btn-clean btn-icon" title="Delete">\
						<i class="la la-trash"></i>\
					</a>\
						`;
          },
        },
        {
          targets: 4,
          width: 350,
          title: "point",
          orderable: false,
          render: function (data, type, full, meta) {
            var URLSlider="kt_slider_"+full.RecordID;
            var URLSliderH="#kt_slider_"+full.RecordID;

            $(URLSliderH).ionRangeSlider({
              type: "double",
              grid: false,
              min: 0,
              max: 100,
              from: 0,
              to: full.point,
              prefix: "Point:"
          });
           return `<div id="${URLSlider}"></div>`;

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
      initTable12();
      initTable13();
      initTable4();
    },
  };
})();

jQuery(document).ready(function () {
  KTDatatablesSearchOptionsAdvancedSearch.init();
  KTDatatablesSearchOptionsAdvancedSearch_UserList.init();

  // custom prefix
 

});

//function

// HTML TABLE
var KTDatatablesDataSourceHtml = (function () {
  var initTable1 = function () {
    var table = $("#kt_datatable_static_content");

    // begin first table
    table.DataTable({
      responsive: true,
      dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
      // read more: https://datatables.net/examples/basic_init/dom.html

      columnDefs: [
        {
          targets: [0],
          visible: !1,
        },
        {
          targets: -1,
          title: "Actions",
          orderable: false,
          render: function (data, type, full, meta) {
            console.log(full);
            var EDIT_URL = BASE_URL + "/edit-static-content/" + full[0];

            return `
							
							<a href="${EDIT_URL}" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
								<i class="la la-edit"></i>\
							</a>\
							<a href="javascript:void(0)" onclick="deleteMeStatic(1,${full[0]})" class="btn btn-sm btn-clean btn-icon" title="Delete">\
								<i class="la la-trash"></i>\
							</a>\
						`;
          },
        },
        {
          width: "75px",
          targets: 4,
          render: function (data, type, full, meta) {
            var status = {
              0: { title: "Deactive", state: "danger" },
              1: { title: "Active", state: "primary" },
            };
            if (typeof status[data] === "undefined") {
              return data;
            }
            return (
              "</span>" +
              '<span class="font-weight-bold text-' +
              status[data].state +
              '">' +
              status[data].title +
              "</span>"
            );
          },
        },
      ],
    });
  };
  var initTable2 = function () {
    var table = $("#kt_datatable_school_certificate");

    // begin first table
    table.DataTable({
      responsive: true,
      footerCallback: function(row, data, start, end, display) {

				var column = 4;
				var api = this.api(), data;

				// Remove the formatting to get integer data for summation
				var intVal = function(i) {
					return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
				};

				// Total over all pages
				var total = api.column(column).data().reduce(function(a, b) {
					return intVal(a) + intVal(b);
				}, 0);

				// Total over this page
				var pageTotal = api.column(column, {page: 'current'}).data().reduce(function(a, b) {
					return intVal(a) + intVal(b);
				}, 0);

				// Update footer
				$(api.column(column).footer()).html(
					'Total :' + KTUtil.numberString(pageTotal.toFixed(0)) + ' Studnts<br/> <a href="">More ..</a>)',
				);
			},
      dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
      // read more: https://datatables.net/examples/basic_init/dom.html

      columnDefs: [
        {
          targets: [1],
          visible: !1,
        },
        {
          targets: -1,
          title: "Actions",
          orderable: false,
          render: function (data, type, full, meta) {
           
            var VIEW_URL = BASE_URL + "/view-school-details/" + full[0];

            return `
							
							
							
						`;
          },
        },
      ],
    });
    $("#kt_searchA").on("click", function (e) {
      alert(55);
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

  };
  var initTable3 = function () {
    var table = $("#kt_datatable_sport1");

    // begin first table
    table.DataTable({
      responsive: true,
      dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
      // read more: https://datatables.net/examples/basic_init/dom.html

      columnDefs: [
        {
          targets: [0],
          visible: !1,
        },
        {
          targets: -1,
          title: "Actions",
          orderable: false,
          render: function (data, type, full, meta) {
            console.log(full);
            var EDIT_URL = BASE_URL + "/edit-static-content/" + full[0];

            return `
							
						
							<a href="javascript:void(0)" onclick="deleteMe(1,${full[0]})" class="btn btn-sm btn-clean btn-icon" title="Delete">\
								<i class="la la-trash"></i>\
							</a>\
						`;
          },
        },
      ],
    });
  };

  var initTable4 = function () {
    var table = $("#kt_datatable_interest");

    // begin first table
    table.DataTable({
      responsive: true,
      dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
      // read more: https://datatables.net/examples/basic_init/dom.html

      columnDefs: [
        {
          targets: [0],
          visible: !1,
        },
        {
          targets: -1,
          title: "Actions",
          orderable: false,
          render: function (data, type, full, meta) {
            console.log(full);
            var EDIT_URL = BASE_URL + "/edit-static-content/" + full[0];

            return `
							
						
            <a href="javascript:void(0)" onclick="deleteMe(2,${full[0]})" class="btn btn-sm btn-clean btn-icon" title="Delete">\
            <i class="la la-trash"></i>\
          </a>\
						`;
          },
        },
      ],
    });
  };

  return {
    //main function to initiate the module
    init: function () {
      initTable1();
      initTable2();
      initTable3();
      initTable4();
    },
  };
})();

jQuery(document).ready(function () {
  KTDatatablesDataSourceHtml.init();
});

//kt_datatable_school_certificate
