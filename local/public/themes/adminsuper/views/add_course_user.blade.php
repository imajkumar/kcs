<!--begin::Container-->
<div class="container">

    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">Add uses to couser</h3>


            </div>

        </div>
        <div class="card-body">
            <div class="card-body p-0">
                <div class="row justify-content-center py-8 px-8 py-lg-15 px-lg-10">
                    <div class="col-xl-12 col-xxl-10">

                       
                        <input type="hidden" id="uploadFileAction" value="1">
                       

                        <!--begin::Wizard Form-->
                        <form class="form fv-plugins-bootstrap fv-plugins-framework" data-redirect="user-list" id="kt_form_add_user_dataCouser">
                            <input type="hidden" name="txtSID" id="txtSID" value="{{ Request::segment(2) }}">
                            <input type="hidden" name="txtAction" value="_edit">

                            <div class="row justify-content-center">
                                <div class="col-xl-9">
                                    <!--begin::Wizard Step 1-->
                                    <div class="my-5 step" data-wizard-type="step-content" data-wizard-state="current">
                                        

                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Users</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <select name="user_id" id=""class="form-control form-control-solid form-control-lg">
                                                <option value="">-SELECT-</option>
                                                <?php 
                                                $userid=Request::segment(2);

                                                $users = DB::table('users')
                                                ->where('user_type', 3)
                                                ->get();
                                                foreach ($users as $key => $rowData) {
                                                    if($userid==$rowData->id){
                                                        ?>
                                                        <option selected value="{{$rowData->id}}">{{$rowData->firstname}} {{$rowData->lastname}}</option>
                                                        <?php
                                                    }else{
                                                        ?>
                                                    <option value="{{$rowData->id}}">{{$rowData->firstname}} {{$rowData->lastname}}</option>
                                                    <?php
                                                    }
                                                    
                                                }

                                                ?>
                                                </select>
                                                
                                                <div class="fv-plugins-message-container"></div>
                                            </div>
                                        </div>
                                        <!--end::Group-->
                                        <!--begin::Group-->
                                        <div class="form-group row fv-plugins-icon-container">
                                            <label class="col-xl-3 col-lg-3 col-form-label">Course</label>
                                            <div class="col-lg-9 col-xl-9">
                                                
                                                <select name="course_id" id=""class="form-control form-control-solid form-control-lg">
                                                <option value="">-SELECT-</option>

                                                <?php 
                                                $users = DB::table('course_list')
                                                ->where('is_deleted', 0)
                                                ->get();
                                                foreach ($users as $key => $rowData) {
                                                    ?>
                                                    <option value="{{$rowData->id}}">{{$rowData->name}}</option>
                                                    <?php
                                                }

                                                ?>
                                                </select>

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