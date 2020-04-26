@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear una categoria</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{url('/categories')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        @include('categories.form', ['type'=>'create'])
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection