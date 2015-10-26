@inject('data', 'App\Models\Product')
<?php 
    $data          = $data->find($id);
?>

@extends('template.frontend.layout')

@section('content')
	<!-- cont here -->
@stop