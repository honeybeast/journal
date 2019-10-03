@extends('master') 
@php $breadcrumbs = Breadcrumbs::generate('managePages',$user_role); @endphp 
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
    <div class="container">
        <div class="row">
            <div id="sj-twocolumns" class="sj-twocolumns">
                @include('includes.side-menu')
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-9 float-right" id="manage_page">
                    @if (Session::has('message'))
                        <div class="toast-holder">
                            <flash_messages :message="'{{{ Session::get('message') }}}'" :message_class="'success'" v-cloak></flash_messages>
                        </div>
                    @endif
                    <sticky_messages :message="this.message"></sticky_messages>
                    <div id="sj-contentvtwo" class="sj-content sj-addarticleholdcontent sj-addarticleholdvtwo">
                        <div class="sj-dashboardboxtitle sj-titlewithform">
                            <h2>{{{trans('prs.manage_pages')}}}</h2>
                        </div>
                        <div class="sj-manageallsession">
                            <form class="sj-formtheme sj-managesessionform">
                                <fieldset>
                                    <div class="form-group">
                                        <a class="sj-btn sj-btnactive create-user" href="{{{url('/'.$user_role.'/dashboard/'.$editor_id.'/pages/page/create-page')}}}">
                                            {{{trans('prs.add_new_pge')}}}
                                        </a>
                                    </div>
                                </fieldset>
                            </form>
                            <ul class="sj-allcategorys">
                                @if($pages->count() > 0) 
                                    @foreach($pages as $page)
                                        <li class="sj-categorysinfo delPage-{{{$page->id}}}">
                                            <div class="sj-title">
                                                <h3>{{{ $page->title }}}</h3>
                                            </div>
                                            @php 
                                                $delete_title = trans("prs.ph_delete_confirm_title"); 
                                                $delete_message = trans("prs.ph_page_delete_message"); 
                                                $deleted = trans("prs.ph_delete_title"); 
                                            @endphp
                                            <div class="sj-categorysrightarea">
                                                <a href="{{{url('/'.$user_role.'/dashboard/pages/page')}}}/{{{$page->id}}}/edit-page" class="sj-pencilbtn">
                                                    <i class="ti-pencil"></i>
                                                </a>
                                                <a href="#" v-on:click.prevent="deletePage($event,'{{{$delete_title}}}','{{{$delete_message}}}','{{{$deleted}}}')" class="sj-trashbtn" id="{{{ $page->id }}}">
                                                    <i class="ti-trash"></i>
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach 
                                @else
                                    @include('errors.no-record') 
                                @endif
                            </ul>
                            @if( method_exists($pages,'links') ) {{{ $pages->links('pagination.custom') }}} @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
