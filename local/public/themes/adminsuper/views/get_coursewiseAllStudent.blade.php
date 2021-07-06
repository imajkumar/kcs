<!--begin::Container-->
<div class="container">

    <?php
    $id = Request::segment(2);

    $schoolCourse = DB::table('school_course')
        ->where('id', $id)
        ->first();
    $schoolArr = DB::table('schools')
        ->where('id', $schoolCourse->sid)
        ->first();


    ?>
    <!--begin::Card-->
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <span class="card-icon">
                    <i class="flaticon2-supermarket text-primary"></i>
                </span>
                <h3 class="card-label">{{$schoolArr->title}} Enrolled Users</h3>
            </div>

        </div>
        <div class="card-body">
            <!--begin: Search Form-->
           
                <div class="row mb-6">
                    <div class="col-lg-4 mb-lg-0 mb-6">
                        <label>Payment Filter</label>
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" value="1" name="paymentStatusRadio">
                                <span></span>Full payment</label>
                            <label class="radio">
                                <input type="radio" value="2" name="paymentStatusRadio">
                                <span></span>Partial payment</label>
                           
                        </div>
                    </div>
                   
                
                    <div class="col-lg-2 mb-lg-0 mb-6">
								<label>Filter By:</label>
								<select class="form-control datatable-input getWeelData ">
									<option value="">-SELECT- </option>
									<option value="1">This Week </option>
									<option value="2">This Month</option>
									<option value="3">This Year </option>
									<option value="4">Custom </option>
								</select>
							</div>
							<div class="col-lg-6 mb-lg-0 mb-6">
								<label>Date From :</label>
								<div class="input-daterange input-group" id="kt_datepicker">
									<input type="text" class="form-control datatable-input" id="startDate" placeholder="From" />
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="la la-ellipsis-h"></i>
										</span>
									</div>
									<input type="text" class="form-control datatable-input" id="endDate" placeholder="To" />
								</div>

							</div>
                </div>
               
                <div class="row mt-8">
                    <div class="col-lg-12">
                        <button class="btn btn-primary btn-primary--icon" id="btnSearchPaymentFilter">
                            <span>
                                <i class="la la-search"></i>
                                <span>Search</span>
                            </span>
                        </button>
                       
                    </div>
                </div>
            

            <input type="hidden" id="sid" value="{{Request::segment(2)}}">
            <table class="table table-bordered table-hover table-checkable" id="kt_datatable_schoolEntrolledPayment" style="margin-top: 13px !important">
						<thead>
							<tr>
								<th>Record#</th>
								<th>S#</th>
								<th>User</th>
								
								<th>Course Neme</th>
								<th>Enrolled date</th>
								<th>Payment</th>
								<th>Actions</th>
							</tr>
						</thead>



					</table>

        </div>
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->