@extends('template.master')
@section('title', 'Room')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="row mt-2 mb-2">
                <div class="col-lg-6 mb-2">
                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ route('room.create') }}" class="btn btn-sm shadow-sm myBtn border rounded">
                            <svg width="25" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="black">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <form class="d-flex" method="GET" action="{{ route('room.search') }}">
                        @csrf
                        <input class="form-control me-2" room="search" placeholder="Search" aria-label="Search" id="search"
                            name="search" value="">
                        <button class="btn btn-outline-dark" room="submit">Search</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Number</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Capacity</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">View</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rooms as $room)
                                            <tr>
                                                <td scope="row">
                                                    {{ ($rooms->currentpage() - 1) * $rooms->perpage() + $loop->index + 1 }}
                                                </td>
                                                <td>{{ $room->number }}</td>
                                                <td>{{ $room->type->name }}</td>
                                                <td>{{ $room->capacity }}</td>
                                                <td>{{ $room->price }}</td>
                                                <td><span style="
                                                                display:inline-block;
                                                                /* white-space: nowrap; */
                                                                overflow: hidden;
                                                                text-overflow: ellipsis;
                                                                max-width: 1000px;">{{ $room->view }}</span></td>
                                                <td>{{ $room->roomStatus->name }}</td>
                                                <td>
                                                    <a class="btn btn-light btn-sm rounded shadow-sm border"
                                                        href="{{ route('room.edit', ['room' => $room->id]) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form class="btn btn-sm" method="POST"
                                                        id="delete-room-form-{{ $room->id }}"
                                                        action="{{ route('room.destroy', ['room' => $room->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a class="btn btn-light btn-sm rounded shadow-sm border delete"
                                                            href="#" room-id="{{ $room->id }}" room-role="room"
                                                            room-name="{{ $room->name }}" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Delete room">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </form>
                                                    <a class="btn btn-light btn-sm rounded shadow-sm border"
                                                        href="{{ route('room.show', ['room' => $room->id]) }}">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h3>Room</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center mt-3">
                <div class="col-sm-10 d-flex justify-content-md-center">
                    {{ $rooms->onEachSide(2)->links('template.paginationlinks') }}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('footer')
    <script>
        $('.delete').click(function() {
            var room_id = $(this).attr('room-id');
            var room_name = $(this).attr('room-name');
            var room_url = $(this).attr('room-url');
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "Room number " + room_name + " will be deleted, You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel! ',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    id = "#delete-room-form-" + room_id
                    console.log(id)
                    $(id).submit();
                }
            })
        });

    </script>
@endsection
