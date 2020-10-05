@extends('layouts.app')
@section('content')

<div class="row">
  <div class="col">
    <div class="pull-left">
      <h2>Editar Veículos</h2>
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

<form action="{{route('vehicles.update', $vehicle->id)}}" method="POST">
  @csrf
  @method('PUT')

  <div class="form-group">
    <label for="exampleInputEmail1">Placa do Veículo</label>
  <input type="text" class="form-control" name="board" value="{{$vehicle->board}}" required minlength="8" maxlength="8">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Modelo do Veiculo</label>
    <input type="text" class="form-control" name="model" value="{{$vehicle->model}}" required maxlength="255">
  </div>  
  <div class="form-group">
    <label for="exampleInputEmail1">Cor do Veículo</label>
    <input type="text" class="form-control" name="color" value="{{$vehicle->color}}" required maxlength="255">
  </div>  
  <div class="form-group">
    <label for="exampleInputEmail1">Modelo do Veiculo</label>
    <input type="nymber" class="form-control" name="year" value="{{$vehicle->year}}" required maxlength="4">
  </div>  
  <button type="submit" class="btn btn-primary">Editar</button>
</form>

@endsection