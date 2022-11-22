<div class="card mb-0 pt-2" style=height:55px;">
    <div class="row justify-content-between">
        <div class="col-sm-4 pl-4">
            <h2>Pertanyaan</h2>
        </div>
        <div class="col-sm-4">
        <h2>{{$pertanyaan->count()}} Pertanyaan</h2>
        </div>
        <div class="col-sm-4">
            <a href="{{Url('/tambahpertanyaan')}}" class="btn btn-block btn-primary">Tambah Pertanyaan</a>
        </div>
    </div>
</div>