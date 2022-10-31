<div class="form-group {{ $errors->has('data') ? 'has-error' : ''}}">
    <label for="data" class="control-label">{{ 'Data' }}</label>
    <textarea class="form-control" rows="5" name="data" type="textarea" id="data" >{{ isset($evaluation->data) ? $evaluation->data : ''}}</textarea>
    {!! $errors->first('data', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($evaluation->description) ? $evaluation->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('solution_id') ? 'has-error' : ''}}">
    <label for="solution_id" class="control-label">{{ 'Solution Id' }}</label>
    <input class="form-control" name="solution_id" type="number" id="solution_id" value="{{ isset($evaluation->solution_id) ? $evaluation->solution_id : ''}}" required>
    {!! $errors->first('solution_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
    <label for="user_id" class="control-label">{{ 'User Id' }}</label>
    <input class="form-control" name="user_id" type="number" id="user_id" value="{{ isset($evaluation->user_id) ? $evaluation->user_id : ''}}" required>
    {!! $errors->first('user_id', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
