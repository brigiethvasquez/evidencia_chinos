
@extends('layouts.masterpage')
  
@section('contenido')

<form class="form-horizontal" method="POST"
    enctype="multipart/form-data" 
   action="{{ url('media-types/store')}}">
@csrf
<h2>Upload media types with CSV File:</h2>
    <fieldset>
  
    <div class="form-group">
      <label class="col-md-4 control-label" for="media-types">File:</label>
      <div class="col-md-4">
        <input id="media-types" name="media-types" class="input-file" type="file">
        <strong class="text-danger"> {{$errors->first('media-types')}} </strong>
      </div>
    </div>
    <div class="form-group">
      <label class="col-md-4 control-label" for=""></label>
      <div class="col-md-4">
        <button type="submit" id="" name="" class="btn btn-primary">Enviar</button>
      </div>
    </div>
    
    </fieldset>
    @if (session('exito'))
        <p class="alert-success">{{session('exito')}}</p>
    @endif
    
    @if (session('repetidos'))
      @foreach (session('repetidos') as $mediarepetido)
          <p class="alert-warning">{{ $mediarepetido }}</p>
       @endforeach
    @endif
    </form>
    @endsection