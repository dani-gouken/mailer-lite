<template>
  <button :disabled="isLoading" type="submit" class="btn btn-primary">
    <span v-if="isLoading">
      <span
        class="spinner-border spinner-border-sm"
        role="status"
        aria-hidden="true"
      ></span>
      Please wait...
    </span>
    <span v-else>
      <slot> Submit </slot>
    </span>
  </button>
</template>
<script setup>
import { defineProps } from "vue";
const { isLoading } = defineProps({
  isLoading: {
    type: Boolean,
    default: false,
  },
});
</script>