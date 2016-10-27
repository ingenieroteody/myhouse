@extends('layouts.app')

@section('title','Users');

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    New Users
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Consignor Form -->
                    <form action="{{ url('user') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Item -->
						<div class="form-group {{ ($errors->first('username')) ? 'has-error'  :''}}">
                            <label for="username" class="col-sm-3 control-label">Username</label>

                            <div class="col-sm-6">
								<input type="text" name="username" id="username" class="form-control" value="{{ Request::old('username') }}">
                            </div>
                        </div>

						<!-- Firstname -->
						<div class="form-group">
                            <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                            <div class="col-sm-6">
                                <input type="text" name="firstname" id="firstname" class="form-control" value="{{ Request::old('firstname') }}">
                            </div>
                        </div>
						
						<!-- Lastname -->
						<div class="form-group">
                            <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                            <div class="col-sm-6">
                                <input type="text" name="lastname" id="lastname" class="form-control" value="{{ Request::old('lastname') }}">
                            </div>
                        </div>
						
                        <!-- Add User Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
		
		<div class="container">
            <!-- Current Users -->
            @if (count($users) > 0)
			<div class="row">
				<div class="box col-md-12">
					<div class="box-inner">
						<div class="box-header well" data-original-title="">
							<h2>Users</h2>

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
									<th>Username</th>
									<th>Firstname</th>
									<th>Lastname</th>
									<th>&nbsp;</th>
								</tr>
								</thead>
								<tbody>
								
								@foreach ($users as $user)
                                    <tr>
                                        <td class="table-text"><div>{{ $user->username }}</div></td>
										<td class="table-text"><div>{{ $user->firstname }}</div></td>
										<td class="table-text"><div>{{ $user->lastname }}</div></td>
										
                                        <!-- User Delete Button -->
                                        <td>
                                            <form action="{{url('user/' . $user->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-transaction-{{ $user->id }}" class="btn btn-danger">
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
