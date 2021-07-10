<!--begin::Container-->
<div class="container">

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">Edit User</h3>


            </div>

        </div>
        <div class="card-body">
            <div class="card-body p-0">
                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                    <div class="col-xl-12 col-xxl-10">

                        <?php
                        $schoolArr = DB::table('users')->where('id', $data->id)->whereNotNull('avatar')->first();
                        if ($schoolArr == null) {
                            $schLogo = NoImage();
                        } else {
                            $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->avatar;
                        }


                        ?>
                        <input type="hidden" id="uploadFileAction" value="1">
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label class="col-xl-3 col-lg31 text-right col-form-label"></label>
                                <div class="col-lg-9 col-xl-9">
                                    <div class="image-input image-input-outline image-input" id="kt_user_avatar" style="background-image: url({{$schLogo}})">
                                        <div class="image-input-wrapper" style="background-image: url({{$schLogo}})"></div>
                                        <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="remove" data-toggle="tooltip" title="Remove ">
                                            <i class="ki ki-bold-close icon-xs text-muted"></i>
                                        </span>

                                    </div>
                                    <div class="dropzone dropzone-multi" id="kt_dropzone_4_1">
                                        <div class="dropzone-panel mb-lg-0 mb-2">
                                            <a class="dropzone-select btn btn-primary font-weight-bold btn-sm">Attach
                                                Photo</a>
                                            <a class="dropzone-upload btn btn-warning font-weight-bold btn-sm">Upload
                                            </a>
                                            <a class="dropzone-remove-all btn btn-danger font-weight-bold btn-sm">Remove
                                            </a>
                                        </div>
                                        <div class="dropzone-items">
                                            <div class="dropzone-item" style="display:none">
                                                <div class="dropzone-file">
                                                    <div class="dropzone-filename" title="some_image_file_name.jpg">
                                                        <span data-dz-name="">some_image_file_name.jpg</span>
                                                        <strong>(
                                                            <span data-dz-size="">340kb</span>)</strong>
                                                    </div>
                                                    <div class="dropzone-error" data-dz-errormessage="">
                                                    </div>
                                                </div>
                                                <div class="dropzone-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" data-dz-uploadprogress=""></div>
                                                    </div>
                                                </div>
                                                <div class="dropzone-toolbar">
                                                    <span class="dropzone-start">
                                                        <i class="flaticon2-arrow"></i>
                                                    </span>
                                                    <span class="dropzone-cancel" data-dz-remove="" style="display: none;">
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
                                        supported.</span>



                                </div>
                            </div>

                        </div>

                        <!--begin::Wizard Form-->
                        <form class="form fv-plugins-bootstrap fv-plugins-framework" data-redirect="user-list" id="kt_form_add_user_data">
                            <input type="hidden" name="txtSID" id="txtSID" value="{{ Request::segment(2) }}">
                            <input type="hidden" name="txtAction" value="_edit">

                            <div class="row justify-content-center">
                                <div class="col-xl-9">
                                    <!--begin::Wizard Step 1-->
                                    <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                        <h5 class="text-dark font-weight-bold mb-10">User's Profile Details:</h5>

                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input class="form-control form-control-solid form-control-lg" name="firstname" type="text" value="{{$data->firstname}}">
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input class="form-control form-control-solid form-control-lg" name="lastname" type="text" value="{{$data->lastname}}">
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->

                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Contact Phone</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <div class="input-group input-group-solid input-group-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-phone"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="phone" value="{{$data->phone}}" placeholder="Phone">
                                                </div>
                                                <span class="form-text text-muted">Enter valid phone number</span>
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Email Address</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <div class="input-group input-group-solid input-group-lg">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="la la-at"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="email" value="{{$data->email}}">
                                                </div>
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Gender</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <div class="input-group input-group-solid input-group-lg">
                                                    <select name="gender" id="" class="form-control form-control-solid form-control-lg">

                                                        <option <?php echo $data->gender == 1 ? "selected" : "" ?> value="1">Male</option>
                                                        <option <?php echo $data->gender == 2 ? "selected" : "" ?> value="2">Female</option>
                                                        <option <?php echo $data->gender == 3 ? "selected" : "" ?> value="3">Other</option>
                                                    </select>

                                                </div>
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->

                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Position</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <div class="input-group input-group-solid input-group-lg">
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="user_position" placeholder="" value="{{$data->user_position}}">

                                                </div>
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>

                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <div class="input-group input-group-solid input-group-lg">
                                                    <input type="text" class="form-control form-control-solid form-control-lg" name="user_address" placeholder="" value="{{$data->address}}">
                                                    
                                                </div>
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->

                                    </div>
                                    <!--end::Wizard Step 1-->



                                    <!--begin::Wizard Actions-->
                                    <div class="d-flex justify-content-between border-top pt-10 mt-15">

                                        <div>
                                            <button type="submit" class="btn btn-success font-weight-bolder px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                            <button type="button" id="next-step" class="btn btn-primary font-weight-bolder px-9 py-4" data-wizard-type="action-next">Reset</button>
                                        </div>
                                    </div>
                                    <!--end::Wizard Actions-->
                                </div>
                            </div>

                        </form>
                        <!--end::Wizard Form-->
                    </div>
                </div>
            </div>



        </div>
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->