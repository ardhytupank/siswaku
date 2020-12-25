@extends('template')

@section('main')
    <div id="siswa">
      <h2>Tambah Siswa</h2>
      {{-- @include('errors.form_error_list') --}}
      {!! Form::open(['url' => 'siswa']) !!}
      @include('siswa.form',['submitButtonText' => 'Simpan']);
      {!! Form::close() !!}
  
  </div>
@endsection

@section('footer')
        @include('footer')
@stop