<div class="container">
    <div class="row">
        <?php
      

        $userCount = DB::table('users')
            ->where('is_deleted', 0)
            ->where('user_type', 3)
            ->count();

            $course_listCount = DB::table('course_list')
            ->where('is_deleted', 0)            
            ->count();

            $coursecat_listCount = DB::table('coursecat_list')
            ->where('is_deleted', 0)            
            ->count();

            $course_progressCount_1 = DB::table('course_progress')
            ->where('is_deleted', 0)            
            ->where('point', 0)            
            ->count();

            $course_progressCount_2 = DB::table('course_progress')
            ->where('is_deleted', 0)            
            ->where('point', 100)            
            ->count();
            $course_progressCount_All = DB::table('course_progress')
            ->where('is_deleted', 0)            
            // ->where('point', 100)            
            ->count();


        ?>
        <div class="col-xl-6">

            <div class="row">
                <div class="col-xl-6">
                    <!--begin::Tiles Widget 11-->
                    <div class="card card-custom bg-primary gutter-b" style="height: 150px">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                                <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="text-inverse-primary font-weight-bolder font-size-h2 mt-3">{{$course_listCount}}</div>
                            <a href="{{route('courseList')}}" class="text-inverse-primary font-weight-bold font-size-lg mt-1">Course</a>
                        </div>
                    </div>
                    <!--end::Tiles Widget 11-->
                </div>
                <div class="col-xl-6">
                    <!--begin::Tiles Widget 12-->
                    <div class="card card-custom bg-warning gutter-b" style="height: 150px">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-3x svg-icon-white ml-n2">
                                <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <rect fill="#000000" x="4" y="4" width="7" height="7" rx="1.5" />
                                        <path d="M5.5,13 L9.5,13 C10.3284271,13 11,13.6715729 11,14.5 L11,18.5 C11,19.3284271 10.3284271,20 9.5,20 L5.5,20 C4.67157288,20 4,19.3284271 4,18.5 L4,14.5 C4,13.6715729 4.67157288,13 5.5,13 Z M14.5,4 L18.5,4 C19.3284271,4 20,4.67157288 20,5.5 L20,9.5 C20,10.3284271 19.3284271,11 18.5,11 L14.5,11 C13.6715729,11 13,10.3284271 13,9.5 L13,5.5 C13,4.67157288 13.6715729,4 14.5,4 Z M14.5,13 L18.5,13 C19.3284271,13 20,13.6715729 20,14.5 L20,18.5 C20,19.3284271 19.3284271,20 18.5,20 L14.5,20 C13.6715729,20 13,19.3284271 13,18.5 L13,14.5 C13,13.6715729 13.6715729,13 14.5,13 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="text-inverse-primary font-weight-bolder font-size-h2 mt-3">{{$coursecat_listCount}}</div>
                            <a href="{{route('courseCatList')}}" class="text-inverse-primary font-weight-bold font-size-lg mt-1">Sub Category</a>
                        </div>
                    </div>
                    <!--end::Tiles Widget 12-->
                </div>
            </div>
        </div>
        <div class="col-xl-6">

            <div class="row">
                <div class="col-xl-6">
                    <!--begin::Tiles Widget 11-->
                    <div class="card card-custom gutter-b" style="height: 150px">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-3x svg-icon-success">
                                <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/Communication/Group.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24" />
                                        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="text-dark font-weight-bolder font-size-h2 mt-3">{{$userCount}}</div>
                            <a href="{{route('userList')}}" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">Users</a>
                        </div>
                    </div>
                   
                    <!--end::Tiles Widget 11-->
                </div>
                <div class="col-xl-6">
                    <!--begin::Tiles Widget 12-->
                    <div class="card card-custom gutter-b" style="height: 150px">
                        <div class="card-body">
                            <span class="svg-icon svg-icon-3x svg-icon-success">
                                <!--begin::Svg Icon | path:/metronic/theme/html/demo2/dist/assets/media/svg/icons/Communication/Group.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24" />
                                        <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                        <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <div class="text-dark font-weight-bolder font-size-h2 mt-3">{{$course_progressCount_All}}</div>
                            <a href="{{route('courseProgressList')}}" class="text-muted text-hover-primary font-weight-bold font-size-lg mt-1">Points</a>
                        </div>
                    </div>
                    <!--end::Tiles Widget 12-->
                </div>
            </div>
        </div>



    </div>
   
    



</div>

<!--end::Row-->