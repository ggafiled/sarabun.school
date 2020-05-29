@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message-title','Page not found')
@section('message', __('The page you are looking for might have been removed had its name changed or is temporarily
unavailable.'))