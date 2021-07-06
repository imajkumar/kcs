<!--begin::Container-->
<div class="container">

    <!--begin::Card-->
    <div class="row">

        <div class="col-lg-12">
            <div class="card card-custom example example-compact">
                <div class="card-header">
                    <h3 class="card-title">Announcement</h3>

                </div>
                <!--begin::Form-->
                <form class="form" data-redirect="static-content-list" id="kt_form_add_static_content">
                    <div class="card-body">

                        <div class="mb-3">
                               <input type="hidden" name="staticAction" id="staticAction" value="_add">
                            <div class="mb-2">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>* Whom To:</label>
                                        <select class="form-control" name="" id="">
                                        <option value="1">USERS</option>
                                        <option value="2">SCHOOLS</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>* Subject:</label>
                                        <input type="text" name="title" class="form-control" placeholder="" value="" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>* Message:</label>
                                        <div id="kt-ckeditor-1-toolbar"></div>
                                        <div id="kt-ckeditor-1" name="content">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label>* Status:</label>
                                        <select class="form-control form-control-sm" id="isactive" name="isactive">
                                            <option value="1">draft</option>
                                            <option value="2">completed</option>                                           
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary font-weight-bold mr-2">Submit</button>
                                <button type="reset" class="btn btn-light-primary font-weight-bold">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>
</div>
<!--end::Container-->