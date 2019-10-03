<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-16" data-toggle="collapse" data-target="#collapseOne-16"
    aria-expanded="true" aria-controls="collapseOne-16">
        <h2>{{trans('prs.ad_img_settings')}}</h2>
    </div>
    <div id="collapseOne-16" aria-labelledby="headingOne-16" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        <div class="sj-acsettingthold" id="uploaded_site_logo">
            <image-upload
                :delete_confirm_title="'{{trans("prs.ph_file_delete_confirm_title")}}'"
                :file_placeholder="'{{trans("prs.ph_upload_file_label")}}'"
                :file_size_label="'{{trans("prs.ph_article_file_size")}}'"
                :file_uploaded_label="'{{trans("prs.ph_file_uploaded")}}'"
                :file_not_uploaded_label="'{{trans("prs.ph_file_not_uploaded")}}'"
                :delete_url=adconfig.img_deleted
                :submit_url=adconfig.img_upload
                :get_url=adconfig.get_img
                :id="'adver_img'">
            </image-upload>
        </div>
    </div>
</div>
