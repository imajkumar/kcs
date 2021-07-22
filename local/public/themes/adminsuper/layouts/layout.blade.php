<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>@get('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="BASE_URL" content="{{ url('/') }}" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="" />
    <!--begin::Fonts-->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" /> -->
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{getBaseURL()}}/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{getBaseURL()}}/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{getBaseURL()}}/assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{getBaseURL()}}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{getBaseURL()}}/assets/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="{{getBaseURL()}}/assets/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="{{getBaseURL()}}/assets/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="{{getBaseURL()}}/assets/css/themes/layout/aside/dark.css" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{applogo()}}" />

</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    @partial('header')
    @partial('left_side')
    @partial('top_toolbar')
    @content()
    @partial('footer')


    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{getBaseURL()}}/assets/plugins/global/plugins.bundle.js"></script>
    <script src="{{getBaseURL()}}/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="{{getBaseURL()}}/assets/js/scripts.bundle.js"></script>
    <!--end::Global Theme Bundle-->
    <script src="{{getBaseURL()}}/assets/js/pages/widgets.js"></script>
    <script src="{{getBaseURL()}}/assets/js/pages/crud/forms/widgets/select2.js?v=7.2.7"></script>
    <script type="text/javascript">
        BASE_URL = $('meta[name="BASE_URL"]').attr('content');
        CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //	location.reload(1);
    </script>


    <script src="{{getBaseURL()}}/assets/js/pages/features/miscellaneous/sweetalert2.js?v=7.2.7"></script>
    <script src="{{getBaseURL()}}/assets/plugins/custom/datatables/datatables.bundle.js?v=7.2.7"></script>
    <script src="{{getBaseURL()}}/corex/js/admin_datatable_ajax_x.js?v=7.2.7"></script>

    <script src="{{getBaseURL()}}/corex/js/superadmin_x.js"></script>
    <?php
    if ( Request::segment(1) == "add-user" || Request::segment(1) == "edit-user" || Request::segment(1) == "add-course-user") {
    ?>
        <script src="{{getBaseURL()}}/corex/js/formsubmit_validated_x.js"></script>
    <?php
    }
    ?>

<?php
    if (Request::segment(1) == "add-course"  || Request::segment(1) == "edit-course" || Request::segment(1) == "add-course-category" || Request::segment(1) == "edit-course-cat") {
    ?>
        <script src="{{getBaseURL()}}/corex/js/formsubmit_validated_x_couser_cat.js"></script>
    <?php
    }
    ?>


   

    <!--end::Page Scripts-->


</body>
<!--end::Body-->

</html>