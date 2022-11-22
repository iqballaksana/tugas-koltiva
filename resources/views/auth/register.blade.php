@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                            <span class="login-message error-message">
                                
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('daftarBaru') }}" id="form-register">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class=" form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autocomplete="name" autofocus>
                                <span class="error-message">
                                    
                                </span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="required form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <span class="error-message">
                                    
                                </span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="required form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                <span class="error-message">
                                    
                                </span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                            <div class="col-md-6">
                                <input  type="file" class="form-control" name="photo" accept="image/png, image/gif, image/jpeg">
                                <span class="error-message">
                                    
                                </span>
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">

                                <button id="btn-register" type="button" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">

function submit_data(){
    var cek = 0; 
    $("#form-register").find('input.required').each(function(){
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var formData = new FormData($('#form-register')[0]);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: "{{ route('daftarBaru') }}",
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
                location.href = '{{ route("login") }}'
              }
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });

}

$(document).ready(function(){
    $("#btn-register").click(submit_data);
});
</script>

@endpush
