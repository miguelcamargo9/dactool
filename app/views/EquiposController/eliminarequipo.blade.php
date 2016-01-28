<div id="eliminarEquipo" style="{{$visibleEliminar}}" class="box2">
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
        <h1>Eliminar Equipo</h1>
        {{
    Form::open(
        array(
            'action' => 'EquiposController@EliminarEquipo',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-horizontal',
            'id'     => 'formEliminarEquipo'
        )
    )
        }}
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Nombre:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'nameEl', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'nameEl' )) }}
            </div>
            <div class="bg-danger" id="error_name">{{$errors->first('name')}}</div>
        </div>
        <div class="form-group">
            <div class="col-sm-1">{{ Form::label('Ip:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'ipEl', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'ipEl' )) }}
            </div>
            <div class="bg-danger" id="error_ip">{{$errors->first('ip')}}</div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Numero Inventario:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'numinventEl', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'numinventEl' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Ubicación:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'ubicacionEl', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'ubicacionEl' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Fabricante:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'fabricanteEl', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'fabricanteEl' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Tipo:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'tipoEl', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'tipoEl' )) }}
            </div>
        </div>
        {{ Form::input('hidden', 'idEl', null, array('id' => 'idEl' )) }}
        {{ Form::input('hidden', 'eliminado') }}
        {{ Form::input('submit', null, 'Eliminar', array('class' => 'btn btn-danger confirmEliminar')) }}

        {{ Form::close() }}

    </div>
</div>


