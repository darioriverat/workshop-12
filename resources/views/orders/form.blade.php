<div>

    <div>
        <div class="form-group row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card">
                    @if($product->photo)
                    <img class="card-img-top" src="{{ asset('storage').'/'.$product->photo}}" alt="" width="100">
                    @else
                    <img class="card-img-top" src="{{asset('img/no-image-icon.png')}}" alt="" width="100">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <div class="row">
                            <div class="col-sm-6"><p class="card-text"><b>Categoria</b> : {{$product->category->name}}</p></div>
                            <div class="col-sm-6"><p class="card-text"><b>Descripción</b> : {{$product->description}}</p></div>
                            <div class="col-sm-12"><p class="card-text"><b>Precio</b> : {{number_format($product->price, 2).' ' .$product->currency}}</p></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="form-group row">
                <input id="product_id" hidden type="number" step="1" class="form-control @error('product_id') is-invalid @enderror"
                name="product_id" placeholder="Cantidad" value="{{$product->id ?? ''}}"
                autocomplete="product_id" autofocus>
            <label for="country" class="col-md-2 col-form-label text-md-right">{{ __('Pais de Pago') }}</label>
            <div class="col-md-4">
                <select value="" name="country" id="country" class="form-control @error('country') is-invalid @enderror"
                    required autocomplete="country" autofocus>
                    <option value="">-- Selecciona una opción --</option>
                    <option {{$product->country ?? '' =='co' ? ' selected ':''}} value="co">Colombia</option>
                    <option {{$product->country ?? ''=='ec' ? ' selected ':''}} value="ec">Ecuador</option>
                </select>
                @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="col-md-6">
                <input id="quantity" type="number" step="1" class="form-control @error('quantity') is-invalid @enderror"
                    name="quantity" placeholder="Cantidad" value="1" required
                    autocomplete="quantity" autofocus>

                @error('quantity')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row mb-0 justify-content-center">
            <button type="submit" class="btn btn-primary">
                {{$type=='create'? 'Guardar': ''}}
            </button>
        </div>

    </div>
</div>