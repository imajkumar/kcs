<!--begin::Container-->
<div class="container">
    <?php
   $schoolArr = DB::table('users')->where('id', $data->id)->whereNotNull('avatar')->first();
    if ($schoolArr == null) {
        $schLogo = NoImage();
    } else {
        $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->avatar;
    }

    ?>
    <!--begin::Card-->
    <div class="card card-custom gutter-b" style="display:block">
        <div class="card-body">
            <div class="d-flex">
                <!--begin::Pic-->
                <div class="flex-shrink-0 mr-7">
                    <div class="symbol symbol-50 symbol-lg-120">
                        <img alt="{{Auth::user()->name}}" src="{{$schLogo}}">
                    </div>
                </div>
                <!--end::Pic-->
                <!--begin: Info-->
                <div class="flex-grow-1">
                    <!--begin::Title-->
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <!--begin::User-->
                        <div class="mr-3">
                            <div class="d-flex align-items-center mr-3">
                                <!--begin::Name-->
                                <a href="javascript:;" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">{{$data->firstname}}</a>
                                <i class="flaticon2-correct text-success icon-md ml-2"></i>
                                <a href="#" class="font-weight-bolder font-size-h5 text-success-75 text-hover-success">Active</a>
                                <!--end::Name-->

                            </div>
                            <!--begin::Contacts-->
                            <div class="d-flex flex-wrap my-2">
                                @if(isset(Auth::user()->email))
                                <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Mail-notification.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000"></path>
                                                <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"></circle>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>{{@Auth::user()->email}}</a>
                                    @endif
                                    @if(isset(Auth::user()->phone))
                                <a href="#" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/General/Lock.svg-->
                                        <i class="icon-1x text-dark-50 flaticon2-phone"></i>
                                        <!--end::Svg Icon-->
                                    </span>{{@$data->phone}}</a>
                                    @endif
                                    @if(isset(Auth::user()->address))
                                <a href="#" class="text-muted text-hover-primary font-weight-bold">
                                    <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Map/Marker2.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M9.82829464,16.6565893 C7.02541569,15.7427556 5,13.1079084 5,10 C5,6.13400675 8.13400675,3 12,3 C15.8659932,3 19,6.13400675 19,10 C19,13.1079084 16.9745843,15.7427556 14.1717054,16.6565893 L12,21 L9.82829464,16.6565893 Z M12,12 C13.1045695,12 14,11.1045695 14,10 C14,8.8954305 13.1045695,8 12,8 C10.8954305,8 10,8.8954305 10,10 C10,11.1045695 10.8954305,12 12,12 Z" fill="#000000"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>{{$data->address}}</a>
                                    @endif
                            </div>
                            <!--end::Contacts-->
                        </div>
                        <!--begin::User-->

                    </div>
                    <!--end::Title-->
                    <!--begin::Content-->
                    <div class="d-flex align-items-center flex-wrap justify-content-between">
                        <!--begin::Description-->
                        <div class="flex-grow-1 font-weight-bold text-dark-50 py-2 py-lg-2 mr-5">


                        </div>
                        <!--end::Description-->

                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Info-->
            </div>
        </div>
    </div>
    <!--end::Card-->
    <!--begin::Row-->
    <div class="card card-custom">
        <!--Begin::Header-->
        <div class="card-header card-header-tabs-line">
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x" role="tablist">
                    <li class="nav-item mr-3">
                        <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_2">
                            <span class="nav-icon mr-2">
                                <span class="svg-icon mr-3">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Chat-check.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <span class="nav-text font-weight-bold">Personal</span>
                        </a>
                    </li>
                    <li class="nav-item mr-3">
                        <a class="nav-link " data-toggle="tab" href="#kt_apps_contacts_view_tab_3">
                            <span class="nav-icon mr-2">
                                <span class="svg-icon mr-3">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Communication/Chat-check.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <span class="nav-text font-weight-bold">Reset Password</span>
                        </a>
                    </li>
                   
                </ul>
            </div>
        </div>
        <!--end::Header-->
        <!--Begin::Body-->
        <div class="card-body">
            <div class="tab-content pt-5">
                <!--begin::Tab Content-->
                <div class="tab-pane active" id="kt_apps_contacts_view_tab_2" role="tabpanel">
                    <form action="{{route('saveAdminProfile')}}" id="frmsaveAdminProfile" method="post">
                        <!--begin::Heading-->
                        @csrf
                        <input type="hidden" value="{{Auth::user()->id}}" id="txtSID" name="txtSID">
                      
                        <!--end::Heading-->
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 text-right col-form-label">Avatar</label>
                            <div class="col-lg-9 col-xl-9">
                                <div class="image-input image-input-outline image-input"
                                    id="kt_user_avatar" style="background-image: url({{$schLogo}})">
                                    <div class="image-input-wrapper"
                                        style="background-image: url({{$schLogo}})"></div>
                                    <span
                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                        data-action="remove" data-toggle="tooltip" title="Remove ">
                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                    </span>

                                </div>
                                <div class="dropzone dropzone-multi" id="kt_dropzone_4">
                                    <div class="dropzone-panel mb-lg-0 mb-2">
                                        <a
                                            class="dropzone-select btn btn-primary font-weight-bold btn-sm">Attach
                                            Photo</a>
                                        <a
                                            class="dropzone-upload btn btn-warning font-weight-bold btn-sm">Upload
                                        </a>
                                        <a
                                            class="dropzone-remove-all btn btn-danger font-weight-bold btn-sm">Remove
                                        </a>
                                    </div>
                                    <div class="dropzone-items">
                                        <div class="dropzone-item" style="display:none">
                                            <div class="dropzone-file">
                                                <div class="dropzone-filename"
                                                    title="some_image_file_name.jpg">
                                                    <span
                                                        data-dz-name="">some_image_file_name.jpg</span>
                                                    <strong>(
                                                        <span data-dz-size="">340kb</span>)</strong>
                                                </div>
                                                <div class="dropzone-error" data-dz-errormessage="">
                                                </div>
                                            </div>
                                            <div class="dropzone-progress">
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary"
                                                        role="progressbar" aria-valuemin="0"
                                                        aria-valuemax="100" aria-valuenow="0"
                                                        data-dz-uploadprogress=""></div>
                                                </div>
                                            </div>
                                            <div class="dropzone-toolbar">
                                                <span class="dropzone-start">
                                                    <i class="flaticon2-arrow"></i>
                                                </span>
                                                <span class="dropzone-cancel" data-dz-remove=""
                                                    style="display: none;">
                                                    <i class="flaticon2-cross"></i>
                                                </span>
                                                <span class="dropzone-delete" data-dz-remove="">
                                                    <i class="flaticon2-cross"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="form-text text-muted">Maximum 5MB file size is
                                    supported.
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 text-right col-form-label"> Name</label>
                            <div class="col-lg-9 col-xl-6">
                                <input name="name" class="form-control form-control-lg form-control-solid" type="text" value="{{@$data->name}}">
                            </div>
                        </div>
                        
                        <div class="separator separator-dashed my-10"></div>
                        <!--begin::Heading-->
                        <div class="row">
                            <div class="col-lg-9 col-xl-6 offset-xl-3">
                                <h3 class="font-size-h6 mb-5">Contact Info:</h3>
                            </div>
                        </div>
                        <!--end::Heading-->
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 text-right col-form-label">Contact Phone</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group input-group-lg input-group-solid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-phone"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="phone" class="form-control form-control-lg form-control-solid" value="{{@$data->phone}}" placeholder="Phone">
                                </div>
                                <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 text-right col-form-label">Email Address</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group input-group-lg input-group-solid">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="la la-at"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="email" class="form-control form-control-lg form-control-solid" value="{{@$data->email}}" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane " id="kt_apps_contacts_view_tab_3" role="tabpanel">
                    <!--begin::Form-->
											
												<div class="card-body">
													<!--begin::Alert-->
													
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label text-alert">Current Password</label>
														<div class="col-lg-9 col-xl-6">
															<input type="password" name="current" id="current" class="form-control form-control-lg form-control-solid mb-2"  placeholder="*************************" />
															
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password</label>
														<div class="col-lg-9 col-xl-6">
															<input type="password" name="password"  id="password" class="form-control form-control-lg form-control-solid"  placeholder="New password" />
                                                            
														</div>
													</div>
													<div class="form-group row">
														<label class="col-xl-3 col-lg-3 col-form-label text-alert">Verify Password</label>
														<div class="col-lg-9 col-xl-6">
															<input type="password" name="confirmed" id="confirmed" class="form-control form-control-lg form-control-solid"  placeholder="Verify password" />
														</div>
													</div>
												</div>
                                                <div class="card-footer">
                                                    <button type="button" id="btnPasswordReset" class="btn btn-primary mr-2">Save Changes</button>
                                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                                </div>
											
											<!--end::Form-->
                </div>
                <!--end::Tab Content-->
                
            </div>
        </div>
        <!--end::Body-->
    </div>
    <!--end::Row-->
</div>
<!--end::Container-->