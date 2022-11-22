@extends('template.master')
@section('title', 'Pengaturan user')
@section('content')
<div class="col-md-12">
  &nbsp;
</div>
<div class="box p-2">
  <div class="container">
    <button onclick="setForm();" id="btn-tambah-user" type="button" class="btn btn-info m-1" data-toggle="modal" data-target="#modal-default">
      Tambah User
    </button>
    &nbsp;&nbsp;&nbsp;
    <a href="{{ route('user_admin') }}" class="btn btn-danger m-1">Refresh</a>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Photo</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      @foreach($user as $k => $data)
        <tr>
          <td>{{$k + (isset($_GET['page'])?(($_GET['page']-1)*10)+1:1)}}</td>
          <td>{{$data->name}}</td>
          <td>{{$data->email}}</td>
          <td>
            <?php 
                $path = public_path().'/images/user/'.$data->photo;
                if (file_exists($path) && !empty($data->photo)){
            ?>
                <img src="{{ asset('images/user').'/'.$data->photo }}" width="200px" height="200px" class="" alt="{{$data->photo}}">
            <?php
                }else{
                  echo 'not set';
                }
            ?>

          </td>
          <td>
            <a href="/user/{{$data->id}}" class="btn btn-info">Info</a>
            <a href="#" onclick="setForm({{$data->id}});$('#modal-default').modal('open')" data-toggle="modal" data-target="#modal-default" class="btn btn-warning">Edit</a>
            <button type="button" class="btn btn-danger" onclick="hapusUser({{$data->id}});">Delete</button>
          </td>
        </tr>

      @endforeach
      </tbody>
    </table>
    <p>&nbsp;&nbsp;&nbsp;</p>
    <div class="card mt-3 pb-0" style="height:38px;">
      <div class="row justify-content-between">
          <div class="col-sm-4 ">              
              {{ $user->links() }}
          </div>
                    
      </div>
  </div>
  </div>
</div>
@endsection
@extends('modal')

@push('scripts')
<script type="text/javascript">

  function setForm(id = null){
    $("#btn-save-modal").removeAttr("onclick","");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ route('user_form') }}",
        type: "GET",
        data:{
          id:id
        },
        success:function(response){
            $("#modal-default").find(".modal-body").html(response);

            $("#btn-save-modal").attr("onclick","submitForm();");
        },
        error:function(response){            
            console.log(response);
        }
    });
  }

  function submitForm(){

    var cek = 0; 
    $("#form-user").find('input.required').each(function(){
        $(this).removeAttr('style');
        $(this).parents(".form-group").find(".error-message").html('');
        if ($(this).val() == ''){
            cek++;
            $(this).attr('style','border:red 1px solid;');
            $(this).parents(".form-group").find(".error-message").html($(this).attr("id")+' wajib diisi');
        }
    });
  
    if (cek > 0){
        return false;
    }

    var formData = new FormData($('#form-user')[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "{{ route('postUser') }}",
        data: formData,           
        dataType: 'json',        
        contentType: false,
        processData: false,
        success: function (data) {
              if (data.success != true){
                if (data.attr == 'email'){
                  $("#email").parents(".form-group").find(".error-message").html(data.message);
                }
              }else{
                alert("Data berhasil disimpan");
                location.href = '{{ route("user_admin") }}'
              }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
  }

  function hapusUser(id){
    const r = confirm("Apakah Anda yakin ingin menghapus user ini ?");
    if (r == true){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
          type: 'DELETE',
          url: "/user/"+id,
          data: {
            id
          },           
          dataType: 'json',              
          success: function (data) {
              if (data.success != true){
                alert("Data gagal dihapus")
              }else{
                alert("Data berhasil dihapus");
                location.href = '{{ route("user_admin") }}'
              }
          },
          error: function (jqXHR, textStatus, errorThrown) {
          }
      });
    }
  }

  $(document).ready(function(){
    
  });
  
</script>
@endpush


