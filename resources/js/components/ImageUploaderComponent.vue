<template>
  <div>
    <div class="sj-inputtyfile" v-bind:class="{ 'sj-uploading': this.uploading }">
      <transition name="jump">
        <div v-if="isShow" class="sj-jump-messeges">{{this.message}}</div>
      </transition>
      <label :for="my_file">
        <span v-if="this.image">{{this.image}}</span>
        <span v-else>{{file_placeholder}}</span>
        <div class="sj-filerightarea" v-if="this.image">
          <a href="javascript:void(0);" v-on:click="clear()" id="clear_data">
            <i v-bind:class="{ 'ti-upload': this.file_uncheck, 'ti-close': this.file_check }"></i>
          </a>
        </div>
        <div class="sj-filerightarea" v-else>
          <i class="ti-upload"></i>
        </div>
        <input :id="my_file" type="file" ref="fileInput" @change="fileChanged($event)">
        <input type="hidden" :value="this.hidden_value" name="deleted_image">
      </label>
      <div class="sj-filedetails">
        <span>{{file_size_label}}</span>
        <em v-if="this.image">{{file_uploaded_label}}</em>
        <em v-else>{{file_not_uploaded_label}}</em>
      </div>
    </div>
    <div class="sj-btnarea sj-updatebtns">
      <a href class="sj-btn sj-btnactive" v-on:click.prevent="update()">{{this.submit_btn}}</a>
    </div>
  </div>
</template>
<script>
export default {
  props: [
    "field_title",
    "file_name",
    "file_placeholder",
    "file_size_label",
    "file_uploaded_label",
    "file_not_uploaded_label",
    "delete_title",
    "delete_confirm_title",
    "delete_url",
    "submit_url",
    "get_url",
    "img_id",
    "submit_btn"
  ],
  data() {
    return {
      file: "Upload Your File Here",
      file_check: false,
      file_uncheck: true,
      uploading: false,
      size: "",
      image: "",
      message: "",
      isShow: false,
      hidden_value: "",
      my_file: this.img_id,
      fileInput: "",
      img_delete_url: this.delete_url,
      img_submit_url: this.submit_url,
      img_get_url: this.get_url
    };
  },
  methods: {
    fileChanged(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.createImage(files[0]);

      let uploadedFiles = e.target.files || e.dataTransfer.files;
      var fileName = uploadedFiles[0].name;
      this.image = fileName;

      if (uploadedFiles.length > 0) {
        this.file_check = true;
        this.file_uncheck = false;
        this.uploading = true;
      } else {
        this.uploading = false;
        this.file_uncheck = true;
        this.file_check = false;
      }

      let uploadedFileSize = uploadedFiles[0].size;
      let fileSize = this.bytesToSize(uploadedFileSize);
      this.size = fileSize;
      this.hidden_value = "";
    },

    createImage(file) {
      var image = new Image();
      var reader = new FileReader();
      var vm = this;

      reader.onload = e => {
        vm.my_file = e.target.result;
      };
      reader.readAsDataURL(file);
    },

    clear() {
      this.uploading = false;
      this.size = "";
      this.image = "";
      let self = this;
      this.hidden_value = "deleted";
      swal(
        {
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
            axios
              .post(self.img_delete_url)
              .then(function(response) {
                  self.file_check = false;
                  self.file_uncheck = true;
                  setTimeout(function() {
                  swal({
                      title: "Deleted!",
                      text: "Image has been deleted.",
                      type: "success"
                  });
                  }, 500);
                  if(response.data.type == 'user_delete') {
                    document.getElementById("user_image_sidebar").src = APP_URL + "/images/no-profile-img.jpg";
                    document.getElementById("site_user_image_header").src = APP_URL + "/images/no-profile-img.jpg";
                  } else if (response.data.type == 'logo_delete') {
                    document.getElementById("site_logo").src = APP_URL+'/images/logo.png';
                    document.getElementById("footer_site_logo").src = APP_URL+'/images/logo.png';
                  } 
             });
          } else {
          }
        }
      );
    },
    update() {
      let self = this;
      if (this.image != '') {
          if(this.$refs.fileInput.files.length == 0){
                self.message ='image uploaded successfully';
                self.isShow = true;
                setTimeout(function(){
                    self.isShow = false;
                }, 2000);
                return false;
            }
        var data = new FormData();
        var file = this.$refs.fileInput.files[0];
        data.append("attachment_file", file);
        axios
          .post(
            self.img_submit_url,
            data,
            {
              headers: {
                "Content-Type": "multipart/form-data"
              }
            }
          )
          .then(
            function(data) {
              if (data.data.message) {
                self.message = data.data.message;
                self.file = data.data.image_name;
                self.isShow = true;
                if (data.data.type == 'user_img_update') {
                  document.getElementById("user_image_sidebar").src = data.data.url;
                  document.getElementById("site_user_image_header").src = data.data.url;
                } else if (data.data.type == 'logo_update') {
                  document.getElementById("site_logo").src = data.data.url;
                  document.getElementById("footer_site_logo").src = data.data.url;
                }
              } else {
                self.message = data.data.error;
                self.isShow = true;
                self.file_check = false;
                self.file = "Upload Your File Here";
                self.uploading = false;
                self.file_uncheck = true;
              }
              setTimeout(function() {
                self.isShow = false;
              }, 2000);
            }.bind(this)
          )
          .catch(function(data) {});
      } else {
        self.message = "image required";
        self.isShow = true;
        setTimeout(function() {
          self.isShow = false;
        }, 2000);
      }
    },
    getImage() {
      let self = this;
      axios
        .get(self.img_get_url)
        .then(function(response) {
          self.image = response.data.image;
          if (self.image) {
            self.uploading = true;
            self.file_check = true;
            self.file_uncheck = false;
          }
        })
        .catch(function(error) {
          // handle error
        })
        .then(function() {
          // always executed
        });
    },
    bytesToSize(bytes) {
      var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
      if (bytes == 0) return "0 Byte";
      var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
      return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
    }
  },
  created: function() {
    this.getImage();
  }
};
</script>