<div>
    <div class="row">
        <div class="col-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Code"
                    aria-label="Code" aria-describedby="button-addon2">
                    <input type="text" class="form-control" placeholder="Name"
                        aria-label="Name" aria-describedby="button-addon2">
                <button class="btn btn-success" type="button" id="button-addon2">
                    <i class='bx bx-plus-medical'></i>
                </button>
            </div>
            <ul class="list-group">
                @foreach ($client as $item)
                    <li class="list-group-item d-flex flex-row justify-content-between">
                        <div>{{ strtoupper($item->code) }} - {{ $item->name }}</div>
                        <button type="button" class="btn btn-sm btn-danger">
                            <i class='bx bx-window-close'></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-6">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Code"
                    aria-label="Code" aria-describedby="button-addon2">
                    <input type="text" class="form-control" placeholder="Name"
                        aria-label="name" aria-describedby="button-addon2">
                <button class="btn btn-success" type="button" id="button-addon2">
                    <i class='bx bx-plus-medical'></i>
                </button>
            </div>
            <ul class="list-group">
                @foreach ($matter as $item)
                <li class="list-group-item d-flex flex-row justify-content-between">
                    <div>{{ strtoupper($item->code) }} - {{ $item->name }}</div>
                    <button type="button" class="btn btn-sm btn-danger">
                        <i class='bx bx-window-close'></i>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-4"></div>
    </div>
</div>
