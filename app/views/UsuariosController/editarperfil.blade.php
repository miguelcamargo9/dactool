<div id="editarPerfil" style="{{$visibleEditar}}" class="box2">
    <div class='row form-group col-sm-12'>
        <div class='col-sm-1'></div>
        <div class='col-sm-10'>
            <h1>Editar Perfil</h1>
            {{
    Form::open(
        array(
            'action' => 'UsuariosController@EditarPerfil',
            'method' => 'post',
            'role'   => 'form',
            'class'  => 'form-horizontal',
            'id'     => 'formEditPerfil'
        )
    )
            }}
            <div class='form-group'>
                <div class="col-sm-1">{{ Form::label('Nick Name:') }}</div>
                <div class="col-sm-11">
                    {{ Form::input('text', 'nickname', Input::old('nickname'), array('class' => 'form-control', 'readonly' => 'true', 'id' => 'nickname')) }}
                </div>
            </div>
            <div class='form-group'>
                <div class="col-sm-1">{{ Form::label('Nombre:') }}</div>
                <div class="col-sm-11">
                    {{ Form::input('text', 'nombre', Input::old('nombre'), array('class' => 'form-control', 'readonly' => 'true' , 'id' => 'nombre')) }}
                </div>
            </div>
            <div class='form-group'>
                <div class="col-sm-1">{{ Form::label('Grupo:') }}</div>
                <div class="col-sm-11">
                    {{ Form::input('text', 'grupo', Input::old('grupo'), array('class' => 'form-control', 'readonly' => 'true', 'id' => 'grupo' )) }}
                </div>
                <div class="bg-danger" id="error_parametros">{{$errors->first('parametros')}}</div>
            </div>
            <div class='form-group'>
                <div class="col-sm-1">{{ Form::label('Perfil:') }}</div>
                <div class="col-sm-9">
                    {{ Form::Select('IdPerfil', $Perfiles, 1, array('class' => 'form-control', 'id' => 'perfil')) }}
                </div>
            </div>

            {{ Form::input('hidden', 'editado') }}
            {{ Form::input('hidden', 'idusuario', null, array('id' => 'idusuario')) }}
            {{ Form::input('submit', null, 'Editar', array('class' => 'btn btn-primary confirmEditar')) }}

            {{ Form::close() }}    
        </div>
    </div>
</div>


