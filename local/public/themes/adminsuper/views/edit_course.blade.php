<!--begin::Container-->
<div class="container">

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">Edit New Couse</h3>
            </div>

        </div>
        <div class="card-body">
            <div class="card-body p-0">
                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                    <div class="col-xl-12 col-xxl-10">

                    <?php
                                    $schoolArr = DB::table('course_list')->where('id', $data->id)->first();
    if ($schoolArr == null) {
        $schLogo = NoImage();
    } else {
        $schLogo = asset('/local/storage/app/doc/') . "/" . $schoolArr->photo;
    }


                                    ?>
    <input type="hidden" id="uploadFileAction" value="2">
    <input type="hidden" name="txtSID" id="txtSID" value="{{ Request::segment(2) }}">
    
                                    <div class="col-lg-12">
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg31 text-right col-form-label"></label>
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
                                                <div class="dropzone dropzone-multi" id="kt_dropzone_4_1">
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
                                                    supported.</span>



                                            </div>
                                        </div>

                                    </div>

                        <!--begin::Wizard Form-->
                        <form class="form fv-plugins-bootstrap fv-plugins-framework" data-redirect="course-list" id="kt_form_add_course_data">
                            <div class="row justify-content-center">
                                <div class="col-xl-9">
                                    <!--begin::Wizard Step 1-->
                                    <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                       
                                       <input type="hidden" id="txtAction" name="txtAction" value="__edit">
                                       <input type="hidden" id="txtID" name="txtID" value="{{$data->id}}">
                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Course Name</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input class="form-control form-control-solid form-control-lg" name="name" type="text" value="{{$data->name}}">
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Course Description</label>
                                            <div class="col-lg-9 col-xl-9">
                                                
                                                <textarea class="form-control form-control-solid form-control-lg" name="couser_info"    cols="30" rows="5">{{$data->couser_info}}</textarea>

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