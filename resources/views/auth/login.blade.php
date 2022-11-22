@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>
                
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4 col-form-label text-md-right"></label>
                        <div class="col-md-6">
                            <span class="login-message error-message">
                                
                            </span>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('login') }}" id="form-login">
                        @csrf

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
                       
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">

                                <button id="btn-login" type="button" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <button id="btn-register" type="button" class="btn btn-success">
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
    $("#form-login").find('input.required').each(function(){
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

    $.ajax({
        url: "{{ route('postLogin') }}",
        type: "POST",
        dataType: "JSON",
        cache: false,
        data: $("#form-login").serialize(),
        success:function(response){
            $(".login-message").html('');
            if (response.auth == false){
                $(".login-message").html("Ada yang salah dengan email atau password. Silahkan periksa kembali!");
            }else{
                location.href = "{{ route('home') }}"
            }
        },
        error:function(response){            
            console.log(response);
        }
    });

}

$(document).ready(function(){
    $("#btn-login").click(submit_data);

    $("#btn-register").click(function(){
        location.href = '{{ route("register") }}';
    })
});
</script>

@endpush
