@extends('layouts.app')
@section('content')

<div class="row">
      <div class="col-lg-12 margin-tb">
        <div class="pull-left">
          <h2>Cadastrar Veículo</h2>
        </div>
      </div>
    </div>

@if ($errors->any())
    <div class="alert alert-danger">
      <strong>Ops!</strong>There is a problem with the data entered: <br><br>
      <ul>
        @foreach ($errors->all() as $error)
      <li>{{$error}}</li>
        @endforeach
      </ul>
    </div>
@endif

<form action="{{ route('vehicles.store')}}" method="POST">
    @csrf
    <div class="form-group">
      <label for="exampleInputEmail1">Placa do Veículo</label>
    <input type="text" class="form-control" name="board" placeholder="AAA-1111" value="{{old('board')}}" min="8" max="8">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Modelo do Veículo</label>
      <input type="text" class="form-control" name="model" placeholder="Modelo" value="{{old('model')}}" required maxlength="255">
    </div>  
    <div class="form-group">
      <label for="exampleInputEmail1">Cor do Veículo</label>
      <input type="text" class="form-control" name="color" placeholder="Cor" value="{{old('color')}}" required maxlength="255">
    </div>  
    <div class="form-group">
      <label for="exampleInputEmail1">Ano do Veículo</label>
      <input type="number" class="form-control" name="year" placeholder="0000" value="{{old('year')}}" required max="2020">
    </div>  

    <button type="submit" class="btn btn-primary">Cadastrar</button>
  </form>
@endsection