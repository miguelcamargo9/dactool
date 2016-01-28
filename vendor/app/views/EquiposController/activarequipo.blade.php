<div id="activarEquipo" style="display:none;" class="box2">
    <div class="container" style="margin-bottom: 2%">
        <h1>Activar Equipo</h1>
        {{
    Form::open(
        array(
            'action' => 'EquiposController@ActivarEquipo',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-horizontal',
            'id'     => 'formActivarEquipo'
        )
    )
        }}
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Nombre:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'nameAc', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'nameAc' )) }}
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-1">{{ Form::label('Ip:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'ipAc', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'ipAc' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Numero Inventario:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'numinventAc', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'numinventAc' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Ubicación:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'ubicacionAc', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'ubicacionAc' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Fabricante:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'fabricanteAc', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'fabricanteAc' )) }}
            </div>
        </div>
        <div class='form-group'>
            <div class="col-sm-1">{{ Form::label('Tipo:') }}</div>
            <div class="col-sm-11">
                {{ Form::input('text', 'tipoAc', null, array('class' => 'form-control', 'readonly' => 'true', 'id' => 'tipoAc' )) }}
            </div>
        </div>
        {{ Form::input('hidden', 'idAc', null, array('id' => 'idAc' )) }}

        {{ Form::input('hidden', 'activar') }}
        {{ Form::input('submit', null, 'Activar', array('class' => 'btn btn-success confirm')) }}

        {{ Form::input('hidden', 'queryAc', null, array('id' => 'queryAc')) }}

        {{ Form::close() }}      
    </div>
</div>