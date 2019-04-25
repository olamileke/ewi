@extends('layouts.app')

@section('page_title')
	Create Poem
@endsection()

@section('page_css')

	<link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="{{ asset('css/Poems/create.css') }}">	
	<link rel="stylesheet" type="text/css" href="{{ asset('css/notifications/info.css') }}">	

	<!-- WYSIWYG EDITOR STYLES  -->

	<link rel="stylesheet" type="text/css" href="{{ asset('css/froala/css/froalaeditor.pkgd.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/froala/css/froalastyle.min.css') }}">

	<!--  -->

	<meta name='csrf-token' content="{{ csrf_token() }}">	
	
@endsection


@section('page_body')

	<div class='new_tag'>
		
		<div class='tag'>

			<input type="text" name="tag" placeholder='Tag Name' autofocus>

			<div class='section'>
				<button class='close'>Close</button>				
				<button class='add'>Add</button>
			</div>
		</div>
	</div>

	<div class='container'>

		<form action='{{ route("poem.store") }}' method='POST' enctype='multipart/form-data'>

			{{ csrf_field() }}

			<div class='picture'>
				<div class='image'>
					<i class='fa fa-image'></i> 
				</div>
				<input type="file" name="picture">
			</div>

			<div class='main_content'>
				<label>Title</label>
				<input type="text" name="title" placeholder='Untitled'>

				<input type="text" name="imagepath" class='imagepath' hidden>

				<label>Poem Type</label>
				<select name='type'>
					
					@foreach($types as $type)
					
						<option value="{{ $type->id }}">{{ $type->type }}</option>
					@endforeach
				</select>

				<button class='tagbtn' type="button">Add Tags <i class='fa fa-plus'></i></button>
				<div class='tags'>
				</div>

				<label>Content</label>
				<textarea id='content' rows='14' name='content'></textarea>

				<input type="submit" value="Create">
			</div>
		</form>
	</div>
	
@endsection


@section('page_js')	

	<script type="text/javascript" src="{{ asset('js/Poems/create.js') }}"></script>

@endsection()