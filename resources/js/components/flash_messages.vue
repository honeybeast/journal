<template>
  <div class="sj-flash-alert">
    <b-alert
      :show="dismissCountDown"
      dismissible
      fade
      @dismissed="dismissCountDown=0"
      :variant="this.message_class"
      @dismiss-count-down="countDownChanged"
    >
      <div id="toast-container">
        <div class="toast-message">{{message}}</div>
      </div>
    </b-alert>
  </div>
</template>

<script>
export default {
  props: ["message", "dismiss_time", "message_class"],
  data() {
    return {
      dismissSecs: 5,
      dismissCountDown: 0,
      showDismissibleAlert: false
    };
  },
  methods: {
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    }
  },
  created() {
    flashVue.$on("showFlashMessage", this.showAlert);
  }
};
</script>

<style>
.fade-enter {
  opacity: 0;
}
.fade-enter-active {
  transition: opacity 1s;
}
.fade-leave {
  /* opacity: 1; */
}
.fade-leave-active {
  transition: opacity 1s;
  opacity: 0;
}
</style>
