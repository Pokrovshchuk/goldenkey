@extends('admin.layouts.main')
@section('content')
    {{--============================================--}}


    <div class="container">
        <div class="row">
            <div class="cold-12">
                <form action="{{route('create-certificates')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="products">Выберите сертификат</label>
                        <select name="product" class="form-control" id="products">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="more_than_one">more than one</label>
                        <input name="more_than_one" type="checkbox" class="form-control" id="more_than_one" aria-describedby="more_than_one">
                    </div>
                    <div class="form-group mb-4">
                        <label for="more_than_one">Сколько человек должно пройти по сертификату</label>
                        <input name="more_than_one" type="checkbox" class="form-control" id="more_than_one" aria-describedby="more_than_one">
                    </div>
                    <div class="form-group mb-4">
                        <label for="pass_limit">Сколько человек должно пройти по сертификату</label>
                        <input name="pass_limit" type="number" class="form-control" id="pass_limit" aria-describedby="pass_limit" placeholder="Введите количество человек">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Создать сертификат</button>
                </form>
            </div>
        </div>
    </div>
@endsection
