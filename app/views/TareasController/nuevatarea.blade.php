<div id="nuevaTarea" style="{{$visibleNuevo}}" class="box2">
    <div class="container" style="margin-bottom: 2%">
        <h1>Crear Tarea</h1>
        {{
    Form::open(
        array(
            'action' => 'TareasController@NuevaTarea',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-horizontal',
            'id'     => 'formNuevaTarea'
        )
    )
        }}
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Ruta Script:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'ruta', Input::old('ruta'), array('class' => 'form-control', 'placeholder' => 'Ingrese la Ruta del Script' )) }}
            </div>
            <div class="bg-danger" id="error_ruta">{{$errors->first('ruta')}}</div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Nombre:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'nombre', Input::old('nombre'), array('class' => 'form-control', 'placeholder' => 'Nombre de la Tarea' )) }}
            </div>
            <div class="bg-danger" id="error_nombre">{{$errors->first('nombre')}}</div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Parametros:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'parametros', Input::old('parametros'), array('class' => 'form-control', 'placeholder' => 'Parametros separados por espacio' )) }}
            </div>
            <div class="bg-danger" id="error_parametros">{{$errors->first('parametros')}}</div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Minutos:') }}</div>
            <div class="col-sm-9">
                {{ Form::input('number', 'minutos', Input::old('minutos'), array('class' => 'form-control', 'min' => 0, 'max' => 59, 'placeholder' => 'Minutos de 0-59' )) }}
            </div>
            <div class="col-sm-2">
                {{ Form::input('checkbox', 'cadaminuto', true, array('class' => 'checkbox-inline')) }} Frecuencia
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Horas:') }}</div>
            <div class="col-sm-9">
                {{ Form::input('number', 'horas', Input::old('horas'), array('class' => 'form-control', 'min' => 0, 'max' => 23, 'placeholder' => 'Horas de 0-23' )) }}
            </div>
            <div class="col-sm-2">
                {{ Form::input('checkbox', 'cadahora', true, array('class' => 'checkbox-inline')) }} Frecuencia
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Dia del Mes:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('number', 'diames', Input::old('diames'), array('class' => 'form-control', 'min' => 1, 'max' => 31, 'placeholder' => 'Dia de 1-31' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Mes:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('number', 'mes', Input::old('mes'), array('class' => 'form-control', 'min' => 1, 'max' => 12, 'placeholder' => 'Mes de 1-12' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Días de la Semana:') }}</div>
            <div class="col-sm-1">
                Lunes{{ Form::input('checkbox', 'dias[1]', null, array('class' => 'checkbox')) }}
            </div>
            <div class="col-sm-1">
                Martes{{ Form::input('checkbox', 'dias[2]', null, array('class' => 'checkbox')) }}
            </div>
            <div class="col-sm-1">
                Miercoles{{ Form::input('checkbox', 'dias[3]', null, array('class' => 'checkbox')) }}
            </div>
            <div class="col-sm-1">
                Jueves{{ Form::input('checkbox', 'dias[4]', null, array('class' => 'checkbox')) }}
            </div>
            <div class="col-sm-1">
                Viernes{{ Form::input('checkbox', 'dias[5]', null, array('class' => 'checkbox')) }}
            </div>
            <div class="col-sm-1">
                Sabado{{ Form::input('checkbox', 'dias[6]', null, array('class' => 'checkbox')) }}
            </div>
            <div class="col-sm-1">
                Domingo{{ Form::input('checkbox', 'dias[7]', null, array('class' => 'checkbox')) }}
            </div>
        </div>
        {{ Form::input('hidden', 'enviado') }}
        {{ Form::input('hidden', 'username', Session::get('NickNameUsuario')) }}
        {{ Form::input('submit', null, 'Enviar', array('class' => 'btn btn-primary')) }}


        {{ Form::close() }}
    </div>
</div>


