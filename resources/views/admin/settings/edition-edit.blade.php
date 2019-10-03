@extends('master')
@php $breadcrumbs = Breadcrumbs::generate('editEdition',$id); @endphp
@section('breadcrumbs')
    @if (count($breadcrumbs))
        <ol class="sj-breadcrumb">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{{ $breadcrumb->url }}}">{{{ $breadcrumb->title }}}</a></li>
                @else
                    <li class="active">{{{ $breadcrumb->title }}}</li>
                @endif
            @endforeach
        </ol>
    @endif
@endsection
@section('content')
@php $counter = 0; @endphp
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                @include('includes.side-menu')
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="general_setting">
                    @if (Session::has('error'))
                        <div class="toast-holder">
                            <flash_messages :message="'{{{ Session::get('error') }}}'" :message_class="'danger'" v-cloak></flash_messages>
                        </div>
                    @elseif ($errors->any())
                        <div class="toast-holder">
                            @foreach ($errors->all() as $error)
                                <flash_messages :message="'{{{$error}}}'" :message_class="'danger'" v-cloak></flash_messages>
                            @endforeach
                        </div>
                   @endif
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-content editiontemplate" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo sj-editiontemplate">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{trans('prs.edit_edition')}}}</h2>
                        </div>
                        <div class="sj-manageallsession sj-editionsettings">
                            {!! Form::open(['url' => '/dashboard/general/settings/update-edition/'.$edition->id,
                            'class'=>'sj-categorydetails category_edit_form sj-formtheme', 'files'=>'true']) !!}
                                <fieldset>
                                    <div class="form-category form-group">
                                        {!! Form::text('title', $edition->title, ['class' => 'form-control', 'required' => 'required']) !!}
                                    </div>
                                    <div class="form-group">
                                        <date-picker name="edition_date" value="{{{$edition->edition_date}}}" :config="config"></date-picker>
                                    </div>
                                    @if ($payment_mode != "free")
                                        <div class="form-group">
                                            {!! Form::number('price', $edition->edition_price, ['class' => 'form-control', 'min' => '1', 'placeholder' => trans('prs.ph_edition_price')]) !!}
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <upload-files-field
                                            :doc_id="'edition_cover'"
                                            :uploaded_file="'{{{App\Edition::getEditionImageByID($edition->id)}}}'"
                                            :hidden_field_name="'hidden_edition_cover'"
                                            :file_name="'edition_cover'"
                                            :file_placeholder="'{{{trans("upload cover image")}}}'"
                                            :file_size_label="'{{{trans("prs.ph_article_file_size")}}}'"
                                            :file_uploaded_label="'{{{trans("prs.ph_file_uploaded")}}}'"
                                            :file_not_uploaded_label="'{{{trans("prs.ph_file_not_uploaded")}}}'">
                                        </upload-files-field>
                                    </div>
                                    <div class="form-group margin-none">
                                        <span class="sj-select">
                                            <select data-placeholder="{{{ !empty($unassigned_articles) ? trans('prs.assing_articles') : trans('prs.no_article_found') }}}"
                                             multiple class="chosen-select" name="articles[]">
                                                <optgroup>
                                                    @foreach($unassigned_articles as $key => $article)
                                                        <option value="{{{$article->id}}}" {{{ in_array($article->id, $assign_articles) ? 'selected' : '' }}} >
                                                            {{{$article->title}}}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                        </span>
                                    </div>
                                </fieldset>
                                <div class="sj-popupbtn">
                                    {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
