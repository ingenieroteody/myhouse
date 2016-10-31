@extends('layouts.app')

@section('title','Report')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading box-header well">
                    Search Criteria
					<div class="box-icon">
						<a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
						<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
						<a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
					</div>
                </div>

				
                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- Search Criteria -->
                    <form action="{{ url('reports') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Item -->
						<div class="form-group">
                            <label for="consignor_id" class="col-sm-2 control-label">Consignor</label>

                            <div class="col-sm-6">
								<select id="consignor_id" name="consignor_id" data-placeholder="Choose Consignor" class="chosen-select form-control" style="width:350px;" tabindex="2">
									<option value="">-- Consignor --</option>
									@foreach ($consignors as $consignor)
										<option value="{{$consignor->id}}" >{{$consignor->firstname}} {{$consignor->lastname}}</option>
									@endforeach
								</select>
                            </div>
                        </div>

						<!-- Item -->
						<div class="form-group ">
                            <label for="item_id" class="col-sm-2 control-label">Item</label>
                            <div class="col-sm-2">
								<select id="item_id" name="item_id" data-placeholder="Choose an Item" class="chosen-select form-control" style="width:350px;" tabindex="2">
									<option value="">-- Item --</option>
								</select>
                            </div>
                        </div>
						
						<!-- Transaction Date From -->
						<div class="form-group ">
                            <label for="from" class="col-sm-2 control-label">Transaction Date From</label>
                            <div class="col-sm-2">
								<input type="text" name="from" id="from" class="form-control" value="{{ Request::old('from') }}">
                            </div>
                        </div>
						
						<!-- Transaction Date To -->
						<div class="form-group ">
                            <label for="to" class="col-sm-2 control-label">Transaction Date To</label>
                            <div class="col-sm-2">
								<input type="text" name="to" id="to" class="form-control" value="{{ Request::old('to') }}">
                            </div>
                        </div>
						
                        <!-- Add Consignor Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
		
		<div class="container">
            <!-- Filtered Transaction -->
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
@endsection

@section('javascripts')
@parent
<script type="text/javascript">
//load the items when a consignor is selected
3480
jQuery("#consignor_id").change(function(){
	jQuery.ajax({
		type		:	'GET',
		url 		:	'/ajax/consignoritems/'+jQuery(this).val(),
		dataType	:	'json',
		success		:	function(data) {
						//reset value of fields

						var select = jQuery('select#item_id');
						//reset option
						select.find('option').remove().end().append('<option>-- Item --</option>');

						for(var d in data) {
							if(data.hasOwnProperty(d)) {
								select.append(jQuery('<option>', {
									value : data[d].id,
									text : "[" + data[d].code + "] " + data[d].name
									}
								));
							}
						}
					},
		error		:	function(xhr,status,err) {
						console.log(xhr,status,err);
					}
	});
});

</script>
@endsection