@extends('layouts.main')

@section('main-section')
  <h1 class="text-center">
      Products Page
  </h1>
<div class="row m-2">
<form action="" class="col-3 d-flex justify-content-center align-items-center g-2">
      <div class="form-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name or price" value="{{$search}}"/>
      </div>
      <button class="btn btn-primary">Search</button>
      <a href="{{url('/products')}}">
        <button class="btn btn-danger" type="button">Reset</button>
      </a>
  </form>
</div>
 
  
    <table class="table">
    <thead class="table-dark">
      <tr>
        <th>Id</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Status</th>
        <th>Created at</th>
        <th>Updated at</th>
      </tr>
    </thead>
    <tbody>

@php $i=1; @endphp
@foreach ($products as $product)
      <tr>
        <td>{{ $i }}</td>
        <td>{{$product->product_name}}</td>
        <td>{{$product->product_price}}</</td>
        <td>
            @if($product->status == "1")
                Active
            @else
                Inactive
            @endif
        </td>
        <td>{{$product->created_at}}</</td>
        <td>{{$product->updated_at}}</</td>
      </tr>
      @php $i++; @endphp
@endforeach
    </tbody>
  </table>
  <div class="row">
    @if($products)
      {{$products->links();}}
    @endif
  </div>
@endsection
