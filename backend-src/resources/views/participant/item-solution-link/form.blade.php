<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
    <label for="title" class="control-label">{{ 'Title' }}</label>
    <input class="form-control" name="title" type="text" id="title" value="{{ isset($itemsolutionlink->title) ? $itemsolutionlink->title : ''}}" >
    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description" class="control-label">{{ 'Description' }}</label>
    <textarea class="form-control" rows="5" name="description" type="textarea" id="description" >{{ isset($itemsolutionlink->description) ? $itemsolutionlink->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    <label for="url" class="control-label">{{ 'Url' }}</label>
    <input class="form-control" name="url" type="text" id="url" value="{{ isset($itemsolutionlink->url) ? $itemsolutionlink->url : ''}}" required>
    {!! $errors->first('url', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('item_solution_id') ? 'has-error' : ''}}">
    <label for="item_solution_id" class="control-label">{{ 'Item Solution Id' }}</label>
    <input class="form-control" name="item_solution_id" type="number" id="item_solution_id" value="{{ isset($itemsolutionlink->item_solution_id) ? $itemsolutionlink->item_solution_id : ''}}" required>
    {!! $errors->first('item_solution_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
    <label for="type" class="control-label">{{ 'Type' }}</label>
    <select name="type" class="form-control" id="type" >
    @foreach (json_decode('{"image":"Image","document":"Document","video":"Video","external":"External page","other":"Other"}', true) as $optionKey => $optionValue)
        <option value="{{ $optionKey }}" {{ (isset($itemsolutionlink->type) && $itemsolutionlink->type == $optionKey) ? 'selected' : ''}}>{{ $optionValue }}</option>
    @endforeach
</select>
    {!! $errors->first('type', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
