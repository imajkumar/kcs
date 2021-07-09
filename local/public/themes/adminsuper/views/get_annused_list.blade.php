<!--begin::Container-->
<div class="container">
    <div class="row">
        <div class="col-lg-12">


            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-header">
                    <div class="card-title">
                        <span class="card-icon">
                            <i class="flaticon2-favourite text-primary"></i>
                        </span>
                        <h3 class="card-label">List</h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <a href="{{route('addNotify')}}" class="btn btn-primary font-weight-bolder">
                            <i class="la la-plus"></i>Add New </a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-hover table-checkable" id="kt_datatable_static_content" style="margin-top: 13px !important">
                        <thead>
                            <tr>
                                <th>Record ID</th>
                                <th>S#</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contentArr = DB::table('notify_list')
                                ->where('is_deleted', 0)
                                ->get();
                            $i = 0;
                            foreach ($contentArr as $key => $rowData) {
                                $i++;
                            ?>
                                <tr>
                                    <td>{{$rowData->id}}</td>
                                    <td>{{$i}}</td>
                                    <td>{{$rowData->subject}}</td>
                                    <td>
                                        {!!$rowData->message!!}
                                    </td>
                                    <td>{{$rowData->status}}</td>

                                    <td nowrap="nowrap"></td>
                                </tr>
                            <?php
                            }

                            ?>


                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->

        </div>
    </div>
</div>
<!--end::Container-->