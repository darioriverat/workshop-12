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
                <div class="card-header">
                    <div class="row justify-content-left">
                        <div class="col-sm-8">
                            <h1>Categorias</h1>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary" href="{{route('categories.create')}}">Agregar una categoria</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <table class="table table-light">
                        <thead class="thead">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($categories)>0)
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->description}}</td>
                                <td>
                                    <div class="form-group row">
                                        <a href="{{url('categories/'.$category->id.'/edit')}}"
                                            class="btn btn-secondary m-2">Editar</a>

                                        <form method="post" action="{{url('categories/'.$category->id)}}">

                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                                            <button class="btn btn-primary m-2" type="submit"
                                                onclick="return confirm('Desea borrar el producto {{$category->name}}');">Borrar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">No se han encontrado registros</td>
                            </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection