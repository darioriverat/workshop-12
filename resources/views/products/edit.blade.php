@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                    @if(session('Message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('Message') }}
                    </div>
                    @endif
    
                    @if(session('MessageError'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('MessageError') }}
                    </div>
                    @endif
                <div class="card-header">Editar una categoria</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form action="{{url('/products/'.$category->id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('PATCH')}}
                        @include('products.form', ['type'=>'editar'])
        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
