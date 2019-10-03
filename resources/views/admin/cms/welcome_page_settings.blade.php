<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-10" data-toggle="collapse" data-target="#collapseOne-10" aria-expanded="true"
        aria-controls="collapseOne-10">
        <h2>{{{trans('prs.hme_page_welcome_section')}}}</h2>
    </div>
    <div id="collapseOne-10" aria-labelledby="headingOne-10" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
            <div class="sj-addarticleholdcontent">
                <div class="sj-dashboardboxtitle">
                    <h3>{{{trans('prs.select_welcome_page')}}}</h3>
                </div>
                @if (($page->count() > 0))
                    {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/welcome-settings',
                    'class' => 'sj-formtheme sj-formarticle sj-formsocical']) !!}
                        <fieldset class="social-icons-content">
                            <div class="wrap-social-icons">
                                <div class="form-group sj-authorholdvtwo">
                                    <span class="sj-select">
                                        {!! Form::select('page[0]page_id', $page, $welcome_page, array('class' => 'form-control', 'placeholder' => !empty($page) ? trans('prs.choose_resource_pages') : trans('prs.create_page_selction'))) !!}
                                    </span>
                                </div>
                            </div>
                        </fieldset>
                        <div class="sj-btnarea sj-updatebtns">
                            {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
                        </div>
                    {!! Form::close() !!}
                @else
                    <div class="sj-uploadimgbarslink">
                        <a href="{{{url('/'.$user_role.'/dashboard/'.$editor_id.'/pages/page/create-page')}}}">{{{trans('prs.create_pages')}}}</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="sj-acsettingthold sj-btnarea sj-updatebtns">
            <div class="sj-addarticleholdcontent">
                <div class="sj-dashboardboxtitle">
                    <h3>{{{trans('prs.welcome_page_slider')}}}</h3>
                </div>
                {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/welcome-slider-settings',
                'class' => 'sj-formtheme sj-formarticle sj-formsocical', 'id'=>'social_management', 'enctype' => 'multipart/form-data',
                'multiple' => true]) !!}
                    <fieldset class="welcome-slider-content">
                        @if (!empty($welcome_slide_unserialize_array))
                            @php $counter = 0 @endphp
                            @foreach ($welcome_slide_unserialize_array as $unserialize_key => $unserialize_value)
                                <div class="wrap-welcome-slider">
                                    <upload-files-field
                                        :doc_id="'welcome_slide_image_id{{$counter}}'"
                                        :hidden_id="'welcome_hidden_slide_image_id{{$counter}}'"
                                        :uploaded_file="'{{$unserialize_value['welcome_slide_image']}}'"
                                        :field_title="'{{trans("prs.upload_slider_image")}}'"
                                        :file_name="this.store_file_input_name+'[{{$counter}}]'+this.store_welcome_file_input_image"
                                        :hidden_field_name="'slide'+'[{{$counter}}]'+'[welcome_hidden_image]'"
                                        :file_placeholder="'{{trans("prs.ph_upload_file_image")}}'"
                                        :file_size_label="'{{trans("prs.ph_article_file_size")}}'"
                                        :file_uploaded_label="'{{trans("prs.ph_file_uploaded")}}'"
                                        :file_not_uploaded_label="'{{trans("prs.ph_file_not_uploaded")}}'"
                                        :input_class="'slider-input'">
                                    </upload-files-field>
                                    <div class="sj-authorholdvtwo">
                                        <div class="sj-adddelbtns">
                                            @if ($unserialize_key == 0 )
                                                <span class="sj-addbtn" @click="addWelcomeSlide"><i class="fa fa-plus"></i></span>
                                            @else
                                                <span class="sj-addbtn sj-delbtn delete-slide" data-check="{{{$counter}}}">
                                                    <i class="fa fa-plus"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php $counter++; @endphp
                            @endforeach
                        @else
                            <div class="wrap-welcome-slider">
                                <upload-files-field
                                    :doc_id="'welcome_slide_image_id'"
                                    :field_title="'{{trans("prs.upload_slider_image")}}'"
                                    :file_name="'slide[0][welcome_image]'"
                                    :file_placeholder="'{{trans("prs.ph_upload_file_image")}}'"
                                    :file_size_label="'{{trans("prs.ph_article_file_size")}}'"
                                    :file_uploaded_label="'{{trans("prs.ph_file_uploaded")}}'"
                                    :file_not_uploaded_label="'{{trans("prs.ph_file_not_uploaded")}}'">
                                </upload-files-field>
                                <div class="sj-authorholdvtwo">
                                    <div class="sj-adddelbtns">
                                        <span class="sj-addbtn" @click="addWelcomeSlide"><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div v-for="(slide, index) in welcome_slides" v-cloak>
                            <div class="wrap-welcome-slider">
                                <upload-files-field
                                    :doc_id="slide.image_id+slide.slide_count"
                                    :field_title="'{{trans("prs.upload_slider_image")}}'"
                                    :file_name="slide.slide_input_name"
                                    :file_placeholder="'{{trans("prs.ph_upload_file_image")}}'"
                                    :file_size_label="'{{trans("prs.ph_article_file_size")}}'"
                                    :file_uploaded_label="'{{trans("prs.ph_file_uploaded")}}'"
                                    :file_not_uploaded_label="'{{trans("prs.ph_file_not_uploaded")}}'">
                                </upload-files-field>
                                <div class="sj-authorholdvtwo">
                                    <div class="sj-adddelbtns">
                                        <span class="sj-addbtn sj-delbtn delete-slide" @click="removeWelcomeSlide(index)">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="sj-btnarea sj-updatebtns">
                        {!! Form::submit(trans('prs.btn_save'), ['class' => 'sj-btn sj-btnactive']) !!}
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
