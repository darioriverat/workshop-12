<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div>

        <div>
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{$product->name ?? ''}}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

                <div class="col-md-6">
                    <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        name="description" value="{{$product->description ?? ''}}" required autocomplete="description" autofocus>

                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                    <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Precio') }}</label>
    
                    <div class="col-md-6">
                        <input id="price" type="number" class="form-control @error('price') is-invalid @enderror"
                            name="price" value="{{$product->price ?? ''}}" required autocomplete="price" autofocus>
    
                        @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
            </div>
            <div class="form-group row">
                    <label for="currency" class="col-md-4 col-form-label text-md-right">{{ __('Moneda') }}</label>
    
                    <div class="col-md-6">
                            <select value="" name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror" required autocomplete="currency" autofocus>
                                    <option value="">-- Selecciona una opción --</option>    
                                    <option {{$product->currency ?? '' =='COP' ? ' selected ':''}} value="COP">Peso Colombiano</option>
                                    <option {{$product->currency ?? ''=='USD' ? ' selected ':''}} value="USD">Dolar Estadounidense</option>
                            </select>
                        @error('currency')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
            </div>
            <div class="form-group row">
                    <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('Categoria') }}</label>
                    <div class="col-md-6">
                            <select value="{{$product->category ?? ''}}" name="category_id" id="category" class="form-control @error('category_id') is-invalid @enderror"  required autocomplete="category_id" autofocus>
                                    <option value="">-- Selecciona una opción --</option>
                                    @foreach ($categories as $category)
                                        <option {{ $product->category_id ?? ''== $category->id ? ' selected ':''}} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                            </select>
                        @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
            </div>
            <div class="form-group row">
                    <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                    <div class="col-md-6">
                        @if(isset($product->photo))
                        <img src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                        @endif

                        <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror"
                            name="photo" accept="image/png, image/jpeg" value="{{$product->photo ?? ''}}" 
                            autocomplete="photo" autofocus>

                        @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{$type=='create'? 'Agregar': 'Modificar'}}
                    </button>
                </div>
            </div>
        </div>

    </div>
</body>

</html>