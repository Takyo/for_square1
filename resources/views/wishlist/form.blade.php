<div class="form-group">
{!! Form::label('name', 'Name', ['class' => 'mb-2 mr-sm-2']) !!}
{!! Form::text('name', null , ['id' => 'inputName', 'class' => 'form-control mb-2 mr-sm-2'] ) !!}
</div>
{!! Form::submit('SAVE', ['class' => 'btn btn-primary mb-2 mr-sm-2']) !!}