@section('content');
<input type="hidden" name="_token" value="{csrf_token()}"/>
<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" role="main">

            @if($errors->any())
                <ul class="list-group">
                    @foreach($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger">{{$error}}</li>
                    @endforeach
                </ul>
            @endif

            {!! Form::open(['url'=>'/user/subregister']) !!}
            {{--<div class="form-group">--}}
                {{--{!! Form::label('name', '用户名', ['class'=>'col-md-4 control-label']) !!}--}}
                {{--<div class="col-md-6">--}}
                    {{--{!! Form::text('name', null, ['class'=>'form-control']) !!}--}}
                {{--</div>--}}
            {{--</div>--}}

            <div class="form-group">
                {!! Form::label('email', '邮箱', ['class'=>'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::text('phone', null, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('password', '密码', ['class'=>'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::password('password', null, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', '确认密码', ['class'=>'col-md-4 control-label']) !!}
                <div class="col-md-6">
                    {!! Form::password('password_confirmation', null, ['class'=>'form-control']) !!}
                </div>
            </div>

            <div class="form-group pull-right">
                {!! Form::submit('注册', ['class'=>'btn btn-primary']) !!}
            </div>

            {!! Form::close() !!}



        </div>
    </div>



</div>

@stop