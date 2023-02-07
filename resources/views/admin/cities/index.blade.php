@extends('admin.layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="{{route('add-city')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <div class="form-group">
                            <label for="city_name">Город</label>
                            <input name="city_name" type="text" class="form-control" id="city_name" aria-describedby="city_name" placeholder="Введити название города">
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <ul class="list-group">
                            @foreach($cities as $city)
                                <li class="list-group-item">{{$city->name}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Добавить город</button>
                </form>
            </div>
        </div>
    </div>
@endsection
