@extends('errors::mentalite')

@section('title', __('- File not Found'))
@section('code', '404')
@section('message', __($exception->getMessage() ?: 'File not Found'))