<div id="accordion" class="sj-addarticleholdcontent sj-collapsehold">
    <div class="sj-dashboardboxtitle" id="headingOne-8" data-toggle="collapse" data-target="#collapseOne-8"
        aria-expanded="true" aria-controls="collapseOne-8">
        <h2>{{{trans('prs.add_logo')}}}</h2>
    </div>
    <div  id="collapseOne-8" aria-labelledby="headingOne-8" data-parent="#accordion" class="sj-uploadimgbars sj-active collapse">
        <div class="sj-acsettingthold" id="uploaded_site_logo">
            <image-upload
                :delete_confirm_title="'{{{trans("prs.ph_file_delete_confirm_title")}}}'"
                :file_placeholder="'{{{trans("prs.ph_upload_file_label")}}}'"
                :file_size_label="'{{{trans("prs.ph_article_file_size")}}}'"
                :file_uploaded_label="'{{{trans("prs.ph_file_uploaded")}}}'"
                :file_not_uploaded_label="'{{{trans("prs.ph_file_not_uploaded")}}}'"
                :delete_url=config.img_deleted
                :submit_url=config.img_upload
                :get_url=config.get_img
                :id="'site_logo'">
            </image-upload>
        </div>
    </div>
</div>
