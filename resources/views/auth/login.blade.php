@extends('layouts.app')

@section('content')
<div class="ch-container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
		            <div class="alert alert-info">
						Please login with your Username and Password.
					</div>
					
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {!! csrf_field() !!}
						<fieldset>
		                    <div class="input-group input-group-lg {{ $errors->has('username') ? ' has-error' : '' }}">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user red"></i></span>
								<input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
								@if ($errors->has('username'))
									<span class="help-block">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
								@endif
							</div>
							<div class="clearfix"></div><br>
							
							<div class="input-group input-group-lg {{ $errors->has('password') ? ' has-error' : '' }}">
								<span class="input-group-addon"><i class="glyphicon glyphicon-lock red"></i></span>
								<input type="password" class="form-control" placeholder="Password" name="password">
								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif								
							</div>
							<div class="clearfix"></div>
							
							<div class="input-prepend">
								<label class="remember" for="remember"><input type="checkbox" id="remember"> Remember me</label>
							</div>
							<div class="clearfix"></div>
							
							<p class="center col-md-5">
								<button type="submit" class="btn btn-primary">Login</button><br />
								<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
							</p>
							
						</fieldset>
                    </form>
					
                </div>
            </div>
        </div>
    </div><!--/row-->
</div><!--/.fluid-container-->


@endsection
