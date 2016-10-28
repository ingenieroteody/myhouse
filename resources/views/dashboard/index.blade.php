@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="ch-container">
	<div class="row">
		<div class="box col-md-4">
			<div class="box-inner">
				<div class="box-header well" data-original-title="asd">
					<h2><i class="glyphicon glyphicon-list-alt"></i> Most sold items today</h2>

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


@section('javascripts')
@parent
<!-- chart libraries start -->
<script src="bower_components/flot/excanvas.min.js"></script>
<script src="bower_components/flot/jquery.flot.js"></script>
<script src="bower_components/flot/jquery.flot.pie.js"></script>
<script src="bower_components/flot/jquery.flot.stack.js"></script>
<script src="bower_components/flot/jquery.flot.resize.js"></script>
<!-- chart libraries end 
<script src="js/init-chart.js"></script>-->

<script type="text/javascript">

var mostSoldItemsData = [];

jQuery.ajax({
	type		:	'GET',
	//url			:	'/dashboard/ajaxGetMostSoldItems/' + moment().format('YYYY-MM-DD'),
	url			:	'/dashboard/ajaxGetMostSoldItems/2016-10-26',
	dataType	:	'json',
	success		:	function(data) {						
						for(var d in data.data) {
							if (data.data.hasOwnProperty(d)) {
						
								mostSoldItemsData.push({
									label : '['+data.data[d].item.code+'] ' + data.data[d].item.name,
									data : parseInt(data.data[d].total_quantity)
								});
							  }
						}
						
						
											
						if ($("#piechart").length) {
							$.plot($("#piechart"), mostSoldItemsData,
								{
									series: {
										pie: {
											show: true
										}
									},
									grid: {
										hoverable: true,
										clickable: true
									},
									legend: {
										show: false
									}
								});

							function pieHover(event, pos, obj) {
								if (!obj)
									return;
								percent = parseFloat(obj.series.percent).toFixed(2);
								$("#hover").html('<span style="font-weight: bold; color: ' + obj.series.color + '">' + obj.series.label + ' (' + percent + '%)</span>');
								console.log(obj.series);
							}

							//$("#piechart").bind("plothover", pieHover);
						}
						
					},
	error		:	function(jqXHR,status,err) {
						console.log(jqXHR);
						console.log(status);
						console.log(err);
					}
});
</script>
@endsection
