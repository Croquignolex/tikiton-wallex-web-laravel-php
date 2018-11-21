@extends('layouts.error')

@section('error.layout.title', page_title('503'))

@section('error.code', '503')

@section('error.title', trans('error.503_title'))

@section('error.body', trans('error.503_message'))