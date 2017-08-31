
<div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">{{$title}}</h4>
            </div>

            <div class="modal-body">

                @if(!is_null($datas))
                <table class="display table table-bordered table-striped">
                    <tr>
                        <th>Sim Serial</th>
                        <td>{{$datas->sim_serial}}</td>
                    </tr>
                    <tr>
                        <th>Transaction Type</th>
                        <td>{{$datas->transaction_type}}</td>
                    </tr>
                    <tr>
                        <th>Vodafone Number</th>
                        <td>{{$datas->vf_number}}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{$datas->status}}</td>
                    </tr>
                    <tr>
                        <th>Issuance</th>
                        <td>{{$datas->issuance}}</td>
                    </tr>
                    <tr>
                        <th>Reason Fail</th>
                        <td>{{$datas->reason_fail}}</td>
                    </tr>
                    <tr>
                        <th>Comment Partner</th>
                        <td>{{$datas->comment_partner}}</td>
                    </tr>
                    <tr>
                        <th>Insert date</th>
                        <td>{{$datas->insert_date}}</td>
                    </tr>

                    <tr>
                        <th>Insert user</th>
                        <td>{{$datas->insert_user}}</td>
                    </tr>
                    <tr>
                        <th>Sim Serial</th>
                        <td>{{$datas->outlet_id}}</td>
                    </tr>
                    <tr>
                        <th>Outlet</th>
                        <td>{{$datas->outlet}}</td>
                    </tr>
                    <tr>
                        <th>Distributor Code</th>
                        <td>{{$datas->distributor_code}}</td>
                    </tr>
                    <tr>
                        <th>Region</th>
                        <td>{{$datas->region}}</td>
                    </tr>
                    <tr>
                        <th>Distributor</th>
                        <td>{{$datas->distributor}}</td>
                    </tr>
                    <tr>
                        <th>Sim Serial</th>
                        <td>{{$datas->type}}</td>
                    </tr>
                    <tr>
                        <th>Comment Vodafone</th>
                        <td>{{$datas->comment_vodafone}}</td>
                    </tr>
                    <tr>
                        <th>Month</th>
                        <td>{{$datas->month}}</td>
                    </tr>
                    <tr>
                        <th>Inserted At</th>
                        <td>{{$datas->inserted_at}}</td>
                    </tr>


                </table>



                        @else
                    <li>Could not found match.</li>
                        @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>