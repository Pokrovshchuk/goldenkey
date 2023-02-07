@extends('admin.layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="cold-12 mb-4">
                <form enctype="multipart/form-data" class="row" action="{{route('add-service')}}" method="POST">
                    @csrf
                    <div class="col-md-6 form-group mb-4">
                        <div class="form-group">
                            <label for="name">Навзание сервиса</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="name"
                                   placeholder="Введити название услуги">
                        </div>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <div class="form-group">
                            <label for="icon">Иконка</label>
                            <input name="icon" type="file" class="form-control" id="icon" aria-describedby="icon">
                        </div>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <div class="form-group">
                            <label for="type">Тип услуги</label>
                            <select name="type" class="form-control" id="type">
                                <option value="main">Входит в стоимость</option>
                                <option value="add">Доп. услуга</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 form-group mb-4">
                        <div class="form-group">
                            <label for="text">Текст</label>
                            <textarea name="text" class="form-control" id="text"
                                      aria-describedby="text" placeholder="Введити описание" cols="30"
                                      rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <div class="form-group">
                            <label for="hall_id">БЗ</label>
                            @foreach($halls as $hall)
                                <div style="display: flex; align-items: center">
                                    <p style="padding: 0; margin: 0 10px 0 0;">{{$hall->admin_name}}</p>
                                    <input id="hall_id" type="checkbox" name="hall_id[]"
                                           value="{{$hall->id}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Добавить услугу</button>
                </form>
            </div>
            <div class="col-12">
                <h2>Основные услуги:</h2>
                <ul class="list-group">
                    @foreach($services as $service)
                        <form action="{{route('delete-service')}}" method="POST">
                            @csrf
                            <input type="hidden" name="service_id" value="{{$service->id}}">
                            <div class="row">
                                <div class="col-md-10">
                                    <li class="list-group-item">
                                        <h5>{{$service->name}}</h5>
                                        <p>{{$service->text}}</p>
                                    </li>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary mb-2">Удалить</button>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </ul>
            </div>
            <div class="col-12">
                <h2>Дополнительные услуги:</h2>
                <ul class="list-group">
                    @foreach($add_services as $service)
                        <li class="list-group-item">
                            <form action="{{route('delete-service')}}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{$service->id}}">

                                <div class="row">
                                    <div class="col-md-10">
                                        <h5>{{$service->name}}</h5>
                                        <p>{{$service->text}}</p>
                                        @if($service->content)
                                            @if($service->content->add_info_1)
                                                Кол-во человек: {{$service->content->add_info_1->name}}<br>
                                                @if($service->content->add_info_1->subtext)
                                                    За одного человека: {{$service->content->add_info_1->subtext}}<br>
                                                @endif
                                                Цена: {{$service->content->add_info_1->price}}<br>
                                                <hr>
                                            @endif
                                            @if($service->content->add_info_2)
                                                Кол-во человек: {{$service->content->add_info_2->name}}<br>
                                                @if($service->content->add_info_2->subtext)
                                                    За одного человека: {{$service->content->add_info_2->subtext}}<br>
                                                @endif
                                                Цена: {{$service->content->add_info_2->price}}<br>
                                                <hr>
                                            @endif
                                            @if($service->content->add_info_3)
                                                Кол-во человек: {{$service->content->add_info_3->name}}<br>
                                                @if($service->content->add_info_3->subtext)
                                                    За одного человека: {{$service->content->add_info_3->subtext}}<br>
                                                @endif
                                                Цена: {{$service->content->add_info_3->price}}<br>
                                                <hr>
                                            @endif
                                            @if($service->content->add_info_4)
                                                Кол-во человек: {{$service->content->add_info_4->name}}<br>
                                                @if($service->content->add_info_4->subtext)
                                                    За одного человека: {{$service->content->add_info_4->subtext}}<br>
                                                @endif
                                                Цена: {{$service->content->add_info_4->price}}<br>
                                                <hr>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary mb-2">Удалить</button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
            <hr class="mb-4 mt-4">
            <div class="col-12">
                <form enctype="multipart/form-data" class="row" action="{{route('add-content')}}" method="POST">
                    <div class="col-12 form-group mb-4">
                        <h2>
                            <label for="hall_id">Выберите сервис</label>
                        </h2>
                        <select name="add_service_id" class="form-control" id="add_service_id">
                            @foreach($add_services as $service)
                                <option value="{{$service->id}}">{{$service->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group mb-4">
                            <p>Первый</p>
                            <input id="for_1_name" name="add_info_1[name]" type="text" placeholder="Кол-во человек">
                            <input id="for_1_subtext" name="add_info_1[subtext]" type="text"
                                   placeholder="серый текст в скобках">
                            <input id="for_1_price" name="add_info_1[price]" type="text" placeholder="Цена">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <p>Второй</p>
                            <input id="for_2_name" name="add_info_2[name]" type="text" placeholder="Кол-во человек">
                            <input id="for_2_subtext" name="add_info_2[subtext]" type="text"
                                   placeholder="серый текст в скобках">
                            <input id="for_2_price" name="add_info_2[price]" type="text" placeholder="Цена">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <p>Третий</p>
                            <input id="for_3_name" name="add_info_3[name]" type="text" placeholder="Кол-во человек">
                            <input id="for_3_subtext" name="add_info_3[subtext]" type="text"
                                   placeholder="серый текст в скобках">
                            <input id="for_3_price" name="add_info_3[price]" type="text" placeholder="Цена">
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <p>Четвёртый</p>
                            <input id="for_3_name" name="add_info_4[name]" type="text" placeholder="Кол-во человек">
                            <input id="for_3_subtext" name="add_info_4[subtext]" type="text"
                                   placeholder="серый текст в скобках">
                            <input id="for_3_price" name="add_info_4[price]" type="text" placeholder="Цена">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Добавить услугу</button>
                </form>
            </div>
        </div>
    </div>
@endsection
