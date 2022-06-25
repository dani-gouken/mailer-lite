<template>
  <form @submit.prevent="onSubmit">
    <Alert :message="errorMessage" />
    <div class="mb-3">
      <label class="form-label">Title</label>
      <div class="input-group has-validation">
        <input
          v-model="model.title"
          type="text"
          required
          :class="{ 'is-invalid': validationErrors.title }"
          class="form-control"
          id="cs-title"
          placeholder="Enter title"
        />
        <div
          id="cs-title-err"
          v-for="e in validationErrors.title"
          :key="e"
          class="invalid-feedback"
        >
          {{ e }}
        </div>
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Type</label>
      <select
        :class="{ 'is-invalid': validationErrors.type }"
        v-model="model.type"
        name="type"
        class="form-select"
        required
        id="cs-state"
        aria-label="Select state"
      >
        <option disabled selected>Select type</option>
        <option
          v-for="fieldType in fieldTypes"
          :value="fieldType"
          :key="fieldType"
        >
          {{ fieldType }}
        </option>
      </select>
      <div
        :key="e"
        id="cs-state-err"
        v-for="e in validationErrors.type"
        class="invalid-feedback"
      >
        {{ e }}
      </div>
    </div>
    <SubmitButton :isLoading="isLoading" />
  </form>
</template>

<script setup>
import { defineProps } from "vue";
import SubmitButton from "../../shared/SubmitButton.vue";
import Alert from "../../shared/Alert.vue";
import { fieldTypes } from "../../constants";

const emit = defineEmits(["submit"]);
const onSubmit = () => {
  emit("submit", model);
};
const { model, isLoading, validationErrors, errorMessage } = defineProps({
  errorMessage: String,
  validationErrors: {
    type: Object,
    default: {},
  },
  isLoading: Boolean,
  model: {
    required: true,
    type: Object,
  },
});
</script>