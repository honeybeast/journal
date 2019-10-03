<template>
  <div>
    <div class="form-group">
      <span class="sj-select">
        <select id="email_types" name="template_types" v-on:change="getUserType($event)">
          <option selected value>Select Email Type</option>
          <option
            v-for="(email_type, index) in email_types"
            :value="email_type.value"
          >{{email_type.title}}</option>
        </select>
      </span>
    </div>
    <div class="form-group" v-if="user_types.length > 0 && !this.error">
      <span class="sj-select">
        <select id="user_types" name="user_types" v-on:change="getEmailVariables($event)">
          <option selected value="null">Select User Type</option>
          <option
            v-for="(user_type, index) in user_types"
            :value="user_type.role_id"
          >{{user_type.role_name}}</option>
        </select>
      </span>
    </div>
    <transition name="jump" v-else>
      <div class="sj-jump-messeges">{{this.error}}</div>
    </transition>
    <div class="jf-settingvari" v-if="variables.length > 0">
      <div class="jf-title">
        <h3>Email Setting Variables</h3>
      </div>
      <ul class="jf-settingdetails">
        <li v-for="(variable, index) in variables">
          <span>{{variable.value}}</span>
          <em>- {{variable.key}}</em>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
export default {
  props: [""],
  data() {
    return {
      selected_email_type: "",
      selected_role: "",
      selected_role_name: "",
      selected_role_type: "",
      email_types: [],
      user_types: [],
      variables: [],
      stored_variables: [],
      show: false,
      error: "",
      total_email_templates: "",
      selected_type: ""
    };
  },
  methods: {
    getEmailType: function(event) {
      var self = this;
      axios
        .get(APP_URL + "/dashboard/superadmin/emails/get-email-type")
        .then(function(response) {
          self.email_types = response.data.email_type;
        })
        .catch(function(error) {
          //console.log(error.response.data);
        });
    },
    getUserType: function(event) {
      this.error = "";
      var element = event.currentTarget;
      var elementID = element.getAttribute("id");
      this.selected_email_type = jQuery("#" + elementID).val();
      var self = this;
      axios
        .post(APP_URL + "/dashboard/superadmin/emails/get-email-user-type", {
          email_type: self.selected_email_type
        })
        .then(function(response) {
          if (response.data.error) {
            self.error = response.data.error;
            //console.log(self.error);
          } else {
            self.user_types = response.data.user_type;
            //console.log(self.user_types);
          }
          self.show = true;
        })
        .catch(function(error) {
          //console.log(error.response.data);
        });
    },
    getEmailVariables: function(event) {
      var element = event.currentTarget;
      var elementID = element.getAttribute("id");
      var role_id = jQuery("#" + elementID).val();
      var self = this;
      axios
        .post(APP_URL + "/dashboard/superadmin/emails/get-email-variables", {
          role_id: role_id,
          email_type: self.selected_email_type
        })
        .then(function(response) {
          self.variables = response.data.variables;
          self.show = true;
        })
        .catch(function(error) {
          //console.log(error.response.data);
        });
    }
  },

  created: function() {
    this.getEmailType();
  }
};
</script>
