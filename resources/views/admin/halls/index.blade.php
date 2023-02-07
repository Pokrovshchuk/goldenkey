@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form enctype="multipart/form-data" action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group mb-4">
                            <label for="name">Название БЗ</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="name"
                                   placeholder="Введити название БЗ">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label for="admin_name">Название БЗ в админке</label>
                            <input name="admin_name" type="text" class="form-control" id="admin_name"
                                   aria-describedby="admin_name"
                                   placeholder="Введити название БЗ для админ панели">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label for="photos">Фото</label>
                            <input name="photos[]" type="file" multiple class="form-control" id="photos"
                                   aria-describedby="photos">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label for="working_time">Время работы</label>
                            <input name="working_time" type="text" class="form-control" id="working_time"
                                   aria-describedby="working_time"
                                   placeholder="Введити время работы">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label for="location">Где находится</label>
                            <input name="location" type="text" class="form-control" id="location"
                                   aria-describedby="location"
                                   placeholder="Введити время работы">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label for="exampleFormControlSelect1">Выберите город</label>
                            <select name="city_id" class="form-control" id="exampleFormControlSelect1">
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Добавить БЗ</button>
                </form>
            </div>
        </div>
        <hr class="mb-3">
        <div class="row">
            <div class="col-12">
                <form action="{{route('halls-edit')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group mb-4">
                            <label for="exampleFormControlSelect1">Выберите зал</label>
                            <select name="hall_id" class="form-control" id="exampleFormControlSelect1">
                                @foreach($halls as $hall)
                                    <option value="{{$hall->id}}">{{$hall->admin_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label for="exampleFormControlSelect1">Выберите администратора зала</label>
                            <select name="user_id" class="form-control" id="exampleFormControlSelect1">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Назначить администратора БЗ</button>
                </form>
            </div>
        </div>
        <hr class="mb-3">
        <div class="row">
            <div class="col-12">
                @foreach($halls as $hall)
                    <form action="{{route('add-service-to-halls')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{$hall->id}}">
                        <div class="row">
                            <div class="col-md-9">
                                <h2>{{$hall->admin_name}}</h2>
                                @foreach($services as $service)
                                    <label class="mb-4" for="hall_service">{{$service->name}}
                                        <input type="checkbox" value="{{$service->id}}" name="hall_service[]"
                                               @if (count($hall->services->where('id', $service->id)))
                                               checked
                                               @endif
                                               aria-describedby="hall_service">
                                    </label>
                                    @if(!$loop->last), &nbsp;@endif
                                @endforeach
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary mb-2">Обновить сервисы</button>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
