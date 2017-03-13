@extends('layout.master')
@section('title')


    {!! Charts::assets() !!}
    {!! $chart->render() !!}
@stop