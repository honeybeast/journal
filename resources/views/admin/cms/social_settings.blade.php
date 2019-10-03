<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-1" data-toggle="collapse" data-target="#collapseOne-1"
    aria-expanded="true" aria-controls="collapseOne-1">
        <h2>{{{trans('prs.add_social_icons')}}}</h2>
    </div>
    <div id="collapseOne-1" aria-labelledby="headingOne-1" data-parent="#accordion" class="sj-acsettingthold sj-active collapse">
        <div class="card-body">
            {!! Form::open(['url' => '/dashboard/'.$user_role.'/site-management/store-settings', 'class' => 'sj-formtheme sj-formarticle
            sj-formsocical', 'id'=>'social_management']) !!}
                <fieldset class="social-icons-content">
                    @if (!empty($social_unSerialize_array))
                        @php $counter = 0 @endphp
                        @foreach ($social_unSerialize_array as $unSerializeKey =>$unSerializeValue)
                            <div class="wrap-social-icons">
                                <div class="form-group sj-authorhold">
                                    <span class="sj-select">
                                        <select name="social[{{{$counter}}}][title]" class="form-control">
                                            <option value="null" selected>{{{trans('prs.select_social_icons')}}}</option>
                                            @foreach ($social_list as $key => $value)
                                                @php
                                                    $selected = 'selected';
                                                    $selected_value = $unSerializeValue['title'] === $key ? $selected : '';
                                                @endphp
                                                <option value="{{{$key}}}" {{{$selected_value}}}>{{{$value['title']}}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                                <div class="form-group sj-authorholdvtwo">
                                    {!! Form::text('social['.$counter.'][url]', $unSerializeValue['url'], ['class' => 'form-control author_title']) !!}
                                    <div class="sj-adddelbtns">
                                        @if ($unSerializeKey == 0 )
                                            <span class="sj-addbtn" @click="addSocial"><i class="fa fa-plus"></i></span>
                                        @else
                                            <span class="sj-addbtn sj-delbtn delete-social" data-check="{{{$counter}}}">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @php $counter++; @endphp
                        @endforeach
                    @else
                        <div class="wrap-social-icons">
                            <div class="form-group sj-authorhold">
                                <span class="sj-select">
                                    <select name="social[0][title]" class="form-control">
                                        <option value="null" selected>{{ trans('prs.select_social_icons') }}</option>
                                        @foreach($social_list as $key => $value)
                                            <option value="{{{$key}}}">{{{$value['title']}}}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                {!! Form::text('social[0][url]', null, ['class' => 'form-control author_title', 'placeholder' => trans('prs.ph_social_url'),'v-model'
                                => 'first_social_url']) !!}
                                <div class="sj-adddelbtns">
                                    <span class="sj-addbtn" @click="addSocial"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div v-for="(social, index) in socials" v-cloak>
                        <div class="wrap-social-icons">
                            <div class="form-group sj-authorhold">
                                <select class="form-control" v-bind:name="'social['+[social.count]+'][title]'">
                                    <option value="null" selected>{{{trans('prs.select_social_icons')}}}</option>
                                    @foreach($social_list as $key => $value)
                                        <option value="{{{$key}}}">{{{$value['title']}}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group sj-authorholdvtwo">
                                <input placeholder="{{{trans('prs.ph_social_url')}}}" v-bind:name="'social['+[social.count]+'][url]'" type="text" class="form-control"
                                    v-model="social.social_url">
                                <div class="sj-adddelbtns">
                                    <span class="sj-addbtn sj-delbtn" @click="removeSocial(index)"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="sj-btnarea sj-updatebtns">
                    {!! Form::submit(trans('prs.btn_submit'), ['class' => 'sj-btn sj-btnactive']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
