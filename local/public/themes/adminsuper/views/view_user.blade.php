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
    
    <!--begin::Row-->
    <div class="row">
       
        <div class="col-xl-12">
        
            <!--begin::Card-->

          
<!--begin::Card-->
										<div class="card card-custom">
                                        
											<!--begin::Header-->
											<div class="card-header h-auto py-4">
												<div class="card-title">
													<h3 class="card-label">User Details 
													<span class="d-block text-muted pt-2 font-size-sm">User profile preview</span></h3>
												</div>
											
											</div>
											<!--end::Header-->
											<!--begin::Body-->
											<div class="card-body py-4">
                                            <!--begin::User-->
												<div class="d-flex align-items-center">
													 <!--begin::Pic-->
                                                     <div class="flex-shrink-0 mr-7">
                    <div class="symbol symbol-50 symbol-lg-120">
                        <img alt="Avatar" src="{{$schLogo}}">
                    </div>
                </div>
                <!--end::Pic-->
													
												</div>
												<!--end::User-->

												<div class="form-group row my-2">
													<label class="col-4 col-form-label">First Name:</label>
													<div class="col-8">
														<span class="form-control-plaintext font-weight-bolder">{{$data->firstname}}</span>
													</div>
												</div>
                                                <div class="form-group row my-2">
													<label class="col-4 col-form-label">Last Name:</label>
													<div class="col-8">
														<span class="form-control-plaintext font-weight-bolder">{{$data->lastname}}</span>
													</div>
												</div>
                                                <div class="form-group row my-2">
													<label class="col-4 col-form-label">Phone:</label>
													<div class="col-8">
														<span class="form-control-plaintext font-weight-bolder">{{$data->phone}}</span>
													</div>
												</div>

												<div class="form-group row my-2">
													<label class="col-4 col-form-label">Email:</label>
													<div class="col-8">
														<span class="form-control-plaintext font-weight-bolder">{{$data->email}}</span>
													</div>
												</div>
                                               
												
												<div class="form-group row my-2">
													<label class="col-4 col-form-label">Postion:</label>
													<div class="col-8">
														<span class="form-control-plaintext font-weight-bolder">{{$data->user_position}}</span>
													</div>
												</div>
												<div class="form-group row my-2">
													<label class="col-4 col-form-label">Created on:</label>
													<div class="col-8">
														<span class="form-control-plaintext font-weight-bolder">{{date('j F Y H:iA',strtotime($data->created_at))}}</span>
													</div>
												</div>
												
												
											</div>
											<!--end::Body-->
											
										</div>
										<!--end::Card-->
          

           
        </div>
    </div>
    <!--end::Row-->
</div>
<!--end::Container-->