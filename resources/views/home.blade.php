@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Selecciona un producto a comprar</div>
                <div class="card-body">
                     <table class="table table-striped">
                        <thead class="thead">
                            <tr>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Moneda</th>
                                <th></th>
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
                                                <a class="btn btn-primary m-2"href="{{url('/orders/create/'.$product->id)}}">Comprar</a>
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
