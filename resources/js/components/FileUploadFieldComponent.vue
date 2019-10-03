<template>
  <div>
    <div class="sj-inputtyfile" v-bind:class="{ 'sj-uploading': this.uploading }">
      <div class="sj-title">
        <h3>{{field_title}}</h3>
      </div>
      <label :for="this.doc_id" :id="'label'+doc_id" v-if="slider_from_db">
        <span class="uploaded_slider_image_name">{{slider_from_db}}</span>
        <div class="sj-filerightarea">
          <span>
            <em>{{fileSize}}</em>
          </span>
        </div>
        <input
          type="file"
          :class="this.input_class"
          @change="notifyFileInput"
          :name="file_name"
          :id="doc_id"
          :ref="doc_ref"
        >
        <input type="hidden" :value="slider_from_db" :name="hidden_field_name" :id="hidden_id">
      </label>
      <label :for="this.doc_id" v-else-if="file">
        <span>{{file}}</span>
        <div class="sj-filerightarea">
          <span>
            <em>{{fileSize}}</em>
          </span>
        </div>
        <input
          type="file"
          :class="this.input_class"
          @change="notifyFileInput"
          :name="file_name"
          :id="doc_id"
          :ref="doc_ref"
        >
      </label>
      <label :for="this.doc_id" v-else>
        <span>{{file_placeholder}}</span>
        <div class="sj-filerightarea">
          <span>
            <i v-bind:class="{ 'ti-upload': this.file_na, 'ti-close': this.file_check }"></i>
          </span>
        </div>
        <input
          type="file"
          :class="this.input_class"
          @change="notifyFileInput"
          :name="file_name"
          :id="doc_id"
          :ref="doc_ref"
        >
      </label>
      <div class="sj-filedetails">
        <span>{{file_size_label}}</span>
        <em v-if="slider_from_db">{{file_uploaded_label}}</em>
        <em v-else-if="file">{{file_uploaded_label}}</em>
        <em v-else>{{file_not_uploaded_label}}</em>
      </div>
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
    "doc_id",
    "uploaded_file",
    "input_class",
    "hidden_field_name",
    "hidden_id"
  ],
  data() {
    return {
      file_check: false,
      file_na: true,
      file_error: true,
      file_completed: false,
      file: "",
      fileSize: "",
      uploading: false,
      doc_ref: "uploaded_doc",
      doc_input: "",
      file_object: "",
      deleted: "",
      slider_from_db: this.uploaded_file
    };
  },
  methods: {
    watchFileInput: function() {
      $('input[type="file"]').change(this.notifyFileInput.bind(this));
    },

    notifyFileInput: function(event) {
      var file = event.target.files;
      this.file_object = file;
      var fileName = event.target.files[0].name;
      var Size = event.target.files[0].size;
      (this.file_check = false),
        (this.file_na = true),
        (this.file_error = true),
        (this.file_completed = false);

      if (fileName) {
        this.file_na = false;
        this.file_check = true;
        this.file_completed = true;
        this.file_error = false;
        this.uploading = true;
      }

      this.file = fileName;
      this.slider_from_db = fileName;
      let UploadedFileSize = this.bytesToSize(Size);
      this.fileSize = UploadedFileSize;
      this.deleted = "";
    },
    bytesToSize(bytes) {
      var sizes = ["Bytes", "KB", "MB", "GB", "TB"];
      if (bytes == 0) return "0 Byte";
      var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
      return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
    },
    clear: function() {
      console.log(this.file_object);
      this.file_object = null;
      this.file = "";
      this.file_check = false;
      this.file_na = true;
      this.file_error = true;
      this.fileSize = "";
      this.uploading = false;
      this.deleted = "deleted";
    }
  },

  created: function() {}
};
</script>
