@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="">name</label>
                    <input class="form-control" type="text" name="name">
                    <label for="">price</label>
                    <input class="form-control" type="number" name="price">
                    <label for="">Image</label>
                    <input type="file" class="form-control" name="image">
                    <button class="btn btn-success mt-3" type="submit">เพิ่ม</button>
                </form>
            </div>
        </div>
    </div>
@endsection
