@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear un producto</div>
                <div class="card-body">
                    <form action="{{url('/products')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @include('products.form', ['type'=>'create'])
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
