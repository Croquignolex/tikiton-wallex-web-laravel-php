@extends('layouts.error')

@section('error.layout.title', page_title('404'))

@section('error.code', '404')

@section('error.title', trans('error.404_title'))

@section('error.body', trans('error.404_message'))