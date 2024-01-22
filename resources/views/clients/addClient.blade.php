@extends('layouts.app')

@section('content')
<form action="{{route("clients.store")}}" method="post" class="col-8 m-5">
    @csrf
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Arabic Name</label>
      <input type="text" class="form-control" id="exampleInputEmail1" name="name" aria-describedby="emailHelp">
     
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1"  class="form-label">English name</label>
        <input type="text" name="name_en" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
       
      </div>

 
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
    
@endsection