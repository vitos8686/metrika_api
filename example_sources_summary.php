<?php 

	require('metrika_api.php');

	$metrika = new Metrika(OAUTH_TOKEN);
	$metrika->preset = 'sources_summary';
	$metrika->filters = array("ym:s:regionCityName=='Санкт-Петербург'");

	$stat = $metrika->stat( COUNTER_ID , date('Y-m-d') , date('Y-m-d') );

 ?>

 <!DOCTYPE html>
 <html lang="ru">
 <head>
 	<meta charset="UTF-8">
 	<title>Отчет "Источники - Сводка"</title>
	
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

 </head>
 <body>


 	<div class="container">
 		 <div class="page-header">
 		  			<h1>Отчет "Источники - Сводка"</h1>
 				</div> 
		<a target="_blank" class="pull-right" href="https://tech.yandex.ru/metrika/doc/api2/api_v1/examples-docpage/">API Метрики — Примеры</a>
 	</div>



	<?php if ( isset($stat['data']) ): ?>
		<div class="container">
 		
 			<table class="table table-striped table-hover">
 			
 				<thead>
 					<!-- dimensions -->
 					<th>TrafficSource</th>
 					<th>SourceEngine</th>
 					<!-- dimensions end -->
					
					<!-- metrics -->
					<th>visits</th>
					<th>users</th>
					<th>bounceRate</th>
					<th>pageDepth</th>
					<th>avgVisitDurationSeconds</th>
					<!-- metrics end -->

 				</thead>

 				<tbody>
 					<?php foreach ($stat['data'] as $key => $value): ?>
 						<tr>
 							<td><?=$value['dimensions'][0]['name'] ?></td>
 							<td><?=$value['dimensions'][1]['name'] ?></td>

 							<td><?=$value['metrics'][0] ?></td>
 							<td><?=$value['metrics'][1] ?></td>
 							<td><?=$value['metrics'][2] ?></td>
 							<td><?=$value['metrics'][3] ?></td>
 							<td><?=$value['metrics'][4] ?></td>
 						</tr>
 					<?php endforeach ?>
 				</tbody>

 			</table>

 		</div>
	<?php endif ?>


	<!-- ERROR -->
	<?php if ( isset($stat['errors']) ): ?>
		<div class="container">
			<p style="padding: 15px;" class="bg-danger">
				<b>Error</b> <?=$stat['message'] ?> <br>
				<b>Code</b> <?=$stat['code'] ?>
			</p>
		</div>
	<?php endif ?>
 	

 </body>
 </html>