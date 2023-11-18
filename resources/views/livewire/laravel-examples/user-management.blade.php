<style>
    html{
        overflow-x: hidden !important;
    }

    tr{
        border: aliceblue;
    }

    .ps__rail-x{
        display: none !important;
    }
</style>

<div class="main-content">
    <div class="row">
        <div>

            @if (session()->has('message'))
    
                <div class="alert alert-info">
    
                    {{ session('message') }}
    
                </div>
    
            @endif
    
        </div>
        <div class="col-12">
            <div class="card mb-4 mx-4" style="padding: 1.5rem">
                <div class="card-title" style="font-size: 1.5rem;font-weight: bold;margin-bottom: 1.5rem">
                    <div class="row">                       
                        <div class="col-8">
                            {{$label}}
                        </div>
                        <div class="col-4 text-end">
                            <button class="btn btn-info" id="add-register">{{__('Add new')}}</button>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="myTable">
                            <thead>
                                <tr>
                                    @foreach ($atributes as $field)
                                        @if($field != 'updated_at')
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                {{__($field)}}
                                            </th>
                                        @endif
                                    @endforeach
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{__('actions')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key)
                                    <tr>
                                        @foreach ($atributes as $field)
                                            @if($field != 'updated_at')
                                                @if(str_contains($field, '_id'))
                                                    @foreach ($extra_data[$field]['values'] as $value)
                                                        @foreach ($extra_data[$field]['fields'] as $field2)
                                                            @if($field2 != 'created_at' && $field2 != 'updated_at' && $field2 != 'id')
                                                                @if($value->id == $key->$field)
                                                                    <td class="ps-4">
                                                                        <p class="text-xs font-weight-bold mb-0">{{$value->$field2}}</p>
                                                                    </td> 
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    <td class="ps-4">
                                                        <p class="text-xs font-weight-bold mb-0">{{$key->$field}}</p>
                                                    </td> 
                                                @endif
                                            @endif
                                        @endforeach
                                        <td class="text-start">
                                            <a onclick="editUser([
                                                <?php
                                                    $count = 0;
                                                    echo "'";
                                                    foreach($atributes as $field){
                                                        if($field != 'created_at' && $field != 'updated_at'){
                                                            if($count == 0){
                                                                echo "$field";
                                                            }else{
                                                                echo "|$field";
                                                            }
                                                            $count++;
                                                        }
                                                    }
                                                    echo "'";
                                                    foreach($atributes as $field){
                                                        if($field != 'created_at' && $field != 'updated_at'){
                                                            echo ",'".$key->$field."'";
                                                        }
                                                    }
                                                ?>])" class="mx-3" data-bs-toggle="tooltip"
                                                data-bs-original-title="Edit user" style="cursor: pointer">
                                                <i class="fas fa-user-edit text-secondary"></i>
                                            </a>
                                                <a onclick="deleteUser({{$key->id}})" class="mx-3" data-bs-toggle="tooltip"
                                                    data-bs-original-title="Edit user">
                                                    <i class="cursor-pointer fas fa-trash text-secondary"></i>
                                                </a>
                                        </td>
                                        <form action="{{route('delete-register')}}" id="form-delete-{{$key->id}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$key->id}}">
                                            <input type="hidden" name="label" value="{{$label}}">
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('Add new')}}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('table-store')}}" method="POST" autocomplete="off">
            @csrf
        <div class="modal-body">
            <div class="card" style="width: 50%;left: 25%;">
                <div class="card-body">
                    @foreach ($atributes as $field)
                        @if($field != 'created_at' && $field != 'updated_at' && $field != 'id')
                            @if(str_contains($field, '_id'))
                                <label for="">{{__($field)}}</label>
                                <select class="form-select" name="{{$field}}">
                                    @foreach ($extra_data[$field]['values'] as $value)
                                        @foreach ($extra_data[$field]['fields'] as $field2)
                                            @if($field2 != 'created_at' && $field2 != 'updated_at' && $field2 != 'id')
                                                <option value="{{$value->id}}">{{$value->$field2}}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            @else
                                <label for="">{{__($field)}}</label>
                                <input type="text" name="{{$field}}" required class="form-control" placeholder="{{__('enter a')}} {{__($field)}}">
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
          <button type="submit" class="btn btn-info">{{__('Save changes')}}</button>
        </div>
        <input type="hidden" name="label" value="{{$label}}">
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">{{__('Edit')}}</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('table-update')}}" method="POST"  autocomplete="off">
            @csrf
        <div class="modal-body">
            <div class="card" style="width: 50%;left: 25%;">
                <div class="card-body" id="card-edit">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            <button type="submit" class="btn btn-info">{{__('Save changes')}}</button>
        </div>
        <input type="hidden" name="label" value="{{$label}}">
        <input type="hidden" name="id" id="id-edit">
        </form>
      </div>
    </div>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('#myTable').DataTable({
        "oLanguage": {
                    "sSearch": "{{__('Search')}}",
        },"language": {
            "zeroRecords": "{{__('No matching records found')}}",
            "infoEmpty": "{{__('No records available')}}",
            "paginate": {
                "previous": "{{__('Previous')}}",
                "next": "{{__('Next')}}"
            },
            "lengthMenu": "{{__('Showing')}} _MENU_ {{__('entries')}}",
            "infoFiltered":   "({{__('filtered from')}} _TOTAL_ {{__('total entries')}})",
            "info": "{{__('Showing')}} _START_ {{__('to')}} _END_ {{__('of')}} _TOTAL_ {{__('entries')}}",
        },
    });

    $("#add-register").click(() => {
        $("#sidenav-collapse-main").addClass('o-hidden');
        $("#exampleModal").modal('show');
    });

    $("#exampleModal").on("hidden.bs.modal", function () {
        $("#sidenav-collapse-main").removeClass('o-hidden');
    });

    $("#exampleModal2").on("hidden.bs.modal", function () {
        $("#sidenav-collapse-main").removeClass('o-hidden');
    });

    function deleteUser(id){
        $("#sidenav-collapse-main").addClass('o-hidden');
        Swal.fire({
            title: "¿Seguro que quieres eliminar este registro?",
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: `Cancelar`
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $("#form-delete-"+id).submit();
            }else{
                $("#sidenav-collapse-main").removeClass('o-hidden');
            }
        });
    }

    function editUser(array){
        console.log(array);
        let fields = array[0].split("|");
        array.shift();
        let id = array[0];
        $("#id-edit").val(id);
        array.shift();
        var plantilla = "";
        var count = 0;
        console.log(fields);
        fields.forEach((key, index) => {
            if(index != 0 && key != 'id'){
                if(key.includes('_id')){
                    plantilla += `<label for="">{{__('${key}')}}</label>
                    <select class="form-select" name="${key}">
                        <option value="1">Venezuela</option>
                        <option value="2">Colombia</option>
                        <option value="3">Brasil</option>
                        <option value="4">Peru</option>
                    </select>`;
                }else{
                    plantilla += `<label for="">{{__('${key}')}}</label>
                        <input type="text" name="{{__('${key}')}}" required class="form-control" placeholder="{{__('enter a')}} {{__('${key}')}}" value="${array[count]}">`;
                }
                count++;
            }
        });
        $("#card-edit").html(plantilla);
        $("#card-edit").show();

        $("#sidenav-collapse-main").addClass('o-hidden');
        $("#exampleModal2").modal("show");
    }
</script>