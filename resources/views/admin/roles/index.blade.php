@extends('admin.layouts.main')
@section('content')
    {{--============================================--}}


    <div class="container">
        <div class="row">
            <div class="cold-12 mb-4">
                <form action="{{route('add-role')}}" method="POST">
                    @csrf
                    <div class="form-group mb-4">
                        <div class="form-group">
                            <label for="name">Навзание роли пользователя</label>
                            <input name="name" type="text" class="form-control" id="name" aria-describedby="name" placeholder="Введити название роли">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Добавить роль</button>
                </form>
            </div>
            <div class="col-12">
                <h2>Список возможный ролей</h2>
                <ul class="list-group">
                    @foreach($roles as $role)
                        <li class="list-group-item">{{$role->name}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
