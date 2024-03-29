@extends('master') 
@php $breadcrumbs = Breadcrumbs::generate('categorySetting'); @endphp 
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
    <style type="text/css">
        .meta_tag, .meta-cur{
            background-color: #f7f7f7;
            padding: 10px;
            border: 1px solid #c1c1c1;
            border-radius: 8px;
            overflow-y: scroll;
            max-height: 173px;
            min-height: 173px;
        }
        .meta_add_btn{
            border-radius: 50%;
            background-color: #24d00b;
            padding: 3px 6px;
            color: white;
            margin-left: 10px;
            cursor: pointer;
        }
    </style>
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="general_setting">
                    @if (Session::has('message'))
                        <div class="toast-holder">
                            <flash_messages :message="'{{{ Session::get('message') }}}'" :message_class="'success'" v-cloak></flash_messages>
                        </div>
                    @elseif (Session::has('error'))
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
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{trans('prs.manage_category')}}}</h2>
                        </div>
                        <div class="sj-manageallsession">
                            <form class="sj-formtheme sj-managesessionform">
                                <fieldset>
                                    <div class="form-group">
                                        <a href="#" data-toggle="modal" data-target="#categoryModal" class="sj-btn sj-btnactive">
                                            {{{trans('prs.new_cat')}}}
                                        </a>
                                    </div>
                                </fieldset>
                            </form>
                            <ul class="sj-allcategorys">
                                @if($categories->count() > 0) 
                                    @foreach($categories as $category)
                                        <li class="sj-categorysinfo del-{{{$category->id}}}" v-bind:id="categoryID">
                                            <div class="sj-title">
                                                <h3>{{{ $category->title }}}</h3>
                                            </div>
                                            <div class="sj-categorysrightarea">
                                                @php 
                                                    $delete_title = trans("prs.ph_delete_confirm_title"); 
                                                    $delete_message = trans("prs.ph_category_delete_message");
                                                    $deleted = trans("prs.ph_delete_title"); 
                                                @endphp
                                                <a href="#" class="sj-pencilbtn" data-toggle="modal" data-target="#categoryEditModal-{{{$counter}}}">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <a href="#" v-on:click.prevent="deleteCategory($event,'{{{$delete_title}}}','{{{$delete_message}}}','{{{$deleted}}}')" class="sj-trashbtn" id="{{{ $category->id }}}">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            </div>
                                        </li>
                                        <div class="sj-modalboxarea modal fade del-{{{$category->id}}}" tabindex="-1" role="dialog" 
                                            aria-labelledby="categoryEditModalLabel" aria-hidden="true" id="categoryEditModal-{{{$counter}}}">
                                            <div class="modal-dialog" role="document">
                                                <div class="sj-modalcontent modal-content cat-model">
                                                    <div class="sj-popuptitle">
                                                        <h2>{{{trans('prs.edit_cat')}}}</h2>
                                                        <a href="javascript;void(0);" class="sj-closebtn close">
                                                            <i class="lnr lnr-cross" data-dismiss="modal" aria-label="Close"></i>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!! Form::open(['url' => '/dashboard/general/settings/edit-category/'.$category->id,'class'=>'category_edit_form edit_form', 
                                                        'files' => true, 'enctype' => 'multipart/form-data']) !!}
                                                            <fieldset>
                                                                <select class="form-control" required="required" name="category_list" style="margin-bottom: 20px;">
                                                                    <option disabled selected value>Select Category</option>
                                                                    @php
                                                                        $category_list = DB::table('category_list')->get();
                                                                    @endphp
                                                                    @if(isset($category_list))
                                                                        @foreach($category_list as $val)
                                                                            <option value="{{{$val->id}}}" 
                                                                                @if ($val->id == $category->category_list)
                                                                                    selected='selected'
                                                                                @endif
                                                                             >{{{$val->category_list}}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <select class="form-control" required="required" name="editor_list" style="margin-bottom: 20px;">
                                                                    <option disabled selected value>Select Editor</option>
                                                                    @php
                                                                        $editor_list = DB::table('users')
                                                                            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                                                            ->where('model_has_roles.role_id', '2')
                                                                            ->select('users.name','users.id')
                                                                            ->get();
                                                                    @endphp
                                                                    @if(isset($editor_list))
                                                                        @foreach($editor_list as $val)
                                                                            <option value="{{{$val->id}}}"
                                                                                @if ($val->id == $category->editor_id)
                                                                                    selected='selected'
                                                                                @endif
                                                                             >{{{$val->name}}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <div class="form-group">
                                                                    {!! Form::text('title', $category->title, ['class' => 'form-control', 'required' => 'required']) !!}
                                                                </div>
                                                                <div class="form-group">
                                                                    {!! Form::textarea('description', $category->description, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_cat_desc')]) !!}
                                                                </div>
                                                                <div class="form-group">
                                                                    {!! Form::textarea('author_guideline', $category->author_guideline, ['class' => 'form-control author_guideline', 'required' => 'required', 'placeholder' => trans('prs.ph_author_guideline')]) !!}
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ISSN for Print</label>
                                                                    {!! Form::text('issn_print', $category->issn_print, ['class' => 'form-control', 'placeholder' => "ISSN for Print"]) !!}
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>ISSN for Electronic</label>
                                                                    {!! Form::text('issn_electronic', $category->issn_electronic, ['class' => 'form-control', 'placeholder' => "ISSN for Electronic"]) !!}
                                                                </div>
                                                                <div class="form-group">
                                                                    <upload-files-field
                                                                        :field_title="this.uploadArticleTitle"
                                                                        :uploaded_file="'{{{App\UploadMedia::getImageName($category->image)}}}'"
                                                                        :hidden_field_name="'hidden_category_image'"
                                                                        :doc_id="edit_category +'{{$category->id}}'"
                                                                        :file_name="this.file_input_name"
                                                                        :file_placeholder="'{{trans("prs.ph_upload_file_label")}}'"
                                                                        :file_size_label="'{{trans("prs.ph_article_file_size")}}'"
                                                                        :file_uploaded_label="'{{trans("prs.ph_file_uploaded")}}'"
                                                                        :file_not_uploaded_label="'{{trans("prs.ph_file_not_uploaded")}}'">
                                                                    </upload-files-field>
                                                                </div>
                                                                <label>Abstract and Indexing<span class="abs_add_btn" id="add_abs_cur" ><i class="fa fa-plus"></i></span></label>
                                                                  <div class="form-group abstract-cur">
                                                                    @php
                                                                      $abstract = DB::table('abstract')->where('jo_id', $category->id)->get();
                                                                    @endphp
                                                                    @if (count($abstract))
                                                                          @foreach ($abstract as $val)
                                                                            <div class="abstract-item-cur">
                                                                              <div style="position: relative;">
                                                                                <input type="hidden" class="abstract-id" name="abstract_id[]" value="{{{$val->id}}}">
                                                                                <input type="hidden" class="logo-img-flag" name="logo_img_changed[]" value="0">
                                                                                <input type="file" class="form-control file_input file" name="logo_img[]" title="" style="margin-bottom: 10px; position: absolute; z-index: 2;opacity: 0;">
                                                                                <span class="file_val" style="display: block;height: 42px; background-color: white;     border: 1px solid #dbdbdb; border-radius: 6px; margin-bottom: 10px; padding: 10px;">{{{$val->logo_img}}}</span>
                                                                              </div>
                                                                              <input class="form-control" required="required" type="text" name="abstract_title[]" placeholder="Input Title" style="margin-bottom: 10px" value="{{{ $val->abstract_title }}}">
                                                                              <input class="form-control valid_url" required="required" name="abstract_url[]" placeholder="Input Url" style="margin-bottom: 10px" value="{{{ $val->abstract_url }}}">
                                                                              <span class="sj-addbtn sj-delbtn abs_del_cur"style="float: right; margin-bottom: 10px"><i class="fa fa-plus"></i></span>
                                                                              <div style="clear:both;"></div>
                                                                            </div>
                                                                          @endforeach
                                                                    @endif 
                                                                  </div>
                                                                  <label>Meta Tags<span class="meta_add_btn" id="add_meta_cur" ><i class="fa fa-plus"></i></span></label>
                                                                  <div class="form-group meta-cur">
                                                                    @php
                                                                      $meta_info = DB::table('meta_tags')->where('jo_id', $category->id)->get();
                                                                    @endphp
                                                                    @if (count($meta_info))
                                                                          @foreach ($meta_info as $val)
                                                                            <div class="meta-item-cur">
                                                                              <input type="hidden" class="meta_tag_id" name="meta_tag_id[]" value="{{{$val->id}}}">  
                                                                              <input class="form-control" required="required" type="text" name="meta_tag_name[]" placeholder="Meta Tag Name" style="margin-bottom: 10px" value="{{{ $val->meta_name }}}">
                                                                              <input class="form-control" required="required" type="text" name="meta_tag_des[]" placeholder="Meta Tag Description" style="margin-bottom: 10px" value="{{{ $val->meta_des }}}">
                                                                              <span class="sj-addbtn sj-delbtn meta_del_cur"style="float: right; margin-bottom: 10px"><i class="fa fa-plus"></i></span>
                                                                              <div style="clear:both;"></div>
                                                                            </div>
                                                                          @endforeach
                                                                    @endif 
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
                                        @php $counter++; @endphp 
                                    @endforeach 
                                @else
                                    @include('errors.no-record') 
                                @endif
                            </ul>
                            <div class="sj-modalboxarea modal fade" id="categoryModal" tabindex="-1" role="dialog" 
                                aria-labelledby="categoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="sj-modalcontent modal-content cat-model">
                                        <div class="sj-popuptitle">
                                            <h2>{{{trans('prs.new_cat')}}}</h2>
                                            <a href="javascript;void(0);" class="sj-closebtn close">
                                                <i class="lnr lnr-cross" data-dismiss="modal" aria-label="Close"></i>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            {!! Form::open(['url' => '/dashboard/general/settings/create-category','class'=>'category_edit_form edit_form', 'id'=>'group_form', 
                                            'enctype' => 'multipart/form-data', 'multiple' => true]) !!}
                                                <fieldset>
                                                    <select class="form-control" required="required" name="category_list" style="margin-bottom: 20px;">
                                                        <option disabled selected value>Select Category</option>
                                                        @php
                                                            $category_list = DB::table('category_list')->get();
                                                        @endphp
                                                        @if(isset($category_list))
                                                            @foreach($category_list as $val)
                                                                <option value="{{{$val->id}}}">{{{$val->category_list}}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    <select class="form-control" required="required" name="editor_list" style="margin-bottom: 20px;">
                                                        <option disabled selected value>Select Editor</option>
                                                        @php
                                                            $editor_list = DB::table('users')
                                                                ->join('model_has_roles','users.id','=','model_has_roles.model_id')
                                                                ->where('model_has_roles.role_id', '2')
                                                                ->select('users.name','users.id')
                                                                ->get();

                                                        @endphp
                                                        @if(isset($editor_list))
                                                            @foreach($editor_list as $val)
                                                                <option value="{{{$val->id}}}">{{{$val->name}}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                    <div class="form-group">
                                                        {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('prs.ph_cat_title')]) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::textarea('description', null, ['class' => 'form-control', 'required' =>'required', 'placeholder' => trans('prs.ph_cat_desc')]) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        {!! Form::textarea('author_guideline', null, ['class' => 'form-control author_guideline', 'required' => 'required', 'placeholder' => trans('prs.ph_author_guideline')]) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <label>ISSN for Print</label>
                                                        {!! Form::text('issn_print', null, ['class' => 'form-control', 'placeholder' => "ISSN for Print"]) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <label>ISSN for Electronic</label>
                                                        {!! Form::text('issn_electronic', null, ['class' => 'form-control', 'placeholder' => "ISSN for Electronic"]) !!}
                                                    </div>
                                                    <div class="form-group">
                                                        <upload-files-field
                                                            :field_title="'{{trans("prs.ph_upload_file")}}'"
                                                            :doc_id="this.create_category"
                                                            :hidden_field_name="'hidden_category_image'"
                                                            :file_name="this.file_input_name"
                                                            :file_placeholder="'{{trans("prs.ph_upload_file_label")}}'"
                                                            :file_size_label="'{{trans("prs.ph_article_file_size")}}'"
                                                            :file_uploaded_label="'{{trans("prs.ph_file_uploaded")}}'"
                                                            :file_not_uploaded_label="'{{trans("prs.ph_file_not_uploaded")}}'" >
                                                        </upload-files-field>
                                                    </div>
                                                    <label>Abstract and Indexing<span class="abs_add_btn" id="add_abs"><i class="fa fa-plus"></i></span></label>
                                                    <div class="form-group abstract">
                                                      <div class="abstract-item">
                                                        <input type="file" title="" class="form-control file" name="logo_img[]" style="margin-bottom: 10px;">
                                                        <input type="hidden" class="logo-img-flag" name="logo_img_changed[]" value="0">
                                                        <input class="form-control" required="required" type="text" name="abstract_title[]" placeholder="Input Title" style="margin-bottom: 10px">
                                                        <input class="form-control add_url" required="required" name="abstract_url[]" placeholder="Input Url" style="margin-bottom: 10px">
                                                        <span class="sj-addbtn sj-delbtn abs_del" style="float: right; margin-bottom: 10px"><i class="fa fa-plus"></i></span>
                                                      </div>
                                                    </div>
                                                    <label>Meta Tags<span class="meta_add_btn" id="add_meta"><i class="fa fa-plus"></i></span></label>
                                                    <div class="form-group meta_tag">
                                                      <div class="meta-item">
                                                        <input class="form-control" required="required" type="text" name="meta_tag_name[]" placeholder="Meta Tag Name" style="margin-bottom: 10px">
                                                        <input class="form-control" required="required" type="text" name="meta_tag_des[]" placeholder="Meta Tag Description" style="margin-bottom: 10px">
                                                        <span class="sj-addbtn sj-delbtn meta_del" style="float: right; margin-bottom: 10px"><i class="fa fa-plus"></i></span>
                                                      </div>
                                                    </div>
                                                </fieldset>
                                                <div class="sj-popupbtn">
                                                    {!! Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']) !!}
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if( method_exists($categories,'links') ) {{{ $categories->links('pagination.custom') }}} @endif
                        </div>
                    </div>
                </div>
                @include('includes.side-menu')
            </div>
        </div>
    </div>
@endsection

