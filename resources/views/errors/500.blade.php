@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Sorry buddy. We encountered an error while processing your request.'))
