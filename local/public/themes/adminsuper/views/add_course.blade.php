<!--begin::Container-->
<div class="container">

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">Add New Couse</h3>
            </div>

        </div>
        <div class="card-body">
            <div class="card-body p-0">
                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                    <div class="col-xl-12 col-xxl-10">
                        <!--begin::Wizard Form-->
                        <form class="form fv-plugins-bootstrap fv-plugins-framework" data-redirect="course-list" id="kt_form_add_course_data">
                            <div class="row justify-content-center">
                                <div class="col-xl-9">
                                    <!--begin::Wizard Step 1-->
                                    <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                       
                                       
                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Course Name</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <input class="form-control form-control-solid form-control-lg" name="name" type="text" value="">
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>

                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Course Description</label>
                                            <div class="col-lg-9 col-xl-9">
                                              
                                                <textarea class="form-control form-control-solid form-control-lg" name="couser_info" cols="30" rows="5"></textarea>
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        
                                      
                                       
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