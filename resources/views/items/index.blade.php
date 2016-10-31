@extends('layouts.app')

@section('title','Items')

@section('content')
    <div class="container">
	
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">			
                <div class="panel-heading">
                    New Item
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Item Form -->
                    <form action="{{ url('item') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Item Code -->
                        <div class="form-group {{ ($errors->first('code')) ? 'has-error'  :''}}">
                            <label for="item-code" class="col-sm-3 control-label">Item Code</label>

                            <div class="col-sm-6">
                                <input type="text" name="code" id="item-code" class="form-control" value="{{ Request::old('code') }}">
                            </div>
                        </div>

						<!-- Item Name -->
						<div class="form-group {{ ($errors->first('name')) ? 'has-error'  :''}}">
                            <label for="item-name" class="col-sm-3 control-label">Item Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="name" id="item-name" class="form-control" value="{{ Request::old('name') }}">
                            </div>
                        </div>

						<!-- Price -->
						<div class="form-group {{ ($errors->first('price')) ? 'has-error'  :''}}">
                            <label for="item-price" class="col-sm-3 control-label">Price</label>

                            <div class="col-sm-6">
                                <input type="text" name="price" id="item-price" class="form-control" value="{{ Request::old('price') }}">
                            </div>
                        </div>
						
						<!-- Owner/Consignor -->
						<div class="form-group {{ ($errors->first('consignor_id')) ? 'has-error'  :''}}">
                            <label for="item-consignor" class="col-sm-3 control-label">Consignor</label>

                            <div class="col-sm-6">
								<select id="item-consignor" name="consignor_id" data-placeholder="Choose a Consignor..." class="chosen-select form-control" style="width:350px;" tabindex="2">
									<option value="">-- Consignor --</option>
									@foreach ($consignors as $consignor)
										<option value="{{$consignor->id}}" {{ (old('consignor_id') == $consignor->id) ? "selected" : "" }} >{{$consignor->lastname}}, {{$consignor->firstname}}</option>
									@endforeach
								</select>
                            </div>
                        </div>
						
                        <!-- Add Item Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Item
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
		
		<div class="container">
			@if (session('msg'))
				<div class="alert alert-success">
					{{ session('msg') }}
				</div>
			@endif
            <!-- Current Items -->
            @if (count($items) > 0)
			<div class="row">
				<div class="box col-md-12">
					<div class="box-inner">
						<div class="box-header well" data-original-title="">
							<h2>Items</h2>

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
									<th>Item Code</th>
									<th>Item Name</th>
									<th>Price</th>
									<th>Consignor</th>
									<th>Available Stock</th>
									<th>&nbsp;</th>
								</tr>
								</thead>
								<tbody>
								
								@foreach ($items as $item)
                                    <tr id="{{ $item->id }}">
                                        <td class="table-text"><div>{{ $item->code }}</div></td>
										<td class="table-text"><div>{{ $item->name }}</div></td>
										<td class="table-text"><div>{{ $item->price }}</div></td>
										<td class="table-text"><div>{{ $item->consignor->firstname }}</div></td>
										<td class="table-text"><div>{{ $item->stocks}}</div></td>
										
                                        <!-- Item Action Buttons -->
                                        <td>
											<a class="btn btn-setting" id="addRemoveStock-{{$item->id}}" data-id="{{$item->id}}" href="#" >Add/Remove Stock</a>
											<a class="btn btn-default" id="editStock-{{$item->id}}" data-id="{{$item->id}}" href="#" ><i class="glyphicon glyphicon-edit"></i> Edit</a>
											<a class="btn btn-danger" id="deleteItem-{{$item->id}}" data-id="{{$item->id}}" href="#" ><i class="glyphicon glyphicon-trash"></i> Delete</a>
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
		
	<!-- Modal for Stock -->
	<div class="modal fade" id="modalAddRemoveStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Add/Remove Stock</h3>
                </div>
                <div class="modal-body form-group">
                    <div class="form-group">
						<label for="stock" class="col-sm-2 control-label">Quantity</label>
						
						<div class="col-sm-2">
							<input type="text" class="form-control" id="stock" name="stock" />
						</div>
					</div>

                </div>
                <div class="modal-footer">
					<a href="#" id="add-stock" class="btn btn-default" data-mode="add"><i class="glyphicon glyphicon-plus-sign"></i></a>
                    <a href="#" id="minus-stock" class="btn btn-primary" data-mode="minus"><i class="glyphicon glyphicon-minus-sign"></i></a>
				</div>
            </div>
        </div>
    </div>
	
	<!-- Modal for edit -->
		<div class="modal fade" id="modalEditStock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h3>Edit Stock</h3>
                </div>
                <div class="modal-body form-group">
					<div class="panel-body">
						<!-- Display Validation Errors -->
						@include('common.errors')

						<!-- Edit Item Form >-->
						<form action="" method="POST" class="form-horizontal">
							{{ csrf_field() }}
							<!-- Item Code -->
							<div class="form-group">
								<label for="edit-code" class="col-sm-3 control-label">Item Code</label>

								<div class="col-sm-6">
									<input type="text" name="code" id="edit-code" class="form-control" value="">
								</div>
							</div>

							<!-- Item Name -->
							<div class="form-group">
								<label for="edit-name" class="col-sm-3 control-label">Item Name</label>

								<div class="col-sm-6">
									<input type="text" name="name" id="edit-name" class="form-control" value="">
								</div>
							</div>

							<!-- Price -->
							<div class="form-group">
								<label for="edit-price" class="col-sm-3 control-label">Price</label>

								<div class="col-sm-6">
									<input type="text" name="price" id="edit-price" class="form-control" value="">
								</div>
							</div>
							
							<!-- Owner/Consignor -->
							<div class="form-group">
								<label for="edit-consignor_id" class="col-sm-3 control-label">Consignor</label>

								<div class="col-sm-6">
									<select id="edit-consignor_id" name="consignor_id" data-placeholder="Choose a Consignor..." class="chosen-select form-control" style="width:350px;" tabindex="2">
										<option value="">-- Consignor --</option>
										@foreach ($consignors as $consignor)
											<option value="{{$consignor->id}}" {{ (old('consignor_id') == $consignor->id) ? "selected" : "" }} >{{$consignor->lastname}}, {{$consignor->firstname}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</form>
					</div>		
                </div>
                <div class="modal-footer">
					<a id="edit-form" href="#" data-url="{{ url('/ajax/item/update') }}" class="btn btn-default">Save Changes</a>
                    <a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
				</div>
            </div>
        </div>
    </div>
@endsection

@section('javascripts')
@parent
<script type="text/javascript">
	//load the price when item is selected
	
	//global
	var itemId = 0;
	var token = jQuery('#data-token').val();
	
	jQuery("[id^=editStock-]").click(function(){
		jQuery.ajax({
			type		:	'GET',
			url 		:	'/ajax/items/'+jQuery(this).attr('id').split('-')[1],
			dataType	:	'json',
			success		:	function(data) {
								jQuery('#edit-code').val(data.code);
								jQuery('#edit-name').val(data.name);
								jQuery('#edit-price').val(data.price);
								jQuery('#edit-consignor_id').val(data.consignor_id);
								itemId = data.id;
							}
		});
	});

	//update item
	jQuery("#edit-form").click(function(e) {
		var _this = jQuery(this);
		
		var $inputs = $('div#modalEditStock input[id^=edit-], div#modalEditStock select[id^=edit-]');
		var data = $inputs.serializeArray();
		
		var view = {};
		for (var i in data) {
			view[data[i].name] = data[i].value;
		}
		
		view['_token'] = token;
		view['_method'] = 'PUT';
		view['id'] = itemId;
		
		jQuery.ajax({
			type		:	'POST',
			data		:	view,
			url			:	_this.data('url'),
			dataType	:	'json',
			success		:	function(data) {
								
								if(data.type=="success") {
									jQuery('#modalEditStock').modal('hide');
									
									//update the values in table
									jQuery("tr#"+itemId+" > td:nth-child(1) > div").text(data.data.code);
									jQuery("tr#"+itemId+" > td:nth-child(2) > div").text(data.data.name);
									jQuery("tr#"+itemId+" > td:nth-child(3) > div").text(data.data.price);
									jQuery("tr#"+itemId+" > td:nth-child(4) > div").text(data.data.consignor.firstname);
									console.log(data);
								} else {
									$msg = "";
									//remove all error class
									jQuery('input[id^=edit-]').parent().parent().removeClass('has-error');
									
									//add error class to input fields container
									for(var d in data.text) {
										if (data.text.hasOwnProperty(d)) {
											$msg += data.text[d] + "<br />";
											var elem = jQuery("#edit-"+d);
											elem.parent().parent().addClass('has-error');											
										  }
									}
									data.text = $msg;
								}
								
								noty(data);
								
							},
			error		:	function(data) {
								console.log(data);
							}
		});
		
		
	});
	
	//update stock
	jQuery("#add-stock,#minus-stock").click(function(e) {
		var _this = jQuery(this);
		console.log(_this.data('mode'));				
		jQuery.ajax({
			type		:	'POST',
			data		:	{stock : jQuery('#stock').val(), _token : token, id : _this.data('id'), mode : _this.data('mode'), _method : 'PUT' },
			url			:	'/ajax/stock/update',
			dataType	:	'json',
			success		:	function(data) {
								if(data.type == "success") {
									$('#modalAddRemoveStock').modal('hide');
									jQuery("tr#"+itemId+" > td:nth-child(5) > div").text(data.text.stocks);
									data.text = "Successfully updated the stocks";
									jQuery('#stock').val('');
								}
								noty(data);
							},
			error		:	function(xhr, status, err) {
								//noty(data);
								console.log(status);
								console.log(err);
								console.log(xhr);
							}
		});
	});
	
	//delete item
	jQuery("[id^=deleteItem-]").click(function(){
		var _this = jQuery(this);
		var id = _this.attr('id').split('-')[1];
		
		jQuery.ajax({
			type		:	'POST',
			url 		:	'/item',
			data		:	{ _method : 'DELETE', _token : token, id : id },
			dataType	:	'json',
			success		:	function(data) {
								if(data.type=="success") {
									_this.parent().parent().hide();
								}
								noty(data);
							},
			error		:	function(data) {
								console.log(data);
							}
		});
	});
	
	//modal for add/remove stock
    $('[id^=addRemoveStock-]').click(function (e) {
        e.preventDefault();
        jQuery('#modalAddRemoveStock').modal('show');
		jQuery('#stock').focus();
		itemId = jQuery(this).data('id');
		jQuery('#add-stock,#minus-stock').data('id',itemId);
    });
	
	//modal for editing stock
	$('[id^=editStock-]').click(function (e) {
        e.preventDefault();
		jQuery('input[id^=edit-],select[id^=edit-]').parent().parent().removeClass('has-error');
        jQuery('#modalEditStock').modal('show');
    });
</script>
@endsection
