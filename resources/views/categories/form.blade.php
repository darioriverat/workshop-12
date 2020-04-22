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
                    value="{{$category->name ?? ''}}" required autocomplete="name" autofocus>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Descripción') }}</label>

                <div class="col-md-6">
                    <input id="description" type="text" class="form-control @error('mobile') is-invalid @enderror"
                        name="description" value="{{$category->description ?? ''}}" required autocomplete="description" autofocus>

                    @error('description')
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