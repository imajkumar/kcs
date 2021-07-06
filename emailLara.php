<?php 
  //send email code
          if ($request->client_notify) {

            $qc_data = QCFORM::where('form_id', $formid)->first();

            $use_data = AyraHelp::getUser($qc_data->created_by);

            $sent_to = $row['txtClientEmailSend'];
            //$myorder=$row['txtPONumber'];
            $myorder = $qc_data->order_id . "/" . $qc_data->subOrder;
            $brandNameMy = $qc_data->brand_name . "/Bo International";
            $subLine = "[ORDER NO] " . $myorder . " " . $brandNameMy;

            $data = array(
              'transport_name' => $row['txtTransport'],
              'lr_no' => $row['txtLRNo'],
              'ship_date' => $row['txtDispatchDate'],
              'booking' => $row['txtBookingFor'],
              // 'po_no'=>$row['txtPONumber'],
              'po_no' => $qc_data->order_id . "/" . $qc_data->subOrder,
              'cartons' => $row['txtCartons'],
              'totalUnitEntry' => $row['txtTotalUnit'],

              // 'material_name'=>$qc_data->item_name,
              'material_name' => $mTName,
              'no_of_pack' => $row['txtCartonsEachUnit'],
              'invoice_number' => $row['txtInvoice'],

            );
            Mail::send('mail', $data, function ($message) use ($sent_to, $use_data, $subLine) {

              $message->to($sent_to, 'Bo')->subject($subLine);
              $message->cc($use_data->email, $use_data->name = null);
              //$message->bcc('udita.bointl@gmail.com', 'UDITA');
              $message->from('bointloperations@gmail.com', 'Bo Intl Operations');
            });
          }

          //send email code
          //email code