@extends('layouts.main')

@section('main-section')
<h1 class="text-center">
    Login Page
</h1>
<form  method="post" action="{{url('/login_check')}}"  class="my-5 mx-5">
    @csrf
  <div class="mb-3 col-5">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3 col-5">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" required class="form-control" id="exampleInputPassword1">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection