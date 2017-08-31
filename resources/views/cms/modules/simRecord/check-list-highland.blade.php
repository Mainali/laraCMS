
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
                        <td>{{$datas->sim_serial_number}}</td>
                    </tr>
                    <tr>
                        <th>Highland Id</th>
                        <td>{{$datas->highland_id}}</td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{$datas->customer_name}}</td>
                    </tr>
                    <tr>
                        <th>Sim Service Number</th>
                        <td>{{$datas->sim_service_number}}</td>
                    </tr>
                    <tr>
                        <th>Document Number</th>
                        <td>{{$datas->document_number}}</td>
                    </tr>
                    <tr>
                        <th>Submitted Date</th>
                        <td>{{$datas->submitted_date}}</td>
                    </tr>
                    <tr>
                        <th>Created at</th>
                        <td>{{$datas->created_at}}</td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td>{{$datas->remarks}}</td>
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