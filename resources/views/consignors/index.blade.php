@extends('layouts.app')

@section('title','Consignors')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Consignor
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')
					
                    <!-- New Consignor Form -->
                    <form action="{{ url('consignor') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Consignor FirstName -->
                        <div class="form-group {{ ($errors->first('firstname')) ? 'has-error'  :''}}">
                            <label for="consignor-firstname" class="col-sm-3 control-label">First Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="firstname" id="consignor-firstname" class="form-control" value="{{ Request::old('firstname') }}">
                            </div>
                        </div>

						<!-- Cosignor Lastname -->
						<div class="form-group {{ ($errors->first('lastname')) ? 'has-error'  :''}}">
                            <label for="consignor-lastname" class="col-sm-3 control-label">Last Name</label>

                            <div class="col-sm-6">
                                <input type="text" name="lastname" id="consignor-lastname" class="form-control" value="{{ Request::old('lastname') }}">
                            </div>
                        </div>
						
                        <!-- Add Consignor Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Consignor
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
		
		<div class="container">
            <!-- Current Consignors -->
            @if (count($consignors) > 0)
			<div class="row">
				<div class="box col-md-12">
					<div class="box-inner">
						<div class="box-header well" data-original-title="">
							<h2>Consignors</h2>

							<div class="box-icon">
								<a href="#" class="btn btn-setting btn-round btn-default"><i class="glyphicon glyphicon-cog"></i></a>
								<a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
								<a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							@if (session('error'))
								<div class="alert alert-danger">
									{{ session('error') }}
								</div>
							@endif
						
							<table class="table table-bordered table-striped table-condensed">
								<thead>
								<tr>
									<th>Firstname</th>
									<th>Lastname</th>
									<th>&nbsp;</th>
								</tr>
								</thead>
								<tbody>
								
								@foreach ($consignors as $consignor)
                                    <tr>
                                        <td class="table-text"><div>{{ $consignor->firstname }}</div></td>
										<td class="table-text"><div>{{ $consignor->lastname }}</div></td>
										
                                        <!-- Consignor Delete Button -->
                                        <td>
                                            <form action="{{url('consignor/' . $consignor->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-consignor-{{ $consignor->id }}" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
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
@endsection

@section('javascripts')
@parent
<script type="text/javascript">


</script>
@endsection