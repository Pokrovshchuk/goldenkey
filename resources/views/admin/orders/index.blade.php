@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form class="row" action="{{route('add-order')}}" method="POST">
                    @csrf
                    <div class="col-md-6 form-group mb-4">
                        <label for="name">Название серификата</label>
                        <input name="name" type="text" class="form-control" id="name" aria-describedby="name"
                               placeholder="Введити название сертификата">
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label for="exampleFormControlSelect1">Выберите зал</label>
                        <select name="hall_id" class="form-control" id="exampleFormControlSelect1">
                            @foreach($halls as $hall)
                                <option value="{{$hall->id}}">{{$hall->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label for="count">Количество</label>
                        <input name="count" type="number" class="form-control" id="count" aria-describedby="count"
                               placeholder="Введити название сертификата">
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label for="price">Цена</label>
                        <input name="price" type="price" class="form-control" id="price" aria-describedby="price"
                               placeholder="Введити название сертификата">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Добавить вид сертификата</button>
                </form>

                <div class="row">
                    <div class="col-12">
                        <h2>Список залов</h2>
                        <ul class="list-group">
                            @foreach($products as $product)
                                <li class="list-group-item">{{$product->name}} - {{$product->count}}шт.</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
