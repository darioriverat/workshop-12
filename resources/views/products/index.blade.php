@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-left">
                        <div class="col-sm-8">
                            <h1>Productos</h1>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary" href="{{route('products.create')}}">Agregar un producto</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table table-striped">
                        <thead class="thead">
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Moneda</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($products)>0)
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->photo)
                                    <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                                    @else
                                    <img  src="{{asset('img/no-image-icon.png')}}"  alt="" width="100">
                                    @endif

                                </td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->description}}</td>
                                <td>{{number_format($product->price, 2)}}</td>
                                <td>{{$product->currency}}</td>
                                <td>
                                    <div class="form-group row">
                                        <a href="{{url('products/'.$product->id.'/edit')}}"
                                            class="btn btn-secondary m-2">Editar</a>

                                        <form method="post" action="{{url('products/'.$product->id)}}">

                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button class="btn btn-primary m-2" type="submit"
                                                onclick="return confirm('Desea borrar el producto {{$product->name}}');">Borrar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6">No se han encontrado registros</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    
                    <div class="form-group row  justify-content-center">
                        {!!$products->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection