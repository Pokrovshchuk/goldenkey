<template>
  <svg :class="className" :width="width" :height="height">
    <use :xlink:href="'/img/sprite.svg#' + name"></use>
  </svg>
</template>
<script>
export default {
  props: {
    className: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    width: {
      type: [String, Number],
      default: '24',
    },
    height: {
      type: [String, Number],
      default: '24',
    },
  },
}
</script>
