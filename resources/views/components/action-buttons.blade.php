<div class="btn-group">
    @if(isset($showAdmin))
    <a href="{{ route($route . '.showAdmin', $id) }}" class="btn btn-secondary btn-xs mx-1">
        <i class="fa fa-user"></i>
    </a>
    @endif
    @if(isset($showDetail))
    <a href="{{ route($route . '.show', $id) }}" class="btn btn-info btn-xs">
        <i class="fa fa-info-circle"></i>
    </a>
    @endif
    <a href="#" class="btn btn-primary btn-xs edit-button mx-1" data-toggle="modal"
        data-target="#editModal{{$id}}" data-id="{{$id}}">
        <i class="fa fa-edit"></i>
    </a>
    <a href="{{ route($route . '.destroy', $id) }}"
        onclick="notificationBeforeDelete(event, this, {{$key+1}})" class="btn btn-danger btn-xs">
        <i class="fa fa-trash"></i>
    </a>
</div>

