
@extends ('layouts.inicio')
@section ('contenido')
@include('alerts.success')
@include('alerts.request')
@include('alerts.errors')

 


<?php
$message=Session::get('message');
?>



 
 






	<img  src='images/logo.png' style="width: 100%; height: 100%;" >	
		

 
 



 








</div>

 
@endsection

