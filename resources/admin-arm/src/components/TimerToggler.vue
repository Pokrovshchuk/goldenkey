<template>
  <label
    class="certificate__label"
    :class="{
      'certificate__label--active': timer,
      'guest__timer-toggler': isGuest,
    }"
    for="timer-checkbox"
    >Таймер
    <input
      type="checkbox"
      name="timer"
      id="timer-checkbox"
      :checked="timer"
      @change="toggleTimer"
    />
  </label>
</template>
<script>
export default {
  props: {
    isGuest: {
      type: Boolean,
      default: true,
    },
    timer: {
      type: Boolean,
      default: true,
    },
    toggleTimer: {
      type: Function,
      default: () => {},
    },
  },
}
</script>
