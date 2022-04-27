@extends('themes.default.layout')

@section('page_title', $page->title)

@section('page_body')
{{-- {{ $current_nav_page }} --}}
<div class="page-body-container">
{!! $page->body !!}
</div>

@endsection