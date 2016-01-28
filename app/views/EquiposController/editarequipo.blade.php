<div id="editarEquipo" style="{{$visibleEditar}}" class="box2">
    <div class="container" style="margin-bottom: 2%">
        <?php if (Session::get('mensajeError')) { ?>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                <?php echo Session::get('mensajeError'); ?>
            </div>
            <?php
        }
        ?>
        <h1>Editar Equipo</h1>
        {{
    Form::open(
        array(
            'action' => 'EquiposController@EditarEquipo',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-horizontal',
            'id'     => 'formEditarEquipo'
        )
    )
        }}
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Nombre:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'nameEd', Input::old('nameEd'), array('class' => 'form-control', 'id' => 'nameEd' )) }}
            </div>
            <div class="bg-danger" id="error_name">{{$errors->first('name')}}</div>
        </div>
        <div class="form-group">
            <div class="col-sm-1">{{ Form::label('Ip:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'ipEd', Input::old('ipEd'), array('class' => 'form-control', 'id' => 'ipEd')) }}
            </div>
            <div class="bg-danger" id="error_ip">{{$errors->first('ip')}}</div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Numero Inventario:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'numinventEd', Input::old('numinventEd'), array('class' => 'form-control', 'id' => 'numinventEd')) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Ubicación:') }}</div>
            <div class="col-sm-11">
                {{ Form::Select('ubicacionEd', $paises, Input::old('ubicacionEd'), array('class' => 'form-control', 'id' => 'ubicacionEd')) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Fabricante:') }}</div>
            <div class="col-sm-11">
                {{ Form::Select('fabricanteEd', $fabricantes, Input::old('fabricanteEd'), array('class' => 'form-control', 'id' => 'fabricanteEd')) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Tipo:') }}</div>
            <div class="col-sm-11">
                {{ Form::Select('tipoEd', $tipos, Input::old('tipoEd'), array('class' => 'form-control', 'id' => 'tipoEd')) }}
            </div>
        </div>

        {{ Form::input('hidden', 'idEd', null, array('id' => 'idEd')) }}
        {{ Form::input('hidden', 'name_old', null, array('id' => 'name_old')) }}
        {{ Form::input('hidden', 'ip_old', null, array('id' => 'ip_old')) }}
        {{ Form::input('hidden', 'editado') }}
        {{ Form::input('submit', null, 'Editar', array('class' => 'btn btn-warning confirmEditar')) }}

        {{ Form::close() }}

    </div>
</div>

