<template>
    <div>
        <div class="sj-inputtyfile" v-bind:class="{ 'sj-uploading': this.uploading }">
            <transition name="jump">
                <div v-if="isShow" class="sj-jump-messeges">{{this.message}}</div>
            </transition>
             <label for="files">
                <span v-if="this.image">{{this.image}}</span>
                <span v-else>{{file_placeholder}}</span>
                <div class="sj-filerightarea" v-if="this.image">
                    <a href="javascript:void(0);" v-on:click="clear()" id="clear_data"><i v-bind:class="{ 'ti-upload': this.file_uncheck, 'ti-close': this.file_check }"></i></a>
                </div>
                <div class="sj-filerightarea" v-else>
                    <i class="ti-upload"></i>
                </div>
                <input type="file" id="files" ref="files" v-on:change="handleFiles()" name="user_image" />
                <input type="hidden" :value="this.hidden_value" name="deleted_image">
            </label>
            <div class="sj-filedetails">
                <span>{{file_size_label}} </span>
                <em v-if="files.length > 0"> {{file_uploaded_label}}</em>
                <em v-else-if="this.image"> {{file_uploaded_label}}</em>
                <em v-else>{{file_not_uploaded_label}}</em>
            </div>
        </div>
       <div class="sj-btnarea sj-updatebtns">
            <a href="" class="sj-btn sj-btnactive" v-on:click.prevent="submitFiles()">Submit</a>
       </div>
    </div>
</template>
<script>
    export default{
    props: ['field_title','file_name','file_placeholder','file_size_label','file_uploaded_label','file_not_uploaded_label','delete_title','delete_confirm_title'],
        data(){
            return {
               file: 'Upload Your File Here',
               file_check: false,
               file_uncheck: true,
               uploading:false,
               size:"",
               image:"",
               message:"",
               isShow: false,
               hidden_value:'',
               files: []
            }
        },
        methods: {
            handleFiles() {
                let uploadedFiles = this.$refs.files.files;
                var fileName = uploadedFiles[0].name;
                for(var i = 0; i < uploadedFiles.length; i++) {
                    this.files.push(uploadedFiles[i]);
                }
                this.image = fileName;

                if( uploadedFiles.length > 0 ){
                    this.file_check = true;
                    this.file_uncheck = false;
                    this.uploading = true;
                }else{
                    this.uploading = false;
                    this.file_uncheck = true;
                    this.file_check = false;
                }

                let uploadedFileSize = uploadedFiles[0].size ;
                let fileSize = this.bytesToSize(uploadedFileSize);
                this.size = fileSize;
                this.hidden_value = "";
            },
            clear(){
                this.uploading = false;
                this.size = "";
                this.image = "";
                let self = this;
                this.hidden_value = "deleted";
                swal({
                    title: self.delete_confirm_title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm) {
                   if (isConfirm) {
                        let self = this;
                        axios.post(APP_URL+'/dashboard/general/settings/account-settings/delete-image')
                            .then(function (response) {
                                self.file_check = false;
                                self.file_uncheck = true;
                            })
                            setTimeout(function(){ swal({
                               title: "Deleted!",
                               text: "Image has been deleted.",
                               type: "success"
                           }) }, 500);
                           document.getElementById("user_image_sidebar").src = APP_URL+'/images/no-profile-img.jpg';
                           document.getElementById("site_user_image_header").src = APP_URL+'/images/no-profile-img.jpg';
                    } else {

                    }
                });

            },
            submitFiles() {
                let self = this;
                if(this.image != '' ){
                  if(this.files.length == 0){
                    self.message ='image uploaded successfully';
                    self.isShow = true;
                    setTimeout(function(){
                        self.isShow = false;
                    }, 2000);
                  }
                  for( let i = 0; i < this.files.length; i++ )
                  {
                    let formData = new FormData();
                    formData.append('file', this.files[i]);
                    axios.post(APP_URL+'/dashboard/general/settings/account-settings/upload-image',
                        formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }
                    ).then(function(data) {
                        if(data.data.message){
                            this.files[i].id = data['data']['id'];
                            this.files.splice(i, 1, this.files[i]);
                            self.message = data.data.message;
                            self.file = data.data.image_name;
                            self.isShow = true;
                            console.log(data);
                            document.getElementById("user_image_sidebar").src = data.data.url;
                            document.getElementById("site_user_image_header").src = data.data.url;

                        }else{
                            self.message = data.data.error;
                            self.isShow = true;
                            self.file_check = false;
                            self.file = "Upload Your File Here";
                            self.uploading = false;
                            self.file_uncheck = true;
                        }
                       setTimeout(function(){
                            self.isShow = false;
                        }, 2000);
                    }.bind(this)).catch(function(data) {

                    });
                  }
                }else
                {
                    self.message ='image required';
                    self.isShow = true;
                    setTimeout(function(){
                        self.isShow = false;
                    }, 2000);

                }

            },
            getImage(){
                let self = this;
                axios.get(APP_URL+'/dashboard/general/settings/account-settings/get-image')
                  .then(function (response) {
                    self.image = response.data.image;
                    if(self.image){
                        self.uploading = true;
                        self.file_check = true;
                        self.file_uncheck = false;
                    }
                  })
                  .catch(function (error) {
                    // handle error
                  })
                  .then(function () {
                    // always executed
                  });
             },
            bytesToSize(bytes) {
               var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
               if (bytes == 0) return '0 Byte';
               var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
               return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
            }
        },
        created: function(){
            this.getImage();
        }
    }
</script>