<template>
  <div
    v-if="message && message.length !== 0"
    class="alert alert-danger"
    role="alert"
  >
    {{ message }}
  </div>
</template>

<script setup>
import { defineProps } from "vue";
const { message } = defineProps({
  message: {
    type: String,
    default: "",
  },
});
</script>