@extends('layouts.app')

@section('content')

<div class="ch-container">
	<div class="row">
		<div class="box col-md-4">
			<div class="box-inner">
				<div class="box-header well" data-original-title="">
					<h2><i class="glyphicon glyphicon-list-alt"></i> Pie</h2>

					<div class="box-icon">
						<a href="#" class="btn btn-setting btn-round btn-default"><i
								class="glyphicon glyphicon-cog"></i></a>
						<a href="#" class="btn btn-minimize btn-round btn-default"><i
								class="glyphicon glyphicon-chevron-up"></i></a>
						<a href="#" class="btn btn-close btn-round btn-default"><i
								class="glyphicon glyphicon-remove"></i></a>
					</div>
				</div>
				<div class="box-content">
					<div id="piechart" style="height:300px"></div>
				</div>
			</div>
		</div>

		<div class="box col-md-4">
			<div class="box-inner">
				<div class="box-header well" data-original-title="">
					<h2><i class="glyphicon glyphicon-list-alt"></i> Donut</h2>

					<div class="box-icon">
						<a href="#" class="btn btn-setting btn-round btn-default"><i
								class="glyphicon glyphicon-cog"></i></a>
						<a href="#" class="btn btn-minimize btn-round btn-default"><i
								class="glyphicon glyphicon-chevron-up"></i></a>
						<a href="#" class="btn btn-close btn-round btn-default"><i
								class="glyphicon glyphicon-remove"></i></a>
					</div>
				</div>
				<div class="box-content">
					<div id="donutchart" style="height: 300px;">
					</div>
				</div>
			</div>
		</div>
	</div><!--/row-->
</div><!--/.fluid-container-->

<!-- chart libraries start -->
<script src="bower_components/flot/excanvas.min.js"></script>
<script src="bower_components/flot/jquery.flot.js"></script>
<script src="bower_components/flot/jquery.flot.pie.js"></script>
<script src="bower_components/flot/jquery.flot.stack.js"></script>
<script src="bower_components/flot/jquery.flot.resize.js"></script>
<!-- chart libraries end -->
<script src="js/init-chart.js"></script>

@endsection
