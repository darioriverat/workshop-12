@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <!-- <div class="card-header">Resumen de la Orden</div> -->
                <div class="card-body">
                    <form action="{{url('/orders/'.$order->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('PATCH')}}
                        <h4 class="text-center py-3"> Resumen de Compra</h4>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="card" style="width: 15rem;">
                                    @if($order->photo)
                                    <img class="card-img-top " src="{{ asset('storage').'/'.$order->photo}}" alt="">
                                    @else
                                    <img class="card-img-top " src="{{asset('img/no-image-icon.png')}}" alt=""
                                        width="50">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{$order->name}}</h5>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="card-text"><b>Categoria</b> : {{$order->category_name}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="card-text"><b>Descripción</b> : {{$order->description}}</p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="card-text"><b>Precio</b> :
                                                    {{number_format($order->price, 2).' ' .$order->currency}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($order->status =='PAYED')
                                <label id="product_description" id="product_description"> <b>Estado : </b> Pagada</label>
                                <img src="{{asset('img/PAYED.png')}}" alt="" width="100">
                                @endif
                                @if($order->status =='REJECTED')
                                <label><b>Estado : </b> Rechazada</label>
                                <img src="{{asset('img/REJECTED.png')}}" alt="" width="100">
                                @endif
                                @if($order->status =='PENDING')
                                <label><b>Estado : </b> Pendiente , esperando autorizacion intentalo más tarde</label>
                                <img src="{{asset('img/PENDING.png')}}" alt="" width="100">
                                @endif
                              
                            </div>
                        </div>

                        <div class="form-group justify-content-center row">
                            <div class="center">
                                <a class="btn btn-secondary" href="{{url('/orders')}}">Regresar</a>
                                @if($order->status =='CREATED')
                                <input class="btn btn-primary" type="submit" value="Pagar"></button>
                                @endif
                                @if($order->status =='REJECTED')
                                <input class="btn btn-primary" type="submit" value="Reintentar"></button>
                                @endif
                                @if($order->status =='PENDING')
                                @endif
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection