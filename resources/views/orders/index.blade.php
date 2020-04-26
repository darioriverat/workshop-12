@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-center">
                        <div class="col-sm-8">
                            <h1>Ordenes</h1>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead class="thead">
                            <tr>
                                <th>Foto</th>
                                <th>Usuario</th>
                                <th>País</th>
                                <th>Valor</th>
                                <th>Estado</th>
                                <th>Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    @if($order->photo)
                                    <img src="{{ asset('storage').'/'.$order->photo}}" alt="" width="100">
                                    @else
                                    <img  src="{{asset('img/no-image-icon.png')}}"  alt="" width="100">
                                    @endif

                                </td>
                                <td>{{$order->user_id}}</td>
                                <td> @if($order->country =='co')COLOMBIA
                                        @else ECUADOR
                                        @endif</td>
                                <td>{{number_format($order->paymentAmount, 2)}} {{$order->currency}}</td>
                                <td>
                                @if($order->status =='CREATED')PENDIENTE DE PAGO
                                @elseif($order->status =='REJECTED')RECHAZADA
                                @elseif($order->status =='PAYED')PAGADA
                                @else ESPERANDO AUTORIZACIÓN
                                @endif
                            </td>
                            <td>
                                <div class="form-group row">
        
                                    <a href="{{url('orders/'.$order->id)}}" class="btn btn-secondary m-2">Ver Resumen </a>
        
                                </div>
                            </td>
                            </tr>
                            @endforeach
                            @if(count($orders)==0)
                            <tr>
                                <td colspan="6">No se han encontrado registros</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    
                    <div class="form-group row  justify-content-center">
                        {!!$orders->render()!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection