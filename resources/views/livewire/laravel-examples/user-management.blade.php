@section('css')
<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

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
                                                                @if($value->id == $key->$field && !str_contains($field2, '_id'))
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
                                            <a onclick="editUser(
                                                <?php
                                                    $arrayExtraFields = [];
                                                    $count = 0;
                                                    echo "['";
                                                    foreach($atributes as $field){
                                                        if($field != 'created_at' && $field != 'updated_at'){
                                                            if($count == 0){
                                                                echo "$field";
                                                            }else{
                                                                echo "|$field";
                                                            }
                                                            $count++;
                                                        }

                                                        if(str_contains($field, '_id')){
                                                            array_push($arrayExtraFields, $field);
                                                        }
                                                    }
                                                    echo "'";
                                                    foreach($atributes as $field){
                                                        if($field != 'created_at' && $field != 'updated_at'){
                                                            echo ",'".$key->$field."'";
                                                        }
                                                    }

                                                    if(isset($key->aditionalPictures)){
                                                        echo ",'images:";
                                                        foreach($key->aditionalPictures as $index => $image){
                                                            if($index == 0){
                                                                echo "$image->image";
                                                            }else{
                                                                echo "|$image->image";
                                                            }
                                                        }
                                                        echo "'";
                                                    }
                                                    echo "]";
                                                    ?>)" class="mx-3" data-bs-toggle="tooltip"
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
        <div class="modal-body">
            <div class="card" style="width: 72%;left: 16%;">
                <div class="card-body">
                    <form action="{{route('table-store')}}" method="POST" autocomplete="off" id="form">
                    @csrf
                    @foreach ($atributes as $field)
                        @if($field != 'created_at' && $field != 'updated_at' && $field != 'id')
                            @if(str_contains($field, '_id'))
                                <label for="">{{__($field)}}</label>
                                <select class="form-select" name="{{$field}}">
                                    @foreach ($extra_data[$field]['values'] as $value)
                                        @foreach ($extra_data[$field]['fields'] as $field2)
                                            @if($field2 != 'created_at' && $field2 != 'updated_at' && $field2 != 'id' && !str_contains($field2, '_id'))
                                                <option value="{{$value->id}}">{{$value->$field2}}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            @elseif($field == 'image')
                                <?php $image = true; ?>
                            @elseif($field == 'count')
                                <label class="d-none">{{__($field)}}</label>
                                <input type="number" name="{{$field}}" required class="form-control d-none" value="0">
                            @else
                                <label for="">{{__($field)}}</label>
                                <input type="text" name="{{$field}}" required class="form-control" placeholder="{{__('enter a')}} {{__($field)}}">
                            @endif
                        @endif
                    @endforeach
                    <input type="hidden" name="label" value="{{$label}}">
                    @isset($image)
                    <label style="margin-top: 1rem;">{{__('images')}}</label>
                    <div class="dropzone" id="myDropzone">
                    </div>
                    @endisset
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
          <button 
          @if(isset($image))
            type="button" id="store"
          @else
            type="submit"
          @endif
           class="btn btn-info">{{__('Save changes')}}</button>
        </div>
        </form>
        <input type="hidden" id="id_table">
        <input type="hidden" id="table">
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
            <div class="card" style="width: 74%;left: 16%;">
                <div class="card-body">
                    @foreach ($atributes as $field)
                        @if($field != 'created_at' && $field != 'updated_at' && $field != 'id')
                            @if(str_contains($field, '_id'))
                                <label for="">{{__($field)}}</label>
                                <select class="form-select" name="{{$field}}" id="{{$field}}">
                                    @foreach ($extra_data[$field]['values'] as $value)
                                        @foreach ($extra_data[$field]['fields'] as $field2)
                                            @if($field2 != 'created_at' && $field2 != 'updated_at' && $field2 != 'id' && !str_contains($field2, '_id'))
                                                <option value="{{$value->id}}">{{$value->$field2}}</option>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </select>
                            @elseif($field == 'image')
                                <?php $image = true; ?>
                            @else
                                <label for="">{{__($field)}}</label>
                                <input type="text" name="{{$field}}" id="{{$field}}" required class="form-control" placeholder="{{__('enter a')}} {{__($field)}}">
                            @endif
                        @endif
                    @endforeach
                    @isset($image)
                    <label style="margin-top: 1rem;">{{__('images')}}</label>
                    <div class="row" id="row-img-update">
                    </div>
                    <div class="dropzone" id="myDropzone2" style="margin-top: 1rem;">
                    </div>
                    @endisset
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('Close')}}</button>
            <button type="submit" class="btn btn-info">{{__('Save changes')}}</button>
        </div>
        <input type="hidden" name="label" value="{{$label}}">
        <input type="hidden" name="id" id="id">
        </form>
      </div>
    </div>
  </div>




