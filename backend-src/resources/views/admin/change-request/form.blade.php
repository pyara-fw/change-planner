<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($changerequest->title) ? $changerequest->title : ''}}" required>
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($changerequest->description) ? $changerequest->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('project_id') ? 'has-error' : ''}}">
    <label for="project_id" class="control-label">{{ 'Project Id' }}</label>
    <input class="form-control" name="project_id" type="number" id="project_id" value="{{ isset($changerequest->project_id) ? $changerequest->project_id : ''}}" required>
    {!! $errors->first('project_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('reporter_user_id') ? 'has-error' : ''}}">
    <label for="reporter_user_id" class="control-label">{{ 'Reporter User Id' }}</label>
    <input class="form-control" name="reporter_user_id" type="number" id="reporter_user_id" value="{{ isset($changerequest->reporter_user_id) ? $changerequest->reporter_user_id : ''}}" >
    {!! $errors->first('reporter_user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('assigned_user_id') ? 'has-error' : ''}}">
    <label for="assigned_user_id" class="control-label">{{ 'Assigned User Id' }}</label>
    <input class="form-control" name="assigned_user_id" type="number" id="assigned_user_id" value="{{ isset($changerequest->assigned_user_id) ? $changerequest->assigned_user_id : ''}}" >
    {!! $errors->first('assigned_user_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <label for="status" class="control-label">{{ 'Status' }}</label>
    <select name="status" class="form-control" id="status" required>
    @foreach (json_decode('{"1":"Pending","2":"Executing","3":"Planned","4":"Cancelled"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($changerequest->status) && $changerequest->status == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
