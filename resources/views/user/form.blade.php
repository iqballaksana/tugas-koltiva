<div class="container">
	<form action="/user" method="POST" id="form-user" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <input type="hidden" name="id" value="{{ empty($users->id)?'':$users->id }}">
        <input type="hidden" name="tempFile" value="{{ empty($users->photo)?'':$users->photo }}">
    </div>
    <div class="form-group row">
        <label for="content">Name</label>
      <input  type="text" class="form-control" name="name" placeholder="Masukan nama" value="{{ empty($users->name)?'':$users->name }}">
    </div>
    <div class="form-group row">
        <label for="content">Email</label>
      <input  type="text" class="form-control required" name="email" id="email" placeholder="Masukan email" value="{{ empty($users->email)?'':$users->email }}">
      <span class="error-message">
    </span>
    </div>
    <?php if (empty($users->id)){ ?>
    <div class="form-group row">
        <label for="content">Password</label>
      <input  type="password" class="form-control required" name="password" placeholder="Masukan password">
      <span class="error-message">
    </span>
    </div>
    <?php } ?>
    <div class="form-group row">
        <label for="content">Photo</label>
        <input  type="file" class="form-control" name="photo" accept="image/png, image/gif, image/jpeg">
    </div>
    <?php 
    if (!empty($users->photo)){
          $path = public_path().'/images/user/'.$users->photo;
          if (file_exists($path) && !empty($users->photo)){
      ?>
          <img src="{{ asset('images/user').'/'.$users->photo }}" width="200px" height="200px" class="" alt="{{$users->photo}}">
      <?php
          }else{
            echo 'not set image';
          }
        }
      ?>
  </form>
</div>
