@extends('layouts.app')

@section('title','Transactions')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading box-header well">
                    New Transaction
					<div class="box-icon">
						<a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
						<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
						<a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
					</div>
                </div>

				
                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Consignor Form -->
                    <form action="{{ url('transaction') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Item -->
						<div class="form-group {{ ($errors->first('item_id')) ? 'has-error'  :''}}">
                            <label for="item_id" class="col-sm-2 control-label">Item</label>

                            <div class="col-sm-6">
								<select id="item_id" name="item_id" data-placeholder="Choose an Item..." class="chosen-select form-control" style="width:350px;" tabindex="2">
									<option value=""></option>
									@foreach ($items as $item)
										<option value="{{$item->id}}" {{ (old('item_id') == $item->id) ? "selected" : "" }} >[{{$item->code}}] {{$item->name}}</option>
									@endforeach
								</select>
                            </div>
                        </div>

						<!-- Quantity and Price-->
						<div class="form-group ">
                            <label for="transaction-quantity" class="col-sm-2 control-label {{ ($errors->first('quantity')) ? 'has-error'  :''}}">Quantity</label>
                            <div class="col-sm-2">
								<input type="text" name="quantity" id="transaction-quantity" class="form-control" value="{{ Request::old('quantity') }}">
                            </div>
							
							<label for="transaction-price" class="col-sm-1 control-label">Price</label>
                            <div class="col-sm-3">
                                <input type="text" name="price" id="transaction-price" class="form-control" value="{{ Request::old('price') }}" readonly >
                            </div>
                        </div>
						
						<!-- Total Price -->
						<div class="form-group">
                            <label for="transaction-totalprice" class="col-sm-2 control-label">Total Price</label>

                            <div class="col-sm-6">
                                <input type="text" name="total_price" id="transaction-totalprice" class="form-control" value="{{ Request::old('total_price') }}" readonly >
                            </div>
                        </div>

						<!-- Remarks -->
						<div class="form-group">
                            <label for="transaction-remarks" class="col-sm-2 control-label">Remarks</label>

                            <div class="col-sm-6">
								<textarea class="autogrow" id="transaction-remarks" name="remarks" style="width: 334px; height: 100px;">{{ Request::old('remarks') }}</textarea>
                            </div>
                        </div>
						
                        <!-- Add Consignor Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Transaction
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
		
		<div class="container">
            <!-- Current Transaction -->
            @if (count($transactions) > 0)
			<div class="row">
				<div class="box col-md-12">
					<div class="box-inner">
						<div class="box-header well" data-original-title="">
							<h2>Transactions</h2>

							<div class="box-icon">
								<a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
								<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
								<a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<input type="hidden" id="data-token" value="{{ csrf_token() }}" />
							<table class="table table-bordered table-striped table-condensed">
								<thead>
								<tr>
									<th>Id</th>
									<th>Date</th>
									<th>Item</th>
									<th>Consignor</th>
									<th>Quantity</th>
									<th>Price</th>
									<th>Total Price</th>
									<th>Remarks</th>
									<th>&nbsp;</th>
								</tr>
								</thead>
								<tbody>
								
								@foreach ($transactions as $transaction)
                                    <tr id="{{ $transaction->id }}">
										<td class="table-text"><div>{{ $transaction->id }}</div></td>
                                        <td class="table-text"><div>{{ date('F d, Y',strtotime($transaction->created_at)) }}</div></td>
										<td class="table-text"><div>[{{ $transaction->item->code }}] {{ $transaction->item->name }}</div></td>
										<td class="table-text"><div>{{ $transaction->consignor->firstname }}</div></td>
										<td class="table-text"><div>{{ $transaction->quantity }}</div></td>
										<td class="table-text"><div>{{ $transaction->price }}</div></td>
										<td class="table-text"><div>{{ $transaction->total_price }}</div></td>
										<td class="table-text"><div>{{ $transaction->remarks }}</div></td>
                                        <!-- Transaction Delete Button -->
                                        <td>
											<a href="#" class="btn btn-danger" id="delete-transaction-{{ $transaction->id }}" data-id="{{ $transaction->id }}" ><i class="glyphicon glyphicon-trash"></i>Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
								</tbody>
							</table>
							<ul class="pagination pagination-centered">
								<li><a href="#">Prev</a></li>
								<li class="active">
									<a href="#">1</a>
								</li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">Next</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div><!--/span-->
            @endif
        </div>
    </div>
	
	<!-- Modal for delete action -->
	<div class="modal fade" id="deleteTransactionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4>Warning!</h4>
                </div>
                <div class="modal-body form-group">
                    <div class="form-group">
						<label id="deleteTransactionLabelModal" class="col-sm-10 control-label"></label>
					
						
					</div>

                </div>
                <div class="modal-footer">
					<a href="#" id="delete-yes" class="btn btn-default" >YES</a>
					&nbsp;&nbsp;
					<a href="#" id="delete-no" class="btn btn-primary" >NO</a>
				</div>
            </div>
        </div>
    </div>
	
@endsection

@section('javascripts')
@parent
<script type="text/javascript">
//load the price when item is selected
var transaction_id = 0;

jQuery("#item_id").change(function(){
	jQuery.ajax({
		type		:	'GET',
		url 		:	'/ajax/items/'+jQuery(this).val(),
		dataType	:	'json',
		success		:	function(data) {
						//reset value of fields
						jQuery('#transaction-quantity, #transaction-price, #transaction-totalprice').val('');
						jQuery('#transaction-price').val(data.price);
						
					}
	});
});

//compute total price once quantity is provided
jQuery("#transaction-quantity").keyup(function(){
	var totalPrice = jQuery(this).val() * jQuery('#transaction-price').val();
	jQuery('#transaction-totalprice').val(totalPrice.toFixed(2));
});

//delete transaction
jQuery("a[id^=delete-transaction-").click(function() {
	transaction_id = jQuery(this).data('id');
	jQuery("#deleteTransactionLabelModal").text("Are you sure you want to delete transaction # " + transaction_id +"?");
	jQuery("#deleteTransactionModal").modal('show');
});

jQuery("#delete-yes").click(function() {
	var token = $("#data-token").val();

	jQuery.ajax({
		type		:	'POST',
		data		:	{ _token : token, _method : 'DELETE', id : transaction_id },
		url			:	'/ajax/transaction/delete',
		dataType	:	'json',
		success		:	function(data) {
							if(data.type=='success') {
								jQuery("#deleteTransactionModal").modal('hide');
								jQuery("#"+transaction_id).hide();
							}
							noty(data);
						},
		error		:	function(jqXHR,status,err) {
							console.log(jqXHR);
							console.log(status);
							console.log(err);
						}
	});
});

//hide modal
jQuery("#delete-no").click(function() {
	jQuery("#deleteTransactionModal").modal('hide');
});

</script>
@endsection