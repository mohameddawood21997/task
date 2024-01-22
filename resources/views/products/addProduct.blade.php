@extends('layouts.app')

@section('content')

@if (Session::has('success'))
    <div class="alert alert-success col-6">
        {{ Session::get('success') }}
    </div>
@endif
<form action="{{route("products.store")}}" method="post" class="col-8 m-5">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Arabic Name</label>
      <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp">
      @error('name')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1"  class="form-label">English name</label>
        <input type="text" name="name_en" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        @error('name_en')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
      </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">price</label>
      <input type="number" name="price" class="form-control" id="exampleInputPassword1">
      @error('price')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
    </div>
 
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
    
@endsection