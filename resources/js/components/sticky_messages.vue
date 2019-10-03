<template>
  <div class="toast-holder">
    <b-alert
      :show="dismissCountDown"
      dismissible
      fade
      variant="warning"
      @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged"
    >{{message}}</b-alert>
  </div>
</template>

<script>
export default {
  props: ["message", "dismiss_time"],
  data() {
    return {
      dismissSecs: 4,
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
    messageVue.$on("showAlert", this.showAlert);
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
  opacity: 1;
}
.fade-leave-active {
  transition: opacity 1s;
  opacity: 0;
}
</style>
