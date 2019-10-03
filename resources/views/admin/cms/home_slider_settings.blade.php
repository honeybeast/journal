<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold sj-sildersettinghold">
    <div class="sj-dashboardboxtitle" id="headingOne-5" data-toggle="collapse" data-target="#collapseOne-5"
        aria-expanded="true" aria-controls="collapseOne-5">
        <h2>{{ trans('prs.home_slider_sett') }}</h2>
    </div>
    <div id="collapseOne-5" aria-labelledby="headingOne-5" data-parent="#accordion" class="sj-acsettingthold sj-active collapse">
        {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store/slider-settings', 'class' =>
        'sj-formtheme sj-formarticle sj-formsocical', 'id'=>'social_management', 'enctype' => 'multipart/form-data',
        'multiple' => true]) !!}
            <fieldset class="home-slider-content">
                @if (!empty($slide_unSerialize_array))
                @php $counter = 0 @endphp
                    @foreach($slide_unSerialize_array as $unSerializeKey => $unSerializeValue)
                        <div class="wrap-home-slider">
                            <upload-files-field :doc_id="'home_slide_image_id{{{$counter}}}'"
                                :uploaded_file="'{{{$unSerializeValue['slide_image']}}}'"
                                :field_title="'{{{trans("prs.upload_slider_image")}}}'" :file_name="this.store_file_input_name+'[{{{$counter}}}]'+this.store_file_input_image"
                                :hidden_field_name="'slide'+'[{{{$counter}}}]'+'[hidden_image]'" :file_placeholder="'{{{trans("prs.ph_upload_file_image")}}}'"
                                :file_size_label="'{{{trans("prs.ph_article_file_size")}}}'" :file_uploaded_label="'{{{trans("prs.ph_file_uploaded")}}}'"
                                :file_not_uploaded_label="'{{{trans("prs.ph_file_not_uploaded")}}}'" :input_class="'slider-input'">
                            </upload-files-field>
                            <div class="form-group sj-authorhold">
                                {!! Form::text('slide['.$counter.'][title]', $unSerializeValue['slide_title'], ['class' =>
                                'form-control author_title','placeholder'=>trans('prs.ph_title')]) !!}
                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                {!! Form::textarea('slide['.$counter.'][desc]', $unSerializeValue['slide_desc'], ['class' =>
                                'form-control author_title','placeholder'=>trans('prs.ph_desc')]) !!}
                                <div class="sj-adddelbtns">
                                    @if ($unSerializeKey == 0 )
                                        <span class="sj-addbtn" @click="addSlide"><i class="fa fa-plus"></i></span>
                                    @else
                                        <span class="sj-addbtn sj-delbtn delete-slide" data-check="{{{$counter}}}"><i class="fa fa-plus"></i></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php $counter++; @endphp
                    @endforeach
                @else
                    <div class="wrap-home-slider">
                        <upload-files-field
                            :doc_id="first_slide_img_id"
                            :field_title="'{{{trans("prs.upload_slider_image")}}}'"
                            :file_name="this.file_input_name"
                            :file_placeholder="'{{{trans("prs.ph_upload_file_image")}}}'"
                            :file_size_label="'{{{trans("prs.ph_article_file_size")}}}'"
                            :file_uploaded_label="'{{{trans("prs.ph_file_uploaded")}}}'"
                            :file_not_uploaded_label="'{{{trans("prs.ph_file_not_uploaded")}}}'">
                        </upload-files-field>
                        <div class="form-group sj-authorhold">
                            {!! Form::text('slide[0][title]', null, ['class' => 'form-control author_title', 'placeholder' =>
                            trans('prs.ph_slide_title'),'v-model' => 'first_slide_title']) !!}
                        </div>
                        <div class="form-group sj-authorholdvtwo">
                            {!! Form::textarea('slide[0][desc]', null, ['class' => 'form-control author_title', 'placeholder'
                            => trans('prs.ph_slide_desc'),'v-model' => 'first_slide_desc']) !!}
                            <div class="sj-adddelbtns">
                                <span class="sj-addbtn" @click="addSlide"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                    </div>
                @endif
                <div v-for="(slide, index) in slides" v-cloak>
                    <div class="wrap-home-slider">
                        <upload-files-field
                            :doc_id="slide.image_id+slide.slide_count"
                            :field_title="'{{{trans("prs.upload_slider_image")}}}'"
                            :file_name="slide.slide_input_name"
                            :file_placeholder="'{{{trans("prs.ph_upload_file_image")}}}'"
                            :file_size_label="'{{{trans("prs.ph_article_file_size")}}}'"
                            :file_uploaded_label="'{{{trans("prs.ph_file_uploaded")}}}'"
                            :file_not_uploaded_label="'{{{trans("prs.ph_file_not_uploaded")}}}'">
                        </upload-files-field>
                        <div class="form-group sj-authorhold">
                            <input placeholder="{{{trans('prs.ph_slide_title')}}}" v-bind:name="'slide['+[slide.slide_count]+'][title]'"
                                type="text" class="form-control" :v-model="slide.slide_title">
                        </div>
                        <div class="form-group sj-authorholdvtwo">
                            <textarea placeholder="{{{trans('prs.ph_slide_desc')}}}" v-bind:name="'slide['+[slide.slide_count]+'][desc]'"
                                type="text" class="form-control" :v-model="slide.slide_desc"></textarea>
                            <div class="sj-adddelbtns">
                                <span class="sj-addbtn sj-delbtn" @click="removeSlide(index)"><i class="fa fa-plus"></i></span>
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
