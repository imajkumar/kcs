<!--begin::Container-->
<div class="container">
	<div class="row">
		<div class="col-lg-12">

			<?php
			$contentArr = DB::table('school_course')
				->where('is_deleted', 0)
				->orderBy('id', 'desc')
				->get();
			$data_arr = array();
			$i = 0;
			$toc = 0;
			foreach ($contentArr as $key => $rowData) {
				$i++;
				$schoolArr = DB::table('schools')
					->where('id', $rowData->sid)
					->first();
				$URL = getBaseURL() . "/view-school-details/" . $rowData->sid;
				$cid = $rowData->id;
				$stuCount = DB::table('school_course_student')
					->where('course_id', $cid)
					->count();
				$toc = $toc + $stuCount;
			}
			?>
			<!--begin::Card-->
			<div class="card card-custom">
				<div class="card-header">
					<div class="card-title">
						<span class="card-icon">
							<i class="icon-xl la la-school"></i>
						</span>
						<h3 class="card-label">School Certificate</h3> List
					</div>
					<div class="card-toolbar">

						<!--begin::Button-->

						<!--end::Button-->
					</div>
				</div>
				<div class="card-body">
					<!--begin: Search Form-->
					<!--begin: Search Form-->
					<form class="mb-15">
						<div class="row mb-6">
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Schools:</label>
								<select class="form-control datatable-input myschool" data-col-index="2">
									<option value="">Select</option>
									<?php
									$schools = DB::table('schools')
										->where('is_deleted', 0)
										->where('added_from_status', 1)
										->get();
									foreach ($schools as $key => $rowData) {
										$schoolsArr = DB::table('school_course')
											->where('sid', $rowData->id)
											->first();
										if ($schoolsArr == null) {
										} else {
									?>
											<option value="{{$rowData->id}}">{{$rowData->title}}</option>
									<?php
										}
									}



									?>

								</select>

							</div>
							<div class="col-lg-3 mb-lg-0 mb-6">
								<label>Course:</label>
								<select class="form-control datatable-input myschoolCourse" data-col-index="3">


								</select>
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
							<div class="col-lg-4 mb-lg-0 mb-6">
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
								<a href="javascript:void(0)" class="btn btn-primary btn-primary--icon" id="btnDateRenage">
									<span>
										<i class="la la-search"></i>
										<span>Search</span>
									</span>
								</a>&#160;&#160;
								<button class="btn btn-secondary btn-secondary--icon" id="kt_resetA">
									<span>
										<i class="la la-close"></i>
										<span>Reset</span>
									</span>
								</button>
							</div>
						</div>
					</form>

					<!--begin: Search Form-->


					<!--begin: Datatable-->

					<!-- {{getBaseURL().'/getMoreCertificate'}} -->
					
				
					<a href="javascript:void(0)" id="txtTS" title="Total Student" class="btn btn-secondary font-weight-bolder" style="margin-left: 820px;">
						
					</a>


					<table class="table table-bordered table-hover table-checkable" id="kt_datatable_schoolCertificate" style="margin-top: 13px !important">
						<thead>
							<tr>
								<th>Record#</th>
								<th>S#</th>
								<th>School</th>
								<th>Certificate</th>
								<th>Total Enrolled Student</th>
								<th>Course Date</th>
								<th>Actions</th>
							</tr>
						</thead>



					</table>
					<!--end: Datatable-->
				</div>
			</div>
			<!--end::Card-->

		</div>
	</div>
</div>
<!--end::Container-->