@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
            fields = array[0].split("|");
            array.shift();
            if(array.at(-1).includes('images:')){
                var arrayImagenes = [];
            }
            fields.forEach((key, index) => {
                if(key.includes('image')){
                    arrayImagenes.push(array[index]);
                }else{
                    $(`#${key}`).val(array[index]);
                }
            });

            if(array.at(-1).includes('images:')){
                var arrayImagenes = arrayImagenes.concat(array.at(-1).replaceAll('images:','').split('|'));
                var plantilla = '';
                arrayImagenes.forEach((key) => {
                    if(key != ''){
                        key = key.replaceAll('/storage','storage');
                        plantilla += `<div class="col-12 col-md-4" style="position: relative;margin-top: 1rem;">
                                <img src="{{asset('${key}')}}" style="width: 9.5rem;height: 6.5rem;" alt="">
                                <a href="#"><img src="{{asset('/storage/x.png')}}" alt="" style="position: absolute;width: 1rem;left: 9.25rem;"></a>
                            </div>`;
                    }
                });
                $("#row-img-update").html(plantilla);
                $("#row-img-update").show();
            }
            
            $("#sidenav-collapse-main").addClass('o-hidden');
            $("#exampleModal2").modal("show");
        }
    </script>

    @isset($image)
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js" integrity="sha512-U2WE1ktpMTuRBPoCFDzomoIorbOyUv0sP8B+INA3EzNAhehbzED1rOJg6bCqPf/Tuposxb5ja/MAUnC8THSbLQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        Dropzone.autoDiscover = false;

        let myDropzone = new Dropzone("#myDropzone", { 
            url: "{{route('imgs-store')}}",
            headers: {
                'X-CSRF-TOKEN' : "{{csrf_token()}}",
            },
            dictDefaultMessage: "Arrastre o haga click para agregar imágenes",
            acceptedFiles: 'image/*',
            maxFilesize : 5,
            maxFiles: 5,
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            init: function(){
                this.on("sending", function(file, xhr, formData){
                    formData.append("id", `${$("#id_table").val()}`);
                    formData.append("table", `${$("#table").val()}`);
                });

                this.on("success", function(file, response) {
                    if(file.status != 'success'){
                        return false;
                    }
                    if(this.getUploadingFiles().length === 0){
                        hideAlertTime();
                    }
                });
            }
        });

        let myDropzone2 = new Dropzone("#myDropzone2", { 
            url: "{{route('imgs-update')}}",
            headers: {
                'X-CSRF-TOKEN' : "{{csrf_token()}}",
            },
            dictDefaultMessage: "Arrastre o haga click para agregar imágenes",
            acceptedFiles: 'image/*',
            maxFilesize : 5,
            maxFiles: 5,
            autoProcessQueue: false,
            addRemoveLinks: true,
            parallelUploads: 5,
            init: function(){
                this.on("sending", function(file, xhr, formData){
                    formData.append("id", `${$("#id_table").val()}`);
                    formData.append("table", `${$("#table").val()}`);
                });

                this.on("success", function(file, response) {
                    if(file.status != 'success'){
                        return false;
                    }
                    if(this.getUploadingFiles().length === 0){
                        hideAlertTime();
                    }
                });
            }
        });

        $("#store").click((e) => {
            showAlertTime();
            storeData();
        });

        function showAlertTime(){
            Swal.fire({
                toast: true,
                position: 'center',
                title: "Cargando por favor espere...",
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        }

        function hideAlertTime(){
            setTimeout(() => {
                window.location.reload();
            }, 3000);

            Swal.fire({
                toast: true,
                position: 'center',
                icon: 'success',
                showConfirmButton: false,
                title: "Registro agregado exitosamente",
                timer: 3000
            });
        }

        function storeData(){
            $.ajax({
                url: "{{route('table-store-imgs')}}",
                data: $("#form").serialize(),
                method: "POST",
                success(response){
                    var res = JSON.parse(response);
                    $("#id_table").val(res.split('-')[1]);
                    $("#table").val(res.split('-')[0]);
                    myDropzone.processQueue();
                },error(err){
                    Swal.fire({
                        toast: true,
                        position: 'center',
                        icon: 'error',
                        showConfirmButton: false,
                        title: "Ups ha ocurrido un error",
                        timer: 3000
                    });
                    return false;
                }
            });
        }
    </script>
    @endisset
@endsection