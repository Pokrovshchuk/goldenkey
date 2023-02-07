<template>
  <div class="guest__timer">
    {{ timeLeftString }}
  </div>
</template>
<script>
export default {
  props: {
    timer: {
      type: Boolean,
      default: true,
    },
    timeTo: {
      type: String,
      default: '',
    },
    timeLeftString: {
      type: String,
      default: '00:00:00',
    },
  },
}
</script>
