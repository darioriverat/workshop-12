@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="width: -webkit-fill-available;">
                    <div class="card-body">
                        <form action="{{url('/orders/'.$order->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            {{method_field('PATCH')}}
                            <h4 class="text-center py-3">{{__('orders.summaryTitle')}}</h4>
                            <div class="form-group row">
                                <div class="card">
                                    @if($order->photo)
                                        <img class="card-img-top "style="width: 35%; align-self: center;" src="{{ asset('storage').'/'.$order->product->photo}}" alt="">
                                    @else
                                        <img class="card-img-top "style="width: 35%; align-self: center;" src="{{asset('img/no-image-icon.png')}}" alt=""
                                             width="50">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{$order->product->name}}</h5>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="card-text"><b>@lang('orders.columns.category')</b> :
                                                    {{$order->product->category->name}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="card-text"><b>@lang('orders.columns.description')</b> :
                                                    {{$order->product->description}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="card-text"><b>@lang('orders.columns.price')</b> :
                                                    {{number_format($order->payment_amount, 2).' ' .$order->currency}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="card-text"><b>@lang('orders.columns.quantity')</b> :
                                                    {{$order->quantity}}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="card-text"><b>@lang('orders.columns.date')</b> :
                                                    {{$order->created_at}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="card" style="width: -webkit-fill-available;">
                                    @if($order->status =='PAYED')
                                        <label class="pt-3">
                                            <b>@lang('orders.columns.status') :
                                            </b>
                                            @lang('status.payed')</label>
                                        <hr>
                                        <img style="align-self: center;" src="{{asset('img/PAYED.png')}}" alt="" width="100">
                                    @elseif($order->status =='REJECTED')
                                        <label class="pt-3"><b>@lang('orders.columns.status') : </b> @lang('status.rejected')</label>
                                        <hr>
                                        <img style="align-self: center;"  src="{{asset('img/REJECTED.png')}}" alt="" width="100">
                                    @elseif($order->status =='PENDING')
                                        <label class="pt-3"><b>@lang('orders.columns.status') : </b>
                                            @lang('status.pending')</label>
                                        <hr>
                                        <img style="align-self: center;"  src="{{asset('img/PENDING.png')}}" alt="" width="100">
                                    @else
                                        <label class="pt-3"><b>@lang('orders.columns.status') : </b>
                                            @lang('status.created')</label>
                                        <hr>
                                        <img style="align-self: center;"  src="{{asset('img/PENDING.png')}}" alt="" width="100">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group justify-content-center row">
                                <div class="center">
                                    <a class="btn btn-secondary"
                                       href="{{url('/orders')}}">{{__('actions.options.button.return')}}</a>
                                    @if($order->status =='CREATED' or $order->status =='PENDING' )
                                        <input class="btn btn-primary" type="submit"
                                               value="{{__('actions.options.button.pay')}}"></button>
                                    @endif
                                    @if($order->status =='REJECTED')
                                        <input class="btn btn-primary" type="submit"
                                               value="{{__('actions.options.button.retry')}}"></button>
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
