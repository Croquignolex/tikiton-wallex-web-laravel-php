@extends('layouts.error')

@section('error.layout.title', page_title('429'))

@section('error.code', '429')

@section('error.title', trans('error.429_title'))

@section('error.body', trans('error.429_message'))